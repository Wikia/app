<?php

$dir = dirname( __FILE__ ) . '/';

/* Resource Loader Modules */

$wgVisualEditorWikiaResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'VisualEditor/wikia/modules',
);


$wgResourceModules += array(
	// Based on ext.visualEditor.viewPageTarget.init
	'ext.visualEditor.wikia.viewPageTarget.init' => $wgVisualEditorWikiaResourceTemplate + array(
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
		'messages' => array(
			'wikia-visualeditor-loading'
		),
		'position' => 'top'
	),
	'ext.visualEditor.wikia.oasisViewPageTarget' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			've/init/ve.init.wikia.js',
			've/init/ve.init.wikia.ViewPageTarget.js'
		),
		'styles' => array(
			've/init/styles/ve.init.wikia.ViewPageTarget.css'
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		)
	),
	'ext.visualEditor.wikia.venusViewPageTarget' => $wgVisualEditorWikiaResourceTemplate + array(
		// placeholder to establish naming scheme
	),
	'ext.visualEditor.wikia.core' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			've/ve.track.js',

			// dm
			've/dm/ve.dm.WikiaBlockMediaNode.js',
			've/dm/ve.dm.WikiaBlockVideoNode.js',
			've/dm/ve.dm.WikiaMediaCaptionNode.js',
			've/dm/ve.dm.WikiaVideoCaptionNode.js',

			// ce
			've/ce/ve.ce.WikiaVideoNode.js',
			've/ce/ve.ce.WikiaBlockMediaNode.js',
			've/ce/ve.ce.WikiaBlockVideoNode.js',
			've/ce/ve.ce.WikiaMediaCaptionNode.js',
			've/ce/ve.ce.WikiaVideoCaptionNode.js',

			// ui
			've/ui/ve.ui.WikiaCommandRegistry.js',
			've/ui/dialogs/ve.ui.WikiaSourceModeDialog.js',
			've/ui/tools/ve.ui.WikiaDialogTool.js',
			've/ui/widgets/ve.ui.WikiaFocusWidget.js',
		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'videohandler-video-views',
			'wikia-visualeditor-preference-enable',
			'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip',
			'wikia-visualeditor-dialogbutton-wikiamapinsert-tooltip',
			'wikia-visualeditor-dialog-wikiamapinsert-create-button',
			'wikia-visualeditor-dialog-wikiamapinsert-headline',
			'wikia-visualeditor-dialog-wikiamapinsert-empty-headline',
			'wikia-visualeditor-dialog-wikiamapinsert-empty-text',
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
			'wikia-visualeditor-dialog-transclusion-filter',
			'wikia-visualeditor-dialogbutton-transclusion-tooltip',
			'wikia-visualeditor-dialog-transclusion-zerostate',
			'wikia-visualeditor-savedialog-label-save',
			'wikia-visualeditor-savedialog-label-restore',
			'wikia-visualeditor-toolbar-savedialog',
			'wikia-visualeditor-toolbar-cancel',
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
			'wikia-visualeditor-dialog-orientation-headline',
			'wikia-visualeditor-dialog-orientation-text',
			'wikia-visualeditor-dialog-orientation-start-button',
			'wikia-visualeditor-dialog-meta-languages-readonlynote',
			'wikia-visualeditor-dialog-transclusion-no-template-description',
			'wikia-visualeditor-dialog-map-insert-title',
			'wikia-visualeditor-save-error-generic',
			'wikia-visualeditor-dialogbutton-wikiasourcemode',
			'wikia-visualeditor-dialog-done-button',
			'wikia-visualeditor-dialog-cancel-button',
			'wikia-visualeditor-dialog-transclusion-get-info',
			'wikia-visualeditor-dialog-transclusion-preview-button',
			'wikia-visualeditor-context-transclusion-description',
			'wikia-visualeditor-dialog-wikiatemplateinsert-search',
			'wikia-visualeditor-wikiatemplateoptionwidget-appears',
			'wikia-visualeditor-dialog-template-insert-title',
			'wikia-visualeditor-dialog-preference-headline',
			'wikia-visualeditor-dialog-preference-text',
			'wikia-visualeditor-dialog-preference-link-help',
			'wikia-visualeditor-dialog-preference-link-preferences',
			'wikia-visualeditor-dialog-preference-start-button',
			'wikia-visualeditor-dialogbutton-wikiasinglemedia-tooltip',
			'wikia-visualeditor-dialog-wikiasinglemedia-title',
			'wikia-visualeditor-dialog-wikiasinglemedia-search',
			'wikia-visualeditor-wikiamediaoptionwidget-preview-photo',
			'wikia-visualeditor-wikiamediaoptionwidget-preview-video',
			'wikia-visualeditor-media-photo-policy',
			'wikia-visualeditor-media-video-policy',
		),
		'dependencies' => array(
			'ext.visualEditor.core.desktop',
			'ext.visualEditor.mwimage',
			'ext.visualEditor.mwmeta',
		)
	),
);

$wgVisualEditorPluginModules[] = 'ext.visualEditor.wikia.core';

/* Messages */

$wgExtensionMessagesFiles['VisualEditorWikia'] = $dir . 'VisualEditor.i18n.php';

