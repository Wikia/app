<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Stores the list of current category options -
 * usually the pipe-separated entries in specified brackets list
 */
class qp_TextQuestionOptions {

	# boolean, indicates whether incoming tokens are category list elements
	var $isCatDef;
	# indicates whether list of select options will fit into DB field or not
	#   boolean false the values will fit;
	#   int 0         the longest value won't fit;
	#   int 1         all the values of select multiple won't fit;
	var $hasOverflow;
	# type of created element (text,radio,checkbox)
	var $type;
	# counter of pipe-separated elements in-between << >> markup
	# used to distinguish real category options from attributes definition
	# for type='text'
	var $catDefIdx;
	# list of input options; array whose every element is a string
	var $input_options;

	# whether the current option has xml-like attributes specified
	var $hasAttributes = false;
	## Category attributes;
	#    Defined as xml-like attribute in the first element of options list.
	var $attributes = array(
		## width of input text field
		#    possible values: null, positive int, 'auto'
		# <<:: width="12">> or <<:: width="15"|test>> or <<:: width="auto"|asd|fgh>>
		# currently, it is used only for text input / textarea (not for select/option list)
		'width' => null,
		## number of text lines in an select / textarea
		#    possible values: null, positive int, 'auto'
		#    when there is no options or only one option, it produces an textarea
		#    when there is more than one option, it produces a scrollable select / options list
		#    value 'auto' is meaningful only when there are more than one option given;
		# <<:: height="4">> or <<:: height="10"|prefilled text>>
		'height' => null,
		## whether the text options of current category has to be sorted;
		#    possible values: null (do not sort), 'asc', 'desc'
		# <<:: sorting="desc"|a|b|c>>
		'sorting' => null,
		## whether the checkbox type option of current category has to be checked by default;
		#    possible values: null (not checked), not null (checked)
		# <[checked=""]>
		'checked' => null,
		## whether the select for current category can have multiple options selected
		#    possible values: null (no multiple selection), not null (multiple selection)
		#    it is meaningful only for text categories with multiple options defined:
		# <<:: multiple=""|1|2|3>>
		'multiple' => null
	);
	# a pointer to last element in $this->input_options array
	var $iopt_last;

	/**
	 * Prepare options for new proposal line
	 */
	function reset() {
		$this->isCatDef = false;
		$this->input_options = array();
		$this->catDefIdx = 0;
	}

	/**
	 * Creates first single empty option
	 * Applies default settings to the options list
	 * New category begins
	 */
	function startOptionsList( $type ) {
		$this->isCatDef = true;
		$this->hasOverflow = false;
		$this->type = $type;
		$this->input_options = array( 0 => '' );
		$this->hasAttributes = false;
		# set default values of xml-like attributes
		foreach ( $this->attributes as $attr_name => &$attr_val ) {
			$attr_val = null;
		}
		$this->iopt_last = &$this->input_options[0];
	}

	/**
	 * Adds new empty option
	 * This option will be "current last option"
	 */
	function addEmptyOption() {
		# new options are meaningful only for type 'text'
		if ( $this->type === 'text' ) {
			# add new empty option only if there was no xml attributes definition
			if ( !$this->hasAttributes || $this->catDefIdx !== 0 ) {
				# add new empty option to the end of the list
				$this->input_options[] = '';
				$this->iopt_last = &$this->input_options[count( $this->input_options ) - 1];
			}
			$this->catDefIdx++;
		}
	}

	/**
	 * Add string part to value of current last option
	 * @param  $token  string current value of token between pipe separators
	 * Also, _optionally_ parses xml-like attributes (when these are found in category definition)
	 */
	function addToLastOption( $token ) {
		$matches = array();
		if ( $this->type === 'text' ) {
			# first entry of "category type text" might contain current category
			# xml-like attributes
			if ( count( $this->input_options ) === 1 &&
				preg_match( '`^::\s*(.+)$`', $token, $matches ) ) {
				# note that hasAttributes is always true regardless the attributes are used or not,
				# because it is checked in $this->addEmptyOption()
				$this->hasAttributes = true;
				# parse attributes string
				$option_attributes = qp_Setup::getXmlLikeAttributes( $matches[1], array( 'width', 'height', 'sorting', 'multiple' ) );
				# apply attributes to current option
				foreach ( $option_attributes as $attr_name => $attr_val ) {
					$this->attributes[$attr_name] = $attr_val;
				}
				return;
			}
		} elseif ( $this->type === 'checkbox' ) {
			if ( $token !== '' ) {
				# checkbox type of categories do not contain text values,
				# only xml-like attributes
				$option_attributes = qp_Setup::getXmlLikeAttributes( $token, array( 'checked' ) );
				# apply attributes to current option
				foreach ( $option_attributes as $attr_name => $attr_val ) {
					$this->attributes[$attr_name] = $attr_val;
				}
			}
		}
		# add new input option
		$this->iopt_last .= $token;
	}

