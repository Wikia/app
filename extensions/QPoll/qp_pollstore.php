<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/* poll's single question data object RAM storage
 * ( instances usually have short name qdata or quesdata )
 */
class qp_QuestionData {

	// DB index (with current scheme is non-unique)
	var $question_id = null;
	// common properties
	var $type;
	var $CommonQuestion;
	var $Categories;
	var $CategorySpans;
	var $ProposalText;
	var $ProposalCategoryId;
	var $ProposalCategoryText;
	var $alreadyVoted = false; // whether the selected user already voted this question ?
	// statistics storage
	var $Votes = null;
	var $Percents = null;

	function __construct( $argv ) {
		if ( array_key_exists( 'from', $argv ) ) {
			switch ( $argv[ 'from' ] ) {
				case 'postdata' :
						$this->type = $argv[ 'type' ];
						$this->CommonQuestion = $argv[ 'common_question' ];
						$this->Categories = $argv[ 'categories' ];
						$this->CategorySpans = $argv[ 'category_spans' ];
						$this->ProposalText = $argv[ 'proposal_text' ];
						$this->ProposalCategoryId = $argv[ 'proposal_category_id' ];
						$this->ProposalCategoryText = $argv[ 'proposal_category_text' ];
					break;
				case 'qid' :
						$this->question_id = $argv[ 'qid' ];
						$this->type = $argv[ 'type' ];
						$this->CommonQuestion = $argv[ 'common_question' ];
						$this->Categories = Array();
						$this->CategorySpans = Array();
						$this->ProposalText = Array();
						$this->ProposalCategoryId = Array();
						$this->ProposalCategoryText = Array();
					break;
			}
		}
	}

	// integrate spans into categories
	function packSpans() {
		if ( count( $this->CategorySpans ) > 0 ) {
			foreach ( $this->Categories as &$Cat ) {
				if ( array_key_exists( 'spanId', $Cat ) ) {
					$Cat['name'] = $this->CategorySpans[ $Cat['spanId'] ]['name'] . "\n" . $Cat['name'];
					unset( $Cat['spanId'] );
				}
			}
			unset( $this->CategorySpans );
			$this->CategorySpans = Array();
		}
	}

	// restore spans from categories
	function restoreSpans() {
		if ( count( $this->CategorySpans ) == 0 ) {
			$prevSpanName = '';
			$spanId = -1;
			foreach ( $this->Categories as &$Cat ) {
				$a = explode( "\n", $Cat['name'] );
				if ( count( $a ) > 1 ) {
					if ( $prevSpanName != $a[0] ) {
						$spanId++;
						$prevSpanName = $a[0];
						$this->CategorySpans[ $spanId ]['count'] = 0;
					}
					$Cat['name'] = $a[1];
					$Cat['spanId'] = $spanId;
					$this->CategorySpans[ $spanId ]['name'] = $a[0];
					$this->CategorySpans[ $spanId ]['count']++;
				} else {
					$prevSpanName = '';
				}
			}
		}
	}

	// check whether the previousely stored poll header is compatible with the one defined on the page
	// used to reject previous vote in case the header is incompatble
	function isCompatible( &$question ) {
		if ( $question->mType != $this->type ) {
			return false;
		}
		if ( count( $question->mCategorySpans ) != count( $this->CategorySpans ) ) {
			return false;
		}
		foreach ( $question->mCategorySpans as $spanidx => &$span ) {
			if ( !isset( $this->CategorySpans[ $spanidx ] ) ||
					$span[ "count" ] != $this->CategorySpans[ $spanidx ][ "count" ] ) {
				return false;
			}
		}
		return true;
	}

}

/* poll storage and retrieval using DB
 * one poll may contain several questions
 */
class qp_PollStore {

	static $db = null;
	// DB keys
	var $pid = null;
	var $last_uid = null;
	// common properties
	var $mArticleId = null;
	var $mPollId = null; // unique id of poll, used for addressing, also with 'qp_' prefix as the fragment part of the link
	var $mOrderId = null; // order of poll on the page
	var $dependsOn = null; // dependance from other poll address in the following format: "page#otherpollid"
	var $Questions = null; // array of QuestionData instances (data from/to DB)
	var $mCompletedPostData;
	var $voteDone = false;

