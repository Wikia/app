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
 * @package    WURFL_Configuration
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL Configuration holder
 * @package    WURFL_Configuration
 */
class WURFL_Configuration_ConfigHolder {
	
	/**
	 * @var WURFL_Configuration_Config
	 */
	private static $_wurflConfig = null;
	
	private function __construct() {
	}
	
	private function __clone() {
	}
	
	/**
	 * Returns a Configuration object
	 * @return WURFL_Configuration_Config
	 */
	public static function getWURFLConfig() {
		if (null === self::$_wurflConfig) {
			throw new WURFL_WURFLException ( "The Configuration Holder is not initialized with a valid WURFLConfig object" );
		}
		
		return self::$_wurflConfig;
	}
	
	/**
	 * Sets the Configuration object
	 * @param WURFL_Configuration_Config $wurflConfig
	 */
	public static function setWURFLConfig(WURFL_Configuration_Config $wurflConfig) {
		self::$_wurflConfig = $wurflConfig;
	}
	

}

