<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Hold configuration settings access
 * @ingroup Extensions
 */
class ConfigurationSettings {
	protected $types, $initialized = false;

	// Core settings
	protected $settings, $arrayDefs, $emptyValues, $editRestricted,
		$viewRestricted, $notEditableSettings, $settingsVersion;

	protected $extensionsObjects = null;

	// Cache
	protected $cache = array();

	public static function singleton( $types ) {
		static $instances = array();
		if ( !isset( $instances[$types] ) )
			$instances[$types] = new self( $types );
		return $instances[$types];
	}

	/**
	 * Constructor
	 * private, use ConfigurationSettings::sigleton() to get an instance
	 */
	protected function __construct( $types ) {
		$this->types = $types;
	}

	/**
	 * Load messages and initialise static variables
	 */
	protected function loadSettingsDefs() {
		if ( $this->initialized ) return;
		$this->initialized = true;

		wfProfileIn( __METHOD__ );

		require( dirname( __FILE__ ) . '/Settings-core.php' );
		$this->settings = $settings;
		$this->arrayDefs = $arrayDefs;
		$this->emptyValues = $emptyValues;
		$this->editRestricted = $editRestricted;
		$this->viewRestricted = $viewRestricted;
		$this->notEditableSettings = $notEditableSettings;
		$this->settingsVersion = $settingsVersion;

		wfProfileOut( __METHOD__ );
	}

