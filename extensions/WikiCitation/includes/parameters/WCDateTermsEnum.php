<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Magic word enumerations
 */
class WCDateTermsEnum extends WCParameterEnum {
	const nothing    = 0;
	const spring     = 1;
	const summer     = 2;
	const autumn     = 3;
	const winter     = 4;
	const AD         = 5;
	const BC         = 6;
	const yearTerm   = 7;
	const monthTerm  = 8;
	const dayTerm    = 9;
	const circa      = 10;
	const number     = 11;
	const namedMonth = 12;

	public static $nothing;
	public static $spring;
	public static $summer;
	public static $autumn;
	public static $winter;
	public static $AD;
	public static $BC;
	public static $yearTerm;
	public static $monthTerm;
	public static $dayTerm;
	public static $circa;
	public static $number;
	public static $namedMonth;

	public static $magicWordKeys = array(
		self::spring         => 'wc_spring',
		self::summer         => 'wc_summer',
		self::autumn         => 'wc_autumn',
		self::winter         => 'wc_winter',
		self::AD             => 'wc_ad_magic_word',
		self::BC             => 'wc_bc_magic_word',
		self::yearTerm       => 'wc_year',
		self::monthTerm      => 'wc_month',
		self::dayTerm        => 'wc_day',
		self::circa          => 'wc_circa',
#		self::rangeDelimeter => 'wc_range',
	);
	public static $substitutes = array();
	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$nothing    = new self( self::nothing );
		self::$spring     = new self( self::spring );
		self::$summer     = new self( self::summer );
		self::$autumn     = new self( self::autumn );
		self::$winter     = new self( self::winter );
		self::$AD         = new self( self::AD );
		self::$BC         = new self( self::BC );
		self::$yearTerm   = new self( self::yearTerm );
		self::$monthTerm  = new self( self::monthTerm );
		self::$dayTerm    = new self( self::dayTerm );
		self::$circa      = new self( self::circa );
		self::$number     = new self( self::number );
		self::$namedMonth = new self( self::namedMonth );
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
WCDateTermsEnum::init();
