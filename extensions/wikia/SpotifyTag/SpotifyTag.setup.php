<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Spotify Tag Extension',
	'author' => [
		'X-Wing Team @Wikia',
	],
	'descriptionmsg' => 'spotify-tag-desc',
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpotifyTag',
];

$wgAutoloadClasses['SpotifyTagController'] =  __DIR__ . '/SpotifyTagController.class.php';
$wgAutoloadClasses['SpotifyTagValidator'] =  __DIR__ . '/SpotifyTagValidator.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'SpotifyTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['SpotifyTag'] = __DIR__ . '/SpotifyTag.i18n.php';
