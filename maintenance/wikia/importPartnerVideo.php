<?php

///////////////////////////////////////////////////////
////// importPartnerVideo.php                    //////
////// import video from a partner into one wiki //////
////// Author: William Lee (wlee@wikia-inc.com)  //////
///////////////////////////////////////////////////////

$optionsWithArgs = array( 'u', 'f', 'c' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

if ( count( $args ) == 0 || isset( $options['help'] ) ) {
	print <<<EOT
Import video from a partner

Usage: php importPartnerVideo.php [options...] <partner>

Options:
  -u <user>         Username
  -f <filename>     Screenplay: Import video from specified file instead of API. MovieClips: file containing MC ID's to import.
  -c <categories>   Additional categories to apply to video pages, delimited by tilde (~)
  -d                Debug mode
  -o                Parse mode (does not create articles)
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php

If the specified user does not exist, it will be created.

EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$filename = isset( $options['f'] ) ? $options['f'] : null;
$addlCategories = isset( $options['c'] ) ? explode('~', $options['c']) : null;
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

if (!empty($filename)) {
	if (!is_file($filename)) {
		die("Invalid filename\n");
	}
}
else {
	die("Missing filename\n");
}

$provider = strtolower($args[0]);
switch ($provider) {
	case VideoPage::V_SCREENPLAY:
	case VideoPage::V_MOVIECLIPS:
	case VideoPage::V_REALGRAVITY:
		break;
	default:
		die("unknown provider $provider. aborting.\n");		
}

// BEGIN MAIN

!$parseOnly && print("Starting import for provider $provider ({$wgWikiaVideoProviders[$provider]})...\n");

// open file
$file = '';
if ($filename) {
	$file = file_get_contents($filename);
	if ($file === false) {
		die("Error reading file $filename\n");
	}
}
else {
	// unsupported
}

PartnerVideoHelper::getInstance()->importFromPartner($provider, $file);

// END OF MAIN
