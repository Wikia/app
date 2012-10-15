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
 * 
 */
/**
 * Builds a WURFL_DeviceRepository
 * @package    WURFL
 */
class WURFL_DeviceRepositoryBuilder {
	
	/**
	 * @var WURFL_Xml_PersistenceProvider
	 */
	private $persistenceProvider;
	/**
	 * @var WURFL_UserAgentHandlerChain
	 */
	private $userAgentHandlerChain;
	/**
	 * @var WURFL_Xml_DevicePatcher
	 */
	private $devicePatcher;

	/**
	 * Filename of lockfile to prevent concurrent DeviceRepository builds
	 * @var string
	 */
	private $lockFile;
	/**
	 * Determines the fopen() mode that is used on the lockfile 
	 * @var string
	 */
	private $lockStyle = 'r';
	
	/**
	 * @param WURFL_Xml_PersistenceProvider $persistenceProvider
	 * @param WURFL_UserAgentHandlerChain $userAgentHandlerChain
	 * @param WURFL_Xml_DevicePatcher $devicePatcher
	 */
	public function __construct($persistenceProvider, $userAgentHandlerChain, $devicePatcher) {
		$this->persistenceProvider = $persistenceProvider;
		$this->userAgentHandlerChain = $userAgentHandlerChain;
		$this->devicePatcher = $devicePatcher;
		if (strpos(PHP_OS, 'SunOS') === false) {
			$this->lockFile = dirname(__FILE__)."/DeviceRepositoryBuilder.php";
		} else {
			// Solaris can't handle exclusive file locks on files unless they are opened for RW
			$this->lockStyle = 'w+';
			if (function_exists('sys_get_temp_dir')) {
				$this->lockFile = realpath(sys_get_temp_dir());
			}
			$this->lockFile = $this->lockFile? $this->lockFile.'/wurfl.lock': '/tmp/wurfl.lock';
		}
	}
	
	/**
	 * Builds DeviceRepository in PersistenceProvider from $wurflFile and $wurflPatches using $capabilitiesToUse 
	 * @param string $wurflFile Filename of wurfl.xml or other complete WURFL file
	 * @param array $wurflPatches Array of WURFL patch files
	 * @param array $capabilitiesToUse Array of capabilities to be included in the DeviceRepository
	 * @return WURFL_CustomDeviceRepository
	 */
	public function build($wurflFile, $wurflPatches = array(), $capabilitiesToUse = array()) {
		if (!$this->isRepositoryBuilt()) {
			set_time_limit(300);
			$fp = fopen($this->lockFile, $this->lockStyle);
			if (flock($fp, LOCK_EX | LOCK_NB) && !$this->isRepositoryBuilt()) {
				$infoIterator = new WURFL_Xml_VersionIterator($wurflFile);
				$deviceIterator = new WURFL_Xml_DeviceIterator($wurflFile, $capabilitiesToUse);
				$patchIterators = $this->toPatchIterators($wurflPatches , $capabilitiesToUse);
			
				$this->buildRepository($infoIterator, $deviceIterator, $patchIterators);
				$this->setRepositoryBuilt();	
				flock($fp, LOCK_UN);
			}
		}
		$deviceClassificationNames = $this->deviceClassificationNames();
		return new WURFL_CustomDeviceRepository($this->persistenceProvider, $deviceClassificationNames);
	}
	
	/**
	 * Iterates over XML files and pulls relevent data
	 * @param WURFL_Xml_VersionIterator $wurflInfoIterator
	 * @param WURFL_Xml_DeviceIterator $deviceIterator
	 * @param array $patchDeviceIterators arrray of WURFL_Xml_DeviceIterator objects for patch files 
	 * @throws Exception
	 */
	private function buildRepository($wurflInfoIterator, $deviceIterator, $patchDeviceIterators = null) {
		$this->persistWurflInfo($wurflInfoIterator);
		$patchingDevices = array();
		$patchingDevices = $this->toListOfPatchingDevices($patchDeviceIterators);		
		try {
			$this->process($deviceIterator, $patchingDevices);
		} catch(Exception $exception) {
			$this->clean();
			throw new Exception("Problem Building WURFL Repository " . $exception);
		}
	}
	
	/**
	 * Returns an array of WURFL_Xml_DeviceIterator for the given $wurflPatches and $capabilitiesToUse
	 * @param array $wurflPatches Array of (string)filenames
	 * @param array $capabilitiesToUse Array of (string) WURFL capabilities
	 * @return array Array of WURFL_Xml_DeviceIterator objects
	 */
	private function toPatchIterators($wurflPatches, $capabilitiesToUse) {
		$patchIterators = array();
		if (is_array($wurflPatches)) {
			foreach ($wurflPatches as $wurflPatch) {
				$patchIterators [] = new WURFL_Xml_DeviceIterator($wurflPatch, $capabilitiesToUse);
			}
		}
		return $patchIterators;
	}
	
	/**
	 * @return bool true if device repository is already built (WURFL is loaded in persistence proivder)
	 */
	private function isRepositoryBuilt() {
		return $this->persistenceProvider->isWURFLLoaded();
	}
	
