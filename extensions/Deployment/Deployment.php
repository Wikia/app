<?php
/**
 * Deployment extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Deployment
 *
 * @file Deployment.php
 * @ingroup Deployment
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Deployment_VERSION', '0.1 alpha' );

include_once 'Deployment_Settings.php';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Deployment',
	'version' => Deployment_VERSION,
	'author' => '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Deployment',
	'descriptionmsg' => 'deployment-desc',
);

// Register the internationalization and aliasing files.
$wgExtensionMessagesFiles['Deployment'] 		= dirname( __FILE__ ) . '/Deployment.i18n.php';
$wgExtensionMessagesFiles['DeploymentAlias']	= dirname( __FILE__ ) . '/Deployment.alias.php';

// Load classes.
$egDeployIncIp = dirname( __FILE__ ) . '/includes/';
$wgAutoloadClasses['DistributionRepository'] 	= $egDeployIncIp . 'DistributionRepository.php';
$wgAutoloadClasses['ExtensionInfo'] 			= $egDeployIncIp . 'ExtensionInfo.php';
$wgAutoloadClasses['PackageRepository'] 		= $egDeployIncIp . 'PackageRepository.php';
unset( $egDeployIncIp );

// Load and register Special:Dashboard.
$wgAutoloadClasses['SpecialDashboard'] = dirname( __FILE__ ) . '/specials/SpecialDashboard.php';
$wgSpecialPages['Dashboard'] = 'SpecialDashboard';
$wgSpecialPageGroups['Dashboard'] = 'administration';

// Load and register Special:Extensions.
$wgAutoloadClasses['SpecialExtensions'] = dirname( __FILE__ ) . '/specials/SpecialExtensions.php';
$wgSpecialPages['Extensions'] = 'SpecialExtensions';
$wgSpecialPageGroups['Extensions'] = 'administration';

// Load and register Special:Install.
$wgAutoloadClasses['SpecialInstall'] = dirname( __FILE__ ) . '/specials/SpecialInstall.php';
$wgSpecialPages['Install'] = 'SpecialInstall';
$wgSpecialPageGroups['Install'] = 'administration';

// Load and register Special:Update.
$wgAutoloadClasses['SpecialUpdate'] = dirname( __FILE__ ) . '/specials/SpecialUpdate.php';
$wgSpecialPages['Update'] = 'SpecialUpdate';
$wgSpecialPageGroups['Update'] = 'administration';

/**
 * The siteadmin permission is needed to access the administration special pages.
 * By default only sysops have this permission.
 */
$wgGroupPermissions['sysop']['siteadmin'] = true;
function wfGetRepository() {
	global $wgRepositoryApiLocation;
	static $repository = false;

	if ( $repository === false ) {
		$repository = new DistributionRepository( $wgRepositoryApiLocation );
	}

	return $repository;
}
