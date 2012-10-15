<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Manipulates the list of text question view tokens in single proposal row,
 * View tokens are the combined proposal/categories definition.
 */
class qp_TextQuestionProposalView extends qp_StubQuestionProposalView {

	# count of required categories to be non-empty in current proposal
	var $catreq = 'all';
	# list of viewtokens
	#   elements of string type contain proposal parts;
	#   elements of stdClass :
	#     property 'options' indicates current category options list
	#     property 'error' indicates error message
	var $viewtokens = array();
	var $lastTokenType = '';

	/**
	 * Add new proposal part (between two categories or line bounds)
	 * It is just an element of string type
	 *
	 * @param  $token  string  proposal part
	 */
	function addProposalPart( $token ) {
		if ( $this->lastTokenType === 'proposal' ) {
			# add to already existing proposal part
			$last_prop = array_pop( $this->viewtokens );
			$last_prop .= $token;
			array_push( $this->viewtokens, $last_prop );
			return;
		}
		# start new proposal part
		$this->viewtokens[] = $token;
		$this->lastTokenType = 'proposal';
	}

	/**
	 * Creates viewtokens entry with current category definition
	 * @param  $opt  qp_TextQuestionOptions
	 *         should contain "closed" category definition with prepared
	 *         category input options
	 * @param  $name  string  name of input/select element (used in the view)
	 * @param  $text_answer  string user's POSTed category answer
	 *         (empty string '' means no answer)
	 * @param  $unanswered  boolean indicates whether the category of submitted poll
	 *                      was non-blank (true) or not (false)
	 * @return  stdClass object with viewtokens entry
	 */
	function addCatDef( qp_TextQuestionOptions $opt, $name, $text_answer, $unanswered ) {
		# $catdef instanceof stdClass properties:
		# property 'type' contains type of current category: 'text', 'checkbox', 'radio'
		# property 'options' stores an array of user options
		#          Multiple options will be selected from the list
		#          Single option will be displayed as text input
		# property 'name' contains name of input element
		# property 'value' contains value previousely chosen
		#          by user (if any)
		# property 'attributes' contain extra atttibutes of current category definition
		$viewtoken = (object) array(
			'type' => $opt->type,
			'options' => $opt->input_options,
			'name' => $name,
			'value' => $text_answer,
			'unanswered' => $unanswered,
			'attributes' => $opt->attributes
		);
		# fix values of measurable attributes (allow only non-negative integer values)
		# zero value means attribute is unused
		foreach ( array( 'width', 'height' ) as $measurable ) {
			$val = &$viewtoken->attributes[$measurable];
			if ( $val === null ) {
				$val = 0;
			} elseif ( $val !== 'auto' ) {
				$val = preg_match( qp_Setup::PREG_POSITIVE_INT4_MATCH, $val ) ? intval( $val ) : 0;
			}
		}
		$this->viewtokens[] = $viewtoken;
		$this->lastTokenType = 'category';
	}

	/**
	 * Adds new non-empty error message to the begin of the list of parsed tokens (viewtokens)
	 * @param    $msg - text of message
	 * @param    $state - set new question controller state
	 *               note that the 'error' state cannot be changed and '' state cannot be set
	 * @param    $rowClass - string set rowClass value, boolean false (do not set)
	 */
	function prependErrorToken( $msg, $state, $rowClass = 'proposalerror' ) {
		$errmsg = $this->ctrl->view->bodyErrorMessage( $msg, $state, $rowClass );
		# note: when $state == '' every $errmsg is non-empty;
		#       when $state == 'error' only the first $errmsg is non-empty;
		if ( $errmsg !== '' ) {
			array_unshift( $this->viewtokens, (object) array( 'error'=> $errmsg ) );
			if ( count( $this->viewtokens ) < 2 ) {
				$this->lastTokenType = 'errmsg';
			}
		}
	}

	/**
	 * Adds new non-empty error message to the end of the list of parsed tokens (viewtokens)
	 * @param    $msg - text of message
	 * @param    $state - set new question controller state
	 *               note that the 'error' state cannot be changed and '' state cannot be set
	 * @param    $rowClass - string set rowClass value, boolean false (do not set)
	 */
	function addErrorToken( $msg, $state, $rowClass = 'proposalerror' ) {
		$errmsg = $this->ctrl->view->bodyErrorMessage( $msg, $state, $rowClass );
		# note: when $state == '' every $errmsg is non-empty;
		#       when $state == 'error' only the first $errmsg is non-empty;
		if ( $errmsg !== '' ) {
			array_push( $this->viewtokens, (object) array( 'error'=> $errmsg ) );
			$this->lastTokenType = 'errmsg';
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
		$cat_id = -1;
		foreach ( $this->viewtokens as &$token ) {
			if ( is_object( $token ) && property_exists( $token, 'options' ) ) {
				# found a category definition
				$cat_id++;
				if ( isset( $prop_desc[$cat_id] ) ) {
					$foundCats = true;
					# whether to use custom or standard error message
					if ( !is_string( $cat_desc = $prop_desc[$cat_id] ) ) {
						$cat_desc = wfMsg( 'qp_interpetation_wrong_answer' );
					}
					# mark the input to highlight it during the rendering
					if ( ( $msg = $this->ctrl->view->bodyErrorMessage( $cat_desc, '', false ) ) !=='' ) {
						# we call with question state = '', so the returned $msg never should be empty
						# unless there was a syntax error, however during the interpretation stage there
						# should be no syntax errors, so we can assume that $msg is never equal to ''
						$token->interpError = $msg;
					}
				}
			}
		}
		return $foundCats;
	}

} /* end of qp_TextQuestionProposalView */
