<?php
/**
 * SkeleSkin
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
		"name" => "SkeleSkin",
		"description" => "Skin skeleton for smartphones",
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
$app->wg->set( 'wgAutoloadClasses', "{$dir}/SkeleSkinService.class.php", 'SkeleSkinService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/SkeleSkinBodyService.class.php", 'SkeleSkinBodyService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/SkeleSkinWikiHeaderService.class.php", 'SkeleSkinWikiHeaderService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/SkeleSkinPageHeaderService.class.php", 'SkeleSkinPageHeaderService' );
/**
 * controllers
 */


/**
 * special pages
 */


/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/SkeleSkin.i18n.php", 'SkeleSkin' );

/**
 * hooks
 */

/*
 * settings
 */
