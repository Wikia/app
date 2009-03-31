<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that hold the configuration
 *
 * @ingroup Extensions
 */
class ConfigureHandlerFiles implements ConfigureHandler {
	protected $mDir; // Directory of files, *with* leading /

	/**
	 * Construct a new object.
	 */
	public function __construct() {
		global $wgConfigureFilesPath;
		if ( $wgConfigureFilesPath === null ) {
			global $IP;
			$wgConfigureFilesPath = "$IP/serialized/";
		} else if ( substr( $wgConfigureFilesPath, -1 ) != '/' && substr( $wgConfigureFilesPath, -1 ) != '\\' ) {
			$wgConfigureFilesPath .= '/';
		}
		$this->mDir = $wgConfigureFilesPath;
	}

	/**
	 * Load the configuration from the conf-now.ser file in the $this->mDir
	 * directory
	 */
	public function getCurrent( $useCache = true ) {
		$file = $this->getFileName();
		if ( !file_exists( $file ) )
			# maybe the first time the user use this extensions, do not override
			# anything
			return array();
		require( $file );
		if ( !is_array( $settings ) )
			# Weird, should not happen too
			return array();
		return $settings;
	}

	/**
	 * Return the configuration from the conf-{$ts}.ser file in the $this->mDir
	 * Does *not* return site specific settings but *all* settings
	 * FIXME: timestamp is not unique
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getOldSettings( $ts ) {
		$file = $this->getArchiveFileName( $ts );
		if ( !file_exists( $file ) )
			# maybe the time the user use this extensions, do not override
			# anything
			return array();
		require( $file );
		if ( !is_array( $settings ) )
			# Weird, should not happen too
			return array();

		if ( isset( $settings['__metadata'] ) )
			unset( $settings['__metadata'] );

		return $settings;
	}

	/**
	 * Returns the wikis in $ts version
	 * FIXME: timestamp is not unique
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getWikisInVersion( $ts ) {
		$settings = $this->getOldSettings( $ts );
		return array_keys( $settings );
	}

	/**
	 * Returns a pager for this handler
	 *
	 * @return Pager
	 */
	public function getPager() {
		return new ConfigurationPagerFiles( $this );
	}

	/**
	 * Save a new configuration
	 * @param $settings array of settings
	 * @param $wiki String: wiki name or true for all
	 * @return bool true on success
	 */
	public function saveNewSettings( $settings, $wiki, $ts = false, $reason = '' ) {
		global $wgUser;

		$arch = $this->getArchiveFileName();
		$cur = $this->getFileName();

		## Add meta-data
		$settings['__metadata'] = array(
			'user_wiki' => wfWikiID(),
			'user_name' => $wgUser->getName(),
			'reason' => $reason
		);

		$cont = '<?php $settings = '.var_export( $settings, true ).";";
		@file_put_contents( $arch, $cont );
		return ( @file_put_contents( $cur, $cont ) !== false );
	}

	/**
	 * List all archived files that are like conf-{$ts}.php
	 * @return array of timestamps
	 */
	public function getArchiveVersions( $options = array() ) {
		if ( !$dir = opendir( $this->mDir ) )
			return array();
		$files = array();

		while ( ( $file = readdir( $dir ) ) !== false ) {
			if ( preg_match( '/^conf-(\d{14})\.php$/', $file, $m ) ) {
				## Read the data.
				require( $this->mDir."/$file" );

				if( isset( $options['wiki'] ) && !isset( $settings[$options['wiki']] ) )
					continue;

				if ( isset( $settings['__metadata'] ) ) {
					$metadata = $settings['__metadata'];

					$files[$m[1]] = array( 'username' => $metadata['user_name'],
						'userwiki' => $metadata['user_wiki'], 'reason' => $metadata['reason'], 'timestamp' => $m[1] );
				} else {
					$files[$m[1]] = array( 'username' => false, 'userwiki' => false, 'reason' => false, 'timestamp' => $m[1] );
				}
			}
		}
		krsort( $files, SORT_NUMERIC );
		if( isset( $options['limit'] ) && count( $files ) > $options['limit'] )
			$files = array_slice( $files, 0, $options['limit'] );

		return $files;
	}

	/**
	 * Same as listArchiveVersions(), but with more information about each
	 * version
	 *
	 * @param $options Array of options
	 * @return Array of versions
	 */
	public function listArchiveVersions( $options = array() ) {
		return array_keys( $this->getArchiveVersions( $options ) );
	}

	/**
	 * Return a bool whether the version exists
	 *
	 * @param $ts version
	 * @return bool
	 */
	public function versionExists( $ts ) {
		return file_exists( $this->getArchiveFileName( $ts ) );
	}

	/**
	 * Do some checks
	 */
	public function doChecks() {
		// Check that the directory exists...
		if ( !is_dir( $this->getDir() ) ) {
			return array( 'configure-no-directory', $this->getDir() );
		}

		// And that it's writable by PHP
		if ( !is_writable( $this->getDir() ) ) {
			return array( 'configure-directory-not-writable', $this->getDir() );
		}

		return array();
	}

	/**
	 * All settings are editable!
	 */
	public function getUneditableSettings() {
		return array();
	}

	/**
	 * Get the current file name
	 * @return String full path to the file
	 */
	protected function getFileName() {
		return "{$this->mDir}conf-now.php";
	}

	/**
	 * Get the an archive file
	 * @param $ts String: 14 char timestamp (YYYYMMDDHHMMSS) or null to use the
	 *            current timestamp
	 * @return String full path to the file
	 */
	public function getArchiveFileName( $ts = null ) {
		$ts_orig = $ts;

		if ( $ts === null )
			$ts = wfTimestampNow();

		$file = "{$this->mDir}conf-$ts.php";

		## Hack hack hack
		## Basically, if the file already exists, pretend that the setting change was made in a second's time.
		if ( $ts_orig === null && file_exists( $file ) )
			return $this->getArchiveFileName( $ts+1 );

		return $file;
	}

	/**
	 * Get the directory used to store the files
	 *
	 * @return String
	 */
	public function getDir() {
		return $this->mDir;
	}
}
