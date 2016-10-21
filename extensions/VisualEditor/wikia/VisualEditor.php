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
$wgAutoloadClasses['ApiAddMedia'] = $dir . 'ApiAddMedia.php';
$wgAutoloadClasses['ApiAddMediaTemporary'] = $dir . 'ApiAddMediaTemporary.php';
$wgAutoloadClasses['ApiAddMediaPermanent'] = $dir . 'ApiAddMediaPermanent.php';
$wgAutoloadClasses['ApiVideoPreview'] = $dir . 'ApiVideoPreview.php';
$wgAutoloadClasses['ApiTemplateSearch'] = $dir . 'ApiTemplateSearch.php';
$wgAutoloadClasses['ApiTemplateSuggestions'] = $dir . 'ApiTemplateSuggestions.php';
$wgAutoloadClasses['ApiTemplateParameters'] = $dir . 'ApiTemplateParameters.php';

/* API Modules */

$wgAPIModules['apimediasearch'] = 'ApiMediaSearch';
$wgAPIModules['addmediatemporary'] = 'ApiAddMediaTemporary';
$wgAPIModules['addmediapermanent'] = 'ApiAddMediaPermanent';
$wgAPIModules['videopreview'] = 'ApiVideoPreview';
$wgAPIModules['templatesearch'] = 'ApiTemplateSearch';
$wgAPIModules['templatesuggestions'] = 'ApiTemplateSuggestions';
$wgAPIModules['templateparameters'] = 'ApiTemplateParameters';

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
			'wikia-visualeditor-loading',
			'accesskey-ca-editsource',
			'accesskey-ca-ve-edit',
			'accesskey-save',
			'pipe-separator',
			'tooltip-ca-createsource',
			'tooltip-ca-editsource',
			'tooltip-ca-ve-edit',
			'visualeditor-ca-editsource-section',
		),
		'position' => 'top'
	),
	'ext.visualEditor.wikia.oasisViewPageTarget' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			've/init/ve.init.wikia.js',
			've/init/ve.init.wikia.ViewPageTarget.js',
			've/init/ve.init.wikia.TargetEvents.js',
		),
		'styles' => array(
			've/init/styles/ve.init.wikia.ViewPageTarget.css'
		),
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget'
		)
	),
	'ext.visualEditor.wikia.core' => $wgVisualEditorWikiaResourceTemplate + array(
		'scripts' => array(
			've/ve.track.js',

			// dm
			've/dm/ve.dm.WikiaBlockMediaNode.js',
			've/dm/ve.dm.WikiaBlockVideoNode.js',
			've/dm/ve.dm.WikiaMediaCaptionNode.js',
			've/dm/ve.dm.WikiaVideoCaptionNode.js',
			've/dm/ve.dm.WikiaInlineVideoNode.js',
			've/dm/ve.dm.WikiaBlockImageNode.js',
			've/dm/ve.dm.WikiaImageCaptionNode.js',
			've/dm/ve.dm.WikiaCart.js',
			've/dm/ve.dm.WikiaCartItem.js',
			've/dm/ve.dm.WikiaImageCartItem.js',
			've/dm/ve.dm.WikiaGalleryItemCaptionNode.js',
			've/dm/ve.dm.WikiaGalleryItemNode.js',
			've/dm/ve.dm.WikiaGalleryNode.js',
			've/dm/ve.dm.WikiaMapNode.js',
			've/dm/ve.dm.WikiaTransclusionModel.js',
			've/dm/ve.dm.WikiaTemplateModel.js',
			've/dm/ve.dm.WikiaInfoboxTransclusionBlockNode.js',
			've/dm/ve.dm.WikiaInfoboxSpecModel.js',

			// ce
			've/ce/ve.ce.WikiaVideoNode.js',
			've/ce/ve.ce.WikiaBlockMediaNode.js',
			've/ce/ve.ce.WikiaBlockVideoNode.js',
			've/ce/ve.ce.WikiaMediaCaptionNode.js',
			've/ce/ve.ce.WikiaVideoCaptionNode.js',
			've/ce/ve.ce.WikiaInlineVideoNode.js',
			've/ce/ve.ce.WikiaBlockImageNode.js',
			've/ce/ve.ce.WikiaImageCaptionNode.js',
			've/ce/ve.ce.WikiaGalleryItemCaptionNode.js',
			've/ce/ve.ce.WikiaGalleryItemNode.js',
			've/ce/ve.ce.WikiaGalleryNode.js',
			've/ce/ve.ce.WikiaMapNode.js',
			've/ce/ve.ce.WikiaInfoboxTransclusionBlockNode.js',

			// ui
			've/ui/ve.ui.WikiaCommandRegistry.js',
			've/ui/dialogs/ve.ui.WikiaSourceModeDialog.js',
			've/ui/dialogs/ve.ui.WikiaMediaInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaImageInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaVideoInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaSingleMediaDialog.js',
			've/ui/dialogs/ve.ui.WikiaMapInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaInfoboxInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaInfoboxDialog.js',
			've/ui/dialogs/ve.ui.WikiaInfoboxBuilderDialog.js',
			've/ui/dialogs/ve.ui.WikiaTemplateInsertDialog.js',
			've/ui/dialogs/ve.ui.WikiaTransclusionDialog.js',
			've/ui/tools/ve.ui.WikiaDialogTool.js',
			've/ui/tools/ve.ui.WikiaHelpTool.js',
			've/ui/tools/ve.ui.WikiaInfoboxDialogTool.js',
			've/ui/widgets/ve.ui.WikiaFocusWidget.js',
			've/ui/widgets/ve.ui.WikiaCartWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaQueryWidget.js',
			've/ui/widgets/ve.ui.WikiaUploadWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaResultsWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaSelectWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaPhotoOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaVideoOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaCartItemWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaPageWidget.js',
			've/ui/widgets/ve.ui.WikiaDropTargetWidget.js',
			've/ui/widgets/ve.ui.WikiaMediaPreviewWidget.js',
			've/ui/widgets/ve.ui.WikiaSingleMediaQueryWidget.js',
			've/ui/widgets/ve.ui.WikiaSingleMediaCartWidget.js',
			've/ui/widgets/ve.ui.WikiaSingleMediaCartSelectWidget.js',
			've/ui/widgets/ve.ui.WikiaSingleMediaCartOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaMapOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaTemplateSearchWidget.js',
			've/ui/widgets/ve.ui.WikiaTemplateOptionWidget.js',
			've/ui/widgets/ve.ui.WikiaTemplateGetInfoWidget.js',
			've/ui/widgets/ve.ui.WikiaInsertInfoboxEmptyStateWidget.js',
			've/ui/pages/ve.ui.WikiaParameterPage.js',

		),
		'messages' => array(
			'oasis-content-picture-added-by',
			'videohandler-video-views',
			'wikia-visualeditor-dialog-image-insert-title',
			'wikia-visualeditor-dialog-video-insert-title',
			'wikia-visualeditor-preference-enable',
			'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip',
			'wikia-visualeditor-dialogbutton-imageinsert-tooltip',
			'wikia-visualeditor-dialogbutton-videoinsert-tooltip',
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
			'wikia-visualeditor-dialogbutton-infobox-tooltip',
			'wikia-visualeditor-dialog-transclusion-zerostate',
			'wikia-visualeditor-dialog-infobox-insert-title',
			'wikia-visualeditor-dialog-infobox-insert-add-new-template',
			'wikia-visualeditor-dialog-infobox-insert-empty-state',
			'wikia-visualeditor-dialog-infobox-insert-empty-state-has-unconverted-infoboxes',
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

/* Hooks */

$wgHooks['ResourceLoaderTestModules'][] = 'VisualEditorWikiaHooks::onResourceLoaderTestModules';
$wgHooks['MakeGlobalVariablesScript'][] = 'VisualEditorWikiaHooks::onMakeGlobalVariablesScript';

/* Configuration */

$wgDefaultUserOptions['useeditwarning'] = true;

// Disable VE for blog namespaces
if ( !empty( $wgEnableBlogArticles ) ) {
	$tempArray = array();
	foreach ( $wgVisualEditorNamespaces as $key => &$value ) {
		if ( $value === NS_BLOG_ARTICLE || $value === NS_BLOG_ARTICLE_TALK ) {
			continue;
		}
		$tempArray[] = $value;
	}
	$wgVisualEditorNamespaces = $tempArray;
}

// Add additional valid namespaces for Wikia
$wgVisualEditorNamespaces[] = NS_CATEGORY;
$wgVisualEditorNamespaces[] = NS_PROJECT;
