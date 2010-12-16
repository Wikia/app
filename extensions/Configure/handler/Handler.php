<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Interface for configuration handler
 *
 * @ingroup Extensions
 */
interface ConfigureHandler {

	/**
	 * Construct a new object.
	 */
	public function __construct();

	/**
	 * Load the current configuration
	 */
	public function getCurrent( $useCache = true );

	/**
	 * Return the old configuration from $ts timestamp
	 * Does *not* return site specific settings but *all* settings
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getOldSettings( $ts );

	/**
	 * Returns the wikis in $ts version
	 *
	 * @param $ts timestamp
	 * @return array
	 */
	public function getWikisInVersion( $ts );

	/**
	 * Returns a pager for this handler
	 *
	 * @return Pager
	 */
	public function getPager();

	/**
	 * Save a new configuration
	 *
	 * @param $settings array of settings
	 * @param $wiki String: wiki name or true for all
	 * @param $ts 14 chars timestamps
	 * @param $reason String: Reason, as given by the user.
	 * @return bool true on success
	 */
	public function saveNewSettings( $settings, $wiki, $ts = false, $reason = '' );

	/**
	 * List all archived versions
	 *
	 * @param $options Array of options
	 * @return array of timestamps
	 */
	public function getArchiveVersions( $options = array() );

	/**
	 * Same as listArchiveVersions(), but with more information about each
	 * version
	 *
	 * @param $options Array of options
	 * @return Array of versions
	 */
	public function listArchiveVersions( $options = array() );

	/**
	 * Return a bool whether the version exists
	 *
	 * @param $ts version
	 * @return bool
	 */
	public function versionExists( $ts );

	/**
	 * Do some checks
	 * @return array
	 */
	public function doChecks();

	/**
	 * Get settings that are not editable with this handler
	 * @return array
	 */
	public function getUneditableSettings();
}
