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
	'descriptionmsg' => 'wikia-editor-preview-desc',
	'authors' => [
		'Rafał Leszczyński',
		'Andrzej "nAndy" Łukaszewski',
		'Jacek "mech" Woźniak',
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EditPreview'
];

// messages
$wgExtensionMessagesFiles[ 'EditPreview' ] = $dir . 'EditPreview.i18n.php';

// register messages package for JS
JSMessages::registerPackage('EditPreview', [
	'back',
	'preview',
	'savearticle',
	'wikia-editor-preview-current-width',
	'wikia-editor-preview-min-width',
	'wikia-editor-preview-max-width',
	'wikia-editor-preview-mobile-width',
	'wikia-editor-preview-type-tooltip'
]);

JSMessages::registerPackage('EditPreviewInContLang', [
	'wikia-editor-preview-best-practices-button-link'
]);
