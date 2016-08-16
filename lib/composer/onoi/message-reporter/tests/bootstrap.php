<?php

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */

error_reporting( E_ALL | E_STRICT );
date_default_timezone_set( 'UTC' );

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

if ( !is_readable( $path = __DIR__ . '/../vendor/autoload.php' ) ) {
	if ( !is_readable( $path = __DIR__ . '/../../../autoload.php' ) ) {
		die( 'The test suite requires the Composer autoloader to be present' );
	}
}

$autoLoader = require $path;
$autoLoader->addPsr4( 'Onoi\\MessageReporter\\Tests\\', __DIR__ . '/phpunit' );
