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
 * EAcceleratorCacheProvider
 * 
 * An Implementation of the Cache using the eAccelerator cache
 * module.(http://eaccelerator.net/)
 *
 * @category   WURFL
 * @package    WURFL_Cache
 */
class WURFL_Cache_EAcceleratorCacheProvider implements WURFL_Cache_CacheProvider {
	
	private $expire;
	
	function __construct($params) {
		if (is_array ( $params )) {
			$this->expire = isset ( $params [WURFL_Cache_CacheProvider::EXPIRATION] ) ? $params [WURFL_Cache_CacheProvider::EXPIRATION] : WURFL_Cache_CacheProvider::NEVER;
		}
	}
	
	function get($key) {
		return eaccelerator_get ( $key );
	}
	
	function put($key, $value) {
		eaccelerator_put ( $key, $value, $this->expire );
	}
	
	function clear() {
	}
}

