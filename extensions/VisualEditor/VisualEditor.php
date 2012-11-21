<?php
/**
 * VisualEditor extension
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Configuration */

// URL to the Parsoid instance
// MUST NOT end in a slash due to Parsoid bug
$wgVisualEditorParsoidURL = 'http://dev-inez:8000';
// Interwiki prefix to pass to the Parsoid instance
// Parsoid will be called as $url/$prefix/$pagename
$wgVisualEditorParsoidPrefix = 'communitycouncil';
// Timeout for HTTP requests to Parsoid in seconds
$wgVisualEditorParsoidTimeout = 100;
// Namespaces to enable VisualEditor in
$wgVisualEditorNamespaces = array( NS_MAIN );
/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'VisualEditor',
	'author' => array(
		'Trevor Parscal',
		'Inez Korczyński',
		'Roan Kattouw',
		'Neil Kandalgaonkar',
		'Gabriel Wicke',
		'Brion Vibber',
		'Christian Williams',
		'Rob Moen',
		'Subramanya Sastry',
		'Timo Tijhof',
	),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:VisualEditor',
	'descriptionmsg' => 'visualeditor-desc',
);
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['VisualEditor'] = $dir . 'VisualEditor.i18n.php';

$wgVisualEditorResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'VisualEditor/modules',
	'group' => 'ext.visualEditor',
);

