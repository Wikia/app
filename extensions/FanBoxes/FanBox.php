<?php
/**
 * FanBox extension
 * Defines a new namespace for fanboxes (NS_FANTAG, the namespace number is 600
 * by default) and some new special pages to add/view fanboxes.
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Robert Lefkowitz
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link http://www.mediawiki.org/wiki/Extension:FanBox Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'FanBox',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Robert Lefkowitz', 'Jack Phoenix' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:FanBox',
	'description' => 'A new way of creating and using userboxes, based on special pages',
);

// ResourceLoader support for MediaWiki 1.17+
$wgResourceModules['ext.fanBoxes'] = array(
	'styles' => 'FanBoxes.css',
	'scripts' => 'FanBoxes.js',
	'messages' => array(
		'fanbox-mustenter-left', 'fanbox-mustenter-right',
		'fanbox-mustenter-right-or', 'fanbox-mustenter-title', 'fanbox-hash',
		'fanbox-choose-another', 'fanbox-upload-new-image'
	),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'FanBoxes',
	'position' => 'top' // available since r85616
);

// Global fantag namespace reference
if( !defined( 'NS_FANTAG' ) ) {
	define( 'NS_FANTAG', 600 );
}

if( !defined( 'NS_FANTAG_TALK' ) ) {
	define( 'NS_FANTAG_TALK', 601 );
}

// Set up the new special pages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['FanBox'] = $dir . 'FanBox.i18n.php';
$wgExtensionMessagesFiles['FanBoxNamespaces'] = $dir . 'FanBox.namespaces.php';
$wgAutoloadClasses['FanBox'] = $dir . 'FanBoxClass.php';
$wgAutoloadClasses['SpecialFanBoxAjaxUpload'] = $dir . 'MiniAjaxUpload.php';
$wgAutoloadClasses['FanBoxAjaxUploadForm'] = $dir . 'MiniAjaxUpload.php';
$wgAutoloadClasses['FanBoxUpload'] = $dir . 'MiniAjaxUpload.php';
$wgAutoloadClasses['FanBoxPage'] = $dir . 'FanBoxPage.php';
$wgAutoloadClasses['FanBoxes'] = $dir . 'SpecialFanBoxes.php';
$wgAutoloadClasses['TagCloud'] = $dir . 'TagCloudClass.php';
$wgAutoloadClasses['TopFanBoxes'] = $dir . 'SpecialTopFanBoxes.php';
$wgAutoloadClasses['UserFanBoxes'] = $dir . 'FanBoxesClass.php';
$wgAutoloadClasses['ViewFanBoxes'] = $dir . 'SpecialViewFanBoxes.php';
$wgSpecialPages['FanBoxAjaxUpload'] = 'SpecialFanBoxAjaxUpload';
$wgSpecialPages['UserBoxes'] = 'FanBoxes';
$wgSpecialPages['TopUserboxes'] = 'TopFanBoxes';
$wgSpecialPages['ViewUserBoxes'] = 'ViewFanBoxes';
// Special page groups for MW 1.13+
$wgSpecialPageGroups['UserBoxes'] = 'users';
$wgSpecialPageGroups['TopUserboxes'] = 'users';
$wgSpecialPageGroups['ViewUserBoxes'] = 'users';

// AJAX functions used by this extension
require_once( 'FanBox_AjaxFunctions.php' );

// <userboxes> parser hook
require_once( 'UserBoxesHook.php' );

# Configuration settings
// Web-readable path to FanBox files (used to fetch CSS & JS)
$wgFanBoxScripts = $wgScriptPath . '/extensions/FanBoxes';
// Should we display comments on FanBox pages? Requires the Comments extension.
$wgFanBoxPageDisplay['comments'] = true;

// Hooked functions
$wgAutoloadClasses['FanBoxHooks'] = $dir . 'FanBoxHooks.php';

$wgHooks['TitleMoveComplete'][] = 'FanBoxHooks::updateFanBoxTitle';
$wgHooks['ArticleDelete'][] = 'FanBoxHooks::deleteFanBox';
$wgHooks['ArticleFromTitle'][] = 'FanBoxHooks::fantagFromTitle';
$wgHooks['ParserBeforeStrip'][] = 'FanBoxHooks::transformFanBoxTags';
$wgHooks['ParserFirstCallInit'][] = 'FanBoxHooks::registerFanTag';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'FanBoxHooks::addTables';
$wgHooks['RenameUserSQL'][] = 'FanBoxHooks::onUserRename'; // For the Renameuser extension
$wgHooks['CanonicalNamespaces'][] = 'FanBoxHooks::onCanonicalNamespaces';