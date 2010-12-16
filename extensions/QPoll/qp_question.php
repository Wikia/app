<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

abstract class qp_AbstractQuestion {

	var $parser; // an instance of parser from parser tag hook
	var $mState = ''; // current state of question parsing (no error)
	# error message which occured during the question header parsing that will be output later at rendering stage
	var $headerErrorMessage = 'Unknown error';
	# default type and subtype of the question; should always be properly initialized in $this->parseParameters();
	var $mType = 'unknown';
	var $mSubType = ''; // some questions has a subtype, see $this->parseParameters()
	var $mCategories = Array();
	var $mCategorySpans = Array();
	var $mCommonQuestion; // GET common question of the poll
	var $mProposalText = Array(); // an array of question proposals
	var $mBeingCorrected = false; // true, when user is posting this question via the poll's form
	var $alreadyVoted = false; // whether the selected user has already voted this question ?

	# whether to show the current stats to the users
	# the following values are defined:
	# false - use value of pollShowResults, Array(0) - suppress, Array(1) - percents, Array(2) - bars
	var $showResults = false;
	var $pollShowResults;
	// display layout
	var $proposalsFirst = false;
	var $transposed = false;
	var $spanType = 'colspan';
	var $categoriesStyle = '';
	var $proposalTextStyle = 'padding-left: 10px;';
	var $textInputStyle = '';
	// statistics
	var $Percents = null;
	var $mRenderTable = Array();

