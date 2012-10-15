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
 * @package    WURFL_Request
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * Generic WURFL Request object containing User Agent, UAProf and xhtml device data
 * @package    WURFL_Request
 */
class WURFL_Request_GenericRequest {
	
	private $userAgent;
	private $userAgentProfile;
	private $xhtmlDevice;
	private $id;
	
	/**
	 * @param string $userAgent
	 * @param string $userAgentProfile
	 * @param string $xhtmlDevice
	 */
	function __construct($userAgent, $userAgentProfile=null, $xhtmlDevice=null){
		$this->userAgent = $userAgent;
		$this->userAgentProfile = $userAgentProfile;
		$this->xhtmlDevice = $xhtmlDevice;
		$this->id = md5($this->userAgent);
	}
	
	function __get($name){
		return $this->$name;
	}
}

