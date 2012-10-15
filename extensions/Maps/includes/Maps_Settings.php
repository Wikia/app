<?php

/**
 * Static class for interaction with the settings of the Maps extension.
 * 
 * @since 1.1
 * 
 * @file Maps_Settings.php
 * @ingroup Maps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsSettings extends ExtensionSettings {
	
	/**
	 * Initiate the settings list if not done already.
	 * 
	 * @since 1.1
	 * 
	 * @return boolean True if the settings where initiates in this call.
	 */
	protected static function initIfNeeded() {
		$init = parent::initIfNeeded();
		
		if ( $init ) {
			self::$settings['php-bc'] = self::getPhpCompatSettings();
		}
		
		return $init;
	}
	
	/**
	 * Returns a name => value array with the default settings.
	 * 
	 * @since 1.1
	 * 
	 * @return array
	 */
	protected static function getDefaultSettings() {
		static $defaultSettings = false;

		if ( $defaultSettings === false ) {
			$defaultSettings = array();
			
			foreach( ( include dirname( __FILE__ ) . '/../Maps.settings.php' ) as $setting ) {
				$defaultSettings[$setting->getName()] = $setting->getValue();
			} 
		}
		
		return $defaultSettings;
	}

	/**
	 * Returns a name => value array with the default settings
	 * specified using global PHP variables.
	 * 
	 * @since 1.1
	 * 
	 * @return array
	 */
	protected static function getPhpSettings() {
		return $GLOBALS['egMapsSettings'];
	}
	
	/**
	 * Returns a name => value array with the default settings
	 * specified using global PHP variables that have been deprecated.
	 * 
	 * @since 1.1
	 * 
	 * @return array
	 */
	protected static function getPhpCompatSettings() {
		$mappings = array(
			'egMapsAvailableServices' => 'services',
			'egMapsDefaultService' => 'defaultService',
			'egMapsDefaultServices' => 'defaultServices',
			'egMapsAvailableGeoServices' => 'geoServices',
			'egMapsDefaultGeoService' => 'defaultGeoService',
			'egMapsUserGeoOverrides' => 'useGeoOverrides',
			'egMapsAllowCoordsGeocoding' => 'allowCoordsGeocoding',
			'egMapsEnableGeoCache' => 'enableGeoCache',
			'egMapsGeoNamesUser' => 'geoNamesUser',
			'' => '',
		
			// TODO
		);
		
		$settings = array();
		
		foreach ( $mappings as $oldName => $newName ) {
			if ( array_key_exists( $oldName, $GLOBALS ) ) {
				$settings[$newName] = $GLOBALS[$oldName];
			}
		}
		
		return $settings;
	}
	
}

