<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that hold the configuration
 *
 * @ingroup Extensions
 */
class WebConfiguration extends SiteConfiguration {
	protected $mHandler = null;        // Configuration handler
	protected $mWiki;                  // Wiki name
	protected $mConf = array();        // Our array of settings
	protected $mOldSettings = null;    // Old settings (before applying our overrides)
	protected $mDefaults = null;       // Default values

	/**
	 * Construct a new object.
	 *
	 * @param string $path path to the directory that contains the configuration
	 *                     files
	 */
	public function __construct( $wiki = 'default' ) {
		$this->mWiki = $wiki;
	}

	/**
	 * Load the configuration from the conf-now.ser file in the $this->mDir
	 * directory
	 */
	public function initialise( $useCache = true ) {
		parent::initialise();

		// Special case for manage.php maintenance script so that it can work
		// even if the current configuration is broken
		if ( defined( 'EXT_CONFIGURE_NO_EXTRACT' ) )
			return;

		$this->mConf = $this->getHandler()->getCurrent( $useCache );

		# Restore first version of $this->settings if called a second time so
		# that it doesn't duplicate arrays
		if( is_null( $this->mOldSettings ) )
			$this->mOldSettings = $this->settings;
		else
			$this->settings = $this->mOldSettings;

		# We'll need to invert the order of keys as SiteConfiguration uses
		# $settings[$setting][$wiki] and the extension uses $settings[$wiki][$setting]
		foreach ( $this->mConf as $site => $settings ) {
			if ( !is_array( $settings ) )
				continue;
			foreach ( $settings as $name => $val ) {
				if ( $name != '__includes' ) {
					# Merge if possible
					if ( isset( $this->settings[$name][$site] ) && is_array( $this->settings[$name][$site] ) && is_array( $val ) ) {
						$this->settings[$name][$site] = self::mergeArrays( $val, $this->settings[$name][$site] );
					}
					elseif ( isset( $this->settings[$name]["+$site"] ) && is_array( $this->settings[$name]["+$site"] ) && is_array( $val ) ) {
						$this->settings[$name]["+$site"] = self::mergeArrays( $val, $this->settings[$name]["+$site"] );
					}
					elseif ( isset( $this->settings["+$name"][$site] ) && is_array( $this->settings["+$name"][$site] ) && is_array( $val ) ) {
						$this->settings["+$name"][$site] = self::mergeArrays( $val, $this->settings["+$name"][$site] );
					}
					elseif ( isset( $this->settings["+$name"]["+$site"] ) && is_array( $this->settings["+$name"]["+$site"] ) && is_array( $val ) ) {
						$this->settings["+$name"]["+$site"] = self::mergeArrays( $val, $this->settings["+$name"]["+$site"] );
					}
					elseif ( isset( $this->settings["+$name"] ) && is_array( $val ) ) {
						$this->settings["+$name"][$site] = $val;
					}
					else {
						$this->settings[$name][$site] = $val;
					}
				}
			}
		}
	}

	public function snapshotDefaults( /* options */ ) {
		// FIXME: don't hardcode all this stuff here
		static $alwaysSnapshot = array( 'wgGroupPermissions', 'wgImplicitGroups', 'wgAutopromote' );
		$options = func_get_args();
		$noOverride = in_array( 'no_override', $options );
		if( !is_array( $this->mDefaults ) || in_array( 'allow_empty', $options ) ) {
			if( !is_array( $this->mDefaults ) ) {
				$this->mDefaults = array();
			}
			$allSettings = ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getEditableSettings();
			$allSettings += array_flip( $alwaysSnapshot );
			foreach( $allSettings as $setting => $type ) {
				if( array_key_exists( $setting, $GLOBALS ) &&
					!( $noOverride && array_key_exists( $setting, $this->mDefaults ) ) )
				{
					$this->mDefaults[$setting] = $GLOBALS[$setting];
				}
			}
		}
	}

