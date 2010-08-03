<?php
/**
 * Player extension - multimedia playback using common browser plugins
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */


if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Player',
	'svn-date' => '$LastChangedDate: 2008-11-30 04:15:22 +0100 (ndz, 30 lis 2008) $',
	'svn-revision' => '$LastChangedRevision: 44056 $',
	'author' => 'Daniel Kinzler, brightbyte.de',
	'url' => 'http://mediawiki.org/wiki/Extension:Player',
	'description' => 'embedded multimedia playback using common browser plugins',
	'descriptionmsg' => 'player-desc',
);

$wgExtensionFunctions[] = "playerSetup";
$wgHooks['OutputPageParserOutput'][] = 'playerParserOutput';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Player'] = $dir . 'Player.i18n.php';
$wgExtensionAliasesFiles['Player'] = $dir . 'Player.alias.php';
$wgAutoloadClasses['Player'] = $dir . 'PlayerClass.php';
$wgAutoloadClasses['SpecialPlayer'] = $dir . 'SpecialPlayer.php';
$wgSpecialPages['Player'] = 'SpecialPlayer';

$wgAjaxExportList[] = 'playerAjaxHandler';

$wgPlayerExtensionPath = $GLOBALS['wgServer'] . $GLOBALS['wgScriptPath'] . '/extensions/Player';

$wgPlayerMimeOverride = array( );

$wgPlayerTemplates = array();
$wgPlayerVideoResolutionDetector = NULL;

require_once( dirname( __FILE__ ) . '/PlayerDefaultSettings.php' );

function playerSetup() {
	global $wgParser;

	$wgParser->setHook( "player", "renderPlayerTag" );
}

function renderPlayerTag( $name, $args, &$parser ) {
	global $wgUser;

	$attribnames = array( 'id', 'style', 'class', 'thumb', 'align' );

	$attributes = array();
	$options = array();

	$deferred = NULL; //TODO: true forces immediate playback (no ajax), false suppresses it (use ajax).

	foreach ($args as $k => $v) {
		if (in_array($k, $attribnames)) $attributes[$k] = $v;
		else $options[$k] = $v;
	}

	$name = trim($name);
	$n = explode('|', $name, 2);
	if (sizeof($n) > 1) {
		$name = trim($n[0]);
		$options['caption'] = $n[1];
	}

	#print_r($attributes);
	#print_r($options);

	$parser->mOutput->mPlayerTag = true; # flag for use by playerParserOutput

	try {
		$player = Player::newFromName($name, $options, 'thumbsize');
		$html = $player->getThumbnailHTML($attributes, $deferred);

		$html = trim( preg_replace('/[ \t\r\n]+/', ' ', $html) ); //normalize whitespace, don't trigger block-level formating
		return $html;
	}
	catch (PlayerException $ex) {
		$skin = $wgUser->getSkin();

		if ($ex->getCode() == '404') {
			return $skin->makeBrokenLinkObj( Title::makeTitleSafe(NS_IMAGE, $name) );
		}
		else if (@$player && $ex->getCode() == '403') {
			//TODO: show "normal" image thumbnail. requires parameter mangeling, though...
			return $skin->makeKnownLinkObj( $player->title );
		}
		else {
			return "<div class='error'>" . $ex->getMessage() . "</div>";
		}
	}
}

function playerAjaxHandler( $file, $options ) {
	$response = new AjaxResponse( );

	try {
		#TODO: caching!

		$player = Player::newFromName( $file, $options, 'thumbsize' );
		$html = $player->getPlayerHTML( );

		$response->addText( $html );
	}
	catch (PlayerException $ex) {
		$response->setResponseCode($ex->getHTTPCode());
		$response->addText($ex->getHTML());
	}

	return $response;
}

/**
* Hook callback that injects messages and things into the <head> tag
* Does nothing if $parserOutput->mPlayerTag is not set
*/
function playerParserOutput( &$outputPage, &$parserOutput )  {
	if ( !empty( $parserOutput->mPlayerTag ) ) {
		Player::setHeaders( $outputPage );
	}
	return true;
}

if (!function_exists('urldecodeMap')) {
	function urldecodeMap($s) {
		if (!$s) return array();

		$entries = explode('&', $s);
		$map = array();

		foreach ($entries as $e) {
			$m = explode('=', $e, 2);
			$k = urldecode($m[0]);
			$v = sizeof($m) < 2 ? true : urldecode($m[1]);
			$map[$k] = $v;
		}

		return $map;
	}
}

if (!function_exists('urlencodeMap')) {
	function urlencodeMap($map) {
		$s = '';

		foreach ($map as $k => $v) {
			if ($s!=='') $s.= '&';
			$s.= urlencode($k);

			if ($v === false || $v === NULL) continue;
			else if ($v !== true) $s.= '=' . urlencode($v);
		}

		return $s;
	}
}
