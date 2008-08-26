<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

# The autoloader is loaded after LocalSettings.php, so we'll need to load
# that file manually
if( !class_exists( 'SiteConfiguration' ) )
	require_once( "$IP/includes/SiteConfiguration.php" );

/**
 * Class that hold the configuration
 *
 * @ingroup Extensions
 */
class WebConfiguration extends SiteConfiguration {
	protected $mDir;            // Directory of files, *with* leading /
	protected $mWiki;           // Wiki name
	protected $mConf = array(); // Our array of settings

	/**
	 * Construct a new object.
	 *
	 * @param string $path path to the directory that contains the configuration
	 *                     files
	 */
	public function __construct( $wiki = 'default', $path = null ){
		if( $path === null ){
			global $IP;
			$path = "$IP/serialized/";
		} else if( substr( $path, -1 ) != '/' && substr( $path, -1 ) != '\\' ) {
			$path .= '/';
		}
		$this->mDir = $path;
		$this->mWiki = $wiki;
	}

	/**
	 * Load the configuration from the conf-now.ser file in the $this->mDir
	 * directory
	 */
	public function initialise(){
		$file = $this->getFileName();
		if( !file_exists( $file ) )
			# maybe the first time the user use this extensions, do not override
			# anything
			return;
		$cont = file_get_contents( $file );
		if( empty( $cont ) )
			# Weird, should not happen
			return;
		$arr = unserialize( $cont );
		if( !is_array( $arr ) || $arr === array() )
			# Weird, should not happen too
			return;
		$this->mConf = $arr;

		# We'll need to invert the order of keys as SiteConfiguration use
		# $settings[$setting][$wiki] and the extension use $settings[$wiki][$setting]
		foreach( $this->mConf as $site => $settings ){
			if( !is_array( $settings ) )
				continue;
			foreach( $settings as $name => $val ){
				if( $name != '__includes' )
					$this->settings[$name][$site] = $val;
			}
		}
	}

	/**
	 * Save a new configuration
	 * @param $settings array of settings
	 * @param $wiki String: wiki name or false to use the current one
	 * @return bool true on success
	 */
	public function saveNewSettings( $settings, $wiki = false ){
		if( !is_array( $settings ) || $settings === array() )
			# hmmm
			return false;

		if( $wiki === null ){
			$this->mConf = $settings;
		} else {
			if( $wiki === false )
				$wiki = $this->mWiki;
			if( isset( $this->mConf[$wiki] ) && is_array( $this->mConf[$wiki] ) )
				$settings += $this->mConf[$wiki];
			$this->mConf[$wiki] = $settings;
		}

		$arch = $this->getArchiveFileName();
		$cur = $this->getFileName();
		$cont = serialize( $this->mConf );
		file_put_contents( $arch, $cont );
		return ( file_put_contents( $cur, $cont ) !== false );
	}

	/**
	 * extract settings for this wiki in $GLOBALS
	 */
	public function extract(){
		// Special case for manage.php maintenance script so that it can work
		// even the current configuration is broken
		if( defined( 'EXT_CONFIGURE_NO_EXTRACT' ) )
			return;

		// Include files before so that customized settings won't be overriden
		// by the default ones
		$this->includeFiles();

		list( $site, $lang ) = $this->siteFromDB( $this->mWiki );
		$rewrites = array( 'wiki' => $this->mWiki, 'site' => $site, 'lang' => $lang );
		$this->extractAllGlobals( $this->mWiki, $site, $rewrites );
	}

	/**
	 * Get the array representing the current configuration
	 *
	 * @param $wiki String: wiki name
	 * @return array
	 */
	public function getCurrent( $wiki ){
		if( !empty( $this->conf[$wiki] ) )
			return $this->conf[$wiki];

		list( $site, $lang ) = $this->siteFromDB( $wiki );
		$rewrites = array( 'wiki' => $wiki, 'site' => $site, 'lang' => $lang );
		return $this->getAll( $wiki, $site, $rewrites );
	}

	public function getIncludedFiles(){
		if( isset( $this->mConf[$this->mWiki]['__includes'] ) )
			return $this->mConf[$this->mWiki]['__includes'];
		else
			return array();
	}

	/**
	 * Include all extensions files of actived extensions
	 */
	public function includeFiles(){
		// Since the files should be included from the global scope, we'll need
		// to import that variabled in this function
		extract( $GLOBALS, EXTR_REFS );

		$includes = $this->getIncludedFiles();
		foreach( $includes as $file ){
			if( file_exists( $file ) ){
				require_once( $file );
			} else {
				trigger_error( __METHOD__ . ": required file $file doesn't exist", E_USER_WARNING );
			}
		}
	}

	/**
	 * Get the current file name
	 * @return String full path to the file
	 */
	protected function getFileName(){
		return "{$this->mDir}conf-now.ser";
	}

	/**
	 * Get the an archive file
	 * @param $ts String: 14 char timestamp (YYYYMMDDHHMMSS) or null to use the
	 *            current timestamp
	 * @return String full path to the file
	 */
	public function getArchiveFileName( $ts = null ){
		global $IP;

		if( $ts === null )
			$ts = wfTimestampNow();

		$file = "{$this->mDir}conf-$ts.ser";
		return $file;
	}

	/**
	 * List all archived files that are like conf-{$ts}.ser
	 * @return array of timestamps
	 */
	public function listArchiveFiles(){
		if( !$dir = opendir( $this->mDir ) )
			return array();
		$files = array();
		while( ( $file = readdir( $dir ) ) !== false ) {
			if( preg_match( '/conf-(\d{14}).ser$/', $file, $m ) )
				$files[] = $m[1];
		}
		return $files;
	}

	/**
	 * Return the configuration from the conf-{$ts}.ser file in the $this->mDir
	 * Does *not* return site specific settings but *all* settings
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getOldSettings( $ts ){
		$file = $this->getArchiveFileName( $ts );
		if( !file_exists( $file ) )
			# maybe the time the user use this extensions, do not override
			# anything
			return array();
		$cont = file_get_contents( $file );
		if( empty( $cont ) )
			# Weird, should not happen
			return array();
		$arr = unserialize( $cont );
		if( !is_array( $arr ) )
			# Weird, should not happen too
			return array();
		return $arr;
	}

	/**
	 * Get the directory used to store the files
	 *
	 * @return String
	 */
	public function getDir(){
		return $this->mDir;
	}
	
	/**
	 * Get the wiki in use
	 *
	 * @return String
	 */
	public function getWiki(){
		return $this->mWiki;
	}
}