 /* $argv[ 'from' ] indicates type of construction, other elements of $argv vary according to 'from'
  */
	function __construct( $argv = null ) {
		global $wgParser;
		if ( self::$db == null ) {
			self::$db = & wfGetDB( DB_SLAVE );
		}
		if ( is_array( $argv ) && array_key_exists( "from", $argv ) ) {
			$this->Questions = Array();
			$this->mCompletedPostData = 'NA';
			$this->pid = null;
			$is_post = false;
			switch ( $argv[ 'from' ] ) {
				case 'poll_post' :
					$is_post = true;
				case 'poll_get' :
					if ( array_key_exists( 'title', $argv ) ) {
						$title = $argv[ 'title' ];
					} else {
						$title = $wgParser->getTitle();
					}
					$this->mArticleId = $title->getArticleID();
					$this->mPollId = $argv[ 'poll_id' ];
					if ( array_key_exists( 'order_id', $argv ) ) {
						$this->mOrderId = $argv[ 'order_id' ];
					}
					if ( array_key_exists( 'dependance', $argv ) &&
							$argv[ 'dependance' ] !== false ) {
						$this->dependsOn = $argv[ 'dependance' ];
					}
					if ( $is_post ) {
						$this->setPid();
					} else {
						$this->loadPid();
					}
					break;
				case 'pid' :
					if ( array_key_exists( 'pid', $argv ) ) {
						$pid = intval( $argv[ 'pid' ] );
						$res = self::$db->select( 'qp_poll_desc',
							array( 'article_id', 'poll_id', 'order_id', 'dependance' ),
							array( 'pid' => $pid ),
							__METHOD__ . ":create from pid" );
						$row = self::$db->fetchObject( $res );
						if ( $row != false ) {
							$this->pid = $pid;
							$this->mArticleId = $row->article_id;
							$this->mPollId = $row->poll_id;
							$this->mOrderId = $row->order_id;
							$this->dependsOn = $row->dependance;
						}
					}
					break;
			}
		}
	}

	// special version of constructor that builds pollstore from the given poll address
	// @return    instance of qp_PollStore on success, false on error
	static function newFromAddr( $pollAddr ) {
		# build poll object from given poll address in args[0]
		$pollAddr = qp_AbstractPoll::getPrefixedPollAddress( $pollAddr );
		if ( is_array( $pollAddr ) ) {
			list( $pollTitleStr, $pollId ) = $pollAddr;
			$pollTitle = Title::newFromURL( $pollTitleStr );
			if ( $pollTitle !== null ) {
				$pollArticleId = intval( $pollTitle->getArticleID() );
				if ( $pollArticleId > 0 ) {
					return new qp_PollStore( array(
						'from' => 'poll_get',
						'title' => $pollTitle,
						'poll_id' => $pollId ) );
				} else {
					return QP_ERROR_MISSED_TITLE;
				}
			} else {
				return QP_ERROR_MISSED_TITLE;
			}
		} else {
			return QP_ERROR_INVALID_ADDRESS;
		}
	}

	function getPollId() {
		return $this->mPollId;
	}

	# returns Title object, to get a URI path, use Title::getFullText()/getPrefixedText() on it
	function getTitle() {
		$res = null;
		if ( $this->mArticleId !== null && $this->mPollId !== null ) {
			$res = Title::newFromID( $this->mArticleId );
			$res->setFragment( qp_AbstractPoll::getPollTitleFragment( $this->mPollId ) );
		}
		return $res;
	}

	// warning: will work only after successful loadUserAlreadyVoted() or loadUserVote()
	function isAlreadyVoted() {
		if ( is_array( $this->Questions ) && count( $this->Questions > 0 ) ) {
			foreach ( $this->Questions as &$qdata ) {
				if ( $qdata->alreadyVoted )
					return true;
			}
		}
		return false;
	}

	# checks whether the question with specified id exists in the poll store
	# @return   boolean, true when the question exists
	function questionExists( $question_id ) {
		return array_key_exists( $question_id, $this->Questions );
	}

