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
 * Stores question proposals views (see qp_qestion.php) and
 * allows to modify these for quizes results at the later stage (see qp_poll.php)
 * todo: transfer view logic completely from controllers
 */

class qp_TabularQuestionView extends qp_StubQuestionView {

	# display layout
	var $proposalsFirst = false;
	var $transposed = false;
	var $spanType = 'colspan';
	var $categoriesStyle = '';
	# used to indicate which classes should be used for drawing borders
	# around category spans eitherfor horizontal or vertical question layout
	# depends on transpose attribute
	var $signClass = '';
	var $proposalTextStyle = 'padding-left: 10px;';
	var $textInputStyle = '';

	# whether to show the current stats to the users
	# the following values are defined:
	# false - use value of pollShowResults, Array(0) - suppress, Array(1) - percents, Array(2) - bars
	var $showResults = false;
	var $pollShowResults;

	/**
	 * @param $parser
	 * @param $frame
	 * @param  $showResults     poll's showResults (may be overriden in the question)
	 */
	function __construct( Parser $parser, PPFrame $frame, $showResults ) {
		parent::__construct( $parser, $frame );
		$this->pollShowResults = $showResults;
	}

	static function newFromBaseView( $baseView ) {
		return new self( $baseView->parser, $baseView->ppframe, $baseView->showResults );
	}

	function setLayout( $layout, $textwidth ) {
		if ( $layout !== null ) {
			$this->transposed = strpos( $layout, 'transpose' ) !== false;
			$this->proposalsFirst = strpos( $layout, 'proposals' ) !== false;
		}
		# setup question layout parameters
		if ( $this->transposed ) {
			$this->spanType = 'rowspan';
			$this->categoriesStyle = 'text-align:left; vertical-align:middle; ';
			$this->signClass = array( 'first' => 'signt', 'middle' => 'signm', 'last' => 'signb' );
			$this->proposalTextStyle = 'text-align:center; padding-left: 5px; padding-right: 5px; ';
			$this->proposalTextStyle .= ( $this->proposalsFirst ) ? ' vertical-align: bottom;' : 'vertical-align:top;';
		} else {
			$this->spanType = 'colspan';
			$this->categoriesStyle = '';
			$this->signClass = array( 'first' => 'signl', 'middle' => 'signc', 'last' => 'signr' );
			$this->proposalTextStyle = 'vertical-align:middle; ';
			$this->proposalTextStyle .= ( $this->proposalsFirst ) ? 'padding-right: 10px;' : 'padding-left: 10px;';
		}
		if ( $textwidth !== null ) {
			$textwidth = intval( $textwidth );
			if ( $textwidth > 0 ) {
				$this->textInputStyle = 'width:' . $textwidth . 'em;';
			}
		}
	}

	function setShowResults( $showresults ) {
		# setup question's showresults when global showresults != 0
		if ( qp_Setup::$global_showresults != 0 && $showresults !== null ) {
			# use the value from the question
			$this->showResults = qp_AbstractPoll::parseShowResults( $showresults );
			# apply undefined attributes from the poll's showresults definition
			foreach ( $this->pollShowResults as $attr => $val ) {
				if ( $attr != 'type' && !isset( $this->showResults[$attr] ) ) {
					$this->showResults[$attr] = $val;
				}
			}
		} else {
			# use the value "inherited" from the poll
			$this->showResults = $this->pollShowResults;
		}
	}

	/**
	 * Checks, whether the supplied CSS length value is valid
	 * @return  boolean  true for valid value, false otherwise
	 */
	function isCSSLengthValid( $width ) {
		preg_match( '`^\s*(\d+)(px|em|%|)\s*$`', $width, $matches );
		return count( $matches > 1 ) && $matches[1] > 0;
	}

	function setPropWidth( $attr ) {
		if ( $attr !== null && $this->isCSSLengthValid( $attr ) ) {
			$this->propWidth = trim( $attr );
		}
		if ( $this->propWidth !== '' ) {
			$this->proposalTextStyle .= " width:{$this->propWidth};";
		}
	}

