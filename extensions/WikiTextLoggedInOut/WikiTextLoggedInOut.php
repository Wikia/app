<?php
/**
 * WikiTextLoggedInOut extension
 * Defines two new parser hooks, <loggedin> and <loggedout>
 * that will display different output depending if the user
 * is logged in or not.
 *
 * @file
 * @ingroup Extensions
 * @version 1.3
 * @author Aaron Wright
 * @author David Pean
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut Documentation
 */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'WikiTextLoggedInOut',
	'version' => '1.3',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut',
	'descriptionmsg' => 'wikitextloggedinout-desc'
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['WikiTextLoginInOut'] = $dir . 'WikiTextLoggedInOut.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'efWikiTextLoggedInOut';
function efWikiTextLoggedInOut( &$parser ) {
	$parser->setHook( 'loggedin', 'outputLoggedInText' );
	$parser->setHook( 'loggedout', 'outputLoggedOutText' );
	return true;
}

function outputLoggedInText( $input, $args, $parser, $frame ) {
	global $wgUser;

	if( $wgUser->isLoggedIn() ) {
		return $parser->recursiveTagParse( $input, $frame );
	}

	return '';
}

function outputLoggedOutText( $input, $args, $parser, $frame ) {
	global $wgUser;

	if( !$wgUser->isLoggedIn() ) {
		return $parser->recursiveTagParse( $input, $frame );
	}

	return '';
}

