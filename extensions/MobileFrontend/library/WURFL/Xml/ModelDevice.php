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
 * @package    WURFL_Xml
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Represents a device in the wurfl xml file
 * @package    WURFL_Xml
 */
class WURFL_Xml_ModelDevice {

	/**
	 * @var string WURFL device ID
	 */
	private $id;
	/**
	 * @var string Fallback WURFL device ID
	 */
	private $fallBack;
	/**
	 * @var string User agent
	 */
	private $userAgent;
	/**
	 * @var bool This device is an actual root device
	 */
	private $actualDeviceRoot;
	/**
	 * @var bool This device is a specific device
	 */
	private $specific;
	/**
	 * @var array Array of capabilities
	 */
	private $capabilities = array();
	/**
	 * @var array Mapping of group IDs to capability names
	 */
	private $groupIdCapabilitiesNameMap = array();
	
	/**
	 * Creates a WURFL Device based on the provided parameters
	 * @param string $id WURFL device ID
	 * @param string $userAgent
	 * @param string $fallBack
	 * @param bool $actualDeviceRoot
	 * @param bool $specific
	 * @param array $groupIdCapabilitiesMap
	 */
	function __construct($id, $userAgent, $fallBack, $actualDeviceRoot=false, $specific=false, $groupIdCapabilitiesMap = null) {
		
		$this->id = $id;
		$this->userAgent = $userAgent;
		$this->fallBack = $fallBack; 
		$this->actualDeviceRoot = $actualDeviceRoot == true ? true : false;
		$this->specific = $specific == true ? true : false;
		if (is_array($groupIdCapabilitiesMap)) {
			foreach ($groupIdCapabilitiesMap as $groupId => $capabilitiesNameValue) {
				$this->groupIdCapabilitiesNameMap[$groupId] = array_keys($capabilitiesNameValue); 
				$this->capabilities = array_merge($this->capabilities, $capabilitiesNameValue);
			}
			
		}
	}
 
	/**
	 * Magic getter method
	 * @param string $name Name of property to get
	 */
	function __get($name) {
		return $this->$name;
	}
	
	/**
	 * Returns an array of the device capabilities
	 * @return array Capabilities
	 */
    function getCapabilities() {
        return $this->capabilities;
    }
	
    /**
     * Returns the group ID to capability name map
     * @return array Group ID to capability name map
     */
    function getGroupIdCapabilitiesNameMap() {
        return $this->groupIdCapabilitiesNameMap;
    }
    
	/**
	 * Returns the value of the given $capabilityName
	 * @param string $capabilityName
	 * @return mixed Value
	 */
	function getCapability($capabilityName) {
		if($this->isCapabilityDefined($capabilityName)) {
			return $this->capabilities[$capabilityName];
		}
		return null;
	}
	
	/**
	 * Returns true if the capability exists
	 * @param string $capabilityName
	 * @return bool Defined
	 */
	function isCapabilityDefined($capabilityName) {
		return array_key_exists($capabilityName, $this->capabilities);
	}
	
	/**
	 * Returns the capabilities by group name
	 * @return array capabilities
	 */
	function getGroupIdCapabilitiesMap() {
		$groupIdCapabilitiesMap = array();
		foreach ($this->groupIdCapabilitiesNameMap as $groupId => $capabilitiesName) {
			foreach ($capabilitiesName as $capabilityName) {
				$groupIdCapabilitiesMap[$groupId][$capabilityName] = $this->capabilities[$capabilityName];
			}
		}		
		return $groupIdCapabilitiesMap;		
	}
	
	/**
	 * Returns true if $groupId is defined 
	 * @param string $groupId
	 * @returns bool
	 */
	function isGroupDefined($groupId) {
		return array_key_exists($groupId, $this->groupIdCapabilitiesNameMap);
	}	
}