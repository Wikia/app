<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Iterates through the raw proposals of current question.
 * Parses attributes from source (raw) proposal line or from DB field.
 * Build raw proposal line from existing attributes.
 */
class qp_PropAttrs {

	# associated instance of qp_StubQuestion
	# it is unavailable when calling $this->getFromDB()
	protected $question = null;
	# array with keys of $question->raws (when available)
	protected $rawkeys;
	# index of $this->rawkeys (when available)
	protected $rawidx;
	# code of error after getting attributes
	# integer 0 means there is no error
	# string  key of wiki error message
	public $error;
	# proposal name (for interpretation scripts);
	# '' means there is no name
	public $name;
	# minimal required count of answered categories for current proposal
	# null means there is no "catreq" attribute defined
	# (will use question/poll default value)
	public $catreq;
	# whether the current proposal allows empty text fields submission / storage
	# null means there is no 'emptytext' attribute defined
	# (will use question/poll default value)
	public $emptytext;
	# qpoll tag source text of proposal:
	#   * with source cat_parts / prop_parts
	#   * without proposal attributes
	public $cpdef;
	# text of proposal prepared to be stored into DB
	#   * without proposal attributes
	#   * contains parsed cat_parts / prop_parts for question type="text"
	#   * does not contain parsed cat_parts for another types of questions
	public $dbText;

	/**
	 * Set parent instance
	 */
	public function setQuestion( qp_StubQuestion $question ) {
		$this->question = $question;
		$this->reset();
	}

	/**
	 * Begin new iteration through raw proposals.
	 */
	public function reset() {
		$this->rawkeys = array_keys( $this->question->raws );
		$this->rawidx = $this->question->rawProposalKey;
	}

	/**
	 * Iterates through question raws array, using only raw proposals.
	 * Raw categories and category spans (if any) are processed separately.
	 * @return  boolean
	 *   true  $this properties are populated
	 *   false there are no more raws available
	 */
	public function iterate() {
		if ( $this->rawidx >= count( $this->rawkeys ) ) {
			return false;
		}
		$this->getFromSource( $this->question->raws[$this->rawkeys[$this->rawidx++]] );
		$this->applyDefaultAttrs();
		return true;
	}

	public function getFromDB( $proposal_text ) {
		$this->question = null;
		$this->getFromSource( $proposal_text );
		$this->dbText = $this->cpdef;
		$this->cpdef = null;
		# assume that DB state is always consistant
		$this->error = 0;
	}

	/**
	 * Get proposal attributes from raw proposal text (source page text or DB field)
	 *
	 * @param  $proposal_text  string  raw proposal text
	 */
	public function getFromSource( $proposal_text ) {
		# set default values of properties
		$this->error = 0;
		$this->name = '';
		$this->dbText =
		$this->catreq = null;
		$this->emptytext = null;
		$this->cpdef = $proposal_text;
		$matches = array();
		# try to match the raw proposal name (without specific attributes)
		preg_match( '/^:\|\s*(.+?)\s*\|\s*(.+?)\s*$/su', $this->cpdef, $matches );
		if ( count( $matches ) < 3 ||
				( $this->name = $matches[1] ) === '' ) {
			# raw proposal name is not defined or empty
			return;
		}
		# check, whether raw proposal name will fit into the corresponding DB field
		if ( strlen( $this->getAttrDef() ) >= qp_Setup::$field_max_len['proposal_text'] ) {
			$this->setError( 'qp_error_too_long_proposal_name' );
			return;
		}
		# try to get xml-like attributes;
		$paramkeys = qp_Setup::getXmlLikeAttributes( $this->name, array( 'name', 'catreq', 'emptytext' ) );
		if ( $paramkeys['name'] !== null ) {
			# name attribute found
			$this->name = trim( $paramkeys['name'] );
		}
		if ( $paramkeys['catreq'] !== null ) {
			$this->catreq = self::getSaneCatReq( $paramkeys['catreq'] );
		}
		if ( $paramkeys['emptytext'] !== null ) {
			$this->emptytext = self::getSaneEmptyText( $paramkeys['emptytext'] );
		}
		if ( is_numeric( $this->name ) ) {
			$this->setError( 'qp_error_numeric_proposal_name' );
			return;
		} elseif ( preg_match( '/$.^/msu', $this->name ) ) {
			$this->setError( 'qp_error_multiline_proposal_name' );
			return;
		}
		# remove raw proposal name from proposal definition
		$this->cpdef = $matches[2];
	}