	# Constructor
	# @public
	# @param  $parser an instance of parser from parser tag hook
	# @param  $beingCorrected		boolean
	# @param  $questionId				the identifier of the question used to gernerate input names
	# @param  $showResults				poll's showResults (may be overriden in the question)
	function __construct( &$parser, $beingCorrected, $questionId, $showResults ) {
		global $wgRequest;
		$this->parser = &$parser;
		$this->mRequest = &$wgRequest;
		$this->mQuestionId = $questionId;
		$this->mBeingCorrected = $beingCorrected;
		$this->pollShowResults = $showResults;
		$this->mProposalPattern = '`^[^\|\!].*`u';
		$this->mCategoryPattern 	= '`^\|(\n|[^\|].*\n)`u';
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
			# store header error message that cannot be output now, but will be displayed at later stage
			$this->headerErrorMessage = $error_message;
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

	function getHeaderError() {
		return '<div class="proposalerror">' . $this->headerErrorMessage . '</div>';
	}

	# outputs question body parser error/warning message
	# @param    $msg - text of message
	# @param    $state - sets new question state (note that the 'error' state cannot be changed)
	function bodyErrorMessage( $msg, $state ) {
		$prev_state = $this->getState();
		$this->setState( $state );
		# return the message only for the first error occured
		# (this one has to be short, that's why title attribute is being used)
		return ( $prev_state == '' ) ? '<span class="proposalerror" title="' . $msg . '">???</span> ' : '';
	}

	# builds internal & visual representation of question attributes (all attributes but type)
	# @param   $attr_str - source text with question attributes
	# @return  string : type of the question, empty when not defined
	function parseAttributes( $attr_str ) {
		global $qp_enable_showresults;
		$paramkeys = array( 't[yi]p[eo]' => null, 'layout' => null, 'textwidth' => null, 'showresults' => null );
		foreach ( $paramkeys as $key => &$val ) {
			preg_match( '`' . $key . '?="(.*?)"`u', $attr_str, $val );
		}
		$type = $paramkeys[ 't[yi]p[eo]' ];
		$type = isset( $type[1] ) ? trim( $type[1] ) : '';
		$layout = $paramkeys[ 'layout' ];
		$textwidth = $paramkeys[ 'textwidth' ];
		$showresults = $paramkeys[ 'showresults' ];
		if ( count( $layout ) > 0 ) {
			$this->transposed = strpos( $layout[1], 'transpose' ) !== false;
			$this->proposalsFirst = strpos( $layout[1], 'proposals' ) !== false;
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
		if ( count( $textwidth ) > 0 ) {
			$textwidth = intval( $textwidth[1] );
			if ( $textwidth > 0 ) {
				$this->textInputStyle = 'width:' . $textwidth . 'em;';
			}
		}
		# setup showresults
		if ( $qp_enable_showresults != 0 && count( $showresults ) > 0 ) {
			# use the value from the question
			$this->showResults = qp_AbstractPoll::parse_ShowResults( $showresults[1] );
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
		# initialize cell template for the selected showresults
		# this can be moved to {$this->mType}ParseBody in the future,
		# if needed to setup templates depending on question type
		# right now, cell templates depends only on input type and showresults type
		if ( $this->showResults['type'] != 0 ) {
			$this-> { 'cellTemplate' . $this->showResults['type'] } ();
		}
		return $type;
	}

	function addRow( $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		if ( $this->transposed ) {
			qp_Renderer::addColumn( $this->mRenderTable, $row, $rowattrs, $celltag, $attribute_maps );
		} else {
			qp_Renderer::addRow( $this->mRenderTable, $row, $rowattrs, $celltag, $attribute_maps );
		}
	}

	# function to draw borders via css in the question table according to category spans (metacategories)
	function renderSpan( &$name, $catDesc, &$text, &$rawClass, &$spanState ) {
		if ( array_key_exists( 'spanId', $catDesc ) ) {
			$spanState->id = $catDesc[ 'spanId' ];
			$name .= 's' . $spanState->id;
			# there can't be more category spans than the categories
			if ( $this->mCategorySpans[ $spanState->id ]['count'] > count( $this->mCategories ) ) {
				$text = $this->bodyErrorMessage( wfMsg( 'qp_error_too_many_spans' ), 'error' ) . $text;
				$rawClass = 'proposalerror';
			}
			if ( $spanState->prevId != $spanState->id ) {
				# begin of new span
				$spanState->wasChecked = false;
				$spanState->prevId = $spanState->id;
				$spanState->cellsLeft = $this->mCategorySpans[ $spanState->id ]['count'];
				if ( $spanState->cellsLeft < 2 ) {
					$text = $this->bodyErrorMessage( wfMsg( 'qp_error_too_few_spans' ), 'error' ) . $text;
					$row[ $catId ][ 'style' ] = QP_CSS_ERROR_STYLE;
				}
				$spanState->isDrawing = $spanState->cellsLeft != 1 && $spanState->cellsLeft != count( $this->mCategories );
				# hightlight only spans of count != 1 and count != count(categories)
				if ( $spanState->isDrawing ) {
					$spanState->className = $this->signClass[ 'first' ];
				}
			} else {
				$spanState->cellsLeft--;
				if ( $spanState->isDrawing ) {
					$spanState->className = ( $spanState->cellsLeft > 1 ) ? $this->signClass[ 'middle' ] : $this->signClass[ 'last' ];
				}
			}
		}
	}

	function getPercents( $proposalId, $catId ) {
		if ( is_array( $this->Percents ) && array_key_exists( $proposalId, $this->Percents ) &&
					is_array( $this->Percents[ $proposalId ] ) && array_key_exists( $catId, $this->Percents[ $proposalId ] ) ) {
			return intval( round( 100 * $this->Percents[ $proposalId ][ $catId ] ) );
		} else {
			return false;
		}
	}

}

/* parsing, checking ans visualisation of Question in statistical display mode (UI input/output)
 */
class qp_QuestionStats extends qp_AbstractQuestion {

	# Constructor
	# @public
	# @param  $parser an instance of parser from parser tag hook
	# @param  $type							type of question (taken from DB)
	# @param  $questionId				the identifier of the question used to gernerate input names
	# @param  $showResults			poll's showResults (may be overriden in the question)
	function __construct( &$parser, $type, $questionId, $showResults ) {
		parent::__construct( $parser, false, $questionId, $showResults );
		$this->mType = $type;
	}

	# load some question fields from qp_QuestionData given
	# (usually qp_QuestionData is an array property of qp_PollStore instance)
	# @param  $qdata - an instance of qp_QuestionData
	function loadAnswer( qp_QuestionData &$qdata ) {
		$this->alreadyVoted = $qdata->alreadyVoted;
		$this->mCommonQuestion = $qdata->CommonQuestion;
		$this->mProposalText = $qdata->ProposalText;
		$this->mCategories = $qdata->Categories;
		$this->mCategorySpans = $qdata->CategorySpans;
		if ( isset( $qdata->Percents ) && is_array( $qdata->Percents ) ) {
			$this->Percents = $qdata->Percents;
		} else {
			# no percents - no stats
			$this->showResults = Array( 'type' => 0 );
		}
	}

	# populates an instance of qp_Question with data from qp_QuestionData
	# input: the object of type qp_Question
	function getQuestionAnswer( qp_PollStore &$pollStore ) {
		if ( $pollStore->pid !== null ) {
			if ( $pollStore->questionExists( $this->mQuestionId ) ) {
				$qdata = $pollStore->Questions[ $this->mQuestionId ];
				$this->loadAnswer( $qdata );
				return true;
			}
		}
		return false;
	}

	function parseCategories() {
		$row = Array();
		if ( $this->proposalsFirst ) {
			// add empty <th> at the begin of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		foreach ( $this->mCategories as &$cat ) {
			$row[] = $this->parser->recursiveTagParse( $cat['name'] );
		}
		if ( !$this->proposalsFirst ) {
			// add empty <th> at the end of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		return $row;
	}

	function parseCategorySpans() {
		$row = Array();
		if ( $this->mType == 'singleChoice' ) {
			# real category spans have sense only for radiobuttons
			if ( $this->proposalsFirst ) {
				// add empty <th> at the begin of row to "compensate" proposal text
				$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
			}
			foreach ( $this->mCategorySpans as &$span ) {
				$row[] = array( "count" => $span['count'], 0 => $this->parser->recursiveTagParse( $span['name'] ) );
			}
			if ( !$this->proposalsFirst ) {
				// add empty <th> at the end of row to "compensate" proposal text
				$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
			}
		}
		return $row;
	}

	function renderStats() {
		if ( $this->getState() == 'error' ) {
			return $this->getHeaderError();
		}
		$catRow = $this->parseCategories();
		if ( count( $this->mCategorySpans ) > 0 ) {
			$spansRow = $this->parseCategorySpans();
			# if there are multiple spans, "turn on" borders for span and category cells
			if ( count( $this->mCategorySpans ) > 1 ) {
				$this->categoriesStyle .= 'border:1px solid gray;';
			}
			if ( $this->categoriesStyle != '' ) {
				qp_Renderer::applyAttrsToRow( $spansRow, array( 'style' => $this->categoriesStyle ) );
			}
			$this->addRow( $spansRow, array( 'class' => 'spans' ), 'th', array( 'count' => $this->spanType, 'name' => 0 ) );
		}
		if ( $this->categoriesStyle != '' ) {
			qp_Renderer::applyAttrsToRow( $catRow, array( 'style' => $this->categoriesStyle ) );
		}
		$this->addRow( $catRow, array( 'class' => 'categories' ), 'th', array( 'name' => 0 ) );
		foreach ( $this->mProposalText as $proposalId => $text ) {
			$row = Array();
			$rawClass = 'proposal';
			$spanState = (object) array( 'id' => 0, 'prevId' => -1, 'wasChecked' => true, 'isDrawing' => false, 'cellsLeft' => 0, 'className' => 'sign' );
			foreach ( $this->mCategories as $catId => $catDesc ) {
				$row[ $catId ] = Array();
				$spanState->className = 'sign';
				switch ( $this->mType ) {
				case 'singleChoice' :
					# category spans have sense only with single choice proposals
					$this->renderSpan( $name, $catDesc, $text, $rawClass, $spanState );
					break;
				}
				$row[ $catId ][ 'class' ] = $spanState->className;
				if ( $this->showResults['type'] != 0 ) {
					# there ars some stat in row (not necessarily all cells, because size of question table changes dynamically)
					$row[ $catId ][ 0 ] = $this-> { 'addShowResults' . $this->showResults['type'] } ( $proposalId, $catId );
				} else {
					$row[ $catId ][ 0 ] = '';
				}
			}
			$text = array( '__tag' => 'td', '__end' => "\n", 'class' => 'proposaltext', 'style' => $this->proposalTextStyle, 0 => $this->parser->recursiveTagParse( $text ) );
			if ( $this->proposalsFirst ) {
				# first element is proposaltext
				array_unshift( $row, $text );
			} else {
				# last element is proposaltext
				$row[] = $text;
			}
			$this->addRow( $row, array( 'class' => $rawClass ), 'td' );
		}
		return qp_Renderer::renderHTMLobject( $this->mRenderTable );
	}

	/*** cell templates ***/

	# cell templates for the selected showresults
	var $cellTemplate = Array();
	var $cellTemplateParam = Array( 'percents' => '', 'bar1style' => '', 'bar2style' => '' );

	# setup a template for showresults=1
	# showresults=1 cellTemplate has only one variant
	function cellTemplate1() {
		$this->cellTemplate =
			array(
				0 => array( '__tag' => 'div', 'class' => 'stats', 0 => &$this->cellTemplateParam['percents'] )
			);
		if ( isset( $this->showResults['color'] ) ) {
			$this->cellTemplate[0]['style'] = 'color:' . $this->showResults['color'] . ';';
		}
		if ( isset( $this->showResults['background'] ) ) {
			$this->cellTemplate[0]['style'] .= 'background:' . $this->showResults['background'] . ';';
		}
	}

	# transform input according to showresults=1 (numerical percents)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults1( $proposalId, $catId ) {
		$this->cellTemplateParam['percents'] = '&nbsp;';
		if ( ( $percents = $this->getPercents( $proposalId, $catId ) ) !== false ) {
			# there is a stat in cell
			$this->cellTemplateParam['percents'] = $percents . '%';
			# template has to be rendered immediately, because $this->cellTemplateParam[] are used as pointers and thus,
			# will always be overwritten
			return QP_Renderer::renderHTMLobject( $this->cellTemplate );
		} else {
			return '';
		}
	}

	# setup a template for showresults=2
	function cellTemplate2() {
		# statical styles
		$percentstyle = '';
		if ( isset( $this->showResults['textcolor'] ) ) {
			$percentstyle = 'color:' . $this->showResults['textcolor'] . ';';
		}
		if ( isset( $this->showResults['textbackground'] ) ) {
			$percentstyle .= 'background:' . $this->showResults['textbackground'] . ';';
		}
		# has one available template ('bar')
		$this->cellTemplate = array(
			'bar' => array( '__tag' => 'div', 'class' => 'stats2',
				0 => array( '__tag' => 'div', 'class' => 'bar1', 'style' => &$this->cellTemplateParam['bar1style'], 0 => '&nbsp;' ),
				1 => array( '__tag' => 'div', 'class' => 'bar2', 'style' => &$this->cellTemplateParam['bar2style'], 0 => '&nbsp;' ),
				2 => array( '__tag' => 'div', 'class' => 'bar3', 'style' => $percentstyle, 0 => &$this->cellTemplateParam['percents'] )
			),
			# the following entries are not real templates, but pre-calculated values of css attributes taken from showresults parameter
			'bar1showres' => '',
			'bar2showres' => ''
		);
		# dynamical styles, width: in percents will be added during rendering in addShowResults
		if ( isset( $this->showResults['color'] ) ) {
			$this->cellTemplate['bar1showres'] .= 'background:' . $this->showResults['color'] . ';';
		}
		if ( isset( $this->showResults['background'] ) ) {
			$this->cellTemplate['bar2showres'] .= 'background:' . $this->showResults['background'] . ';';
		}
	}

	# transform input according to showresults=2 (bars)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults2( $proposalId, $catId ) {
		$this->cellTemplateParam['percents'] = '&nbsp;';
		if ( ( $percents = $this->getPercents( $proposalId, $catId ) ) !== false ) {
			# there is a stat in cell
			$this->cellTemplateParam['percents'] = $percents . '%';
			$this->cellTemplateParam['bar1style'] = 'width:' . $percents . 'px;' . $this->cellTemplate[ 'bar1showres' ];
			$this->cellTemplateParam['bar2style'] = 'width:' . ( 100 - $percents ) . 'px;' . $this->cellTemplate[ 'bar2showres' ];
			return qp_Renderer::renderHTMLobject( $this->cellTemplate['bar'] );
		} else {
			return '';
		}
	}

	/*** end of cell templates ***/

}

/* parsing, checking ans visualisation of Question in declaration/voting mode (UI input/output)
 */
class qp_Question extends qp_AbstractQuestion {

	# current user voting taken from POST data (if available)
	var $mProposalCategoryId = Array(); // user true/false answers to the question's proposal
	var $mProposalCategoryText = Array(); // user text answers to the question's proposal
	# previous user voting (if available) taken from DB
	var $mPrevProposalCategoryId = Array(); // user true/false answers to the question's proposal from DB
	var $mPrevProposalCategoryText = Array(); // user text answers to the question's proposal from DB

	# load some question fields from qp_QuestionData given
	# (usually qp_QuestionData is an array property of qp_PollStore instance)
	# @param   $qdata - an instance of qp_QuestionData
	function loadAnswer( qp_QuestionData &$qdata ) {
		$this->alreadyVoted = $qdata->alreadyVoted;
		$this->mPrevProposalCategoryId = $qdata->ProposalCategoryId;
		$this->mPrevProposalCategoryText = $qdata->ProposalCategoryText;
		if ( isset( $qdata->Percents ) && is_array( $qdata->Percents ) ) {
			$this->Percents = $qdata->Percents;
		} else {
			# no percents - no stats
			$this->showResults = Array( 'type' => 0 );
		}
	}

	# populates an instance of qp_Question with data from qp_QuestionData
	# @param   the object of type qp_Question
	function getQuestionAnswer( qp_PollStore &$pollStore ) {
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

	# checks, whether user had previousely selected the category of the proposal of this question
	# returns true/false for 'checkbox' and 'radio' inputTypes
	# text string/false for 'text' inputType
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

	# store the proper (checked) Question
	# creates new qp_QuestionData in the given poll store
	# and places it into the poll store Questions[] collection
	# @param   the object of type qp_PollStore
	function store( qp_PollStore &$pollStore ) {
		if ( $pollStore->pid !== null ) {
			$pollStore->Questions[ $this->mQuestionId ] = new qp_QuestionData( array(
				'from' => 'postdata',
				'type' => $this->mType,
				'common_question' => $this->mCommonQuestion,
				'categories' => $this->mCategories,
				'category_spans' => $this->mCategorySpans,
				'proposal_text' => $this->mProposalText,
				'proposal_category_id' => $this->mProposalCategoryId,
				'proposal_category_text' => $this->mProposalCategoryText ) );
		}
	}

	# parses question main header (common question and XML attributes)
	# initializes common question and question type/subtype
	# @param  $input				the question's header in QPoll syntax
	#
	# internally, the header is split into
	#   main header (part inside curly braces) and
	#   body header (categories and metacategories defitions)
	#
	function parseMainHeader( $header ) {
		# split common question and question attributes from the header
		list( $common_question, $attr_str ) = preg_split( '`\n\|([^\|].*)\s*$`u', $header, -1, PREG_SPLIT_DELIM_CAPTURE );
		$this->mCommonQuestion = trim( $common_question );
		$type = $this->parseAttributes( $attr_str );
		# set question type property
		# select the question type and subtype corresponding to the header 'type' attribute
		switch ( $type ) {
		case 'unique()':
			$this->mSubType = 'unique';
			$this->mType = 'singleChoice';
			break;
		case '()':
			$this->mType = 'singleChoice';
			break;
		case '[]':
			$this->mType = 'multipleChoice';
			break;
		case 'mixed' :
			$this->mType = 'mixedChoice';
			break;
		default :
			$this->setState( 'error', wfMsg( 'qp_error_invalid_question_type', qp_Setup::entities( $type ) ) );
		}
	}

	# build categories and spans internal & visual representations according to
	# definition of categories and spans (AKA metacategories) in the question body
	# @param   $input - the text of question body
	#
	# internally, the header is split into
	#   main header (part inside curly braces) and
	#   body header (categories and metacategories defitions)
	#
	function parseBodyHeader( $input ) {
		$this->raws = preg_split( '`\n`su', $input, -1, PREG_SPLIT_NO_EMPTY );
		if ( array_key_exists( 1, $this->raws ) ) {
			$categorySpans = preg_match( $this->mCategoryPattern, $this->raws[1] . "\n", $matches );
		}
		if ( !$categorySpans && array_key_exists( 0, $this->raws ) ) {
			preg_match( $this->mCategoryPattern, $this->raws[0] . "\n", $matches );
		}
		# parse the header - spans and categories
		$catString = isset( $matches[1] ) ? $matches[1] : '';
		$catRow = $this->parseCategories( $catString );
		if ( $categorySpans ) {
			$spansRow = $this->parseCategorySpans( $this->raws[0] );
			# if there are multiple spans, "turn on" borders for span and category cells
			if ( count( $this->mCategorySpans ) > 1 ) {
				$this->categoriesStyle .= 'border:1px solid gray;';
			}
			if ( $this->categoriesStyle != '' ) {
				qp_Renderer::applyAttrsToRow( $spansRow, array( 'style' => $this->categoriesStyle ) );
			}
			$this->addRow( $spansRow, array( 'class' => 'spans' ), 'th', array( 'count' => $this->spanType, 'name' => 0 ) );
		}
		if ( $this->categoriesStyle != '' ) {
			qp_Renderer::applyAttrsToRow( $catRow, array( 'style' => $this->categoriesStyle ) );
		}
		$this->addRow( $catRow, array( 'class' => 'categories' ), 'th', array( 'name' => 0 ) );
	}

	function singleChoiceParseBody() {
		$this->questionParseBody( "radio" );
		return qp_Renderer::renderHTMLobject( $this->mRenderTable );
	}

	function multipleChoiceParseBody() {
		$this->questionParseBody( "checkbox" );
		return qp_Renderer::renderHTMLobject( $this->mRenderTable );
	}

	function questionParseBody( $inputType ) {
		# Parameters used in some special cases.
		$proposalId = -1;
		foreach ( $this->raws as $raw ) {
			if ( !preg_match( $this->mProposalPattern, $raw, $matches ) ) {
				continue;
			}
			# empty proposal text and row
			$text = null;
			$row = Array();
			$proposalId++;
			$rawClass = 'proposal';
			$text = array_pop( $matches );
			$this->mProposalText[ $proposalId ] = trim( $text );
			$spanState = (object) array( 'id' => 0, 'prevId' => -1, 'wasChecked' => true, 'isDrawing' => false, 'cellsLeft' => 0, 'className' => 'sign' );
			foreach ( $this->mCategories as $catId => $catDesc ) {
				$row[ $catId ] = Array();
				$inp = Array( '__tag' => 'input' );
				$spanState->className = 'sign';
				# Determine the input's name and value.
				switch( $this->mType ) {
				case 'multipleChoice':
					$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
					$value = 's' . $catId;
					break;
				case 'singleChoice':
					$name = 'q' . $this->mQuestionId . 'p' . $proposalId;
					$value = 's' . $catId;
					# category spans have sense only with single choice proposals
					$this->renderSpan( $name, $catDesc, $text, $rawClass, $spanState );
					if ( $spanState->cellsLeft <= 1 ) {
						# end of new span
						if ( $this->mBeingCorrected &&
								!$spanState->wasChecked &&
								$this->mRequest->getVal( $name ) != $value ) {
							# the span (a part of proposal) was submitted but unanswered
							$text = $this->bodyErrorMessage( wfMsg( 'qp_error_unanswered_span' ), 'NA' ) . $text;
							# highlight current span to indicate an error
							for ( $i = $catId, $j = $this->mCategorySpans[ $spanState->id ]['count']; $j > 0; $i--, $j-- ) {
								$row[$i][ 'style' ] = QP_CSS_ERROR_STYLE;
							}
							$rawClass = 'proposalerror';
						}
					}
					break;
				}
				# Determine if the input had to be checked.
				if ( $this->mBeingCorrected && $this->mRequest->getVal( $name ) == $value ) {
					$inp[ 'checked' ] = 'checked';
				}
				if ( $this->answerExists( $inputType, $proposalId, $catId ) !== false ) {
					$inp[ 'checked' ] = 'checked';
				}
				if ( array_key_exists( 'checked', $inp ) ) {
					if ( $this->mSubType == 'unique' ) {
						if ( $this->mBeingCorrected && !$this->isUniqueProposalCategoryId( $proposalId, $catId ) ) {
							$text = $this->bodyErrorMessage( wfMsg( 'qp_error_non_unique_choice' ), 'NA' ) . $text;
							$rawClass = 'proposalerror';
							unset( $inp[ 'checked' ] );
							$row[ $catId ][ 'style' ] = QP_CSS_ERROR_STYLE;
						}
					} else {
						$spanState->wasChecked = true;
					}
				}
				if ( array_key_exists( 'checked', $inp ) ) {
					# add category to the list of user answers for current proposal (row)
					$this->mProposalCategoryId[ $proposalId ][] = $catId;
					$this->mProposalCategoryText[ $proposalId ][] = '';
				}
				$row[ $catId ][ 'class' ] = $spanState->className;
				if ( $this->mSubType == 'unique' ) {
					# unique (question,category,proposal) "coordinate" for javascript
					$inp[ 'id' ] = 'uq' . $this->mQuestionId . 'c' . $catId . 'p' . $proposalId;
					# If type='unique()' question has more proposals than categories, such question is impossible to complete
					if ( count( $this->mProposalText ) > count( $this->mCategories ) ) {
						# if there was no previous errors, hightlight the whole row
						if ( $this->getState() == '' ) {
							foreach ( $row as &$cell ) {
								$cell[ 'style' ] = QP_CSS_ERROR_STYLE;
							}
						}
						$text = $this->bodyErrorMessage( wfMsg( 'qp_error_unique' ), 'error' ) . $text;
						$rawClass = 'proposalerror';
					}
				}
				$inp[ 'class' ] = 'check';
				$inp[ 'type' ] = $inputType;
				$inp[ 'name' ] = $name;
				$inp[ 'value' ] = $value;
				if ( $this->showResults['type'] != 0 ) {
					# there ars some stat in row (not necessarily all cells, because size of question table changes dynamically)
					$row[ $catId ][ 0 ] = $this-> { 'addShowResults' . $this->showResults['type'] } ( $inp, $proposalId, $catId );
				} else {
					$row[ $catId ][ 0 ] = $inp;
				}
			}
			# If the proposal text is empty, the question has a syntax error.
			if ( trim( $text ) == '' ) {
				$text = $this->bodyErrorMessage( wfMsg( 'qp_error_proposal_text_empty' ), 'error' );
				foreach ( $row as &$cell ) {
					$cell[ 'style' ] = QP_CSS_ERROR_STYLE;
				}
				$rawClass = 'proposalerror';
			}
			# If the proposal was submitted but unanswered
			if ( $this->mBeingCorrected && !array_key_exists( $proposalId, $this->mProposalCategoryId ) ) {
				# if there was no previous errors, hightlight the whole row
				if ( $this->getState() == '' ) {
					foreach ( $row as &$cell ) {
						$cell[ 'style' ] = QP_CSS_ERROR_STYLE;
					}
				}
				$text = $this->bodyErrorMessage( wfMsg( 'qp_error_no_answer' ), 'NA' ) . $text;
				$rawClass = 'proposalerror';
			}
			if ( $text !== null ) {
				$text = array( '__tag' => 'td', '__end' => "\n", 'class' => 'proposaltext', 'style' => $this->proposalTextStyle, 0 => $this->parser->recursiveTagParse( $text ) );
				if ( $this->proposalsFirst ) {
					# first element is proposaltext
					array_unshift( $row, $text );
				} else {
					# last element is proposaltext
					$row[] = $text;
				}
				$this->addRow( $row, array( 'class' => $rawClass ), 'td' );
			}
		}
	}

	function mixedChoiceParseBody() {
		# Parameters used in some special cases.
		$this->mProposalPattern = '`^';
		foreach ( $this->mCategories as $catDesc ) {
			$this->mProposalPattern .= '(\[\]|\(\)|<>)';
		}
		$this->mProposalPattern .= '(.*)`u';
		$proposalId = -1;
		foreach ( $this->raws as $raw ) {
			# empty proposal text and row
			$text = null;
			$row = Array();
			if ( preg_match( $this->mProposalPattern, $raw, $matches ) ) {
				$text = array_pop( $matches ); // current proposal text
				array_shift( $matches ); // remove "at whole" match
				$last_matches = $matches;
			} else {
				if ( $proposalId >= 0 ) {
					# shortened syntax: use the pattern from the last row where it's been defined
					$text = $raw;
					$matches = $last_matches;
				}
			}
			if ( $text === null ) {
				continue;
			}
			$proposalId++;
			$rawClass = 'proposal';
			$this->mProposalText[ $proposalId ] = trim( $text );
			# Determine a type ID, according to the questionType and the number of signes.
			foreach ( $this->mCategories as $catId => $catDesc ) {
				$typeId  = $matches[ $catId ];
				$row[ $catId ] = Array();
				$inp = Array( '__tag' => 'input' );
				# Determine the input's name and value.
				switch ( $typeId ) {
					case '<>':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = '';
						$inputType = 'text';
						break;
					case '[]':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = 's' . $catId;
						$inputType = 'checkbox';
						break;
					case '()':
						$name = 'q' . $this->mQuestionId . 'p' . $proposalId . 's' . $catId;
						$value = 's' . $catId;
						$inputType = 'radio';
						break;
				}
				# Determine if the input has to be checked.
				$input_checked = false;
				$text_answer = '';
				if ( $this->mBeingCorrected && $this->mRequest->getVal( $name ) !== null ) {
					if ( $inputType == 'text' ) {
						$text_answer = trim( $this->mRequest->getText( $name ) );
						if ( strlen( $text_answer ) > QP_MAX_TEXT_ANSWER_LENGTH ) {
							$text_answer = substr( $text_answer, 0, QP_MAX_TEXT_ANSWER_LENGTH );
						}
						if ( $text_answer != '' ) {
							$input_checked = true;
						}
					} else {
						$inp[ 'checked' ] = 'checked';
						$input_checked = true;
					}
				}
				if ( ( $prev_text_answer = $this->answerExists( $inputType, $proposalId, $catId ) ) !== false ) {
					$input_checked = true;
					if ( $inputType == 'text' ) {
						$text_answer = $prev_text_answer;
					} else {
						$inp[ 'checked' ] = 'checked';
					}
				}
				if ( $input_checked === true ) {
					# add category to the list of user answers for current proposal (row)
					$this->mProposalCategoryId[ $proposalId ][] = $catId;
					$this->mProposalCategoryText[ $proposalId ][] = $text_answer;
				}
				$row[ $catId ][ 'class' ] = 'sign';
				# unique (question,proposal,category) "coordinate" for javascript
				$inp[ 'id' ] = 'mx' . $this->mQuestionId . 'p' . $proposalId . 'c' . $catId;
				$inp[ 'class' ] = 'check';
				$inp[ 'type' ] = $inputType;
				$inp[ 'name' ] = $name;
				if ( $inputType == 'text' ) {
					$inp[ 'value' ] = qp_Setup::specialchars( $text_answer );
					if ( $this->textInputStyle != '' ) {
						$inp[ 'style' ] = $this->textInputStyle;
					}
				} else {
					$inp[ 'value' ] = $value;
				}
				if ( $this->showResults['type'] != 0 ) {
					# there ars some stat in row (not necessarily all cells, because size of question table changes dynamically)
					$row[ $catId ][ 0 ] = $this-> { 'addShowResults' . $this->showResults['type'] } ( $inp, $proposalId, $catId );
				} else {
					$row[ $catId ][ 0 ] = $inp;
				}
			}
			# If the proposal text is empty, the question has a syntax error.
			if ( trim( $text ) == '' ) {
				$text = $this->bodyErrorMessage( wfMsg( "qp_error_proposal_text_empty" ), "error" );
				foreach ( $row as &$cell ) {
					$cell[ 'style' ] = QP_CSS_ERROR_STYLE;
				}
				$rawClass = 'proposalerror';
			}
			# If the proposal was submitted but unanswered
			if ( $this->mBeingCorrected && !array_key_exists( $proposalId, $this->mProposalCategoryId ) ) {
				# if there was no previous errors, hightlight the whole row
				if ( $this->getState() == '' ) {
					foreach ( $row as &$cell ) {
						$cell[ 'style' ] = QP_CSS_ERROR_STYLE;
					}
				}
				$text = $this->bodyErrorMessage( wfMsg( 'qp_error_no_answer' ), 'NA' ) . $text;
				$rawClass = 'proposalerror';
			}
			$text = array( '__tag' => 'td', '__end' => "\n", 'class' => 'proposaltext', 'style' => $this->proposalTextStyle, 0 => $this->parser->recursiveTagParse( $text ) );
			if ( $this->proposalsFirst ) {
				# first element is proposaltext
				array_unshift( $row, $text );
			} else {
				# last element is proposaltext
				$row[] = $text;
			}
			$this->addRow( $row, array( 'class' => $rawClass ), 'td' );
		}
		return qp_Renderer::renderHTMLobject( $this->mRenderTable );
	}

	/**
	 * build internal & visual representation of question categories
	 *
	 * @param  $input			the raw source of categories
	 */
	function parseCategories( $input ) {
		$row = Array();
		if ( $this->proposalsFirst ) {
			// add empty <th> at the begin of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		# build "raw" categories array
		# split tokens
		$cat_split = preg_split( '`({{|}}|\[\[|\]\]|\|)`u', $input, -1, PREG_SPLIT_DELIM_CAPTURE );
		$matching_braces = Array();
		$curr_elem = '';
		$categories = Array();
		foreach ( $cat_split as $part ) {
			switch ( $part ) {
				case '|' :
					if ( count( $matching_braces ) == 0 ) {
						# delimeters are working only when braces are completely closed
						$categories[] = $curr_elem;
						$curr_elem = '';
						$part = '';
					}
					break;
				case '[[' :
				case '{{' :
					if ( $part == '[[' ) {
						$last_brace = ']]';
					} else {
						$last_brace = '}}';
					}
					array_push( $matching_braces, $last_brace );
					break;
				case ']]' :
				case '}}' :
					if ( count( $matching_braces ) > 0 ) {
						$last_brace = array_pop( $matching_braces );
						if ( $last_brace != $part ) {
							array_push( $matching_braces, $last_brace );
						}
					}
					break;
			}
			$curr_elem .= $part;
		}
		if ( $curr_elem != '' ) {
			$categories[] = $curr_elem;
		}
		# analyze previousely build "raw" categories array
		# Less than two categories is a syntax error.
		if ( !array_key_exists( 1, $categories ) ) {
			$categories[0] .= $this->bodyErrorMessage( wfMsg( "qp_error_too_few_categories" ), "error" );
		}
		foreach ( $categories as $catkey => $category ) {
			$category = trim( $category );
			# If a category name is empty, the question has a syntax error.
			if ( $category == "" ) {
				$category = $this->bodyErrorMessage( wfMsg( "qp_error_category_name_empty" ), "error" );
			}
			$this->mCategories[ $catkey ]["name"] = $category;
			$row[] = $this->parser->recursiveTagParse( $category );
		}

		# cut unused categories rows which are presented in DB but were removed from article
		$this->mCategories = array_slice( $this->mCategories, 0, count( $categories ) );
		if ( !$this->proposalsFirst ) {
			// add empty <th> at the end of row to "compensate" proposal text
			$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
		}
		return $row;
	}

	/**
	 * build internal & visual representation of question category spans
	 * ( also known as metacategories or "category groups" )
	 *
	 * @param  $input			the raw source of category spans
	 */
	# warning: parseCategorySpans() should be called after parseCategories()
	function parseCategorySpans( $input ) {
		$row = Array();
		if ( $this->mType == "singleChoice" ) {
			# real category spans have sense only for radiobuttons
			# build "raw" spans array
			# split tokens
			$span_split = preg_split( '`({{|}}|\[\[|\]\]|\||\!)`u', $input, -1, PREG_SPLIT_DELIM_CAPTURE );
			$matching_braces = Array();
			$curr_elem = null;
			$spans = Array();
			if ( isset( $span_split[0] ) && $span_split[0] == '' ) {
				array_shift( $span_split );
				if ( isset( $span_split[0] ) && in_array( $span_split[0], array( '!', '|' ) ) ) {
					$delim = $span_split[0];
					foreach ( $span_split as $part ) {
						if ( $part == $delim ) {
							if ( count( $matching_braces ) == 0 ) {
								# delimeters are working only when braces are completely closed
								$spans[0][] = $part;
								if ( $curr_elem !== null ) {
									$spans[1][] = $curr_elem;
								}
								$curr_elem = '';
								$part = '';
							}
						} else {
							switch ( $part ) {
								case '[[' :
								case '{{' :
									if ( $part == '[[' ) {
										$last_brace = ']]';
									} else {
										$last_brace = '}}';
									}
									array_push ( $matching_braces, $last_brace );
									break;
								case ']]' :
								case '}}' :
									if ( count( $matching_braces ) > 0 ) {
										$last_brace = array_pop( $matching_braces );
										if ( $last_brace != $part ) {
											array_push( $matching_braces, $last_brace );
										}
									}
									break;
							}
						}
						$curr_elem .= $part;
					}
					if ( $curr_elem !== null ) {
						$spans[1][] = $curr_elem;
					} else {
						$curr_elem = '';
					}
				}
			}
			# analyze previousely build "raw" spans array
			# Less than one span is a syntax error.
			if ( !array_key_exists( 0, $spans ) ) {
				return $this->bodyErrorMessage( wfMsg( "qp_error_too_few_spans" ), "error" );
			}
			# fill undefined spans with the last span value
			$SpanCategDelta = count( $this->mCategories ) - count( $spans[0] );
			$lastDefinedSpanKey = array_pop( array_diff( array_keys( $spans[1] ), array_keys( $spans[1], "", true ) ) );
			if ( $lastDefinedSpanKey !== null ) {
				if ( $SpanCategDelta > 0 ) {
					# increase the length of last defined span value to match total lenth of categories
					$lastSpanType = $spans[0][$lastDefinedSpanKey];
					$spans[0] = array_merge( array_slice( $spans[0], 0, $lastDefinedSpanKey ),
						array_fill( 0, $SpanCategDelta, $lastSpanType ),
						array_slice( $spans[0], $lastDefinedSpanKey ) );
					$spans[1] = array_merge( array_slice( $spans[1], 0, $lastDefinedSpanKey ),
						array_fill( 0, $SpanCategDelta, "" ),
						array_slice( $spans[1], $lastDefinedSpanKey ) );
				} elseif ( $SpanCategDelta < 0 ) {
					# cut unused but defined extra spans
					$spans[0] = array_slice( $spans[0], count( $this->mCategories ), - $SpanCategDelta );
					$spans[1] = array_slice( $spans[1], count( $this->mCategories ), - $SpanCategDelta );
				}
			} else {
				# no valid category spans are defined
				return $this->bodyErrorMessage( wfMsg( 'qp_error_too_few_spans' ), 'error' );
			}
			# populate mCategorySpans and row
			if ( $this->proposalsFirst ) {
				// add empty <th> at the begin of row to "compensate" proposal text
				$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
			}
			$colspanBase = ( $lastDefinedSpanKey == 0 ) ? 1 : 0;
			$colspan = 1;
			$categorySpanId = 0;
			foreach ( $spans[0] as $spanKey => $spanType ) {
				$spanCategory = trim( $spans[1][$spanKey] );
				if ( $spanCategory == "" ) {
					$colspan++;
				} else {
					$row[] = array( "count" => $colspan + $colspanBase, 0 => $this->parser->recursiveTagParse( $spanCategory ) );
					if ( $spanType == "|" ) { // "!" is a comment header, not a real category span
						$this->mCategorySpans[ $categorySpanId ]['name'] = $spanCategory;
						$this->mCategorySpans[ $categorySpanId ]['count'] = $colspan;
						for ( $i = $spanKey;
							$i >= 0 && array_key_exists( $i, $this->mCategories ) && !array_key_exists( 'spanId', $this->mCategories[ $i ] );
							$i-- ) {
							$this->mCategories[$i]['spanId'] = $categorySpanId;
						}
						$categorySpanId++;
					}
					$colspan = 1;
				}
			}
			if ( !$this->proposalsFirst ) {
				// add empty <th> at the end of row to "compensate" proposal text
				$row[] = array( '__tag' => 'td', 0 => "", 'style' => 'border:none;', '__end' => "\n" );
			}
		}
		return $row;
	}

	function isUniqueProposalCategoryId( $proposalId, $catId ) {
		foreach ( $this->mProposalCategoryId as $proposalCategoryId ) {
			if ( in_array( $catId, $proposalCategoryId ) ) {
				return false;
			}
		}
		return true;
	}

	/*** cell templates ***/

	# cell templates for the selected showresults
	var $cellTemplate = Array();
	var $cellTemplateParam = Array( 'inp' => '', 'percents' => '', 'bar1style' => '', 'bar2style' => '' );

	# setup a template for showresults=1
	# showresults=1 cellTemplate has only one variant
	function cellTemplate1() {
		$this->cellTemplate =
			array(
				0 => array( '__tag' => 'div', 0 => &$this->cellTemplateParam['inp'] ),
				1 => array( '__tag' => 'div', 'class' => 'stats', 0 => &$this->cellTemplateParam['percents'] )
			);
		if ( isset( $this->showResults['color'] ) ) {
			$this->cellTemplate[1]['style'] = 'color:' . $this->showResults['color'] . ';';
		}
		if ( isset( $this->showResults['background'] ) ) {
			$this->cellTemplate[1]['style'] .= 'background:' . $this->showResults['background'] . ';';
		}
	}

	# transform input according to showresults=1 (numerical percents)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults1( $inp, $proposalId, $catId ) {
		$this->cellTemplateParam['inp'] = $inp;
		$this->cellTemplateParam['percents'] = '&nbsp;';
		if ( ( $percents = $this->getPercents( $proposalId, $catId ) ) !== false ) {
			# there is a stat in cell
			$this->cellTemplateParam['percents'] = $percents . '%';
			# template has to be rendered immediately, because $this->cellTemplateParam[] are used as pointers and thus,
			# will always be overwritten
			return QP_Renderer::renderHTMLobject( $this->cellTemplate );
		} else {
			return $inp;
		}
	}

	# setup a template for showresults=2
	function cellTemplate2() {
		# statical styles
		$percentstyle = '';
		if ( isset( $this->showResults['textcolor'] ) ) {
			$percentstyle = 'color:' . $this->showResults['textcolor'] . ';';
		}
		if ( isset( $this->showResults['textbackground'] ) ) {
			$percentstyle .= 'background:' . $this->showResults['textbackground'] . ';';
		}
		# html arrays used in templates below
		$bar = array( '__tag' => 'div', 'class' => 'stats1',
			0 => array( '__tag' => 'div', 'class' => 'bar0', 0 => &$this->cellTemplateParam['inp'] ),
			1 => array( '__tag' => 'div', 'class' => 'bar1', 'style' => &$this->cellTemplateParam['bar1style'], 0 => '&nbsp;' ),
			2 => array( '__tag' => 'div', 'class' => 'bar2', 'style' => &$this->cellTemplateParam['bar2style'], 0 => '&nbsp;' ),
			3 => array( '__tag' => 'div', 'class' => 'bar0', 'style' => $percentstyle, 0 => &$this->cellTemplateParam['percents'] )
		);
		$bar2 = array( '__tag' => 'div', 'class' => 'stats1',
			0 => array( '__tag' => 'div', 'class' => 'bar0', 0 => '&nbsp;' ),
			1 => &$bar[1],
			2 => &$bar[2],
			3 => &$bar[3]
		);
		# has two available templates ('bar','textinput')
		$this->cellTemplate = array(
			'bar' => $bar,
			'textinput' => array( '__tag' => 'table', 'class' => 'stats',
				0 => array( '__tag' => 'tr',
					0 => array( '__tag' => 'td', 0 => &$this->cellTemplateParam['inp'] ),
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
		if ( isset( $this->showResults['color'] ) ) {
			$this->cellTemplate['bar1showres'] .= 'background:' . $this->showResults['color'] . ';';
		}
		if ( isset( $this->showResults['background'] ) ) {
			$this->cellTemplate['bar2showres'] .= 'background:' . $this->showResults['background'] . ';';
		}
	}

	# transform input according to showresults=2 (bars)
	# *** warning! parameters should be passed only by value, not by reference ***
	function addShowResults2( $inp, $proposalId, $catId ) {
		$this->cellTemplateParam['inp'] = $inp;
		$this->cellTemplateParam['percents'] = '&nbsp;';
		if ( ( $percents = $this->getPercents( $proposalId, $catId ) ) !== false ) {
			# there is a stat in cell
			$this->cellTemplateParam['percents'] = $percents . '%';
			$this->cellTemplateParam['bar1style'] = 'width:' . $percents . 'px;' . $this->cellTemplate[ 'bar1showres' ];
			$this->cellTemplateParam['bar2style'] = 'width:' . ( 100 - $percents ) . 'px;' . $this->cellTemplate[ 'bar2showres' ];
			if ( $inp['type'] == 'text' ) {
				return qp_Renderer::renderHTMLobject( $this->cellTemplate['textinput'] );
			} else {
				return qp_Renderer::renderHTMLobject( $this->cellTemplate['bar'] );
			}
		} else {
			return $inp;
		}
	}

	/*** end of cell templates ***/

}
