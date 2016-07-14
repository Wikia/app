<?php

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

$pwd = getcwd();
chdir( __DIR__ . '/..' );
passthru( 'composer update' );
chdir( $pwd );

$shouldUseMwHack = !defined( 'MEDIAWIKI' );

if ( $shouldUseMwHack ) {
	require_once( __DIR__ . '/evilMediaWikiBootstrap.php' );
}

require_once( __DIR__ . '/../vendor/autoload.php' );

if ( $shouldUseMwHack ) {
	foreach ( $GLOBALS['wgExtensionFunctions'] as $extensionFunction ) {
		call_user_func( $extensionFunction );
	}
}