	/**
	 * extract settings for this wiki in $GLOBALS
	 */
	public function extract() {
		// Include files before so that customized settings won't be overridden
		// by the default ones
		$this->includeFiles();

		$this->snapshotDefaults( 'allow_empty', 'no_override' );

		list( $site, $lang ) = $this->siteFromDB( $this->mWiki );
		$rewrites = array( 'wiki' => $this->mWiki, 'site' => $site, 'lang' => $lang );
		$this->extractAllGlobals( $this->mWiki, $site, $rewrites );
	}

	public function getIncludedFiles( $wiki = null ) {
		if ( is_null( $wiki ) )
			$wiki = $this->mWiki;
		if ( isset( $this->mConf[$wiki]['__includes'] ) )
			return $this->mConf[$wiki]['__includes'];
		else
			return array();
	}

	/**
	 * Include all extensions files of actived extensions
	 */
	public function includeFiles() {
		$includes = $this->getIncludedFiles();
		if ( !count( $includes ) )
			return;

		// Since the files should be included from the global scope, we'll need
		// to import that variabled in this function
		extract( $GLOBALS, EXTR_REFS );

		foreach ( $includes as $file ) {
			if ( file_exists( $file ) ) {
				require_once( $file );
			} else {
				trigger_error( __METHOD__ . ": required file $file doesn't exist", E_USER_WARNING );
			}
		}
	}

	/**
	 * Get the array representing the current configuration
	 *
	 * @param $wiki String: wiki name
	 * @return array
	 */
	public function getCurrent( $wiki ) {
		list( $site, $lang ) = $this->siteFromDB( $wiki );
		$rewrites = array( 'wiki' => $wiki, 'site' => $site, 'lang' => $lang );
		return $this->getAll( $wiki, $site, $rewrites );
	}

	/**
	 * Get the configuration handler
	 * Used for lasy-loading
	 *
	 * @return ConfigureHandler object
	 */
	public function getHandler() {
		if ( !is_object( $this->mHandler ) ) {
			global $wgConfigureHandler;
			$class = 'ConfigureHandler' . ucfirst( $wgConfigureHandler );
			$this->mHandler = new $class();
		}
		return $this->mHandler;
	}

	/**
	 * Return the old configuration from $ts timestamp
	 * Does *not* return site specific settings but *all* settings
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getOldSettings( $ts ) {
		if ( $ts == 'default' )
			return array( 'default' => $this->getDefaults() );
		return $this->getHandler()->getOldSettings( $ts );
	}

	/**
	 * Returns the wikis in $ts version
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getWikisInVersion( $ts ) {
		return $this->getHandler()->getWikisInVersion( $ts );
	}

	/** Recursive doohicky for normalising variables so we can compare them. */
	public static function filterVar( $var ) {
		if ( empty( $var ) && !$var ) {
			return null;
		}

		if ( is_array( $var ) ) {
			return array_filter( array_map( array( __CLASS__, 'filterVar' ), $var ) );
		}

		return trim( $var );
	}

	/**
	 * Returns a pager for this handler
	 *
	 * @return Pager
	 */
	public function getPager() {
		return $this->getHandler()->getPager();
	}

	/**
	 * Get the default values for all settings
	 * Works by recording any overridden values when extracting globals.
	 *
	 * @return array
	 */
	public function getDefaults() {
		return $this->mDefaults;
	}

