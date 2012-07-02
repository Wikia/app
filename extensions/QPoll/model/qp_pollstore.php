<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Poll storage and retrieval using DB
 * one poll may contain several questions
 *
 * Currently, DB_SLAVE is used for reading user answers (from `qp_question_answers`)
 * and for pager methods (statistical export). Everything else should use DB_MASTER
 * to prevent possible inconsistence due to slave lag.
 */
class qp_PollStore {

	## DB keys
	var $pid = null;
	var $last_uid = null;

	# username is used for caching $this->setLastUser() method
	# (which now may be called multiple times);
	# also used by randomizer
	# For anonymous users it might be different from MediaWiki username,
	# because anonymous users can vote in qpoll.
	var $username = '';

	/*** common properties ***/
	# article_id of wiki page where the poll is located
	var $mArticleId = null;
	# unique id (text label) of poll, used for addressing,
	# also with 'qp_' prefix as the fragment part of the http link
	# that leads to the poll definition
	var $mPollId = null;
	# order of definition of the poll in the source of the wiki page
	var $mOrderId = null;

	/*** optional attributes ***/
	# dependance from other poll address in the following format: "page#otherpollid"
	var $dependsOn = null;
	## NS of Title object representing interpretation template
	var $interpNS = 0;
	## DBkey of Title object representing interpretation template
	# '' indicates that interpretation template does not exists (a poll without quiz)
	# null indicates that value is unknown (uninitialized yet)
	var $interpDBkey = null;
	# interpretation of user answer (instance of qp_InterpResult)
	var $interpResult;
	# 1..n - number of random indexes from poll's header; 0 - poll questions are not randomized
	# pollstore loads / saves random indexes for every user only when this property is NOT zero
	# which improves performance of non-randomized polls
	var $randomQuestionCount = null;

	# array of qp_QuestionData instances (question data convertation from / to DB)
	var $Questions = null;
	# array of random indexes of Questions[] array (optional)
	var $randomQuestions = false;

	# attempts of voting (passing the quiz). number of resubmits
	# note: resubmits are counted for syntax-correct answer (when the vote is stored),
	# yet the answer still might be logically incorrect (quiz is not passed / partially passed)
	# that depends on the value $this->interpResult->storeErroneous
	var $attempts = 0;

	# poll processing state, read with getState()
	#
	# 'NA' - object just was created
	#
	# 'incomplete', self::stateIncomplete()
	#    http post: not every proposals were answered: do not update DB
	#    http get: this is not the post: do not update DB
	#
	# 'error', self::stateError()
	#    http get: invalid question syntax, parse errors will cause submit button disabled
	#
	# 'complete', self::stateComplete()
	#    check whether the poll was successfully submitted
	#    store user vote to the DB (when the poll is fine)
	#
	var $mCompletedPostData;
	# true, after the poll results have been successfully stored to DB
	var $voteDone = false;

	/**
	 * Poll store multi-purpose constructor.
	 * @param $argv['from'] indicates type of construction, other elements of $argv
	 *          vary according to the value of 'from'
	 */
	function __construct( array $argv ) {
		$this->interpResult = new qp_InterpResult();
		# set poll store of poll descriptions cache and all it's ancestors
		qp_PollCache::setStore( $this );
		$from = 'null';
		if ( array_key_exists( 'from', $argv ) ) {
			$from = $argv['from'];
			$this->Questions = array();
			$this->mCompletedPostData = 'NA';
			$this->pid = null;
			$is_post = false;
			switch ( $from ) {
			case 'poll_post' :
				$is_post = true;
			case 'poll_get' :
				$this->createFromTagData( $argv, $is_post );
				return;
			case 'pid' :
				if ( array_key_exists( 'pid', $argv ) ) {
					$pid = intval( $argv[ 'pid' ] );
					$this->createFromPid( $pid );
				}
				return;
			}
		}
		throw new MWException( 'Unknown value of "from" parameter: ' . $from . ' in ' . __METHOD__ );
	}

