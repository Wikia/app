<?php

/*
 * Simple script to enable Oasis on a per-wiki basis
 * Takes a file containing a line-by-line list of URLs as first parameter
 *
 * Note: Remember to run the script from a host that has all varnishes in your keys file (best: deploy-s1) and check if pdsh works first
 * by doing:
 * 	pdsh -g all_varnish date
 * if some machines refuse connection, ssh to each one manually. If that doesn't work, call Ops.
 *
 * USAGE: SERVER_ID=177 php EnableOasis.php /path/to/file --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php [--yes] [--nopurge]
 *
 * Use the --yes switch to auto-answer yes to all prompts.
 *
 * Use the --nopurge switch to skip Varnish purges.
 *
 * @date 2010-10-21
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

#error_reporting( E_ERROR );

include( '../commandLine.inc' );

$list = file( $argv[0] );

// exceptions taken from https://staff.wikia-inc.com/wiki/Oasis/Release_plan#D._Site_wide_launch_plan
$exceptions = array(
	'blind.wikia.com',
	'necyklopedie.wikia.com',
	'beidipedia.wikia.com',
	'desencyclopedie.wikia.com',
	'inciclopedia.wikia',
	'nonsensopedia.wikia',
	'absurdopedia.wikia.com',
	'necyklopedia.wikia.com',
	'zh.uncyclopedia.wikia',
	'nonciclopedia.wikia',
	'eincyclopedia.wikia',
	'tolololpedia.wikia.com',
	'neciklopedio.wikia',
	'de.uncyclopedia.org',
	'uncyclopedia.wikia.com',
	'halo.wikia.com', # ad campaign
	'gearsofwar.wikia.com', # ad campaign
	'callofduty.wikia.com', # ad campaign
	'aoc.wikia.com', # ad campaign, per Mike
	'cityofheroes.wikia.com', # ad campaign, per Mike
	'aceattorney.wikia.com', # ad campaign, per Mike
	'alanwake.wikia.com', # ad campaign, per Mike
	'saintsrow.wikia.com', # ad campaign, per Mike
	'halofanon.wikia.com', # ad campaign, per Mike
	'sonicfanon.wikia.com', # ad campaign, per Mike
);

// list of allowed languages taken from Release plan
$allowedLanguages = array( 'en', 'de', 'es' );

if ( empty( $list ) ) {
	echo "ERROR: List file empty or not readable. Please provide a line-by-line list of wikis.\n";
	echo "USAGE: SERVER_ID=177 php EnableOasis.php /path/to/file --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php [--yes] [--nopurge]\n";

	exit;
}

function sanitizeUrl( $url ) {
	$url = str_replace( 'http://', '', $url );
	$url = trim( $url, " \n/" );

	return $url;
}

function parseInput( $input ) {
	$positive = array( 'y', 'Y', 'Yes', 'YES' );
	$negative = array( 'n', 'no', 'No', 'NO' );

	$input = trim( $input );

	if ( in_array( $input, $positive ) ) {
		return true;
	}

	if ( in_array( $input, $negative ) ) {
		return false;
	}

	return null;
}

foreach ( $list as $wiki ) {
	echo "\n";

	$wiki = sanitizeUrl( $wiki );

	// get wiki ID
	$id = WikiFactory::DomainToID( $wiki );

	if ( empty( $id ) ) {
		echo "$wiki: ERROR (not found in WikiFactory)\n";
		continue;
	}

	// get URL, in case the one given is not the main one
	$oUrl = WikiFactory::getVarByName( 'wgServer', $id );

	$oLang = WikiFactory::getVarByName( 'wgLanguageCode', $id );

	$oSkin = WikiFactory::getVarByName( 'wgDefaultSkin', $id );

	if ( empty( $oUrl ) || empty( $oLang ) ) {
		// should never happen, but...
		echo "$wiki: ERROR (failed to get URL for ID $id or language; something's wrong)\n";
		continue;
	}

	$domain = sanitizeUrl( unserialize( $oUrl->cv_value ) );

	$lang = unserialize( $oLang->cv_value );

	$currentSkin = $oSkin ? unserialize( $oLang->cv_value ) : null;

	// handle exceptions
	if ( in_array( $currentSkin, array( 'monobook', 'uncyclopedia', 'oasis' ) ) ) {
		echo "$wiki: SKIPPING! Current skin is $currentSkin! Will NOT process.\n";
		continue;
	}

	if ( in_array( $domain, $exceptions ) ) {
		echo "$wiki: SKIPPING! This wiki is listed as an exception in the Rallout Plan!\n";
		continue;
	}

	if ( !in_array( $lang, $allowedLanguages ) ) {
		echo "$wiki: SKIPPING! Wiki's language ($lang) is not on the allowed languaes list.\n";
		continue;
	}

	if ( !isset( $options['yes'] ) ) {
		$response = null;
		// repeat until we get a valid response
		while ( is_null( $response ) ) {
			echo "$wiki: Are you sure you want to switch to Oasis? [yes/no] ";
			$input = fgets( STDIN );
			$response = parseInput( $input );
		}

		if ( !$response ) {
			// user answered no
			echo "$wiki: SKIPPING (because you said so)\n";
			continue;
		} else {
			echo "$wiki: PROCEEDING\n";
		}
	}

	WikiFactory::setVarByName( 'wgDefaultSkin', $id, 'oasis' );

	WikiFactory::clearCache( $id );

	// purge varnishes
	if ( !isset( $options['nopurge'] ) ) {
		$cmd = "pdsh -g all_varnish varnishadm -T :6082 'purge req.http.host == \"" . $domain . "\"'";
		passthru( $cmd );
	}

	echo "$wiki: PROCESSING COMPLETED\n";
}
