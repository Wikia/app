<?php
/**
 * File holding class WikiObjectModelParser, the base for all object model parser in WOM.
 *
 * Deal plain text only, just get next text token
 *
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WikiObjectModelParser {
	protected $m_parserId;

	/**
	 * Array of error text messages. Private to allow us to track error insertion
	 * (PHP's count() is too slow when called often) by using $mHasErrors.
	 * @var array
	 */
	protected $mErrors = array();

	/**
	 * Boolean indicating if there where any errors.
	 * Should be modified accordingly when modifying $mErrors.
	 * @var boolean
	 */
	protected $mHasErrors = false;

	public function __construct() {
		$this->m_parserId = WOM_PARSER_ID_TEXT;
	}

// /// Processing methods /////
	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		$r = preg_match( '/^[a-zA-Z0-9]+/', $text, $m );
		if ( $r ) return array( 'len' => strlen( $m[0] ), 'obj' => new WOMTextModel( $m[0] ) );
		// special case, <nowiki>, <noinclude>
		$idx = stripos( $text, '<nowiki>' );
		if ( $idx === 0 ) {
			$len = stripos( $text, '</nowiki>' );
			$len += strlen( '</nowiki>' );
			return array( 'len' => $len, 'obj' => new WOMTextModel( substr( $text, 0, $len ) ) );
		}
		$idx = stripos( $text, '<noinclude>' );
		if ( $idx === 0 ) {
			$len = stripos( $text, '</noinclude>' );
			$len += strlen( '</noinclude>' );
			return array( 'len' => $len, 'obj' => new WOMTextModel( substr( $text, 0, $len ) ) );
		}

		return array( 'len' => 1, 'obj' => new WOMTextModel( $text { 0 } ) );
	}

	// E.g.,
	// semantic property is extended from internal links
	// parser functions is extended from templates
	public function subclassOf( $parserInstance ) {
		return ( $this instanceof $parserInstance );
	}

	// return length of closed chars, false if not closed
	// only available in parsers for collection models
	public function isObjectClosed( $obj, $text, $offset ) { return false; }

// /// Get methods /////
	public function getParserID() {
		return $this->m_parserId;
	}

	// specified next parser. e.g., template parser -> parameter parser
	public function getSubParserID( $obj ) { return ''; }

	/**
	 * Return a string that displays all error messages as a tooltip, or
	 * an empty string if no errors happened.
	 */
	public function getErrorText() {
		if ( defined( 'SMW_VERSION' ) )
			return smwfEncodeMessages( $this->mErrors );

		return $this->mErrors;
	}

	/**
	 * Return an array of error messages, or an empty array
	 * if no errors occurred.
	 */
	public function getErrors() {
		return $this->mErrors;
	}
}
