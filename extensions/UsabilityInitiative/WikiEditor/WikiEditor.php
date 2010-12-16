<?php
/**
 * Usability Initiative WikiEditor extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the WikiEditor portion of the UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/WikiEditor/WikiEditor.php" );
 *
 * @author Trevor Parscal <trevor@wikimedia.org>, Roan Kattouw <roan.kattouw@gmail.com>,
 *         Nimish Gautam <nimish@wikimedia.org>, Adam Miller <amiller@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.2.0
 */

/* Configuration */

// Each module may be configured individually to be globally on/off or user preference based
$wgWikiEditorModules = array(
	'highlight' => array( 'global' => false, 'user' => true ),
	'preview' => array( 'global' => false, 'user' => true ),
	'publish' => array( 'global' => false, 'user' => true ),
	'toc' => array( 'global' => false, 'user' => true ),
	'toolbar' => array( 'global' => false, 'user' => true ),
	'templateEditor' => array( 'global' => false, 'user' => true ),
);

/* Setup */

// Bump this each time you change an icon without renaming it
$wgWikiEditorIconVersion = 0;

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WikiEditor',
	'author' => array( 'Trevor Parscal', 'Roan Kattouw', 'Nimish Gautam', 'Adam Miller' ),
	'version' => '0.2.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'wikieditor-desc',
);

// Include parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Add Autoload Classes
$wgAutoloadClasses['WikiEditorHooks'] = dirname( __FILE__ ) . '/WikiEditor.hooks.php';

// Add Internationalized Messages
$wgExtensionMessagesFiles['WikiEditor'] = dirname( __FILE__ ) . '/WikiEditor.i18n.php';
$wgExtensionMessagesFiles['WikiEditorHighlight'] = dirname( __FILE__ ) . '/Modules/Highlight/Highlight.i18n.php';
$wgExtensionMessagesFiles['WikiEditorPreview'] = dirname( __FILE__ ) . '/Modules/Preview/Preview.i18n.php';
$wgExtensionMessagesFiles['WikiEditorPublish'] = dirname( __FILE__ ) . '/Modules/Publish/Publish.i18n.php';
$wgExtensionMessagesFiles['WikiEditorToc'] = dirname( __FILE__ ) . '/Modules/Toc/Toc.i18n.php';
$wgExtensionMessagesFiles['WikiEditorToolbar'] = dirname( __FILE__ ) . '/Modules/Toolbar/Toolbar.i18n.php';
$wgExtensionMessagesFiles['WikiEditorTemplateEditor'] = dirname( __FILE__ ) . '/Modules/TemplateEditor/TemplateEditor.i18n.php';

// Register Hooks
$wgHooks['EditPageBeforeEditToolbar'][] = 'WikiEditorHooks::addModules';
$wgHooks['GetPreferences'][] = 'WikiEditorHooks::addPreferences';
