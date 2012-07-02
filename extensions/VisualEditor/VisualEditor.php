<?php
/**
 * VisualEditor extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @author Inez Korczyński <inez@wikia-inc.com>
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 * @author Brion Vibber <brion@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.0
 */

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
	),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:VisualEditor',
	'descriptionmsg' => 'visualeditor-desc',
);
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['VisualEditor'] = $dir . 'VisualEditor.i18n.php';
$wgExtensionMessagesFiles['VisualEditorAliases'] = $dir . 'VisualEditor.alias.php';
$wgAutoloadClasses['SpecialVisualEditorSandbox'] = $dir . 'SpecialVisualEditorSandbox.php';
$wgSpecialPages['VisualEditorSandbox'] = 'SpecialVisualEditorSandbox';
$wgSpecialPageGroups['VisualEditorSandbox'] = 'other';

$wgVisualEditorResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'VisualEditor/modules',
	'group' => 'ext.visualEditor',
);

$wgResourceModules += array(
	'ext.visualEditor.special.sandbox' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'sandbox/special.js',
		),
		'messages' => array(
			'visualeditor-feedback-prompt',
			'visualeditor-feedback-dialog-title',
			'visualeditor-sandbox-title',
		),
		'dependencies' => array( 
			'ext.visualEditor.sandbox',
			'mediawiki.feedback',
			'mediawiki.Uri',
		)
	),
	'ext.visualEditor.sandbox' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			'sandbox/sandbox.js',
		),
		'messages' => array(
			'visualeditorsandbox',
		),
		'styles' => 'sandbox/sandbox.css',
		'dependencies' => array(
			'ext.visualEditor.ve',
		),
	),
	'ext.visualEditor.ve' => $wgVisualEditorResourceTemplate + array(
		'scripts' => array(
			// ve
			've/ve.js',
			've/ve.Position.js',
			've/ve.Range.js',
			've/ve.EventEmitter.js',
			've/ve.Node.js',
			've/ve.BranchNode.js',
			've/ve.LeafNode.js',
			// dm
			've/dm/ve.dm.js',
			've/dm/ve.dm.Node.js',
			've/dm/ve.dm.BranchNode.js',
			've/dm/ve.dm.LeafNode.js',
			've/dm/ve.dm.TransactionProcessor.js',
			've/dm/ve.dm.Transaction.js',
			've/dm/ve.dm.Surface.js',
			've/dm/nodes/ve.dm.DocumentNode.js',
			've/dm/nodes/ve.dm.HeadingNode.js',
			've/dm/nodes/ve.dm.ParagraphNode.js',
			've/dm/nodes/ve.dm.PreNode.js',
			've/dm/nodes/ve.dm.ListItemNode.js',
			've/dm/nodes/ve.dm.ListNode.js',
			've/dm/nodes/ve.dm.TableCellNode.js',
			've/dm/nodes/ve.dm.TableNode.js',
			've/dm/nodes/ve.dm.TableRowNode.js',
			've/dm/serializers/ve.dm.AnnotationSerializer.js',
			've/dm/serializers/ve.dm.HtmlSerializer.js',
			've/dm/serializers/ve.dm.JsonSerializer.js',
			've/dm/serializers/ve.dm.WikitextSerializer.js',
			// es
			've/es/ve.es.js',
			've/es/ve.es.Node.js',
			've/es/ve.es.BranchNode.js',
			've/es/ve.es.LeafNode.js',
			've/es/ve.es.Content.js',
			've/es/ve.es.Surface.js',
			've/es/nodes/ve.es.DocumentNode.js',
			've/es/nodes/ve.es.HeadingNode.js',
			've/es/nodes/ve.es.ParagraphNode.js',
			've/es/nodes/ve.es.PreNode.js',
			've/es/nodes/ve.es.ListItemNode.js',
			've/es/nodes/ve.es.ListNode.js',
			've/es/nodes/ve.es.TableCellNode.js',
			've/es/nodes/ve.es.TableNode.js',
			've/es/nodes/ve.es.TableRowNode.js',
			// ui
			've/ui/ve.ui.js',
			've/ui/ve.ui.Inspector.js',
			've/ui/ve.ui.Tool.js',
			've/ui/ve.ui.Toolbar.js',
			've/ui/ve.ui.Context.js',
			've/ui/ve.ui.Menu.js',
			've/ui/inspectors/ve.ui.LinkInspector.js',
			've/ui/tools/ve.ui.ButtonTool.js',
			've/ui/tools/ve.ui.AnnotationButtonTool.js',
			've/ui/tools/ve.ui.ClearButtonTool.js',
			've/ui/tools/ve.ui.HistoryButtonTool.js',
			've/ui/tools/ve.ui.ListButtonTool.js',
			've/ui/tools/ve.ui.IndentationButtonTool.js',
			've/ui/tools/ve.ui.DropdownTool.js',
			've/ui/tools/ve.ui.FormatDropdownTool.js',
		),
		'styles' => array(
			// es
			've/es/styles/ve.es.Surface.css',
			've/es/styles/ve.es.Content.css',
			've/es/styles/ve.es.Document.css',
			// ui
			've/ui/styles/ve.ui.Context.css',
			've/ui/styles/ve.ui.Inspector.css',
			've/ui/styles/ve.ui.Toolbar.css',
			've/ui/styles/ve.ui.Menu.css',
		),
		'dependencies' => array(
			'jquery',
		),
		'messages' => array(
			'visualeditor-tooltip-wikitext',
			'visualeditor-tooltip-json',
			'visualeditor-tooltip-html',
			'visualeditor-tooltip-render',
			'visualeditor-tooltip-history',
			'visualeditor-tooltip-help',
			'visualeditor',
		),
	)
);


// API for retrieving wikidom parse results
$wgAutoloadClasses['ApiQueryParseTree'] = $dir . 'api/ApiQueryParseTree.php';
$wgAPIPropModules['parsetree'] = 'ApiQueryParseTree';

// external cmd, accepts wikitext and returns parse tree in JSON. Also set environment variables needed by script here.
putenv('NODE_PATH=/usr/local/bin/node_modules' );
$wgVisualEditorParserCmd = '/usr/local/bin/node ' . $dir . 'modules/parser/parse.js';