	/**
	 * Creates new poll from data available in qpoll tag attributes.
	 * Usually that is HTTP GET / POST operation.
	 */
	function createFromTagData( array &$argv, $is_post ) {
		global $wgParser;
		if ( array_key_exists( 'title', $argv ) ) {
			$title = $argv[ 'title' ];
		} else {
			$title = $wgParser->getTitle();
		}
		$this->mArticleId = $title->getArticleID();
		if ( !isset( $argv['poll_id'] ) ) {
			throw new MWException( 'Parameter "from" = poll_get / poll_post requires parameter "poll_id" in ' . __METHOD__ );
		}
		$this->mPollId = $argv[ 'poll_id' ];
		if ( array_key_exists( 'order_id', $argv ) ) {
			$this->mOrderId = $argv[ 'order_id' ];
		}
		if ( array_key_exists( 'dependance', $argv ) &&
				$argv[ 'dependance' ] !== false ) {
			$this->dependsOn = $argv[ 'dependance' ];
		}
		if ( array_key_exists( 'interpretation', $argv ) ) {
			# (0,'') indicates that interpretation template does not exists
			$this->interpNS = 0;
			$this->interpDBkey = '';
			if ( $argv['interpretation'] != '' ) {
				$interp = Title::newFromText( $argv['interpretation'], NS_QP_INTERPRETATION );
				if ( $interp instanceof Title ) {
					$this->interpNS = $interp->getNamespace();
					$this->interpDBkey = $interp->getDBkey();
				}
			}
		}
		if ( array_key_exists( 'randomQuestionCount', $argv ) ) {
			$this->randomQuestionCount = $argv['randomQuestionCount'];
		}
		# do not load / create the poll when article id is unavailable
		# (during newly created page submission)
		if ( $this->mArticleId != 0 ) {
			if ( $is_post ) {
				# load or create poll description
				$this->setPid();
			} else {
				# try to load poll description
				$this->loadPid();
				if ( is_null( $this->pid ) &&
						$this->pollDescIsValid() &&
						$this->randomQuestionCount > 0 ) {
					# Randomized polls are required to create their descriptions,
					# because questions random seed is generated at
					# the first user's GET, not at the poll POST.
					$this->setPid();
				}
			}
		}
	}

	/**
	 * Creates new poll store from DB pid specified.
	 * That is usual way of loading polls from Special:Pollresults page.
	 */
	private function createFromPid( $pid ) {
		# We do not need to cache qp_poll_desc by pid here, because
		# polls are created from pid only in Special:Pollresults page,
		# which usually has low load.
		# However, we have to update poll description cache to keep it's
		# state coherent.
		$db = wfGetDB( DB_MASTER );
		$res = $db->select( 'qp_poll_desc',
			array( 'article_id', 'poll_id', 'order_id', 'dependance', 'interpretation_namespace', 'interpretation_title', 'random_question_count' ),
			array( 'pid' => $pid ),
			__METHOD__ . ":create from pid" );
		$row = $db->fetchObject( $res );
		if ( $row === false ) {
			throw new MWException( 'Attempt to create poll from non-existent pid in ' . __METHOD__ );
		}
		# set the whole set of poll description properties
		# note: it is very important to apply correct type conversation,
		# when populating the data from DB rows
		$this->pid = $pid;
		$this->mArticleId = intval( $row->article_id );
		$this->mPollId = $row->poll_id;
		$this->mOrderId = intval( $row->order_id );
		$this->dependsOn = $row->dependance;
		$this->interpNS = intval( $row->interpretation_namespace );
		$this->interpDBkey = $row->interpretation_title;
		$this->randomQuestionCount = intval( $row->random_question_count );
		# write current poll description properties into memory cache
		qp_PollCache::store( null, 'qp_PollCache' );
	}

	/**
	 * Special version of constructor that builds pollstore from the poll address given.
	 * It is used in poll dependance checking, parser functions and in statistical mode.
	 * @return    instance of qp_PollStore on success, false on error
	 */
	static function newFromAddr( $pollAddr ) {
		# build poll object from given poll address
		$pollAddr = qp_AbstractPoll::getPrefixedPollAddress( $pollAddr );
		if ( is_array( $pollAddr ) ) {
			list( $pollTitleStr, $pollId ) = $pollAddr;
			$pollTitle = Title::newFromURL( $pollTitleStr );
			if ( $pollTitle instanceof Title ) {
				$pollArticleId = intval( $pollTitle->getArticleID() );
				if ( $pollArticleId > 0 ) {
					return new qp_PollStore( array(
						'from' => 'poll_get',
						'title' => $pollTitle,
						'poll_id' => $pollId ) );
				} else {
					return qp_Setup::ERROR_MISSED_TITLE;
				}
			} else {
				return qp_Setup::ERROR_MISSED_TITLE;
			}
		} else {
			return qp_Setup::ERROR_INVALID_ADDRESS;
		}
	}

	/**
	 * Get string id of current poll
	 * @return  string id of current poll
	 */
	function getPollId() {
		return $this->mPollId;
	}

