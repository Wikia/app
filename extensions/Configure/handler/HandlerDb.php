<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Class that hold the configuration
 *
 * @ingroup Extensions
 */
class ConfigureHandlerDb implements ConfigureHandler {
	protected $mDb; // Database name

	/**
	 * Construct a new object.
	 */
	public function __construct() {
		global $IP, $wgConfigureDatabase;
		require_once( "$IP/includes/GlobalFunctions.php" );
		require_once( "$IP/includes/ObjectCache.php" );
		$this->mDb = $wgConfigureDatabase;
	}

	/**
	 * Get a slave DB connection, used for reads
	 * @return Database object
	 */
	public function getSlaveDB() {
		return wfGetDB( DB_SLAVE, 'config', $this->mDb );
	}

	/**
	 * Get a master DB connection, used for writes
	 * @return Database object
	 */
	public function getMasterDB() {
		return wfGetDB( DB_MASTER, 'config', $this->mDb );
	}

	/**
	 * Get cache key
	 */
	protected function cacheKey( /* ... */ ) {
		$args = func_get_args();
		$args = array_merge( wfSplitWikiID( $this->mDb ), $args );
		return call_user_func_array( 'wfForeignMemcKey', $args );
	}

	/**
	 * Returns a cache object
	 */
	protected function getCache() {
		return wfGetMainCache();
	}

	/**
	 * Checks if it's cached on the filesystem.
	 */
	protected function getFSCached() {
		global $wgConfigureFileSystemCache, $wgConfigureFileSystemCacheExpiry;

		$expiry = $wgConfigureFileSystemCacheExpiry;

		if ( !( $path = $wgConfigureFileSystemCache ) )
			return null;

		if ( !file_exists( $path ) )
			return null;

		$mtime = filemtime( $path );

		if ( time() > ( $mtime + $expiry ) ) # Regenerate every five minutes or so
			return null;

		# Suppress errors, if there's an error, it'll just be null and we'll do it again.
		$data = @unserialize( file_get_contents( $path ) );

		return $data;
	}

	/**
	 * Cache the data to the filesystem.
	 * @returns int bytes
	 */
	protected function cacheToFS( $data ) {
		global $wgConfigureFileSystemCache;

		return @file_put_contents( $wgConfigureFileSystemCache, serialize( $data ) );
	}

	/**
	 * Load the current configuration the database (i.e. cv_is_latest == 1)
	 * directory
	 */
	public function getCurrent( $useCache = true ) {
		static $ipCached = null;

		if ( $ipCached && $useCache ) # In-process caching...
			return $ipCached;

		# Check filesystem cache
		if ( $useCache && ( $cached = $this->getFSCached() ) ) {
			return $ipCached = $cached;
		}

		$cacheKey = $this->cacheKey( 'configure', 'current' );
		$cached = $this->getCache()->get( $cacheKey );
		if ( is_array( $cached ) && $useCache ) {
			$this->cacheToFS( $cached );
			return $ipCached = $cached;
		}

		try {
			$dbr = $this->getSlaveDB();
			$ret = $dbr->select(
				array( 'config_setting', 'config_version' ),
				array( 'cs_name', 'cv_wiki', 'cs_value' ),
				array( 'cv_is_latest' => 1 ),
				__METHOD__,
				array(),
				array( 'config_version' => array( 'LEFT JOIN', 'cs_id = cv_id' ) )
			);
			$arr = array();
			foreach ( $ret as $row ) {
				$arr[$row->cv_wiki][$row->cs_name] = unserialize( $row->cs_value );
			}
			$this->getCache()->set( $cacheKey, $arr, 3600 );
			$this->cacheToFS( $arr );

			return $ipCached = $arr;
		} catch ( MWException $e ) {
			return array();
		}
	}

	/**
	 * Return the old configuration from $ts
	 * Does *not* return site specific settings but *all* settings
	 * FIXME: timestamp is not unique
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getOldSettings( $ts ) {
		$dbr = $this->getSlaveDB();
		$ret = $dbr->select(
			array( 'config_setting', 'config_version' ),
			array( 'cs_name', 'cv_wiki', 'cs_value' ),
			array( 'cv_timestamp' => $dbr->timestamp( $ts ) ),
			__METHOD__,
			array(),
			array( 'config_version' => array( 'LEFT JOIN', 'cs_id = cv_id' ) )
		);
		$arr = array();
		foreach ( $ret as $row ) {
			$arr[$row->cv_wiki][$row->cs_name] = unserialize( $row->cs_value );
		}
		return $arr;
	}

	/**
	 * Returns the wikis in $ts version
	 * FIXME: only returns the first match
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getWikisInVersion( $ts ) {
		$dbr = $this->getSlaveDB();
		$wiki = $dbr->selectField( 'config_version', 'cv_wiki', array( 'cv_timestamp' => $dbr->timestamp( $ts ) ), __METHOD__ );
		if ( $wiki === false )
			return array();
		return array( $wiki );
	}

	/**
	 * Returns a pager for this handler
	 *
	 * @return Pager
	 */
	public function getPager() {
		return new ConfigurationPagerDb( $this );
	}

	/**
	 * Save a new configuration
	 *
	 * @param $settings array of settings
	 * @param $wiki String: wiki name or true for all
	 * @param $ts 14 chars timestamps
	 * @param $reason String: Reason, as given by the user.
	 * @return bool true on success
	 */
	public function saveNewSettings( $settings, $wiki, $ts = false, $reason = '' ) {
		if ( $wiki === true ) {
			foreach ( $settings as $name => $val ) {
				$this->saveSettingsForWiki( $val, $name, $ts, $reason );
			}
		} else {
			if ( !isset( $settings[$wiki] ) )
				return false;
			$this->saveSettingsForWiki( $settings[$wiki], $wiki, $ts, $reason );
		}
		$this->getCache()->delete( $this->cacheKey( 'configure', 'current' ) );
		return true;
	}