	/**
	 * Applies default attribute values from question, when current proposal
	 * attributes are undefined.
	 * note: this cannot be integrated into $this->getFromSource(), because
	 *   $this->getFromSource() is also called from $this->getFromDB().
	 */
	public function applyDefaultAttrs() {
		if ( $this->catreq === null ) {
			$this->catreq = $this->question->mCatReq;
		}
		if ( $this->emptytext === null ) {
			$this->emptytext = $this->question->mEmptyText;
		}
	}

	/**
	 * Get sanitized "catreq" attribute value.
	 * @return  mixed
	 *   string 'all' require all categories to be filled
	 *   integer  count of categories to be filled
	 */
	public static function getSaneCatReq( $attr_val ) {
		$attr_val = trim( $attr_val );
		if ( is_numeric( $attr_val ) ) {
			# return count of categories to be filled
			return ( $attr_val > 0 ) ? intval( $attr_val ) : 0;
		}
		# require all categories to be filled
		return 'all';
	}

	/**
	 * Get sanitized 'emptytext' attribute value
	 * @return  boolean
	 *   true  empty text fields will be allowed
	 *   false otherwise
	 */
	public static function getSaneEmptyText( $attr_val ) {
		return trim( $attr_val ) !== 'no';
	}

	/**
	 * Set error state.
	 * Make sure $this->cpdef contains the full raw proposal line,
	 * otherwise the output of $this->__toString() will be incorrect.
	 */
	protected function setError( $code ) {
		$this->error = $code;
		$this->name = '';
		$this->catreq = null;
	}

	/**
	 * Return attributes part of raw proposal line.
	 */
	public function getAttrDef() {
		# we do not store "catreq" and "emptytext" attributes because:
		# 1. they are not used in qp_QuestionData
		# 2. we do not store poll's/question's "catreq" / "emptytext" anyway
		return ( $this->name === '' ) ? '' : ":|{$this->name}|";
		/*
			return ":|name=\"{$this->name}\" catreq=\"{$this->catreq}\" emptytext=\"" .
				( ( $this->emptytext !== 'no' ) ?
					'yes' :
					'no'
				) .
				"\"|";
		*/
	}

	/**
	 * Checks, whether current proposal has not enough of user-answered categories,
	 * according to current question instance.
	 * @param  $answered_cats_count  integer
	 *   number of user-answered categories in current proposal
	 * @param  $total_cats_count  integer
	 *   total amount of categories in current proposal
	 * @return  boolean
	 *   true  not enough of categories are filled
	 *   false otherwise
	 */
	function hasMissingCategories( $answered_cats_count, $total_cats_count ) {
		# How many categories has to be answered,
		# all defined in row or the amount specified by "catreq" attribute?
		# total amount of categories in current proposal
		$countRequired = ($this->catreq === 'all') ? $total_cats_count : $this->catreq;
		if ( $countRequired > $total_cats_count ) {
			# do not require to fill more categories
			# than is available in current proposal row
			$countRequired = $total_cats_count;
		}
		return $answered_cats_count < $countRequired;
	}

	/**
	 * Return raw proposal text to be stored in DB (if any)
	 */
	public function __toString() {
		if ( $this->dbText === null ) {
			throw new MWException( 'dbText is uninitialized in ' . __METHOD__ );
		}
		return $this->getAttrDef() . $this->dbText;
	}

} /* end of qp_PropAttrs class */
