<?php

/**
 * Global functions for the Distributed Semantic MediaWiki extension.
 * 
 * @file DSMW_GlobalFunctions.php
 * @ingroup DSMW
 * 
 * @author jean-philippe muller & Morel Émile
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

/**
 *
 * @param <String> $version1
 * @param <String> $version2='1.14.0'
 * @return <integer>
 */
function compareMWVersion( $version1, $version2 = '1.14.0' ) {
	$version1 = explode( ".", $version1 );
	$version2 = explode( ".", $version2 );

	if ( $version1[0] > $version2[0] )
		return 1;
	elseif ( $version1[0] < $version2[0] )
		return -1;
	elseif ( $version1[1] > $version2[1] )
		return 1;
	elseif ( $version1[1] < $version2[1] )
		return -1;
	elseif ( $version1[2] > $version2[2] )
		return 1;
	elseif ( $version1[2] < $version2[2] )
		return -1;
	else
		return 0;
}
