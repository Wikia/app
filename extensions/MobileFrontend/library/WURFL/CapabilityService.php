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
 * WURFL Capability Service
 * @package    WURFL
 */
class WURFL_CapabilityService {

	/**
	 * @var WURFL_DeviceRepository
	 */
	private $_deviceRepository;
	/**
	 * @var WURFL_Cache_CacheProvider
	 */
	private $_cacheProvider;
	
	/**
	 * Initialize the CapabilityService
	 *
	 * @param WURFL_DeviceRepository $deviceRepository
	 * @param WURFL_Cache_CacheProvider $cacheProvider
	 */
	function __construct($deviceRepository, $cacheProvider) {
		$this->_deviceRepository = $deviceRepository;
		$this->_cacheProvider = $cacheProvider;
	}

	/**
	 * Return a Cabability Value
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	function getCapabilityForDevice($deviceID, $capabilityName) {
		$key = $deviceID . $capabilityName;
		$capabilityValue = $this->_cacheProvider->get($key);
		if (empty($capabilityValue)) {
			$capabilityValue = $this->_deviceRepository->getCapabilityForDevice($deviceID, $capabilityName);
			// save it in cache
			$this->_cacheProvider->put($key, $capabilityValue);
		}
		return $capabilityValue;
	}

	/**
	 * Returns all the capabilities of the device
	 *
	 * @param string $deviceID
	 * @return array
	 */
	function getAllCapabilitiesForDevice($deviceID) {
		return $this->_deviceRepository->getAllCapabilitiesForDevice($deviceID);
	}

	/**
	 * Returns an array of all group ids
	 *
	 * @return array
	 */
	public function getListOfGroups() {
		return $this->_deviceRepository->getListOfGroups();
	}


	/**
	 * Returns an array of capabilities name for the given gorup id
	 *
	 * @param string $groupID
	 * @return array
	 */
	public function getCapabilitiesNameForGroup($groupID) {
		return $this->_deviceRepository->getCapabilitiesNameForGroup($groupID);
	}
	
	/**
	 * Return a list of fallback devices starting from 
	 * the given 
	 *
	 * @param string $deviceID
	 * @return array of devices
	 */
	public function getDeviceHierarchy($deviceID) {
		return $this->_deviceRepository->getDeviceHierarchy($deviceID);
	}

	/**
	 * 
	 *
	 * @param string $deviceID
	 * @return array
	 */
	public function getFallBackListForDevice($deviceID) {
		$devices = $this->_deviceRepository->getDeviceHierarchy($deviceID);
		$fallBacks = array();
		foreach ($devices as $device) {
			$fallBacks[] = $device->id;
		}
		return $fallBacks;
	}
}
