<?php

///////////////////////////////////////////////////////////////////////////
////// ingestPartnerVideoWithData.php                                //////
////// ingest video from all premium partners using WikiFactory data //////
////// Author: William Lee (wlee@wikia-inc.com)                      //////
///////////////////////////////////////////////////////////////////////////

ini_set( 'display_errors', 'stdout' );

$optionsWithArgs = array( 'u', 's', 'e' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

if ( isset( $options['h'] ) ) {
	print <<<EOT
Import video from a partner

Usage: php ingestPartnerVideoWithData.php [options...] <partner>

Options:
  -u <user>         Username
  -s <date>         Start date for searching videos by date (Unix timestamp)
  -e <date>         End date for searching videos by date (Unix timestamp)
  -d                Debug mode
  -r				Reingest videos (overwrite existing)
  -a				get all videos
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php.
                    If none is specified, script will ingest content from all 
		    supported premium providers.


EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Wikia Video Library';
// default date range - start: three days ago, end: tomorrow
$now = date_create();
$di = new DateInterval('P1D');
date_add($now, $di);
$endDateTS = isset( $options['e'] ) ? $options['e'] : date_timestamp_get($now);
$di = new DateInterval('P2D');
date_sub($now, $di); // for some reason, this subtracts twice the date interval!
$startDateTS = isset( $options['s'] ) ? $options['s'] : date_timestamp_get($now);
$debug = isset($options['d']);
$reupload = isset($options['r']);
$getAllVideos = isset($options['a']);

// INPUT VALIDATION

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	die("Invalid username\n");
}
if ( $wgUser->isAnon() ) {
//	$wgUser->addToDatabase();
}
$wgUser->load();

$providersVideoFeed = array();

$db = wfGetDB( DB_SLAVE );
$res = $db->query("SELECT img_name, img_minor_mime, img_metadata FROM image WHERE img_width=0 AND img_minor_mime IN ('ign')"); /* ign, screenplay */

$providersToIngest = array();


while ( $row = $res->fetchObject() ) {

	$data = unserialize( $row->img_metadata );

	if ( !empty ($data['published']) ) {

		$published = $data['published'];

		$providersToIngest[] = array(
			"provider" => strtolower( $row->img_minor_mime ),
			"feedTimeStart" => strtotime("-1 day", $published),
			"feedTimeEnd" => strtotime("+1 day", $published),
			"dateStart" => date("Y-m-d H:i:s", strtotime("-2 day", $published)),
			"dateEnd" => date("Y-m-d H:i:s", strtotime("+2 day", $published)),
			"filter" => $data['videoId']
		);

	}
}

if ( count( $providersToIngest ) == 0 ) {
	die( "NOTHING TO INGEST" );
}

foreach ( $providersToIngest as $provider ) {

	print_r($provider);

	$feedIngester = VideoFeedIngester::getInstance($provider['provider']); /* @var $feedIngester VideoFeedIngester */
	$feedIngester->reupload = true;
	$ingestionData = $feedIngester->getWikiIngestionData();
	if (empty($ingestionData)) {
		die("No ingestion data found in wikicities. Aborting.");
	}

	$startDateTS = $provider['feedTimeStart'];
	$endDateTS = $provider['feedTimeEnd'];

	switch ($provider['provider']) {
		case VideoFeedIngester::PROVIDER_SCREENPLAY:
			$startDate = date('m/d/y', $startDateTS);
			$endDate = date('m/d/y', $endDateTS);
			$file = $feedIngester->downloadFeed($startDate, $endDate);
			break;
		case VideoFeedIngester::PROVIDER_IGN:
			$startDate = date('Y-m-d', $startDateTS).'T00:00:00-0800';
			$endDate = date('Y-m-d', $endDateTS).'T00:00:00-0800';
			$file = $feedIngester->downloadFeed($startDate, $endDate);
			break;
		case VideoFeedIngester::PROVIDER_REALGRAVITY:
			// no file needed
			$startDate = date('Y-m-d', $startDateTS);
			$endDate = date('Y-m-d', $endDateTS);
			break;
		case VideoFeedIngester::PROVIDER_ANYCLIP:
			$file = $feedIngester->downloadFeed( $getAllVideos );
			break;
		default:
	}

	$params = array('debug'=>$debug, 'startDate'=>$startDate, 'endDate'=>$endDate);
	if (!empty($ingestionData['keyphrases'])) {
		$params['keyphrasesCategories'] = $ingestionData['keyphrases'];
	}

	$feedIngester->setFilter( $provider['filter'] );

	$numCreated = $feedIngester->import($file, $params);

	print "Created $numCreated articles!\n\n";



	die( " \n\n-------[- ingesting only one video for now -]--------\n\n " );
}




// END OF MAIN
