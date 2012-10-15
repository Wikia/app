<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Processes poll markup in declaration/voting mode
 */
class qp_Poll extends qp_AbstractPoll {

	# question header match pattern without line begin/end, braces, regexp modifiers
	private static $headerPattern = '[^{\|].*?\|.*?[^}\|]';
	# question header split pattern
	private static $splitPattern;
	# question header match pattern with line begin/end, braces, regexp modifiers
	private static $matchPattern;

	# optional address of the poll which must be answered first
	var $dependsOn = '';
	# optional template used to interpret user vote in the Special:Pollresults page
	var $interpretation = '';
	# whether the questions of the poll has to be randomized
	# 0: questions are not randomized
	# 1..n: pull 1..n question from total number of defined questions;
	# separately stored for every (poll,user) in the poll store
	var $randomQuestionCount = 0;
	# maximal count of attepts of answer submission ( < 1 for infinite )
	var $maxAttempts = 0;

	function __construct( array $argv, qp_PollView $view ) {
		parent::__construct( $argv, $view );
		# Split header / body
		# Includes surrounding newlines and header's curly braces into match in parentheses
		# because raw question bodies has to be trimmed from single surrounding newlines.
		# Otherwise, these newlines will cause false positive detection of multiline proposals.
		self::$splitPattern = '/((?:$.^|^)\s*{' . self::$headerPattern . '\}\s*$.^)/msu';
		# match header
		# Does not include surrounding newlines and header's curly braces into match in parentheses
		# because we need to parse only the inner part (common question and optional categories).
		self::$matchPattern = '/^\s*{(' . self::$headerPattern . ')\}\s*$/msu';
		# dependance attr
		if ( array_key_exists( 'dependance', $argv ) ) {
			$this->dependsOn = trim( $argv['dependance'] );
			if ( $this->dependsOn === 'dependance' ) {
				$this->dependsOn = '';
			}
		}
		# interpretation attr
		if ( array_key_exists( 'interpretation', $argv ) ) {
			$this->interpretation = trim( $argv['interpretation'] );
		}
		# randomize attr
		if ( array_key_exists( 'randomize', $argv ) ) {
			if ( $argv['randomize'] === 'randomize' ) {
				$this->randomQuestionCount = 1;
			} else {
				$this->randomQuestionCount = intval( trim( $argv['randomize'] ) );
				if ( $this->randomQuestionCount < 0 ) {
					$this->randomQuestionCount = 0;
				}
			}
		}
		# max_attempts attr
		$this->maxAttempts = qp_Setup::$max_submit_attempts;
		if ( array_key_exists( 'max_attempts', $argv ) ) {
			$this->maxAttempts = intval( trim( $argv['max_attempts'] ) );
			# do not allow to specify more submit attempts than is set by global level in qp_Setup
			if ( qp_Setup::$max_submit_attempts > 0 &&
					# also does not allow to set infinite number ( < 1 ) when global level is finite ( > 0 )
					( $this->maxAttempts < 1 ||
						$this->maxAttempts > qp_Setup::$max_submit_attempts ) ) {
				$this->maxAttempts = qp_Setup::$max_submit_attempts;
			}
		}
		# negative values are possible however meaningless (<=0 is infinite, >0 is finite)
		if ( $this->maxAttempts < 0 ) {
			$this->maxAttempts = 0;
		}
		# order_id is used to sort out polls on the Special:PollResults statistics page
		$this->mOrderId = self::$sOrderId;
		# Determine if this poll is being corrected or not, according to the pollId
		$this->mBeingCorrected = ( qp_Setup::$request->wasPosted() && qp_Setup::$request->getVal( 'pollId' ) == $this->mPollId );
	}

