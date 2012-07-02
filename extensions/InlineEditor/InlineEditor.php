<?php
/**
 * InlineEditor extension, basic include file.
 *
 * @file
 * @ingroup Extensions
 *
 * This is the include file for the InlineEditor.
 *
 * Usage: It's recommended to use the following configuration LocalSettings.php:
 * require_once( "$IP/extensions/InlineEditor/InlineEditorRecommended.php" );
 *
 * @author Jan Paul Posma <jp.posma@gmail.com>
 * @license GPL v2 or later
 * @version 0.0.0
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'InlineEditor',
	'author' => array( 'Jan Paul Posma', 'Dimitris Meimaris', 'Dimitris Mitropoulos' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:InlineEditor',
	'descriptionmsg' => 'inline-editor-desc',
);

// current directory including trailing slash
$dir = dirname( __FILE__ ) . '/';

// add autoload classes
$wgAutoloadClasses['InlineEditor']                = $dir . 'InlineEditor.class.php';
$wgAutoloadClasses['InlineEditorText']            = $dir . 'InlineEditorText.class.php';
$wgAutoloadClasses['InlineEditorMarking']         = $dir . 'InlineEditorMarking.class.php';
$wgAutoloadClasses['InlineEditorPiece']           = $dir . 'InlineEditorPiece.class.php';
$wgAutoloadClasses['InlineEditorRoot']            = $dir . 'InlineEditorRoot.class.php';
$wgAutoloadClasses['InlineEditorNode']            = $dir . 'InlineEditorNode.class.php';
$wgAutoloadClasses['ExtendedEditPage']            = $dir . 'ExtendedEditPage.class.php';

// register hooks
$wgHooks['MediaWikiPerformAction'][]              = 'InlineEditor::mediaWikiPerformAction';
$wgHooks['EditPage::showEditForm:initial'][]      = 'InlineEditor::showEditForm';
$wgHooks['GetPreferences'][]                      = 'InlineEditor::getPreferences';

$wgHooks['InlineEditorPartialBeforeParse']        = array();
$wgHooks['InlineEditorPartialAfterParse']         = array();

// i18n messages
$wgExtensionMessagesFiles['InlineEditor']         = $dir . 'InlineEditor.i18n.php';

// ajax functions
$wgAjaxExportList[]                               = 'InlineEditor::ajaxPreview';

// default options
$wgInlineEditorEnableGlobal                       = false;
$wgInlineEditorAdvancedGlobal                     = false;
$wgInlineEditorBrowserBlacklist                   = $wgBrowserBlackList;
$wgInlineEditorAllowedNamespaces                  = array( NS_MAIN, NS_TALK, NS_USER, NS_USER_TALK );

// default user options
$wgDefaultUserOptions['inline-editor-enabled']    = 1;
$wgDefaultUserOptions['inline-editor-advanced']   = 0;

// resources
$inlineEditorTpl = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'InlineEditor',
	'group'         => 'ext.inlineEditor',
);

$wgResourceModules += array(
	'jquery.inlineEditor' => $inlineEditorTpl + array(
		'scripts'      => 'jquery.inlineEditor.js',
		'styles'       => 'jquery.inlineEditor.css',
		'dependencies' => array(
			'jquery.color',
			'mediawiki.util',
			'jquery.json',
		),
	),
	'jquery.inlineEditor.editors.basic' => $inlineEditorTpl + array(
		'scripts'      => 'jquery.inlineEditor.editors.basic.js',
		'styles'       => 'jquery.inlineEditor.editors.basic.css',
		'messages'     => array(
			'inline-editor-preview',
			'tooltip-inline-editor-preview',
			'accesskey-inline-editor-preview',
			'inline-editor-cancel',
			'tooltip-inline-editor-cancel',
			'accesskey-inline-editor-cancel',
		),
		'dependencies' => array(
			'jquery.inlineEditor',
			'jquery.elastic',
			'mediawiki.util',
		),
	),
	'jquery.elastic' => $inlineEditorTpl + array(
		'scripts'      => 'jquery.elastic.js',
	),
);
