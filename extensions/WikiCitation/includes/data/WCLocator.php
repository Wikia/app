<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Data structure WCLocator.
 * Stores and renders a location or range of locations in a source.
 */
class WCLocator {

	public $ranges;

	protected static $listTerms, $rangeTerms;

	public static function init() {
		$listDelimiterMW    = MagicWord::get( 'wc_list_delimiter' );
		$rangeDelimiterMW   = MagicWord::get( 'wc_range_delimiter' );
		self::$listTerms  = '\s*' . implode( '\s*|\s*', $listDelimiterMW->getSynonyms() ) . '\s*|\s+';
		self::$rangeTerms = '/^\p{Zs}*[\p{Pi}"\']?((?(?<=[\p{Pi}"\']).*?(?=[\p{Pf}"\'])|(?(?=\p{Ps}).+?\p{Pe}|.))*?)[\p{Pf}"\']?\p{Zs}*(?:' . implode( '|', $rangeDelimiterMW->getSynonyms() ) . '|\p{Pd})\p{Zs}*[\p{Pi}"\']*(.*?)[\p{Pf}"\']*\p{Zs}*$/uS';
	}

	/**
	 * Constructor.
	 * This should be able to handle complex ranges like
	 * "45(iv)45-(v)7, 45(ii)52-61, and 45(ix)99-100".
	 * A dash or hyphen will be interpreted as a range, unless the number is
	 * enclosed in quotation marks.
	 * @param WCCitation $citation = the WCCitation object
	 * @param WCScopeEnum $scope = the scope (i.e., work, container, series, etc.)
	 * @param WCParameterEnum $type = the type of property.
	 * @param string $text = the unprocessed locator text.
	 */
	public function __construct( $text ) {
		$this->ranges = mb_split( self::$listTerms, $text ); # Split by range-delimiting terms like comma or and
		foreach( $this->ranges as &$range ) {
			if ( !preg_match( self::$rangeTerms, $range, $matches ) ) {
				$range = array( $range );
				continue;
			}
			$range = array( $matches[1], $matches[2] );
		}
		return;
	}


	/**
	 * Render the text.
	 * @return string
	 */
	public function render( $endSeparator = '' ) {
		$text = '';
		$rangeCount = count( $this->ranges );
		# single range:
		if ( $rangeCount == 1 ) {
			$text = implode( '–', reset( $this->ranges ) );
		}
		# two ranges
		elseif ( $rangeCount == 2 ) {
			$text = implode( '–', reset( $this->ranges ) );
			$text .= ' & ' . implode( '–', next( $this->ranges ) );
		}
		# three or more ranges:
		else {
			$text = implode( '–', reset( $this->ranges ) );
			for ( $i = 2; $i < $rangeCount-1; $i++ ) {
				$text .= ', ' . implode( '–', next( $this->ranges ) );
			}
			$text .= ' & ' . implode( '–', next( $this->ranges ) );
		}
		if ( $endSeparator ) {
			$chrL = mb_substr( $text, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			return $text . $endSeparator;
		} else {
			return $text;
		}
	}


	public function __toString() {
		$arr = $this->ranges;
		foreach( $arr as &$range ) {
			$range = implode( '–', $range );
		}
		return implode( ', ', $arr );
	}

}

/**
 * Static initializer
 */
WCLocator::init();