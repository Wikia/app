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
 * Proposal / category view row building helper.
 * Currently the single instance is re-used (no nesting).
 */
class qp_TextQuestionViewRow {

	# owner of row ( an insance of qp_TextQuestionView )
	var $owner;
	# proposal prefix for category tag id generation
	var $id_prefix;
	# each element of row is real table cell or "cell" with spans,
	# depending on $this->tabularDisplay value
	var $row;
	# tagarray with error elements will be merged into adjascent cells
	# (otherwise tabular layout will be broken by proposal errors)
	var $error;
	# tagarray with current cell builded for row
	# cell contains one or multiple tags, describing proposal part or category
	var $cell;
	# current category id
	var $catId;

	function __construct( qp_TextQuestionView $owner ) {
		$this->owner = $owner;
		$this->reset( '' );
	}

	/**
	 * Prepare current instance for new proposal row
	 */
	function reset( $id_prefix ) {
		$this->id_prefix = $id_prefix;
		$this->row = array();
		$this->error = array();
		$this->cell = array();
		# category index, starting from 0
		$this->catId = 0;
	}

	/**
	 * Add proposal error tagarray
	 */
	function addError( stdClass $elem ) {
		$this->cell[] = array(
			'__tag' => 'span',
			'class' => 'proposalerror',
			$elem->interpError
		);
	}

	/**
	 * Add category as input type text / checkbox / radio / textarea tagarray
	 */
	function addInput( stdClass $elem, $className ) {
		$tagName = ( $elem->type === 'text' && $elem->attributes['height'] !== 0 ) ? 'textarea' : 'input';
		$lines_count = 1;
		# get category value
		$value = $elem->value;
		# check, whether the definition of category has "pre-filled" value
		# single, non-unanswered, non-empty option is a pre-filled value
		if ( !$elem->unanswered && $elem->value === '' && $elem->options[0] !== '' ) {
			# input text pre-fill
			$value = $elem->options[0];
			if ( $tagName === 'textarea' ) {
				# oversimplicated regexp, but it's enough for our needs
				# todo: multiline proposals do not require to use <br> to separate lines
				# of pre-filled text, check out when question type="free" will be implemented.
				$value = preg_replace( '/<br[\sA-Z\d="]*\/?>/i', qp_Setup::TEXTAREA_LINES_SEPARATOR, $value, -1, $lines_count );
				$lines_count++;
			}
			$className .= ' cat_prefilled';
		}
		$tag = array(
			'__tag' => $tagName,
			# unique (poll_type,order_id,question,proposal,category) "coordinate" for javascript
			'id' => "{$this->id_prefix}c{$this->catId}",
			'class' => $className,
			'name' => $elem->name,
		);
		if ( $tagName === 'input' ) {
			$tag['type'] = $elem->type;
			$tag['value'] = qp_Setup::specialchars( $value );
		} else { /* 'textarea' */
			$tag[] = qp_Setup::specialchars( $value );
			if ( is_int( $elem->attributes['height'] ) ) {
				$tag['rows'] = $elem->attributes['height'];
			} else { /* 'auto' */
				# todo: allow multiline prefilled text and calculate number of new lines
				$tag['rows'] = $lines_count;
			}
		}
		$this->catId++;
		if ( $elem->type === 'text' ) {
			# input type text and textarea
			if ( $this->owner->textInputStyle != '' ) {
				# apply poll's textwidth attribute
				$tag['style'] = $this->owner->textInputStyle;
			}
			if ( $elem->attributes['width'] !== 0 ) {
				# apply current category width attribute
				if ( is_int( $elem->attributes['width'] ) ) {
					$tag['style'] = 'width:' . $elem->attributes['width'] . 'em;';
				} else { /* 'auto' */
					$tag['style'] = 'width:99%;';
				}
			}
		} else {
			# checkbox or radiobutton
			if ( $elem->attributes['checked'] === true ) {
				$tag['checked'] = 'checked';
			}
		}
		$this->cell[] = $tag;
	}

