<?php
/**
 * WikiaModern Skin
 *
 * @author Consumer Team
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$dir = dirname( __FILE__ );

/**
 * info
 */
$wgExtensionCredits['other'][] =
	[
		"name" => "WikiaModern",
		"description" => "WikiaModern Skin for Wikia",
		"author" => [
			'Consumer Team',
		]
	];

/**
 * settings
 */

/**
 * classes
 */

/**
 * services
 */

/**
 * models
 */


/**
 * controllers
 */
$wgAutoloadClasses['WikiaModernController'] = $dir . '/WikiaModernController.class.php';
$wgAutoloadClasses['GlobalNavigationController'] = $dir . '/../GlobalNavigation/GlobalNavigationController.class.php';
$wgAutoloadClasses['LocalNavigationController'] = $dir . '/../LocalNavigation/LocalNavigationController.class.php';
$wgAutoloadClasses['LocalHeaderController'] = $dir . '/../LocalNavigation/LocalHeaderController.class.php';

/**
 * special pages
 */

/**
 * message files
 */
//$wgExtensionMessagesFiles['WikiaModern'] = "{$dir}/WikiaModern.i18n.php";

/**
 * hooks
 */


//404 Pages
