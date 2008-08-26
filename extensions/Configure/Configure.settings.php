<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Hold configuration settings access
 * @ingroup Extensions
 */
class ConfigurationSettings {
	protected $types, $initialized = false;
	
	// Core settings
	protected $settings, $arrayDefs, $editRestricted, $viewRestricted,
		$notEditableSettings, $settingsVersion;

	// Extension settings
	protected $extensions;

	public static function singleton( $types ){
		static $instances = array();
		if( !isset( $instances[$types] ) )
			$instances[$types] = new self( $types );
		return $instances[$types];
	}

	/**
	 * Constructor
	 * private, use ConfigurationSettings::sigleton() to get an instance
	 */
	protected function __construct( $types ){
		$this->types = $types;
	}

	/**
	 * Load messages and initialise static variables
	 */
	protected function loadSettingsDefs(){
		if( $this->initialized )
			return;
		$this->initialized = true;

		require( dirname( __FILE__ ) . '/Configure.settings-core.php' );
		$this->settings = $settings;
		$this->arrayDefs = $arrayDefs;
		$this->editRestricted = $editRestricted;
		$this->viewRestricted = $viewRestricted;
		$this->notEditableSettings = $notEditableSettings;
		$this->settingsVersion = $settingsVersion;

		require( dirname( __FILE__ ) . '/Configure.settings-ext.php' );
		$this->extensions = $extensions;
	}

	/**
	 * Get an array of WebExtensions objects
	 *
	 * @return array
	 */
	public function getAllExtensionsObjects(){
		static $list = array();
		if( !empty( $list ) )
			return $list;
		$this->loadSettingsDefs();
		global $wgConfigureAdditionalExtensions;
		$extensions = array_merge( $this->extensions, $wgConfigureAdditionalExtensions );
		usort( $extensions, array( __CLASS__, 'compExt' ) );
		foreach( $extensions as $ext ){
			$ext = new WebExtension( $ext );
			if( $ext->isInstalled() ){
				$list[] = $ext;
			}
		}
		return $list;
	}

	/**
	 * Callback to sort extensions
	 */
	public static function compExt( $e1, $e2 ){
		return strcmp( $e1['name'], $e2['name'] );	
	}

	/**
	 * Get settings, grouped by section
	 *
	 * @return array
	 */
	public function getSettings(){
		$this->loadSettingsDefs();
		$ret = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ){
			$ret += $this->settings;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ){
			static $extArr;
			if( !isset( $extArr ) ){
				foreach( $this->getAllExtensionsObjects() as $ext ){
					$name = $ext->getName();
					if( count( $ext->getSettings() ) )
						$extArr['mw-extensions'][$name] = $ext->getSettings();
				}
			}
			$ret += $extArr;
		}
		return $ret;
	}

	/**
	 * Get a simple array with all config settings
	 *
	 * @return array
	 */
	public function getAllSettings(){
		static $arr;
		if( isset( $arr ) )
			return $arr;
		$this->loadSettingsDefs();
		$arr = array();
		foreach( $this->getSettings() as $section ){
			foreach( $section as $group ){
				$arr = array_merge( $arr, $group );
			}
		}
		return $arr;
	}

	/**
	 * Get the list of settings that are view restricted
	 *
	 * @return array
	 */
	public function getViewRestricted(){
		$this->loadSettingsDefs();
		$ret = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ){
			$ret += $this->viewRestricted;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ){
			$ret += array(); // Nothing for extensions
		}
		return $ret;
	}

	/**
	 * Get the list of settings that are edit restricted
	 *
	 * @return array
	 */
	public function getEditRestricted(){
		$this->loadSettingsDefs();
		$ret = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ){
			$ret += $this->editRestricted;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ){
			$ret += array(); // Nothing for extensions
		}
		return $ret;
	}

	/**
	 * Get the list of settings that aren't editable by anybody
	 *
	 * @return array
	 */
	public function getNotEditableSettings(){
		$this->loadSettingsDefs();
		$ret = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ){
			$ret += $this->notEditableSettings;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ){
			$ret += array(); // Nothing for extensions
		}
		return $ret;
	}

	/**
	 * Get the list of all arrays settings, mapping setting name to its type
	 *
	 * @return array
	 */
	public function getArrayDefs(){
		static $list;
		if( isset( $list ) )
			return $list;
		$list = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ){
			$list += $this->arrayDefs;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ){
			foreach( $this->getAllExtensionsObjects() as $ext ){
				$list  += $ext->getArrayDefs();
			}
		}
		return $list;
	}

	/**
	 * Return true if the setting is available in this version of MediaWiki
	 *
	 * @return bool
	 */
	public function isSettingAvailable( $setting ){
		$this->loadSettingsDefs();
		if( !array_key_exists( $setting, $this->getAllSettings() ) )
			return false;
		if( !array_key_exists( $setting, $this->settingsVersion ) )
			return true;
		global $wgVersion;
		foreach( $this->settingsVersion[$setting] as $test ){
			list( $ver, $comp ) = $test;
			if( !version_compare( $wgVersion, $ver, $comp ) )
				return false;
		}
		return true;
	}

	/**
	 * Get the type of a setting
	 *
	 * @return mixed
	 */
	public function getSettingType(){
		$settings = $this->getAllSettings();
		if( isset( $settings[$setting] ) )
			return $settings[$setting];
		else
			return false;
	}

	/**
	 * Get the array type of a setting
	 *
	 * @param $setting String: setting name
	 */
	public function getArrayType( $setting ){
		$arr = $this->getArrayDefs();
		return isset( $arr[$setting] ) ?
			$arr[$setting] :
			null;
	}
}
