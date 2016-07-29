<?php

/**
 * PHPUnit bootstrap file for the ParserHooks extension.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
 
if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

if ( is_readable( $path = __DIR__ . '/../vendor/autoload.php' ) ) {
	print( "\nUsing the local vendor autoloader ...\n\n" );
} elseif ( is_readable( $path = __DIR__ . '/../../../vendor/autoload.php' ) ) {
	print( "\nUsing the MediaWiki vendor autoloader ...\n\n" );
} else {
	die( 'To run tests it is required that packages are installed using Composer.' );
}

$autoloader = require $path;

$GLOBALS['wgExtensionMessagesFiles']['TagHookTest'] = __DIR__ . '/system/TagHookTest.i18n.php';
