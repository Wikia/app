<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Data structure WCText.
 * Stores and renders a text attribute.
 */
class WCText extends WCData {

	# The text.
	protected $text;


	/**
	 * Constructor.
	 * @param WCCitation $citation = the WCCitation object
	 * @param WCScopeEnum $scope = the scope (i.e., work, container, series, etc.)
	 * @param WCParameterEnum $type = the type of property.
	 * @param string $text = the unprocessed text.
	 */
	public function __construct( $text ) {
		$this->text = $text;
	}


	/**
	 * Get text.
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}


	public function __toString() {
		return $this->text;
	}


	/**
	 * Determine if $this can be considered a short form of the argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCText $text
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $text ) {
		if ( strnatcasecmp( $this->text === $text->getText() ) === 0 ) return 1; else return False;
	}


}

