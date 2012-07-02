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
 * SamsungUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_SamsungHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Samsung/SGH" )
                || WURFL_Handlers_Utils::checkIfStartsWithAnyOf ( $userAgent, array("SEC-","Samsung","SAMSUNG", "SPH", "SGH", "SCH"));
	}


 	/**
	 * If UA starts with one of the following ("SEC-", "SAMSUNG-", "SCH"), apply RIS with FS.
	 * If UA starts with one of the following ("Samsung-","SPH", "SGH" ), apply RIS with First Space (not FS).
	 * If UA starts with "SAMSUNG/", apply RIS with threshold SS (Second Slash)
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
        $tolerance = $this->tolerance($userAgent);
		$this->logger->log ( "$this->prefix :Applying Conclusive Match for ua: $userAgent with tolerance $tolerance" );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}

 
    private function tolerance($userAgent) {
        if(WURFL_Handlers_Utils::checkIfStartsWithAnyOf($userAgent, array("SEC-", "SAMSUNG-", "SCH"))) {
            return WURFL_Handlers_Utils::firstSlash($userAgent);
        }
        if(WURFL_Handlers_Utils::checkIfStartsWithAnyOf($userAgent, array("Samsung-","SPH", "SGH"))) {
            return WURFL_Handlers_Utils::firstSpace($userAgent);
        }
        if(WURFL_Handlers_Utils::checkIfStartsWith($userAgent, "SAMSUNG/")) {
            return WURFL_Handlers_Utils::secondSlash($userAgent);
        }
        return WURFL_Handlers_Utils::firstSlash($userAgent);
    }

    protected $prefix = "SAMSUNG";
}

