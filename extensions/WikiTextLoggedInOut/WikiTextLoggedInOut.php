<?php
/**
 * WikiTextLoggedInOut extension
 * Defines two new parser hooks, <loggedin> and <loggedout>
 * that will display different output depending if the user
 * is logged in or not.
 *
 * @file
 * @ingroup Extensions
 * @author Aaron Wright
 * @author David Pean
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut Documentation
 */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'WikiTextLoggedInOut',
	'version' => '1.1',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Two parser hooks, <tt>&lt;loggedin&gt;</tt> and <tt>&lt;loggedout&gt;</tt> to show different text depending on the users\' login state',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WikiTextLoggedInOut',
	'descriptionmsg' => 'wikitextloggedinout-desc'
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['WikiTextLoginInOut'] = $dir . 'WikiTextLoggedInOut.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfWikiTextLoggedIn';
function wfWikiTextLoggedIn( &$parser ) {
	$parser->setHook( 'loggedin', 'OutputLoggedInText' );
	return true;
}

function OutputLoggedInText( $input, $args, $parser ) {
	global $wgUser;

	if( $wgUser->isLoggedIn() ) {
		return $parser->recursiveTagParse( $input );
	}

	return '';
}

$wgHooks['ParserFirstCallInit'][] = 'wfWikiTextLoggedOut';

function wfWikiTextLoggedOut( &$parser ) {
	$parser->setHook( 'loggedout', 'OutputLoggedOutText' );
	return true;
}

function OutputLoggedOutText( $input, $args, $parser ) {
	global $wgUser;

	if( !$wgUser->isLoggedIn() ) {
		return $parser->recursiveTagParse( $input );
	}

	return '';
}
