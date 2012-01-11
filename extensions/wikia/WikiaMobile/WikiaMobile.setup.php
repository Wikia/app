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
			'Jakub Olek <jakubolek(at)wikia-inc.com>'
		)
	),
	'other'
);

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileHooks.class.php", 'WikiaMobileHooks' );

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileService.class.php", 'WikiaMobileService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileBodyService.class.php", 'WikiaMobileBodyService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileArticleCategoriesService.class.php", 'WikiaMobileArticleCategoriesService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobilePageHeaderService.class.php", 'WikiaMobilePageHeaderService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileNavigationService.class.php", 'WikiaMobileNavigationService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileFooterService.class.php", 'WikiaMobileFooterService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileAdService.class.php", 'WikiaMobileAdService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WikiaMobileLeftPaneService.class.php", 'WikiaMobileLeftPaneService' );

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
$app->registerHook( 'OutputPageParserOutput', 'WikiaMobileHooks', 'onOutputPageParserOutput' );
$app->registerHook( 'ParserLimitReport', 'WikiaMobileHooks', 'onParserLimitReport' );
$app->registerHook( 'MakeHeadline', 'WikiaMobileHooks', 'onMakeHeadline' );

/*
 * settings
 */

 //list of special pages (canonical names) to strip out from the navigation menu
$app->wg->set( 'wgWikiaMobileNavigationBlacklist', array( 'Chat' ) );