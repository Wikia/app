<?php
/**
 * WikiEditor extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Nimish Gautam <nimish@wikimedia.org>
 * @author Adam Miller <amiller@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.3.1
 */

/* Configuration */

// Each module may be configured individually to be globally on/off or user preference based
$wgWikiEditorFeatures = array(

	/* Textarea / i-frame compatible (OK to deploy) */

	'toolbar' => array( 'global' => false, 'user' => true ),
	// Provides interactive tools
	'dialogs' => array( 'global' => false, 'user' => true ),
	// Hide signature button from main namespace
	'hidesig' => array( 'global' => true, 'user' => false ),

	/* Textarea / i-frame compatible, but still experimental and unstable (do not deploy!) */

	// Adds a tab for previewing in-line
	'preview' => array( 'global' => false, 'user' => true ),
	// Adds a button for previewing in a dialog
	'previewDialog' => array( 'global' => false, 'user' => false ),
	//  Adds a button and dialog for step-by-step publishing
	'publish' => array( 'global' => false, 'user' => true ),

	/* I-frame dependent (do not deploy!) */

	// Failry stable table of contents
	'toc' => array( 'global' => false, 'user' => true ),
	// Pretty broken template collapsing/editing
	'templateEditor' => array( 'global' => false, 'user' => false ),
	// Bare-bones (probably broken) template collapsing
	'templates' => array( 'global' => false, 'user' => false ),

);

// If set to true and the ClickTracking extension is installed, track clicks
// on the toolbar buttons
$wgWikiEditorToolbarClickTracking = false;

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WikiEditor',
	'author' => array( 'Trevor Parscal', 'Roan Kattouw', 'Nimish Gautam', 'Adam Miller' ),
	'version' => '0.3.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiEditor',
	'descriptionmsg' => 'wikieditor-desc',
);
$wgAutoloadClasses['WikiEditorHooks'] = dirname( __FILE__ ) . '/WikiEditor.hooks.php';
$wgExtensionMessagesFiles['WikiEditor'] = dirname( __FILE__ ) . '/WikiEditor.i18n.php';
$wgHooks['EditPage::showEditForm:initial'][] = 'WikiEditorHooks::editPageShowEditFormInitial';
$wgHooks['GetPreferences'][] = 'WikiEditorHooks::getPreferences';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'WikiEditorHooks::resourceLoaderGetConfigVars';
$wgHooks['MakeGlobalVariablesScript'][] = 'WikiEditorHooks::makeGlobalVariablesScript';
$wgHooks['EditPageBeforeEditToolbar'][] = 'WikiEditorHooks::EditPageBeforeEditToolbar';

$wikiEditorTpl = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'WikiEditor/modules',
	'group' => 'ext.wikiEditor',
);

