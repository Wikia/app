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
 * Factory class for WURFL Configuration objects
 * @package    WURFL_Configuration
 */
class WURFL_Configuration_ConfigFactory {
	
	/**
	 * @param string $configFilePath
	 * @throws InvalidArgumentException
	 * @return WURFL_Configuration_Config
	 */
	public static function create($configFilePath) {
		if (!isset ( $configFilePath )) {
			throw new InvalidArgumentException ( " The configuration file path $configFilePath is not set" );
		}
		if (self::isXmlConfiguration ( $configFilePath )) {
			return new WURFL_Configuration_XmlConfig ( $configFilePath );
		}
		
		return new WURFL_Configuration_ArrayConfig ( $configFilePath );
	
	}
	
	/**
	 * Returns true if the given $fileName is an XML Configuration
	 * @param string $fileName
	 * @return bool
	 */
	private static function isXmlConfiguration($fileName) {
		return strcmp("xml", substr($fileName, - 3)) === 0 ? true : false;
	}
}
