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
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL_Handlers_Filter is the base interface that concrete classes
 * must implement to classify the devices by user agent and then persist
 * the resulting datastructures.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

interface WURFL_Handlers_Filter {

	/**
	 * The filter() method is used to classify devices based on patterns
	 * in their user agents.
	 *  
	 * @param string $userAgent User Agent of the device
	 * @param string $deviceID  id of the the device
	 * 
	 */
	public function filter($userAgent, $deviceID);

	/**
	 * The persistData() method is resposible to 
	 * saving the classification output(associative arrays that holds <userAgent, deviceID> pair))  
	 *
	 */
	public function persistData();


}

