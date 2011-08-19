<?php

///////////////////////////////////////////////////////
////// importPartnerVideo.php                    //////
////// import video from a partner into one wiki //////
////// Author: William Lee (wlee@wikia-inc.com)  //////
///////////////////////////////////////////////////////

// CONFIG

$SCREENPLAY_FTP_HOST = 'ftp.screenplayinc.com';
$SCREENPLAY_REMOTE_FILE = 'feed.zip';
$SCREENPLAY_FEED_FILE = 'feed.xml';
$MOVIECLIPS_VIDEOS_LISTING_FOR_MOVIE_URL = 'http://api.movieclips.com/v2/movies/$1/videos';
$MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';
$TEMP_DIR = '/tmp';

$optionsWithArgs = array( 'u', 'f', 'r', 'p' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

if ( count( $args ) == 0 || isset( $options['help'] ) ) {
	print <<<EOT
Import video from a partner

Usage: php importPartnerVideo.php [options...] <partner>

Options:
  -u <user>         Username
  -f <filename>     Screenplay: Import video from specified file instead of API. MovieClips: file containing MC ID's to import.
  -r <remoteuser>   Remote username
  -p <password>     Remote password
  -d                Debug mode
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php

If the specified user does not exist, it will be created.

EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$filename = isset( $options['f'] ) ? $options['f'] : null;
$remoteUser = isset( $options['r'] ) ? $options['r'] : null;
$remotePassword = isset( $options['p'] ) ? $options['p'] : null;
$debug = isset($options['d']);

// INPUT VALIDATION

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	die("Invalid username\n");
}
if ( $wgUser->isAnon() ) {
//	$wgUser->addToDatabase();
}

if (!empty($filename)) {
	if (!is_file($filename)) {
		die("Invalid filename\n");
	}
}
else {
	if (!$remoteUser || !$remotePassword) {
		die("must provide username and password\n");
	}
}

$provider = strtolower($args[0]);
switch ($provider) {
	case VideoPage::V_SCREENPLAY:
	case VideoPage::V_MOVIECLIPS:
		break;
	default:
		die("unknown provider $provider. aborting.\n");		
}

// BEGIN MAIN

print("Starting import for provider $provider ({$wgWikiaVideoProviders[$provider]})...\n");

// open file
$file = '';
if ($filename) {
	$file = file_get_contents($filename);
	if ($file === false) {
		die("Error reading file $filename\n");
	}
}
else {
	switch ($provider) {
		case VideoPage::V_SCREENPLAY:
			$file = PartnerVideoHelper::downloadScreenplayFeed();
			break;
		default:
			$file = @Http::get( $url );
			if ($file === false) {
				die("Error reading URL $url\n");
			}
	}
}

PartnerVideoHelper::getInstance()->importFromPartner($provider, $file);

// END OF MAIN
