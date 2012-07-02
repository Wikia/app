<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class qp_StubQuestionProposalView {

	# proposal's id
	var $proposalId;

	# an instance of question's controller
	var $ctrl;
	var $rowClass = 'proposal';

	/*** imported from question's view ***/
	# qustion's showresults level
	static $showResults;
	# used to indicate which classes should be used for drawing borders
	# around category spans eitherfor horizontal or vertical question layout
	# depends on transpose attribute
	static $signClass;
	/*** end of imported from question's view ***/

	# name of cell template method
	static $cellTemplateMethod;
	# name of cell showresults method
	static $showResultsMethod;

	/**
	 * We are type hinting for qp_AbstractQuestion instead of qp_StubQuestion
	 * because qp_QuestionStats derives directly from qp_AbstractQuestion
	 * todo: isn't it better to derive qp_QuestionStats from qp_StubQuestion ?
	 */
	function __construct( $proposalId, qp_AbstractQuestion $ctrl ) {
		$this->proposalId = $proposalId;
		$this->ctrl = $ctrl;
	}

	/**
	 * Apply current view layout from questions view to proposal view
	 */
	static function applyViewState( qp_StubQuestionView $view ) {
		self::$showResults = $view->showResults;
		self::$showResultsMethod = 'addShowResults' . self::$showResults['type'];
		self::$cellTemplateMethod = 'cellTemplate' . self::$showResults['type'];
		# text questions do not have categories and thus no borders around cells
		if ( property_exists( $view, 'signClass' ) ) {
			self::$signClass = $view->signClass;
		}
	}

} /* end of qp_StubQuestionProposalView */
