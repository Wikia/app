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
 * @package    WURFL_Cache
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Holds WURFL Device capabilities
 * @package    WURFL
 */
class WURFL_CapabilitiesHolder {
	
	/**
	 * @var WURFL_Device
	 */
	private $_device;
	/**
	 * @var WURFL_DeviceRepository
	 */
	private $_deviceRepository;
	/**
	 * @var WURFL_Cache_CacheProvider
	 */
	private $_cacheProvider;
	
	/**
	 * @param WURFL_Device $device
	 * @param WURFL_DeviceRepository $deviceRepository
	 * @param WURFL_Cache_CacheProvider $cacheProvider
	 */
	public function __construct($device, $deviceRepository, $cacheProvider) {
		$this->_device = $device;
		$this->_deviceRepository = $deviceRepository;
		$this->_cacheProvider = $cacheProvider;
	}
	
	/**
	 * Returns the value of a given capability name
	 * 
	 * @param string $capabilityName
	 * @return string Capability value
	 * @throws WURFLException if the value of the $capability name is illegal
	 */
	public function getCapability($capabilityName) {
		
		if(isset($this->_device->capabilities[$capabilityName])) {
 			return $this->_device->capabilities[$capabilityName];
 		}
 				
 		$key = $this->_device->id . "_" . $capabilityName;
 		$capabilityValue = $this->_cacheProvider->get($key);
 		if (empty($capabilityValue)) {

			$capabilityValue = $this->_deviceRepository->getCapabilityForDevice($this->_device->fallBack, $capabilityName);
 			// save it in cache
 			$this->_cacheProvider->put($key, $capabilityValue);
 		}

		// prevent useless gets when retrieving the same capability from this device again
		//$this->_device->capabilities[$capabilityName] = $capabilityValue;

 		return $capabilityValue;
 	}
	
	/**
	 * Returns all the capabilities value of the current device as <capabilityName, capabilityValue>
	 * @return array All capabilities
	 */
	public function getAllCapabilities() {
		return  $this->_deviceRepository->getAllCapabilitiesForDevice($this->_device->id);		
	}
	
}
