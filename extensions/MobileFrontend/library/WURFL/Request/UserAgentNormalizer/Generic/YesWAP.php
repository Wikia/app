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
 * @package    WURFL_Request_UserAgentNormalizer_Generic
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * User Agent Normalizer - removes YesWAP garbage from user agent
 * @package    WURFL_Request_UserAgentNormalizer_Generic
 */
class WURFL_Request_UserAgentNormalizer_Generic_YesWAP implements WURFL_Request_UserAgentNormalizer_Interface  {

	const YES_WAP_REGEX = "/\\s*Mozilla\\/4\\.0 \\(YesWAP mobile phone proxy\\)/";
	
	public function normalize($userAgent) {
		return preg_replace(self::YES_WAP_REGEX, "", $userAgent);
	}
}