	# load questions for the newly created poll (if the poll was voted at least once)
	# @return   boolean, true when the questions are available, false otherwise (poll was never voted)
	function loadQuestions() {
		$result = false;
		$typeFromVer0_5 = array(
			"singleChoicePoll" => "singleChoice",
			"multipleChoicePoll" => "multipleChoice",
			"mixedChoicePoll" => "mixedChoice"
		);
		if ( $this->pid !== null ) {
			$res = self::$db->select( 'qp_question_desc',
				array( 'question_id', 'type', 'common_question' ),
				array( 'pid' => $this->pid ),
				__METHOD__ );
			if ( self::$db->numRows( $res ) > 0 ) {
				$result = true;
				while ( $row = self::$db->fetchObject( $res ) ) {
					$question_id = intval( $row->question_id );
					# convert old (v0.5) question type string to the "new" type string
					if ( isset( $typeFromVer0_5[$row->type] ) ) {
						$row->type = $typeFromVer0_5[$row->type];
					}
					# create a qp_QuestionData object from DB fields
					$this->Questions[ $question_id ] = new qp_QuestionData( array(
						'from' => 'qid',
						'qid' => $question_id,
						'type' => $row->type,
						'common_question' => $row->common_question ) );
				}
				$this->getCategories();
				$this->getProposalText();
			}
		}
		return $result;
	}

	// checks whether single user already voted the poll's questions
	// will be written into self::Questions[]->alreadyVoted
	// may be used only after loadQuestions()
	// returns true when the user voted to any of the currently defined questions, false otherwise
	function loadUserAlreadyVoted() {
		$result = false;
		if ( $this->pid === null || $this->last_uid === null ||
				!is_array( $this->Questions ) || count( $this->Questions ) == 0 ) {
			return false;
		}
		$res = self::$db->select( 'qp_question_answers',
			array( 'DISTINCT question_id' ),
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':load one user poll questions alreadyVoted values' );
		if ( self::$db->numRows( $res ) == 0 ) {
			return false;
		}
		while ( $row = self::$db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			if ( $this->questionExists( $question_id ) ) {
				$result = $this->Questions[ $question_id ]->alreadyVoted = true;
			}
		}
		return $result;
	}

	// load single user vote
	// will be written into self::Questions[]->ProposalCategoryId,ProposalCategoryText,alreadyVoted
	// may be used only after loadQuestions()
	// returns true when any of currently defined questions has the votes, false otherwise
	function loadUserVote() {
		$result = false;
		if ( $this->pid === null || $this->last_uid === null ||
				!is_array( $this->Questions ) || count( $this->Questions ) == 0 ) {
			return false;
		}
		$res = self::$db->select( 'qp_question_answers',
			array( 'question_id', 'proposal_id', 'cat_id', 'text_answer' ),
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':load one user single poll vote' );
		if ( self::$db->numRows( $res ) == 0 ) {
			return false;
		}
		while ( $row = self::$db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			if ( $this->questionExists( $question_id ) ) {
				$qdata = &$this->Questions[ $question_id ];
				$result = $qdata->alreadyVoted = true;
				$qdata->ProposalCategoryId[ intval( $row->proposal_id ) ][] = intval( $row->cat_id );
				$qdata->ProposalCategoryText[ intval( $row->proposal_id ) ][] = $row->text_answer;
			}
		}
		return $result;
	}

