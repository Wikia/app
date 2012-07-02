<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Instantinable question controller used as base class for
 * interactive question controllers;
 * Also it's instantinated when the declaration of the question has errors in
 * it's main header (see $ctrl->parseMainHeader() )
 */
class qp_StubQuestion extends qp_AbstractQuestion {

	# array of raw question source lines
	var $raws;
	# key of first raw proposal in $this->raws
	var $rawProposalKey = 0;

	# optional question literal name, used to address questions in interpretation scripts
	var $mName = null;

	# some questions have subtype; currently is not stored in DB;
	# should always be properly initialized in parent controller via $poll->parseMainHeader()
	var $mSubType = '';

	# array of question proposals names (optional, used in interpretation scripts)
	# packed to string together with mProposalText then stored into DB field 'proposal_text'
	var $mProposalNames = array();

	# current user voting taken from POST data (if available)
	var $mProposalCategoryId = Array(); // user true/false answers to the question's proposal
	var $mProposalCategoryText = Array(); // user text answers to the question's proposal
	# previous user voting (if available) taken from DB
	var $mPrevProposalCategoryId = Array(); // user true/false answers to the question's proposal from DB
	var $mPrevProposalCategoryText = Array(); // user text answers to the question's proposal from DB

	/**
	 * Constructor
	 * @public
	 * @param  $poll  object
	 *   an instance of question's parent controller
	 * @param  $view  object
	 *   an instance of question view "linked" to this question
	 * @param  $questionId  integer
	 *   identifier of the question used to generate input names
	 * @param  $name  mixed
	 *   null  when question has no name / invalid name
	 *   string  valid question name
	 */
	function __construct( qp_AbstractPoll $poll, qp_StubQuestionView $view, $questionId, $name ) {
		parent::__construct( $poll, $view, $questionId );
		$this->mName = $name;
	}

	/**
	 * Get question key (reference)
	 * @return mixed
	 *   string question name if available, otherwise
	 *   integer question id
	 */
	function getQuestionKey() {
		return $this->mName === null ? $this->mQuestionId : $this->mName;
	}

	/**
	 * Get proposal id by proposal name, if any.
	 * @param $proposalName string
	 *   proposal name
	 * @return mixed
	 *   integer question id for specified name
	 *   false there is no such name
	 */
	function getProposalIdByName( $proposalName ) {
		return array_search( $proposalName, $this->mProposalNames, true );
	}

	/**
	 * Replace lines of alone '\' character to empty lines.
	 * Trims first and last empty line, left from raws split regexp,
	 * when available.
	 */
	private function substBackslashNL( &$s ) {
		# warning: in single quoted regexp replace '\\\' translates into '\';
		# wikitext always uses '\n' as line separator (unix style)
		$s = preg_replace( '/^(\s*\\\??\s*)$|(\A\n)|(\n\Z)/mu', '', $s );
	}

	/**
	 * Split raw question body into raw proposals and optionally
	 * raw categories / raw category spans, when available.
	 */
	function splitRawProposals( $input ) {
		# detect type of raw proposals
		# multiline raw proposals have empty lines and also optionally have lines
		# containing only '\' character.
		if ( preg_match( '/^\s*\\??\s*$/mu', $input ) ) {
			# multiline raw proposals
			# warning: in single quoted regexp split '\\' translates into '\'
			$this->raws = preg_split( '/((?:^\s*$)+)/mu', $input, -1, PREG_SPLIT_NO_EMPTY );
			array_walk( $this->raws, array( __CLASS__, 'substBackslashNL' ) );
		} else {
			# single line raw proposals
			$this->raws = preg_split( '`\n`su', $input, -1, PREG_SPLIT_NO_EMPTY );
		}
	}

	/**
	 * Load answer-related question fields from qp_QuestionData instance given.
	 * @param  $qdata  instance of qp_QuestionData
	 */
	function loadAnswer( qp_QuestionData $qdata ) {
		$this->alreadyVoted = $qdata->alreadyVoted;
		$this->mPrevProposalCategoryId = $qdata->ProposalCategoryId;
		$this->mPrevProposalCategoryText = $qdata->ProposalCategoryText;
		if ( isset( $qdata->Percents ) && is_array( $qdata->Percents ) ) {
			$this->Percents = $qdata->Percents;
		} else {
			# no percents - no stats
			$this->view->showResults = Array( 'type' => 0 );
		}
	}

