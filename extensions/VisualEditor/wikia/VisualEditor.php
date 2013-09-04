<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

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
	)
);

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

