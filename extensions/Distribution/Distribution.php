<?php

/**
 * Initialization file for the Distribution extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Distribution
 *
 * @file Distribution.php
 * @ingroup Distribution
 *
 * @author Jeroen De Dauw
 * @author Chad Horohoe
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Distribution_VERSION', '0.1 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Distribution',
	'version' => Distribution_VERSION,
	'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]', 'Chad Horohoe' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Distribution',
	'descriptionmsg' => 'distribution-desc',
);

include_once 'Distribution_Settings.php';


// Register the internationalization and aliasing files.
$wgExtensionMessagesFiles['Distribution'] = dirname( __FILE__ ) . '/Distribution.i18n.php';
$wgExtensionMessagesFiles['DistributionAlias'] = dirname( __FILE__ ) . '/Distribution.alias.php';

// Load classes.
$wgAutoloadClasses['DistributionRelease'] = dirname( __FILE__ ) . '/includes/DistributionRelease.php';
$wgAutoloadClasses['ExtensionDataImporter'] = dirname( __FILE__ ) . '/includes/ExtensionDataImporter.php';
$wgAutoloadClasses['ReleaseRepo'] = dirname( __FILE__ ) . '/includes/ReleaseRepo.php';
// $wgAutoloadClasses['Release'] = dirname( __FILE__ ) . '/includes/Release.php';
$wgAutoloadClasses['MediaWikiRelease'] = dirname( __FILE__ ) . '/includes/Release.php';

// Special pages.
$wgAutoloadClasses['SpecialDownloadMediaWiki'] = dirname( __FILE__ ) . '/specials/SpecialDownloadMediawiki.php';
$wgSpecialPages['DownloadMediaWiki'] = 'SpecialDownloadMediaWiki';

$wgAutoloadClasses['SpecialReleaseManager'] = dirname( __FILE__ ) . '/specials/SpecialReleaseManager.php';
$wgSpecialPages['ReleaseManager'] = 'SpecialReleaseManager';

// API modules registration.
$wgAutoloadClasses['ApiMWReleases'] = dirname( __FILE__ ) . '/api/ApiMWReleases.php';
$wgAPIModules['mwreleases'] = 'ApiMWReleases';

$wgAutoloadClasses['ApiQueryExtensions'] = dirname( __FILE__ ) . '/api/ApiQueryExtensions.php';
$wgAPIListModules['extensions'] = 'ApiQueryExtensions';

$wgAutoloadClasses['ApiQueryPackages'] = dirname( __FILE__ ) . '/api/ApiQueryPackages.php';
$wgAPIModules['packages'] = 'ApiQueryPackages';

$wgAutoloadClasses['ApiExtensionVersions'] = dirname( __FILE__ ) . '/api/ApiExtensionVersions.php';
$wgAPIModules['extensionversions'] = 'ApiExtensionVersions';

$wgAutoloadClasses['ApiUpdates'] = dirname( __FILE__ ) . '/api/ApiUpdates.php';
$wgAPIModules['updates'] = 'ApiUpdates';

// Hook registration.
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efDistributionSchemaUpdate';

/**
 * LoadExtensionSchemaUpdates hook.
 *
 * @since 0.1
 *
 * @return true
 */
function efDistributionSchemaUpdate( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array(
			'distribution_packages', dirname( __FILE__ ) . '/distribution.sql'
		);
		$wgExtNewTables[] = array(
			'distribution_units', dirname( __FILE__ ) . '/distribution.sql'
		);
		$wgExtNewTables[] = array(
			'distribution_unit_versions', dirname( __FILE__ ) . '/distribution.sql'
		);
		$wgExtNewTables[] = array(
			'distribution_mwreleases', dirname( __FILE__ ) . '/distribution.sql'
		);
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'distribution_packages',
			dirname( __FILE__ ) . '/distribution.sql', true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'distribution_units',
			dirname( __FILE__ ) . '/distribution.sql', true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'distribution_unit_versions',
			dirname( __FILE__ ) . '/distribution.sql', true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'distribution_mwreleases',
			dirname( __FILE__ ) . '/distribution.sql', true ) );
	}

	return true;
}
