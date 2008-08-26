<?php
/**
 * WikiTextLoggedInOut extension
 * Defines two new parser hooks, <loggedin> and <loggedout>
 * that will display different output depending if the user
 * is logged in or not.
 *
 * @author Wikia, Inc.
 * @version 1.0
 * @link http://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfWikiTextLoggedIn';
} else {
	$wgExtensionFunctions[] = 'wfWikiTextLoggedIn';
}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikiTextLoginInOut'] = $dir . 'WikiTextLoggedInOut.i18n.php';

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'WikiTextLoggedInOut',
	'version' => '1.0',
	'author' => 'Wikia New York Team',
	'description' => 'Two parser hooks, <tt>&lt;loggedin&gt;</tt> and <tt>&lt;loggedout&gt;</tt> to show different text depending on the users\' login state',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut',
	'descriptionmsg' => 'wikitextloggedinout-desc'
);

function wfWikiTextLoggedIn() {
	global $wgParser, $wgOut;
	$wgParser->setHook( 'loggedin', 'OutputLoggedInText' );
	return true;
}

function OutputLoggedInText( $input, $args, &$parser ) {
	global $wgUser, $wgTitle, $wgOut;

	if( $wgUser->isLoggedIn() ){
		return $parser->recursiveTagParse($input);
	}

	return "";
}

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfWikiTextLoggedOut';
} else {
	$wgExtensionFunctions[] = 'wfWikiTextLoggedOut';
}

function wfWikiTextLoggedOut() {
	global $wgParser, $wgOut;
	$wgParser->setHook( 'loggedout', 'OutputLoggedOutText' );
	return true;
}

function OutputLoggedOutText( $input, $args, &$parser ) {
	global $wgUser, $wgTitle, $wgOut;

	if( !$wgUser->isLoggedIn() ){
		return $parser->recursiveTagParse($input);
	}

	return "";
}
