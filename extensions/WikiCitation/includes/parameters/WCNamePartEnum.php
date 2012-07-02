<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCNamePartEnum extends WCParameterEnum {
	const literal             = 0;
	const surname             = 1;
	const given               = 2;
	const nameLink            = 3;
	const suffix              = 4;
	const droppingParticle    = 5;
	const nonDroppingParticle = 6;
	const __default           = self::literal;

	public static $literal;
	public static $surname;
	public static $given;
	public static $nameLink;
	public static $suffix;
	public static $droppingParticle;
	public static $nonDroppingParticle;


	public static $magicWordKeys = array(
		self::surname             => 'wc_surname',
		self::given               => 'wc_given',
		self::literal             => 'wc_literalname',
		self::nameLink            => 'wc_namelink',
		self::suffix              => 'wc_suffix',
		self::droppingParticle    => 'wc_droppingparticle',
		self::nonDroppingParticle => 'wc_nondroppingparticle',
	);
	public static $substitutes = array();
	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$surname             = new self( self::surname );
		self::$given               = new self( self::given );
		self::$literal             = new self( self::literal );
		self::$nameLink            = new self( self::nameLink );
		self::$suffix              = new self( self::suffix );
		self::$droppingParticle    = new self( self::droppingParticle );
		self::$nonDroppingParticle = new self( self::nonDroppingParticle );
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
WCNamePartEnum::init();
