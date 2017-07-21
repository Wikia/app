<?php

if ( PHP_SAPI !== 'cli' ) {
	die( 'Not an entry point' );
}

error_reporting( E_ALL | E_STRICT );
date_default_timezone_set( 'UTC' );
ini_set( 'display_errors', 1 );

if ( !is_readable( $autoloaderClassPath = __DIR__ . '/../../SemanticMediaWiki/tests/autoloader.php' ) ) {
	die( "\nThe Semantic MediaWiki test autoloader is not available" );
}

if ( !class_exists( 'SemanticScribunto' ) || ( $version = SemanticScribunto::getVersion() ) === null ) {
	die( "\nSemantic Scribunto is not available or loaded, please check your Composer or LocalSettings.\n" );
}

print sprintf( "\n%-20s%s\n", "Semantic Scribunto: ", $version );
print sprintf( "%-20s%s\n", "Lua version: ", SemanticScribunto::getVersion( 'Lua' ) );

// What is the Scribunto version?? Who knows ..., it doesn't have a version number

$autoLoader = require $autoloaderClassPath;
$autoLoader->addPsr4( 'SMW\\Scribunto\\Tests\\', __DIR__ . '/phpunit/Unit' );
$autoLoader->addPsr4( 'SMW\\Scribunto\\Tests\\Integration\\', __DIR__ . '/phpunit/Integration' );
unset( $autoLoader );