/**
 * Abstract static class for interaction with the settings of an extension.
 * Settings can be specified in various groups, and obtained by merging these
 * in a specific order. In most cases these will oly be the two default groups,
 * which are "default" and "php". The former contains the settings and their
 * default values while the later contains settings specified via PHP variables.
 * 
 * The setting groups are populated the first time a setting value is requested.
 * By default merged setting groups will be cached. This makes sense as in most
 * cases, the only combination accessed will be ["default", "php"].
 * 
 * Using this class one can access configuration without the use of globals and
 * in a way that allows for changing how the configuration is obtained. For
 * example, it's possible to obtain configuration via database instead of by
 * PHP vars or add in a user-preferences setting group without making changes
 * at any other place in the extension.
 * 
 * @since ?
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ExtensionSettings {
	
	/**
	 * The different groups of settings.
	 * array[ group name => array[ setting name => setting value ] ]
	 * 
	 * @since ?
	 * @var array
	 */
	protected static $settings = false;
	
	/**
	 * Cached merged settings groups. The keys are the name of the
	 * cache, which is created by joining the group names with a |.
	 * array[ cache name => settings[] ]
	 * 
	 * @since ?
	 * @var array
	 */
	protected static $mergedCaches = array();
	
	/**
	 * Returns a name => value array with the default settings.
	 * 
	 * @since ?
	 * 
	 * @return array
	 */
	protected static function getDefaultSettings() { return array(); }
	
	/**
	 * Initiate the settings list if not done already.
	 * 
	 * @since ?
	 * 
	 * @return boolean True if the settings where initiates in this call.
	 */
	protected static function initIfNeeded() {
		$init = static::$settings === false;
		
		if ( $init ) {
			static::$settings = array(
				'default' => static::getDefaultSettings(),
				'php' => static::getPhpSettings()
			);
		}
		
		return $init;
	}
	
	/**
	 * Returns the settings of the specified groups, merged.
	 * If available in the cache, it'll be used. If not,
	 * and $cache is true, it'll be cached.
	 * 
	 * @since 1.1
	 * 
	 * @param array $groups
	 * @param boolean $cache
	 * 
	 * @return array
	 */
	protected static function getMergedSettings( array $groups, $cache = true ) {
		$names = implode( '|', $groups ); 
		
		if ( array_key_exists( $names, static::$mergedCaches )  ) {
			return static::$mergedCaches[$names];
		}
		else {
			$settings = array();
			
			foreach ( $groups as $group ) {
				if ( array_key_exists( $group, static::$settings ) ) {
					// TODO: recursive merge, that does not append for arrays w/o named keys.
					$settings = array_merge( $settings, static::$settings[$group] );
				}
			}
			
			if ( $cache ) {
				static::$mergedCaches[$names] = $settings;
			}
			
			return $settings;
		}
	}
	
	/**
	 * Returns a name => value array with the default settings
	 * specified using global PHP variables.
	 * 
	 * @since ?
	 * 
	 * @return array
	 */
	protected static function getPhpSettings() {
		return array();
	}
	
	/**
	 * Returns all settings for a group.
	 * 
	 * @since ?
	 * 
	 * @param array|boolean $groups True to use all overrides, false for none, array for custom set or order. 
	 * @param boolean $cache Cache the merging of groups or not?
	 * 
	 * @return array
	 */
	public static function getSettings( $groups = true, $cache = true ) {
		static::initIfNeeded();
		
		if ( $groups === false ) {
			return static::getDefaultSettings(); 
		}
		else {
			if ( $groups === true ) {
				$groups = array_keys( static::$settings );
			}
			return static::getMergedSettings( $groups, $cache );
		}
	}
	
	/**
	 * Returns the value of a single setting.
	 * 
	 * @since ?
	 * 
	 * @param string $settingName
	 * @param array|boolean $groups
	 * @param boolean $cache Cache the merging of groups or not?
	 * 
	 * @return mixed
	 */
	public static function get( $settingName, $groups = true, $cache = true ) {
		$settings = static::getSettings( $groups, $cache );
		
		if ( !array_key_exists( $settingName, $settings ) ) {
			throw new MWException(); // TODO
		}
		
		return $settings[$settingName];
	}

	/**
	 * Returns if a single setting exists or not.
	 * 
	 * @since ?
	 * 
	 * @param string $settingName
	 * @param array|boolean $groups
	 * @param boolean $cache Cache the merging of groups or not?
	 * 
	 * @return boolean
	 */
	public static function has( $settingName, $groups = true, $cache = true ) {
		$settings = static::getSettings( $groups, $cache );
		return array_key_exists( $settingName, $settings );
	}

	/**
	 * Set a sigle setting in the specified group.
	 * 
	 * @since ?
	 * 
	 * @param string $settingName
	 * @param mixed $settingValue
	 * @param string $groupName
	 * @param boolean $invalidateCache
	 * 
	 * @return boolean
	 */
	public static function set( $settingName, $settingValue, $groupName, $invalidateCache = true ) {
		if ( !array_key_exists( $groupName, static::$settings ) ) {
			static::$settings[$groupName] = array();
		}
		elseif ( $invalidateCache
			&& ( !array_key_exists( $settingName, static::$settings[$groupName] )
				|| static::$settings[$groupName][$settingName] !== $settingValue ) ) {
			static::ivalidateCachesForGroup( $groupName );
		}
		
		static::$settings[$groupName][$settingName] = $settingValue;
	}
	
	/**
	 * Invalidate the cahces that contain data from the specified group.
	 * 
	 * @since ?
	 * 
	 * @param name $group
	 */
	protected static function ivalidateCachesForGroup( $group ) {
		foreach ( array_keys( static::$mergedCaches ) as $cacheName ) {
			if ( in_array( $groupName, explode( '|', $cacheName ) ) ) {
				unset( static::$mergedCaches[$cacheName] );
			}
		}		
	}
	
}

/**
 * Simple class to define settings, which can be represented
 * as key values pairs, together with meta data such as 
 * description messages and how they can be represented in
 * as UI elements.
 * 
 * @since ?
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Setting {
	
	protected $name;
	protected $value;
	protected $message = false;
	
	public static function newFromValue( $name, $value ) {
		return new Setting( $name, $value );
	}
	
	public function __construct( $name, $value, $message = false ) {
		$this->name = $name;
		$this->value = $value;
		$this->message = $message;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getMessage() {
		return $this->message;
	}

	public function setMessage( $message ) {
		$this->message = $message;
	}
	
}
