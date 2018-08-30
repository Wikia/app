<?php
/**
 * this script should be run once a day
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 *
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

require_once( "commandLine.inc" );

if ( !function_exists( 'wfFounderEmailsInit' ) ) {
	require_once( dirname( __FILE__ ) . "/FounderEmails.php" );
	wfFounderEmailsInit();
}

if ( isset( $options['help'] ) ) {
	die( "Usage: php maintenance.php [--event=(daysPassed/viewsDigest/completeDigest)] [--wikiId=12345] [--test-days=3] [--help] [--quiet]
		--event			specific email event i.e. daysPassed, viewsDigest, completeDigest
		--wikiId		specific wiki id
		--help			you are reading it right now\n\n" );
}

$events = [
	'daysPassed',
	'viewsDigest',    // Process events for any users that want the daily views digest
	'completeDigest', // Process events for any users that want the complete digest
];

if ( isset( $options['event'] ) && in_array( $options['event'], $events ) ) {
	$events = [ $options['event'] ];
}

$wikiId = null;
if ( isset( $options['wikiId'] ) && is_numeric( $options['wikiId'] ) ) {
	$wikiId = $options['wikiId'];
	if ( $wikiId == 1 ) {
		die( "Wiki ID 1 not valid.  Make sure an '=' was used, e.g. '--wikiId 123' vs '--wikiId=123\n" );
	}
}

foreach ( $events as $event ) {
	echo "Sending Founder Emails ($event).\n";
	FounderEmails::getInstance()->processEvents( $event, false, $wikiId );
}