	/**
	 * Closes current category definition and prepares input options entries
	 */
	function closeCategory() {
		$this->isCatDef = false;
		# prepare new category input choice (text questions have no category names)
		$unique_options = array_unique( array_map( 'trim', $this->input_options ), SORT_STRING );
		$this->input_options = array();
		foreach ( $unique_options as $option ) {
			# make sure unique elements keys are consequitive starting from 0
			$this->input_options[] = $option;
		}
		switch ( $this->attributes['sorting'] ) {
		case 'asc' :
			sort( $this->input_options, SORT_STRING );
			break;
		case 'desc' :
			rsort( $this->input_options, SORT_STRING );
			break;
		}
		if ( $this->type === 'text' && count( $this->input_options ) > 1 ) {
			# check max length of select values that may be stored
			# into 'text_answer' DB field
			if ( $this->attributes['multiple'] === null ) {
				# one value may be selected and then submitted
				$multiple = 0;
				$val_max_len = 0;
				foreach ( $this->input_options as $option ) {
					if ( strlen( $option ) > $val_max_len ) {
						$val_max_len= strlen( $option );
					}
				}
			} else {
				# all of the values may be selected and then submitted
				$multiple = 1;
				$val_max_len = strlen( implode( qp_Setup::SELECT_MULTIPLE_VALUES_SEPARATOR, $this->input_options ) );
			}
			$this->hasOverflow = ( $val_max_len > qp_Setup::$field_max_len['text_answer'] ) ? $multiple : false;
		}
	}

} /* end of qp_TextQuestionOptions class */

/**
 * A base class for parsing, checking and visualisation of text questions in
 * declaration/voting mode (UI input/output)
 *
 * An attempt to make somewhat cleaner question controller
 * todo: further refactoring of controllers for different question types
 */
class qp_TextQuestion extends qp_StubQuestion {

	## default proposal attributes
	# do not allow empty text fields submission / storage by default
	var $mEmptyText = false;
	# required count of current proposal's categories that should be filled by user
	var $mCatReq = 'all';

	# regexp for separation of proposal line tokens
	var $propCatPattern;

	# source "raw" tokens (preg_split)
	var $rawtokens;

	/**
	 * array with parsed braces pairs
	 * every element may have the following keys:
	 *   'type' : type of brace string _key_values_ of $this->matching_braces
	 *   'closed_at' : indicates opening brace;
	 *     false when no matching closing brace was found
	 *     int  key of $this->rawtokens a "link" to matching closing brace
	 *   'opened_at' : indicates closing brace;
	 *     false when no matching opening brace was found
	 *     int  key of $this->rawtokens a "link" to matching opening brace
	 *   'iscat'     : indicates brace that belongs to $this->input_braces_types AND
	 *                 has a proper match (both 'closed_at' and 'opened_at' are int)
	 */
	var $brace_matches;

	# $propview is an instance of qp_TextQuestionProposalView
	#             which contains parsed tokens for combined
	#             proposal/category view
	var $propview;
	# $dbtokens will contain parsed tokens for combined
	#           proposal/category storage
	# $dbtokens elements do not include error messages;
	# only proposal parts and category options
	var $dbtokens = array();

	# List of opening input braces types
	# input is html representation of category:
	# brace value 'text' is mapped to input text or to select option;
	# brace values 'radio' and 'checkbox' are mapped to
	# input radio and input checkbox, respectively.
	var $input_braces_types = array(
		'<<' => 'text',
		'<(' => 'radio',
		'<[' => 'checkbox'
	);
	# matches of opening / closing braces
	var $matching_braces = array(
		# wiki link
		'[[' => ']]',
		# wiki magicword
		'{{' => '}}',
		# text input / select option
		'<<' => '>>',
		# radiobutton
		'<(' => ')>',
		# checkbox
		'<[' => ']>'
	);

