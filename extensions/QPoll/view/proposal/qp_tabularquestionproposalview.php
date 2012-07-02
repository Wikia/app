<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class qp_TabularQuestionProposalView extends qp_StubQuestionProposalView {

	# current row of tagarrays for categories of the question
	var $row = array();
	# text of current proposal (null means not found)
	var $text = null;

	# current (processed) category id
	var $catId;

	# current state of border drawing logic around category spans
	# todo: watch whether the state should be transferred to the next row
	static $spanState;

	/**
	 * Called for every proposal of the question
	 *
	 * We are type hinting for qp_AbstractQuestion instead of qp_StubQuestion
	 * because qp_QuestionStats derives directly from qp_AbstractQuestion
	 * todo: isn't it better to derive qp_QuestionStats from qp_StubQuestion ?
	 *
	 */
	function __construct( $proposalId, qp_AbstractQuestion $ctrl ) {
		parent::__construct( $proposalId, $ctrl );
	}

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

	/**
	 * Initializes new category tagarray entry
	 * set current (processed) category id
	 * @param  $catId  int category id
	 */
	function addNewCategory( $catId ) {
		$this->catId = $catId;
		$this->row[$catId] = array();
	}

	function resetSpanState() {
		# no category span border by default
		self::$spanState->className = 'sign';
	}

	function spanWasChecked( $checked ) {
		self::$spanState->wasChecked = $checked;
	}

	/**
	 * Applies current border style to the current category cell
	 * @param  $catId  int category id
	 */
	function setCategorySpan() {
		qp_Renderer::addClass( $this->row[$this->catId], self::$spanState->className );
	}

	/**
	 * Applies CSS class to all of the category cells
	 * @param  $className  string  CSS class name
	 */
	function addCellsClass( $className ) {
		foreach ( $this->row as &$cell ) {
			qp_Renderer::addClass( $cell, $className );
		}
	}

	/**
	 * Initializes current category tagarray (category "viewtoken")
	 * @param $tagarray  array of tags to render
	 */
	function setCat( $tagarray ) {
		if ( self::$showResults['type'] != 0 ) {
			# there ars some stat in row;
			# not necessarily all cells, because size of question table changes dynamically
			$this->row[$this->catId][0] = $this->{ self::$showResultsMethod }( $tagarray );
		} else {
			$this->row[$this->catId][0] = $tagarray;
		}
	}

	/**
	 * Prepend error message to proposal text
	 * @param    $msg - text of message
	 * @param    $state - set new question controller state
	 *               note that the 'error' state cannot be changed and '' state cannot be set
	 * @param    $rowClass - string set rowClass value, boolean false (do not set)
	 */
	function prependErrorMessage( $msg, $state, $rowClass = 'proposalerror' ) {
		$this->text = $this->ctrl->view->bodyErrorMessage( $msg, $state, $rowClass ) . $this->text;
	}

	/**
	 * Prepend error message to proposal text
	 * @param    $msg - text of message
	 * @param    $state - set new question controller state
	 *               note that the 'error' state cannot be changed and '' state cannot be set
	 * @param    $rowClass - string set rowClass value, boolean false (do not set)
	 */
	function setErrorMessage( $msg, $state, $rowClass = 'proposalerror' ) {
		$this->text = $this->ctrl->view->bodyErrorMessage( $msg, $state, $rowClass );
	}

	/**
	 * Draws borders via css in the question table for current processed category
	 * according to controller's category spans (metacategories)
	 *
	 * todo: figure out how to split it into smaller parts
	 */
	function renderSpan( &$name, $value, $catDesc ) {
		$spanState = &self::$spanState;
		if ( array_key_exists( 'spanId', $catDesc ) ) {
			$spanState->id = $catDesc[ 'spanId' ];
			$name .= 's' . $spanState->id;
			# there can't be more category spans than the categories
			if ( $this->ctrl->mCategorySpans[ $spanState->id ]['count'] > count( $this->ctrl->mCategories ) ) {
				$this->prependErrorMessage( wfMsg( 'qp_error_too_many_spans' ), 'error' );
				$this->rowClass = 'proposalerror';
			}
			if ( $spanState->prevId != $spanState->id ) {
				# begin of new span
				$spanState->wasChecked = false;
				$spanState->prevId = $spanState->id;
				$spanState->cellsLeft = $this->ctrl->mCategorySpans[ $spanState->id ]['count'];
				if ( $spanState->cellsLeft < 2 ) {
					$this->prependErrorMessage( wfMsg( 'qp_error_too_few_spans' ), 'error' );
					qp_Renderer::addClass( $this->row[$this->catId], 'error' );
				}
				$spanState->isDrawing = $spanState->cellsLeft != 1 && $spanState->cellsLeft != count( $this->ctrl->mCategories );
				# hightlight only spans of count != 1 and count != count(categories)
				if ( $spanState->isDrawing ) {
					$spanState->className = self::$signClass[ 'first' ];
				}
			} else {
				$spanState->cellsLeft--;
				if ( $spanState->isDrawing ) {
					$spanState->className = ( $spanState->cellsLeft > 1 ) ? self::$signClass[ 'middle' ] : self::$signClass[ 'last' ];
				}
			}
		}
		# todo: figure out how to split this part to separate function
		# this part is unneeded for question stats controller,
		# which should never have $this->ctrl->poll->mBeingCorrected === true
		if ( $spanState->cellsLeft <= 1 ) {
			# end of new span
			if ( $this->ctrl->poll->mBeingCorrected &&
					!$spanState->wasChecked &&
					qp_Setup::$request->getVal( $name ) != $value ) {
				# the span (a part of proposal) was submitted but unanswered
				$this->prependErrorMessage( wfMsg( 'qp_error_unanswered_span' ), 'NA' );
				# highlight current span to indicate an error
				for ( $i = $this->catId, $j = $this->ctrl->mCategorySpans[ $spanState->id ]['count']; $j > 0; $i--, $j-- ) {
					qp_Renderer::addClass( $this->row[$i], 'error' );
				}
				$this->rowClass = 'proposalerror';
			}
		}
	}

	/**
	 * Applies interpretation script category error messages
	 * to the current proposal line.
	 * @param   $prop_desc  array
	 *          keys are category numbers (indexes)
	 *          values are interpretation script-generated error messages
	 * @return  boolean true when at least one category was found in the list
	 *          false otherwise
	 */
	function applyInterpErrors( array $prop_desc ) {
		$foundCats = false;
		# scan the category views row to highlight erroneous categories
		foreach ( $this->row as $cat_id => &$cat_tag ) {
			# only integer keys are the category views
			if ( is_int( $cat_id ) && isset( $prop_desc[$cat_id] ) ) {
				# found a category which has script-generated error
				$foundCats = true;
				# whether to use custom or standard error message
				if ( !is_string( $cat_desc = $prop_desc[$cat_id] ) ) {
					$cat_desc = wfMsg( 'qp_interpetation_wrong_answer' );
				}
				# highlight the input
				qp_Renderer::addClass( $cat_tag, 'cat_error' );
				array_unshift( $cat_tag, $this->ctrl->view->bodyErrorMessage( $cat_desc, '', false ) . '<br />' );
			}
		}
		return $foundCats;
	}

	/*** cell templates ***/

	# cell templates for the selected showresults
	static $cellTemplate = array();
	static $cellTemplateParam = array( 'inp' => '', 'percents' => '', 'bar1style' => '', 'bar2style' => '' );

	# setup a template for showresults=1
	# showresults=1 cellTemplate has only one variant
	static function cellTemplate1() {
		self::$cellTemplate =
			array(
				0 => array( '__tag' => 'div', 0 => &self::$cellTemplateParam['inp'] ),
				1 => array( '__tag' => 'div', 'class' => 'stats', 0 => &self::$cellTemplateParam['percents'] )
			);
		if ( isset( self::$showResults['color'] ) ) {
			self::$cellTemplate[1]['style'] = 'color:' . self::$showResults['color'] . ';';
		}
		if ( isset( self::$showResults['background'] ) ) {
			self::$cellTemplate[1]['style'] .= 'background:' . self::$showResults['background'] . ';';
		}
	}

	# transform input according to showresults=1 (numerical percents)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults1( $inp ) {
		self::$cellTemplateParam['inp'] = $inp;
		self::$cellTemplateParam['percents'] = '&#160;';
		if ( ( $percents = $this->ctrl->getPercents( $this->proposalId, $this->catId ) ) !== false ) {
			# there is a stat in cell
			self::$cellTemplateParam['percents'] = $percents . '%';
			# template has to be rendered immediately, because self::$cellTemplateParam[] is
			# a pointer and thus, will always be overwritten
			return qp_Renderer::renderTagArray( self::$cellTemplate );
		} else {
			return $inp;
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
		# html arrays used in templates below
		$bar = array( '__tag' => 'div', 'class' => 'stats1',
			0 => array( '__tag' => 'div', 'class' => 'bar0', 0 => &self::$cellTemplateParam['inp'] ),
			1 => array( '__tag' => 'div', 'class' => 'bar1', 'style' => &self::$cellTemplateParam['bar1style'], 0 => '&#160;' ),
			2 => array( '__tag' => 'div', 'class' => 'bar2', 'style' => &self::$cellTemplateParam['bar2style'], 0 => '&#160;' ),
			3 => array( '__tag' => 'div', 'class' => 'bar0', 'style' => $percentstyle, 0 => &self::$cellTemplateParam['percents'] )
		);
		$bar2 = array( '__tag' => 'div', 'class' => 'stats1',
			0 => array( '__tag' => 'div', 'class' => 'bar0', 0 => '&#160;' ),
			1 => &$bar[1],
			2 => &$bar[2],
			3 => &$bar[3]
		);
		# has two available templates ('bar','textinput')
		self::$cellTemplate = array(
			'bar' => $bar,
			'textinput' => array( '__tag' => 'table', 'class' => 'stats',
				0 => array( '__tag' => 'tr',
					0 => array( '__tag' => 'td', 0 => &self::$cellTemplateParam['inp'] ),
				),
				1 => array( '__tag' => 'tr',
					0 => array( '__tag' => 'td',
						0 => $bar2
					)
				)
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
		self::$cellTemplateParam['inp'] = $inp;
		self::$cellTemplateParam['percents'] = '&#160;';
		if ( ( $percents = $this->ctrl->getPercents( $this->proposalId, $this->catId ) ) !== false ) {
			# there is a stat in cell
			self::$cellTemplateParam['percents'] = $percents . '%';
			self::$cellTemplateParam['bar1style'] = 'width:' . $percents . 'px;' . self::$cellTemplate[ 'bar1showres' ];
			self::$cellTemplateParam['bar2style'] = 'width:' . ( 100 - $percents ) . 'px;' . self::$cellTemplate[ 'bar2showres' ];
			if ( $inp['type'] == 'text' ) {
				return qp_Renderer::renderTagArray( self::$cellTemplate['textinput'] );
			} else {
				return qp_Renderer::renderTagArray( self::$cellTemplate['bar'] );
			}
		} else {
			return $inp;
		}
	}
	/*** end of cell templates ***/

} /* end of qp_TabularQuestionProposalView class */
