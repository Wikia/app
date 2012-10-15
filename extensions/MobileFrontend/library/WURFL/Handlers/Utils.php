<?php
/**
 * Copyright (c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL user agent hander utilities
 * @package    WURFL
 */
class WURFL_Handlers_Utils {
	
	/**
	 * The worst allowed match tolerance
	 * @var unknown_type
	 */
    const WORST_MATCH = 7;
	
	/**
	 * @var string Locale / Language matching RegEx
	 */
	const LANGUAGE_PATTERN = "/; [a-z]{2}(-[a-zA-Z]{0,2})?(?!=[;)])/";
	
	/**
	 * @var array Collection of mobile browser keywords
	 */
	private static $mobileBrowsers = array (
        "cldc",
        "symbian",
        "midp",
        "j2me",
        "mobile",
        "wireless",
        "palm",
        "phone",
        "pocket pc",
        "pocketpc",
        "netfront",
        "bolt",
        "iris",
        "brew",
        "openwave",
        "windows ce",
        "wap2",
        "android",
        "opera mini",
        "opera mobi",
        "maemo",
        "fennec",
        "blazer",
        "160x160",
        "webos",
        "sony",
        "nitro",
        "480x640",
        "aspen simulator",
        "up.browser",
        "up.link",
        "embider",
        "danger hiptop",
        "obigo",
        "foma");
	
	/** 
	 * Alias of WURFL_Handlers_Matcher_RISMatcher::match()
	 * @param array $collection
	 * @param string $needle
	 * @param int $tolerance
	 * @return string Matched user agent
	 * @see WURFL_Handlers_Matcher_RISMatcher::match()
	 */
	public static function risMatch($collection, $needle, $tolerance) {
		return WURFL_Handlers_Matcher_RISMatcher::INSTANCE ()->match ( $collection, $needle, $tolerance );
	}
	
	/**
	 * Alias of WURFL_Handlers_Matcher_LDMatcher::match()
	 * @param array $collection
	 * @param string $needle
	 * @param int $tolerance
	 * @return string Matched user agent
	 * @see WURFL_Handlers_Matcher_LDMatcher::match()
	 */
	public static function ldMatch($collection, $needle, $tolerance = 7) {
		return WURFL_Handlers_Matcher_LDMatcher::INSTANCE ()->match ( $collection, $needle, $tolerance );
	}
	
	/**
	 * Char index of the first instance of $string found in $target, starting at $startingIndex;
	 * if no match is found, the length of the string is returned
	 * @param string $string haystack
	 * @param string $target needle
	 * @param int $startingIndex Char index for start of search
	 * @return int Char index of match or length of string
	 */
	public static function indexOfOrLength($string, $target, $startingIndex = 0) {
		$length = strlen ( $string );
		$pos = strpos ( $string, $target, $startingIndex );
		return $pos === false ? $length : $pos;
	}
	
	/**
	 * Lowest char index of the first instance of any of the $needles found in $userAgent, starting at $startIndex;
	 * if no match is found, the length of the string is returned
	 * @param string $userAgent haystack
	 * @param array $needles Array of (string)needles to search for in $userAgent
	 * @param int $startIndex Char index for start of search
	 * @return int Char index of left-most match or length of string
	 */
	public static function indexOfAnyOrLength($userAgent, $needles = array(), $startIndex) {
		$positions = array ();
		foreach ( $needles as $needle ) {
			$pos = strpos ( $userAgent, $needle, $startIndex );
			if ($pos !== false) {
				$positions [] = $pos;
			}
		}
		sort ( $positions );		
		return count ( $positions ) > 0 ? $positions [0] : strlen ( $userAgent );
	}
	
	/**
	 * Returns true if the give $userAgent is from a mobile device
	 * @param string $userAgent
	 * @return bool
	 */
	public static function isMobileBrowser($userAgent) {
		$mobileBrowser = false;
		foreach ( self::$mobileBrowsers as $key ) {
			if (stripos ( $userAgent, $key ) !== FALSE) {
				$mobileBrowser = true;
				break;
			}
		}
		return $mobileBrowser;
	
	}
	
	/**
	 * Returns true if the give $userAgent is from a spam bot or crawler
	 * @param string $userAgent
	 * @return bool
	 */
	public static function isSpamOrCrawler($userAgent) {
		//$spamOrCrawlers = array("FunWebProducts", "Spam");		
		return self::checkIfContains($userAgent, "Spam") || self::checkIfContains($userAgent, "FunWebProducts");
	}
	
	/**
	 * 
	 * Returns the position of third occurrence of a ;(semi-column) if it exists 
	 * or the string length if no match is found 
	 * @param string $haystack
	 * @return int Char index of third semicolon or length
	 */
	public static function thirdSemiColumn($haystack) {
		$thirdSemiColumnIndex = self::ordinalIndexOf ( $haystack, ";", 3 );
		if ($thirdSemiColumnIndex < 0) {
			return strlen ( $haystack );
		}
		return $thirdSemiColumnIndex;
	}
	
