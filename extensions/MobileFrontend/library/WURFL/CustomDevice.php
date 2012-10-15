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
 * WURFL Custom Device - this is the core class that is used by developers to access the
 * properties and capabilities of a mobile device
 * 
 * Examples:
 * <code>
 * // Create a WURFL Manager and detect device first
 * $wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
 * $wurflManager = $wurflManagerFactory->create();
 * $device = $wurflManager->getDeviceForHttpRequest($_SERVER);
 * 
 * // Example 1: Get display resolution from device
 * $width = $device->getCapability('resolution_width');
 * $height = $device->getCapability('resolution_height');
 * echo "Resolution: $width x $height <br/>";
 * 
 * // Example 2: Get the WURFL ID of the device
 * $wurflID = $device->id;
 * </code>
 * 
 * @property-read string $id WURFL Device ID
 * @property-read string $userAgent User Agent
 * @property-read string $fallBack Fallback Device ID
 * @property-read bool $actualDeviceRoot true if device is an actual root device
 * @package WURFL
 */
class WURFL_CustomDevice {
	
	/**
	 * @var array Array of WURFL_Xml_ModelDevice objects
	 */
	private $modelDevices;
	
	/**
	 * 
	 * @param array Array of WURFL_Xml_ModelDevice objects
	 * @throws InvalidArgumentException if the $modelDevice is not an array of at least one WURFL_Xml_ModelDevice
	 */
	public function __construct($modelDevices) {
		if (! is_array ( $modelDevices ) || count ( $modelDevices ) < 1) {
			throw new InvalidArgumentException ( "modelDevices must be an array of at least one ModelDevice." );
		}
		$this->modelDevices = $modelDevices;
	
	}
	
	/**
	 * Magic Method
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name) {
		if (isset($name)) {
			switch ($name) {
				case "id" :
				case "userAgent" :
				case "fallBack" :
				case "actualDeviceRoot" :
					return $this->modelDevices[0]->$name;
					break;
				default :
					throw new WURFL_WURFLException("the field " . $name . " is not defined");
					break;
			}
		}
		throw new WURFL_WURFLException("the field " . $name . " is not defined");
	}
	
	/**
	 * Device is a specific or actual WURFL device as defined by its capabilities
	 * @return bool
	 */
	public function isSpecific() {
		foreach ($this->modelDevices as $modelDevice) {
			if ($modelDevice->specific === true || $modelDevice->actualDeviceRoot === true) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Returns the value of a given capability name
	 * for the current device
	 * 
	 * @param string $capabilityName must be a valid capability name
	 * @return string Capability value
	 * @throws InvalidArgumentException The $capabilityName is is not defined in the loaded WURFL.
	 * @see WURFL_Xml_ModelDevice::getCapability()
	 */
	public function getCapability($capabilityName) {
		if (empty($capabilityName)) {
			throw new InvalidArgumentException("capability name must not be empty");
		}
		if(!$this->isCapabilityDefined($capabilityName)) {
			throw new InvalidArgumentException("no capability named [$capabilityName] is present in wurfl.");	
		}
		foreach ($this->modelDevices as $modelDevice) {
			$capabilityValue = $modelDevice->getCapability($capabilityName);
			if ($capabilityValue != null) {
				return $capabilityValue;
			}
		}
		return "";
	}
	
	/**
	 * @param string $capabilityName
	 * @return bool true if capability is defined
	 * @see WURFL_Xml_ModelDevice::isCapabilityDefined()
	 */
	private function isCapabilityDefined($capabilityName) {
		return $this->modelDevices[count($this->modelDevices)-1]->isCapabilityDefined($capabilityName);
	}
	
	/**
	 * Returns capabilities and their values for the current device 
	 * @return array Device capabilities array
	 * @see WURFL_Xml_ModelDevice::getCapabilities()
	 */
	public function getAllCapabilities() {
		$capabilities = array ();
		foreach (array_reverse($this->modelDevices) as $modelDevice) {
			$capabilities = array_merge($capabilities, $modelDevice->getCapabilities());
		}
		return $capabilities;
	}
}