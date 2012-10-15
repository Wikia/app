<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

abstract class qp_AbstractQuestion {

	# indicates whether current question is used or not;
	# also provides sparce enumeration of questions (unused questions are not counted)
	# 1..n when the question is active;
	# false when the question is hidden (used by randomizer)
	var $usedId = false;
	# sequental number of question (starting from 1); matches to usedId
	# when the collection of the questions is not sparce (was not randomized)
	var $mQuestionId;

	# current state of question parsing (no error)
	var $mState = '';
	# default type of the question; stored in DB;
	# should always be properly initialized in parent controller via $poll->parseMainHeader()
	var $mType = 'unknown';
	var $mCategories = array();
	var $mCategorySpans = array();
	# common question of this question
	var $mCommonQuestion = '';
	# an array of question proposals
	var $mProposalText = array();
	# whether the selected user has already voted this question?
	var $alreadyVoted = false;

	# statistics
	var $Percents = null;

	# question's parent controller
	var $poll;
	# question's view
	var $view;

	/**
	 * Constructor
	 * @public
	 * @param  $poll  object
	 *   an instance of question's parent controller
	 * @param  $view  object
	 *   an instance of question view "linked" to this question
	 * @param  $questionId  integer
	 *   identifier of the question used to generate input names
	 */
	function __construct( qp_AbstractPoll $poll, qp_AbstractView $view, $questionId ) {
		# the question collection is not sparce by default
		$this->mQuestionId = $this->usedId = $questionId;
		$view->setController( $this );
		$this->view = $view;
		$this->poll = $poll;
	}

	/**
	 * Mutator of the question state
	 *
	 * @protected
	 * @param  $pState - state of the question
	 * @param  $error_message - optional main_header_parsing error message
	 */
	function setState( $pState, $error_message = null ) {
		if ( $this->mState != 'error' ) {
			$this->mState = $pState;
		}
		if ( $error_message !== null ) {
			# store header error message that cannot be output now, but will be displayed at rendering stage
			$this->view->headerErrorMessage = $error_message;
		}
	}

	/**
	 * Accessor of the question state.
	 *
	 * @protected
	 */
	function getState() {
		return $this->mState;
	}

	/**
	 * Applies previousely parsed attributes from main header into question's view
	 * (all attributes but type)
	 *
	 * @param   $attr_str - source text with question attributes
	 * @return  string : type of the question, empty when not defined
	 */
	function applyAttributes( array $paramkeys ) {
		$this->view->setLayout( $paramkeys[ 'layout' ], $paramkeys[ 'textwidth' ] );
		$this->view->setShowResults( $paramkeys[ 'showresults' ] );
		$this->view->setPropWidth( $paramkeys[ 'propwidth' ] );
	}

	function getPercents( $proposalId, $catId ) {
		if ( is_array( $this->Percents ) && array_key_exists( $proposalId, $this->Percents ) &&
					is_array( $this->Percents[ $proposalId ] ) && array_key_exists( $catId, $this->Percents[ $proposalId ] ) ) {
			return intval( round( 100 * $this->Percents[ $proposalId ][ $catId ] ) );
		}
		return false;
	}

	function applyStateToParent() {
		$this->poll->mState = $this->getState();
	}

} /* end of qp_AbstractQuestion class */