	/**
	 * Add category as select / option list tagarray
	 */
	function addSelect( stdClass $elem, $className ) {
		if ( $elem->options[0] !== '' ) {
			# default element in select/option set always must be an empty option
			array_unshift( $elem->options, '' );
		}
		$html_options = array();
		# prepare the list of selected values
		if ( $elem->attributes['multiple'] !== null ) {
			# new lines are separator for selected multiple options
			$selected_values = explode( qp_Setup::SELECT_MULTIPLE_VALUES_SEPARATOR, $elem->value );
		} else {
			$selected_values = array( $elem->value );
		}
		# generate options list
		foreach ( $elem->options as $option ) {
			$html_option = array(
				'__tag' => 'option',
				'value' => qp_Setup::entities( $option ),
				qp_Setup::specialchars( $option )
			);
			if ( in_array( $option, $selected_values ) ) {
				$html_option['selected'] = 'selected';
			}
			$html_options[] = $html_option;
		}
		$select = array(
			'__tag' => 'select',
			# unique (poll_type,order_id,question,proposal,category) "coordinate" for javascript
			'id' => "{$this->id_prefix}c{$this->catId}",
			'class' => $className,
			'name' => $elem->name,
			$html_options
		);
		# multiple options 'name' attribute should have array hint []
		if ( $elem->attributes['multiple'] !== null ) {
			$select['multiple'] = 'multiple';
			$select['name'] .= '[]';
		}
		# determine visual height of select options list
		if ( ( $size = $elem->attributes['height'] ) !== 0 ) {
			if ( is_int( $size ) ) {
				if ( count( $elem->options ) < $size ) {
					$size = count( $elem->options );
				}
			} else { /* 'auto' */
				$size = count( $elem->options );
			}
			$select['size'] = $size;
		}
		$this->cell[] = $select;
		$this->catId++;
	}

	/**
	 * Add tagarray representation of proposal part
	 */
	function addProposalPart( /* string */ $elem ) {
		$this->cell[] = array(
			'__tag' => 'span',
			'class' => 'prop_part',
			$this->owner->rtp( $elem )
		);
	}

	/**
	 * Build "final" cell which contain tagarray representation of
	 * proposal parts, proposal errors and one adjascent category
	 * and then add it to the row
	 */
	function addCell() {
		if ( count( $this->error ) > 0 ) {
			# merge previous errors to current cell
			$this->cell = array_merge( $this->error, $this->cell );
			$this->error = array();
		}
		if ( count( $this->cell ) > 0 ) {
			$this->row[] = $this->cell;
		}
	}

} /* end of qp_TextQuestionViewRow class */

/**
 * Stores question proposals views (see qp_textqestion.php) and
 * allows to modify these for results of quizes at the later stage (see qp_poll.php)
 * An attempt to make somewhat cleaner question view
 * todo: further refactoring of views for different question types
 */
class qp_TextQuestionView extends qp_StubQuestionView {

	## the layout of question
	# true: categories and proposal parts will be placed into
	# table cells (display:table-cell)
	# false: categories and proposal parts will be placed into
	# spans (display:inline)
	var $tabularDisplay = false;
	# whether the resulting display table should be transposed
	# meaningful only when $this->tabularDisplay is true
	var $transposed = false;
	# how many characters will hold horizontal line of textarea;
	# currently is unused, because textarea 'cols' attribute renders
	# poorly in table cells in modern versions of Firefox, so
	# we are using CSS $this->textInputStyle instead
	# var $textwidth = 0;

	# default style of text input
	var $textInputStyle = '';
	# view row
	var $vr;

	/**
	 * @param $parser
	 * @param $frame
	 * @param  $showResults     poll's showResults (may be overriden in the question)
	 */
	function __construct( Parser $parser, PPFrame $frame, $showResults ) {
		parent::__construct( $parser, $frame );
		$this->vr = new qp_TextQuestionViewRow( $this );
		/* todo: implement showResults */
	}

	static function newFromBaseView( $baseView ) {
		return new self( $baseView->parser, $baseView->ppframe, $baseView->showResults );
	}

	function setLayout( $layout, $textwidth ) {
		if ( $layout !== null ) {
			$this->tabularDisplay = strpos( $layout, 'tabular' ) !== false;
			$this->transposed = strpos( $layout, 'transpose' ) !== false;
		}
		if ( $textwidth !== null ) {
			if ( preg_match( qp_Setup::PREG_POSITIVE_INT4_MATCH, $textwidth ) ) {
				$this->textInputStyle = "width:{$textwidth}em;";
			} elseif ( $textwidth === 'auto' ) {
				$this->textInputStyle = 'width:auto;';
			}
		}
	}

