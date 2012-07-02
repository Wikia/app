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
 * @package    WURFL_Request_UserAgentNormalizer
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * Null User Agent Normalizer - does not normalize anything
 * @package    WURFL_Request_UserAgentNormalizer
 */
class WURFL_Request_UserAgentNormalizer_Null implements WURFL_Request_UserAgentNormalizer_Interface  {

	public function normalize($userAgent) {		
		return $userAgent;
	}
}