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
 * @package    WURFL_Request_UserAgentNormalizer_Specific
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * User Agent Normalizer - Return the Konqueror user agent with the major version		
 * e.g 
 * 	Mozilla/5.0 (compatible; Konqueror/4.1; Linux) KHTML/4.1.2 (like Gecko) -> Konqueror/4
 * @package    WURFL_Request_UserAgentNormalizer_Specific
 */
class WURFL_Request_UserAgentNormalizer_Specific_Konqueror implements WURFL_Request_UserAgentNormalizer_Interface  {

	const KONQUEROR = "Konqueror";
	
	public function normalize($userAgent) {
		return $this->konquerorWithMajorVersion($userAgent);
	}
	
	/**
	 * Return KDE Konquerer major version
	 * @param string $userAgent
	 * @return string|int Major version number
	 */
	private function konquerorWithMajorVersion($userAgent) {
		return substr($userAgent, strpos($userAgent, self::KONQUEROR), 10);
	}

}


