<?php
/**
 * Edit Preview
 *
 * @author Rafał Leszczyński
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Jacek 'mech' Woźniak
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['editpreview'][] = [
	'name' => 'Edit preview',
	'description' => 'Enables users to preview their edits before saving them',
	'authors' => [
		'Rafał Leszczyński',
		'Andrzej "nAndy" Łukaszewski',
		'Jacek "mech" Woźniak',
	],
	'version' => 1.0
];

// messages
$wgExtensionMessagesFiles[ 'EditPreview' ] = $dir . '/EditPreview.i18n.php';

// register messages package for JS
JSMessages::registerPackage('EditPreview', [
	'back',
	'preview',
	'savearticle',
	'wikia-editor-preview-current-width',
	'wikia-editor-preview-min-width',
	'wikia-editor-preview-max-width',
	'wikia-editor-preview-type-tooltip'
]);