$wgResourceModules += array(
	/* Third-party modules */

	'contentCollector' => $wikiEditorTpl + array(
		'scripts' => 'contentCollector.js',
	),

	/* WikiEditor jQuery plugin Resources */

	'jquery.wikiEditor' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.js',
		'styles' => 'jquery.wikiEditor.css',
		'dependencies' => array(
			'jquery.client',
			'jquery.textSelection',
			'jquery.delayedBind',
		),
		'messages' => array(
			'wikieditor-wikitext-tab',
			'wikieditor-loading',
		),
	),
	'jquery.wikiEditor.iframe' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.iframe.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'contentCollector',
		),
	),
	'jquery.wikiEditor.dialogs' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.dialogs.js',
		'styles' => 'jquery.wikiEditor.dialogs.css',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.toolbar',
			'jquery.ui.dialog',
			'jquery.ui.button',
			'jquery.ui.draggable',
			'jquery.ui.resizable',
			'jquery.tabIndex',
		),
	),
	'jquery.wikiEditor.dialogs.config' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.dialogs.config.js',
		'styles' => 'jquery.wikiEditor.dialogs.config.css',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.dialogs',
			'jquery.wikiEditor.toolbar.i18n',
			'jquery.suggestions',
		),
	),
	'jquery.wikiEditor.highlight' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.highlight.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.iframe',
		),
	),
	'jquery.wikiEditor.preview' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.preview.js',
		'styles' => 'jquery.wikiEditor.preview.css',
		'dependencies' => 'jquery.wikiEditor',
	),
	'jquery.wikiEditor.previewDialog' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.previewDialog.js',
		'styles' => 'jquery.wikiEditor.previewDialog.css',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.dialogs',
		),
	),
	'jquery.wikiEditor.publish' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.publish.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.dialogs',
		),
	),
	'jquery.wikiEditor.templateEditor' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.templateEditor.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.iframe',
			'jquery.wikiEditor.dialogs',
		),
	),
	'jquery.wikiEditor.templates' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.templates.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.iframe',
		),
	),
	'jquery.wikiEditor.toc' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.toc.js',
		'styles' => 'jquery.wikiEditor.toc.css',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.iframe',
			'jquery.ui.draggable',
			'jquery.ui.resizable',
			'jquery.autoEllipsis',
			'jquery.color',
		),
	),
	'jquery.wikiEditor.toolbar' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.toolbar.js',
		'styles' => 'jquery.wikiEditor.toolbar.css',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.toolbar.i18n',
		),
	),
	'jquery.wikiEditor.toolbar.config' => $wikiEditorTpl + array(
		'scripts' => 'jquery.wikiEditor.toolbar.config.js',
		'dependencies' => array(
			'jquery.wikiEditor',
			'jquery.wikiEditor.toolbar.i18n',
			'jquery.wikiEditor.toolbar',
			'jquery.cookie',
			'jquery.async',
		)
	),
	'jquery.wikiEditor.toolbar.i18n' => $wikiEditorTpl + array(
		'messages' => array(
			// This is a mixed bunch that needs to be separated between dialog and toolbar messages,
			// but since both the dialog and toolbar config have this as dependency, it's not urgent
			'wikieditor-toolbar-loading',
			/* Main Section */
			'wikieditor-toolbar-tool-bold',
			'wikieditor-toolbar-tool-bold-example',
			'wikieditor-toolbar-tool-italic',
			'wikieditor-toolbar-tool-italic-example',
			'wikieditor-toolbar-tool-ilink',
			'wikieditor-toolbar-tool-ilink-example',
			'wikieditor-toolbar-tool-xlink',
			'wikieditor-toolbar-tool-xlink-example',
			'wikieditor-toolbar-tool-link',
			'wikieditor-toolbar-tool-link-title',
			'wikieditor-toolbar-tool-link-int',
			'wikieditor-toolbar-tool-link-int-target',
			'wikieditor-toolbar-tool-link-int-target-tooltip',
			'wikieditor-toolbar-tool-link-int-text',
			'wikieditor-toolbar-tool-link-int-text-tooltip',
			'wikieditor-toolbar-tool-link-ext',
			'wikieditor-toolbar-tool-link-ext-target',
			'wikieditor-toolbar-tool-link-ext-text',
			'wikieditor-toolbar-tool-link-insert',
			'wikieditor-toolbar-tool-link-cancel',
			'wikieditor-toolbar-tool-link-int-target-status-exists',
			'wikieditor-toolbar-tool-link-int-target-status-notexists',
			'wikieditor-toolbar-tool-link-int-target-status-invalid',
			'wikieditor-toolbar-tool-link-int-target-status-external',
			'wikieditor-toolbar-tool-link-int-target-status-loading',
			'wikieditor-toolbar-tool-link-int-invalid',
			'wikieditor-toolbar-tool-link-lookslikeinternal',
			'wikieditor-toolbar-tool-link-lookslikeinternal-int',
			'wikieditor-toolbar-tool-link-lookslikeinternal-ext',
			'wikieditor-toolbar-tool-link-empty',
			'wikieditor-toolbar-tool-file',
			'wikieditor-toolbar-tool-file-example',
			'wikieditor-toolbar-tool-file-pre',
			'wikieditor-toolbar-tool-reference',
			'wikieditor-toolbar-tool-reference-title',
			'wikieditor-toolbar-tool-reference-cancel',
			'wikieditor-toolbar-tool-reference-text',
			'wikieditor-toolbar-tool-reference-insert',
			'wikieditor-toolbar-tool-reference-example',
			'wikieditor-toolbar-tool-signature',
			/* Formatting Section */
			'wikieditor-toolbar-section-advanced',
			'wikieditor-toolbar-tool-heading',
			'wikieditor-toolbar-tool-heading-1',
			'wikieditor-toolbar-tool-heading-2',
			'wikieditor-toolbar-tool-heading-3',
			'wikieditor-toolbar-tool-heading-4',
			'wikieditor-toolbar-tool-heading-5',
			'wikieditor-toolbar-tool-heading-example',
			'wikieditor-toolbar-group-format',
			'wikieditor-toolbar-tool-ulist',
			'wikieditor-toolbar-tool-ulist-example',
			'wikieditor-toolbar-tool-olist',
			'wikieditor-toolbar-tool-olist-example',
			'wikieditor-toolbar-tool-indent',
			'wikieditor-toolbar-tool-indent-example',
			'wikieditor-toolbar-tool-nowiki',
			'wikieditor-toolbar-tool-nowiki-example',
			'wikieditor-toolbar-tool-redirect',
			'wikieditor-toolbar-tool-redirect-example',
			'wikieditor-toolbar-tool-big',
			'wikieditor-toolbar-tool-big-example',
			'wikieditor-toolbar-tool-small',
			'wikieditor-toolbar-tool-small-example',
			'wikieditor-toolbar-tool-superscript',
			'wikieditor-toolbar-tool-superscript-example',
			'wikieditor-toolbar-tool-subscript',
			'wikieditor-toolbar-tool-subscript-example',
			'wikieditor-toolbar-group-insert',
			'wikieditor-toolbar-tool-gallery',
			'wikieditor-toolbar-tool-gallery-example',
			'wikieditor-toolbar-tool-newline',
			'wikieditor-toolbar-tool-table',
			'wikieditor-toolbar-tool-table-example-old',
			'wikieditor-toolbar-tool-table-example-cell-text',
			'wikieditor-toolbar-tool-table-example',
			'wikieditor-toolbar-tool-table-example-header',
			'wikieditor-toolbar-tool-table-title',
			'wikieditor-toolbar-tool-table-dimensions-rows',
			'wikieditor-toolbar-tool-table-dimensions-columns',
			'wikieditor-toolbar-tool-table-dimensions-header',
			'wikieditor-toolbar-tool-table-wikitable',
			'wikieditor-toolbar-tool-table-sortable',
			'wikieditor-toolbar-tool-table-insert',
			'wikieditor-toolbar-tool-table-cancel',
			'wikieditor-toolbar-tool-table-example-text',
			'wikieditor-toolbar-tool-table-toomany',
			'wikieditor-toolbar-tool-table-invalidnumber',
			'wikieditor-toolbar-tool-table-zero',
			'wikieditor-toolbar-tool-replace',
			'wikieditor-toolbar-tool-replace-title',
			'wikieditor-toolbar-tool-replace-search',
			'wikieditor-toolbar-tool-replace-replace',
			'wikieditor-toolbar-tool-replace-case',
			'wikieditor-toolbar-tool-replace-regex',
			'wikieditor-toolbar-tool-replace-button-findnext',
			'wikieditor-toolbar-tool-replace-button-replace',
			'wikieditor-toolbar-tool-replace-button-replaceall',
			'wikieditor-toolbar-tool-replace-close',
			'wikieditor-toolbar-tool-replace-nomatch',
			'wikieditor-toolbar-tool-replace-success',
			'wikieditor-toolbar-tool-replace-emptysearch',
			'wikieditor-toolbar-tool-replace-invalidregex',
			/* Special Characters Section */
			'wikieditor-toolbar-section-characters',
			'wikieditor-toolbar-characters-page-latin',
			'wikieditor-toolbar-characters-page-latinextended',
			'wikieditor-toolbar-characters-page-ipa',
			'wikieditor-toolbar-characters-page-symbols',
			'wikieditor-toolbar-characters-page-greek',
			'wikieditor-toolbar-characters-page-cyrillic',
			'wikieditor-toolbar-characters-page-arabic',
			'wikieditor-toolbar-characters-page-arabicextended',
			'wikieditor-toolbar-characters-page-persian',
			'wikieditor-toolbar-characters-page-hebrew',
			'wikieditor-toolbar-characters-page-bangla',
			'wikieditor-toolbar-characters-page-tamil',
			'wikieditor-toolbar-characters-page-telugu',
			'wikieditor-toolbar-characters-page-sinhala',
			'wikieditor-toolbar-characters-page-gujarati',
			'wikieditor-toolbar-characters-page-thai',
			'wikieditor-toolbar-characters-page-lao',
			'wikieditor-toolbar-characters-page-khmer',
			/* Help Section */
			'wikieditor-toolbar-section-help',
			'wikieditor-toolbar-help-heading-description',
			'wikieditor-toolbar-help-heading-syntax',
			'wikieditor-toolbar-help-heading-result',
			'wikieditor-toolbar-help-page-format',
			'wikieditor-toolbar-help-page-link',
			'wikieditor-toolbar-help-page-heading',
			'wikieditor-toolbar-help-page-list',
			'wikieditor-toolbar-help-page-file',
			'wikieditor-toolbar-help-page-reference',
			'wikieditor-toolbar-help-page-discussion',
			'wikieditor-toolbar-help-content-bold-description',
			'wikieditor-toolbar-help-content-bold-syntax',
			'wikieditor-toolbar-help-content-bold-result',
			'wikieditor-toolbar-help-content-italic-description',
			'wikieditor-toolbar-help-content-italic-syntax',
			'wikieditor-toolbar-help-content-italic-result',
			'wikieditor-toolbar-help-content-bolditalic-description',
			'wikieditor-toolbar-help-content-bolditalic-syntax',
			'wikieditor-toolbar-help-content-bolditalic-result',
			'wikieditor-toolbar-help-content-ilink-description',
			'wikieditor-toolbar-help-content-ilink-syntax',
			'wikieditor-toolbar-help-content-ilink-result',
			'wikieditor-toolbar-help-content-xlink-description',
			'wikieditor-toolbar-help-content-xlink-syntax',
			'wikieditor-toolbar-help-content-xlink-result',
			'wikieditor-toolbar-help-content-heading1-description',
			'wikieditor-toolbar-help-content-heading1-syntax',
			'wikieditor-toolbar-help-content-heading1-result',
			'wikieditor-toolbar-help-content-heading2-description',
			'wikieditor-toolbar-help-content-heading2-syntax',
			'wikieditor-toolbar-help-content-heading2-result',
			'wikieditor-toolbar-help-content-heading3-description',
			'wikieditor-toolbar-help-content-heading3-syntax',
			'wikieditor-toolbar-help-content-heading3-result',
			'wikieditor-toolbar-help-content-heading4-description',
			'wikieditor-toolbar-help-content-heading4-syntax',
			'wikieditor-toolbar-help-content-heading4-result',
			'wikieditor-toolbar-help-content-heading5-description',
			'wikieditor-toolbar-help-content-heading5-syntax',
			'wikieditor-toolbar-help-content-heading5-result',
			'wikieditor-toolbar-help-content-ulist-description',
			'wikieditor-toolbar-help-content-ulist-syntax',
			'wikieditor-toolbar-help-content-ulist-result',
			'wikieditor-toolbar-help-content-olist-description',
			'wikieditor-toolbar-help-content-olist-syntax',
			'wikieditor-toolbar-help-content-olist-result',
			'wikieditor-toolbar-help-content-file-description',
			'wikieditor-toolbar-help-content-file-syntax',
			'wikieditor-toolbar-help-content-file-result',
			'wikieditor-toolbar-help-content-reference-description',
			'wikieditor-toolbar-help-content-reference-syntax',
			'wikieditor-toolbar-help-content-reference-result',
			'wikieditor-toolbar-help-content-rereference-description',
			'wikieditor-toolbar-help-content-rereference-syntax',
			'wikieditor-toolbar-help-content-rereference-result',
			'wikieditor-toolbar-help-content-showreferences-description',
			'wikieditor-toolbar-help-content-showreferences-syntax',
			'wikieditor-toolbar-help-content-showreferences-result',
			'wikieditor-toolbar-help-content-signaturetimestamp-description',
			'wikieditor-toolbar-help-content-signaturetimestamp-syntax',
			'wikieditor-toolbar-help-content-signaturetimestamp-result',
			'wikieditor-toolbar-help-content-signature-description',
			'wikieditor-toolbar-help-content-signature-syntax',
			'wikieditor-toolbar-help-content-signature-result',
			'wikieditor-toolbar-help-content-indent-description',
			'wikieditor-toolbar-help-content-indent-syntax',
			'wikieditor-toolbar-help-content-indent-result',
		),
	),

	/* WikiEditor Resources */

	'ext.wikiEditor' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.js',
		'styles' => 'ext.wikiEditor.css',
		'dependencies' => 'jquery.wikiEditor',
	),
	'ext.wikiEditor.dialogs' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.dialogs.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'ext.wikiEditor.toolbar',
			'jquery.wikiEditor.dialogs',
			'jquery.wikiEditor.dialogs.config',
		),
	),
	'ext.wikiEditor.highlight' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.highlight.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'jquery.wikiEditor.highlight',
		),
	),
	'ext.wikiEditor.preview' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.preview.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'jquery.wikiEditor.preview',
		),
		'messages' => array(
			'wikieditor-preview-tab',
			'wikieditor-preview-changes-tab',
			'wikieditor-preview-loading',
		),
	),
	'ext.wikiEditor.previewDialog' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.previewDialog.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'jquery.wikiEditor.previewDialog',
		),
		'messages' => array(
			'wikieditor-previewDialog-preference',
			'wikieditor-previewDialog-tab',
			'wikieditor-previewDialog-loading',
		),
	),
	'ext.wikiEditor.publish' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.publish.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'jquery.wikiEditor.publish',
		),
		'messages' => array(
			'wikieditor-publish-button-publish',
			'wikieditor-publish-button-cancel',
			'wikieditor-publish-dialog-title',
			'wikieditor-publish-dialog-summary',
			'wikieditor-publish-dialog-minor',
			'wikieditor-publish-dialog-watch',
			'wikieditor-publish-dialog-publish',
			'wikieditor-publish-dialog-goback',
		),
	),
	'ext.wikiEditor.templateEditor' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.templateEditor.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'ext.wikiEditor.highlight',
			'jquery.wikiEditor.templateEditor',
		),
		'messages' => array(
			'wikieditor-template-editor-dialog-title',
			'wikieditor-template-editor-dialog-submit',
			'wikieditor-template-editor-dialog-cancel',
		),
	),
	'ext.wikiEditor.templates' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.templates.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'ext.wikiEditor.highlight',
			'jquery.wikiEditor.templates',
		),
	),
	'ext.wikiEditor.toc' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.toc.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'ext.wikiEditor.highlight',
			'jquery.wikiEditor.toc',
		),
		'messages' => array(
			'wikieditor-toc-show',
			'wikieditor-toc-hide',
		),
	),
	'ext.wikiEditor.tests.toolbar' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.tests.toolbar.js',
		'dependencies' => 'ext.wikiEditor.toolbar',
	),
	'ext.wikiEditor.toolbar' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.toolbar.js',
		'dependencies' => array(
			'ext.wikiEditor',
			'jquery.wikiEditor.toolbar',
			'jquery.wikiEditor.toolbar.config',
		)
	),
	'ext.wikiEditor.toolbar.hideSig' => $wikiEditorTpl + array(
		'scripts' => 'ext.wikiEditor.toolbar.hideSig.js',
	),
);
