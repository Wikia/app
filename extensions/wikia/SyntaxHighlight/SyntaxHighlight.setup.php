<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Syntax Highlight',
	'version' => '0.0.1',
	'author' => 'Wikia',
	'description' => 'Syntax highlight solution for Fandom powered by Wikia',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SyntaxHighlight'
];

$wgAutoloadClasses['SyntaxHighlightHooks'] = __DIR__ . '/SyntaxHighlightHooks.php';

$wgResourceModules['ext.syntaxHighlight'] = [
	'scripts' => [
		'modules/highlight/highlight.pack.js',
		'modules/ext.syntaxHighlight.js'
	],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/SyntaxHighlight'
];

$wgResourceModules['ext.syntaxHighlight.dark'] = [
	'styles' => [
		'modules/highlight/styles/solarized-dark.css'
	],
	'dependencies' => [ 'ext.syntaxHighlight' ],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/SyntaxHighlight'
];

$wgResourceModules['ext.syntaxHighlight.light'] = [
	'styles' => [
		'modules/highlight/styles/solarized-light.css'
	],
	'dependencies' => [ 'ext.syntaxHighlight' ],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/SyntaxHighlight'
];
