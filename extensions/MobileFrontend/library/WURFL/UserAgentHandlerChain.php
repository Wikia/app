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
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * Handles the chain of WURFL_Handlers_Handler objects
 * @package    WURFL
 * @see WURFL_Handlers_Handler
 */
class WURFL_UserAgentHandlerChain {
	 
	/**
	 * @var array of WURFL_Handlers_Handler objects
	 */
	private $_userAgentHandlers = array();
	
	/**
	 * Adds a WURFL_Handlers_Handler to the chain
	 *
	 * @param WURFL_UserAgentHandler_Interface $handler
	 * @return WURFL_UserAgentHandlerChain $this
	 */
	public function addUserAgentHandler(WURFL_Handlers_Handler $handler) {
		$size = sizeof($this->_userAgentHandlers); 
		if ($size > 0) {
			$this->_userAgentHandlers[$size-1]->setNextHandler($handler);
		}
		$this->_userAgentHandlers[] = $handler;
		return $this;
	}
	
	/**
	 * @return array An array of all the WURFL_Handlers_Handler objects
	 */
	public function getHandlers() {
		return $this->_userAgentHandlers;
	}
	
	/**
	 * Adds the pair $userAgent, $deviceID to the clusters they belong to.
	 *
	 * @param String $userAgent
	 * @param String $deviceID
	 */
	public function filter($userAgent, $deviceID) {
		$this->_userAgentHandlers[0]->filter($userAgent, $deviceID);
	}
	
	
	
	/**
	 * Return the the device id for the request 
	 *
	 * @param WURFL_Request_GenericRequest $request
	 * @return String deviceID
	 */
	public function match(WURFL_Request_GenericRequest $request) {
		return $this->_userAgentHandlers[0]->match($request);
	}
	
	/**
	 * Save the data from each WURFL_Handlers_Handler
	 * @see WURFL_Handlers_Handler::persistData()
	 */
	public function persistData() {
		foreach ($this->_userAgentHandlers as $userAgentHandler) {
			$userAgentHandler->persistData();
		}
		
	}
	
	/**
	 * Collect data
	 * @return array data
	 */
	public function collectData() {
		$userAgentsWithDeviceId = array();		
		foreach ($this->_userAgentHandlers as $userAgentHandler) {
			/**
			 * @see WURFL_Handlers_Handler::getUserAgentsWithDeviceId()
			 */
			$current = $userAgentHandler->getUserAgentsWithDeviceId();
			if(!empty($current)) {
				$userAgentsWithDeviceId = array_merge($userAgentsWithDeviceId, $current);
			} 
		}
		return $userAgentsWithDeviceId;
	}
	
	
	
	
}