	/**
	 * Applies previousely parsed attributes from main header into question's view
	 * (all attributes but type)
	 * @param  $paramkeys array
	 *   key is attribute name regexp match, value is the value of attribute
	 */ 
	function applyAttributes( array $paramkeys ) {
		parent::applyAttributes( $paramkeys );
		# commented out, because now the "catreq" attribute can be set per proposal row, thus
		# it is unpractical to disable radiobuttons for all proposals of the question.
		# todo: disable radiobuttons per proposal, when current catreq=0 ?
		/*
		if ( $this->mCatReq === 'all' ) {
			# radio button prevents from filling all categories, disable it
			if ( ( $radio_brace = array_search( 'radio', $this->input_braces_types, true ) ) !== false ) {
				unset( $this->input_braces_types[$radio_brace] );
				unset( $this->matching_braces[$radio_brace] );
			}
		}
		*/
		$braces_list = array_map( 'preg_quote',
			array_merge(
				( array_values( $this->matching_braces ) ),
				array_keys( $this->matching_braces ),
				array( '|' )
			)
		);
		$this->propCatPattern = '/(' . implode( '|', $braces_list ) . ')/u';
	}

	/**
	 * Parses question body header.
	 * Text questions do not have "body header" (no definitions of spans and categories).
	 */
	function parseBodyHeader() {
		/* noop */
	}

	/**
	 * Load checkbox / radio / text answer to the selected (proposal,category) pair, when available
	 * Also, stores checkbox / radio / text answer into the parsed tokens list (propview)
	 */
	function loadProposalCategory( qp_TextQuestionOptions $opt, $proposalId, $catId ) {
		global $wgContLang;
		$name = "q{$this->mQuestionId}p{$proposalId}s{$catId}";
		$answered = false;
		$text_answer = '';
		# try to load from POST data
		if ( $this->poll->mBeingCorrected &&
				( $ta = qp_Setup::$request->getArray( $name ) ) !== null ) {
			if ( $opt->type === 'text' ) {
				if ( count( $ta ) === 1 ) {
					# fallback to WebRequest::getText(), because it offers useful preprocessing
					$ta = trim( qp_Setup::$request->getText( $name ) );
				} else {
					# pack select multiple values
					$ta = implode( qp_Setup::SELECT_MULTIPLE_VALUES_SEPARATOR, array_map( 'trim', $ta ) );
				}
				if ( qp_Setup::$propAttrs->emptytext || $ta != '' ) {
					$answered = true;
					if ( strlen( $ta ) > qp_Setup::$field_max_len['text_answer'] ) {
						$text_answer = $wgContLang->truncate( $ta, qp_Setup::$field_max_len['text_answer'] , '' );
					} else {
						$text_answer = $ta;
					}
				}
			} else {
				$answered = true;
			}
		}
		# try to load from pollStore
		# pollStore optionally overrides POST data
		if ( ( $prev_text_answer = $this->answerExists( $opt->type, $proposalId, $catId ) ) !== false ) {
			$answered = true;
			if ( is_string( $prev_text_answer ) ) {
				$text_answer = $prev_text_answer;
			}
		}
		if ( $answered !== false ) {
			# add category to the list of user answers for current proposal (row)
			$this->mProposalCategoryId[ $proposalId ][] = $catId;
			$this->mProposalCategoryText[ $proposalId ][] = $text_answer;
			if ( $opt->type !== 'text' ) {
				$opt->attributes['checked'] = true;
			}
		}
		# finally, add new category input options for the view
		$opt->closeCategory();
		if ( $opt->hasOverflow !== false ) {
			$msg_key = ( $opt->hasOverflow === 0 ) ? 'qp_error_too_long_category_option_value' : 'qp_error_too_long_category_options_values';
			$this->propview->addErrorToken( wfMsg( $msg_key ), 'error' );
		}
		$this->propview->addCatDef( $opt, $name, $text_answer, $this->poll->mBeingCorrected && !$answered );
	}

