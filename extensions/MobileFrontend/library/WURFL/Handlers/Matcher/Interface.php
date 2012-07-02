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
 * @package    WURFL_Handlers_Matcher
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL user agent matcher interface
 * @package    WURFL_Handlers_Matcher
 */
interface WURFL_Handlers_Matcher_Interface {
	
	/**
	 * Attempts to find a matching $needle in given $collection within the specified $tolerance
	 * @param array $collection Collection of user agents
	 * @param string $needle User agent to search for
	 * @param int $tolerance Minimum accuracy to be considered a match
	 * @return string matched user agent
	 */
	public function match(&$collection, $needle, $tolerance);
}