	/**
	 * Set poll headers; checks poll headers for errors
	 * @return  string  error message to display;
	 *          boolean  true when no errors
	 */
	function setHeaders() {
		if ( $this->mPollId == null ) {
			$this->mState = "error";
			return self::fatalErrorNoQuote( 'qp_error_no_poll_id' );
		}
		if ( !self::isValidPollId( $this->mPollId ) ) {
			$this->mState = "error";
			return self::fatalErrorQuote( 'qp_error_invalid_poll_id', $this->mPollId );
		}
		if ( !self::isUniquePollId( $this->mPollId ) ) {
			$this->mState = "error";
			return self::fatalErrorQuote( 'qp_error_already_used_poll_id', $this->mPollId );
		}
		self::addPollId( $this->mPollId ); // add current poll id to the static list of poll ids on this page
		if ( $this->pollAddr !== null ) {
			$this->mState = "error";
			return self::fatalErrorNoQuote( 'qp_error_address_in_decl_mode' );
		}
		if ( $this->dependsOn != '' ) {
			if ( strlen( $this->dependsOn ) > qp_Setup::$field_max_len['dependance'] ) {
				return self::fatalErrorQuote( 'qp_error_too_long_dependance_value', $this->mPollId, $this->dependsOn );
			}
			$depsOnAddr = self::getPrefixedPollAddress( $this->dependsOn );
			if ( !is_array( $depsOnAddr ) ) {
				return self::fatalErrorQuote( 'qp_error_invalid_dependance_value', $this->mPollId, $this->dependsOn );
			}
			$this->dependsOn = $depsOnAddr[2];
		}
		return true;
	}

	# prepare qp_PollStore object
	# @return    true on success ($this->pollStore has been created successfully), error string on failure
	function getPollStore() {
		$newPollStore = array(
				'poll_id' => $this->mPollId,
				'order_id' => $this->mOrderId,
				'randomQuestionCount' => $this->randomQuestionCount,
				'dependance' => $this->dependsOn,
				'interpretation' => $this->interpretation
		);
		if ( ( $dependanceResult = $this->checkDependance( $this->dependsOn ) ) !== true ) {
			# return an error string
			# here we create a pollstore only to update poll attributes (order_id,dependance), in case these were changed
			$newPollStore['from'] = 'poll_get';
			$this->pollStore = new qp_PollStore( $newPollStore );
			return $dependanceResult;
		}
		if ( $this->mBeingCorrected ) {
			$newPollStore['from'] = 'poll_post';
			$this->pollStore = new qp_PollStore( $newPollStore );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( $this->username );
			$this->pollStore->loadUserAlreadyVoted();
		} else {
			$newPollStore['from'] = 'poll_get';
			$this->pollStore = new qp_PollStore( $newPollStore );
			$this->pollStore->loadQuestions();
			$this->pollStore->setLastUser( $this->username );
			# to show previous choice of current user, if that's available
			# do not check the result, because user can vote even if haven't voted before
			$this->pollStore->loadUserVote();
		}
		return true;
	}

	/**
	 * Please call after the poll has been loaded but before it's being submitted
	 * @return  int number of attempts left (1..n); true for infinite number; false when no attempts left
	 */
	function attemptsLeft() {
		if ( $this->maxAttempts > 0 ) {
			$result = $this->maxAttempts - $this->pollStore->attempts;
			if ( $result > 0 ) {
				return $result;
			}
			return false;
		}
		return true;
	}

	function setUsedQuestions() {
		if ( $this->randomQuestionCount === 0 ) {
			return;
		}
		if ( $this->randomQuestionCount > $this->questions->totalCount() ) {
			$this->randomQuestionCount = $this->questions->totalCount();
		}
		if ( is_array( $this->pollStore->randomQuestions ) ) {
			if ( count( $this->pollStore->randomQuestions ) == $this->randomQuestionCount ) {
				# count of random questions was not changed, no need to regenerate seed
				$this->questions->setUsedQuestions( $this->pollStore->randomQuestions );
				return;
			}
		}
		# generate or regenerate random questions
		$this->questions->randomize( $this->randomQuestionCount );
		$this->pollStore->randomQuestions = $this->questions->getUsedQuestions();
		# store random questions for current user into DB
		if ( qp_Setup::$title->getArticleID() !== 0 ) {
			$this->pollStore->setPid();
			$this->pollStore->createLastUser( $this->username );
			$this->pollStore->setRandomQuestions();
		}
	}