	/**
	 * Builds $this->brace_matches array which contains the list of matching braces
	 * from $this->rawtokens array.
	 */
	private function findMatchingBraces() {
		$brace_stack = array();
		$this->brace_matches = array();
		$matching_closed_brace = '';
		# building $this->brace_matches
		foreach ( $this->rawtokens as $tkey => $token ) {
			if ( array_key_exists( $token, $this->matching_braces ) ) {
				# opening braces
				$this->brace_matches[$tkey] = array(
					'closed_at' => false,
					'type' => $token
				);
				$match = $this->matching_braces[$token];
				# create new brace_stack element:
				$last_brace_def = array(
					'match' => $match,
					'idx' => $tkey
				);
				if ( array_key_exists( $token, $this->input_braces_types ) &&
						count( $brace_stack ) == 0 ) {
					# will try to start category definiton (on closing)
					$matching_closed_brace = $match;
				}
				array_push( $brace_stack, $last_brace_def );
			} elseif ( in_array( $token, $this->matching_braces ) ) {
				# closing braces
				$this->brace_matches[$tkey] = array(
					'opened_at' => false,
					# we always put opening brace in 'type'
					'type' => array_search( $token, $this->matching_braces, true )
				);
				if ( count( $brace_stack ) > 0 ) {
					$last_brace_def = array_pop( $brace_stack );
					if ( $last_brace_def['match'] != $token ) {
						# braces didn't match
						array_push( $brace_stack, $last_brace_def );
						continue;
					}
					$idx = $last_brace_def['idx'];
					# link opening / closing braces to each other
					$this->brace_matches[$tkey]['opened_at'] = $idx;
					$this->brace_matches[$idx]['closed_at'] = $tkey;
					if ( count( $brace_stack ) > 0 || $token !== $matching_closed_brace ) {
						# brace does not belong to $this->input_braces_types
						continue;
					}
					# stack level 1 and found a matching_closed_brace;
					# indicate end of category in $this->brace_matches
					$this->brace_matches[$tkey]['iscat'] = true;
					# indicate begin of category in $this->brace_matches
					$this->brace_matches[$idx]['iscat'] = true;
					# clear match
					$matching_closed_brace = '';
				}
			}
		}
	}

	/**
	 * Trying to backtrack non-closed braces only for these which belong to
	 * $this->input_braces_types
	 */
	private function backtrackMismatchingBraces() {
		$brace_keys = array_keys( $this->brace_matches, true );
		for ( $i = count( $brace_keys ) - 1; $i >= 0; $i-- ) {
			$brace_match = &$this->brace_matches[$brace_keys[$i]];
			# match non-closed brace which belongs to $this->input_braces_types
			# (non-closed category definitions)
			if ( array_key_exists( 'opened_at', $brace_match ) &&
					$brace_match['opened_at'] === false &&
					array_key_exists( $brace_match['type'], $this->input_braces_types ) ) {
				# try to find matching opening brace for current non-closed closing brace
				for ( $j = $i - 1; $j >= 0; $j-- ) {
					$checked_brace = &$this->brace_matches[$brace_keys[$j]];
					if ( array_key_exists( 'iscat', $checked_brace ) ) {
						# category definitions cannot be nested
						break;
					}
					if ( array_key_exists( 'closed_at', $checked_brace ) ) {
						# opening brace
						if ( $checked_brace['closed_at'] === false ) {
							# opening brace that has no matching closing brace
							if ( $checked_brace['type'] === $brace_match['type'] ) {
								# opening brace of the same type that $brace_match have
								# link $brace_match and $checked_brace to each other:
								# found matching non-closed opening brace; "link" both to each other
								$brace_match['opened_at'] = $brace_keys[$j];
								$brace_match['iscat'] = true;
								$checked_brace['closed_at'] = $brace_keys[$i];
								$checked_brace['iscat'] = true;
								break;
							}
						} elseif ( $checked_brace['closed_at'] > $i ) {
							# found opening brace that is closed at higher position than our
							# $brace_match has;
							# cross-closing is not allowed, the following code cannot be
							# category definition and template at the same time:
							# "<[ {{ ]> }}"
							break;
						}
					}
				}
			}
		}
	}

