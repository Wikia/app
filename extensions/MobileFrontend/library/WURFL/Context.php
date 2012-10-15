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
 * WURFL Context stores the persistence provider, cache provider and logger objects
 * @package    WURFL
 */
class WURFL_Context {
	
	/**
	 * @var WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider
	 */
	private $persistenceProvider;
	/**
	 * @var WURFL_Cache_CacheProvider
	 */
	private $cacheProvider;
	/**
	 * @var WURFL_Logger_Interface
	 */
	private $logger;
	
	public function __construct($persistenceProvider, $caheProvider = null, $logger = null) {
		$this->persistenceProvider = $persistenceProvider;
		$this->cacheProvider = is_null($caheProvider) ? new WURFL_Cache_NullCacheProvider() : $caheProvider;
		$this->logger = is_null($logger) ? new WURFL_Logger_NullLogger() : $logger;
	}
	
	public function cacheProvider($cacheProvider) {
		return new WURFL_Context ( $this->persistenceProvider, $cacheProvider, $this->logger );
	}
	
	public function logger($logger) {
		return new WURFL_Context ( $this->persistenceProvider, $this->cacheProvider, $logger );
	}
	
	public function __get($name) {
		return $this->$name;
	}

}