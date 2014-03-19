<?php

/*
 * Simple script to enable VideosModule on a per-wiki basis
 * Takes a file containing a line-by-line list of URLs as first parameter
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

include( '../../commandLine.inc' );

$filename = $argv[0];

echo "Reading from $filename ...\n";
$list = file( $filename );

if ( empty( $list ) ) {
	echo "ERROR: List file empty or not readable. Please provide a line-by-line list of wikis.\n";
	echo "USAGE: SERVER_ID=177 php EnableVideosModule.php /path/to/file\n";

	exit;
}

foreach ( $list as $wiki ) {
	echo "\n";

	$wiki = sanitizeUrl( $wiki );

	echo "Running on $wiki ...\n";
	// get wiki ID
	try {
		$id = WikiFactory::DomainToID( $wiki );
	} catch (Exception $e) {
		echo "\tCould not find wiki ID, skipping ...\n";
		continue;
	}

	if ( empty( $id ) ) {
		echo "\t$wiki: ERROR (not found in WikiFactory)\n";
		continue;
	} else {
		echo "\tWiki ID ($wiki): $id\n";
	}

	if ( $id == 177 ) {
		echo "\tDefaulted to community, not likely a valid wiki, skipping...\n";
		continue;
	}

	echo "Setting ... wgVideosModuleABTest, wgEnableVideosModuleExt\n";
	if (0) {
		WikiFactory::setVarByName( 'wgVideosModuleABTest', $id, 'bottom' );
		WikiFactory::setVarByName( 'wgEnableVideosModuleExt', $id, true );

		WikiFactory::clearCache( $id );
	}

	echo "\tdone\n";
}

function sanitizeUrl( $url ) {
	$url = str_replace( 'http://', '', $url );
	$url = trim( $url, " \n/" );

	if ( !preg_match('/\.wikia\.com/', $url) ) {
		$url .= '.wikia.com';
	}

	return $url;
}