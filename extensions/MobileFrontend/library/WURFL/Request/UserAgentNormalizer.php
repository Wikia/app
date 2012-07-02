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
 * User Agent Normalizer
 * @package    WURFL_Request
 */
class WURFL_Request_UserAgentNormalizer implements WURFL_Request_UserAgentNormalizer_Interface {

	/**
	 * UserAgentNormalizer chain - array of WURFL_Request_UserAgentNormalizer objects
	 * @var array
	 */
	protected $_userAgentNormalizers = array();
	
	/**
	 * Set the User Agent Normalizers
	 * @param array $normalizers Array of WURFL_Request_UserAgentNormalizer objects
	 */
	function __construct($normalizers = array()) {
		if(is_array($normalizers)) {
			$this->_userAgentNormalizers = $normalizers;
		}
	}
	
	/**
	 * Adds a new UserAgent Normalizer to the chain
	 * @param WURFL_UserAgentNormalizer_Interface $Normalizer
	 * @return WURFL_Request_UserAgentNormalizer
	 */
	public function addUserAgentNormalizer(WURFL_Request_UserAgentNormalizer_Interface $normalizer) {
		$userAgentNormalizers = $this->_userAgentNormalizers; 
		$userAgentNormalizers[] = $normalizer;
		return new WURFL_Request_UserAgentNormalizer($userAgentNormalizers);
	}
	
	/**
	 * Return the number of normalizers currently registered
	 * @return int count
	 */
	public function count() {
		return count($this->_userAgentNormalizers);
	}
	
	/**
	 * Normalize the given $userAgent by passing down the chain 
	 * of normalizers
	 *
	 * @param string $userAgent
	 * @return string Normalized user agent
	 */
	public function normalize($userAgent) {
		$normalizedUserAgent = $userAgent;
		foreach ($this->_userAgentNormalizers as $normalizer) {
			$normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);
		}
		return $normalizedUserAgent;
	}
}

