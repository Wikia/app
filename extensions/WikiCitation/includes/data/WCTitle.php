<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCTitleFormat extends WCEnum {
	const normal    = 0;
	const quoted    = 1;
	const italic    = 2;
	const __default = self::normal;
}


/**
 * Data structure WCTitle.
 * Contains all information needed to be known about a title.
 */
class WCTitle extends WCData {

	# Regexes initialized by WCTitle::init()
	protected static $patternExternal, $patternInternal;

	# The title, as text.
	protected $title;

	/**
	 * Static initializer.
	 */
	public static function init() {
		$iExQuoteMW                = MagicWord::get( 'wc_initial_exterior_quote' );
		$fExQuoteMW                = MagicWord::get( 'wc_final_exterior_quote' );
		$iInQuoteMW                = MagicWord::get( 'wc_initial_interior_quote' );
		$fInQuoteMW                = MagicWord::get( 'wc_final_interior_quote' );
		$iExQuotes                 = implode( $iExQuoteMW->getSynonyms() );
		$fExQuotes                 = implode( $fExQuoteMW->getSynonyms() );
		$iInQuotes                 = implode( $iInQuoteMW->getSynonyms() );
		$fInQuotes                 = implode( $fInQuoteMW->getSynonyms() );
		self::$patternExternal   = '/(^|[\p{Ps}\p{Zs}\p{Pd}\p{Pi}\'])[' . $iExQuotes . '](.*?)[' . $fExQuotes . ']($|[\p{Pe}\p{Zs}\.,;:?!\p{Pd}\p{Pf}\'])/usS';
		self::$patternInternal   = '/(^|[\p{Ps}\p{Zs}\p{Pd}\p{Pi}"])[' . $iInQuotes . '](.*?)[' . $fInQuotes . ']($|[\p{Pe}\p{Zs}\.,;:?!\p{Pd}\p{Pf}"])/usS';
	}

	/**
	 * Constructor.
	 *
	 * Converts character-based quotes to semantic HTML quotes.
	 * For now, this is done as an intermediate step to regularize quotes, and
	 * to allow quotes to be shifted if the entire title is quoted.
	 * This method assumes that the title does not contain quoted HTML
	 * attributes.
	 *
	 * @param WCCitation $citation = the WCCitation object
	 * @param WCScopeEnum $scope = the scope (i.e., work, container, series, etc.)
	 * @param WCParameterEnum $type = the type of property.
	 * @param string $title = the unprocessed text of the title.
	 */
	public function __construct( $title ) {

		# Regex for replacing internal quotes with markers. Searches for
		# pairs of internal quotes that are closest to each other.
		static $replacement = '$1<q>$2</q>$3';
		do { # make substitutions for nested quotes until string stops changing.
			$oldTitle = $title;
			$title = preg_replace( self::$patternInternal, $replacement, $title );
		} while ( $oldTitle != $title );

		# replace double quotes
		do { # make substitutions for nested quotes until string stops changing.
			$oldTitle = $title;
			$title = preg_replace( self::$patternExternal, $replacement, $title );
		} while ( $oldTitle != $title );

		$this->title = $title;

	}


	/**
	 * Get title.
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	public function __toString() {
		return $this->title;
	}


	/**
	 * Determine if $this can be considered a short form of the argument.
	 * If so, then determine the number of matches.
	 *
	 * @param WCTitle $title
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $title ) {
		return strnatcasecmp( $this->title, $title->getTitle() ) === 0 ? 1 : False;
	}


}

/**
 * Static initializer.
 */
WCTitle::init();

