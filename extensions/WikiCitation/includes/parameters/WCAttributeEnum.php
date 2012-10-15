<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCAttributeEnum extends WCEnum {
	const text            = 0;
	const title           = 1;
	const date            = 2;
	const parameter       = 3;
	const name            = 4;
	const names           = 5;
	const locator         = 6;
	const __default       = self::text;

	public static $text;
	public static $title;
	public static $date;
	public static $parameter;
	public static $name;
	public static $names;
	public static $locator;

	public static $attribute = array(
		self::text      => 'WCText',
		self::title     => 'WCTitle',
		self::date      => 'WCDate',
		self::parameter => 'WCTypeData',
		self::name      => 'WCName',
		self::names     => 'WCNames',
		self::locator   => 'WCLocator',
	);

	public static function init() {
		self::$text      = new self( self::text );
		self::$title     = new self( self::title );
		self::$date      = new self( self::date );
		self::$parameter = new self( self::parameter );
		self::$name      = new self( self::name );
		self::$names     = new self( self::names );
		self::$locator   = new self( self::locator );
	}
}
WCAttributeEnum::init();
