<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * An interpretation result of user answer to the quiz
 */
class qp_InterpResult {

	private static $props = array( 'error', 'short', 'long', 'structured' );

	# short answer. it is supposed to be sortable and accountable in statistics
	# by default, it is private (displayed only in Special:Pollresults page)
	# blank value means short answer is unavailable
	var $short = '';
	# long answer. it is supposed to be understandable by amateur users
	# by default, it is public (displayed everywhere)
	# blank value means long answer is unavailable
	var $long = '';
	# structured answer. scalar value or an associative array.
	# object instances are not allowed.
	# their purpose is:
	#   * exported to XLS cells to be analyzed by external tools
	#   * import interpretation results of another polls to
	#     current interpretation script make cross-poll (multi-poll)
	#     interpretations
	var $structured = '';
	# error message. non-blank value indicates interpretation script error
	# either due to incorrect script code, or a script-generated one
	var $error = '';
	# whether the user answer should be stored in case of
	# erroneous interpretation results:
	#   true:  education application, to see pupul's mistake;
	#   false: form validation, to prevent visibility of next poll in
	#          dependance chain until the form is filled properly;
	var $storeErroneous = true;
	# interpretation result
	# 2d array of errors generated for [question][proposal]
	# 3d array of errors generated for [question][proposal][category]
	# false if no errors
	var $qpcErrors = false;

	/**
	 * @param $init - optional array of properties to be initialized
	 */
	function __construct( $init = null ) {
		if ( is_array( $init ) ) {
			foreach ( self::$props as $prop ) {
				if ( array_key_exists( $prop, $init ) ) {
					$this->{ $prop } = $init[$prop];
				}
			}
			return;
		}
	}

	function hasVisibleProperties() {
		foreach ( self::$props as $prop ) {
			if ( $this->{ $prop } !== '' && qp_Setup::$show_interpretation[$prop] ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * "global" error message
	 */
	function setError( $msg ) {
		$this->error = $msg;
		return $this;
	}

	/**
	 * Set question / proposal error message (for quizes).
	 *
	 * @param $msg  mixed
	 *   string error message for [question][proposal][category];
	 *   non-string will cause displaying default message for that qp / qpc;
	 * @param $qidx  mixed
	 *   string  question name
	 *   int index of poll's question
	 * @param $pidx  mixed
	 *   string proposal name
	 *   int index of question's proposal
	 * @param $cidx  integer
	 *   index of proposal's category (optional)
	 */
	function setQPCerror( $msg, $qidx, $pidx, $cidx = null ) {
		if ( !is_array( $this->qpcErrors ) ) {
			$this->qpcErrors = array();
		}
		if ( !array_key_exists( $qidx, $this->qpcErrors ) ) {
			$this->qpcErrors[$qidx] = array();
		}
		if ( $cidx === null ) {
			# proposal interpretation error message
			$this->qpcErrors[$qidx][$pidx] = $msg;
			return;
		}
		# proposal's category interpretation error message
		if ( !array_key_exists( $pidx, $this->qpcErrors[$qidx] ) ||
				!is_array( $this->qpcErrors[$qidx][$pidx] ) ) {
			# remove previous proposal interpretation error message because
			# now we have more precise category interpretation error message
			$this->qpcErrors[$qidx][$pidx] = array();
		}
		$this->qpcErrors[$qidx][$pidx][$cidx] = $msg;
	}

	function setDefaultErrorMessage() {
		if ( is_array( $this->qpcErrors ) && $this->error == '' ) {
			$this->error = wfMsg( 'qp_interpetation_wrong_answer' );
		}
		return $this;
	}

	function isError() {
		return $this->error != '' || is_array( $this->qpcErrors );
	}

	function hasToBeStored() {
		return !$this->isError() || $this->storeErroneous;
	}

	/**
	 * Builds tabular representation of the current structured answer
	 * @return  array  containing nodes for every level of of structured answer,
	 *                 line per line;
	 *
	 * "line" is an array( 'keys'=>(,,),'vals'=>(,,) ) when
	 * current recursive node is an associative array;
	 * "line is an array( 'vals'=>value) when current recursive node
	 * is a scalar value.
	 *
	 */
	function getStructuredAnswerTable() {
		$strucTable = array();
		$structured = unserialize( $this->structured );
		$this->buildStructuredTable( $strucTable, $structured );
		return $strucTable;
	}

	/**
	 * Build a projection of associative array tree to 2nd dimensional array
	 * @modifies  $strucTable  array
	 *   destination 2nd dimensional array;
	 *   see description in $this->getStructuredAnswerTable();
	 * @param  $structured  mixed
	 *   array / scalar current node of associative array tree
	 * @param  $level_header  string
	 *   current "folder-like" prefix of structured answer nested key
	 * (levels are separated with " / ")
	 */
	function buildStructuredTable( array &$strucTable, &$structured, $level_header = '' ) {
		$keys = array();
		$vals = array();
		if ( is_array( $structured ) ) {
			foreach ( $structured as $key => &$val ) {
				# display only non-numeric keys as "folders"
				$level_key = is_int( $key ) ? '' : strval( $key );
				# do not display '/' separator for root "folders"
				$new_level_header = ( $level_header === '' ) ? $level_key : "{$level_header} / {$level_key}";
				if ( is_array( $val ) ) {
					$this->buildStructuredTable( $strucTable, $val, $new_level_header );
				} else {
					$keys[] = $new_level_header;
					$vals[] = $val;
				}
			}
			# associative keys and their vals
			$strucTable[] = array( 'keys' => $keys, 'vals' => $vals );
		} else {
			# scalar value has no keys
			$strucTable[] = array( 'vals' => strval( $structured ) );
		}
	}

} /* end of qp_InterpResult class */
