<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

/* ResourceLoader Modules */

$wgResourceModules += array(
	'ext.visualEditor.wikiaViewPageTarget.init' => array(
		'scripts' => 'init/ve.init.mw.WikiaViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options'
		),
		'position' => 'top',
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia'
	),
	'ext.visualEditor.wikiaViewPageTarget' => array(
		'scripts' => array(
			'init/ve.init.mw.WikiaViewPageTarget.js',
		),
		'styles' => array(
			'init/styles/ve.init.mw.WikiaViewPageTarget.css'
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.wikiaCore' => array(
		'scripts' => array(
			// dm
			'dm/ve.dm.WikiaMediaCaptionNode.js',
			'dm/ve.dm.WikiaBlockMediaNode.js',
			'dm/ve.dm.WikiaBlockImageNode.js',
			'dm/ve.dm.WikiaBlockVideoNode.js',
			'dm/ve.dm.WikiaInlineVideoNode.js',

			// ce
			'ce/ve.ce.WikiaMediaCaptionNode.js',
			'ce/ve.ce.WikiaBlockMediaNode.js',
			'ce/ve.ce.WikiaBlockImageNode.js',
			'ce/ve.ce.WikiaVideoNode.js',
			'ce/ve.ce.WikiaBlockVideoNode.js',
			'ce/ve.ce.WikiaInlineVideoNode.js',

			// ui
			'ui/tools/buttons/ve.ui.WikiaMediaInsertButtonTool.js',
			'ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
		),
		'styles' => array(
			'ui/styles/ve.ui.Tool.css',
			'ui/styles/ve.ui.Icons-vector.css',
			'ui/styles/ve.ui.Surface.css'
		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'visualeditor-wikiamediainsertbuttontool-label',
			'videohandler-video-views'
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.iconsVector' => array(
		'styles' => array(
			'ui/styles/ve.ui.Icons-vector.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia',
	),
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';

/* Messages */

$wgExtensionMessagesFiles['VisualEditorWikia'] = dirname( __FILE__ ) . '/VisualEditor.i18n.php';

/* Hooks */

$wgHooks['ResourceLoaderTestModules'][] = 'Wikia_onResourceLoaderTestModules';
$wgHooks['GetPreferences'][] = 'Wikia_onGetPreferences';

function Wikia_onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
	$testModules['qunit']['ext.visualEditor.wikiaTest'] = array(
		'scripts' => array(
			// util
			'test/ve.wikiaTest.utils.js',

			// dm
			'test/dm/ve.dm.wikiaExample.js',
			'test/dm/ve.dm.WikiaConverter.test.js',

			// ce
			'test/ce/ve.ce.wikiaExample.js',
			'test/ce/ve.ce.WikiaBlockImageNode.test.js',
			'test/ce/ve.ce.WikiaBlockVideoNode.test.js',
			'test/ce/ve.ce.WikiaInlineVideoNode.test.js',
		),
		'dependencies' => array(
			'ext.visualEditor.test',
			'ext.visualEditor.wikiaCore',
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia'
	);
	return true;
}

function Wikia_onGetPreferences( $user, &$preferences ) {
	unset( $preferences['visualeditor-betatempdisable'] );
	$preferences['visualeditor-enable']['label-message'] = 'visualeditor-wikiapreference-enable';

	return true;
}
