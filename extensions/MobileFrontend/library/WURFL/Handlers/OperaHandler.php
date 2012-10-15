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
 * OperaHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_OperaHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "OPERA";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		if (WURFL_Handlers_Utils::isMobileBrowser ( $userAgent )) {
			return false;
		}
		
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera" );
	}
	
	private $operas = array (
        "" => "opera",
        "7" => "opera_7",
        "8" => "opera_8",
        "9" => "opera_9",
        "10" => "opera_10"
    );
	
	const OPERA_TOLERANCE = 3;
	function lookForMatchingUserAgent($userAgent) {
		return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::OPERA_TOLERANCE );
	}
	
	function applyRecoveryMatch($userAgent) {
		$operaVersion = $this->operaVersion ( $userAgent );
		$operaId = "opera";
		if (isset ( $this->operas [$operaVersion] )) {
			$operaId = $this->operas [$operaVersion];
		}
		
		if($this->isDeviceExist ( $operaId )) {
			return $operaId;
		}

		
		return "generic_web_browser";
		
	}
	

	
	const OPERA_VERSION_PATTERN = "/.*Opera[\s\/](\d+).*/";
	private function operaVersion($userAgent) {
		if (preg_match ( self::OPERA_VERSION_PATTERN, $userAgent, $match )) {
			return $match [1];
		}
		return NULL;
	}

}