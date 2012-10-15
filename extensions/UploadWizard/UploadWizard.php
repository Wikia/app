<?php
/**
 * UploadWizard extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for UploadWizard
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UploadWizard/UploadWizard.php" );
 *
 * @author Neil Kandalgaonkar <neil@wikimedia.org>
 * @license GPL v2 or later
 * @version 1.1
 */

/* Configuration */


// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Upload Wizard',
	'author' => 'Neil Kandalgaonkar',
	'version' => '1.2 alpha',
	'descriptionmsg' => 'uploadwizard-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UploadWizard'
);

$wgUpwizDir = dirname( __FILE__ );

$wgExtensionMessagesFiles['UploadWizard'] = $wgUpwizDir . '/UploadWizard.i18n.php';
$wgExtensionMessagesFiles['UploadWizardAlias'] = $wgUpwizDir . '/UploadWizard.alias.php';

# Require modules, including the special page
foreach ( array(
		'UploadWizardMessages' => $wgUpwizDir,
		'UploadWizardHooks' => $wgUpwizDir,
		'ApiDeleteUploadCampaign' => $wgUpwizDir . '/api',
		'UploadWizardConfig' => $wgUpwizDir . '/includes',
		'UploadWizardTutorial' => $wgUpwizDir . '/includes',
		'UploadWizardCampaign' => $wgUpwizDir . '/includes',
		'SpecialUploadWizard' => $wgUpwizDir . '/includes/specials',
		'SpecialUploadCampaigns' => $wgUpwizDir . '/includes/specials',
		'SpecialUploadCampaign' => $wgUpwizDir . '/includes/specials',
		) as $module => $dir ) {
	$wgAutoloadClasses[$module] = $dir . '/' . $module . '.php';
}

// $wgAPIModules['titlecheck'] = 'ApiTitleCheck';
// $wgAPIListModules['titlecheck'] = 'ApiTitleCheck';

# Let the special page be a special center of unique specialness
$wgSpecialPages['UploadWizard'] = 'SpecialUploadWizard';
$wgSpecialPageGroups['UploadWizard'] = 'media';

$wgSpecialPages['UploadCampaigns'] = 'SpecialUploadCampaigns';
$wgSpecialPageGroups['UploadCampaigns'] = 'media';

$wgSpecialPages['UploadCampaign'] = 'SpecialUploadCampaign';
$wgSpecialPageGroups['UploadCampaign'] = 'media';

$wgAPIModules['deleteuploadcampaign'] = 'ApiDeleteUploadCampaign';

// Disable ResourceLoader support by default, it's currently broken
// $wgUploadWizardDisableResourceLoader = true;

// for ResourceLoader
$wgHooks['ResourceLoaderRegisterModules'][] = 'UploadWizardHooks::resourceLoaderRegisterModules';
$wgHooks['CanonicalNamespaces'][] = 'UploadWizardHooks::canonicalNamespaces';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'UploadWizardHooks::onSchemaUpdate';
$wgHooks['GetPreferences'][] = 'UploadWizardHooks::onGetPreferences';

$wgAvailableRights[] = 'upwizcampaigns';

# Users that can modify the upload campaigns (ie via Special:UploadCampaigns)
$wgGroupPermissions['*'               ]['upwizcampaigns'] = false;
$wgGroupPermissions['user'            ]['upwizcampaigns'] = false;
$wgGroupPermissions['autoconfirmed'   ]['upwizcampaigns'] = false;
$wgGroupPermissions['bot'             ]['upwizcampaigns'] = false;
$wgGroupPermissions['sysop'           ]['upwizcampaigns'] = true;
$wgGroupPermissions['upwizcampeditors']['upwizcampaigns'] = true;

$wgAddGroups['sysop'][] = 'upwizcampeditors';
$wgRemoveGroups['sysop'][] = 'upwizcampeditors';

$wgDefaultUserOptions['upwiz_deflicense'] = 'default';
$wgDefaultUserOptions['upwiz_def3rdparty'] = 'default';
$wgDefaultUserOptions['upwiz_deflicensetype'] = 'default';

// Init the upload wizard config array
// UploadWizard.config.php includes default configuration
// any value can be modified in localSettings.php by setting  $wgUploadWizardConfig['name'] = 'value;
$wgUploadWizardConfig = array();
