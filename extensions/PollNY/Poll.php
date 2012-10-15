<?php
/**
 * PollNY extension
 * Defines a new namespace for polls (NS_POLL, the namespace number is 300 by
 * default) and 6 new special pages for poll creation/administration.
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:PollNY Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'PollNY',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Advanced polling system that uses special pages and allows embedding polls to wiki pages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PollNY'
);

// Global poll namespace reference
define( 'NS_POLL', 300 );
define( 'NS_POLL_TALK', 301 );

# Configuration section
// Display comments on poll pages? Requires the Comments extension.
$wgPollDisplay['comments'] = false;

// Web-accessible path to this extension's files.
// If you change this, you also need to edit Poll.js.
$wgPollScripts = $wgScriptPath . '/extensions/PollNY';

// For example: 'edits' => 5 if you want to require users to have at least 5
// edits before they can create new polls.
$wgCreatePollThresholds = array();

// New user right for administering polls
$wgAvailableRights[] = 'polladmin';
$wgGroupPermissions['sysop']['polladmin'] = true;

// Set up the new special pages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['PollNY'] = $dir . 'Poll.i18n.php';
$wgExtensionMessagesFiles['PollNYAlias'] = $dir . 'Poll.alias.php';
// Namespace translations
$wgExtensionMessagesFiles['PollNYNamespaces'] = $dir . 'Poll.namespaces.php';

$wgAutoloadClasses['AdminPoll'] = $dir . 'SpecialAdminPoll.php';
$wgAutoloadClasses['CreatePoll'] = $dir . 'SpecialCreatePoll.php';
$wgAutoloadClasses['Poll'] = $dir . 'PollClass.php';
$wgAutoloadClasses['PollPage'] = $dir . 'PollPage.php';
$wgAutoloadClasses['RandomPoll'] = $dir . 'SpecialRandomPoll.php';
$wgAutoloadClasses['UpdatePoll'] = $dir . 'SpecialUpdatePoll.php';
$wgAutoloadClasses['ViewPoll'] = $dir . 'SpecialViewPoll.php';

$wgSpecialPages['AdminPoll'] = 'AdminPoll';
$wgSpecialPages['CreatePoll'] = 'CreatePoll';
$wgSpecialPages['RandomPoll'] = 'RandomPoll';
$wgSpecialPages['UpdatePoll'] = 'UpdatePoll';
$wgSpecialPages['ViewPoll'] = 'ViewPoll';

// Upload form
$wgAutoloadClasses['SpecialPollAjaxUpload'] = $dir . 'MiniAjaxUpload.php';
$wgAutoloadClasses['PollAjaxUploadForm'] = $dir . 'MiniAjaxUpload.php';
$wgAutoloadClasses['PollUpload'] = $dir . 'MiniAjaxUpload.php';
$wgSpecialPages['PollAjaxUpload'] = 'SpecialPollAjaxUpload';

// New special page group for poll-related special pages
$wgSpecialPageGroups['AdminPoll'] = 'poll';
$wgSpecialPageGroups['CreatePoll'] = 'poll';
$wgSpecialPageGroups['RandomPoll'] = 'poll';
$wgSpecialPageGroups['ViewPoll'] = 'poll';

// Load required AJAX functions
require_once( 'Poll_AjaxFunctions.php' );

// Hooked functions
$wgAutoloadClasses['PollNYHooks'] = $dir . 'PollNYHooks.php';

$wgHooks['TitleMoveComplete'][] = 'PollNYHooks::updatePollQuestion';
$wgHooks['ArticleDelete'][] = 'PollNYHooks::deletePollQuestion';
$wgHooks['ParserFirstCallInit'][] = 'PollNYHooks::registerUserPollHook';
$wgHooks['ParserFirstCallInit'][] = 'PollNYHooks::registerPollEmbedHook';
$wgHooks['ArticleFromTitle'][] = 'PollNYHooks::pollFromTitle';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'PollNYHooks::addTables';
$wgHooks['RenameUserSQL'][] = 'PollNYHooks::onUserRename'; // For the Renameuser extension
$wgHooks['CanonicalNamespaces'][] = 'PollNYHooks::onCanonicalNamespaces';

// ResourceLoader support for MediaWiki 1.17+
$resourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'PollNY',
	'position' => 'top' // available since r85616
);

$wgResourceModules['ext.pollNY'] = $resourceTemplate + array(
	'styles' => 'Poll.css',
	'scripts' => 'Poll.js',
	'messages' => array(
		// PollPage.php
		'poll-open-message', 'poll-close-message', 'poll-flagged-message',
		'poll-finished',
		// SpecialAdminPoll.php
		'poll-open-message', 'poll-close-message', 'poll-flagged-message',
		'poll-delete-message',
		// SpecialCreatePoll.php / create-poll.tmpl.php
		'poll-createpoll-error-nomore', 'poll-upload-new-image',
		'poll-atleast', 'poll-enterquestion', 'poll-hash',
		'poll-pleasechoose',
	)
);

$wgResourceModules['ext.pollNY.lightBox'] = $resourceTemplate + array(
	'scripts' => 'LightBox.js'
);