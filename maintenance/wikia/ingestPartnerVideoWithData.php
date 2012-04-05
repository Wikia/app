<?php

///////////////////////////////////////////////////////////////////////////
////// ingestPartnerVideoWithData.php                                //////
////// ingest video from all premium partners using WikiFactory data //////
////// Author: William Lee (wlee@wikia-inc.com)                      //////
///////////////////////////////////////////////////////////////////////////

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
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php.
                    If none is specified, script will ingest content from all 
		    supported premium providers.


EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
// default date range - start: three days ago, end: tomorrow
$now = date_create();
$di = new DateInterval('P1D');
date_add($now, $di);
$endDateTS = isset( $options['e'] ) ? $options['e'] : date_timestamp_get($now);
$di = new DateInterval('P2D');
date_sub($now, $di); // for some reason, this subtracts twice the date interval!
$startDateTS = isset( $options['s'] ) ? $options['s'] : date_timestamp_get($now);
$debug = isset($options['d']);

// INPUT VALIDATION

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	die("Invalid username\n");
}
if ( $wgUser->isAnon() ) {
//	$wgUser->addToDatabase();
}

$useVideoFeed = WikiaVideoService::useVideoHandlersExtForIngestion();
$usePartnerVideo = WikiaVideoService::useWikiaVideoExtForIngestion();
$providersVideoFeed = $providersPartnerVideo = array();
$provider = !empty($args[0]) ? strtolower($args[0]) : '';
if ($useVideoFeed) {
	if (empty($provider)) {
		$providersVideoFeed = VideoFeedIngester::$PROVIDERS;
	}
	elseif (array_search($provider, VideoFeedIngester::$PROVIDERS) !== false) {
		$providersVideoFeed = array( $provider );
	}
	else {
		die("unknown provider $provider. aborting.\n");			
	}
}
if ($usePartnerVideo) {
	switch ($provider) {
		case VideoPage::V_SCREENPLAY:
		case VideoPage::V_MOVIECLIPS:
		case VideoPage::V_REALGRAVITY:
			$providersPartnerVideo = array( $provider );
			break;
		case '':
			$providersPartnerVideo = array( VideoPage::V_SCREENPLAY, VideoPage::V_MOVIECLIPS, VideoPage::V_REALGRAVITY );
			break;
		default:
			die("unknown provider $provider. aborting.\n");		
	}
}

// BEGIN MAIN

if ($useVideoFeed) {
	foreach ($providersVideoFeed as $provider) {
		print("Starting import for provider $provider...\n");

		$feedIngester = VideoFeedIngester::getInstance($provider);

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
			case VideoFeedIngester::PROVIDER_MOVIECLIPS:
				// no file needed
				break;
			case VideoFeedIngester::PROVIDER_REALGRAVITY:				
				// no file needed
				$startDate = date('m/d/Y', $startDateTS);
				$endDate = date('m/d/Y', $endDateTS);
				break;
			default:
		}

		$params = array('debug'=>$debug, 'startDate'=>$startDate, 'endDate'=>$endDate);
		if (!empty($ingestionData['keyphrases'])) {
			$params['keyphrasesCategories'] = $ingestionData['keyphrases'];
		}
		if (!empty($ingestionData['movieclipsIds'])) {
			$params['movieclipsidsCategories'] = $ingestionData['movieclipsIds'];

		}

		$numCreated = $feedIngester->import($file, $params);		
		
		print "Created $numCreated articles!\n\n";
	}
}

if ($usePartnerVideo) {
	foreach ($providersPartnerVideo as $provider) {
		print("Starting import for provider $provider ({$wgWikiaVideoProviders[$provider]})...\n");

		// get WikiFactory data
		$ingestionData = PartnerVideoHelper::getInstance()->getPartnerVideoIngestionData();
		if (empty($ingestionData)) {
			die("No ingestion data found in wikicities. Aborting.");
		}

		// open file
		$file = '';
		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$remoteUser = $wgScreenplayApiConfig['username'];
				$remotePassword = $wgScreenplayApiConfig['password'];
				$startDate = date('m/d/y', $startDateTS);
				$endDate = date('m/d/y', $endDateTS);
				$file = PartnerVideoHelper::getInstance()->downloadScreenplayFeed($startDate, $endDate);
				break;
			case VideoPage::V_MOVIECLIPS:
				// no file needed
				break;
			case VideoPage::V_REALGRAVITY:
				$startDate = date('m/d/Y', $startDateTS);
				$endDate = date('m/d/Y', $endDateTS);
				// no file needed
				break;
			default:
		}

		$params = array();
		if (!empty($ingestionData['keyphrases'])) {
			$params['keyphrasesCategories'] = $ingestionData['keyphrases'];
		}
		if (!empty($ingestionData['movieclipsIds'])) {
			$params['movieclipsidsCategories'] = $ingestionData['movieclipsIds'];

		}

		PartnerVideoHelper::getInstance()->importFromPartner($provider, $file, $params);
	}
}

// END OF MAIN
