<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class qp_QuestionStatsProposalView extends qp_TabularQuestionProposalView {

	/**
	 * Apply current view layout from questions view to proposal view
	 *
	 * Please clone this method in derived classes until the code is
	 * moved from early to late static binding
	 */
	static function applyViewState( qp_StubQuestionView $view ) {
		parent::applyViewState( $view );
		# initialize cell template for selected showresults
		# todo: this is self (PHP 5.2), not static (PHP 5.3)
		# do not forget to clone this method in ancestors
		self::$spanState = (object) array( 'id' => 0, 'prevId' => -1, 'wasChecked' => true, 'isDrawing' => false, 'cellsLeft' => 0, 'className' => 'sign' );
		if ( self::$showResults['type'] != 0 ) {
			call_user_func( array( __CLASS__, self::$cellTemplateMethod ) );
		}
	}

	/*** cell templates ***/

	# setup a template for showresults=1
	# showresults=1 cellTemplate has only one variant
	static function cellTemplate1() {
		self::$cellTemplate =
			array(
				0 => array( '__tag' => 'div', 'class' => 'stats', 0 => &self::$cellTemplateParam['percents'] )
			);
		if ( isset( self::$showResults['color'] ) ) {
			self::$cellTemplate[0]['style'] = 'color:' . self::$showResults['color'] . ';';
		}
		if ( isset( self::$showResults['background'] ) ) {
			self::$cellTemplate[0]['style'] .= 'background:' . self::$showResults['background'] . ';';
		}
	}

	# transform input according to showresults=1 (numerical percents)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults1( $inp ) {
		self::$cellTemplateParam['percents'] = '&#160;';
		if ( ( $percents = $this->ctrl->getPercents( $this->proposalId, $this->catId ) ) !== false ) {
			# there is a stat in cell
			self::$cellTemplateParam['percents'] = $percents . '%';
			# template has to be rendered immediately, because self::$cellTemplateParam[] is
			# a pointer and thus, will always be overwritten
			return qp_Renderer::renderTagArray( self::$cellTemplate );
		} else {
			return '';
		}
	}

	# setup a template for showresults=2
	static function cellTemplate2() {
		# statical styles
		$percentstyle = '';
		if ( isset( self::$showResults['textcolor'] ) ) {
			$percentstyle = 'color:' . self::$showResults['textcolor'] . ';';
		}
		if ( isset( self::$showResults['textbackground'] ) ) {
			$percentstyle .= 'background-color:' . self::$showResults['textbackground'] . ';';
		}
		# has one available template ('bar')
		self::$cellTemplate = array(
			'bar' => array( '__tag' => 'div', 'class' => 'stats2',
				0 => array( '__tag' => 'div', 'class' => 'bar1', 'style' => &self::$cellTemplateParam['bar1style'], 0 => '&#160;' ),
				1 => array( '__tag' => 'div', 'class' => 'bar2', 'style' => &self::$cellTemplateParam['bar2style'], 0 => '&#160;' ),
				2 => array( '__tag' => 'div', 'class' => 'bar3', 'style' => $percentstyle, 0 => &self::$cellTemplateParam['percents'] )
			),
			# the following entries are not real templates, but pre-calculated values of css attributes taken from showresults parameter
			'bar1showres' => '',
			'bar2showres' => ''
		);
		# dynamical styles, width: in percents will be added during rendering in addShowResults
		if ( isset( self::$showResults['color'] ) ) {
			self::$cellTemplate['bar1showres'] .= 'background:' . self::$showResults['color'] . ';';
		}
		if ( isset( self::$showResults['background'] ) ) {
			self::$cellTemplate['bar2showres'] .= 'background:' . self::$showResults['background'] . ';';
		}
	}

	# transform input according to showresults=2 (bars)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults2( $inp ) {
		self::$cellTemplateParam['percents'] = '&#160;';
		if ( ( $percents = $this->ctrl->getPercents( $this->proposalId, $this->catId ) ) !== false ) {
			# there is a stat in cell
			self::$cellTemplateParam['percents'] = $percents . '%';
			self::$cellTemplateParam['bar1style'] = 'width:' . $percents . 'px;' . self::$cellTemplate[ 'bar1showres' ];
			self::$cellTemplateParam['bar2style'] = 'width:' . ( 100 - $percents ) . 'px;' . self::$cellTemplate[ 'bar2showres' ];
			return qp_Renderer::renderTagArray( self::$cellTemplate['bar'] );
		} else {
			return '';
		}
	}

	/*** end of cell templates ***/

} /* end of qp_QuestionStatsProposalView class */
