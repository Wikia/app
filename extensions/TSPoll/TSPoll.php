<?php
/**
 * Toolserver Poll - Include the Toolserver-Poll-Skript(http://toolserver.org/~jan/poll/index.php)
 *
 * To activate this extension, add the following into your LocalSettings.php file:
 * require_once("$IP/extensions/TSPoll/TSPoll.php");
 *
 * @ingroup Extensions
 * @author Jan Luca <jan@toolserver.org>
 * @version 1.0 Dev
 * @link http://www.mediawiki.org/wiki/User:Jan_Luca/Extension:TSPoll Documentation
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */

// Die the extension, if not MediaWiki is used
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( - 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name'          => 'TSPoll',
	'version'       => '1.0 Beta',
	'path'          => __FILE__,
	'author'        => 'Jan Luca',
	'url'           => 'http://www.mediawiki.org/wiki/Extension:TSPoll',
	'descriptionmsg' => 'tspoll-desc'
);

// Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'efTSPollSetup';

$wgExtensionMessagesFiles['TSPoll'] = dirname( __FILE__ ) . '/TSPoll.i18n.php';

//Set function fpr <tspoll ...> and <TSPoll ...> to efTSPollRender
function efTSPollSetup( &$parser ) {
	$parser->setHook( 'TSPoll', 'efTSPollRender' );
	$parser->setHook( 'tspoll', 'efTSPollRender' );
	return true;
}

//Set function fpr <tspoll ...> and <TSPoll ...> to efTSPollRender
function efTSPollSetupHook( &$parser ) {
	$parser->setHook( 'TSPoll', 'efTSPollRender' );
	$parser->setHook( 'tspoll', 'efTSPollRender' );
	return true;
}

// Get the Output of the TSPoll-Skript and return that
function efTSPollRender( $input, $args, $parser ) {

	// Control if the "id" is set. If not, it output a error
  if ( isset( $args['id'] ) && $args['id'] != "" ) {
		$id = wfUrlencode( $args['id'] );
	} else {
		wfLoadExtensionMessages( 'TSPoll' );
		return wfMsg( 'tspoll-id-error' );
	}
  
  // Control if "dev" is set. If not, it use the normal skript, else, it use the dev skript
  if ( isset( $args['dev'] ) && $args['dev'] == "1" ) { // If the arrgument dev is given, use the TSPoll-Dev-Version
      $get_server = Http::get( 'http://toolserver.org/~jan/poll/dev/main.php?page=wiki_output&id='.$id );
  } else { // sonst die normale Version verwenden
      $get_server = Http::get( 'http://toolserver.org/~jan/poll/main.php?page=wiki_output&id='.$id );
  }
 
  // If $get_server is empty it output a error
	if ( $get_server != '' ) {
		return $get_server;
	}
	else {
		wfLoadExtensionMessages( 'TSPoll' );
		return wfMsg( 'tspoll-fetch-error' );
	}
}