	/**
	 * Creates question view which should be renreded and
	 * also may be altered during the poll generation
	 */
	function parseBody() {
		$proposalId = 0;
		# Currently, we use just a single instance (no nested categories)
		$opt = new qp_TextQuestionOptions();
		# set static view state for the future qp_TextQuestionProposalView instances
		qp_TextQuestionProposalView::applyViewState( $this->view );
		$prop_attrs = qp_Setup::$propAttrs;
		$prop_attrs->setQuestion( $this );
		while ( $prop_attrs->iterate() ) {
			$opt->reset();
			$this->propview = new qp_TextQuestionProposalView( $proposalId, $this );
			# get proposal name and optional attributes (if any)
			if ( is_string( $prop_attrs->error ) ) {
				$this->propview->prependErrorToken( wfMsg( $prop_attrs->error, 'error' ) );
			}
			$this->dbtokens = $brace_stack = array();
			$dbtokens_idx = -1;
			$catId = 0;
			$last_brace = '';
			$this->rawtokens = preg_split(
				$this->propCatPattern,
				$prop_attrs->cpdef,
				-1,
				PREG_SPLIT_DELIM_CAPTURE
			);
			$matching_closed_brace = '';
			$this->findMatchingBraces();
			$this->backtrackMismatchingBraces();
			foreach ( $this->rawtokens as $tkey => $token ) {
				# $toBeStored == true when current $token has to be stored into
				# category / proposal list (depending on $opt->isCatDef)
				$toBeStored = true;
				if ( $token === '|' ) {
					# parameters separator
					if ( $opt->isCatDef ) {
						if ( count( $brace_stack ) == 1 && $brace_stack[0] === $matching_closed_brace ) {
							# pipe char starts new option only at top brace level,
							# with matching input brace
							$opt->addEmptyOption();
							$toBeStored = false;
						}
					}
				} elseif ( array_key_exists( $tkey, $this->brace_matches ) ) {
					# brace
					$brace_match = &$this->brace_matches[$tkey];
					if ( array_key_exists( 'closed_at', $brace_match ) &&
							$brace_match['closed_at'] !== false ) {
						# valid opening brace
						array_push( $brace_stack, $this->matching_braces[$token] );
						if ( array_key_exists( 'iscat', $brace_match ) ) {
							# start category definition
							$matching_closed_brace = $this->matching_braces[$token];
							$opt->startOptionsList( $this->input_braces_types[$token] );
							$toBeStored = false;
						}
					} elseif ( array_key_exists( 'opened_at', $brace_match ) &&
						$brace_match['opened_at'] !== false ) {
						# valid closing brace
						array_pop( $brace_stack );
						if ( array_key_exists( 'iscat', $brace_match ) ) {
							$matching_closed_brace = '';
							# add new category input options for the storage
							$this->dbtokens[++$dbtokens_idx] = $opt->input_options;
							# setup mCategories
							$this->mCategories[$catId] = array( 'name' => strval( $catId ) );
							# load proposal/category answer (when available)
							$this->loadProposalCategory( $opt, $proposalId, $catId );
							# current category is over
							$catId++;
							$toBeStored = false;
						}
					}
				}
				if ( $toBeStored ) {
					if ( $opt->isCatDef ) {
						$opt->addToLastOption( $token );
					} else {
						# add new proposal part
						if ( $dbtokens_idx >= 0 && is_string( $this->dbtokens[$dbtokens_idx] ) ) {
							$this->dbtokens[$dbtokens_idx] .= strval( $token );
						} else {
							$this->dbtokens[++$dbtokens_idx] = strval( $token );
						}
						$this->propview->addProposalPart( $token );
					}
				}
			}
			# check if there is at least one category defined
			if ( $catId === 0 ) {
				# todo: this is the explanatory line, it is not real proposal
				$this->propview->prependErrorToken( wfMsg( 'qp_error_too_few_categories' ), 'error' );
			}
			$prop_attrs->dbText = serialize( $this->dbtokens );
			# build the whole raw DB proposal_text value to check it's maximal length
			if ( strlen( $prop_attrs ) > qp_Setup::$field_max_len['proposal_text'] ) {
				# too long proposal field to store into the DB
				# this is very important check for text questions because
				# category definitions are stored within the proposal text
				$this->propview->prependErrorToken( wfMsg( 'qp_error_too_long_proposal_text' ), 'error' );
			}
			$this->mProposalText[$proposalId] = strval( $prop_attrs );
			if ( $prop_attrs->name !== '' ) {
				$this->mProposalNames[$proposalId] = $prop_attrs->name;
			}
			$this->propview->catreq = $prop_attrs->catreq;
			## Check for unanswered categories.
			if ( $this->poll->mBeingCorrected &&
						$prop_attrs->hasMissingCategories(
							$answered_cats_count = $this->getAnsweredCatCount( $proposalId ),
							$catId
						) ) {
				$prev_state = $this->getState();
				$this->propview->prependErrorToken(
					($answered_cats_count > 0) ?
						wfMsg( 'qp_error_not_enough_categories_answered' ) :
						wfMsg( 'qp_error_no_answer' )
					, 'NA'
				);
			}
			$this->view->addProposal( $proposalId, $this->propview );
			$proposalId++;
		}
	}

} /* end of qp_TextQuestion class */
