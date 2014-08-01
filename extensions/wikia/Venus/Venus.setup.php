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
$wgAutoloadClasses['VenusController'] = __DIR__ . '/VenusController.class.php';
//$wgAutoloadClasses['GlobalNavigationController'] = __DIR__ . '/../GlobalNavigation/GlobalNavigationController.class.php';
//$wgAutoloadClasses['LocalNavigationController'] = __DIR__ . '/../LocalNavigation/LocalNavigationController.class.php';
//$wgAutoloadClasses['LocalHeaderController'] = __DIR__ . '/../LocalNavigation/LocalHeaderController.class.php';

/**
 * special pages
 */

/**
 * message files
 */
//$wgExtensionMessagesFiles['Venus'] = __DIR__ . '/Venus.i18n.php';

/**
 * hooks
 */


//404 Pages