	/**
	 * Marks the WURFL as loaded in the persistence provider
	 * @see WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider::setWURFLLoaded()
	 */
	private function setRepositoryBuilt() {
		$this->persistenceProvider->setWURFLLoaded();
	}
	
	/**
	 * @return array Array of (string)User Agent Handler prefixes
	 * @see WURFL_Handlers_Handler::getPrefix()
	 */
	private function deviceClassificationNames() {
		$deviceClusterNames = array();
		foreach ($this->userAgentHandlerChain->getHandlers() as $userAgentHandler) {
			$deviceClusterNames[] = $userAgentHandler->getPrefix();
		}
		return $deviceClusterNames;
	}
	
	/**
	 * Clears the devices from the persistence provider
	 * @see WURFL_Xml_PersistenceProvider::clear()
	 */
	private function clean() {
		$this->persistenceProvider->clear();
	}
	
	/**
	 * Save Loaded WURFL info in the persistence provider 
	 * @param WURFL_Xml_VersionIterator $wurflInfoIterator
	 */
	private function persistWurflInfo($wurflInfoIterator) {
		foreach ($wurflInfoIterator as $info) {
			$this->persistenceProvider->save(WURFL_Xml_Info::PERSISTENCE_KEY, $info);
		}
	}
	
	/**
	 * Process device iterator
	 * @param WURFL_Xml_DeviceIterator $deviceIterator
	 * @param unknown_type $patchingDevices
	 */
	private function process($deviceIterator, $patchingDevices) {
		$usedPatchingDeviceIds = array();
		foreach ($deviceIterator as $device) {
			$toPatch = isset($patchingDevices [$device->id]);
			if ($toPatch) {
				$device = $this->patchDevice($device, $patchingDevices [$device->id]);
				$usedPatchingDeviceIds [$device->id] = $device->id;
			}
			$this->classifyAndPersistDevice($device);
		}
		$this->classifyAndPersistNewDevices(array_diff_key($patchingDevices, $usedPatchingDeviceIds));
		$this->persistClassifiedDevicesUserAgentMap();
	}
	
	/**
	 * Save all $newDevices in the persistence provider
	 * @param array $newDevices Array of WURFL_Device objects
	 */
	private function classifyAndPersistNewDevices($newDevices) {
		foreach ($newDevices as $newDevice) {
			$this->classifyAndPersistDevice($newDevice);
		}
	}

	/**
	 * Save given $device in the persistence provider
	 * @param WURFL_Device $device
	 * @see WURFL_UserAgentHandlerChain::filter(), WURFL_Xml_PersistenceProvider::save()
	 */
	private function classifyAndPersistDevice($device) {
		$this->userAgentHandlerChain->filter($device->userAgent, $device->id);
		$this->persistenceProvider->save($device->id, $device);
	}
	
	/**
	 * Save the User Agent Map in the UserAgentHandlerChain
	 * @see WURFL_UserAgentHandlerChain::persistData()
	 */
	private function persistClassifiedDevicesUserAgentMap() {
		$this->userAgentHandlerChain->persistData();
	}
	
	private function patchDevice($device, $patchingDevice) {
		return $this->devicePatcher->patch($device, $patchingDevice);
	}
	
	/**
	 * @param array $patchingDeviceIterators Array of WURFL_Xml_DeviceIterators
	 * @return array Merged array of current patch devices
	 */
	private function toListOfPatchingDevices($patchingDeviceIterators) {
		$currentPatchingDevices = array();
		if (is_null($patchingDeviceIterators)) {
			return $currentPatchingDevices;
		}
		foreach ($patchingDeviceIterators as $deviceIterator) {
			$newPatchingDevices = $this->toArray($deviceIterator);
			$this->patchDevices($currentPatchingDevices, $newPatchingDevices);
		}
		return $currentPatchingDevices;
	}
	
	/**
	 * Adds the given $newPatchingDevices to the $currentPatchingDevices array
	 * @param array $currentPatchingDevices REFERENCE to array of current devices to be patches
	 * @param array $newPatchingDevices Array of new devices to be patched in
	 */
	private function patchDevices(&$currentPatchingDevices, $newPatchingDevices) {
		foreach ($newPatchingDevices as $deviceId => $newPatchingDevice) {
			if (isset($currentPatchingDevices[$deviceId])) {
				$currentPatchingDevices[$deviceId] = $this->patchDevice($currentPatchingDevices[$deviceId], $newPatchingDevice);
			} else {
				$currentPatchingDevices[$deviceId] = $newPatchingDevice;
			}
		}
	}
	
	/**
	 * Returns an array of devices in the form "WURFL_Device::id => WURFL_Device"
	 * @param WURFL_Xml_DeviceIterator $deviceIterator
	 * @return array
	 */
	private function toArray($deviceIterator) {
		$patchingDevices = array();
		foreach ($deviceIterator as $device) {
			$patchingDevices[$device->id] = $device;
		}
		return $patchingDevices;
	}

}
