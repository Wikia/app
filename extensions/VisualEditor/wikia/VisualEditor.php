<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

$dir = dirname( __FILE__ ) . '/';

// Register files
$wgAutoloadClasses['VisualEditorWikiaHooks'] = $dir . 'VisualEditor.hooks.php';
$wgAutoloadClasses['ApiTempUpload'] = $dir . 'ApiTempUpload.php';
$wgAutoloadClasses['ApiMediaSearch'] = $dir . 'ApiMediaSearch.php';
$wgAutoloadClasses['ApiPhotoAttribution'] = $dir . 'ApiPhotoAttribution.php';

// Register API modules
$wgAPIModules['apitempupload'] = 'ApiTempUpload';
$wgAPIModules['apimediasearch'] = 'ApiMediaSearch';
$wgAPIModules['apiphotoattribution'] = 'ApiPhotoAttribution';

// Register resource modules
$wgVisualEditorWikiaResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'VisualEditor/wikia/modules',
);

$wgResourceModules += array(
	'ext.visualEditor.wikiaViewPageTarget.init' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => 've/init/ve.init.mw.WikiaViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options'
		),
		'position' => 'top'
	),
	'ext.visualEditor.wikiaViewPageTarget' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			've/init/ve.init.mw.WikiaViewPageTarget.js',
		),
		'styles' => array(
			've/init/styles/ve.init.mw.WikiaViewPageTarget.css'
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		)
	),
	'ext.visualEditor.wikiaCore' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			// dm
			've/dm/ve.dm.WikiaMediaCaptionNode.js',
			've/dm/ve.dm.WikiaBlockMediaNode.js',
			've/dm/ve.dm.WikiaBlockImageNode.js',
			've/dm/ve.dm.WikiaBlockVideoNode.js',
			've/dm/ve.dm.WikiaInlineVideoNode.js',
			've/dm/ve.dm.WikiaCart.js',
			've/dm/ve.dm.WikiaCartItem.js',

			// ce
			've/ce/ve.ce.WikiaMediaCaptionNode.js',
			've/ce/ve.ce.WikiaBlockMediaNode.js',
			've/ce/ve.ce.WikiaBlockImageNode.js',
			've/ce/ve.ce.WikiaVideoNode.js',
			've/ce/ve.ce.WikiaBlockVideoNode.js',
			've/ce/ve.ce.WikiaInlineVideoNode.js',

			// ui
			've/ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
			've/ui/tools/buttons/ve.ui.WikiaMediaInsertButtonTool.js',
			've/ui/widgets/ve.ui.WikiaCartWidget.js',
			've/ui/widgets/ve.ui.WikiaCartItemWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaPageWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaResultWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaResultsWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaQueryWidget.js',
			've/ui/widgets/ve.ui.WikiaUploadWidget.js',
		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'visualeditor-wikiamediainsertbuttontool-label',
			'videohandler-video-views',
			'visualeditor-wikiauploadwidget-label',
			'visualeditor-wikiauploadwidget-button',
			'visualeditor-wikiauploaderror',
			'visualeditor-wikiamediainsertsearch-placeholder',
		),
		'dependencies' => array(
			'ext.visualEditor.core'
		)
	),
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';

/* Messages */

$wgExtensionMessagesFiles['VisualEditorWikia'] = $dir . 'VisualEditor.i18n.php';

/* Hooks */

$wgHooks['ResourceLoaderTestModules'][] = 'VisualEditorWikiaHooks::onResourceLoaderTestModules';
$wgHooks['GetPreferences'][] = 'VisualEditorWikiaHooks::onGetPreferences';
