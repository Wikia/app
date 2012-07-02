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
 * Persistence provider for APC
 * @package    WURFL_Xml_PersistenceProvider
 */
class WURFL_Xml_PersistenceProvider_APCPersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {
	
	const EXTENSION_MODULE_NAME = "apc";
	
	protected $persistenceIdentifier = "APC_PERSISTENCE_PROVIDER";
	
	public function initialize() {
		$this->_ensureModuleExistance ();
	}
	
	public function save($objectId, $object) {
		apc_store ( $this->encode ( $objectId ), $object );
	}
	
	public function load($objectId) {
		$value = apc_fetch ( $this->encode ( $objectId ) );
		return $value !== false ? $value : NULL;
	}
	
	public function remove($objectId) {
		apc_delete ( $this->encode ( $objectId ) );
	}
	
	/**
	 * Removes all entry from the Persistence Provider
	 *
	 */
	public function clear() {
		apc_clear_cache ( "user" );
	}
	
	/**
	 * Ensures the existance of the the PHP Extension apc
	 *
	 */
	private function _ensureModuleExistance() {
		if (! (extension_loaded ( self::EXTENSION_MODULE_NAME ) && ini_get ( 'apc.enabled' ) == true)) {
			throw new WURFL_Xml_PersistenceProvider_Exception ( "The PHP extension apc must be installed, loaded and enabled." );
		}
	}

}