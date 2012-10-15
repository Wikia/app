<?php

/**
 * Helper to load syntax-highlighting editor for JavaScript and CSS pages
 * on-wiki.
 *
 * Extends and requires WikiEditor extension.
 *
 * Extension code is GPLv2 following MediaWiki base.
 * Ace editor JS code follows its own license, see in the 'ace' subdir.
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CodeEditor',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CodeEditor',
	'author' => array( 'Brion Vibber', 'authors of Ace (ajax.org)' ),
	'descriptionmsg' => 'codeeditor-desc',
);

$dir = dirname( __FILE__ );
$wgAutoloadClasses['CodeEditorHooks'] = $dir . '/CodeEditor.hooks.php';
$wgExtensionMessagesFiles['CodeEditor'] = $dir . '/CodeEditor.i18n.php';

$wgHooks['EditPage::showEditForm:initial'][] = 'CodeEditorHooks::editPageShowEditFormInitial';
$wgHooks['BeforePageDisplay'][] = 'CodeEditorHooks::onBeforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'CodeEditorHooks::onMakeGlobalVariablesScript';

$tpl = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'CodeEditor/modules',
	'group' => 'ext.wikiEditor',
);

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
		'jquery.ui.resizable'
	),
	'messages' => array(
		'codeeditor-toolbar-toggle'
	)
) + $tpl;

// Minimal bundling of a couple bits of Ace
$wgResourceModules['ext.codeEditor.ace'] = array(
	'group' => 'ext.codeEditor.ace',
	'scripts' => array(
		'ace/ace-uncompressed.js',
		'ace/mode-javascript-uncompressed.js',
		'ace/mode-css-uncompressed.js',
		'ace/mode-lua-uncompressed.js',
	),
) + $tpl;

// Extra highlighting modes to match some available GeSHi highlighting languages
$wgResourceModules['ext.codeEditor.ace.modes'] = array(
	'group' => 'ext.codeEditor.ace',
	'scripts' => array(
		'ace/mode-c_cpp-uncompressed.js',
		'ace/mode-clojure-uncompressed.js',
		'ace/mode-csharp-uncompressed.js',
		'ace/mode-coffee-uncompressed.js',
		'ace/mode-groovy-uncompressed.js',
		'ace/mode-html-uncompressed.js',
		'ace/mode-java-uncompressed.js',
		'ace/mode-ocaml-uncompressed.js',
		'ace/mode-perl-uncompressed.js',
		'ace/mode-php-uncompressed.js',
		'ace/mode-python-uncompressed.js',
		'ace/mode-ruby-uncompressed.js',
		'ace/mode-scala-uncompressed.js',
	),
	'dependencies' => 'ext.codeEditor.ace',
) + $tpl;

// Helper to add inline [edit] links to <source> sections
$wgResourceModules['ext.codeEditor.geshi'] = array(
	'scripts' => array(
		'ext.codeEditor.geshi.js'
	),
	'messages' => array(
		'editsection',
		'editsection-brackets',
		'savearticle'
	)
) + $tpl;

// Experimental feature; not ready yet.
$wgCodeEditorGeshiIntegration = false;
