<?php

/**
* Maintenance script to reingest existing IVA videos to Ooyala and then reingest the videos to video wiki
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Write data to file
 * @global boolean $dryRun
 * @param string $filename
 * @param string $msg
 * @param array $video
 */
function backupFile( $filename, $msg, $video ) {
	global $dryRun;

	if ( !$dryRun ) {
		file_put_contents( $filename, "$msg:\n".var_export( json_encode( $video ), true )."\n" , FILE_APPEND );
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php reingestVideoIva.php [--help] [--dry-run] [--backup=path/filename] [--to=wiki]
	--dry-run       dry run
	--to            wiki or ooyala
	--backup        backup all videos data to file
	--help          you are reading it right now\n\n" );
}

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id.\n" );
}

$dryRun = isset( $options['dry-run'] );
$toWiki = ( isset( $options['iva'] ) && $options['iva'] == 'wiki' ) ? true : false;
$backupFile = isset( $options['backup'] ) ? $options['backup'] : '';

if ( $toWiki ) {
	$provider = 'ooyala';
	$remoteAsset = false;
} else {
	$provider = 'iva';
	$remoteAsset = true;
}

echo "Wiki: $wgCityId ($wgDBname)\n";
echo "Provider: $provider\n";
if ( !empty( $backupFile ) ) {
	echo "Backup File: $backupFile\n";
}

$wgUser = User::newFromName( 'Wikia Video Library' );
if ( !$wgUser ) {
	die( "Invalid username\n" );
}
$wgUser->load();

$ingester = VideoFeedIngester::getInstance( $provider );
// get WikiFactory data
$ingestionData = $ingester->getWikiIngestionData();
if ( empty( $ingestionData ) ) {
	die( "No ingestion data found in wikicities. Aborting.\n" );
}

// format: Y-m-d
$startDate = '1993-01-01';
$endDate = '2013-08-28';

$params = array(
	'debug' => $dryRun,
	'startDate' => $startDate,
	'endDate' => $endDate,
	'ignorerecent' => 0,
	'remoteAsset' => $remoteAsset,
);

if ( !empty( $ingestionData['keyphrases'] ) ) {
	$params['keyphrasesCategories'] = $ingestionData['keyphrases'];
}

$numCreated = $ingester->import( '', $params );

print "Created $numCreated articles!\n\n";




echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
