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
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Provides methods for accessing a repository of WURFL Devices
 * @package    WURFL
 */
interface WURFL_DeviceRepository {
	
	/**
	 * Return a WURFL_Xml_Info object containing: 
	 *  - version
	 *  - lastUpdated
	 *  - officialURL
	 *  @return WURFL_Xml_Info WURFL Version info
	 */
	public function getWURFLInfo();
	
	/**
	 * Returns loaded WURFL version
	 * @return string Loaded WURFL version
	 */
	public function getVersion();
	
	/**
	 * Returns loaded WURFL last updated date
	 * @return string Loaded WURFL last updated date
	 */
	public function getLastUpdated();
	
	/**
	 * Returns a device for the given $deviceId
	 *
	 * @param string $deviceId
	 * @return WURFL_Device
	 * @throws WURFL_Exception if $deviceID is not defined in device repository
	 */
	public function getDevice($deviceId);
	
	/**
	 * Return an array of all devices defined in the wurfl + patch files
	 * @return array
	 */
	public function getAllDevices();
	
	/**
	 * Returns an array of all the device ids
	 *
	 * @return array
	 */
	public function getAllDevicesID();
	
	
	/**
	 * Returns the Capability value for the given device id
	 * and capablility name
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	public function getCapabilityForDevice($deviceId, $capabilityName);
	
	
	/**
	 * Returns an associative array of capabilityName => capabilityValue 
	 * for the given device 
	 * 
	 *
	 * @param string $deviceId
	 * @return array associative array of capabilityName, capabilityValue
	 */
	function getAllCapabilitiesForDevice($deviceId);
	
	/**
	 * Returns an array containing all devices from the root
	 * device to the device of the given id
	 *
	 * @param string $deviceId
	 * @return array
	 */
	public function getDeviceHierarchy($deviceId);
	
	
	/**
	 * Returns an array of the group IDs defined in wurfl
	 *
	 * @return array
	 */
	public function getListOfGroups();
	
	/**
	 * Returns an array of all capability names defined in the given group ID
	 *
	 * @param string $groupID
	 * @return array of capability names
	 */
	public function getCapabilitiesNameForGroup($groupID);
	
	/**
	 * Returns the group id in which the given capabiliy name belongs to
	 *
	 * @param string $capabilitity
	 * @return string Group ID
	 */
	public function getGroupIDForCapability($capability);

}