	/**
	 * @return  boolean  true when the current instance has all of the
	 * properties matched to 'qp_poll_desc' fields initialized with values
	 * taken from $argv[] argument of constructor;
	 *
	 * when this function returns false, $this->setPid() cannot be called;
	 */
	private function pollDescIsValid() {
		# non-checked fields:
		# 'pid' is key (result of insert);
		# 'article_id' is always created by constructor
		# 'poll_id' is mandatory parameter of constructor
		# 'interpretation_namespace' is determined by 'interpretation_title' (dbkey)
		return
			!is_null( $this->mOrderId ) &&
			!is_null( $this->dependsOn ) &&
			!is_null( $this->interpDBkey ) &&
			!is_null ( $this->randomQuestionCount );
	}

	/**
	 * Get full title (with fragment part) of the current poll.
	 * To get an URI path, use Title::getFullText()/getPrefixedText() on it.
	 * @return Title object
	 */
	function getTitle() {
		if ( $this->mArticleId === 0 ) {
			throw new MWException( __METHOD__ . ' cannot be called for unsaved new pages' );
		}
		if ( is_null( $this->mArticleId ) ) {
			throw new MWException( 'Unknown article id in ' . __METHOD__ );
		}
		if ( is_null( $this->mPollId ) ) {
			throw new MWException( 'Unknown poll id in ' . __METHOD__ );
		}
		$res = Title::newFromID( $this->mArticleId );
		if ( !( $res instanceof Title ) ) {
			throw new MWException( 'Cannot create poll title in ' . __METHOD__ );
		}
		$res->setFragment( qp_AbstractPoll::s_getPollTitleFragment( $this->mPollId ) );
		return $res;
	}

	/**
	 * @return mixed Title instance of interpretation template (existing or not)
	 *               false, when no interpretation template is defined in poll header
	 *               null, when the title parts are invalid (error)
	 */
	function getInterpTitle() {
		if ( is_null( $this->interpDBkey ) ) {
			throw new MWException( 'interpDBkey is uninitialized in ' . __METHOD__ );
		}
		if ( $this->interpNS === 0 && $this->interpDBkey === '' ) {
			return false;
		}
		$title = Title::newFromText( $this->interpDBkey, $this->interpNS );
		return ( $title instanceof Title ) ? $title : null;
	}

	/**
	 * Checks, whether current $this->last_uid already voted for current poll,
	 * or not.
	 *
	 * Warning: will work only after successful $this->loadUserAlreadyVoted()
	 * or $this->loadUserVote()
	 *
	 * @return  boolean  true user already voted, false otherwise
	 */
	function isAlreadyVoted() {
		if ( is_array( $this->Questions ) && count( $this->Questions > 0 ) ) {
			foreach ( $this->Questions as $qdata ) {
				if ( $qdata->alreadyVoted )
					return true;
			}
		}
		return false;
	}

	/**
	 * Checks whether the question with specified id exists in the poll store.
	 * @return   boolean, true when the question exists, false otherwise
	 */
	function questionExists( $question_id ) {
		return array_key_exists( $question_id, $this->Questions );
	}

	/**
	 * Loads questions for the newly created poll.
	 * The questions are available only when the poll was voted at least once.
	 * The vote might be an empty submission, usually performed by poll creator
	 * (so-called "poll save").
	 *
	 * @return  boolean, true questions are available, false otherwise (poll was never voted)
	 */
	function loadQuestions() {
		$result = false;
		$typeFromVer0_5 = array(
			"singleChoicePoll" => "singleChoice",
			"multipleChoicePoll" => "multipleChoice",
			"mixedChoicePoll" => "mixedChoice"
		);
		$db = wfGetDB( DB_MASTER );
		if ( $this->pid !== null ) {
			$rows = qp_PollCache::load( $db, 'qp_QuestionCache' );
			if ( count( $rows ) > 0 ) {
				$result = true;
				foreach ( $rows as $row ) {
					$question_id = $row->question_id;
					# convert old (v0.5) question type string to the "new" type string
					if ( isset( $typeFromVer0_5[$row->type] ) ) {
						$row->type = $typeFromVer0_5[$row->type];
					}
					# create qp_QuestionData object from question description DB row
					$this->Questions[$question_id] = qp_QuestionData::factory( array(
						'qid' => $question_id,
						'type' => $row->type,
						'common_question' => $row->common_question,
						'name' => $row->name )
					);
				}
				$this->getCategories();
				$this->getProposalText();
			}
		}
		return $result;
	}

	/**
	 * Populates $this->Questions->Categories with data loaded and
	 * unpacked from DB
	 */
	private function getCategories() {
		$db = wfGetDB( DB_MASTER );
		$rows = qp_PollCache::load( $db, 'qp_CategoryCache' );
		foreach ( $rows as $row ) {
			$question_id = $row->question_id;
			$cat_id = $row->cat_id;
			if ( $this->questionExists( $question_id ) ) {
				$qdata = $this->Questions[ $question_id ];
				$qdata->Categories[$cat_id]['name'] = $row->cat_name;
			}
		}
		foreach ( $this->Questions as $qdata ) {
			$qdata->restoreSpans();
		}
	}

