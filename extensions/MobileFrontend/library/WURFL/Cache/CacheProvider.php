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
 * @package    WURFL_Cache
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

/**
 * WURFL_Cache_CacheProvider is the base interface for any type of caching implementation.
 * It provides an API that allows storing and retrieving resources.
 *
 *
 * @category   WURFL
 * @package    WURFL_Cache
 */
interface WURFL_Cache_CacheProvider {
	
	/**
	 * @var string Key for storing the expiration
	 */
	const EXPIRATION = "expiration";
	
	const ONE_HOUR = 3600;
	const ONE_DAY = 86400;
	const ONE_WEEK = 604800;
	const ONE_MONTH = 2592000;
	const ONE_YEAR = 31556926;
	const NEVER = 0;
	
	
	/**
	 * Put the the computed data into the cache so that it can be
	 * retrieved later.
	 * @param string $key Key for accessing the data
	 * @param mixed $value The actual data been stored
	 */
	function put($key, $value);

	/**
	 * Get the previously saved data.
	 * @param string $key Key for accessing the data
	 * @return mixed the actual data been retrieved
	 */
	function get($key);
	
	/**
	 * Invalidates the Cache, removing all cached devices
	 */
	function clear();
}
