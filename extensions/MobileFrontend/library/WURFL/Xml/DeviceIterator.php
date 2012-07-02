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
 * @package    WURFL_Xml
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 *
 */
/**
 * Extracts device capabilities from XML file
 * @package    WURFL_Xml
 */
class WURFL_Xml_DeviceIterator extends WURFL_Xml_AbstractIterator {
	
	private $capabilitiesToSelect = array ();
	private $filterCapabilities;
	
	/**
	 * @param string $inputFile XML file to be processed
	 * @param array $capabilities Capabiities to process
	 */
	function __construct($inputFile, $capabilities = array()) {
		parent::__construct ( $inputFile );
		foreach ( $capabilities as $groupId => $capabilityNames ) {
			$trimmedCapNames = $this->removeSpaces ( $capabilityNames );
			$capabilitiesAsArray = array ();
			if (strlen ( $trimmedCapNames ) != 0) {
				$capabilitiesAsArray = explode ( ',', $trimmedCapNames );
			}
			$this->capabilitiesToSelect [$groupId] = $capabilitiesAsArray;
		}
		$this->filterCapabilities = empty ( $this->capabilitiesToSelect ) ? false : true;
	}
	
	/**
	 * Removes spaces from the given $subject
	 * @param string $subject
	 */
	private function removeSpaces($subject) {
		return str_replace ( " ", "", $subject );
	}
	
	public function readNextElement() {
		
		$deviceId = null;
		$groupId = null;
		
		while ( $this->xmlReader->read () ) {
			
			$nodeName = $this->xmlReader->name;
			switch ($this->xmlReader->nodeType) {
				case XMLReader::ELEMENT :
					switch ($nodeName) {
						case WURFL_Xml_Interface::DEVICE :
							$groupIDCapabilitiesMap = array ();
							
							$deviceId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ID );
							$userAgent = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::USER_AGENT );
							$fallBack = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::FALL_BACK );
							$actualDeviceRoot = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ACTUAL_DEVICE_ROOT );
							$specific = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::SPECIFIC );
							$currentCapabilityNameValue = array ();
							if ($this->xmlReader->isEmptyElement) {
								$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot, $specific );
								break 3;
							}
							break;
						
						case WURFL_Xml_Interface::GROUP :
							$groupId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::GROUP_ID );
							if ($this->needToReadGroup ( $groupId )) {
								$groupIDCapabilitiesMap [$groupId] = array ();
							} else {
								$this->moveToGroupEndElement ();
								break 2;
							}
							break;
						
						case WURFL_Xml_Interface::CAPABILITY :
							
							$capabilityName = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_NAME );
							if ($this->neededToReadCapability ( $groupId, $capabilityName )) {
								$capabilityValue = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_VALUE );
								$currentCapabilityNameValue [$capabilityName] = $capabilityValue;
								$groupIDCapabilitiesMap [$groupId] [$capabilityName] = $capabilityValue;
							}
							
							break;
					}
					
					break;
				case XMLReader::END_ELEMENT :
					if ($nodeName == WURFL_Xml_Interface::DEVICE) {
						$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot, $specific, $groupIDCapabilitiesMap );
						break 2;
					}
			}
		} // end of while
	

	}
	
	/**
	 * Returns true if the group element needs to be processed
	 * @param string $groupId
	 * @return bool
	 */
	private function needToReadGroup($groupId) {
		if ($this->filterCapabilities) {
			return array_key_exists($groupId, $this->capabilitiesToSelect);
		}
		return true;
	}
	
	/**
	 * Returns true if the given $groupId's $capabilityName needs to be read
	 * @param string $groupId
	 * @param string $capabilityName
	 * @return bool
	 */
	private function neededToReadCapability($groupId, $capabilityName) {
		if (array_key_exists($groupId, $this->capabilitiesToSelect)) {
			$capabilities = $this->capabilitiesToSelect[$groupId];
			if (empty($capabilities)) {
				return true;
			}
			foreach ($capabilities as $capability) {
				if (strcmp($capabilityName, $capability) === 0) {
					return true;
				}
			}
			return false;
		}
		return true;
	
	}
	
	private function moveToGroupEndElement() {
		while (!$this->groupEndElement()) {
			$this->xmlReader->read();
		}
	}
	
	/**
	 * Returns true if the current element is the ending tag of a group
	 * @return bool
	 */
	private function groupEndElement() {
		return ($this->xmlReader->name === "group") && ($this->xmlReader->nodeType === XMLReader::END_ELEMENT);
	}
}