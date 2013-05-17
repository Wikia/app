<?php

///////////////////////////////////////////////////////////////////////////
////// ingestPartnerVideoWithData.php                                //////
////// ingest video from all premium partners using WikiFactory data //////
////// Author: William Lee (wlee@wikia-inc.com)                      //////
///////////////////////////////////////////////////////////////////////////

ini_set( 'display_errors', 'stdout' );

$optionsWithArgs = array( 'u', 's', 'e', 'i' );

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
  -i <time>			Do not reingest videos if they were uploaded in the last <time> seconds
  -a				get all videos
  --ra				use ooyala remote asset to ingest video

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
$ignoreRecent = isset($options['i']) ? $options['i'] : 0;
$getAllVideos = isset($options['a']);
$remoteAsset = isset( $options['ra'] );

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
$provider = !empty($args[0]) ? strtolower($args[0]) : '';
if (empty($provider)) {
	$providersVideoFeed = VideoFeedIngester::$PROVIDERS_DEFAULT;
}
elseif (array_search($provider, VideoFeedIngester::$PROVIDERS) !== false) {
	$providersVideoFeed = array( $provider );
}
else {
	die("unknown provider $provider. aborting.\n");
}

// BEGIN MAIN

foreach ($providersVideoFeed as $provider) {
	print("Starting import for provider $provider...\n");

	$feedIngester = VideoFeedIngester::getInstance($provider); /* @var $feedIngester VideoFeedIngester */
	$feedIngester->reupload = $reupload;

	// get WikiFactory data
	$ingestionData = $feedIngester->getWikiIngestionData();
	if (empty($ingestionData)) {
		die("No ingestion data found in wikicities. Aborting.");
	}


	// open file
	$file = '';
	$startDate = $endDate = '';
	switch ($provider) {
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
			break;
		case VideoFeedIngester::PROVIDER_ANYCLIP:
			$file = $feedIngester->downloadFeed( $getAllVideos );
			break;
		case VideoFeedIngester::PROVIDER_OOYALA:
			$startDate = date('Y-m-d', $startDateTS).'T00:00:00Z';
			$endDate = date('Y-m-d', $endDateTS).'T00:00:00Z';
			break;
		case VideoFeedIngester::PROVIDER_IVA:
			// no file needed
			$startDate = date('Y-m-d', $startDateTS);
			$endDate = date('Y-m-d', $endDateTS);
			break;
		default:
	}

	$params = array(
		'debug' => $debug,
		'startDate' => $startDate,
		'endDate' => $endDate,
		'ignorerecent' => $ignoreRecent,
		'remoteAsset' => $remoteAsset,
	);

	if (!empty($ingestionData['keyphrases'])) {
		$params['keyphrasesCategories'] = $ingestionData['keyphrases'];
	}

	$numCreated = $feedIngester->import($file, $params);

	print "Created $numCreated articles!\n\n";
}

// END OF MAIN
