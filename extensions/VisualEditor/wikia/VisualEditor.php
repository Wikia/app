<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

$dir = dirname( __FILE__ ) . '/';

/* Classes */

$wgAutoloadClasses['VisualEditorWikiaHooks'] = $dir . 'VisualEditor.hooks.php';

/* ResourceLoader Modules */

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
			've/ui/tools/buttons/ve.ui.WikiaMediaInsertButtonTool.js',
			've/ui/tools/buttons/ve.ui.WikiaSourceModeButtonTool.js',
			've/ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaSourceModeDialog.js',
			've/ui/widgets/ve.ui.WikiaCartWidget.js',
			've/ui/widgets/ve.ui.WikiaCartItemWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaResultWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaSearchWidget.js',
		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'visualeditor-wikiamediainsertbuttontool-label',
			'visualeditor-wikiasourcemodebuttontool-label',
			'visualeditor-wikiasourcemode-button-apply',
			'visualeditor-dialog-source-mode-title',
			'videohandler-video-views'
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