	/**
	 * Add the list of parsed viewtokens matching current proposal / categories row
	 */
	function addProposal( $proposalId, qp_TextQuestionProposalView $propview ) {
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
					$propview->prependErrorToken( $prop_desc, '', false );
					$propview->rowClass = 'proposalerror';
					continue;
				}
				# specified category of proposal has errors;
				# scan the category views row to highlight erroneous categories
				$foundCats = $propview->applyInterpErrors( $prop_desc );
				if ( !$foundCats ) {
					# there are category errors specified in interpretation result;
					# however none of them are found in proposal's view
					# generate error for the whole proposal
					$propview->prependErrorToken( wfMsg( 'qp_interpetation_wrong_answer' ), '', false );
					$propview->rowClass = 'proposalerror';
				}
			}
		}
	}

	/**
	 * Generates tagarray representation from the proposal view.
	 * @param   $pkey  integer
	 *   proposal index (starting from 0):
	 *     it is required for JS code, because text questions
	 *     now may optionally have "tabular transposed" layout.
	 * @param   $propview  qp_TextQuestionProposalView
	 * @return  tagarray
	 */
	function renderParsedProposal( $pkey, qp_TextQuestionProposalView $propview ) {
		$vr = $this->vr;
		# proposal prefix for category tag id generation
		$vr->reset( "tx{$this->ctrl->poll->mOrderId}q{$this->ctrl->mQuestionId}p{$pkey}" );
		foreach ( $propview->viewtokens as $elem ) {
			$vr->cell = array();
			if ( is_object( $elem ) ) {
				if ( isset( $elem->options ) ) {
					$className = 'cat_part';
					if ( $propview->catreq === 'all' && $elem->unanswered ) {
						$className .= ' cat_noanswer';
					}
					if ( isset( $elem->interpError ) ) {
						if ( !qp_Renderer::hasClassName( $className, 'cat_noanswer' ) ) {
							$className .= ' cat_noanswer';
						}
						# create view for proposal/category error message
						$vr->addError( $elem );
					}
					# create view for the input / textarea options part
					if ( count( $elem->options ) === 1 ) {
						# one option produces html text / radio / checkbox input or an textarea
						$vr->addInput( $elem, $className );
						$vr->addCell();
						continue;
					}
					# multiple options produce html select / options
					$vr->addSelect( $elem, $className );
					$vr->addCell();
				} elseif ( isset( $elem->error ) ) {
					# create view for proposal/category error message
					$vr->error[] = array(
						'__tag' => 'span',
						'class' => 'proposalerror',
						$elem->error
					);
				} else {
					throw new MWException( 'Invalid view token encountered in ' . __METHOD__ );
				}
			} else {
				# create view for the proposal part
				$vr->addProposalPart( $elem );
				$vr->addCell();
			}
		}
		$vr->cell = array();
		# make sure last "error" tokens are added, if any:
		$vr->addCell();
		if ( $this->tabularDisplay ) {
			return $vr->row;
		}
		return array( $vr->row );
	}

	/**
	 * Renders question table with header and proposal views
	 */
	function renderTable() {
		$questionTable = array();
		# add header views to $questionTable
		foreach ( $this->hviews as $header ) {
			$rowattrs = array();
			$attribute_maps = array();
			if ( is_object( $header ) ) {
				$row = &$header->row;
				$rowattrs['class'] = $header->className;
				$attribute_maps = &$header->attribute_maps;
			} else {
				$row = &$header;
			}
			qp_Renderer::addRow( $questionTable, $row, $rowattrs, 'th', $attribute_maps );
		}
		foreach ( $this->pviews as $pkey => $propview ) {
			$prop = $this->renderParsedProposal( $pkey, $propview );
			$rowattrs = array( 'class' => $propview->rowClass );
			if ( $this->transposed ) {
				qp_Renderer::addColumn( $questionTable, $prop, $rowattrs );
			} else {
				qp_Renderer::addRow( $questionTable, $prop, $rowattrs );
			}
		}
		return $questionTable;
	}

} /* end of qp_TextQuestionView class */