	/**
	 * Parses the text enclosed in poll tag
	 * Votes, when user have submitted data successfully
	 * @param    $input - text enclosed in poll tag
	 * @return   boolean true - stop further processing, false - continue processing
	 */
	function parseInput( $input ) {
		# parse the input; generates $this->questions collection
		$this->parseQuestionsHeaders( $input );
		$this->setUsedQuestions();
		$this->parseQuestionsBodies();
		# check whether the poll was successfully submitted
		if ( $this->attemptsLeft() === false ) {
			# user has no attempts left, refuse to submit and
			# will show the message in $this->view->renderPoll()
			return false;
		}
		if ( $this->pollStore->stateComplete() ) {
			# store user vote to the DB (when the poll is fine)
			$this->pollStore->createLastUser( $this->username );
			$this->pollStore->setUserVote();
		}
		if ( $this->pollStore->interpResult->isError() ) {
			# no redirect when there are script-generated interpretation errors (quiz mode)
			return false;
		}
		if ( $this->pollStore->voteDone ) {
			if ( qp_Setup::$cache_control ) {
				$this->mResponse->setcookie( 'QPoll', 'clearCache', time() + 20 );
			}
			$this->mResponse->header( 'HTTP/1.0 302 Found' );
			$this->mResponse->header( 'Location: ' . qp_Setup::$title->getFullURL() . $this->getPollTitleFragment() );
			return true;
		}
		return false;
	}

	# check whether the poll is dependant on other polls
	# @param     $dependsOn - poll address on which the current (recursive) poll is dependant
	# @param     $nonVotedDepLink - maintains different logic for recursion
	#	value: string - link to the poll in chain which has not been voted yet OR
	#	value: boolean - false when there was no poll in the chain which has not been voted yet
	# @return    true when dependance is fulfilled, error message otherwise
	private function checkDependance( $dependsOn, $nonVotedDepLink = false ) {
		# check the headers for dependance to other polls
		if ( $dependsOn === '' ) {
			return true;
		}
		$depPollStore = qp_PollStore::newFromAddr( $dependsOn );
		if ( $depPollStore instanceof qp_PollStore ) {
			# process recursive dependance
			$depTitle = $depPollStore->getTitle();
			$depPollId = $depPollStore->mPollId;
			$depLink = $this->view->link( $depTitle, $depTitle->getPrefixedText() . ' (' . $depPollStore->mPollId . ')' );
			if ( $depPollStore->pid === null ) {
				return self::fatalErrorNoQuote( 'qp_error_missed_dependance_poll', qp_Setup::specialchars( $this->mPollId ), $depLink, qp_Setup::specialchars( $depPollId ) );
			}
			if ( !$depPollStore->loadQuestions() ) {
				return self::fatalErrorNoQuote( 'qp_error_vote_dependance_poll', $depLink );
			}
			$depPollStore->setLastUser( $this->username );
			if ( $depPollStore->loadUserAlreadyVoted() ) {
				# user already voted in current the poll in chain
				if ( $depPollStore->dependsOn === '' ) {
					if ( $nonVotedDepLink === false ) {
						# there was no non-voted deplinks in the chain at some previous level of recursion
						return true;
					} else {
						# there is an non-voted deplink in the chain at some previous level of recursion
						return self::fatalErrorNoQuote( 'qp_error_vote_dependance_poll', $nonVotedDepLink );
					}
				} else {
					return $this->checkDependance( $depPollStore->dependsOn, $nonVotedDepLink );
				}
			} else {
				# user hasn't voted in current the poll in chain
				if ( $depPollStore->dependsOn === '' ) {
					# current element of chain is not voted and furthermore, doesn't depend on any other polls
					return self::fatalErrorNoQuote( 'qp_error_vote_dependance_poll', $depLink );
				} else {
					# current element of chain is not voted, BUT it has it's own dependance
					# so we will check for the most deeply nested poll which hasn't voted, yet
					return $this->checkDependance( $depPollStore->dependsOn, $depLink );
				}
			}
		} else {
			# process poll address errors
			switch ( $depPollStore ) {
			case qp_Setup::ERROR_INVALID_ADDRESS :
				return self::fatalErrorQuote( 'qp_error_invalid_dependance_value', $this->mPollId, $dependsOn );
			case qp_Setup::ERROR_MISSED_TITLE :
				$depSplit = self::getPrefixedPollAddress( $dependsOn );
				if ( is_array( $depSplit ) ) {
					list( $depTitleStr, $depPollId ) = $depSplit;
					$depTitle = Title::newFromURL( $depTitleStr );
					$depTitleStr = $depTitle->getPrefixedText();
					$depLink = $this->view->link( $depTitle, $depTitleStr );
					return self::fatalErrorNoQuote( 'qp_error_missed_dependance_title', qp_Setup::specialchars( $this->mPollId ), $depLink, qp_Setup::specialchars( $depPollId ) );
				} else {
					return self::fatalErrorQuote( 'qp_error_invalid_dependance_value', $this->mPollId, $dependsOn );
				}
			default :
				throw new MWException( __METHOD__ . ' invalid dependance poll store found' );
			}
		}
	}

