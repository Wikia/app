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
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL related utilities
 * @package    WURFL
 */
class WURFL_WURFLUtils {

	/**
	 * returns the User Agent From $request or empty string if not found one
	 *
	 * @param array $request HTTP Request array (normally $_SERVER)
	 * @return string
	 */
	public static function getUserAgent($request) {			
		if (isset($request[WURFL_Constants::UA])) {
			return $request[WURFL_Constants::UA];
		}		

		if(isset($request['HTTP_X_DEVICE_USER_AGENT'])) {
			return $request['HTTP_X_DEVICE_USER_AGENT'];
		}		
		if(isset($request['HTTP_USER_AGENT'])) {
			return $request['HTTP_USER_AGENT'];
		}
		
		return '';
	}

	/**
	 * Returns the UA Profile from the $request
	 * @param array $request HTTP Request array (normally $_SERVER)
	 * @return string UAProf URL
	 */
	public static function getUserAgentProfile($request) {
		if (isset($request["HTTP_X_WAP_PROFILE"])) {
			return $request["HTTP_X_WAP_PROFILE"];
		}
		if (isset($request["HTTP_PROFILE"])) {
			return $request["HTTP_PROFILE"];
		}
		if (isset($request["Opt"])) {
			$opt = $request["Opt"];
			$regex = "/ns=\\d+/";
			$matches = array();
			if (preg_match($regex, $opt, $matches)) {
				$namespaceProfile = substr($matches[0], 2) . "-Profile";
			}
			if (isset($request[$namespaceProfile])) {
				return $request[$namespaceProfile];
			}
		}

		return null;
	}

	/**
	 * Checks if the requester device is xhtml enabled
	 *
	 * @param array $request HTTP Request array (normally $_SERVER)
	 * @return bool
	 */
	public static function isXhtmlRequester($request) {
		if (!isset($request["accept"])) {
			return false;
		}
		
		$accept = $request["accept"];
		if (isset($accept)) {
			if ((strpos($accept, WURFL_Constants::ACCEPT_HEADER_VND_WAP_XHTML_XML) !== 0)
			|| (strpos($accept, WURFL_Constants::ACCEPT_HEADER_XHTML_XML) !== 0)
			|| (strpos($accept, WURFL_Constants::ACCEPT_HEADER_TEXT_HTML) !== 0)) {
				return true;;
			}
		}

		return false;

	}

	/**
	 * Returns true if given $deviceID is the 'generic' WURFL device
	 * @param string $deviceID
	 * @return bool
	 */
	public static function isGeneric($deviceID) {
		if (strcmp($deviceID, WURFL_Constants::GENERIC) === 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Recursively merges $array1 with $array2, returning the result
	 * @param array $array1
	 * @param array $array2
	 * @return array
	 */
	public static function array_merge_recursive_unique($array1, $array2) {
		// LOOP THROUGH $array2
		foreach($array2 AS $k => $v) {

			// CHECK IF VALUE EXISTS IN $array1
			if(!empty($array1[$k])) {
				// IF VALUE EXISTS CHECK IF IT'S AN ARRAY OR A STRING
				if(!is_array($array2[$k])) {
					// OVERWRITE IF IT'S A STRING
					$array1[$k]=$array2[$k];
				} else {
					// RECURSE IF IT'S AN ARRAY
					$array1[$k] = self::array_merge_recursive_unique($array1[$k], $array2[$k]);
				}
			} else {
				// IF VALUE DOESN'T EXIST IN $array1 USE $array2 VALUE
				$array1[$k]=$v;
			}
		}
		unset($k, $v);

		return $array1;
	}

}

