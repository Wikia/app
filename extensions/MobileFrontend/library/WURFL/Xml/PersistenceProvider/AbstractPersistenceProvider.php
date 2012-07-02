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
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

/**
 * Abstract PersistenceProvider
 *
 * A Skeleton implementation of the PersistenceProvider Interface
 *
 * @category   WURFL
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
abstract class WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider implements WURFL_Xml_PersistenceProvider {
	
	const APPLICATION_PREFIX = "WURFL_"; 
	const WURFL_LOADED = "WURFL_WURFL_LOADED";
	protected $persistenceIdentifier;
	
	/**
     * Saves the object.
     *
     * @param string $objectId
     * @param mixed $object
     * @return bool $success
     */
    public function save($objectId, $object) {}
	
    /**
     * Returns the object identified by $objectId
     *
     * @param string $objectId
     * @return mixed Value
     */
    public function load($objectId){}

    
    /**
     * Removes from the persistence provider the
     * object identified by $objectId
     *
     * @param string $objectId
     */
    public function remove($objectId){}


    /**
     * Removes all entry from the Persistence Provider
     */
    public function clear(){}
    
    
    /**
     * Checks if WURFL is Loaded
     * @return bool true if WURFL is loaded
     */
 	public function isWURFLLoaded() {
        return $this->load(self::WURFL_LOADED);
    }
	
    /**
     * Sets the WURFL Loaded flag on the persistence provider 
     */
    public function setWURFLLoaded($loaded=true) {
        $this->save(self::WURFL_LOADED, $loaded);
    }
	
	/**
	 * Encode the Object Id using the Persistence Identifier
	 *
	 * @param string $input
	 */
	protected function encode($input) {
		return self::APPLICATION_PREFIX . $this->persistenceIdentifier . "_" . $input;  	
	}
	
	/**
	 * Decode the Object Id
	 *
	 * @param string $input
	 */
	protected function decode($input) {
		return substr($input, sizeof(self::APPLICATION_PREFIX . $this->persistenceIdentifier));
	}
	
	
	
	
}