	/**
	 * Builds tagarray of categories
	 * @param     $categories  "raw" categories
	 */
	function buildCategoriesRow( array $categories ) {
		$row = array();
		if ( $this->proposalsFirst ) {
			// add empty <th> at the begin of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		foreach ( $categories as $cat ) {
			$row[] = $this->rtp( $cat['name'] );
		}
		if ( !$this->proposalsFirst ) {
			// add empty <th> at the end of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		return $row;
	}

	/**
	 * Builds tagarray of category spans
	 * @param   $categorySpans  "raw" spans
	 */
	function buildSpansRow( array $categorySpans ) {
		$row = array();
		if ( $this->proposalsFirst ) {
			// add empty <th> at the begin of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		foreach ( $categorySpans as &$span ) {
			$row[] = array( "count" => $span['count'], 0 => $this->rtp( $span['name'] ) );
		}
		if ( !$this->proposalsFirst ) {
			// add empty <th> at the end of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		return $row;
	}

	/**
	 * Adds category spans row to question's header views list
	 */
	function addSpanRow( $row ) {
		# apply categoriesStyle
		if ( $this->categoriesStyle != '' ) {
			qp_Renderer::applyAttrsToRow( $row, array( 'style' => $this->categoriesStyle ) );
		}
		$this->hviews[] = (object) array(
			'row' => $row,
			'className' => 'spans',
			'attribute_maps' => array( 'count' => $this->spanType, 'name' => 0 )
		);
	}

	/**
	 * Adds categories row to question's header views list
	 */
	function addCategoryRow( $row ) {
		# apply categoriesStyle
		if ( $this->categoriesStyle != '' ) {
			qp_Renderer::applyAttrsToRow( $row, array( 'style' => $this->categoriesStyle ) );
		}
		$this->hviews[] = (object) array(
			'row' => $row,
			'className' => 'categories',
			'attribute_maps' => array( 'name' => 0 )
		);
	}

	/**
	 * @param  $proposalId  int index of proposal
	 * @param  $propview    an instance of current proposal view
	 * @param  $row         array representation of html table row associated with current proposal
	 */
	function addProposal( $proposalId, qp_TabularQuestionProposalView $propview ) {
		$this->pviews[$proposalId] = $propview;
	}

	/**
	 * Render script-generated interpretation errors, when available (quiz mode)
	 */
	function renderInterpErrors() {
		if ( ( $interpErrors = $this->ctrl->getInterpErrors() ) === false ) {
			# there is no interpretation error
			return;
		}
		foreach ( $interpErrors as $prop_key => $prop_desc ) {
			if ( is_string( $prop_key ) ) {
				if ( ( $prop_id = $this->ctrl->getProposalIdByName( $prop_key ) ) === false ) {
					continue;
				}
			} elseif ( is_int( $prop_key ) ) {
				$prop_id = $prop_key;
			} else {
				continue;
			}
			if ( isset( $this->pviews[$prop_id] ) ) {
				# the whole proposal line has errors
				$propview = $this->pviews[$prop_id];
				if ( !is_array( $prop_desc ) ) {
					if ( !is_string( $prop_desc ) ) {
						$prop_desc = wfMsg( 'qp_interpetation_wrong_answer' );
					}
					$propview->prependErrorMessage( $prop_desc, '', false );
					$propview->rowClass = 'proposalerror';
					continue;
				}
				# specified category of proposal has errors;
				$foundCats = $propview->applyInterpErrors( $prop_desc );
				if ( !$foundCats ) {
					# there are category errors specified in interpretation result;
					# however none of them are found in proposal's view
					# generate error for the whole proposal
					$propview->prependErrorMessage( wfMsg( 'qp_interpetation_wrong_answer' ), '', false );
					$propview->rowClass = 'proposalerror';
				}
			}
		}
	}

	/**
	 * Renders question table with header and proposal views
	 */
	function renderTable() {
		$questionTable = array();
		# add header views to $questionTable
		$rowattrs = array();
		foreach ( $this->hviews as $header ) {
			$rowattrs['class'] = $header->className;
			if ( $this->transposed ) {
				qp_Renderer::addColumn( $questionTable, $header->row, $rowattrs, 'th', $header->attribute_maps );
			} else {
				qp_Renderer::addRow( $questionTable, $header->row, $rowattrs, 'th', $header->attribute_maps );
			}
		}
		# add proposal views to $questionTable
		ksort( $this->pviews );
		foreach ( $this->pviews as $propview ) {
			$row = &$propview->row;
			$rowattrs = array( 'class' => $propview->rowClass );
			$text = array( '__tag' => 'td', '__end' => "\n", 'class' => 'proposaltext', 'style' => $this->proposalTextStyle, 0 => $this->rtp( $propview->text ) );
			# insert proposal text to the beginning / end according to proposalsFirst property
			if ( $this->proposalsFirst ) {
				# first element is proposaltext
				array_unshift( $row, $text );
			} else {
				# last element is proposaltext
				$row[] = $text;
			}
			if ( $this->transposed ) {
				qp_Renderer::addColumn( $questionTable, $row, $rowattrs );
			} else {
				qp_Renderer::addRow( $questionTable, $row, $rowattrs );
			}
		}
		return $questionTable;
	}

	/**
	 * @return  boolean  true when the question's proposals views support showresults attribute;
	 *                   false otherwise
	 */
	function hasShowResults() {
		return $this->showResults['type'] > 0 && $this->showResults['type'] < 3;
	}

} /* end of qp_TabularQuestionView class */
