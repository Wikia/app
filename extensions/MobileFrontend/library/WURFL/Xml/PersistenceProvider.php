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
 */
/**
 * Persistence provider interface
 * @package    WURFL_Xml
 */
interface WURFL_Xml_PersistenceProvider {
	/**
	 * Saves the object 
	 *
	 * @param string $objectId
	 * @param mixed $object
	 */
    public function save($objectId, $object);

    
    /**
     * Loads the object identified by the objectId from the persistence
     * provider
     *
     * @param string $objectId
     * @return mixed value
     */
    public function load($objectId);
	
    
    /**
     * Removes the element form the Persistence identified by the object Id
     *
     * @param string $objectId
     */
    public function remove($objectId);
    
    /**
     * Removes all of entries from the persistence provider.
     */
    public function clear();
    
    /**
     * Returns true if WURFL is currently loaded in the persistence provider
     * @return bool
     */
    public function isWURFLLoaded();

    /**
	 * Sets the WURFL Loaded flag on the persistence provider
	 */
    public function setWURFLLoaded();

}