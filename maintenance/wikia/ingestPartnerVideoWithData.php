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

Usage: php importPartnerVideo.php [options...] <partner>

Options:
  -u <user>         Username
  -s <date>         Start date for searching videos by date (Unix timestamp)
  -e <date>         End date for searching videos by date (Unix timestamp)
  -d                Debug mode
  -o                Parse mode (does not create articles)
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php.
                    If none is specified, script will ingest content from all 
		    supported premium providers.


EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$startDateTS = isset( $options['s'] ) ? $options['s'] : null;
$endDateTS = isset( $options['e'] ) ? $options['e'] : null;
$debug = isset($options['d']);
$parseOnly = isset($options['o']);

// INPUT VALIDATION

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	die("Invalid username\n");
}
if ( $wgUser->isAnon() ) {
//	$wgUser->addToDatabase();
}

$provider = !empty($args[0]) ? strtolower($args[0]) : '';
$providers = array();
switch ($provider) {
	case VideoPage::V_SCREENPLAY:
	case VideoPage::V_MOVIECLIPS:
	case VideoPage::V_REALGRAVITY:
		$providers = array( $provider );
		break;
	case '':
		$providers = array( VideoPage::V_SCREENPLAY, VideoPage::V_MOVIECLIPS, VideoPage::V_REALGRAVITY );
		break;
	default:
		die("unknown provider $provider. aborting.\n");		
}

// BEGIN MAIN

foreach ($providers as $provider) {

	!$parseOnly && print("Starting import for provider $provider ({$wgWikiaVideoProviders[$provider]})...\n");

	// get WikiFactory data
	$ingestionData = PartnerVideoHelper::getInstance()->getPartnerVideoIngestionData();

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

// END OF MAIN
