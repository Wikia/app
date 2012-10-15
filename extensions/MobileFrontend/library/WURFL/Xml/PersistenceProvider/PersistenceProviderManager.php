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
 *
 * @category   WURFL
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Persistence Provider Manager
 * @package    WURFL_Xml_PersistenceProvider
 */
class WURFL_Xml_PersistenceProvider_PersistenceProviderManager {
	
	/**
	 * @var WURFL_Xml_PersistenceProvider
	 */
	private static $_persistenceProvider;
	
	/**
	 * Returns the persistence provider based on the given $wurflConfig
	 * @param WURFL_Configuration_Config $wurflConfig
	 * @return WURFL_Xml_PersistenceProvider Persistence Provider
	 */
	public static function getPersistenceProvider($persistenceConfig = null) {
		if (! isset ( self::$_persistenceProvider )) {
			self::_initialize ( $persistenceConfig );
		}
		return self::$_persistenceProvider;
	}
	
	/**
	 * Initializes the Persistence Provider Manager
	 * @param array $persistenceConfig Persistence configuration
	 * @see WURFL_Configuration_ConfigHolder::getWURFLConfig()
	 */
	private static function _initialize($persistenceConfig) {
    	
    	$persistenceConfig = is_null($persistenceConfig) ? WURFL_Configuration_ConfigHolder::getWURFLConfig()->persistence : $persistenceConfig;
		$provider = $persistenceConfig["provider"];
		$persistenceParams = isset($persistenceConfig["params"]) ? $persistenceConfig["params"] : array();
		
		switch ($provider) {
			case WURFL_Constants::MEMCACHE :
				self::$_persistenceProvider = new WURFL_Xml_PersistenceProvider_MemcachePersistenceProvider ( $persistenceParams );
				break;
			case WURFL_Constants::APC :
				self::$_persistenceProvider = new WURFL_Xml_PersistenceProvider_APCPersistenceProvider ( $persistenceParams );
				break;
			case WURFL_Constants::MYSQL :
				self::$_persistenceProvider = new WURFL_Xml_PersistenceProvider_MysqlPersistenceProvider ( $persistenceParams );
				break;
			case WURFL_Xml_PersistenceProvider_InMemoryPersistenceProvider::IN_MEMORY :
				self::$_persistenceProvider = new WURFL_Xml_PersistenceProvider_InMemoryPersistenceProvider ( $persistenceParams );
				break;
				
			default :
				self::$_persistenceProvider = new WURFL_Xml_PersistenceProvider_FilePersistenceProvider ( $persistenceParams );
				break;
		}
	}

}