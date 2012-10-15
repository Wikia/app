<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCScopeEnum extends WCParameterEnum {
	const work      = 0;
	const container = 1;
	const series    = 2;
	const original  = 3;
	const subject   = 4;
	const __default = self::work;

	public static $work;
	public static $container;
	public static $series;
	public static $original;
	public static $subject;

	public static $magicWordKeys = array(
		self::work      => 'wc_work',
		self::container => 'wc_container',
		self::series    => 'wc_series',
		self::original  => 'wc_original',
		self::subject   => 'wc_subject'
	);
	public static $substitutes = array (
		self::work      => array( self::work, self::original, self::subject ),
		self::container => array( self::container, self::series ),
		self::series    => array( self::series, self::container ),
		self::original  => array( self::original ),
		self::subject   => array( self::subject )
	);
	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$work      = new self( self::work );
		self::$container = new self( self::container );
		self::$series    = new self( self::series );
		self::$original  = new self( self::original );
		self::$subject   = new self( self::subject );
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
WCScopeEnum::init();
