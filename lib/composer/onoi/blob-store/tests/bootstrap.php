<?php

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */

if ( PHP_SAPI !== 'cli' ) {
	die( 'Not an entry point' );
}

error_reporting( E_ALL | E_STRICT );
ini_set( 'display_errors', 1 );

if ( is_readable( $path = __DIR__ . '/../vendor/autoload.php' ) ) {
	print( "\nUsing the blobstore vendor autoloader ...\n\n" );
} elseif ( is_readable( $path = __DIR__ . '/../../../autoload.php' ) ) {
	print( "\nUsing another local vendor autoloader ...\n\n" );
} else {
	die( 'The test suite requires a Composer based deployement.' );
}

$autoLoader = require $path;
$autoLoader->addPsr4( 'Onoi\\BlobStore\\Tests\\', __DIR__ . '/phpunit/Unit' );
$autoLoader->addPsr4( 'Onoi\\BlobStore\\Tests\\Integration\\', __DIR__ . '/phpunit/Integration' );
