<?php
/**
 * Weinre web inspector
 * 
 * @see http://phonegap.github.com/weinre/
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

$app->wg->append(
	'ExtensionCredits',
	array(
		'name' => 'Weinre web inspector',
		'description' => 'Adds support for inspecting the browser via Weinre on mobile devices',
		'version' => '1.0',
		'author' => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <jakubolek(at)wikia-inc.com>'
		)
	),
	'other'
);

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/Weinre.class.php", 'Weinre' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/WeinreHooks.class.php", 'WeinreHooks' );

/**
 * hooks
 */
$app->registerHook( 'SkinAfterBottomScripts', 'WeinreHooks', 'onSkinAfterBottomScripts' );