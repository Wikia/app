<?php

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor for Wikia'
);

$dir = dirname( __FILE__ ) . '/';

/* Classes */

$wgAutoloadClasses['VisualEditorWikiaHooks'] = $dir . 'VisualEditor.hooks.php';
$wgAutoloadClasses['ApiMediaSearch'] = $dir . 'ApiMediaSearch.php';
$wgAutoloadClasses['ApiPhotoAttribution'] = $dir . 'ApiPhotoAttribution.php';
$wgAutoloadClasses['ApiAddMedia'] = $dir . 'ApiAddMedia.php';
$wgAutoloadClasses['ApiAddMediaTemporary'] = $dir . 'ApiAddMediaTemporary.php';
$wgAutoloadClasses['ApiAddMediaPermanent'] = $dir . 'ApiAddMediaPermanent.php';
$wgAutoloadClasses['ApiVideoPreview'] = $dir . 'ApiVideoPreview.php';

/* API Modules */

$wgAPIModules['apimediasearch'] = 'ApiMediaSearch';
$wgAPIModules['apiphotoattribution'] = 'ApiPhotoAttribution';
$wgAPIModules['addmediatemporary'] = 'ApiAddMediaTemporary';
$wgAPIModules['addmediapermanent'] = 'ApiAddMediaPermanent';
$wgAPIModules['videopreview'] = 'ApiVideoPreview';

/* Resource Loader Modules */

$wgVisualEditorWikiaResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'VisualEditor/wikia/modules',
);

$wgResourceModules += array(
	'ext.visualEditor.wikiaViewPageTarget.init' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => 've/init/ve.init.mw.WikiaViewPageTarget.init.js',
		'dependencies' => array(
			'jquery.client',
			'jquery.byteLength',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options'
		),
		'messages' => array(
			'wikia-visualeditor-loading'
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
			've/ve.track.js',

			// dm
			've/dm/ve.dm.WikiaMediaCaptionNode.js',
			've/dm/ve.dm.WikiaVideoCaptionNode.js',
			've/dm/ve.dm.WikiaImageCaptionNode.js',
			've/dm/ve.dm.WikiaBlockMediaNode.js',
			've/dm/ve.dm.WikiaBlockImageNode.js',
			've/dm/ve.dm.WikiaBlockVideoNode.js',
			've/dm/ve.dm.WikiaInlineVideoNode.js',
			've/dm/ve.dm.WikiaCart.js',
			've/dm/ve.dm.WikiaCartItem.js',

			// ce
			've/ce/ve.ce.WikiaMediaCaptionNode.js',
			've/ce/ve.ce.WikiaVideoCaptionNode.js',
			've/ce/ve.ce.WikiaImageCaptionNode.js',
			've/ce/ve.ce.WikiaBlockMediaNode.js',
			've/ce/ve.ce.WikiaBlockImageNode.js',
			've/ce/ve.ce.WikiaVideoNode.js',
			've/ce/ve.ce.WikiaBlockVideoNode.js',
			've/ce/ve.ce.WikiaInlineVideoNode.js',

			// ui
			've/ui/ve.ui.WikiaCommandRegistry.js',
			've/ui/dialogs/ve.ui.WikiaMediaEditDialog.js',
			've/ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaReferenceDialog.js',
			've/ui/dialogs/ve.ui.WikiaSaveDialog.js',
			've/ui/dialogs/ve.ui.WikiaSourceModeDialog.js',
			've/ui/tools/ve.ui.WikiaDialogTool.js',
			've/ui/tools/ve.ui.WikiaHelpTool.js',
			've/ui/tools/ve.ui.WikiaMWGalleryInspectorTool.js',
			've/ui/tools/ve.ui.WikiaMWLinkInspectorTool.js',
			've/ui/widgets/ve.ui.WikiaCartWidget.js',
			've/ui/widgets/ve.ui.WikiaCartItemWidget.js',
			've/ui/widgets/ve.ui.WikiaDimensionsWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaPageWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaSelectWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaResultsWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaQueryWidget.js',
			've/ui/widgets/ve.ui.WikiaUploadWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaPreviewWidget.js',
			've/ui/widgets/ve.ui.WikiaDropTargetWidget.js',
			've/ui/widgets/ve.ui.WikiaFocusWidget.js'
		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'videohandler-video-views',
			'wikia-visualeditor-preference-enable',
			'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip',
			'wikia-visualeditor-dialog-wikiamediainsert-insert-button',
			'wikia-visualeditor-dialog-wikiamediainsert-item-license-label',
			'wikia-visualeditor-dialog-wikiamediainsert-item-title-label',
			'wikia-visualeditor-dialog-wikiamediainsert-item-remove-button',
			'wikia-visualeditor-dialog-wikiamediainsert-upload-label',
			'wikia-visualeditor-dialog-wikiamediainsert-upload-button',
			'wikia-visualeditor-dialog-wikiamediainsert-upload-error',
			'wikia-visualeditor-dialog-wikiamediainsert-search-input-placeholder',
			'wikia-visualeditor-dialog-wikiamediainsert-preview-alert',
			'wikia-visualeditor-dialog-wikiamediainsert-upload-error-size',
			'wikia-visualeditor-dialog-wikiamediainsert-upload-error-filetype',
			'wikia-visualeditor-dialog-wikiamediainsert-policy-message',
			'wikia-visualeditor-dialog-wikiamediainsert-read-more',
			'wikia-visualeditor-dialog-drop-target-callout',
			'wikia-visualeditor-help-label',
			'wikia-visualeditor-help-link',
			'wikia-visualeditor-beta-warning',
			'wikia-visualeditor-wikitext-warning',
			'wikia-visualeditor-aliennode-tooltip',
			'wikia-visualeditor-dialog-transclusion-title',
			'wikia-visualeditor-dialogbutton-transclusion-tooltip',
			'wikia-visualeditor-savedialog-label-save',
			'wikia-visualeditor-savedialog-label-restore',
			'wikia-visualeditor-toolbar-savedialog',
			'visualeditor-descriptionpagelink',
			'wikia-visualeditor-dialogbutton-wikiasourcemode-tooltip',
			'wikia-visualeditor-dialog-wikiasourcemode-title',
			'wikia-visualeditor-dialog-wikiasourcemode-apply-button',
			'wikia-visualeditor-dialog-wikiasourcemode-help-link',
			'wikia-visualeditor-dialog-wikiasourcemode-help-text',
			'wikia-visualeditor-notification-media-must-be-logged-in',
			'wikia-visualeditor-notification-media-only-premium-videos-allowed',
			'wikia-visualeditor-notification-media-query-failed',
			'wikia-visualeditor-notification-media-permission-denied',
			'wikia-visualeditor-notification-video-preview-not-available',
			'accesskey-save',
		),
		'dependencies' => array(
			'ext.visualEditor.core.desktop',
			'ext.visualEditor.mwimage',
			'ext.visualEditor.mwmeta',
		)
	),
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikiaCore';

/* Messages */

$wgExtensionMessagesFiles['VisualEditorWikia'] = $dir . 'VisualEditor.i18n.php';

/* Hooks */

$wgHooks['GetPreferences'][] = 'VisualEditorWikiaHooks::onGetPreferences';
$wgHooks['ResourceLoaderTestModules'][] = 'VisualEditorWikiaHooks::onResourceLoaderTestModules';
$wgHooks['MakeGlobalVariablesScript'][] = 'VisualEditorWikiaHooks::onMakeGlobalVariablesScript';