	/**
	 * Populates current instance of question with data from pollstore.
	 * @param  $pollStore  instance of qp_PollStore
	 */
	function getQuestionAnswer( qp_PollStore $pollStore ) {
		if ( $pollStore->pid !== null ) {
			if ( $pollStore->questionExists( $this->mQuestionId ) ) {
				$qdata = $pollStore->Questions[ $this->mQuestionId ];
				if ( $qdata->IsCompatible( $this ) ) {
					$this->loadAnswer( $qdata );
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Check, whether current user previousely selected the particular category of
	 * the proposal of this question.
	 * @return  mixed
	 *   boolean true / boolean false for 'checkbox' and 'radio' inputTypes
	 *   string / boolean false for 'text' inputType
	 */
	function answerExists( $inputType, $proposalId, $catId ) {
		if ( $this->alreadyVoted ) {
			if ( array_key_exists( $proposalId, $this->mPrevProposalCategoryId ) ) {
				$id_key = array_search( $catId, $this->mPrevProposalCategoryId[ $proposalId ] );
				if ( $id_key !== false ) {
					if ( $inputType == 'text' ) {
						if ( array_key_exists( $proposalId, $this->mPrevProposalCategoryText ) &&
								array_key_exists( $id_key, $this->mPrevProposalCategoryText[ $proposalId ] ) ) {
							$prev_text_answer = $this->mPrevProposalCategoryText[ $proposalId ][ $id_key ];
							if ( $prev_text_answer != '' ) {
								return $prev_text_answer;
							}
						}
					} else {
						return true;
					}
				}
			}
		}
		return false;
	}

	function isUniqueProposalCategoryId( $proposalId, $catId ) {
		foreach ( $this->mProposalCategoryId as $proposalCategoryId ) {
			if ( in_array( $catId, $proposalCategoryId ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param  $proposal_id  integer
	 *   id of existing question's proposal
	 * @return integer
	 *   count of answered categories by current submitting user for
	 *   specified proposal id
	 */
	function getAnsweredCatCount( $proposal_id ) {
		return array_key_exists( $proposal_id, $this->mProposalCategoryId ) ?
			count( $this->mProposalCategoryId[$proposal_id] ) :
			0;
	}

	/**
	 * Applies previousely parsed attributes from main header into question's view
	 * (all attributes but type)
	 * @param  $paramkeys array
	 *   key is attribute name regexp match, value is the value of attribute
	 */
	function applyAttributes( array $paramkeys ) {
		parent::applyAttributes( $paramkeys );
		if ( $paramkeys['catreq'] !== null ) {
			$this->mCatReq = qp_PropAttrs::getSaneCatReq( $paramkeys['catreq'] );
		}
		if ( $paramkeys['emptytext'] !== null ) {
			$this->mEmptyText = qp_PropAttrs::getSaneEmptyText( $paramkeys['emptytext'] );
		}
	}

	/**
	 * @return  mixed
	 *   array  (associative) of script-generated interpretation error messages
	 *     for current question proposals (and optionally categories);
	 *   boolean  false, when there are no script-generated error messages;
	 */
	function getInterpErrors() {
		$interpResult = $this->poll->pollStore->interpResult;
		if ( !is_array( $interpResult->qpcErrors ) ) {
			return false;
		}
		$key = $this->getQuestionKey();
		if ( isset( $interpResult->qpcErrors[$key] ) ) {
			return $interpResult->qpcErrors[$key];
		}
		return false;
	}

	/**
	 * Raises an error in case parsed question does not have any proposals.
	 */
	function isEmpty() {
		if ( count( $this->mProposalText ) === 0 ) {
			$this->setState( 'error', wfMsgHtml( 'qp_error_question_no_proposals' ) );
		};
	}

	/**
	 * Creates question view which should be renreded and
	 * also may be altered during the poll generation
	 */
	function parseBody() {
		/* does nothing */
	}

} /* end of qp_StubQuestion class */
