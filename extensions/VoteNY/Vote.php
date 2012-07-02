<?php
/**
 * Vote extension - JavaScript-based voting with the <vote> tag
 *
 * @file
 * @ingroup Extensions
 * @version 2.4
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link http://www.mediawiki.org/wiki/Extension:VoteNY Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Vote',
	'version' => '2.5',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'descriptionmsg' => 'voteny-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:VoteNY'
);

// Path to Vote extension files
$wgVoteDirectory = "$IP/extensions/VoteNY";

// New user right
$wgAvailableRights[] = 'vote';
$wgGroupPermissions['*']['vote'] = false; // Anonymous users cannot vote
$wgGroupPermissions['user']['vote'] = true; // Registered users can vote

// AJAX functions needed by this extension
require_once( 'Vote_AjaxFunctions.php' );

// Autoload classes and set up i18n
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Vote'] = $dir . 'Vote.i18n.php';
$wgExtensionMessagesFiles['VoteNYMagic'] = $dir . 'VoteNY.i18n.magic.php';
$wgAutoloadClasses['Vote'] = $dir . 'VoteClass.php';
$wgAutoloadClasses['VoteStars'] = $dir . 'VoteClass.php';

// Set up the new special page, Special:TopRatings, which shows top rated pages
// based on given criteria
$wgAutoloadClasses['SpecialTopRatings'] = $dir . 'SpecialTopRatings.php';
$wgSpecialPages['TopRatings'] = 'SpecialTopRatings';

// Hooked functions
$wgAutoloadClasses['VoteHooks'] = $dir . 'VoteHooks.php';

$wgHooks['ParserFirstCallInit'][] = 'VoteHooks::registerParserHook';
$wgHooks['RenameUserSQL'][] = 'VoteHooks::onUserRename';
$wgHooks['ParserGetVariableValueSwitch'][] = 'VoteHooks::assignValueToMagicWord';
$wgHooks['MagicWordwgVariableIDs'][] = 'VoteHooks::registerVariableId';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'VoteHooks::addTable';

// ResourceLoader support for MediaWiki 1.17+
$wgResourceModules['ext.voteNY'] = array(
	'styles' => 'Vote.css',
	'scripts' => 'Vote.js',
	'messages' => array( 'vote-link', 'vote-unvote-link' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'VoteNY',
	'position' => 'top' // available since r85616
);