	/**
	 * The nth($ordinal) occurance of $needle in $haystack or -1 if no match is found
	 * @param string $haystack
	 * @param string $needle
	 * @param int $ordinal
	 * @throws InvalidArgumentException
	 * @return int Char index of occurance
	 */
	public static function ordinalIndexOf($haystack, $needle, $ordinal) {
		if (is_null ( $haystack ) || empty ( $haystack )) {
			throw new InvalidArgumentException ( "haystack must not be null or empty" );
		}
		
		if (! is_integer ( $ordinal )) {
			throw new InvalidArgumentException ( "ordinal must be a positive ineger" );
		}
		
		$found = 0;
		$index = - 1;
		do {
			$index = strpos ( $haystack, $needle, $index + 1 );
			$index = is_int ( $index ) ? $index : - 1;
			if ($index < 0) {
				return $index;
			}
			$found ++;
		} while ( $found < $ordinal );
		
		return $index;
	
	}
	
	/**
	 * First occurance of a / character
	 * @param string $string Haystack
	 * @return int Char index
	 */
	public static function firstSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		return $firstSlash != 0 ? $firstSlash : strlen ( $string );
	}
	
	/**
	 * Second occurance of a / character
	 * @param string $string Haystack
	 * @return int Char index
	 */
	public static function secondSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		if ($firstSlash === false)
			return strlen ( $string );
		return strpos ( substr ( $string, $firstSlash + 1 ), "/" ) + $firstSlash;
	}
	
	/**
	 * First occurance of a space character
	 * @param string $string Haystack
	 * @return int Char index
	 */
	public static function firstSpace($string) {
		$firstSpace = strpos ( $string, " " );
		return ($firstSpace == 0) ? strlen ( $string ) : $firstSpace;
	}
	
	/**
	 * First occurance of a ; character or length
	 * @param string $string Haystack
	 * @return int Char index
	 */
	public static function firstSemiColonOrLength($string) {
		return self::firstMatchOrLength ( $string, ";" );
	}
	
	/**
	 * First occurance of $toMatch string or length
	 * @param string $string Haystack
	 * @param string $toMatch Needle
	 * @return int Char index
	 */
	public static function firstMatchOrLength($string, $toMatch) {
		$firstMatch = strpos ( $string, $toMatch );
		return ($firstMatch == 0) ? strlen ( $string ) : $firstMatch;
	}
	
	/**
	 * Returns true if $haystack contains $needle
	 * @param string $haystack Haystack
	 * @param string $needle Needle
	 * @return bool
	 */
	public static function checkIfContains($haystack, $needle) {
		return strpos ( $haystack, $needle ) !== false;
	}
	
	/**
	 * Returns true if $haystack contains any of the (string)needles in $needles
	 * @param string $haystack Haystack
	 * @param array $needles Array of (string)needles
	 * @return bool
	 */
    public static function checkIfContainsAnyOf($haystack, $needles) {
        foreach($needles as $needle) {
            if(self::checkIfContains($haystack, $needle)) return true;
        }
		return false;
	}
	
	/**
	 * Returns true if $haystack contains all of the (string)needles in $needles
	 * @param string $haystack Haystack
	 * @param array $needles Array of (string)needles
	 * @return bool
	 */
    public static function checkIfContainsAll($haystack, $needles=array()) {
        foreach($needles as $needle) {
            if(!self::checkIfContains($haystack, $needle)) return false;
        }
		return true;

    }
    
	/**
	 * Returns true if $haystack contains $needle without regard for case
	 * @param string $haystack Haystack
	 * @param string $needle Needle
	 * @return bool
	 */
	public static function checkIfContainsCaseInsensitive($haystack, $needle) {
		return stripos ( $haystack, $needle ) !== FALSE;
	}
	
	/**
	 * Returns true if $haystack starts with $needle
	 * @param string $haystack Haystack
	 * @param string $needle Needle
	 * @return bool
	 */
	public static function checkIfStartsWith($haystack, $needle) {
		return strpos ( $haystack, $needle ) === 0;
	}
	
	/**
	 * Returns true if $haystack starts with any of the $needles
	 * @param string $haystack Haystack
	 * @param array $needles Array of (string)needles
	 * @return bool
	 */
	public static function checkIfStartsWithAnyOf($haystack, $needles) {
		if (is_array ( $needles )) {
			foreach ( $needles as $needle ) {
				if (strpos ( $haystack, $needle ) === 0) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Removes the locale portion from the userAgent
	 * @param string $userAgent
	 */
	public static function removeLocale($userAgent) {
		return preg_replace ( self::LANGUAGE_PATTERN, "", $userAgent, 1 );
	}
}