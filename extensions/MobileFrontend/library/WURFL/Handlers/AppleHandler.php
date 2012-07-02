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
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

/**
 * AppleUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_AppleHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "APPLE";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing either "iPhone" or "iPod" or "iPad"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPhone" ) 
			|| WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPod" )
			|| WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPad" );
	}
	
	/** 
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
		$tolerance = 0;
		if(WURFL_Handlers_Utils::checkIfStartsWith($userAgent, "Apple")) {
			$tolerance = WURFL_Handlers_Utils::ordinalIndexOf($userAgent, " ", 3);
		} else {
			$tolerance = WURFL_Handlers_Utils::firstSemiColonOrLength($userAgent);
		}
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPad" )) {
			return "apple_ipad_ver1";
		}
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "iPod" )) {
			return "apple_ipod_touch_ver1";
		}
		
		return "apple_iphone_ver1";
	}

}
