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
 * KDDIUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_KDDIHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "KDDI";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing "KDDI"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "KDDI" );
	}
	
	/**
	 */
	function lookForMatchingUserAgent($userAgent) {
		$tolerance = $this->tolerance ( $userAgent );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		if (WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera" )) {
			return "opera";
		}
		return "opwv_v62_generic";
	}
	
	private function tolerance($userAgent) {
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "KDDI/" )) {
			return WURFL_Handlers_Utils::secondSlash ( $userAgent );
		}
		
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "KDDI" )) {
			return WURFL_Handlers_Utils::firstSlash ( $userAgent );
		}
		
		return WURFL_Handlers_Utils::indexOfOrLength ( $userAgent, ")" );
	
	}

}
