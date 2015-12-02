<?php
/**
 * VisualEditor extension
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor',
	'author' => array(
		'Alex Monk',
		'Bartosz Dziewoński',
		'Christian Williams',
		'David Chan',
		'Ed Sanders',
		'Inez Korczyński',
		'James Forrester',
		'Moriel Schottlender',
		'Roan Kattouw',
		'Rob Moen',
		'Sucheta Ghoshal',
		'Timo Tijhof',
		'Trevor Parscal',
	),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:VisualEditor',
	'descriptionmsg' => 'visualeditor-desc',
	'license-name' => 'MIT',
);

$dir = __DIR__ . '/';

// Register files
$wgAutoloadClasses['ApiVisualEditor'] = $dir . 'ApiVisualEditor.php';
$wgAutoloadClasses['ApiVisualEditorEdit'] = $dir . 'ApiVisualEditorEdit.php';
$wgAutoloadClasses['VisualEditorHooks'] = $dir . 'VisualEditor.hooks.php';
$wgAutoloadClasses['VisualEditorDataModule'] = $dir . 'VisualEditorDataModule.php';
$wgAutoloadClasses['VisualEditorViewPageTargetInitModule'] =
	$dir . 'VisualEditorViewPageTargetInitModule.php';
$wgExtensionMessagesFiles['VisualEditor'] = $dir . 'VisualEditor.i18n.php';
$wgMessagesDirs['VisualEditor'] = array(
	__DIR__ . '/lib/ve/i18n',
	__DIR__ . '/modules/ve-mw/i18n',
	__DIR__ . '/modules/ve-wmf/i18n',
	__DIR__ . '/lib/ve/lib/oojs-ui/i18n'
);

// Register API modules
// Wikia change
/*
$wgAPIModules['visualeditor'] = array(
	'class' => 'ApiVisualEditor',
	'factory' => 'wfVisualEditorApiFactory',
);
$wgAPIModules['visualeditoredit'] = array(
	'class' => 'ApiVisualEditorEdit',
	'factory' => 'wfVisualEditorApiFactory',
);
*/
$wgAPIModules['visualeditor'] = 'ApiVisualEditor';
$wgAPIModules['visualeditoredit'] = 'ApiVisualEditorEdit';

/**
 * @param ApiMain $main
 * @param string $name
 * @return ApiVisualEditor|ApiVisualEditorEdit
 */
function wfVisualEditorApiFactory( $main, $name ) {
	$config = ConfigFactory::getDefaultInstance()->makeConfig( 'visualeditor' );
	$class = $name === 'visualeditor' ? 'ApiVisualEditor' : 'ApiVisualEditorEdit';
	return new $class( $main, $name, $config );
}

// Register Config instance
$wgConfigRegistry['visualeditor'] = 'GlobalVarConfig::newInstance';

// Register Hooks
$wgHooks['BeforePageDisplay'][] = 'VisualEditorHooks::onBeforePageDisplay';
$wgHooks['ContentHandlerDefaultModelFor'][] = 'VisualEditorHooks::onContentHandlerDefaultModelFor';
$wgHooks['DoEditSectionLink'][] = 'VisualEditorHooks::onDoEditSectionLink';
//$wgHooks['GetBetaFeaturePreferences'][] = 'VisualEditorHooks::onGetBetaPreferences';
//$wgHooks['GetPreferences'][] = 'VisualEditorHooks::onGetPreferences';
$wgHooks['ListDefinedTags'][] = 'VisualEditorHooks::onListDefinedTags';
$wgHooks['MakeGlobalVariablesScript'][] = 'VisualEditorHooks::onMakeGlobalVariablesScript';
$wgHooks['RedirectSpecialArticleRedirectParams'][] =
	'VisualEditorHooks::onRedirectSpecialArticleRedirectParams';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'VisualEditorHooks::onResourceLoaderGetConfigVars';
$wgHooks['ResourceLoaderRegisterModules'][] = 'VisualEditorHooks::onResourceLoaderRegisterModules';
$wgHooks['ResourceLoaderTestModules'][] = 'VisualEditorHooks::onResourceLoaderTestModules';
//$wgHooks['SkinTemplateNavigation'][] = 'VisualEditorHooks::onSkinTemplateNavigation';
$wgHooks['ParserTestGlobals'][] = 'VisualEditorHooks::onParserTestGlobals';
$wgHooks['EditPage::showEditForm:fields'][] = 'VisualEditorHooks::onEditPageShowEditFormFields';
$wgHooks['PageContentSaveComplete'][] = 'VisualEditorHooks::onPageContentSaveComplete';
$wgHooks['BeforeInitialize'][] = 'VisualEditorHooks::onBeforeInitialize';
//$wgExtensionFunctions[] = 'VisualEditorHooks::onSetup';

// Register resource modules

$wgVisualEditorResourceTemplate = array(
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'VisualEditor',
);

