<?php
$wgExtensionFunctions[] = "wfWikiTextLoggedIn";

function wfWikiTextLoggedIn() {
	global $wgParser;
	$wgParser->setHook( "loggedin", "OutputLoggedInText" );
}

function OutputLoggedInText( $input, $args, &$parser ){
	global $wgUser;

	if( $wgUser->isLoggedIn() ){
		return $parser->recursiveTagParse($input);
	}
	
	return "";
}

$wgExtensionFunctions[] = "wfWikiTextLoggedOut";

function wfWikiTextLoggedOut() {
	global $wgParser;
	$wgParser->setHook( "loggedout", "OutputLoggedOutText" );
}

function OutputLoggedOutText( $input, $args, &$parser ){
	global $wgUser;
	
	if( $wgUser->isAnon() ){
		return $parser->recursiveTagParse($input);
	}
	
	return "";
}
