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
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

/**
 * VodafoneUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_VodafoneHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "VODAFONE";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercepting All User Agents Starting with "Vodafone"
	 *
	 * @param $string $userAgent
	 * @return boolean
	 */
	function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "Vodafone" );
	}
	
	/** 
	 * 
	 * @param string $userAgent
	 */
	function lookForMatchingUserAgent($userAgent) {	
		$tolerance = WURFL_Handlers_Utils::ordinalIndexOf($userAgent, "/", 3);		
		return WURFL_Handlers_Utils::risMatch(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
	}

}