$wgResourceModules += array(
	'oojs' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'../../resources/lib/oojs/oojs.jquery.js',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),
	'oojs-ui' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'../../resources/lib/oojs-ui/oojs-ui.js',
		),
		'skinScripts' => array(
			'default' => '../../resources/lib/oojs-ui/oojs-ui-mediawiki.js',
		),
		'dependencies' => array(
			'oojs',
			'oojs-ui.styles',
		),
		'messages' => array(
			'ooui-dialog-message-accept',
			'ooui-dialog-message-reject',
			'ooui-dialog-process-continue',
			'ooui-dialog-process-dismiss',
			'ooui-dialog-process-error',
			'ooui-dialog-process-retry',
			'ooui-outline-control-move-down',
			'ooui-outline-control-move-up',
			'ooui-outline-control-remove',
			'ooui-toolbar-more',
			'ooui-toolgroup-collapse',
			'ooui-toolgroup-expand',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),
	'oojs-ui.styles' => $wgVisualEditorResourceTemplate + array(
		'position' => 'top',
		'skinStyles' => array(
			'default' => '../../resources/lib/oojs-ui/oojs-ui-apex.svg.css',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),
	'jquery.visibleText' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/ve/lib/jquery/jquery.visibleText.js',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'Base64.js' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/Base64.js/base64.js',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	// This includes typed arrays and base64 polyfills for IE9
	// All the other polyfills Easy-Deflate provides are
	// already VE requirements.
	'easy-deflate.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/Easy-Deflate/easydeflate.js',
			'lib/Easy-Deflate/typedarrays.js',
		),
		'dependencies' => array(
			'Base64.js'
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'easy-deflate.deflate' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/Easy-Deflate/deflate.js',
		),
		'dependencies' => array(
			'easy-deflate.core'
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'unicodejs' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/ve/lib/unicodejs/unicodejs.js',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	// Back compat alias, can be removed after October 2014 or so
	'unicodejs.wordbreak' => $wgVisualEditorResourceTemplate + array(
		'dependencies' => 'unicodejs'
	),

	'papaparse' => $wgVisualEditorResourceTemplate + array(
		'scripts' => 'lib/ve/lib/papaparse/papaparse.js',
		'targets' => array( 'desktop', 'mobile' ),
	),

	'rangefix' => $wgVisualEditorResourceTemplate + array(
		'scripts' => 'lib/ve/lib/rangefix/rangefix.js',
		'targets' => array( 'desktop', 'mobile' )
	),

	'ext.visualEditor.viewPageTarget.init' => $wgVisualEditorResourceTemplate + array(
		'class' => 'VisualEditorViewPageTargetInitModule',
		'scripts' => 'modules/ve-mw/init/targets/ve.init.mw.ViewPageTarget.init.js',
		'styles' => 'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget.init.css',
		'dependencies' => array(
			'jquery.client',
			'mediawiki.page.startup',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.util',
			'user.options',
			'ext.visualEditor.track',
		),
		'messages' => array(
			'accesskey-ca-editsource',
			'accesskey-ca-ve-edit',
			'accesskey-save',
			'pipe-separator',
			'tooltip-ca-createsource',
			'tooltip-ca-editsource',
			'tooltip-ca-ve-edit',
			'visualeditor-ca-editsource-section',
		),
		'position' => 'top',
	),

	'ext.visualEditor.viewPageTarget.noscript' => $wgVisualEditorResourceTemplate + array(
		'styles' => 'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget.noscript.css',
	),

	'ext.visualEditor.viewPageTarget' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/init/targets/ve.init.mw.ViewPageTarget.js',
		),
		'styles' => array(
			'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget.css',
		),
		'skinStyles' => array(
			'vector' => array(
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-shared.css',
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-vector.css',
			),
			'apex' => array(
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-shared.css',
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-apex.css',
			),
			'monobook' => array(
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-shared.css',
				'modules/ve-mw/init/styles/ve.init.mw.ViewPageTarget-monobook.css',
			)
		),
		'dependencies' => array(
			'ext.visualEditor.base',
			'ext.visualEditor.mediawiki',
			'ext.visualEditor.core.desktop',
			'jquery.placeholder',
			'mediawiki.feedback',
			'mediawiki.jqueryMsg',
			'mediawiki.util',
		),
		'messages' => array(
			// MW core messages
			'creating',
			'editing',
			'lastmodifiedat',
			'parentheses',
			'redirectpagesub',
			'spamprotectionmatch',
			'spamprotectiontext',
			'summary-preview',

			// Messages needed by VE in init phase only (rest go below)
			'postedit-confirmation-created',
			'postedit-confirmation-restored',
			'postedit-confirmation-saved',
			'visualeditor-loadwarning',
			'visualeditor-loadwarning-token',
			'visualeditor-savedialog-identify-anon',
			'visualeditor-savedialog-identify-user',
			'visualeditor-timeout',
		),
	),
	'ext.visualEditor.mobileViewTarget' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/init/targets/ve.init.mw.MobileViewTarget.js',
		),
		'styles' => array(
			'modules/ve-mw/init/styles/ve.init.mw.MobileViewTarget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.base',
			'ext.visualEditor.mediawiki.mobile',
			'ext.visualEditor.core.mobile',
			'ext.visualEditor.mwimage.core',
		),
		'targets' => array( 'mobile' ),
	),

	'ext.visualEditor.ve' => $wgVisualEditorResourceTemplate + array(
		'scripts' => 'lib/ve/src/ve.js',
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.track' => $wgVisualEditorResourceTemplate + array(
		'scripts' => 'lib/ve/src/ve.track.js',
		'dependencies' => 'ext.visualEditor.ve',
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.base' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// ve
			'lib/ve/src/ve.utils.js',
			'lib/ve/src/ve.TriggerListener.js',

			// init
			'lib/ve/src/init/ve.init.js',
			'lib/ve/src/init/ve.init.Platform.js',
			'lib/ve/src/init/ve.init.Target.js',
		),
		'debugScripts' => array(
			'lib/ve/src/ve.debug.js',
		),
		'dependencies' => array(
			'oojs',
			'oojs-ui',
			'unicodejs',
			'rangefix',
			'ext.visualEditor.ve',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mediawiki' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// init
			'modules/ve-mw/init/ve.init.mw.js',
			'modules/ve-mw/init/ve.init.mw.LinkCache.js',
			'modules/ve-mw/init/ve.init.mw.Platform.js',
			'modules/ve-mw/init/ve.init.mw.Target.js',
			'modules/ve-mw/init/ve.init.mw.TargetEvents.js',
			'modules/ve-mw/init/ve.init.mw.trackSubscriber.js',
		),
		'styles' => array(
			'modules/ve-mw/init/styles/ve.init.mw.Target.css',
		),
		'dependencies' => array(
			'jquery.visibleText',
			'jquery.byteLength',
			'jquery.client',
			'mediawiki.api',
			'mediawiki.language',
			'mediawiki.Title',
			'mediawiki.Uri',
			'mediawiki.user',
			'mediawiki.util',
			'easy-deflate.deflate',
			'user.options',
			'user.tokens',
			'ext.visualEditor.base',
			'ext.visualEditor.track',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mediawiki.mobile' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/ui/ve.ui.MWMobileContext.js',
			'modules/ve-mw/ui/ve.ui.MWMobileSurface.js',
		),
		'dependencies' => array(
			'ext.visualEditor.mediawiki',
			'ext.visualEditor.core.mobile',
		),
		'targets' => array( 'mobile' ),
	),

	'ext.visualEditor.standalone' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// init
			'lib/ve/src/init/sa/ve.init.sa.js',
			'lib/ve/src/init/sa/ve.init.sa.Platform.js',
			'lib/ve/src/init/sa/ve.init.sa.Target.js',
		),
		'styles' => array(
			'lib/ve/src/init/sa/styles/ve.init.sa.css'
		),
		'dependencies' => array(
			'ext.visualEditor.base',
			'jquery.i18n',
		),
	),

	'ext.visualEditor.data' => $wgVisualEditorResourceTemplate + array(
		'class' => 'VisualEditorDataModule',
	),

	'ext.visualEditor.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// ve
			'lib/ve/src/ve.Range.js',
			'lib/ve/src/ve.Node.js',
			'lib/ve/src/ve.BranchNode.js',
			'lib/ve/src/ve.LeafNode.js',
			'lib/ve/src/ve.Document.js',
			'lib/ve/src/ve.EventSequencer.js',

			// dm
			'lib/ve/src/dm/ve.dm.js',
			'lib/ve/src/dm/ve.dm.Model.js',
			'lib/ve/src/dm/ve.dm.ModelRegistry.js',
			'lib/ve/src/dm/ve.dm.NodeFactory.js',
			'lib/ve/src/dm/ve.dm.AnnotationFactory.js',
			'lib/ve/src/dm/ve.dm.AnnotationSet.js',
			'lib/ve/src/dm/ve.dm.MetaItemFactory.js',
			'lib/ve/src/dm/ve.dm.Node.js',
			'lib/ve/src/dm/ve.dm.ClassAttributeNode.js',
			'lib/ve/src/dm/ve.dm.FocusableNode.js',
			'lib/ve/src/dm/ve.dm.Scalable.js',
			'lib/ve/src/dm/ve.dm.ResizableNode.js',
			'lib/ve/src/dm/ve.dm.BranchNode.js',
			'lib/ve/src/dm/ve.dm.LeafNode.js',
			'lib/ve/src/dm/ve.dm.Annotation.js',
			'lib/ve/src/dm/ve.dm.InternalList.js',
			'lib/ve/src/dm/ve.dm.MetaItem.js',
			'lib/ve/src/dm/ve.dm.MetaList.js',
			'lib/ve/src/dm/ve.dm.TableMatrix.js',
			'lib/ve/src/dm/ve.dm.TransactionProcessor.js',
			'lib/ve/src/dm/ve.dm.Transaction.js',
			'lib/ve/src/dm/ve.dm.Selection.js',
			'lib/ve/src/dm/ve.dm.LinearSelection.js',
			'lib/ve/src/dm/ve.dm.NullSelection.js',
			'lib/ve/src/dm/ve.dm.TableSelection.js',
			'lib/ve/src/dm/ve.dm.Surface.js',
			'lib/ve/src/dm/ve.dm.SurfaceFragment.js',
			'lib/ve/src/dm/ve.dm.DataString.js',
			'lib/ve/src/dm/ve.dm.Document.js',
			'lib/ve/src/dm/ve.dm.DocumentSlice.js',
			'lib/ve/src/dm/ve.dm.LinearData.js',
			'lib/ve/src/dm/ve.dm.DocumentSynchronizer.js',
			'lib/ve/src/dm/ve.dm.IndexValueStore.js',
			'lib/ve/src/dm/ve.dm.Converter.js',

			'lib/ve/src/dm/lineardata/ve.dm.FlatLinearData.js',
			'lib/ve/src/dm/lineardata/ve.dm.ElementLinearData.js',
			'lib/ve/src/dm/lineardata/ve.dm.MetaLinearData.js',

			'lib/ve/src/dm/nodes/ve.dm.GeneratedContentNode.js',
			'lib/ve/src/dm/nodes/ve.dm.AlienNode.js',
			'lib/ve/src/dm/nodes/ve.dm.BlockquoteNode.js',
			'lib/ve/src/dm/nodes/ve.dm.BreakNode.js',
			'lib/ve/src/dm/nodes/ve.dm.CenterNode.js',
			'lib/ve/src/dm/nodes/ve.dm.CommentNode.js',
			'lib/ve/src/dm/nodes/ve.dm.DefinitionListItemNode.js',
			'lib/ve/src/dm/nodes/ve.dm.DefinitionListNode.js',
			'lib/ve/src/dm/nodes/ve.dm.DivNode.js',
			'lib/ve/src/dm/nodes/ve.dm.DocumentNode.js',
			'lib/ve/src/dm/nodes/ve.dm.HeadingNode.js',
			'lib/ve/src/dm/nodes/ve.dm.InternalItemNode.js',
			'lib/ve/src/dm/nodes/ve.dm.InternalListNode.js',
			'lib/ve/src/dm/nodes/ve.dm.ListItemNode.js',
			'lib/ve/src/dm/nodes/ve.dm.ListNode.js',
			'lib/ve/src/dm/nodes/ve.dm.ParagraphNode.js',
			'lib/ve/src/dm/nodes/ve.dm.PreformattedNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TableCaptionNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TableCellNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TableNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TableRowNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TableSectionNode.js',
			'lib/ve/src/dm/nodes/ve.dm.TextNode.js',
			'lib/ve/src/dm/nodes/ve.dm.ImageNode.js',
			'lib/ve/src/dm/nodes/ve.dm.BlockImageNode.js',
			'lib/ve/src/dm/nodes/ve.dm.BlockImageCaptionNode.js',
			'lib/ve/src/dm/nodes/ve.dm.InlineImageNode.js',

			'lib/ve/src/dm/annotations/ve.dm.LinkAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.TextStyleAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.AbbreviationAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.BigAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.BoldAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.CodeSampleAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.CodeAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.DatetimeAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.DefinitionAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.HighlightAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.ItalicAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.QuotationAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.SmallAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.SpanAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.StrikethroughAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.SubscriptAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.SuperscriptAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.UnderlineAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.UserInputAnnotation.js',
			'lib/ve/src/dm/annotations/ve.dm.VariableAnnotation.js',

			'lib/ve/src/dm/metaitems/ve.dm.AlienMetaItem.js',
			'lib/ve/src/dm/metaitems/ve.dm.CommentMetaItem.js',

			// ce
			'lib/ve/src/ce/ve.ce.js',
			'lib/ve/src/ce/ve.ce.RangeState.js',
			'lib/ve/src/ce/ve.ce.AnnotationFactory.js',
			'lib/ve/src/ce/ve.ce.NodeFactory.js',
			'lib/ve/src/ce/ve.ce.Document.js',
			'lib/ve/src/ce/ve.ce.View.js',
			'lib/ve/src/ce/ve.ce.Annotation.js',
			'lib/ve/src/ce/ve.ce.Node.js',
			'lib/ve/src/ce/ve.ce.BranchNode.js',
			'lib/ve/src/ce/ve.ce.ContentBranchNode.js',
			'lib/ve/src/ce/ve.ce.LeafNode.js',
			'lib/ve/src/ce/ve.ce.FocusableNode.js',
			'lib/ve/src/ce/ve.ce.ResizableNode.js',
			'lib/ve/src/ce/ve.ce.Surface.js',
			'lib/ve/src/ce/ve.ce.SurfaceObserver.js',

			'lib/ve/src/ce/nodes/ve.ce.GeneratedContentNode.js',
			'lib/ve/src/ce/nodes/ve.ce.AlienNode.js',
			'lib/ve/src/ce/nodes/ve.ce.BlockquoteNode.js',
			'lib/ve/src/ce/nodes/ve.ce.BreakNode.js',
			'lib/ve/src/ce/nodes/ve.ce.CenterNode.js',
			'lib/ve/src/ce/nodes/ve.ce.CommentNode.js',
			'lib/ve/src/ce/nodes/ve.ce.DefinitionListItemNode.js',
			'lib/ve/src/ce/nodes/ve.ce.DefinitionListNode.js',
			'lib/ve/src/ce/nodes/ve.ce.DivNode.js',
			'lib/ve/src/ce/nodes/ve.ce.DocumentNode.js',
			'lib/ve/src/ce/nodes/ve.ce.HeadingNode.js',
			'lib/ve/src/ce/nodes/ve.ce.InternalItemNode.js',
			'lib/ve/src/ce/nodes/ve.ce.InternalListNode.js',
			'lib/ve/src/ce/nodes/ve.ce.ListItemNode.js',
			'lib/ve/src/ce/nodes/ve.ce.ListNode.js',
			'lib/ve/src/ce/nodes/ve.ce.ParagraphNode.js',
			'lib/ve/src/ce/nodes/ve.ce.PreformattedNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TableCaptionNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TableCellNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TableNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TableRowNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TableSectionNode.js',
			'lib/ve/src/ce/nodes/ve.ce.TextNode.js',
			'lib/ve/src/ce/nodes/ve.ce.ImageNode.js',
			'lib/ve/src/ce/nodes/ve.ce.BlockImageNode.js',
			'lib/ve/src/ce/nodes/ve.ce.BlockImageCaptionNode.js',
			'lib/ve/src/ce/nodes/ve.ce.InlineImageNode.js',

			'lib/ve/src/ce/annotations/ve.ce.LinkAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.TextStyleAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.AbbreviationAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.BigAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.BoldAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.CodeAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.CodeSampleAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.DatetimeAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.DefinitionAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.HighlightAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.ItalicAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.QuotationAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.SmallAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.SpanAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.StrikethroughAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.SubscriptAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.SuperscriptAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.UnderlineAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.UserInputAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.VariableAnnotation.js',

			// ui
			'lib/ve/src/ui/ve.ui.js',

			'lib/ve/src/ui/ve.ui.Overlay.js',
			'lib/ve/src/ui/ve.ui.Surface.js',
			'lib/ve/src/ui/ve.ui.Context.js',
			'lib/ve/src/ui/ve.ui.TableContext.js',
			'lib/ve/src/ui/ve.ui.Tool.js',
			'lib/ve/src/ui/ve.ui.Toolbar.js',
			'lib/ve/src/ui/ve.ui.TargetToolbar.js',
			'lib/ve/src/ui/ve.ui.ToolFactory.js',
			'lib/ve/src/ui/ve.ui.Command.js',
			'lib/ve/src/ui/ve.ui.CommandRegistry.js',
			'lib/ve/src/ui/ve.ui.Trigger.js',
			'lib/ve/src/ui/ve.ui.TriggerRegistry.js',
			'lib/ve/src/ui/ve.ui.Sequence.js',
			'lib/ve/src/ui/ve.ui.SequenceRegistry.js',
			'lib/ve/src/ui/ve.ui.Action.js',
			'lib/ve/src/ui/ve.ui.ActionFactory.js',
			'lib/ve/src/ui/ve.ui.FileDropHandler.js',
			'lib/ve/src/ui/ve.ui.FileDropHandlerFactory.js',
			'lib/ve/src/ui/ve.ui.WindowManager.js',

			'lib/ve/src/ui/actions/ve.ui.AnnotationAction.js',
			'lib/ve/src/ui/actions/ve.ui.ContentAction.js',
			'lib/ve/src/ui/actions/ve.ui.FormatAction.js',
			'lib/ve/src/ui/actions/ve.ui.HistoryAction.js',
			'lib/ve/src/ui/actions/ve.ui.IndentationAction.js',
			'lib/ve/src/ui/actions/ve.ui.ListAction.js',
			'lib/ve/src/ui/actions/ve.ui.TableAction.js',
			'lib/ve/src/ui/actions/ve.ui.WindowAction.js',

			'lib/ve/src/ui/commands/ve.ui.ClearAnnotationCommand.js',
			'lib/ve/src/ui/commands/ve.ui.HistoryCommand.js',
			'lib/ve/src/ui/commands/ve.ui.IndentationCommand.js',
			'lib/ve/src/ui/commands/ve.ui.MergeCellsCommand.js',
			'lib/ve/src/ui/commands/ve.ui.TableCaptionCommand.js',

			'lib/ve/src/ui/dialogs/ve.ui.FragmentDialog.js',
			'lib/ve/src/ui/dialogs/ve.ui.NodeDialog.js',
			'lib/ve/src/ui/dialogs/ve.ui.ToolbarDialog.js',
			'lib/ve/src/ui/dialogs/ve.ui.CommandHelpDialog.js',
			'lib/ve/src/ui/dialogs/ve.ui.FindAndReplaceDialog.js',
			'lib/ve/src/ui/dialogs/ve.ui.ProgressDialog.js',

			'lib/ve/src/ui/filedrophandlers/ve.ui.DSVFileDropHandler.js',
			'lib/ve/src/ui/filedrophandlers/ve.ui.PlainTextFileDropHandler.js',
			'lib/ve/src/ui/filedrophandlers/ve.ui.HTMLFileDropHandler.js',

			'lib/ve/src/ui/windowmanagers/ve.ui.ToolbarDialogWindowManager.js',

			'lib/ve/src/ui/widgets/ve.ui.SurfaceWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.LinkTargetInputWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.ContextSelectWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.ContextOptionWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.DimensionsWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.MediaSizeWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.WhitespacePreservingTextInputWidget.js',

			'lib/ve/src/ui/tools/ve.ui.AnnotationTool.js',
			'lib/ve/src/ui/tools/ve.ui.ClearAnnotationTool.js',
			'lib/ve/src/ui/tools/ve.ui.DialogTool.js',
			'lib/ve/src/ui/tools/ve.ui.FindAndReplaceTool.js',
			'lib/ve/src/ui/tools/ve.ui.FormatTool.js',
			'lib/ve/src/ui/tools/ve.ui.HistoryTool.js',
			'lib/ve/src/ui/tools/ve.ui.IndentationTool.js',
			'lib/ve/src/ui/tools/ve.ui.InspectorTool.js',
			'lib/ve/src/ui/tools/ve.ui.ListTool.js',
			'lib/ve/src/ui/tools/ve.ui.TableTool.js',

			'lib/ve/src/ui/inspectors/ve.ui.FragmentInspector.js',
			'lib/ve/src/ui/inspectors/ve.ui.AnnotationInspector.js',
			'lib/ve/src/ui/inspectors/ve.ui.NodeInspector.js',
			'lib/ve/src/ui/inspectors/ve.ui.CommentInspector.js',
			'lib/ve/src/ui/inspectors/ve.ui.LinkInspector.js',

			'lib/ve/src/ui/inspectors/ve.ui.SpecialCharacterInspector.js',
		),
		'debugScripts' => array(
			'lib/ve/src/ui/ve.ui.DebugBar.js',
			'lib/ve/src/ve.Filibuster.js',
		),
		'styles' => array(
			// ce
			'lib/ve/src/ce/styles/nodes/ve.ce.CommentNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.FocusableNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.AlienNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.BranchNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.DocumentNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.GeneratedContentNode.css',
			'lib/ve/src/ce/styles/annotations/ve.ce.LanguageAnnotation.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.ResizableNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.TableCellNode.css',
			'lib/ve/src/ce/styles/nodes/ve.ce.TableNode.css',
			'lib/ve/src/ce/styles/ve.ce.Surface.css',

			// ui
			'lib/ve/src/ui/styles/dialogs/ve.ui.ToolbarDialog.css',
			'lib/ve/src/ui/styles/dialogs/ve.ui.CommandHelpDialog.css',
			'lib/ve/src/ui/styles/dialogs/ve.ui.FindAndReplaceDialog.css',
			'lib/ve/src/ui/styles/dialogs/ve.ui.ProgressDialog.css',
			'lib/ve/src/ui/styles/tools/ve.ui.FormatTool.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.ContextOptionWidget.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.ContextSelectWidget.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.DimensionsWidget.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.MediaSizeWidget.css',
			'lib/ve/src/ui/styles/inspectors/ve.ui.CommentInspector.css',
			'lib/ve/src/ui/styles/inspectors/ve.ui.FragmentInspector.css',
			'lib/ve/src/ui/styles/inspectors/ve.ui.LinkInspector.css',
			'lib/ve/src/ui/styles/inspectors/ve.ui.SpecialCharacterInspector.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.SurfaceWidget.css',
			'lib/ve/src/ui/styles/ve.ui.Overlay.css',
			'lib/ve/src/ui/styles/ve.ui.Surface.css',
			'lib/ve/src/ui/styles/ve.ui.Toolbar.css',
			'lib/ve/src/ui/styles/ve.ui.TableContext.css',

			// TODO: add debugStyles to ResourceLoader
			'lib/ve/src/ui/styles/ve.ui.DebugBar.css',
		),
		'dependencies' => array(
			'unicodejs',
			'papaparse',
			'jquery.uls.data',
			'ext.visualEditor.base',
		),
		'messages' => array(
			'visualeditor',
			'visualeditor-aliennode-tooltip',
			'visualeditor-annotationbutton-bold-tooltip',
			'visualeditor-annotationbutton-code-tooltip',
			'visualeditor-annotationbutton-italic-tooltip',
			'visualeditor-annotationbutton-link-tooltip',
			'visualeditor-annotationbutton-strikethrough-tooltip',
			'visualeditor-annotationbutton-subscript-tooltip',
			'visualeditor-annotationbutton-superscript-tooltip',
			'visualeditor-annotationbutton-underline-tooltip',
			'visualeditor-clearbutton-tooltip',
			'visualeditor-clipboard-copy',
			'visualeditor-clipboard-cut',
			'visualeditor-clipboard-paste',
			'visualeditor-clipboard-paste-special',
			'visualeditor-commentinspector-edit',
			'visualeditor-commentinspector-title',
			'visualeditor-commentinspector-tooltip',
			'visualeditor-content-select-all',
			'visualeditor-contextitemwidget-label-secondary',
			'visualeditor-dialog-action-apply',
			'visualeditor-dialog-action-cancel',
			'visualeditor-dialog-action-done',
			'visualeditor-dialog-action-goback',
			'visualeditor-dialog-action-insert',
			'visualeditor-dialog-command-help-title',
			'visualeditor-dialog-error',
			'visualeditor-dialog-error-dismiss',
			'visualeditor-dialog-media-goback',
			'visualeditor-dialog-media-size-originalsize-error',
			'visualeditor-dimensionswidget-px',
			'visualeditor-dimensionswidget-times',
			'visualeditor-find-and-replace-find-text',
			'visualeditor-find-and-replace-match-case',
			'visualeditor-find-and-replace-regular-expression',
			'visualeditor-find-and-replace-replace-all-button',
			'visualeditor-find-and-replace-replace-button',
			'visualeditor-find-and-replace-replace-text',
			'visualeditor-find-and-replace-results',
			'visualeditor-find-and-replace-title',
			'visualeditor-formatdropdown-format-blockquote',
			'visualeditor-formatdropdown-format-heading-label',
			'visualeditor-formatdropdown-format-heading1',
			'visualeditor-formatdropdown-format-heading2',
			'visualeditor-formatdropdown-format-heading3',
			'visualeditor-formatdropdown-format-heading4',
			'visualeditor-formatdropdown-format-heading5',
			'visualeditor-formatdropdown-format-heading6',
			'visualeditor-formatdropdown-format-paragraph',
			'visualeditor-formatdropdown-format-preformatted',
			'visualeditor-formatdropdown-title',
			'visualeditor-help-tool',
			'visualeditor-historybutton-redo-tooltip',
			'visualeditor-historybutton-undo-tooltip',
			'visualeditor-indentationbutton-indent-tooltip',
			'visualeditor-indentationbutton-outdent-tooltip',
			'visualeditor-inspector-close-tooltip',
			'visualeditor-inspector-remove-tooltip',
			'visualeditor-linkinspector-open',
			'visualeditor-linkinspector-title',
			'visualeditor-listbutton-bullet-tooltip',
			'visualeditor-listbutton-number-tooltip',
			'visualeditor-mediasizewidget-button-originaldimensions',
			'visualeditor-mediasizewidget-label-custom',
			'visualeditor-mediasizewidget-label-defaulterror',
			'visualeditor-mediasizewidget-label-scale',
			'visualeditor-mediasizewidget-label-scale-percent',
			'visualeditor-mediasizewidget-sizeoptions-custom',
			'visualeditor-mediasizewidget-sizeoptions-default',
			'visualeditor-mediasizewidget-sizeoptions-scale',
			'visualeditor-shortcuts-clipboard',
			'visualeditor-shortcuts-formatting',
			'visualeditor-shortcuts-history',
			'visualeditor-shortcuts-other',
			'visualeditor-shortcuts-text-style',
			'visualeditor-specialcharacter-button-tooltip',
			'visualeditor-specialcharacterinspector-title',
			'visualeditor-specialcharinspector-characterlist-insert',
			'visualeditor-table-caption',
			'visualeditor-table-delete-col',
			'visualeditor-table-delete-row',
			'visualeditor-table-delete-table',
			'visualeditor-table-format-data',
			'visualeditor-table-format-header',
			'visualeditor-table-insert-col-after',
			'visualeditor-table-insert-col-before',
			'visualeditor-table-insert-row-after',
			'visualeditor-table-insert-row-before',
			'visualeditor-table-insert-table',
			'visualeditor-table-merge-cells',
			'visualeditor-toolbar-format-tooltip',
			'visualeditor-toolbar-history',
			'visualeditor-toolbar-insert',
			'visualeditor-toolbar-paragraph-format',
			'visualeditor-toolbar-structure',
			'visualeditor-toolbar-style-tooltip',
			'visualeditor-toolbar-table',
			'visualeditor-toolbar-text-style',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.core.desktop' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/ve/src/ui/ve.ui.DesktopSurface.js',
			'lib/ve/src/ui/ve.ui.DesktopContext.js',
			'lib/ve/src/ui/windowmanagers/ve.ui.DesktopInspectorWindowManager.js',
		),
		'styles' => array(
			'lib/ve/src/ui/styles/ve.ui.DesktopContext.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core',
		),
		'targets' => array( 'desktop' ),
	),

	'ext.visualEditor.core.mobile' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/ve/src/ui/ve.ui.MobileSurface.js',
			'lib/ve/src/ui/ve.ui.MobileContext.js',
			'lib/ve/src/ui/windowmanagers/ve.ui.MobileWindowManager.js',
			'lib/ve/src/ui/widgets/ve.ui.MobileContextOptionWidget.js',
		),
		'styles' => array(
			'lib/ve/src/ui/styles/ve.ui.MobileSurface.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.MobileContextOptionWidget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core',
		),
		'targets' => array( 'mobile' ),
	),

	'ext.visualEditor.mwcore' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// dm
			'modules/ve-mw/dm/ve.dm.MW.js',

			'modules/ve-mw/dm/nodes/ve.dm.MWEntityNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWExtensionNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWTableNode.js',

			'modules/ve-mw/dm/annotations/ve.dm.MWNowikiAnnotation.js',

			'modules/ve-mw/dm/metaitems/ve.dm.MWAlienMetaItem.js',

			// ce
			'modules/ve-mw/ce/nodes/ve.ce.MWEntityNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWExtensionNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWTableNode.js',

			'modules/ve-mw/ce/annotations/ve.ce.MWNowikiAnnotation.js',

			// ui
			'modules/ve-mw/ui/ve.ui.MWCommandRegistry.js',
			'modules/ve-mw/ui/ve.ui.MWSequenceRegistry.js',

			'modules/ve-mw/ui/commands/ve.ui.MWWikitextWarningCommand.js',

			'modules/ve-mw/ui/widgets/ve.ui.MWSurfaceWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWTitleInputWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWTocItemWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWTocWidget.js',

			'modules/ve-mw/ui/dialogs/ve.ui.MWSaveDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWBetaWelcomeDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWCommandHelpDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWCancelConfirmDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWWikitextSwitchConfirmDialog.js',

			'modules/ve-mw/ui/tools/ve.ui.MWEditModeTool.js',
			'modules/ve-mw/ui/tools/ve.ui.MWPopupTool.js',

			'modules/ve-mw/ui/inspectors/ve.ui.MWExtensionInspector.js',
			'modules/ve-mw/ui/inspectors/ve.ui.MWLiveExtensionInspector.js',

			'modules/ve-mw/ui/actions/ve.ui.MWLinkAction.js',
		),
		'styles' => array(
			// ui
			'modules/ve-mw/ui/styles/inspectors/ve.ui.MWExtensionInspector.css',
			'modules/ve-mw/ui/styles/dialogs/ve.ui.MWCommandHelpDialog.css',
			'modules/ve-mw/ui/styles/dialogs/ve.ui.MWSaveDialog.css',
			'modules/ve-mw/ui/styles/tools/ve.ui.MWPopupTool.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWTitleInputWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWTocWidget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core',
			'mediawiki.Title',
			'mediawiki.action.history.diff',
			'mediawiki.user',
			'mediawiki.util',
			'mediawiki.jqueryMsg',
			'jquery.autoEllipsis',
			'jquery.byteLimit',
			// Wikia change
			//'mediawiki.skinning.content.parsoid',
		),
		'messages' => array(
			'visualeditor-beta-label',
			'visualeditor-beta-warning',
			'visualeditor-browserwarning',
			'visualeditor-dialog-beta-welcome-action-continue',
			'visualeditor-dialog-beta-welcome-content',
			'visualeditor-dialog-beta-welcome-title',
			'visualeditor-diff-nochanges',
			'visualeditor-differror',
			'visualeditor-editconflict',
			'visualeditor-editnotices-tool',
			'visualeditor-editnotices-tooltip',
			'visualeditor-editsummary',
			'visualeditor-editsummary-bytes-remaining',
			'visualeditor-feedback-tool',
			'visualeditor-help-label',
			'visualeditor-help-link',
			'visualeditor-help-title',
			'visualeditor-mweditmodesource-title',
			'visualeditor-mweditmodesource-tool',
			'visualeditor-mweditmodesource-warning',
			'visualeditor-mweditmodesource-warning-cancel',
			'visualeditor-mweditmodesource-warning-switch',
			'visualeditor-mweditmodesource-warning-switch-discard',
			'visualeditor-pagemenu-tooltip',
			'visualeditor-pagetranslationwarning',
			'visualeditor-savedialog-error-badtoken',
			'visualeditor-savedialog-label-create',
			'visualeditor-savedialog-label-error',
			'visualeditor-savedialog-label-report',
			'visualeditor-savedialog-label-resolve-conflict',
			'visualeditor-savedialog-label-restore',
			'visualeditor-savedialog-label-resume-editing',
			'visualeditor-savedialog-label-review',
			'visualeditor-savedialog-label-review-good',
			'visualeditor-savedialog-label-save',
			'visualeditor-savedialog-label-warning',
			'visualeditor-savedialog-title-conflict',
			'visualeditor-savedialog-title-nochanges',
			'visualeditor-savedialog-title-review',
			'visualeditor-savedialog-title-save',
			'visualeditor-savedialog-warning-dirty',
			'visualeditor-saveerror',
			'visualeditor-serializeerror',
			'visualeditor-recreate',
			'visualeditor-toolbar-cite-label',
			'visualeditor-toolbar-savedialog',
			'visualeditor-version-label',
			'visualeditor-viewpage-savewarning',
			'visualeditor-viewpage-savewarning-discard',
			'visualeditor-viewpage-savewarning-keep',
			'visualeditor-viewpage-savewarning-title',
			'visualeditor-wikitext-warning-title',
			'visualeditor-window-title',

			// Mentioned in another message
			'ooui-dialog-process-continue',

			// Used by the TOC widget (currently experimental)
			'toc',
			'showtoc',
			'hidetoc',

			'captcha-edit',
			'captcha-label',
			'colon-separator',
			// Only used if FancyCaptcha is installed and triggered on save
			'fancycaptcha-edit',
			// Only used if QuestyCaptcha is installed and triggered on save
			'questycaptcha-edit'
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwformatting' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWHeadingNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWPreformattedNode.js',

			'modules/ve-mw/ce/nodes/ve.ce.MWHeadingNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWPreformattedNode.js',

			'modules/ve-mw/ui/tools/ve.ui.MWFormatTool.js',
		),
		'skinStyles' => array(
			'vector' => array(
				'modules/ve-mw/ui/themes/vector/ve.ui.MWFormatTool.css',
			),
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'messages' => array(
			'visualeditor-formatdropdown-format-mw-heading1',
			'visualeditor-formatdropdown-format-mw-heading2',
			'visualeditor-formatdropdown-format-mw-heading3',
			'visualeditor-formatdropdown-format-mw-heading4',
			'visualeditor-formatdropdown-format-mw-heading5',
			'visualeditor-formatdropdown-format-mw-heading6',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwimage.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWImageNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWInlineImageNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWBlockImageNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWImageCaptionNode.js',

			'modules/ve-mw/ce/ve.ce.MWResizableNode.js',

			'modules/ve-mw/ce/nodes/ve.ce.MWImageNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWInlineImageNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWBlockImageNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWImageCaptionNode.js',
		),
		'styles' => array(
			'modules/ve-mw/ce/styles/nodes/ve.ce.MWBlockImageNode.css',
			'modules/ve-mw/ce/styles/nodes/ve.ce.MWInlineImageNode.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwimage' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/models/ve.dm.MWImageModel.js',

			'modules/ve-mw/ui/widgets/ve.ui.MWMediaSearchWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWMediaResultWidget.js',

			'modules/ve-mw/ui/dialogs/ve.ui.MWMediaDialog.js',
			'modules/ve-mw/ui/tools/ve.ui.MWMediaDialogTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/dialogs/ve.ui.MWMediaDialog.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWMediaResultWidget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwimage.core',
		),
		'messages' => array(
			'visualeditor-dialog-media-insert-title',
			'visualeditor-dialog-media-alttext-section',
			'visualeditor-dialog-media-change-image',
			'visualeditor-dialog-media-content-section',
			'visualeditor-dialog-media-noresults',
			'visualeditor-dialog-media-page-advanced',
			'visualeditor-dialog-media-page-general',
			'visualeditor-dialog-media-position-center',
			'visualeditor-dialog-media-position-checkbox',
			'visualeditor-dialog-media-position-left',
			'visualeditor-dialog-media-position-none',
			'visualeditor-dialog-media-position-right',
			'visualeditor-dialog-media-position-section',
			'visualeditor-dialog-media-size-section',
			'visualeditor-dialog-media-title',
			'visualeditor-dialog-media-type-border',
			'visualeditor-dialog-media-type-frame',
			'visualeditor-dialog-media-type-frameless',
			'visualeditor-dialog-media-type-none',
			'visualeditor-dialog-media-type-section',
			'visualeditor-dialog-media-type-thumb',
			'visualeditor-dialogbutton-media-tooltip',
			'visualeditor-media-input-placeholder',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwlink' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWNumberedExternalLinkNode.js',

			'modules/ve-mw/dm/annotations/ve.dm.MWExternalLinkAnnotation.js',
			'modules/ve-mw/dm/annotations/ve.dm.MWInternalLinkAnnotation.js',

			'modules/ve-mw/ce/nodes/ve.ce.MWNumberedExternalLinkNode.js',

			'modules/ve-mw/ce/annotations/ve.ce.MWExternalLinkAnnotation.js',
			'modules/ve-mw/ce/annotations/ve.ce.MWInternalLinkAnnotation.js',

			'modules/ve-mw/ui/widgets/ve.ui.MWLinkTargetInputWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWLinkMenuOptionWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWInternalLinkMenuOptionWidget.js',

			'modules/ve-mw/ui/inspectors/ve.ui.MWLinkAnnotationInspector.js',
			'modules/ve-mw/ui/inspectors/ve.ui.MWLinkNodeInspector.js',

			'modules/ve-mw/ui/tools/ve.ui.MWLinkInspectorTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWLinkTargetInputWidget.css'
		),
		'skinStyles' => array(
			'default' => array(
				'modules/ve-mw/ui/themes/apex/ve.ui.MWLinkTargetInputWidget.css'
			),
			'minerva' => array(),
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'messages' => array(
			'visualeditor-annotationbutton-linknode-tooltip',
			'visualeditor-linkinspector-illegal-title',
			'visualeditor-linkinspector-suggest-disambig-page',
			'visualeditor-linkinspector-suggest-external-link',
			'visualeditor-linkinspector-suggest-matching-page',
			'visualeditor-linkinspector-suggest-new-page',
			'visualeditor-linkinspector-suggest-redirect-page',
			'visualeditor-linknodeinspector-add-label',
			'visualeditor-linknodeinspector-title',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwmeta' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/metaitems/ve.dm.MWCategoryMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWDefaultSortMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWDisplayTitleMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWHiddenCategoryMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWIndexDisableMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWIndexForceMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWLanguageMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNewSectionEditDisableMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNewSectionEditForceMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNoContentConvertMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNoEditSectionMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNoGalleryMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWNoTitleConvertMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWRedirectMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWStaticRedirectMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWTOCDisableMetaItem.js',
			'modules/ve-mw/dm/metaitems/ve.dm.MWTOCForceMetaItem.js',

			'modules/ve-mw/ui/widgets/ve.ui.MWCategoryInputWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWCategoryPopupWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWCategoryItemWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWCategoryWidget.js',

			'modules/ve-mw/ui/pages/ve.ui.MWSettingsPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWAdvancedSettingsPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWCategoriesPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWLanguagesPage.js',

			'modules/ve-mw/ui/dialogs/ve.ui.MWMetaDialog.js',

			'modules/ve-mw/ui/tools/ve.ui.MWMetaDialogTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/pages/ve.ui.MWCategoriesPage.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWCategoryInputWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWCategoryItemWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWCategoryPopupWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWCategoryWidget.css',
			'modules/ve-mw/ui/styles/dialogs/ve.ui.MWMetaDialog.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
			'ext.visualEditor.mwlink',
		),
		'messages' => array(
			'visualeditor-advancedsettings-tool',
			'visualeditor-categories-tool',
			'visualeditor-dialog-meta-advancedsettings-label',
			'visualeditor-dialog-meta-advancedsettings-section',
			'visualeditor-dialog-meta-categories-category',
			'visualeditor-dialog-meta-categories-data-label',
			'visualeditor-dialog-meta-categories-defaultsort-help',
			'visualeditor-dialog-meta-categories-defaultsort-label',
			'visualeditor-dialog-meta-categories-hidden',
			'visualeditor-dialog-meta-categories-input-hiddencategorieslabel',
			'visualeditor-dialog-meta-categories-input-matchingcategorieslabel',
			'visualeditor-dialog-meta-categories-input-movecategorylabel',
			'visualeditor-dialog-meta-categories-input-newcategorylabel',
			'visualeditor-dialog-meta-categories-input-placeholder',
			'visualeditor-dialog-meta-categories-missing',
			'visualeditor-dialog-meta-categories-options',
			'visualeditor-dialog-meta-categories-section',
			'visualeditor-dialog-meta-categories-sortkey-label',
			'visualeditor-dialog-meta-languages-code-label',
			'visualeditor-dialog-meta-languages-label',
			'visualeditor-dialog-meta-languages-link-label',
			'visualeditor-dialog-meta-languages-name-label',
			'visualeditor-dialog-meta-languages-readonlynote',
			'visualeditor-dialog-meta-languages-section',
			'visualeditor-dialog-meta-settings-displaytitle',
			'visualeditor-dialog-meta-settings-displaytitle-enable',
			'visualeditor-dialog-meta-settings-displaytitle-help',
			'visualeditor-dialog-meta-settings-hiddencat-help',
			'visualeditor-dialog-meta-settings-hiddencat-label',
			'visualeditor-dialog-meta-settings-index-default',
			'visualeditor-dialog-meta-settings-index-disable',
			'visualeditor-dialog-meta-settings-index-force',
			'visualeditor-dialog-meta-settings-index-help',
			'visualeditor-dialog-meta-settings-index-label',
			'visualeditor-dialog-meta-settings-label',
			'visualeditor-dialog-meta-settings-newsectioneditlink-default',
			'visualeditor-dialog-meta-settings-newsectioneditlink-disable',
			'visualeditor-dialog-meta-settings-newsectioneditlink-force',
			'visualeditor-dialog-meta-settings-newsectioneditlink-help',
			'visualeditor-dialog-meta-settings-newsectioneditlink-label',
			'visualeditor-dialog-meta-settings-nocontentconvert-help',
			'visualeditor-dialog-meta-settings-nocontentconvert-label',
			'visualeditor-dialog-meta-settings-noeditsection-help',
			'visualeditor-dialog-meta-settings-noeditsection-label',
			'visualeditor-dialog-meta-settings-nogallery-help',
			'visualeditor-dialog-meta-settings-nogallery-label',
			'visualeditor-dialog-meta-settings-notitleconvert-help',
			'visualeditor-dialog-meta-settings-notitleconvert-label',
			'visualeditor-dialog-meta-settings-redirect-help',
			'visualeditor-dialog-meta-settings-redirect-label',
			'visualeditor-dialog-meta-settings-redirect-placeholder',
			'visualeditor-dialog-meta-settings-redirect-statichelp',
			'visualeditor-dialog-meta-settings-redirect-staticlabel',
			'visualeditor-dialog-meta-settings-section',
			'visualeditor-dialog-meta-settings-toc-default',
			'visualeditor-dialog-meta-settings-toc-disable',
			'visualeditor-dialog-meta-settings-toc-force',
			'visualeditor-dialog-meta-settings-toc-help',
			'visualeditor-dialog-meta-settings-toc-label',
			'visualeditor-dialog-meta-title',
			'visualeditor-dialogbutton-meta-tooltip',
			'visualeditor-languages-tool',
			'visualeditor-meta-tool',
			'visualeditor-settings-tool',

		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwreference.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/models/ve.dm.MWReferenceModel.js',

			'modules/ve-mw/dm/nodes/ve.dm.MWReferencesListNode.js',
			'modules/ve-mw/dm/nodes/ve.dm.MWReferenceNode.js',

			'modules/ve-mw/ce/nodes/ve.ce.MWReferencesListNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWReferenceNode.js',
		),
		'styles' => array(
			'modules/ve-mw/ce/styles/nodes/ve.ce.MWReferencesListNode.css',
			'modules/ve-mw/ce/styles/nodes/ve.ce.MWReferenceNode.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'messages' => array(
			'visualeditor-referenceslist-isempty',
			'visualeditor-referenceslist-isempty-default',
			'visualeditor-referenceslist-missingref',
		),
		'targets' => array( 'desktop', 'mobile' )
	),

	'ext.visualEditor.mwreference' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/ui/widgets/ve.ui.MWReferenceGroupInputWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWReferenceSearchWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWReferenceResultWidget.js',

			'modules/ve-mw/ui/commands/ve.ui.MWUseExistingReferenceCommand.js',

			'modules/ve-mw/ui/dialogs/ve.ui.MWCitationDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWReferencesListDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWReferenceDialog.js',

			'modules/ve-mw/ui/tools/ve.ui.MWReferenceDialogTool.js',
			'modules/ve-mw/ui/tools/ve.ui.MWCitationDialogTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceGroupInputWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceResultWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWReferenceSearchWidget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwreference.core',
			'ext.visualEditor.mwtransclusion',
		),
		'messages' => array(
			'visualeditor-dialog-reference-editing-reused',
			'visualeditor-dialog-reference-options-group-label',
			'visualeditor-dialog-reference-options-group-placeholder',
			'visualeditor-dialog-reference-options-name-label',
			'visualeditor-dialog-reference-options-section',
			'visualeditor-dialog-reference-title',
			'visualeditor-dialog-reference-useexisting-label',
			'visualeditor-dialog-reference-useexisting-tool',
			'visualeditor-dialog-referenceslist-title',
			'visualeditor-dialogbutton-reference-tooltip',
			'visualeditor-dialogbutton-referenceslist-tooltip',
			'visualeditor-reference-input-placeholder',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwtransclusion.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWTransclusionNode.js',

			'modules/ve-mw/dm/metaitems/ve.dm.MWTransclusionMetaItem.js',

			'modules/ve-mw/ce/nodes/ve.ce.MWTransclusionNode.js',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwtransclusion' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/models/ve.dm.MWTransclusionModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWTransclusionPartModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWTransclusionContentModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWTemplateSpecModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWTemplateModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWTemplatePlaceholderModel.js',
			'modules/ve-mw/dm/models/ve.dm.MWParameterModel.js',

			'modules/ve-mw/ui/widgets/ve.ui.MWParameterSearchWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWParameterResultWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWMoreParametersResultWidget.js',
			'modules/ve-mw/ui/widgets/ve.ui.MWNoParametersResultWidget.js',

			'modules/ve-mw/ui/pages/ve.ui.MWTemplatePage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWParameterPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWParameterPlaceholderPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWTemplatePlaceholderPage.js',
			'modules/ve-mw/ui/pages/ve.ui.MWTransclusionContentPage.js',

			'modules/ve-mw/ui/dialogs/ve.ui.MWRequiredParamBlankConfirmDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWTemplateDialog.js',
			'modules/ve-mw/ui/dialogs/ve.ui.MWTransclusionDialog.js',

			'modules/ve-mw/ui/tools/ve.ui.MWTransclusionDialogTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWParameterResultWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWMoreParametersResultWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWNoParametersResultWidget.css',
			'modules/ve-mw/ui/styles/widgets/ve.ui.MWParameterSearchWidget.css',
			'modules/ve-mw/ui/styles/pages/ve.ui.MWTransclusionContentPage.css',
			'modules/ve-mw/ui/styles/dialogs/ve.ui.MWTransclusionDialog.css',
		),
		'skinStyles' => array(
			'default' => array(
				'modules/ve-mw/ui/themes/apex/pages/ve.ui.MWParameterPage.css',
				'modules/ve-mw/ui/themes/apex/pages/ve.ui.MWTemplatePage.css',
			),
			'minerva' => array(
				'modules/ve-mw/ui/themes/minerva/pages/ve.ui.MWParameterPage.css',
				'modules/ve-mw/ui/themes/minerva/pages/ve.ui.MWTemplatePage.css',
			),
		),
		'dependencies' => array(
			'ext.visualEditor.mwtransclusion.core',
			'mediawiki.jqueryMsg',
			'mediawiki.language',
		),
		'messages' => array(
			'visualeditor-dialog-template-title',
			'visualeditor-dialog-transclusion-add-content',
			'visualeditor-dialog-transclusion-add-param',
			'visualeditor-dialog-transclusion-add-template',
			'visualeditor-dialog-transclusion-content',
			'visualeditor-dialog-transclusion-deprecated-parameter',
			'visualeditor-dialog-transclusion-deprecated-parameter-description',
			'visualeditor-dialog-transclusion-loading',
			'visualeditor-dialog-transclusion-multiple-mode',
			'visualeditor-dialog-transclusion-no-template-description',
			'visualeditor-dialog-transclusion-options',
			'visualeditor-dialog-transclusion-param-info',
			'visualeditor-dialog-transclusion-param-info-missing',
			'visualeditor-dialog-transclusion-placeholder',
			'visualeditor-dialog-transclusion-remove-content',
			'visualeditor-dialog-transclusion-remove-param',
			'visualeditor-dialog-transclusion-remove-template',
			'visualeditor-dialog-transclusion-required-parameter',
			'visualeditor-dialog-transclusion-required-parameter-description',
			'visualeditor-dialog-transclusion-required-parameter-dialog-cancel',
			'visualeditor-dialog-transclusion-required-parameter-dialog-ok',
			'visualeditor-dialog-transclusion-required-parameter-dialog-title',
			'visualeditor-dialog-transclusion-required-parameter-is-blank',
			'visualeditor-dialog-transclusion-single-mode',
			'visualeditor-dialog-transclusion-title',
			'visualeditor-dialog-transclusion-wikitext-label',
			'visualeditor-dialogbutton-template-tooltip',
			'visualeditor-dialogbutton-transclusion-tooltip',
			'visualeditor-parameter-input-placeholder',
			'visualeditor-parameter-search-more',
			'visualeditor-parameter-search-no-unused',
			'visualeditor-parameter-search-unknown',
			'quotation-marks',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.language' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'lib/ve/src/dm/annotations/ve.dm.LanguageAnnotation.js',
			'lib/ve/src/ce/annotations/ve.ce.LanguageAnnotation.js',
			'lib/ve/src/ui/widgets/ve.ui.LanguageResultWidget.js',
			'lib/ve/src/ui/widgets/ve.ui.LanguageSearchWidget.js',
			'lib/ve/src/ui/dialogs/ve.ui.LanguageSearchDialog.js',
			'lib/ve/src/ui/inspectors/ve.ui.LanguageInspector.js',
			'lib/ve/src/ui/tools/ve.ui.LanguageInspectorTool.js',
			'lib/ve/src/ui/widgets/ve.ui.LanguageInputWidget.js',
		),
		'styles' => array(
			'lib/ve/src/ui/styles/widgets/ve.ui.LanguageInputWidget.css',
			'lib/ve/src/ui/styles/widgets/ve.ui.LanguageSearchWidget.css',
		),
		'dependencies' => array(
			'ext.visualEditor.core',
			'mediawiki.language.names',
		),
		'messages' => array(
			'visualeditor-annotationbutton-language-tooltip',
			'visualeditor-dialog-language-auto-direction',
			'visualeditor-dialog-language-search-title',
			'visualeditor-language-search-input-placeholder',
			'visualeditor-languageannotation-description',
			'visualeditor-languageannotation-description-with-dir',
			'visualeditor-languageinspector-title',
			'visualeditor-languageinspector-widget-changelang',
			'visualeditor-languageinspector-widget-label-direction',
			'visualeditor-languageinspector-widget-label-langcode',
			'visualeditor-languageinspector-widget-label-language',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwalienextension' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWAlienExtensionNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWAlienExtensionNode.js',
			'modules/ve-mw/ui/inspectors/ve.ui.MWAlienExtensionInspector.js',
			'modules/ve-mw/ui/tools/ve.ui.MWAlienExtensionInspectorTool.js',
		),
		'styles' => array(
			'modules/ve-mw/ui/styles/inspectors/ve.ui.MWAlienExtensionInspector.css',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'messages' => array(
			'visualeditor-mwalienextensioninspector-title',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.mwgallery' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'modules/ve-mw/dm/nodes/ve.dm.MWGalleryNode.js',
			'modules/ve-mw/ce/nodes/ve.ce.MWGalleryNode.js',
			'modules/ve-mw/ui/inspectors/ve.ui.MWGalleryInspector.js',
			'modules/ve-mw/ui/tools/ve.ui.MWGalleryInspectorTool.js',
		),
		'dependencies' => array(
			'ext.visualEditor.mwcore',
		),
		'messages' => array(
			'visualeditor-mwgalleryinspector-placeholder',
			'visualeditor-mwgalleryinspector-title',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),

	'ext.visualEditor.experimental' => array(
		'dependencies' => array(
			'ext.visualEditor.language',
			'ext.visualEditor.mwalienextension',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),
	/*
	'ext.visualEditor.icons' => $wgVisualEditorResourceTemplate + array(
		'styles' => array(
			'lib/ve/src/ui/styles/ve.ui.Icons.css',
			'modules/ve-mw/ui/styles/ve.ui.Icons.css',
		),
		'targets' => array( 'desktop', 'mobile' ),
	),
	*/
);

/* Extend MediaWiki configuration */

// Set default values for new preferences
$wgDefaultUserOptions['visualeditor-enable'] = 0;
$wgDefaultUserOptions['visualeditor-betatempdisable'] = 0;
$wgDefaultUserOptions['visualeditor-enable-experimental'] = 0;
$wgDefaultUserOptions['visualeditor-enable-language'] = 0;
$wgDefaultUserOptions['visualeditor-hidebetawelcome'] = 0;

/* Configuration */

// Array of ResourceLoader module names (strings) that should be loaded when VisualEditor is
// loaded. Other extensions that extend VisualEditor should add to this array.
$wgVisualEditorPluginModules = array();

// Array of modules to load based on a preference. Keys are preference names, values are
// ResourceLoader module names.
// Remember to also set defaults in $wgDefaultUserOptions!
$wgVisualEditorPreferenceModules = array(
	'visualeditor-enable-experimental' => 'ext.visualEditor.experimental',
	'visualeditor-enable-language' => 'ext.visualEditor.language',
	//'visualeditor-enable-mwalienextension' => 'ext.visualEditor.mwalienextension',
);

// URL to the Parsoid instance
// MUST NOT end in a slash due to Parsoid bug
$wgVisualEditorParsoidURL = 'http://localhost:8000';

// Proxy to use for curl requests.
// false: use direct connection to Parsoid daemon ($wgHTTPProxy is not used
// either)
$wgVisualEditorParsoidHTTPProxy = false;

// Interwiki prefix to pass to the Parsoid instance
// Parsoid will be called as $url/$prefix/$pagename
$wgVisualEditorParsoidPrefix = 'localhost';

// Forward users' Cookie: headers to Parsoid. Required for private wikis (login required to read).
// If the wiki is not private (i.e. $wgGroupPermissions['*']['read'] is true) this configuration
// variable will be ignored.
//
// This feature requires a non-locking session store. The default session store will not work and
// will cause deadlocks when trying to use this feature. If you experience deadlock issues, enable
// $wgSessionsInObjectCache.
//
// WARNING: ONLY enable this on private wikis and ONLY IF you understand the SECURITY IMPLICATIONS
// of sending Cookie headers to Parsoid over HTTP. For security reasons, it is strongly recommended
// that $wgVisualEditorParsoidURL be pointed to localhost if this setting is enabled.
$wgVisualEditorParsoidForwardCookies = false;

// Timeout for HTTP requests to Parsoid in seconds
$wgVisualEditorParsoidTimeout = 100;

// Serialization cache timeout, in seconds
$wgVisualEditorSerializationCacheTimeout = 3600;

// Namespaces to enable VisualEditor in
$wgVisualEditorNamespaces = array_merge( $wgContentNamespaces, array( NS_USER ) );

// Whether to enable the (experimental for now) TOC widget
$wgVisualEditorEnableTocWidget = false;

// List of skins VisualEditor integration supports
//$wgVisualEditorSupportedSkins = array( 'vector', 'apex', 'monobook', 'minerva' );

// List of browsers VisualEditor is incompatibe with
// See jQuery.client for specification
$wgVisualEditorBrowserBlacklist = array(
	// IE <= 8 has various incompatibilities in layout and feature support
	// IE10 and 11 have problems but mostly work OK-ish so they're greylisted; IE9 to come
	'msie' => null,
	// Android 2.x and below "support" CE but don't trigger keyboard input
	'android' => array( array( '<', 3 ) ),
	// Firefox issues in versions 12 and below (bug 50780)
	// Wikilink [[./]] bug in Firefox 14 and below (bug 50720)
	'firefox' => array( array( '<=', 14 ) ),
	// Opera < 12 was not tested and it's userbase is almost nonexistent anyway
	'opera' => array( array( '<', 12 ) ),
	// Blacklist all versions:
	'blackberry' => null,
	'silk' => null,
);

// Whether to use change tagging for VisualEditor edits
$wgVisualEditorUseChangeTagging = true;

// Whether to disable for logged-in users
// This allows you to enable the 'visualeditor-enable' preference by default
// but still disable VE for logged-out users (by setting this to false).
$wgVisualEditorDisableForAnons = false;

// Whether to show the "welcome to the beta" dialog the first time a user uses VisualEditor
$wgVisualEditorShowBetaWelcome = false;

// Where to put the VisualEditor edit tab
// 'before': put it right before the old edit tab
// 'after': put it right after the old edit tab
$wgVisualEditorTabPosition = 'before';

$wgVisualEditorTabMessages = array(
	// i18n message key to use for the VisualEditor edit tab
	// If null, the default edit tab caption will be used
	// The 'visualeditor-ca-ve-edit' message is available for this
	'edit' => null,
	// i18n message key to use for the old edit tab
	// If null, the tab's caption will not be changed
	//'editsource' => 'visualeditor-ca-editsource',
	'editsource' => 'visualeditor-ca-classiceditor',
	// i18n message key to use for the VisualEditor create tab
	// If null, the default create tab caption will be used
	// The 'visualeditor-ca-ve-create' message is available for this
	'create' => null,
	// i18n message key to use for the old create tab
	// If null, the tab's caption will not be changed
	//'createsource' => 'visualeditor-ca-createsource',
	'createsource' => 'visualeditor-ca-classiceditor',
	// i18n message key to use for the old create tab on pages for files in foreign repos
	// If null, the tab's caption will not be changed
	'editlocaldescriptionsource' => 'visualeditor-ca-editlocaldescriptionsource',
	// i18n message key to use for the old edit tab on pages for files in foreign repos
	// If null, the tab's caption will not be changed
	'createlocaldescriptionsource' => 'visualeditor-ca-createlocaldescriptionsource',
	// i18n message key to use for the VisualEditor section edit link
	// If null, the default edit section link caption will be used
	'editsection' => null,
	// i18n message key to use for the source section edit link
	// If null, the link's caption will not be changed
	'editsectionsource' => 'visualeditor-ca-editsource-section',

	// i18n message key for an optional appendix to add to each of these from JS
	// Use this if you have HTML messages to add
	// The 'visualeditor-beta-appendix' message is available for this purpose
	'editappendix' => null,
	'editsourceappendix' => null,
	'createappendix' => null,
	'createsourceappendix' => null,
	'editsectionappendix' => null,
	'editsectionsourceappendix' => null,
);
