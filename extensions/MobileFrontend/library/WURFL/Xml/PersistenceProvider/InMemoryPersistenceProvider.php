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
 * In-Memory persistence provider
 * @package    WURFL_Xml_PersistenceProvider
 */
class WURFL_Xml_PersistenceProvider_InMemoryPersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {
	
	const IN_MEMORY = "memory";
	
	protected $persistenceIdentifier = "IN_MEMORY_PERSISTENCE_PROVIDER";
	
	private $map;
	
	public function __construct() {
		$this->map = array();
	}
	
	public function save($objectId, $object) {
		$this->map[$this->encode ( $objectId )] = $object;
	}
	
	public function load($objectId) {
		$key = $this->encode ( $objectId);
		if (isset($this->map [$key])) {
			return $this->map [$key];
		}
		
		return null;
	
	}
	
	public function remove($objectId) {
		$key = $this->encode ( $objectId );
		if($this->map [$key]) {
			unset ( $this->map [$key] );
		}
	
	}
	
	/**
	 * Removes all entry from the Persistence Provier
	 *
	 */
	public function clear() {
		unset($this->map);
	}
}
