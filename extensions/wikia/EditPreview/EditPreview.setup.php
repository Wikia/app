<?php
/**
 * Edit Preview
 *
 * @author Rafał Leszczyński
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Jacek 'mech' Woźniak
 */

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
$wgExtensionMessagesFiles[ 'EditPreview' ] = __DIR__ . '/EditPreview.i18n.php';