$wgResourceModules += array(
	'rangy' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'rangy/rangy-core.js',
			'rangy/rangy-position.js',
		),
	),
	'jquery.multiSuggest' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'jquery/jquery.multiSuggest.js'
		),
	),
	// Alias for backwards compat, safe to remove after
	'ext.visualEditor.editPageInit' => $wgVisualEditorResourceTemplate + array(
		'dependencies' => array(
			'ext.visualEditor.viewPageTarget',
		)
	),
	'ext.visualEditor.viewPageTarget.icons-raster' => $wgVisualEditorResourceTemplate + array(
		'styles' => array(
			've/init/mw/styles/ve.init.mw.ViewPageTarget.Icons-raster.css',
		),
	),
	'ext.visualEditor.viewPageTarget.icons-vector' => $wgVisualEditorResourceTemplate + array(
		'styles' => array(
			've/init/mw/styles/ve.init.mw.ViewPageTarget.Icons-vector.css',
		),
	),
	'ext.visualEditor.viewPageTarget' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			've/init/mw/ve.init.mw.js',
			've/init/mw/ve.init.mw.Platform.js',
			've/init/mw/ve.init.mw.Target.js'
		),
		'skinScripts' => array(
			'vector' => array(
				've/init/mw/targets/ve.init.mw.ViewPageTarget.js'
			),
			'apex' => array(
				've/init/mw/targets/ve.init.mw.ViewPageTarget.js'
			),
			'monobook' => array(
				've/init/mw/targets/ve.init.mw.ViewPageTarget.js'
			),
			'oasis' => array(
				've/init/mw/targets/ve.init.mw.ViewPageTarget.oasis.js'
			)
		),
		'styles' => array(
			've/init/mw/styles/ve.init.mw.ViewPageTarget.css',
		),
		'skinStyles' => array(
			'vector' => array(
				've/init/mw/styles/ve.init.mw.ViewPageTarget-vector.css',
				've/init/mw/styles/ve.init.mw.ViewPageTarget-vector-hd.css' => array(
					'media' => 'screen and (min-width: 982px)'
				),
			),
			'apex' => array(
				've/init/mw/styles/ve.init.mw.ViewPageTarget-apex.css',
			),
			'monobook' => array(
				've/init/mw/styles/ve.init.mw.ViewPageTarget-monobook.css',
			),
			'oasis' => array(
				've/init/mw/styles/ve.init.mw.ViewPageTarget-oasis.css' => array(
					'media' => 'all'
				)
			)
		),
		'dependencies' => array(
			'ext.visualEditor.base',
			'mediawiki.util',
			'mediawiki.Uri',
			'mediawiki.Title',
			'jquery.placeholder',
			'jquery.client',
			'jquery.byteLimit',
			'jquery.byteLength',
			'user.tokens'
		),
		'messages' => array(
			'minoredit',
			'savearticle',
			'watchthis',
			'tooltip-save',
			'copyrightwarning',
			'copyrightpage',
			'edit',
			'create',
			'accesskey-ca-edit',
			'tooltip-ca-edit',
			'viewsource',
			'visualeditor-notification-saved',
			'visualeditor-notification-created',
			'visualeditor-ca-editsource',
			'visualeditor-loadwarning',
			'visualeditor-editsummary',
		),
	),
	'ext.visualEditor.base' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// ve
			've/ve.js',
			've/ve.EventEmitter.js',
			've/init/ve.init.js',
			've/init/ve.init.Platform.js',
		),
		'dependencies' => array(
			'jquery.json',
		),
		'debugScripts' => array(
			've/ve.debug.js',
		),
	),
	'ext.visualEditor.specialMessages' => $wgVisualEditorResourceTemplate + array(
		'class' => 'VisualEditorMessagesModule'
	),
	'ext.visualEditor.core' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// ve
			've/ve.Registry.js',
			've/ve.Factory.js',
			've/ve.Position.js',
			've/ve.Command.js',
			've/ve.CommandRegistry.js',
			've/ve.Range.js',
			've/ve.Node.js',
			've/ve.BranchNode.js',
			've/ve.LeafNode.js',
			've/ve.Surface.js',
			've/ve.Document.js',
			've/ve.OrderedHashSet.js',
			've/ve.AnnotationSet.js',
			've/ve.Action.js',
			've/ve.ActionFactory.js',

			// actions
			've/actions/ve.AnnotationAction.js',
			've/actions/ve.FormatAction.js',
			've/actions/ve.HistoryAction.js',
			've/actions/ve.IndentationAction.js',
			've/actions/ve.InspectorAction.js',
			've/actions/ve.ListAction.js',

			// dm
			've/dm/ve.dm.js',
			've/dm/ve.dm.NodeFactory.js',
			've/dm/ve.dm.AnnotationFactory.js',
			've/dm/ve.dm.Node.js',
			've/dm/ve.dm.BranchNode.js',
			've/dm/ve.dm.LeafNode.js',
			've/dm/ve.dm.Annotation.js',
			've/dm/ve.dm.TransactionProcessor.js',
			've/dm/ve.dm.Transaction.js',
			've/dm/ve.dm.Surface.js',
			've/dm/ve.dm.SurfaceFragment.js',
			've/dm/ve.dm.Document.js',
			've/dm/ve.dm.DocumentSynchronizer.js',
			've/dm/ve.dm.Converter.js',

			've/dm/nodes/ve.dm.AlienInlineNode.js',
			've/dm/nodes/ve.dm.AlienBlockNode.js',
			've/dm/nodes/ve.dm.BreakNode.js',
			've/dm/nodes/ve.dm.CenterNode.js',
			've/dm/nodes/ve.dm.DefinitionListItemNode.js',
			've/dm/nodes/ve.dm.DefinitionListNode.js',
			've/dm/nodes/ve.dm.DocumentNode.js',
			've/dm/nodes/ve.dm.HeadingNode.js',
			've/dm/nodes/ve.dm.ImageNode.js',
			've/dm/nodes/ve.dm.ListItemNode.js',
			've/dm/nodes/ve.dm.ListNode.js',
			've/dm/nodes/ve.dm.MetaBlockNode.js',
			've/dm/nodes/ve.dm.MetaInlineNode.js',
			've/dm/nodes/ve.dm.ParagraphNode.js',
			've/dm/nodes/ve.dm.PreformattedNode.js',
			've/dm/nodes/ve.dm.TableCellNode.js',
			've/dm/nodes/ve.dm.TableNode.js',
			've/dm/nodes/ve.dm.TableRowNode.js',
			've/dm/nodes/ve.dm.TableSectionNode.js',
			've/dm/nodes/ve.dm.TextNode.js',

			've/dm/annotations/ve.dm.LinkAnnotation.js',
			've/dm/annotations/ve.dm.MWExternalLinkAnnotation.js',
			've/dm/annotations/ve.dm.MWInternalLinkAnnotation.js',
			've/dm/annotations/ve.dm.TextStyleAnnotation.js',

			// ce
			've/ce/ve.ce.js',
			've/ce/ve.ce.NodeFactory.js',
			've/ce/ve.ce.Document.js',
			've/ce/ve.ce.Node.js',
			've/ce/ve.ce.BranchNode.js',
			've/ce/ve.ce.LeafNode.js',
			've/ce/ve.ce.Surface.js',
			've/ce/ve.ce.SurfaceObserver.js',

			've/ce/nodes/ve.ce.AlienNode.js',
			've/ce/nodes/ve.ce.AlienInlineNode.js',
			've/ce/nodes/ve.ce.AlienBlockNode.js',
			've/ce/nodes/ve.ce.BreakNode.js',
			've/ce/nodes/ve.ce.CenterNode.js',
			've/ce/nodes/ve.ce.DefinitionListItemNode.js',
			've/ce/nodes/ve.ce.DefinitionListNode.js',
			've/ce/nodes/ve.ce.DocumentNode.js',
			've/ce/nodes/ve.ce.HeadingNode.js',
			've/ce/nodes/ve.ce.ImageNode.js',
			've/ce/nodes/ve.ce.ListItemNode.js',
			've/ce/nodes/ve.ce.ListNode.js',
			've/ce/nodes/ve.ce.MetaBlockNode.js',
			've/ce/nodes/ve.ce.MetaInlineNode.js',
			've/ce/nodes/ve.ce.ParagraphNode.js',
			've/ce/nodes/ve.ce.PreformattedNode.js',
			've/ce/nodes/ve.ce.TableCellNode.js',
			've/ce/nodes/ve.ce.TableNode.js',
			've/ce/nodes/ve.ce.TableRowNode.js',
			've/ce/nodes/ve.ce.TableSectionNode.js',
			've/ce/nodes/ve.ce.TextNode.js',

			// ui
			've/ui/ve.ui.js',
			've/ui/ve.ui.Context.js',
			've/ui/ve.ui.Frame.js',
			've/ui/ve.ui.Inspector.js',
			've/ui/ve.ui.InspectorFactory.js',
			've/ui/ve.ui.Menu.js',
			've/ui/ve.ui.Tool.js',
			've/ui/ve.ui.Toolbar.js',
			've/ui/ve.ui.ToolFactory.js',

			've/ui/inspectors/ve.ui.LinkInspector.js',

			've/ui/tools/ve.ui.ButtonTool.js',
			've/ui/tools/ve.ui.AnnotationButtonTool.js',
			've/ui/tools/ve.ui.InspectorButtonTool.js',
			've/ui/tools/ve.ui.IndentationButtonTool.js',
			've/ui/tools/ve.ui.ListButtonTool.js',
			've/ui/tools/ve.ui.DropdownTool.js',

			've/ui/tools/buttons/ve.ui.BoldButtonTool.js',
			've/ui/tools/buttons/ve.ui.ItalicButtonTool.js',
			've/ui/tools/buttons/ve.ui.ClearButtonTool.js',
			've/ui/tools/buttons/ve.ui.LinkButtonTool.js',
			've/ui/tools/buttons/ve.ui.BulletButtonTool.js',
			've/ui/tools/buttons/ve.ui.NumberButtonTool.js',
			've/ui/tools/buttons/ve.ui.IndentButtonTool.js',
			've/ui/tools/buttons/ve.ui.OutdentButtonTool.js',
			've/ui/tools/buttons/ve.ui.RedoButtonTool.js',
			've/ui/tools/buttons/ve.ui.UndoButtonTool.js',

			've/ui/tools/dropdowns/ve.ui.FormatDropdownTool.js',
		),
		'styles' => array(
			// ce
			've/ce/styles/ve.ce.DocumentNode.css',
			've/ce/styles/ve.ce.Node.css',
			've/ce/styles/ve.ce.Surface.css',
			// ui
			've/ui/styles/ve.ui.Context.css',
			've/ui/styles/ve.ui.Inspector.css',
			've/ui/styles/ve.ui.Menu.css',
			've/ui/styles/ve.ui.Surface.css',
			've/ui/styles/ve.ui.Toolbar.css',
			've/ui/styles/ve.ui.Tool.css',
		),
		'dependencies' => array(
			'jquery',
			'rangy',
			'ext.visualEditor.base',
			'mediawiki.Title',
			'jquery.autoEllipsis',
			'jquery.multiSuggest'
		),
		'messages' => array(
			'visualeditor',
			'visualeditor-linkinspector-title',
			'visualeditor-linkinspector-label-pagetitle',
			'visualeditor-linkinspector-suggest-existing-page',
			'visualeditor-linkinspector-suggest-new-page',
			'visualeditor-linkinspector-suggest-external-link',
			'visualeditor-formatdropdown-title',
			'visualeditor-formatdropdown-format-paragraph',
			'visualeditor-formatdropdown-format-heading1',
			'visualeditor-formatdropdown-format-heading2',
			'visualeditor-formatdropdown-format-heading3',
			'visualeditor-formatdropdown-format-heading4',
			'visualeditor-formatdropdown-format-heading5',
			'visualeditor-formatdropdown-format-heading6',
			'visualeditor-formatdropdown-format-preformatted',
			'visualeditor-annotationbutton-bold-tooltip',
			'visualeditor-annotationbutton-italic-tooltip',
			'visualeditor-annotationbutton-link-tooltip',
			'visualeditor-indentationbutton-indent-tooltip',
			'visualeditor-indentationbutton-outdent-tooltip',
			'visualeditor-listbutton-number-tooltip',
			'visualeditor-listbutton-bullet-tooltip',
			'visualeditor-clearbutton-tooltip',
			'visualeditor-historybutton-undo-tooltip',
			'visualeditor-historybutton-redo-tooltip',
			'visualeditor-viewpage-savewarning',
			'visualeditor-saveerror',
			'visualeditor-aliennode-tooltip',
		),
	),
	'ext.visualEditor.icons-raster' => $wgVisualEditorResourceTemplate + array(
		'styles' => array(
			've/ui/styles/ve.ui.Icons-raster.css',
		),
	),
	'ext.visualEditor.icons-vector' => $wgVisualEditorResourceTemplate + array(
		'styles' => array(
			've/ui/styles/ve.ui.Icons-vector.css',
		),
	),
);

// Parsoid Wrapper API
$wgAutoloadClasses['ApiVisualEditor'] = $dir . 'ApiVisualEditor.php';
$wgAPIModules['ve-parsoid'] = 'ApiVisualEditor';

// Integration Hooks
$wgAutoloadClasses['VisualEditorHooks'] = $dir . 'VisualEditor.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'VisualEditorHooks::onBeforePageDisplay';
$wgHooks['GetPreferences'][] = 'VisualEditorHooks::onGetPreferences';
$wgHooks['MakeGlobalVariablesScript'][] = 'VisualEditorHooks::onMakeGlobalVariablesScript';
$wgHooks['ResourceLoaderTestModules'][] = 'VisualEditorHooks::onResourceLoaderTestModules';

$wgAutoloadClasses['VisualEditorMessagesModule'] = $dir . 'VisualEditorMessagesModule.php';