	/**
	 * Get the default settings (i.e. before apply Configure's overrides)
	 * Very hacky too...
	 *
	 * @param $wiki String
	 * @return array
	 */
	public function getDefaultsForWiki( $wiki ) {
		## Hack for Wikimedia
		static $initialiseSettingsDone = false;

		if ( !$initialiseSettingsDone ) {
			$initialiseSettingsDone = true;
			global $IP, $wgConf;
			if( file_exists( "$IP/InitialiseSettings.php" ) ) {
				require_once "$IP/InitialiseSettings.php";
				$this->initialise( false );
			}
		}

		// Hmm, a better solution would be nice!
		$savedSettings = $this->settings;
		$this->settings = $this->mOldSettings;
		$globalDefaults = $this->getDefaults();

		$savedGlobals = array();
		foreach ( $this->settings as $name => $val ) {
			if ( substr( $name, 0, 1 ) == '+' ) {
				$setting = substr( $name, 1 );
				if ( isset( $globalDefaults[$setting] ) ) {
					$savedGlobals[$setting] = $GLOBALS[$setting];
					$GLOBALS[$setting] = $globalDefaults[$setting];
				}
			}
		}

		$wikiDefaults = $this->getCurrent( $wiki );

		$this->settings = $savedSettings;
		unset( $savedSettings );
		foreach ( $savedGlobals as $name => $val ) {
			$GLOBALS[$setting] = $savedGlobals[$setting];
		}

		$ret = array();
		$keys = array_unique( array_merge( array_keys( $wikiDefaults ), array_keys( $globalDefaults ) ) );
		foreach ( $keys as $setting ) {
			if ( isset( $wikiDefaults[$setting] ) && !is_null( $wikiDefaults[$setting] ) )
				$ret[$setting] = $wikiDefaults[$setting];
			elseif ( array_key_exists( $setting, $globalDefaults ) )
				$ret[$setting] = $globalDefaults[$setting];
		}
		return $ret;
	}

	/**
	 * Save a new configuration
	 * @param $settings array of settings
	 * @param $wiki String: wiki name or false to use the current one
	 * @return bool true on success
	 */
	public function saveNewSettings( $settings, $wiki = false, $reason = '' ) {
		if ( !is_array( $settings ) )
			# hmmm
			return false;

		if ( $wiki === null ) {
			$this->mConf = $settings;
			$wiki = true;
		} else {
			if ( $wiki === false )
				$wiki = $this->getWiki();
			$this->mConf[$wiki] = $settings;
		}

		return $this->getHandler()->saveNewSettings( $this->mConf, $wiki, false, $reason );
	}

	/**
	 * List all archived versions
	 *
	 * @param $options Array of options
	 * @return array of timestamps
	 */
	public function listArchiveVersions( $options = array() ) {
		return $this->getHandler()->listArchiveVersions( $options );
	}

	/**
	 * Same as listArchiveVersions(), but with more information about each
	 * version
	 *
	 * @param $options Array of options
	 * @return Array of versions
	 */
	public function getArchiveVersions( $options = array() ) {
		return $this->getHandler()->getArchiveVersions( $options );
	}

	/**
	 * Do some checks
	 */
	public function doChecks() {
		return $this->getHandler()->doChecks();
	}

	/**
	 * Get not editable settings with the current handler
	 * @return array
	 */
	public function getUneditableSettings() {
		return $this->getHandler()->getUneditableSettings();
	}

	/**
	 * Return a bool whether the version exists
	 *
	 * @param $ts version
	 * @return bool
	 */
	public function versionExists( $ts ) {
		return $this->getHandler()->versionExists( $ts );
	}

	/**
	 * Get the wiki in use
	 *
	 * @return String
	 */
	public function getWiki() {
		return $this->mWiki;
	}

	/**
	 * Merge array settings
	 * TODO: document!
	 * @return Array
	 */
	public static function mergeArrays( /* $array1, ... */ ) {
		$args = func_get_args();
		$canAdd = true;
		foreach ( $args as $arr ) {
			if ( $arr !== array_values( $arr ) ) {
				$canAdd = false;
				break;
			}
		}

		$out = array_shift( $args );
		foreach ( $args as $arr ) {
			foreach ( $arr as $key => $value ) {
				if ( isset( $out[$key] ) && is_array( $out[$key] ) && is_array( $value ) ) {
					$out[$key] = self::mergeArrays( $out[$key], $value );
				} elseif ( $canAdd ) {
					$out[] = $value;
				} else {
					$out[$key] = $value;
				}
			}
		}
		if ( $canAdd )
			$out = array_unique( $out );
		return $out;
	}
}
