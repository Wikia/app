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
 * AndroidUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WURFL_Handlers_AndroidHandler extends WURFL_Handlers_Handler {

	protected $prefix = "ANDROID";

	public function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}

	/**
	 * Intercept all UAs containing "Android"
	 *
	 * @param string $userAgent
	 * @return bool
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Android" );
	}

	/**
	 * Use RIS with first semicolon after the Android String as tollerance
	 *
	 * @param string $userAgent
	 */
	function lookForMatchingUserAgent($userAgent) {
		$tollerance = WURFL_Handlers_Utils::indexOfOrLength ( $userAgent, " ", strpos ( $userAgent, "Android" ) );
		$userAgents = array_keys ( $this->userAgentsWithDeviceID );
		return parent::applyRisWithTollerance ( $userAgents, $userAgent, $tollerance );
	}


	private $androidDeviceIdByVersion = array(
		"" => "generic_android",
		"1_5" => "generic_android_ver1_5",
		"1_6" => "generic_android_ver1_6",
		"2_0" => "generic_android_ver2",
		"2_1" => "generic_android_ver2_1",
		"2_2" => "generic_android_ver2_2",
		"2_3" => "generic_android_ver2_3",
		"3_0" => "generic_android_ver3_0",
	);

	/**
	 * If the User Agent contains "Android"
	 * Return "generic_andorid"
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		$deviceId = "generic_android";
		$platformVersion = $this->platformVersion($userAgent);
		if(isset($this->androidDeviceIdByVersion[$platformVersion])) {
			$deviceId = $this->androidDeviceIdByVersion[$platformVersion];
		} elseif($this->isFroyo($userAgent)) {
			return "generic_android_ver2_2";
		}
		return $deviceId;

	}

	private function isFroyo($userAgent) {
		return strpos($userAgent, "Froyo") !== 0;
	}

	const ANDROID_PLATFORM_VERSION = "/Android[\s\/](\d)\.(\d+)/";

	private function platformVersion($userAgent) {
		$matches = array();
		if(preg_match(self::ANDROID_PLATFORM_VERSION, $userAgent, $matches) != 0) {
			return $matches[1] . "_" . $matches[2];
		}
		return "";
	}

}
