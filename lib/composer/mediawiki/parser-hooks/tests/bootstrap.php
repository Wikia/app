<?php

/**
 * PHPUnit bootstrap file for the ParserHooks extension.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
 
if ( PHP_SAPI !== 'cli' ) {
	die( 'Not an entry point' );
}

error_reporting( E_ALL | E_STRICT );
ini_set( 'display_errors', 1 );

if ( is_readable( $path = __DIR__ . '/../vendor/autoload.php' ) ) {
	print( "\nUsing the local vendor autoloader ...\n\n" );
} elseif ( is_readable( $path = __DIR__ . '/../../../vendor/autoload.php' ) ) {
	print( "\nUsing the MediaWiki vendor autoloader ...\n\n" );
} else {
	die( 'To run tests it is required that packages are installed using Composer.' );
}

require $path;

$GLOBALS['wgExtensionMessagesFiles']['TagHookTest'] = __DIR__ . '/system/TagHookTest.i18n.php';
