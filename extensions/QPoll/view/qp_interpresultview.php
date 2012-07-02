<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * View interpretation results of polls; Used both in "ordinary" pages and
 * in special pages;
 * This cannot extend qp_AbstractView because there is currently no PPFrame
 * in extension's special pages;
 */
class qp_InterpResultView {

	# pview is null in Special:Pollresults;
	# valid view instance with PPFrame in "ordinary" pages
	var $pview = null;
	# a copy of qp_Setup::$show_interpretation or modified version
	var $showInterpretation;

	/**
	 * Creates new view without "parent" view associated - no PPFrame;
	 * @param  $displayAll  boolean  true - display all results (for Special:Pollresults)
	 *                               false - display only allowed results (for end-user)
	 */
	function __construct( $displayAll = false ) {
		## setup 'showInterpretation' property
		# set pre-defined value
		$this->showInterpretation = qp_Setup::$show_interpretation;
		# make sure all required keys are available
		foreach ( array( 'short', 'long', 'structured' ) as $val ) {
			if ( !isset( $this->showInterpretation[$val] ) ) {
				$this->showInterpretation[$val] = false;
			}
		}
		if ( $displayAll ) {
			# enable displaying all the kinds of intepretations
			foreach ( $this->showInterpretation as &$val ) {
				$val = true;
			}
		}
	}

	/**
	 * Instantiate with parent view (with PPFrame);
	 * Used for end-user display (long interpretation as wikitext)
	 */
	static function newFromBaseView( qp_AbstractView $pview ) {
		$self = new self( false );
		$self->pview = $pview;
		return $self;
	}

	/**
	 * Add interpretation results to tagarray of poll view
	 */
	function showInterpResults( array &$tagarray, qp_InterpResult $ctrl, $showDescriptions = false ) {
		if ( $ctrl->hasVisibleProperties() ) {
			return;
		}
		$interp = array();
		if ( $showDescriptions ) {
				$interp[] = array( '__tag' => 'div', wfMsg( 'qp_results_interpretation_header' ) );
		}
		# currently, error is not stored in DB, only the vote and long / short interpretations
		# todo: is it worth to store it?
		if ( ( $scriptError = $ctrl->error ) != '' ) {
			$interp[] = array( '__tag' => 'div', 'class' => 'interp_error', qp_Setup::specialchars( $scriptError ) );
		}
		# output long result, when permitted and available
		if ( $this->showInterpretation['long'] &&
				( $answer = $ctrl->long ) !== '' ) {
			if ( $showDescriptions ) {
				$interp[] = array( '__tag' => 'div', 'class' => 'interp_header', wfMsg( 'qp_results_long_interpretation' ) );
			}
			$interp[] = array( '__tag' => 'div', 'class' => 'interp_answer_body', is_null( $this->pview ) ? nl2br( qp_Setup::specialchars( $answer ) ) : $this->pview->rtp( $answer ) );
		}
		# output short result, when permitted and available
		if ( $this->showInterpretation['short'] &&
				( $answer = $ctrl->short ) !== '' ) {
			if ( $showDescriptions ) {
				$interp[] = array( '__tag' => 'div', 'class' => 'interp_header', wfMsg( 'qp_results_short_interpretation' ) );
			}
			$interp[] = array( '__tag' => 'div', 'class' => 'interp_answer_body', nl2br( qp_Setup::specialchars( $answer ) ) );
		}
		if ( $this->showInterpretation['structured'] &&
				( $answer = $ctrl->structured ) !== '' ) {
			if ( $showDescriptions ) {
				$interp[] = array( '__tag' => 'div', 'class' => 'interp_header', wfMsg( 'qp_results_structured_interpretation' ) );
			}
			$strucTable = $ctrl->getStructuredAnswerTable();
			$rows = array();
			foreach ( $strucTable as &$line ) {
				if ( isset( $line['keys'] ) ) {
					# current node is associative array
					qp_Renderer::addRow( $rows, $line['keys'], array(), 'th' );
					qp_Renderer::addRow( $rows, $line['vals'] );
				} else {
					# current node is scalar value
					qp_Renderer::addRow( $rows, array( $line['vals'] ) );
				}
			}
			$interp[] = array( '__tag' => 'table', 'class' => 'structured_answer', $rows );
			unset( $strucTable );
		}
		$tagarray[] = array( '__tag' => 'div', 'class' => 'interp_answer', $interp );
	}

} /* end of qp_InterpResultView class */