	/**
	 * Populates $this->Questions->ProposalText with data loaded and
	 * unpacked from DB
	 */
	private function getProposalText() {
		$db = wfGetDB( DB_MASTER );
		$rows = qp_PollCache::load( $db, 'qp_ProposalCache' );
		# load proposal text from DB
		$prop_attrs = qp_Setup::$propAttrs;
		foreach ( $rows as $row ) {
			$question_id = $row->question_id;
			$proposal_id = $row->proposal_id;
			if ( $this->questionExists( $question_id ) ) {
				$qdata = $this->Questions[ $question_id ];
				$prop_attrs->getFromDB( $row->proposal_text );
				$qdata->ProposalText[$proposal_id] = $prop_attrs->dbText;
				if ( $prop_attrs->name !== '' ) {
					$qdata->ProposalNames[$proposal_id] = $prop_attrs->name;
				}
			}
		}
	}

	/**
	 * Iterates through the list of users who voted in the current poll
	 * @return  mixed  false on failure,
	 *                 array of ( 'uid'=> 
	 *                   array('username'=>string, 'interpretation'=>instanceof qp_InterpResult)
	 *                 ) on success;
	 * Warning: resulting array might be empty;
	 */
	function pollVotersPager( $offset = 0, $limit = 20 ) {
		if ( $this->pid === null ) {
			return false;
		}
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select(
			array( 'qu' => 'qp_users', 'qup' => 'qp_users_polls' ),
			array( 'qup.uid AS uid', 'name AS username',
			'short_interpretation', 'long_interpretation', 'structured_interpretation' ),
			/* WHERE */ array( 'pid' => $this->pid ),
			__METHOD__,
			array( 'OFFSET' => $offset, 'LIMIT' => $limit ),
			/* JOIN */ array(
			'qu' => array( 'INNER JOIN', 'qup.uid = qu.uid' )
			)
		);
		$result = array();
		while ( $row = $db->fetchObject( $res ) ) {
			$interpResult = new qp_InterpResult();
			$interpResult->short = $row->short_interpretation;
			$interpResult->long = $row->long_interpretation;
			$interpResult->structured = $row->structured_interpretation;
			$result[intval( $row->uid )] = array(
				'username' => $row->username,
				'interpretation' => $interpResult
			);
		}
		return $result;
	}

	/**
	 * Get voices of the selected users in the selected question of current poll
	 * @param  $uids  array of poll user id's in DB
	 * @return mixed  array [uid][proposal_id][cat_id]=text_answer on success,
	 *                false on failure
	 */
	function questionVoicesRange( $question_id, $uids ) {
		if ( $this->pid === null ) {
			return false;
		}
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select(
			'qp_question_answers',
			array( 'uid', 'proposal_id', 'cat_id', 'text_answer' ),
			/* WHERE */ array(
				'pid' => $this->pid,
				'question_id' => $question_id,
				'uid' /* IN */ => $uids
			),
			__METHOD__,
			array( 'ORDER BY' => 'uid' )
		);
		$result = array();
		while ( $row = $db->fetchObject( $res ) ) {
			$uid = intval( $row->uid );
			if ( !isset( $result[$uid] ) ) {
				$result[$uid] = array();
			}
			$proposal_id = intval( $row->proposal_id );
			if ( !isset( $result[$uid][$proposal_id] ) ) {
				$result[$uid][$proposal_id] = array();
			}
			$result[$uid][$proposal_id][intval( $row->cat_id )] = ( ( $row->text_answer == '' ) ? qp_Setup::$resultsCheckCode : $row->text_answer );
		}
		return $result;
	}

	/**
	 * @return boolean
	 *   true  current poll has at least one question loaded (defined)
	 *   false otherwise
	 */
	function hasQuestions() {
		return
			$this->pid !== null &&
			is_array( $this->Questions ) &&
			count( $this->Questions ) > 0;
	}

