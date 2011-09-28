<?php
/**
 * WikiaMobile
 *
 * @author Jakub Olek, Federico Lucignano, Sean Colombo
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
		"name" => "PhotoPop",
		"description" => "Mobile Skin for Wikia",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <bukaj.kelo(at)gmail.com>',
			'[http://www.seancolombo.com Sean Colombo]'
		),
		'descriptionmsg' => 'photopop-desc',
		'version' => '0.1'
	),
	'other'
);

/**
 * classes
 */

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PhotoPopController.class.php", 'PhotoPopController' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PhotoPopAppCacheController.class.php", 'PhotoPopAppCacheController' );

/**
 * controllers
 */

/**
 * special pages
 */


/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/PhotoPop.i18n.php", 'PhotoPop' );

/**
 * hooks
 */

/*
 * settings
 */
// register messages package for JS
F::build('JSMessages')->registerPackage('PhotoPop', array(
	'photopop-progress-numbers',
	'photopop-continue-correct',
	'photopop-endgame-completion-summary',
	'photopop-endgame-score-summary',
));