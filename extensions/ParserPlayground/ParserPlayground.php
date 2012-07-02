<?php

/**
 * JS plugins for demoing & testing early stages of the new parser
 * & visual editor projects: http://www.mediawiki.org/wiki/Future
 *
 * Extends and requires WikiEditor extension.
 *
 * Extension code is GPLv2 following MediaWiki base.
 * Ace editor JS code follows its own license, see in the 'ace' subdir.
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ParserPlayground',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ParserPlayground',
	'author' => array( 'Brion Vibber', ),
	'descriptionmsg' => 'parserplayground-desc',
);

$dir = dirname( __FILE__ );
$wgAutoloadClasses['ParserPlaygroundHooks'] = $dir . '/ParserPlayground.hooks.php';
$wgExtensionMessagesFiles['CodeEditor'] = $dir . '/ParserPlayground.i18n.php';

$wgHooks['EditPage::showEditForm:initial'][] = 'ParserPlaygroundHooks::editPageShowEditFormInitial';

$tpl = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'ParserPlayground/modules',
	'group' => 'ext.wikiEditor',
);
/*
$wgResourceModules['ext.codeEditor'] = array(
	'scripts' => 'ext.codeEditor.js',
	'dependencies' => array(
		'ext.wikiEditor',
		'jquery.codeEditor'
	),
) + $tpl;

$wgResourceModules['jquery.codeEditor'] = array(
	'scripts' => 'jquery.codeEditor.js',
	'dependencies' => array(
		'jquery.wikiEditor',
		'ext.codeEditor.ace',
	),
	'messages' => array(
		'codeeditor-toolbar-toggle'
	)
) + $tpl;

// Minimal bundling of a couple bits of Ace
$wgResourceModules['ext.codeEditor.ace'] = array(
	'scripts' => array(
		'ace/ace-uncompressed.js',
		'ace/mode-javascript.js',
		'ace/mode-css.js',
	),
) + $tpl;
*/

$wgResourceModules['ext.parserPlayground'] = array(
	'scripts' => array(
		'mediawiki.parser.environment.js',
		'ext.cite.taghook.ref.js',

		'lib.jsdiff.js',
		'lib.pegjs.js',
		'jquery.nodetree.js',
		'ext.parserPlayground.hashMap.js',
		'ext.parserPlayground.classicParser.js',
		'ext.parserPlayground.serializer.js',
		'ext.parserPlayground.renderer.js',
		'ext.parserPlayground.pegParser.js',
		'ext.parserPlayground.js',
	),
	'styles' => array(
		'jquery.nodetree.css',
		'ext.parserPlayground.css',
	),
	'messages' => array(
		'vis-edit-source-ok',
		'vis-edit-source-cancel',
	),
	'dependencies' => array(
		'ext.wikiEditor'
	),
) + $tpl;

