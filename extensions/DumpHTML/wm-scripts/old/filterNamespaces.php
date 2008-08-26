<?php

$oldDir = getcwd();
require_once( '/home/wikipedia/common/php/maintenance/commandLine.inc' );
chdir( $oldDir );

$filename = $args[0];
if ( !$filename ) {
	die("No filename specified\n");
}

$lines = file( $filename );
if ( !$lines ) {
	die( "Unable to open file $filename\n" );
}

foreach ( $lines as $line ) {
	$base = basename( trim( $line ) );
	$tildePos = strpos( $base, '~' );
	$printIt = true;
	if ( $tildePos !== false ) {
		$ns = substr( $base, 0, $tildePos );
		$nsi = $wgLang->getNsIndex( $ns );
		if ( $nsi !== false ) {
			if ( !in_array( $nsi, array( NS_IMAGE, NS_PROJECT, NS_HELP, NS_CATEGORY ) ) ) {
				$printIt = false;
			}
		}
	}
	if ( $printIt ) {
		print $line;
	}
}

?>