	// load voting statistics (totals) from DB
	// input: $questions_set is optional array of integer question_id values of the current poll
	// output: $this->Questions[]Votes[] is set on success
	function loadTotals( $questions_set = false ) {
		if ( $this->pid !== null &&
				is_array( $this->Questions ) && count( $this->Questions > 0 ) ) {
			$where = 'pid=' . self::$db->addQuotes( $this->pid );
			if ( is_array( $questions_set ) ) {
				$where .= ' AND question_id IN (';
				$first_elem = true;
				foreach ( $questions_set as &$qid ) {
					if ( $first_elem ) {
						$first_elem = false;
					} else {
						$where .= ',';
					}
					$where .= self::$db->addQuotes( $qid );
				}
				$where .= ')';
			}
			$res = self::$db->select( 'qp_question_answers',
				array( 'count(uid)', 'question_id', 'proposal_id', 'cat_id' ),
				$where,
				__METHOD__ . ':load single poll count of user votes',
				array( 'GROUP BY' => 'question_id,proposal_id,cat_id' ) );
			while ( $row = self::$db->fetchRow( $res ) ) {
				$question_id = intval( $row[ "question_id" ] );
				$propkey = intval( $row[ "proposal_id" ] );
				$catkey = intval( $row[ "cat_id" ] );
				if ( $this->questionExists( $question_id ) ) {
					$qdata = &$this->Questions[ $question_id ];
					if ( !is_array( $qdata->Votes ) ) {
						$qdata->Votes = Array();
					}
					if ( !array_key_exists( $propkey, $qdata->Votes ) ) {
						$qdata->Votes[ $propkey ] = array_fill( 0, count( $qdata->Categories ), 0 );
					}
					$qdata->Votes[ $propkey ][ $catkey ] = intval( $row[ "count(uid)" ] );
				}
			}
		}
	}

	function totalUsersAnsweredQuestion( &$qdata ) {
		$result = 0;
		if ( $this->pid !== null ) {
			$res = self::$db->select( 'qp_question_answers',
				array( 'count(distinct uid)' ),
				array( 'pid' => $this->pid, 'question_id' => $qdata->question_id ),
				__METHOD__ );
			if ( $row = self::$db->fetchRow( $res ) ) {
				$result = intval( $row[ "count(distinct uid)" ] );
			}
		}
		return $result;
	}

	// try to calculate percents for every question where Votes[] are available
	function calculateStatistics() {
		foreach ( $this->Questions as &$qdata ) {
			$this->calculateQuestionStatistics( $qdata );
		}
	}

	// try to calculate percents for the one question
	private function calculateQuestionStatistics( &$qdata ) {
		if ( isset( $qdata->Votes ) ) { // is "votable"
			$qdata->restoreSpans();
			$spansUsed = count( $qdata->CategorySpans ) > 0 ;
			foreach ( $qdata->ProposalText as $propkey => $proposal_text ) {
				if ( isset( $qdata->Votes[ $propkey ] ) ) {
					$votes_row = &$qdata->Votes[ $propkey ];
					if ( $qdata->type == "singleChoice" ) {
						if ( $spansUsed ) {
							$row_totals = array_fill( 0, count( $qdata->CategorySpans ), 0 );
						} else {
							$votes_total = 0;
						}
						foreach ( $qdata->Categories as $catkey => $cat ) {
							if ( isset( $votes_row[ $catkey ] ) ) {
								if ( $spansUsed ) {
									$row_totals[ intval( $cat[ "spanId" ] ) ] += $votes_row[ $catkey ];
								} else {
									$votes_total += $votes_row[ $catkey ];
								}
							}
						}
					} else {
						$votes_total = $this->totalUsersAnsweredQuestion( $qdata );
					}
					foreach ( $qdata->Categories as $catkey => $cat ) {
						$num_of_votes = '';
						if ( isset( $votes_row[ $catkey ] ) ) {
							$num_of_votes = $votes_row[ $catkey ];
							if ( $spansUsed ) {
								if ( isset( $qdata->Categories[ $catkey ][ "spanId" ] ) ) {
									$votes_total = $row_totals[ intval( $qdata->Categories[ $catkey ][ "spanId" ] ) ];
								}
							}
						}
						$qdata->Percents[ $propkey ][ $catkey ] = ( $votes_total > 0 ) ? (float) $num_of_votes / (float) $votes_total : 0.0;
					}
				}
			}
		}
	}

	private function getCategories() {
		$res = self::$db->select( 'qp_question_categories',
				array( 'question_id', 'cat_id', 'cat_name' ),
				array( 'pid' => $this->pid ),
				__METHOD__ );
		while ( $row = self::$db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			$cat_id = intval( $row->cat_id );
			if ( $this->questionExists( $question_id ) ) {
				$qdata = &$this->Questions[ $question_id ];
				$qdata->Categories[ $cat_id ][ "name" ] = $row->cat_name;
			}
		}
		foreach ( $this->Questions as &$qdata ) {
			$qdata->restoreSpans();
		}
	}

