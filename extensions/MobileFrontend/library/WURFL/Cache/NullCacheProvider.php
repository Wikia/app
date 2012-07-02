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
 * Cache provider to prevent caching
 * @package    WURFL_Cache
 */
class WURFL_Cache_NullCacheProvider implements WURFL_Cache_CacheProvider  {
	
	public function get($key) {
		return null;
	}
	
	public function put($key, $value, $expire=0) {}
	
	public function clear() {}
	
}