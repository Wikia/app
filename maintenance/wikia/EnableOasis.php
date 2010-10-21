<?php

/*
 * Simple script to enable Oasis on a per-wiki basis
 * Takes a file containing a line-by-line list of URLs as first parameter
 *
 * USAGE: SERVER_ID=177 php EnableOasis.php /path/to/file --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 *
 * @date 2010-10-21
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

#error_reporting( E_ERROR );

include( '../commandLine.inc' );

$list = file( $argv[0] );

if ( empty( $list ) ) {
	echo "ERROR: List file empty or not readable. Please provide a line-by-line list of wikis.\n";
	echo "USAGE: SERVER_ID=177 php EnableOasis.php /path/to/file --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php\n";

	exit;
}

function sanitizeUrl( $url ) {
	$url = str_replace( 'http://', '', $url );
	$url = trim( $url, " \n/" );

	return $url;
}

foreach ( $list as $wiki ) {
	$wiki = sanitizeUrl( $wiki );

	// get wiki ID
	$id = WikiFactory::DomainToID( $wiki );

	if ( empty( $id ) ) {
		echo "ERROR: $wiki not found in WikiFactory!\n";
		continue;
	}

	// get URL, in case the one given is not the main one
	$url = WikiFactory::getVarByName( 'wgServer', $id );

	if ( empty( $url ) ) {
		// should never happen, but...
		echo "ERROR: failed to get URL for ID $id; something's wrong.";
		continue;
	}

	$url = sanitizeUrl( $url );

	WikiFactory::setVarByName( 'wgDefaultSkin', $id, 'oasis' );

	WikiFactory::clearCache( $id );

	// purge varnishes
	exec( "pdsh -g all_varnish varnishadm -T :6082 'purge req.http.host == \"" . $url . "\"'" );

	echo "PROCESSED WIKI $url with ID = $id\n";
}