	protected function loadExtensions() {
		if ( is_array( $this->extensionsObjects ) )
			return;

		wfProfileIn( __METHOD__ );

		global $wgConfigureAdditionalExtensions;
		$coreExtensions = TxtDef::loadFromFile( dirname( __FILE__ ) . '/Settings-ext.txt', array( 'key' => 'name' ) );
		$extensions = array_merge( $coreExtensions, $wgConfigureAdditionalExtensions );
		usort( $extensions, array( __CLASS__, 'compExt' ) );
		$list = array();
		foreach( $extensions as $ext ) {
			$ext = new WebExtension( $ext );
			#if( $ext->isInstalled() ) {
				$list[] = $ext;
			#}
		}
		
		$this->extensionsObjects = $list;
		
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get an array of WebExtensions objects
	 *
	 * @return array
	 */
	public function getAllExtensionsObjects() {
		$this->loadExtensions();
		
		return $this->extensionsObjects;
	}

	/**
	 * Get an extension object by name
	 */
	public function getExtension( $name ) {
		$this->loadExtensions();
		
		foreach( $this->extensionsObjects as $ext )
			if ( $ext->getName() == $name )
				return $ext;

		return null;
	}

	/**
	 * Callback to sort extensions
	 */
	public static function compExt( $e1, $e2 ) {
		return strcasecmp( $e1['name'], $e2['name'] );
	}

	/**
	 * Get settings, grouped by section
	 *
	 * @return array
	 */
	public function getSettings() {
		wfProfileIn( __METHOD__ );
		$this->loadSettingsDefs();
		$ret = array();
		if( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$ret = $this->settings;
		}
		if( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			static $extArr = null;
			if( is_null( $extArr ) ) {
				$extArr = array();
				foreach( $this->getAllExtensionsObjects() as $ext ) {
					if( !$ext->isUsable() )
						continue;
 					$extSettings = $ext->getSettings();
 					if( $ext->useVariable() )
 						$extSettings[$ext->getVariable()] = 'bool';
 					if( count( $extSettings ) )
 						$extArr['mw-extensions'][$ext->getName()] = $extSettings;
				}
			}
			$ret += $extArr;
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Get a simple array with all config settings
	 *
	 * @return array
	 */
	public function getAllSettings() {
		if( isset( $this->cache['all'] ) ) {
			return $this->cache['all'];
		}
		wfProfileIn( __METHOD__ );
		$this->loadSettingsDefs();
		$arr = array();
		foreach( $this->getSettings() as $section ) {
			foreach( $section as $group ) {
				foreach( $group as $var => $type ) {
					$arr[$var] = $type;
				}
			}
		}
		$this->cache['all'] = $arr;
		wfProfileOut( __METHOD__ );
		return $this->cache['all'];
	}

	/**
	 * Get the list of settings that are view restricted
	 *
	 * @return array
	 */
	public function getViewRestricted() {
		$this->loadSettingsDefs();
		wfProfileIn( __METHOD__ );
		$ret = array();
		if ( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$ret += $this->viewRestricted;
		}
		if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			foreach ( $this->getAllExtensionsObjects() as $ext ) {
				$ret = array_merge( $ret, $ext->getViewRestricted() );
			}
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Get the list of settings that are edit restricted
	 *
	 * @return array
	 */
	public function getEditRestricted() {
		$this->loadSettingsDefs();
		wfProfileIn( __METHOD__ );
		$ret = array();
		if ( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$ret += $this->editRestricted;
		}
		if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			foreach ( $this->getAllExtensionsObjects() as $ext ) {
				$ret = array_merge( $ret, $ext->getEditRestricted() );
			}
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Get the list of settings that aren't editable by anybody
	 *
	 * @return array
	 */
	public function getUneditableSettings() {
		if ( isset( $this->cache['uneditable'] ) )
			return $this->cache['uneditable'];

		$this->loadSettingsDefs();

		wfProfileIn( __METHOD__ );

		$notEditable = array();
		if ( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$notEditable += $this->notEditableSettings;
		}
		if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			$notEditable += array(); // Nothing for extensions
		}

		global $wgConf, $wgConfigureNotEditableSettings, $wgConfigureEditableSettings;
		$notEditable = array_merge( $notEditable, $wgConf->getUneditableSettings() );

		if ( !count( $wgConfigureNotEditableSettings ) && count( $wgConfigureEditableSettings ) &&
			( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			// Only disallow core settings, not extensions settings!
			$coreSettings = array();
			foreach( $this->settings as $section ) {
			foreach( $section as $group ) {
				foreach( $group as $var => $type ) {
					$coreSettings[] = $var;
				}
			}
		}
			$wgConfigureNotEditableSettings = array_diff( $coreSettings, $wgConfigureEditableSettings );
		}

		$notEditable = array_merge( $notEditable,
			$wgConfigureNotEditableSettings );

		wfProfileOut( __METHOD__ );

		return $this->cache['uneditable'] = $notEditable;
	}

	/**
	 * Get a list of editable settings
	 *
	 * @return array
	 */
	public function getEditableSettings() {
		if ( isset( $this->cache['editable'] ) )
			return $this->cache['editable'];

		$this->cache['editable'] = array();
		$this->loadSettingsDefs();

		wfProfileIn( __METHOD__ );

		global $wgConfigureEditableSettings;
		if( count( $wgConfigureEditableSettings ) ) {
			foreach( $wgConfigureEditableSettings as $setting ) {
				$this->cache['editable'][$setting] = $this->getSettingType( $setting );
			}
			// We'll need to add extensions settings
			if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
				foreach ( $this->getAllExtensionsObjects() as $ext ) {
					$this->cache['editable'] += $ext->getSettings();
				}
			}
			wfProfileOut( __METHOD__ );
			return $this->cache['editable'];
		}

		$notEdit = $this->getUneditableSettings();
		$settings = $this->getAllSettings();
		foreach ( $notEdit as $setting )
			unset( $settings[$setting] );

		wfProfileOut( __METHOD__ );

		return $this->cache['editable'] = $settings;
	}

	/**
	 * Get settings to be snapshoted
	 *
	 * @return array
	 */
	public function getSnapshotSettings() {
		static $alwaysSnapshot = array( 'wgGroupPermissions', 'wgImplicitGroups', 'wgAutopromote' );
		global $wgConfigureEditableSettings;

		if( count( $wgConfigureEditableSettings ) ) {
			$settings = $wgConfigureEditableSettings;
		} else {
			$settings = array_keys( $this->getEditableSettings() );
		}
		$settings = array_unique( array_merge( $settings, $alwaysSnapshot ) );
		return $settings;
	}

	/**
	 * Get the list of all arrays settings, mapping setting name to its type
	 *
	 * @return array
	 */
	public function getArrayDefs() {
		if ( isset( $this->cache['array'] ) )
			return $this->cache['array'];

		$list = array();
		$this->loadSettingsDefs();

		wfProfileIn( __METHOD__ );

		if ( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$list += $this->arrayDefs;
		}
		if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			foreach ( $this->getAllExtensionsObjects() as $ext ) {
				$list += $ext->getArrayDefs();
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->cache['array'] = $list;
	}

	/**
	 * Get an array of settings which should have specific values when they're
	 * empty
	 *
	 * @return array
	 */
	public function getEmptyValues() {
		if ( isset( $this->cache['empty'] ) )
			return $this->cache['empty'];

		wfProfileIn( __METHOD__ );

		$list = array();
		if ( ( $this->types & CONF_SETTINGS_CORE ) == CONF_SETTINGS_CORE ) {
			$list += $this->emptyValues;
		}
		if ( ( $this->types & CONF_SETTINGS_EXT ) == CONF_SETTINGS_EXT ) {
			foreach ( $this->getAllExtensionsObjects() as $ext ) {
				$list += $ext->getEmptyValues();
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->cache['empty'] = $list;
	}

	/**
	 * Return true if the setting is available in this version of MediaWiki
	 *
	 * @return bool
	 */
	public function isSettingAvailable( $setting ) {
		$this->loadSettingsDefs();
		if ( !array_key_exists( $setting, $this->getAllSettings() ) )
			return false;
		if ( !array_key_exists( $setting, $this->settingsVersion ) )
			return true;
		global $wgVersion;
		foreach ( $this->settingsVersion[$setting] as $test ) {
			list( $ver, $comp ) = $test;
			if ( !version_compare( $wgVersion, $ver, $comp ) )
				return false;
		}
		return true;
	}

	/**
	 * Get the type of a setting
	 *
	 * @param $setting String: setting name
	 * @return mixed
	 */
	public function getSettingType( $setting ) {
		$settings = $this->getAllSettings();
		if ( isset( $settings[$setting] ) )
			return $settings[$setting];
		else
			return false;
	}

	/**
	 * Get the array type of a setting
	 *
	 * @param $setting String: setting name
	 */
	public function getArrayType( $setting ) {
		$arr = $this->getArrayDefs();
		return isset( $arr[$setting] ) ?
			$arr[$setting] : null;
	}
}