	/**
	 * Checks whether single user already voted to the poll's questions.
	 * Results will be written into self::Questions[]->alreadyVoted properties.
	 * Warning: may be used only after calling $this->loadQuestions()
	 * @return  boolean:
	 *   true when the user voted to any of the currently defined questions,
	 *   false otherwise
	 */
	function loadUserAlreadyVoted() {
		$result = false;
		if ( !$this->hasQuestions() ||
				$this->last_uid === null ) {
			return false;
		}
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( 'qp_question_answers',
			array( 'DISTINCT question_id' ),
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':load one user poll questions alreadyVoted values' );
		if ( $db->numRows( $res ) == 0 ) {
			return false;
		}
		while ( $row = $db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			if ( $this->questionExists( $question_id ) ) {
				$result = $this->Questions[ $question_id ]->alreadyVoted = true;
			}
		}
		return $result;
	}

	/**
	 * Load single user vote.
	 * Also loads answer interpretations, when available.
	 * Will populate:
	 * self::Questions[]->ProposalCategoryId,
	 * self::Questions[]->ProposalCategoryText,
	 * self::Questions[]->alreadyVoted;
	 * Warning: May be used only after calling $this->loadQuestions()
	 * @return boolean:
	 *   true when at least one of currently defined questions were voted,
	 *   false otherwise
	 */
	function loadUserVote() {
		$result = false;
		if ( !$this->hasQuestions() ||
				$this->last_uid === null ) {
			return false;
		}
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( 'qp_question_answers',
			array( 'question_id', 'proposal_id', 'cat_id', 'text_answer' ),
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':load one user single poll vote' );
		if ( $db->numRows( $res ) == 0 ) {
			return false;
		}
		while ( $row = $db->fetchObject( $res ) ) {
			$question_id = intval( $row->question_id );
			if ( $this->questionExists( $question_id ) ) {
				$qdata = $this->Questions[$question_id];
				$result = $qdata->alreadyVoted = true;
				$qdata->ProposalCategoryId[ intval( $row->proposal_id ) ][] = intval( $row->cat_id );
				$qdata->ProposalCategoryText[ intval( $row->proposal_id ) ][] = $row->text_answer;
			}
		}
		return $result;
	}

	/**
	 * Load voting statistics (totals) from DB.
	 * $this->Questions[]Votes[] will be set on success.
	 * Votes[] are the numbers of choises for each category.
	 * @param  $questions_set  mixed:
	 *   array with integer question_id values of the current poll
	 *   which totals will be loaded;
	 *   false load totals for all the questions of the current poll
	 */
	function loadTotals( $questions_set = false ) {
		$db = wfGetDB( DB_SLAVE );
		if ( $this->hasQuestions() ) {
			$where = array( 'pid' => $this->pid );
			if ( is_array( $questions_set ) ) {
				/* IN */ $where['question_id'] = $questions_set;
			}
			$res = $db->select( 'qp_question_answers',
				array( 'count(uid)', 'question_id', 'proposal_id', 'cat_id' ),
				$where,
				__METHOD__ . ':load single poll count of user votes',
				array( 'GROUP BY' => 'question_id,proposal_id,cat_id' )
			);
			while ( $row = $db->fetchRow( $res ) ) {
				$question_id = intval( $row['question_id'] );
				$propkey = intval( $row['proposal_id'] );
				$catkey = intval( $row['cat_id'] );
				if ( $this->questionExists( $question_id ) ) {
					$this->Questions[$question_id]->setVote( $propkey, $catkey, intval( $row['count(uid)'] ) );
				}
			}
		}
	}

	/**
	 * @param  $qdata  qp_QuestionData instance to query
	 * @return  integer
	 *   count of users who answered to this question
	 */
	function totalUsersAnsweredQuestion( qp_QuestionData $qdata ) {
		$result = 0;
		$db = wfGetDB( DB_SLAVE );
		if ( $this->pid !== null ) {
			$res = $db->select( 'qp_question_answers',
				array( 'count(distinct uid)' ),
				array( 'pid' => $this->pid, 'question_id' => $qdata->question_id ),
				__METHOD__ );
			if ( $row = $db->fetchRow( $res ) ) {
				$result = intval( $row[ "count(distinct uid)" ] );
			}
		}
		return $result;
	}

	/**
	 * Calculates Percents[] properties for every of $this->Questions where
	 * Votes[] properties are available.
	 */
	function calculateStatistics() {
		foreach ( $this->Questions as $qdata ) {
			$qdata->calculateQuestionStatistics( $this );
		}
	}

	/**
	 * Get state of current poll. See the description of $this->mCompletedPostData
	 * property at the top of the class.
	 */
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

	/**
	 * Check whether the poll was successfully submitted.
	 * @return  boolean  result of operation
	 */
	function stateComplete() {
		# completed only when previous state was unavaibale;
		# error state cannot be completed
		if ( $this->mCompletedPostData == 'NA'  && $this->hasQuestions() ) {
			$this->mCompletedPostData = 'complete';
			return true;
		}
		return false;
	}

