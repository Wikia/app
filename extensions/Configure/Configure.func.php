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
	global $wgConf, $wgConfigureFilesPath, $wgConfigureExtDir, $wgConfigureHandler, $wgConfigureAllowDeferSetup;
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

	if ( $wgConfigureAllowDeferSetup && $wgConfigureHandler == 'db' ) {
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

/**
 * Add JS variable to the output, for use in Configure.js
 */
function efConfigureMakeGlobalVariablesScript( &$vars ) {
	global $wgConfigureAddJsVariables, $wgUseAjax;

	if ( !$wgConfigureAddJsVariables )
		return true;

	$vars['wgConfigureAdd'] = wfMsg( 'configure-js-add' );
	$vars['wgConfigureRemove'] = wfMsg( 'configure-js-remove' );
	$vars['wgConfigureRemoveRow'] = wfMsg( 'configure-js-remove-row' );
	$vars['wgConfigurePromptGroup'] = wfMsg( 'configure-js-prompt-group' );
	$vars['wgConfigureGroupExists'] = wfMsg( 'configure-js-group-exists' );
	$vars['wgConfigureUseAjax'] = (bool)$wgUseAjax;
	$vars['wgConfigureGetImageUrl'] = wfMsg( 'configure-js-get-image-url' );
	$vars['wgConfigureImageError'] = wfMsg( 'configure-js-image-error' );
	$vars['wgConfigureBiglistShown'] = wfMsg( 'configure-js-biglist-shown' );
	$vars['wgConfigureBiglistHidden'] = wfMsg( 'configure-js-biglist-hidden' );
	$vars['wgConfigureBiglistShow'] = wfMsg( 'configure-js-biglist-show' );
	$vars['wgConfigureBiglistHide'] = wfMsg( 'configure-js-biglist-hide' );
	$vars['wgConfigureSummaryNone'] = wfMsg( 'configure-js-summary-none' );
	$vars['wgConfigureThrottleSummary'] = wfMsg( 'configure-throttle-summary' );
	return true;
}

/**
 * Display link to Special:Configure
 */
function efConfigureFarmerAdminPermissions( $farmer ) {
	global $wgOut;

	wfLoadExtensionMessages( 'Configure' );
	$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-basic-permission' );
	$wgOut->addWikiMsg( 'configure-farmer-settings' );

	return false;
}

/**
 * Avoid displaying anything :)
 */
function efConfigureFarmerAdminSkin( $farmer ) {
	return false;	
}

/**
 * Display link to Special:Extensions
 */
function efConfigureFarmerAdminExtensions( $farmer ) {
	global $wgOut;

	$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions' );
	$wgOut->addWikiMsg( 'configure-farmer-extensions' );

	return false;
}

/**
 * Display link to Special:Extensions
 */
function efConfigureFarmerManageExtensions( $farmer ) {
	global $wgOut;

	$wgOut->wrapWikiMsg( '== $1 ==', 'farmer-extensions-available' );
	$wgOut->addWikiMsg( 'configure-farmer-extensions-list' );

	return false;
}

/**
 * Adds links to Configure's special pages to the Special:AdminLinks page,
 * defined by the Admin Links extension
 */
function efConfigureAddToAdminLinks( &$adminLinksTree ) {
	$generalSection = $adminLinksTree->getSection( wfMsg( 'adminlinks_general' ) );
	$configureRow = new ALRow( 'configure' );
	$configureRow->addItem( ALItem::newFromSpecialPage( 'Configure' ) );
	$configureRow->addItem( ALItem::newFromSpecialPage( 'Extensions' ) );
	$configureRow->addItem( ALItem::newFromSpecialPage( 'ViewConfig' ) );
	$generalSection->addRow( $configureRow );
	return true;
}
