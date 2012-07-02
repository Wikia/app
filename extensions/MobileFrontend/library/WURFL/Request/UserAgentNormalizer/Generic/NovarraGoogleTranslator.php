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
 * User Agent Normalizer - removes Novarra garbage from user agent
 * @package    WURFL_Request_UserAgentNormalizer_Generic
 */
class WURFL_Request_UserAgentNormalizer_Generic_NovarraGoogleTranslator implements WURFL_Request_UserAgentNormalizer_Interface {
	
	const NOVARRA_GOOGLE_TRANSLATOR_PATTERN = "/(\sNovarra-Vision.*)|(,gzip\(gfe\)\s+\(via translate.google.com\))/";
	
	public function normalize($userAgent) {
		return preg_replace(self::NOVARRA_GOOGLE_TRANSLATOR_PATTERN, "", $userAgent);
	}

}