	/**
	 * save the configuration for $wiki
	 */
	protected function saveSettingsForWiki( $settings, $wiki, $ts, $reason = '' ) {
		global $wgUser;

		$dbw = $this->getMasterDB();
		if ( !$ts )
			$ts = wfTimestampNow();

		## Look for dupes
		if ($this->versionExists( $ts ))
			$this->saveSettingsForWiki( $settings, $wiki, $ts+1, $reason );

		$dbw->begin();
		$newId = $dbw->nextSequenceValue( 'config_version_cv_id_seq' );
		$dbw->insert( 'config_version',
			array(
				'cv_id' => $newId,
				'cv_wiki' => $wiki,
				'cv_timestamp' => $dbw->timestamp( $ts ),
				'cv_is_latest' => 1,
				'cv_user_text' => $wgUser->getName(),
				'cv_user_wiki' => wfWikiId(),
				'cv_reason' => $reason
			),
			__METHOD__
		);
		$newId = $dbw->insertId();
		$dbw->update( 'config_version',
			array( 'cv_is_latest' => 0 ),
			array( 'cv_wiki' => $wiki, "cv_id != {$newId}" ),
			__METHOD__ );
		$insert = array();
		foreach ( $settings as $name => $val ) {
			$insert[] = array(
				'cs_id' => $newId,
				'cs_name' => $name,
				'cs_value' => serialize( $val ),
			);
		}
		$dbw->insert( 'config_setting', $insert, __METHOD__ );
		$dbw->commit();
		return true;
	}

	/**
	 * List all archived versions, with detailled information
	 * FIXME: serious O(n) overhead
	 * @return array of timestamps
	 */
	public function getArchiveVersions( $options = array() ) {
		$dbOpts = array( 'ORDER BY' => 'cv_timestamp DESC' );
		$where = array();

		if ( isset( $options['limit'] ) )
			$dbOpts['LIMIT'] = $options['limit'];
		if ( isset( $options['wiki'] ) )
			$where['cv_wiki'] = $options['wiki'];

		$dbr = $this->getSlaveDB();
		$ret = $dbr->select(
			array( 'config_version' ),
			array( 'cv_timestamp', 'cv_user_text', 'cv_user_wiki', 'cv_reason' ),
			$where,
			__METHOD__,
			$dbOpts
		);
		$arr = array();
		foreach ( $ret as $row ) {
			$timestamp = wfTimestamp( TS_MW, $row->cv_timestamp );
			$arr[$timestamp] = array(
				'username' => $row->cv_user_text,
				'userwiki' => $row->cv_user_wiki,
				'reason' => $row->cv_reason,
				'timestamp' => $timestamp,
			);
		}
		return $arr;
	}

	/**
	 * Same as getArchiveVersions(), but only get a list of timestamps
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
		$dbr = $this->getSlaveDB();
		return (bool)$dbr->selectField( 'config_version', '1', array( 'cv_timestamp' => $dbr->timestamp( $ts ) ), __METHOD__ );
	}

	/**
	 * Do some checks
	 */
	public function doChecks() {
		try {
			$dbw = $this->getMasterDB();
		} catch ( MWException $e ) {
			return array( 'configure-db-error', $this->mDb );
		}
		if ( !$dbw->tableExists( 'config_version' ) )
			return array( 'configure-db-table-error' );
		return array();
	}

	/**
	 * Get settings that are not editable with the database handler
	 */
	public function getUneditableSettings() {
		global $wgConfigureAllowDeferSetup;

		$uneditable = array(
		# Database
			'wgAllDBsAreLocalhost',
			'wgCheckDBSchema',
			'wgDBAvgStatusPoll',
			'wgDBerrorLog',
			'wgDBname',
			'wgDBpassword',
			'wgDBport',
			'wgDBserver',
			'wgDBtype',
			'wgDBuser',
			'wgLegacySchemaConversion',
			'wgSharedDB',
			'wgSharedPrefix',
			'wgSharedTables',
			'wgDBClusterTimeout',
			'wgDBservers',
			'wgLBFactoryConf',
			'wgMasterWaitTimeout',
			'wgDBmysql5',
			'wgDBprefix',
			'wgDBTableOptions',
			'wgDBtransactions',
			'wgDBmwschema',
			'wgDBts2schema',
			'wgSQLiteDataDir',
		# Memcached
			'wgMainCacheType',
			'wgMemCachedDebug',
			'wgMemCachedPersistent',
			'wgMemCachedServers',
		);

		if ( $wgConfigureAllowDeferSetup ) {
			// These settings are backward compatible settings which are used
			// in Setup.php before the SetupAfterCache hook is called
			$uneditable = array_merge( $uneditable, array(
			# Uploads
				'wgUseSharedUploads',
				'wgUploadDirectory',
				'wgUploadBaseUrl',
				'wgUploadPath',
				'wgHashedUploadDirectory',
				'wgThumbnailScriptPath',
				'wgGenerateThumbnailOnParse',
				'wgSharedUploadDirectory',
				'wgSharedUploadPath',
				'wgHashedSharedUploadDirectory',
				'wgSharedThumbnailScriptPath',
				'wgSharedUploadDBname',
				'wgSharedUploadDBprefix',
				'wgCacheSharedUploads',
				'wgRepositoryBaseUrl',
				'wgFetchCommonsDescriptions',
			# Recent changes
				'wgRCFilterByAge',
			# Skins
				'wgSkipSkin',
			# Cache
				'wgParserCacheType',
				'wgMessageCacheType',
			) );
		}

		return $uneditable;
	}
}