	/**
	 * Checks, whether particular question belongs to user's random seed
	 * @param $question_id  question_id from DB
	 * @return  true: question belongs to the seed;
	 *          false: question does not belong to the seed;
	 */
	function isUsedQuestion( $question_id ) {
		return !is_array( $this->randomQuestions ) ||
				in_array( $question_id, $this->randomQuestions, true );
	}

	/**
	 * Loads $this->randomQuestions from DB for current user.
	 * Will be overriden in RAM when number of random questions was changed.
	 */
	function loadRandomQuestions() {
		if ( $this->mArticleId == 0 ) {
			$this->randomQuestions = false;
			return;
		}
		if ( $this->pid === null ) {
			throw new MWException( __METHOD__ . ' cannot be called when pid was not set' );
		}
		if ( $this->last_uid === null ) {
			throw new MWException( __METHOD__ . ' cannot be called when uid was not set' );
		}
		# not using DB_SLAVE here due to possible slave lag
		$db = wfGetDB( DB_MASTER );
		$res = $db->select(
			'qp_random_questions',
			'question_id',
			array( 'uid' => $this->last_uid, 'pid' => $this->pid ),
			__METHOD__
		);
		$this->randomQuestions = array();
		while ( $row = $db->fetchObject( $res ) ) {
			$this->randomQuestions[] = intval( $row->question_id );
		}
		if ( count( $this->randomQuestions ) === 0 ) {
			$this->randomQuestions = false;
		} else {
			sort( $this->randomQuestions, SORT_NUMERIC );
		}
	}

	/**
	 * Stores $this->randomQuestions into DB
	 * Should be called:
	 *   when user views the page which has poll definition first time;
	 *   when number of random questions for poll was changed
	 */
	function setRandomQuestions() {
		if ( $this->mArticleId == 0 ) {
			return;
		}
		if ( $this->pid === null ) {
			throw new MWException( __METHOD__ . ' cannot be called when pid was not set' );
		}
		if ( $this->last_uid === null ) {
			throw new MWException( __METHOD__ . ' cannot be called when uid was not set' );
		}
		$db = wfGetDB( DB_MASTER );
		if ( is_array( $this->randomQuestions ) ) {
			$data = array();
			foreach ( $this->randomQuestions as $qidx ) {
				$data[] = array( 'pid' => $this->pid, 'uid' => $this->last_uid, 'question_id' => $qidx );
			}
			$db->begin();
			$db->delete( 'qp_random_questions',
				array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
				__METHOD__
			);
			$res = $db->insert( 'qp_random_questions',
				$data,
				__METHOD__ . ':set random questions seed'
			);
			$db->commit();
			return;
		}
		# this->randomQuestions === false; this poll is not randomized anymore
		$db->delete( 'qp_random_questions',
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':remove question random seed'
		);
	}

	/**
	 * Loads poll user from poll username.
	 * Please note that qpoll has different usernames of anonymous users
	 * and it's own user id's (uid) not matching to MediaWiki user table,
	 * because anonymous users may vote to poll questions.
	 * @param  $username  qpoll username
	 * @param $db optional instance of DB_MASTER when transaction is in progress
	 */
	function setLastUser( $username, $db = null ) {
		if ( $this->pid === null ) {
			return;
		}
		# do no query DB for the same user more than once
		if ( $this->username === $username ) {
			return;
		}
		if ( $db === null ) {
			$db = wfGetDB( DB_MASTER );
		}
		$res = $db->select( 'qp_users', 'uid', array( 'name' => $username ), __METHOD__ );
		$row = $db->fetchObject( $res );
		if ( $row === false ) {
			# there is no such user
			$this->last_uid = null;
			return;
		}
		$this->last_uid = intval( $row->uid );
		# set username, user was loaded
		$this->username = $username;
		$res = $db->select( 'qp_users_polls',
			array( 'attempts', 'short_interpretation', 'long_interpretation', 'structured_interpretation' ),
			array( 'pid' => $this->pid, 'uid' => $this->last_uid ),
			__METHOD__ . ':load answer interpretations'
		);
		if ( $db->numRows( $res ) != 0 ) {
			$row = $db->fetchObject( $res );
			$this->attempts = intval( $row->attempts );
			$this->interpResult = new qp_InterpResult();
			$this->interpResult->short = $row->short_interpretation;
			$this->interpResult->long = $row->long_interpretation;
			$this->interpResult->structured = $row->structured_interpretation;
		}
		$this->randomQuestions = false;
		if ( $this->randomQuestionCount != 0 ) {
			$this->loadRandomQuestions();
		}
//	todo: change to "insert ... on duplicate key update ..." when last_insert_id() bugs will be fixed
	}

