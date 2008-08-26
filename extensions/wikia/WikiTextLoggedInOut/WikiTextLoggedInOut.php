<?php
$wgExtensionFunctions[] = "wfWikiTextLoggedIn";

function wfWikiTextLoggedIn() {
	global $wgParser, $wgOut;
	$wgParser->setHook( "loggedin", "OutputLoggedInText" );
}

function OutputLoggedInText( $input, $args, &$parser ){
	global $wgUser, $wgTitle, $wgOut;

	if( $wgUser->isLoggedIn() ){
		return $parser->recursiveTagParse($input);
	}
	
	return "";
}

$wgExtensionFunctions[] = "wfWikiTextLoggedOut";

function wfWikiTextLoggedOut() {
	global $wgParser, $wgOut;
	$wgParser->setHook( "loggedout", "OutputLoggedOutText" );
}

function OutputLoggedOutText( $input, $args, &$parser ){
	global $wgUser, $wgTitle, $wgOut;
	
	if( ! $wgUser->isLoggedIn() ){
		return $parser->recursiveTagParse($input);
	}
	
	return "";
}
?>