	private function getProposalText() {
		$res = self::$db->select( 'qp_question_proposals',
			array( 'question_id', 'proposal_id', 'proposal_text' ),
			array( 'pid' => $this->pid ),
				__METHOD__ );
		while ( $row = self::$db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			$proposal_id = intval( $row->proposal_id );
			if ( $this->questionExists( $question_id ) ) {
				$qdata = &$this->Questions[ $question_id ];
				$qdata->ProposalText[ $proposal_id ] = $row->proposal_text;
			}
		}
	}

	function getState() {
		return $this->mCompletedPostData;
	}

	function stateIncomplete() {
		if ( $this->mCompletedPostData == 'NA' ) {
			$this->mCompletedPostData = 'incomplete';
		}
	}

	function stateError() {
		$this->mCompletedPostData = 'error';
	}

	# check whether the poll was successfully submitted
	# @return   boolean - result of operation
	function stateComplete() {
		# completed only when previous state was unavaibale; error state can't be completed
		if ( $this->mCompletedPostData == 'NA'  && count( $this->Questions ) > 0 ) {
			$this->mCompletedPostData = 'complete';
			return true;
		} else {
			return false;
		}
	}

	function setLastUser( $username, $store_new_user_to_db = true ) {
		if ( $this->pid !== null ) {
			$res = self::$db->select( 'qp_users', 'uid', 'name=' . self::$db->addQuotes( $username ), __METHOD__ );
			$row = self::$db->fetchObject( $res );
			if ( $row == false ) {
				if ( $store_new_user_to_db ) {
					self::$db->insert( 'qp_users', array( 'name' => $username ), __METHOD__ . ':UpdateUser' );
					$this->last_uid = self::$db->insertId();
				} else {
					$this->last_uid = null;
				}
			} else {
				$this->last_uid = $row->uid;
			}
		}
//	todo: change to "insert ... on duplicate key update ..." when last_insert_id() bugs will be fixed
	}

	function getUserName( $uid ) {
		if ( $uid !== null ) {
			$res = self::$db->select( 'qp_users', 'name', 'uid=' . self::$db->addQuotes( intval( $uid ) ), __METHOD__ );
			$row = self::$db->fetchObject( $res );
			if ( $row != false ) {
				return $row->name;
			}
		}
		return false;
	}

	private function loadPid() {
		$res = self::$db->select( 'qp_poll_desc',
			array( 'pid', 'order_id', 'dependance' ),
			'article_id=' . self::$db->addQuotes( $this->mArticleId ) . ' and ' .
			'poll_id=' . self::$db->addQuotes( $this->mPollId ),
			__METHOD__ );
		$row = self::$db->fetchObject( $res );
		if ( $row != false ) {
			$this->pid = $row->pid;
			# some constructors don't supply the poll attributes, get the values from DB in such case
			if ( $this->mOrderId === null ) {
				$this->mOrderId = $row->order_id;
			}
			if ( $this->dependsOn === null ) {
				$this->dependsOn = $row->dependance;
			}
			$this->updatePollAttributes( $row );
		}
	}

	private function setPid() {
		$res = self::$db->select( 'qp_poll_desc',
			array( 'pid', 'order_id', 'dependance' ),
			'article_id=' . self::$db->addQuotes( $this->mArticleId ) . ' and ' .
			'poll_id=' . self::$db->addQuotes( $this->mPollId ) );
		$row = self::$db->fetchObject( $res );
		if ( $row == false ) {
			self::$db->insert( 'qp_poll_desc',
				array( 'article_id' => $this->mArticleId, 'poll_id' => $this->mPollId, 'order_id' => $this->mOrderId, 'dependance' => $this->dependsOn ),
				__METHOD__ . ':update poll' );
			$this->pid = self::$db->insertId();
		} else {
			$this->pid = $row->pid;
			$this->updatePollAttributes( $row );
		}
//	todo: change to "insert ... on duplicate key update ..." when last_insert_id() bugs will be fixed
	}

