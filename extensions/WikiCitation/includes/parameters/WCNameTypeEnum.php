<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCNameTypeEnum extends WCParameterEnum {
	const author           = 0;
	const editorTranslator = 1; # This goes before editor and translator, because otherwise, the search would stop when it reaches either of the shorter terms.
	const editor           = 2;
	const translator       = 3;
	const publisher        = 4;
	const interviewer      = 5;
	const recipient        = 6;
	const composer         = 7;
	const __default        = self::author;

	public static $author;
	public static $editorTranslator;
	public static $editor;
	public static $translator;
	public static $publisher;
	public static $interviewer;
	public static $recipient;
	public static $composer;

	public static $magicWordKeys = array(
		self::author           => 'wc_author',
		self::editorTranslator => 'wc_editor_translator',
		self::editor           => 'wc_editor',
		self::translator       => 'wc_translator',
		self::publisher        => 'wc_publisher',
		self::interviewer      => 'wc_interviewer',
		self::recipient        => 'wc_recipient',
		self::composer         => 'wc_composer'
	);
	public static $substitutes = array(
		self::author           => array( self::author, self::editorTranslator, self::editor, self::translator, self::interviewer, self::composer, self::recipient, self::publisher ),
		self::editorTranslator => array( self::editorTranslator, self::editor, self::translator ),
		self::editor           => array( self::editor ),
		self::translator       => array( self::translator ),
		self::publisher        => array( self::publisher ),
		self::interviewer      => array( self::interviewer, self::author ),
		self::recipient        => array( self::recipient, self::author ),
		self::composer         => array( self::composer, self::author )
	);
	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$author           = new self( self::author );
		self::$editorTranslator = new self( self::editorTranslator );
		self::$editor           = new self( self::editor );
		self::$translator       = new self( self::translator );
		self::$publisher        = new self( self::publisher );
		self::$interviewer      = new self( self::interviewer );
		self::$recipient        = new self( self::recipient );
		self::$composer         = new self( self::composer );
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
WCNameTypeEnum::init();
