<?php

spl_autoload_register( function ( $class ) {
	$prefix = 'Extensions\\Wikia\\Blogs\\';
	$baseDir = __DIR__ . '/';

	$prefixLength = strlen( $prefix );
	if ( strncmp( $prefix, $class, $prefixLength ) !== 0 ) {
		return;
	}

	$relativeClassName = substr( $class, $prefixLength );
	$file = $baseDir . str_replace( '\\', '/', $relativeClassName ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );
