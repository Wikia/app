<?php

$dir = dirname( __FILE__ ) . '/';

/* Resource Loader Modules */

$wgVisualEditorWikiaResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'VisualEditor/wikia/modules',
);


$wgResourceModules += array(
	// Based on ext.visualEditor.viewPageTarget.init
	'ext.visualEditor.wikiaViewPageTarget.init' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => 've/init/ve.init.wikia.ViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'jquery.byteLength',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options',
			'ext.visualEditor.track'
		),
		'position' => 'top'
	)
);

