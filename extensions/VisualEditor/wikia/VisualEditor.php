<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

// Register resource modules
$wgResourceModules += array(
	'ext.visualEditor.wikiaViewPageTarget.init' => array(
		'scripts' => 've.init.mw.WikiaViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options',
		),
		'position' => 'top',
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.wikiaViewPageTarget' => array(
		'scripts' => array(
			've.init.mw.WikiaViewPageTarget.js',
		),
		'styles' => array(
			've.init.mw.WikiaViewPageTarget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	),
	'ext.visualEditor.wikiaCore' => array(
		'scripts' => array(
			've.ce.WikiaBlockMediaNode.js',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		),
		'localBasePath' => dirname( __FILE__ ) . '/modules',
		'remoteExtPath' => 'VisualEditor/wikia',
	)
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';