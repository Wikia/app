<?php

if ( php_sapi_name() !== 'cli' ) {
	die( 'Not an entry point' );
}

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'MediaWiki is not available for the test environment' );
}

function registerAutoloaderPath( $identifier, $path ) {
	print( "\nUsing the {$identifier} vendor autoloader ...\n\n" );
	return require $path;
}

function runTestAutoLoader() {

	$mwVendorPath = __DIR__ . '/../../../vendor/autoload.php';
	$localVendorPath = __DIR__ . '/../vendor/autoload.php';

	if ( is_readable( $localVendorPath ) ) {
		$autoLoader = registerAutoloaderPath( 'local', $localVendorPath );
	} elseif ( is_readable( $mwVendorPath ) ) {
		$autoLoader = registerAutoloaderPath( 'MediaWiki', $mwVendorPath );
	} else {
		print( "\No vendor autoloader ...\n\n" );
	}

	if ( !$autoLoader instanceof \Composer\Autoload\ClassLoader ) {
		// For now return true as long as SF is not compatible with Composer
		// of course if it is installed via
		// https://packagist.org/packages/mediawiki/semantic-forms
		// we have no problems
		return true;
	}

	return true;
}

if ( !runTestAutoLoader() ) {
	die( 'The required test autoloader was not accessible' );
}
