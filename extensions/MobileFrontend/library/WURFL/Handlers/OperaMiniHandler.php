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
 * OperaHandlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_OperaMiniHandler extends WURFL_Handlers_Handler {

    protected $prefix = "OPERA_MINI";

    function __construct($wurflContext, $userAgentNormalizer = null) {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }

    /**
     * Intercept all UAs Containing Opera Mini
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent) {
        return WURFL_Handlers_Utils::checkIfContains($userAgent, "Opera Mini");
    }

    private $operaMinis = array(
        "Opera Mini/1" => "browser_opera_mini_release1",
        "Opera Mini/2" => "browser_opera_mini_release2",
        "Opera Mini/3" => "browser_opera_mini_release3",
        "Opera Mini/4" => "browser_opera_mini_release4",
        "Opera Mini/5" => "browser_opera_mini_release5"
    );

    function applyRecoveryMatch($userAgent) {
        foreach ($this->operaMinis as $key => $deviceId) {
            if (WURFL_Handlers_Utils::checkIfContains($userAgent, $key)) {
                return $deviceId;
            }
        }

        return WURFL_Constants::GENERIC;

    }

}