	/**
	 * Creates the collection of poll questions in $this->questions
	 * @param    $input  string poll in QPoll syntax
	 */
	function parseQuestionsHeaders( $input ) {
		$this->questions = new qp_QuestionCollection();
		$unparsedQuestions = preg_split( self::$splitPattern, $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		# first pass: parse the headers
		$header =
		$body = '';
		$matches = array();
		while ( list( $key, $part ) = each( $unparsedQuestions ) ) {
			if ( preg_match( self::$matchPattern, $part, $matches ) ) {
				$body = '';
				$header = $matches[1];
			} else {
				$body = $part;
				$question = $this->parseQuestionHeader( $header, $body );
				$this->questions->add( $question );
			}
		}
		if ( $body === '' ) {
			$question = $this->parseQuestionHeader( $header, $body );
			$this->questions->add( $question );
		}
	}

	/**
	 * Parses question bodies for every poll in collection
	 * Also loads statistics from pollstore
	 */
	function parseQuestionsBodies() {
		# check for showresults attribute
		$questions_set = array();
		$this->questions->reset();
		while ( is_object( $question = $this->questions->iterate() ) ) {
			$this->parseQuestionBody( $question );
			if ( $question->view->hasShowResults() ) {
				$questions_set[] = $question->mQuestionId;
			}
		}
		# load the statistics for all/selective/none of questions
		if ( count( $questions_set ) > 0 ) {
			if ( count( $questions_set ) == $this->questions->totalCount() ) {
				$this->pollStore->loadTotals();
			} else {
				$this->pollStore->loadTotals( $questions_set );
			}
			$this->pollStore->calculateStatistics();
		}
	}

	/**
	 * Parse question main header (common question and XML attributes)
	 * initializes common question and question type/subtype
	 * @param  $header  string
	 *   the question's header in QPoll syntax
	 * @return  instance of question that matches the header attributes
	 */
	function parseMainHeader( $header ) {
		# split common question and question attributes from the header
		$parts = explode( '|', $header );
		# last pipe character separates attributes from common question
		$attr_str = array_pop( $parts );
		# this enables to use tables and templates in common question
		$common_question = implode( '|', $parts );
		$error_msg = '';
		# assume that question name does not exists (by default)
		$name = null;
		if ( isset( $attr_str ) ) {
			$paramkeys = array();
			$type = $this->getQuestionAttributes( $attr_str, $paramkeys );
			if ( !array_key_exists( $type, qp_Setup::$questionTypes ) ) {
				$error_msg = wfMsg( 'qp_error_invalid_question_type', qp_Setup::entities( $type ) );
			}
			if ( $paramkeys['name'] !== null &&
						( $name = trim( $paramkeys['name'] ) ) === '' ||
						is_numeric( $name ) ||
						strlen( $name ) > qp_Setup::$field_max_len['question_name'] ) {
				# empty name is not allowed;
				# numeric name is not allowed;
				# name longer than maximal DB field length is not allowed;
				$error_msg = wfMsg( 'qp_error_invalid_question_name', qp_Setup::entities( $name ) );
				$name = null;
			}
		} else {
			$error_msg = wfMsg( 'qp_error_in_question_header', qp_Setup::entities( $header ) );
		}

		if ( $error_msg !== '' ) {
			$question = new qp_StubQuestion(
				$this,
				qp_StubQuestionView::newFromBaseView( $this->view ),
				++$this->mQuestionId,
				$name
			);
			$question->setState( 'error', $error_msg );
			return $question;
		}

		$qt = qp_Setup::$questionTypes[$type];
		$question = new $qt['ctrl'](
			$this,
			call_user_func( array( $qt['view'], 'newFromBaseView' ), $this->view ),
			++$this->mQuestionId,
			$name
		);
		# set the question type and subtype corresponding to the header 'type' attribute
		$question->mType = $qt['mType'];
		if ( isset( $qt['mSubType'] ) ) {
			$question->mSubType = $qt['mSubType'];
		}

		$question->mCommonQuestion = trim( $common_question );
		$question->applyAttributes( $paramkeys );
		return $question;
	}

	/**
	 * Builds the question with fully parsed headers
	 *
	 * internally, the header is split into
	 *   main header (part inside curly braces) and
	 *   body header (categories and metacategories defitions)
	 *
	 * @param  $header : the text of question "main" header (common question and XML-like attrs)
	 * @param  $body   : the text of question body
	 *                   for tabular questions body begins with header line that defines
	 *                   categories and spans, followed by proposal lines)
	 * @return           question object with parsed headers
	 */
	function parseQuestionHeader( $header, $body ) {
		# parse questions common question and XML attributes
		$question = $this->parseMainHeader( $header );
		if ( $question->getState() != 'error' ) {
			# load previous user choice, when it's available and DB header is compatible with parsed header
			if ( !method_exists( $question, 'parseBody' ) ) {
				$question->setState( 'error', wfMsgHtml( 'qp_error_question_not_implemented', qp_Setup::entities( $question->mType ) ) );
			} elseif ( $body === '' ) {
				$question->setState( 'error', wfMsgHtml( 'qp_error_question_empty_body' ) );
			} else {
				# build $question->raws[]
				$question->splitRawProposals( $body );
				# parse the categories and spans (metacategories)
				$question->parseBodyHeader( $body );
			}
		}
		return $question;
	}

	/**
	 * Populates the question with data and builds question->view
	 */
	function parseQuestionBody( qp_StubQuestion $question ) {
		try {
			if ( $question->getState() == 'error' ) {
				throw new Exception( 'qp_error' );
			}
			# populate $question with raw source values
			$question->getQuestionAnswer( $this->pollStore );
			# check whether the global showresults level prohibits to show statistical data
			# to the users who hasn't voted
			if ( qp_Setup::$global_showresults <= 1 && !$question->alreadyVoted ) {
				# suppress statistical results when the current user hasn't voted the question
				$question->view->showResults = array( 'type' => 0 );
			}
			# parse the question body
			# will populate $question->view which can be modified accodring to quiz results
			# warning! parameters are passed only by value, not the reference
			$question->parseBody();
			$question->isEmpty();
			if ( $question->getState() == 'error' ) {
				throw new Exception( 'qp_error' );
			}
			if ( $this->mBeingCorrected ) {
				if ( $question->getState() == '' ) {
					# question is OK, store it into pollStore
					$this->pollStore->setQuestion( $question );
				} else {
					# http post: not every proposals were answered: do not update DB
					$this->pollStore->stateIncomplete();
				}
			} else {
				# this is the get, not the post: do not update DB
				if ( $question->getState() == '' ) {
					$this->pollStore->stateIncomplete();
				} else {
					# http get: invalid question syntax, parse errors will cause submit button disabled
					$this->pollStore->stateError();
				}
			}
		} catch ( Exception $e ) {
			if ( $e->getMessage() === 'qp_error' ) {
				# error occured during the previously performed header parsing, do not process further
				# http get: invalid question syntax, parse errors will cause submit button disabled
				$this->pollStore->stateError();
				return;
			} else {
				throw new MWException( $e->getMessage() );
			}
		}
	}

} /* end of qp_Poll class */
