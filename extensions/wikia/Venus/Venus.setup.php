<?php
/**
 * Venus Skin
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
		"name" => "Venus",
		"description" => "Venus Skin for Wikia",
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
$wgAutoloadClasses['VenusController'] = $dir . '/VenusController.class.php';
$wgAutoloadClasses['GlobalNavigationController'] = $dir . '/../GlobalNavigation/GlobalNavigationController.class.php';
$wgAutoloadClasses['LocalNavigationController'] = $dir . '/../LocalNavigation/LocalNavigationController.class.php';
$wgAutoloadClasses['LocalHeaderController'] = $dir . '/../LocalNavigation/LocalHeaderController.class.php';

/**
 * special pages
 */

/**
 * message files
 */
//$wgExtensionMessagesFiles['Venus'] = "{$dir}/Venus.i18n.php";

/**
 * hooks
 */


//404 Pages
