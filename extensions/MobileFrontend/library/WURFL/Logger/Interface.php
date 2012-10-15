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
 * @package    WURFL_Logger
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL Logging interface
 * 
 * @package    WURFL_Logger
 */
interface WURFL_Logger_Interface {
	
	/**
	 * Send specified $message to the log with INFO level
	 * @param string $message
	 */
	function info($message);
	/**
	 * Send specified $message to the log
	 * @param string $message
	 * @param string $type The type or level of the $message
	 */
	function log($message, $type="");
	/**
	 * Send specified $message to the log with DEBUG level
	 * @param string $message
	 */
	function debug($message);
}

