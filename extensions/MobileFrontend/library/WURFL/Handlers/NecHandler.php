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
 * NecUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_NecHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs starting with "NEC-" and "KGT"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "NEC-" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "KGT" );
	}
	
	/**
	 * If UA starts with "NEC", apply RIS of FS
	 * If UA starts with KGT, apply LD with threshold 2
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	function lookForMatchingUserAgent($userAgent) {
		if (WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "NEC-" )) {
			$tollerance = WURFL_Handlers_Utils::firstSlash ( $userAgent );
			return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tollerance );
		}
		return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::NEC_KGT_TOLLERANCE );
	}
	
	const NEC_KGT_TOLLERANCE = 2;
	protected $prefix = "NEC";
}
