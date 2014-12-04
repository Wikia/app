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

$wgAutoloadClasses['ResourceVariablesGetter'] = "includes/wikia/resourceloader/ResourceVariablesGetter.class.php";

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
