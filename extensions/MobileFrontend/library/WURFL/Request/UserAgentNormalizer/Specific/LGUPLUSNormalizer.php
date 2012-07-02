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
 * User Agent Normalizer
 * @package    WURFL_Request_UserAgentNormalizer_Specific
 */
class WURFL_Request_UserAgentNormalizer_Specific_LGUPLUSNormalizer implements WURFL_Request_UserAgentNormalizer_Interface {
    const LGPLUS_PATTERN = "/Mozilla.*(Windows (?:NT|CE)).*(POLARIS|WV).*lgtelecom;.*;(.*);.*/";

    public function normalize($userAgent) {
        return preg_replace(self::LGPLUS_PATTERN, "$3 $1 $2", $userAgent);
        /*
        $matches = array();
        if (preg_match(self::LGPLUS_PATTERN, $userAgent, $matches) != 0) {
            return $matches[1];
        }
        return $userAgent;
        */
    }

}

