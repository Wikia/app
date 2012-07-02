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
 * @package WURFL_Xml
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 *
 */
/**
 * Stores version and other info about the loaded WURFL
 * @package WURFL_Xml
 * @property-read string $version Loaded WURFL Version
 * @property-read string $lastUpdated Loaded WURFL Last Updated Date
 * @property-read string $officialURL Loaded WURFL Official URL 
 */
class WURFL_Xml_Info {

	/**
	 * Key used in persistence provider to store version-related information
	 * @var string
	 */
	const PERSISTENCE_KEY = "WURFL_XML_INFO";	
	private $version;
	private $lastUpdated;
	private $officialURL;
	
	/**
	 * @param string $version WURFL Version
	 * @param string $lastUpdated WURFL Last Updated data
	 * @param string $officialURL WURFL URL
	 */
	public function __construct($version, $lastUpdated, $officialURL) {
		$this->version = $version;
		$this->lastUpdated = $lastUpdated;
		$this->officialURL = $officialURL;		
	}
	
	/**
	 * Returns the value for the given key (version, lastUpdated, officialURL)
	 * @param string $name
	 * @return string value
	 */
	public function __get($name) {
		return $this->$name;
	} 
	
	/**
	 * @return WURFL_Xml_Info Empty WURFL_Xml_Info object
	 */
	public static function noInfo() {
		return new WURFL_Xml_Info("", "", "");
	}
	
}