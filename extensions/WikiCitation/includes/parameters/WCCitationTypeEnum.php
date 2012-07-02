<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * The type of the citation, either note, biblio, or inline. Note citations
 * are found in footnotes and endnotes. Biblio citations are found in
 * bibliographies. Inline citations are found in the main text.
 */
class WCCitationTypeEnum extends WCParameterEnum {
	const inline     = 0;
	const note       = 1;
	const biblio     = 2;
	const authorDate = 3;
	const __default  = 0;

	public static $inline;
	public static $note;
	public static $biblio;
	public static $authorDate;

	public static $magicWordKeys = array(
		self::inline       => 'wc_inline',
		self::note         => 'wc_note',
		self::biblio       => 'wc_bibliography',
		self::authorDate   => 'wc_author_date',
	);
	public static $substitutes = array();
	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$inline     = new self( self::inline );
		self::$note       = new self( self::note );
		self::$biblio     = new self( self::biblio );
		self::$authorDate = new self( self::authorDate );
	}

	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public function __construct( $key = self::__default ) {
		parent::__construct( $key );
		$subs = &self::$substitutes[ $this->key ];
		if ( $subs ) {
			$this->substituteArray = $subs;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function match( $parameterText ) {
		$id = self::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return new self( self::$flipMagicWordKeys[ $id ] );
		} else {
			return Null;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchVariable( $parameterText ) {
		list( $id, $var ) = self::$magicWordArray->matchVariableStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $var );
		} else {
			return Null;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchPrefix( $parameterText ) {
		$id = self::$magicWordArray->matchStartAndRemove( $parameterText );
		if ( $id ) {
			# Remove any initial punctuation or spaces
			$parameterText = preg_replace( '/^[\p{P}\p{Z}\p{C}]+/u', '', $parameterText );
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $parameterText );
		} else {
			return array( Null, $parameterText );
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchPartAndNumber( $parameterText ) {
		# Extract number and remove number, white spaces and punctuation.
		if ( preg_match( '/\d+/u', $parameterText, $matches ) ) {
			$numString = $matches[0];
			$num = (int) $numString;
			$parameterText = preg_replace( '/' . $numString . '|[\p{P}\p{Z}\p{C}]+/uS', '', $parameterText );
		} else {
			$num = 1;
		}
		# Match what remains.
		$id = self::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $num );
		} else {
			return array( Null, $num );
		}
	}
	
	
}
WCCitationTypeEnum::init();