	private function updatePollAttributes( $row ) {
		if ( $this->mOrderId != $row->order_id || $this->dependsOn != $row->dependance ) {
			$res = self::$db->replace( 'qp_poll_desc',
				'',
				array( 'pid' => $this->pid, 'article_id' => $this->mArticleId, 'poll_id' => $this->mPollId, 'order_id' => $this->mOrderId, 'dependance' => $this->dependsOn ),
				__METHOD__ . ':poll attributes update'
			);
		}
	}

	private function setQuestionDesc() {
		$insert = array();
		foreach ( $this->Questions as $qkey => &$ques ) {
			$insert[] = array( 'pid' => $this->pid, 'question_id' => $qkey, 'type' => $ques->type, 'common_question' => $ques->CommonQuestion );
			$ques->question_id = $qkey;
		}
		if ( count( $insert ) > 0 ) {
			self::$db->replace( 'qp_question_desc',
				'',
				$insert,
				__METHOD__ );
		}
	}

	private function setCategories() {
		$insert = Array();
		foreach ( $this->Questions as $qkey => &$ques ) {
			$ques->packSpans();
			foreach ( $ques->Categories as $catkey => &$Cat ) {
				$insert[] = array( 'pid' => $this->pid, 'question_id' => $qkey, 'cat_id' => $catkey, 'cat_name' => $Cat["name"] );
			}
			$ques->restoreSpans();
		}
		if ( count( $insert ) > 0 ) {
			self::$db->replace( 'qp_question_categories',
				'',
				$insert,
				__METHOD__ );
		}
	}

	private function setProposals() {
		$insert = Array();
		foreach ( $this->Questions as $qkey => &$ques ) {
			foreach ( $ques->ProposalText as $propkey => &$ptext ) {
				$insert[] = array( 'pid' => $this->pid, 'question_id' => $qkey, 'proposal_id' => $propkey, 'proposal_text' => $ptext );
			}
		}
		if ( count( $insert ) > 0 ) {
			self::$db->replace( 'qp_question_proposals',
				'',
				$insert,
				__METHOD__ );
		}
	}

	// warning: requires qp_PollStorage::last_uid to be set
	private function setAnswers() {
		$insert = Array();
		foreach ( $this->Questions as $qkey => &$ques ) {
			foreach ( $ques->ProposalCategoryId as $propkey => &$prop_answers ) {
				foreach ( $prop_answers as $idkey => $catkey ) {
					$insert[] = array( 'uid' => $this->last_uid, 'pid' => $this->pid, 'question_id' => $qkey, 'proposal_id' => $propkey, 'cat_id' => $catkey, 'text_answer' => $ques->ProposalCategoryText[ $propkey ][ $idkey ] );
				}
			}
		}
		# TODO: delete votes of all users, when the POST question header is incompatible with question header in DB ?
		# delete previous vote to make sure previous header of this poll was not incompatible with current vote
		self::$db->delete( 'qp_question_answers',
			array( 'uid' => $this->last_uid, 'pid' => $this->pid ),
			__METHOD__ . ':delete previous answers of current user to the same poll'
		);
		# vote
		$old_user_abort = ignore_user_abort( true );
		if ( count( $insert ) > 0 ) {
			self::$db->replace( 'qp_question_answers',
				'',
				$insert,
				__METHOD__ );
			self::$db->replace( 'qp_users_polls',
				'',
				array( 'uid' => $this->last_uid, 'pid' => $this->pid ),
				__METHOD__ );
		}
		ignore_user_abort( $old_user_abort );
	}

	# when the user votes and poll wasn't previousely voted yet, it also creates the poll in DB
	function setUserVote() {
		if ( $this->pid !== null &&
				$this->last_uid !== null &&
				$this->mCompletedPostData == "complete" &&
				is_array( $this->Questions ) && count( $this->Questions ) > 0 ) {
			$old_user_abort = ignore_user_abort( true );
			$this->setQuestionDesc();
			$this->setCategories();
			$this->setProposals();
			$this->setAnswers();
			ignore_user_abort( $old_user_abort );
			$this->voteDone = true;
		}
	}

}
