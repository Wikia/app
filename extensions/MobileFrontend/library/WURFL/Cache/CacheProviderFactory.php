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
 * Cache Provider factory
 * @package    WURFL_Cache
 */
class WURFL_Cache_CacheProviderFactory  {

	const FILE_CACHE_PROVIDER_DIR = "devices";
	const DEFAULT_CACHE_PROVIDER_NAME = "file";
	
	/**
	 * @var WURFL_Cache_CacheProvider
	 */
	private static $_cacheProvider;
	
	// prevent instantiation
	private function __construct(){}
	private function __clone(){}
	
	/**
	 * Returns a CacheProvider based on the given $cacheConfig
	 * @param WURFL_Configuration_Config $cacheConfig 
	 * @return WURFL_Cache_CacheProvider
	 */
	public static function getCacheProvider($cacheConfig=null) {
		$cacheConfig = is_null($cacheConfig) ? WURFL_Configuration_ConfigHolder::getWURFLConfig()->cache : $cacheConfig;
		$provider = isset($cacheConfig["provider"]) ? $cacheConfig["provider"] : NULL;
		$cache = isset($cacheConfig["params"]) ? $cacheConfig["params"] : NULL;
		switch ($provider) {
			case WURFL_Constants::FILE:
				self::$_cacheProvider = new WURFL_Cache_FileCacheProvider($cache);
				break;
			case WURFL_Constants::MEMCACHE:
				self::$_cacheProvider = new WURFL_Cache_MemcacheCacheProvider($cache);
				break;
			case WURFL_Constants::APC:
				self::$_cacheProvider = new WURFL_Cache_APCCacheProvider($cache);
				break;
			case WURFL_Constants::EACCELERATOR:
				self::$_cacheProvider = new WURFL_Cache_EAcceleratorCacheProvider($cache);
				break;
			case WURFL_Constants::MYSQL:
				self::$_cacheProvider = new WURFL_Cache_MysqlCacheProvider($cache);
				break;
			default:
				self::$_cacheProvider = new WURFL_Cache_NullCacheProvider();
				break;
		}
		return self::$_cacheProvider;
	}
}

