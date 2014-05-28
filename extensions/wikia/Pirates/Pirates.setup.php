<?php
/**
 * Pirates
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
	array(
		"name" => "Pirates",
		"description" => "Pirates Skin for Wikia",
		"author" => array(
			'Consumer Team',
		)
	);

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
$wgAutoloadClasses['PiratesController'] = $dir . '/PiratesController.class.php';
$wgAutoloadClasses['PiratesGlobalHeaderController'] = $dir . '/PiratesGlobalHeaderController.class.php';
$wgAutoloadClasses['PiratesWikiHeaderController'] = $dir . '/PiratesWikiHeaderController.class.php';
$wgAutoloadClasses['PiratesWikiNavigationController'] = $dir . '/PiratesWikiNavigationController.class.php';

/**
 * special pages
 */

/**
 * message files
 */
//$wgExtensionMessagesFiles['Pirates'] = "{$dir}/Pirates.i18n.php";

//JSMessages::registerPackage( 'WkMbl', array( ));


/**
 * hooks
 */


//404 Pages
