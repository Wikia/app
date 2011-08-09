<?php
/**
 * WikiaMobile
 *
 * @author Jakub Olek, Federico Lucignano
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "WikiaMobile",
		"description" => "Mobile Skin for Wikia",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <bukaj.kelo(at)gmail.com>'
		)
	),
	'other'
);

/**
 * classes
 */

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileService.class.php", 'WikiaMobileService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileBodyService.class.php", 'WikiaMobileBodyService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileWikiHeaderService.class.php", 'WikiaMobileWikiHeaderService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobilePageHeaderService.class.php", 'WikiaMobilePageHeaderService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileNavigationService.class.php", 'WikiaMobileNavigationService' );

/**
 * controllers
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileAppCacheController.class.php", 'WikiaMobileAppCacheController' );

/**
 * special pages
 */


/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/WikiaMobile.i18n.php", 'WikiaMobile' );

/**
 * hooks
 */

/*
 * settings
 */
