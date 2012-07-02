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
 * Base Storage Provider
 *
 * A Skeleton implementation of the Storage Interface
 *
 * @category   WURFL
 * @package    WURFL_Storage
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
abstract class WURFL_Storage_Base implements WURFL_Storage {

    const APPLICATION_PREFIX = "WURFL_";
    const WURFL_LOADED = "WURFL_WURFL_LOADED";

	/**
	 * Creates a new WURFL_Storage_Base
	 * @param array $params
	 */
    public function __construct($params = array()) {}

    /**
     * Saves the object
     * @param string $objectId
     * @param mixed $object
     */
    public function save($objectId, $object) {}

    /**
     * Returns the object identified by $objectId
     * @param string $objectId
     * @return mixed value
     */
    public function load($objectId) {}


    /**
     * Removes the object identified by $objectId from the persistence provider
     * @param string $objectId
     */
    public function remove($objectId) {}


    /**
     * Removes all entries from the Persistence Provider
     */
    public function clear() {}


    /**
     * Checks if WURFL is Loaded
     * @return bool
     */
    public function isWURFLLoaded() {
        return $this->load(self::WURFL_LOADED);
    }

    /**
     * Sets the WURFL Loaded flag
     * @param bool $loaded
     */
    public function setWURFLLoaded($loaded = true) {
        $this->save(self::WURFL_LOADED, $loaded);
    }


    /**
	 * Encode the Object Id using the Persistence Identifier
	 * @param string $namespace
	 * @param string $input
	 * @return string $input with the given $namespace as a prefix
	 */
    protected function encode($namespace, $input) {
        return join(":", array(self::APPLICATION_PREFIX, $namespace, $input));
    }

    /**
     * Decode the Object Id
     * @param string $input
     * @return string value
     */
    protected function decode($namespace, $input) {
        $inputs = explode(":", $input);
        return $input[2];
    }


}
