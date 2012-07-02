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
 * @package    WURFL_Storage
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * WURFL Storage factory
 * @package    WURFL_Storage
 */
class WURFL_Storage_Factory {
	
	/**
	 * @var array Default configuration
	 */
    private static $defaultConfiguration = array(
        "provider" => "memory",
        "params" => array()
    );
    
    /**
     * Create a configuration based on the default configuration with the differences from $configuration
     * @param array $configuration
     * @return WURFL_Storage_Base Storage object, initialized with the given $configuration
     */
    public static function create($configuration) {
        $currentConfiguration = is_array($configuration) ?
                array_merge(self::$defaultConfiguration, $configuration)
                : self::$defaultConfiguration;
        $class = self::className($currentConfiguration);
        return new $class($currentConfiguration["params"]);
    }
	
    /**
     * Return the Storage Provider Class name from the given $configuration by using its 'provider' element
     * @param array $configuration
     * @return string WURFL Storage Provider class name
     */
    private static function className($configuration) {
        $provider = $configuration["provider"];
        return "WURFL_Storage_" . ucfirst($provider);
    }
}