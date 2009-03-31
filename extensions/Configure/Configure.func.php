<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Functions for Configure extension
 *
 * @file
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 * @ingroup Extensions
 */

/**
 * Ajax function to create row for a new group in $wgGroupPermissions or
 * $wgAutopromote
 *
 * @param $setting String: setting name
 * @param $group String: new group name
 * @return either <err#> on error or html fragment
 */
function efConfigureAjax( $setting, $group ) {
	global $wgUser;

	$settings = ConfigurationSettings::singleton( CONF_SETTINGS_BOTH );
	if ( $settings->getSettingType( $setting ) != 'array' )
		return '<err#>';

	wfLoadExtensionMessages( 'Configure' );
	$type = $settings->getArrayType( $setting );
	switch( $type ) {
	case 'group-bool':
		if ( isset( $GLOBALS[$setting] ) && isset( $GLOBALS[$setting][$group] ) )
			return '<err#>';

		$row = ConfigurationPage::buildGroupSettingRow( $setting, $type, User::getAllRights(), true, $group, array() );

		// Firefox seems to not like that :(
		return str_replace( '&nbsp;', ' ', $row );
	case 'promotion-conds':
		if ( isset( $GLOBALS[$setting] ) && isset( $GLOBALS[$setting][$group] ) )
			return '<err#>';

		return ConfigurationPage::buildPromotionCondsSettingRow( $setting, true, $group, array() );
	default:
		return '<err#>';
	}
}

/**
 * Initalize the settings stored in a serialized file.
 * This have to be done before the end of LocalSettings.php but is in a function
 * because administrators might configure some settings between the moment where
 * the file is loaded and the execution of these function.
 * Settings are not filled only if they doesn't exists because of a security
 * hole if the register_globals feature of PHP is enabled.
 *
 * @param $wiki String
 */
function efConfigureSetup( $wiki = 'default' ) {
	global $wgConf, $wgConfigureFilesPath, $wgConfigureExtDir;
	wfProfileIn( __FUNCTION__ );
	# Create the new configuration object...
	$oldConf = $wgConf;
	require_once( dirname( __FILE__ ) . '/Configure.obj.php' );
	$wgConf = new WebConfiguration( $wiki, $wgConfigureFilesPath );

	# Copy the existing settings...
	$wgConf->suffixes = $oldConf->suffixes;
	$wgConf->wikis = $oldConf->wikis;
	$wgConf->settings = $oldConf->settings;
	$wgConf->localVHosts = $oldConf->localVHosts;
	$wgConf->siteParamsCallback = $oldConf->siteParamsCallback;

	$wgConf->snapshotDefaults();

	global $wgConfigureHandler;
	if ( $wgConfigureHandler == 'db' ) {
		// Defer to after caches and database are set up.
		global $wgHooks;
		$wgHooks['SetupAfterCache'][] = array( 'efConfigureInitialise' );
	} else {
		efConfigureInitialise();
	}
	# Cleanup $wgConfigureExtDir as needed
	if( substr( $wgConfigureExtDir, -1 ) != '/' && substr( $wgConfigureExtDir, -1 ) != '\\' ) {
		$wgConfigureExtDir .= '/';
	}
	wfProfileOut( __FUNCTION__ );
}

function efConfigureInitialise() {
	global $wgConf;
	# Load the new configuration, and fill in the settings
	$wgConf->initialise();
	$wgConf->extract();
	return true;
}

/**
 * Declare the API module only if $wgConfigureAPI is true
 */
function efConfigureSetupAPI() {
	global $wgConfigureAPI, $wgAPIModules;
	if ( $wgConfigureAPI === true ) {
		$wgAPIModules['configure'] = 'ApiConfigure';
	}
}

/**
 * Add custom rights defined in $wgRestrictionLevels
 */
function efConfigureGetAllRights( &$rights ) {
	global $wgRestrictionLevels;
	$newrights = array_diff( $wgRestrictionLevels, array( '', 'sysop' ) ); // Pseudo rights
	$rights = array_unique( array_merge( $rights, $newrights ) );
	return true;
}
