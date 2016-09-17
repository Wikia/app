<?php
/**
 * Functions useful to extensions, which work regardless of the version of the MediaWiki core
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

/**
 * Add a special page
 *
 * @param string $file Filename containing the derived class
 * @param string $name Name of the special page
 * @param mixed $params Name of the class, or array containing class name and constructor params
 * @deprecated Use $wgSpecialPages and $wgAutoloadClasses
 */
function extAddSpecialPage( $file, $name, $params ) {
	global $wgSpecialPages, $wgAutoloadClasses;
	if ( !is_array( $params ) ) {
		$className = $params;
	} else {
		$className = $params[0];
	}
	$wgSpecialPages[$name] = $params;
	$wgAutoloadClasses[$className] = $file;
}