	/**
	 * Creates poll user from poll username.
	 * @param  $username  string  qpoll username
	 */
	function createLastUser( $username ) {
		$db = wfGetDB( DB_MASTER );
		# begin transaction to avoid race condition when inserting new user
		$db->begin();
		$this->setLastUser( $username, $db );
		if ( $this->last_uid === null ) {
			# user does not exist, try to create new user
			$db->insert( 'qp_users',
				array( 'name' => $username ),
				__METHOD__ . ':UpdateUser'
			);
			$this->last_uid = intval( $db->insertId() );
			# set username, user was created
			$this->username = $username;
		}
		$db->commit();
	}

	/**
	 * Get username by uid
	 * @param  $uid  integer  qpoll user id
	 */
	static function getUserName( $uid ) {
		$db = wfGetDB( DB_MASTER );
		if ( $uid !== null ) {
			$res = $db->select(
				'qp_users',
				'name',
				array( 'uid' => $uid ),
				__METHOD__
			);
			$row = $db->fetchObject( $res );
			if ( $row !== false ) {
				return $row->name;
			}
		}
		return false;
	}

	/**
	 * Loads poll description from DB specified by
	 * ($this->mArticleId, $this->mPollId).
	 * Optionally updates the DB, when poll tag attributes were changed.
	 */
	private function loadPid() {
		if ( $this->mArticleId === 0 ) {
			return;
		}
		$db = wfGetDB( DB_MASTER );
		if ( count( $row = qp_PollCache::load( $db ) ) > 0 ) {
			$this->pid = $row->pid;
			# some constructors don't supply all of the poll attributes,
			# get the values from DB in such case
			$updates_counter = 0;
			if ( $this->mOrderId === null ) {
				$this->mOrderId = $row->order_id;
				$updates_counter++;
			}
			if ( $this->dependsOn === null ) {
				$this->dependsOn = $row->dependance;
				$updates_counter++;
			}
			if ( $this->interpDBkey === null ) {
				$this->interpNS = $row->interpretation_namespace;
				$this->interpDBkey = $row->interpretation_title;
				$updates_counter++;
			}
			if ( $this->randomQuestionCount === null ) {
				$this->randomQuestionCount = $row->random_question_count;
				$updates_counter++;
			}
			if ( $updates_counter < 4 ) {
				# some attributes might have been changed in poll header,
				# update the cache
				qp_PollCache::store( $db, 'qp_PollCache' );
			}
		}
	}

	/**
	 * Creates new, still non-existing poll in DB specified by
	 * ($this->mArticleId, $this->mPollId).
	 * That will also generate new poll description key in $this->pid
	 */
	public function setPid() {
		if ( $this->mArticleId === 0 ) {
			throw new MWException( 'Cannot save new poll description during new page preprocess in ' . __METHOD__ );
		}
		$db = wfGetDB( DB_MASTER );
		$row = qp_PollCache::create( $db );
		# set store properties unconditionally, because they are guaranteed to
		# match store after qp_PollCache::create() call
		$this->pid = $row->pid;
		$this->mOrderId = $row->order_id;
		$this->dependsOn = $row->dependance;
		$this->interpNS = $row->interpretation_namespace;
		$this->interpDBkey = $row->interpretation_title;
		$this->randomQuestionCount = $row->random_question_count;
	}

	/**
	 * Creates / stores question answer from question instance into
	 * question data instance.
	 * @param  $question  qp_StubQuestion
	 *   instance of question which has current user vote
	 */
	public function setQuestion( qp_StubQuestion $question ) {
		if ( $this->questionExists( $question->mQuestionId ) ) {
			# question data already exists, poll structure was stored during previous
			# submission.
			# question, category and proposal descriptions are already loaded into
			# $this->Questions[$question->mQuestionId] by $this->loadQuestions()
			# but might have pending update, if the source of the poll was modified
			$this->Questions[$question->mQuestionId]->applyQuestion( $question );
		} else {
			# create new question data from scratch (first submission)
			$this->Questions[$question->mQuestionId] = qp_QuestionData::factory( $question );
		}
	}

	/**
	 * Prepares an array of user answer to the current poll and interprets these.
	 * Stores the result in $this->interpResult
	 */
	private function interpretVote() {
		$this->interpResult = new qp_InterpResult();
		$interpTitle = $this->getInterpTitle();
		if ( $interpTitle === false ) {
			# this poll has no interpretation script
			return;
		}
		if ( !( $interpTitle instanceof Title ) || !$interpTitle->exists() ) {
			$this->interpResult->storeErroneous = false;
			$this->interpResult->setError( wfMsg( 'qp_error_no_interpretation' ) );
			return;
		}
		$interpArticle = new Article( $interpTitle, 0 );

		# prepare array of user answers that will be passed to the interpreter
		$poll_answer = array();

		foreach ( $this->Questions as $qdata ) {
			if ( !$this->isUsedQuestion( $qdata->question_id ) ) {
				continue;
			}
			$questions = array();
			foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
				$proposals = array();
				foreach ( $qdata->Categories as $catkey => &$cat_name ) {
					$text_answer = '';
					if ( array_key_exists( $propkey, $qdata->ProposalCategoryId ) &&
								( $id_key = array_search( $catkey, $qdata->ProposalCategoryId[ $propkey ] ) ) !== false ) {
						$proposals[$catkey] = $qdata->ProposalCategoryText[ $propkey ][ $id_key ];
					}
				}
				if ( isset( $qdata->ProposalNames[$propkey] ) ) {
					$questions[$qdata->ProposalNames[$propkey]] = $proposals;
				} else {
					$questions[$propkey] = $proposals;
				}
			}
			if ( $qdata->name !== null ) {
				$poll_answer[$qdata->name] = $questions;
			} else {
				$poll_answer[$qdata->question_id] = $questions;
			}
		}

		# interpret the poll answer to get interpretation answer
		$this->interpResult = qp_Interpret::getResult( $interpArticle, array( 'answer' => $poll_answer, 'randomQuestions' => $this->randomQuestions ) );
	}

	/**
	 * Actually stores user answers to all the questions of current poll.
	 * @param  $db  instance of DB_MASTER (transaction in progress)
	 * Warning: requires qp_PollStorage::last_uid to be set.
	 */
	private function setAnswers( $db ) {
		$insert = array();
		foreach ( $this->Questions as $qkey => $qdata ) {
			foreach ( $qdata->ProposalCategoryId as $propkey => &$prop_answers ) {
				foreach ( $prop_answers as $idkey => $catkey ) {
					$insert[] = array(
						'uid' => $this->last_uid,
						'pid' => $this->pid,
						'question_id' => $qkey,
						'proposal_id' => $propkey,
						'cat_id' => $catkey,
						'text_answer' => $qdata->ProposalCategoryText[$propkey][$idkey]
					);
				}
			}
		}
		# Delete previous user vote to make sure previous definitions of this poll
		# questions are not incompatible to their current definitions.
		$db->delete( 'qp_question_answers',
			array( 'uid' => $this->last_uid, 'pid' => $this->pid ),
			__METHOD__ . ':delete previous answers of current user to the same poll'
		);
		# vote
		if ( count( $insert ) > 0 ) {
			$db->replace( 'qp_question_answers',
				array( 'answer' ),
				$insert,
				__METHOD__
			);
			$this->attempts++;
			# update interpretation result and number of syntax-valid resubmit attempts
			$qp_users_polls = $db->tableName( 'qp_users_polls' );
			$uid = $db->addQuotes( $this->last_uid );
			$pid = $db->addQuotes( $this->pid );
			$short = $db->addQuotes( $this->interpResult->short );
			$long = $db->addQuotes( $this->interpResult->long );
			$structured = $db->addQuotes( $this->interpResult->structured );
			$attempts = $db->addQuotes(  $this->attempts );
			$stmt = "INSERT INTO {$qp_users_polls}
(uid, pid, short_interpretation, long_interpretation, structured_interpretation)
VALUES ( {$uid}, {$pid}, {$short}, {$long}, {$structured} )
ON DUPLICATE KEY UPDATE
attempts = {$attempts}, short_interpretation = {$short} , long_interpretation = {$long}, structured_interpretation = {$structured}";
			$db->query( $stmt, __METHOD__ );
		}
	}

	/**
	 * Complete storage of user vote into DB. Final stage of successful poll POST.
	 * When current poll wasn't previousely voted yet, it also creates poll structure
	 * in DB
	 */
	function setUserVote() {
		if ( $this->hasQuestions() &&
				$this->last_uid !== null &&
				$this->mCompletedPostData === 'complete'
			) {
			$this->interpretVote();
			# warning: transaction should include minimal set of carefully monitored methods
			$db = wfGetDB( DB_MASTER );
			$db->begin();
			qp_PollCache::store( $db, 'qp_QuestionCache', 'qp_CategoryCache', 'qp_ProposalCache' );
			if ( $this->interpResult->hasToBeStored() ) {
				$this->setAnswers( $db );
			}
			$db->commit();
			$this->voteDone = true;
		}
	}

} /* enf of qp_PollStore class */
