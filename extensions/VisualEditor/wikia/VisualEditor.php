<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

// Register files
$wgExtensionMessagesFiles['VisualEditorWikia'] = dirname( __FILE__ ) . '/VisualEditor.i18n.php';

// Register resource loader modules
$wgResourceModules += array(
	'ext.visualEditor.wikiaViewPageTarget.init' => array(
		'scripts' => 've.init.mw.WikiaViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options'
		),
		'position' => 'top',
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia'
	),
	'ext.visualEditor.wikiaViewPageTarget' => array(
		'scripts' => 've.init.mw.WikiaViewPageTarget.js',
		'styles' => array(
			've.init.mw.WikiaViewPageTarget.css'
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia'
	),
	'ext.visualEditor.wikiaCore' => array(
		'scripts' => array(
			've.dm.WikiaInlineVideoNode.js',
			've.ce.WikiaInlineVideoNode.js'
			'ui/tools/ve.ui.IconTextButtonTool.js',
			'ui/tools/buttons/ve.ui.WikiaMediaInsertButtonTool.js',
			'ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
		),
		'styles' => 'ui/styles/ve.ui.Tool.css',
		'messages' => array(
			'visualeditor-wikiamediainsertbuttontool-label',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.iconsRaster' => array(
		'styles' => array(
			'ui/styles/ve.ui.Icons-raster.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.iconsVector' => array(
		'styles' => array(
			'ui/styles/ve.ui.Icons-vector.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';
//$wgVisualEditorPluginModules[] = 'ext.visualEditor.iconsRaster';
$wgVisualEditorPluginModules[] = 'ext.visualEditor.iconsVector';

// Register hooks
$wgHooks['ResourceLoaderTestModules'][] = 'Wikia_onResourceLoaderTestModules';

function Wikia_onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
	$testModules['qunit']['ext.visualEditor.wikiaTest'] = array(
		'scripts' => array(
			'test/test.js'
		),
		'dependencies' => array(
			'ext.visualEditor.test'
		),
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'VisualEditor/wikia'
	);
	return true;
}

