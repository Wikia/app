<?php
/**
 * LinkFilter extension
 * Adds some new special pages and a parser hook for link submitting/approval/reject
 *
 * @file
 * @ingroup Extensions
 * @version 2.1
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link https://www.mediawiki.org/wiki/Extension:LinkFilter Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array( 
	'path' => __FILE__,
	'name' => 'LinkFilter',
	'version' => '2.1',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'descriptionmsg' => 'linkfilter-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:LinkFilter'
);

// ResourceLoader support for MediaWiki 1.17+
$wgResourceModules['ext.linkFilter'] = array(
	'styles' => 'LinkFilter.css',
	'scripts' => 'LinkFilter.js',
	'messages' => array(
		'linkfilter-admin-accept-success', 'linkfilter-admin-reject-success',
		'linkfilter-submit-no-title', 'linkfilter-submit-no-type'
	),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'LinkFilter',
	'position' => 'top' // available since r85616
);

// Define some constants (namespaces + some other stuff)
define( 'NS_LINK', 700 );
define( 'NS_LINK_TALK', 701 );

define( 'LINK_APPROVED_STATUS', 1 );
define( 'LINK_OPEN_STATUS', 0 );
define( 'LINK_REJECTED_STATUS', 2 );

// Path to the LinkFilter extension files
$wgLinkFilterDirectory = "$IP/extensions/LinkFilter";

// Array of LinkFilter types
// Key is: number => 'description'
// For example: 2 => 'Awesome',
$wgLinkFilterTypes = array(
	1 => 'Arrest Report',
	2 => 'Awesome',
	3 => 'Cool',
	4 => 'Funny',
	6 => 'Interesting',
	7 => 'Obvious',
	8 => 'OMG WTF?!?',
	9 => 'Rumor',
	10 => 'Scary',
	11 => 'Stupid',
);

// Internationalization files
$wgExtensionMessagesFiles['LinkFilter'] = "{$wgLinkFilterDirectory}/LinkFilter.i18n.php";
$wgExtensionMessagesFiles['LinkFilterAlias'] = "{$wgLinkFilterDirectory}/Link.alias.php";
// Namespace translations
$wgExtensionMessagesFiles['LinkNamespaces'] = "{$wgLinkFilterDirectory}/Link.namespaces.php";

// Some base classes to be autoloaded
$wgAutoloadClasses['Link'] = "{$wgLinkFilterDirectory}/LinkClass.php";
$wgAutoloadClasses['LinkList'] = "{$wgLinkFilterDirectory}/LinkClass.php";
$wgAutoloadClasses['LinkPage'] = "{$wgLinkFilterDirectory}/LinkPage.php";

// RSS feed class used on Special:LinksHome (replaces the hardcoded feed)
$wgAutoloadClasses['LinkFeed'] = "{$wgLinkFilterDirectory}/LinkFeed.php";

// Special pages
$wgAutoloadClasses['LinksHome'] = "{$wgLinkFilterDirectory}/SpecialLinksHome.php";
$wgSpecialPages['LinksHome'] = 'LinksHome';

$wgAutoloadClasses['LinkSubmit'] = "{$wgLinkFilterDirectory}/SpecialLinkSubmit.php";
$wgSpecialPages['LinkSubmit'] = 'LinkSubmit';

$wgAutoloadClasses['LinkRedirect'] = "{$wgLinkFilterDirectory}/SpecialLinkRedirect.php";
$wgSpecialPages['LinkRedirect'] = 'LinkRedirect';

$wgAutoloadClasses['LinkApprove'] = "{$wgLinkFilterDirectory}/SpecialLinkApprove.php";
$wgSpecialPages['LinkApprove'] = 'LinkApprove';

$wgAutoloadClasses['LinkEdit'] = "{$wgLinkFilterDirectory}/SpecialLinkEdit.php";
$wgSpecialPages['LinkEdit'] = 'LinkEdit';

// AJAX functions called by the JavaScript file
require_once("{$wgLinkFilterDirectory}/LinkFilter_AjaxFunctions.php");

// Default setup for displaying sections
$wgLinkPageDisplay = array(
	'leftcolumn' => true,
	'rightcolumn' => false,
	'author' => true,
	'left_ad' => false,
	'popular_articles' => false,
	'in_the_news' => false,
	'comments_of_day' => true,
	'games' => true,
	'new_links' => false
);

// New user right
$wgAvailableRights[] = 'linkadmin';
$wgGroupPermissions['linkadmin']['linkadmin'] = true;
$wgGroupPermissions['staff']['linkadmin'] = true;
$wgGroupPermissions['sysop']['linkadmin'] = true;

// Hooked functions
$wgAutoloadClasses['LinkFilterHooks'] = "{$wgLinkFilterDirectory}/LinkFilterHooks.php";

$wgHooks['TitleMoveComplete'][] = 'LinkFilterHooks::updateLinkFilter';
$wgHooks['ArticleDelete'][] = 'LinkFilterHooks::deleteLinkFilter';
$wgHooks['ArticleFromTitle'][] = 'LinkFilterHooks::linkFromTitle';
$wgHooks['ParserFirstCallInit'][] = 'LinkFilterHooks::registerLinkFilterHook';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'LinkFilterHooks::applySchemaChanges';
$wgHooks['CanonicalNamespaces'][] = 'LinkFilterHooks::onCanonicalNamespaces';
// For the Renameuser extension
$wgHooks['RenameUserSQL'][] = 'LinkFilterHooks::onUserRename';
// Interaction with the Comments extension
$wgHooks['Comment::add'][] = 'LinkFilterHooks::onCommentAdd';
$wgHooks['Comment::delete'][] = 'LinkFilterHooks::onCommentDelete';