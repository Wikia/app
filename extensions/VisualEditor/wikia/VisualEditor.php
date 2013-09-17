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
		'localBasePath' => dirname( __FILE__ ) . '/modules',
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
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.wikiaCore' => array(
		'scripts' => array(
			'dm/ve.dm.WikiaMediaCaptionNode.js',
			'dm/ve.dm.WikiaBlockMediaNode.js',
			'dm/ve.dm.WikiaBlockImageNode.js',
			'dm/ve.dm.WikiaBlockVideoNode.js',
			'dm/ve.dm.WikiaInlineVideoNode.js',
			'ce/ve.ce.WikiaMediaCaptionNode.js',
			'ce/ve.ce.WikiaBlockMediaNode.js',
			'ce/ve.ce.WikiaBlockImageNode.js',
			'ce/ve.ce.WikiaVideoNode.js',
			'ce/ve.ce.WikiaBlockVideoNode.js',
			'ce/ve.ce.WikiaInlineVideoNode.js',
		),
		'styles' => array (
			'ui/styles/ve.ui.Surface.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	)
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';

/* Messages */

JSMessages::registerPackage( 'VisualEditor', array(
	'oasis-content-picture-added-by',
	'videohandler-video-views',
));

/* Hooks */

$wgHooks['ResourceLoaderTestModules'][] = 'Wikia_onResourceLoaderTestModules';

function Wikia_onResourceLoaderTestModules( array &$testModules, ResourceLoader &$resourceLoader ) {
	$testModules['qunit']['ext.visualEditor.wikiaTest'] = array(
		'scripts' => array(
			'test/ve.wikiaTest.utils.js',
			'test/dm/ve.dm.wikiaExample.js',
			'test/dm/ve.dm.WikiaConverter.test.js',
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
