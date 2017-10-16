<?php

$wgExtensionCredits['twittercards'][] = [
	'name' => 'TwitterCards',
	'author' => [
		"Piotr Gabryjeluk <rychu at wikia-inc.com>",
		"Saipetch Kongkatong <saipetch at wikia-inc.com>",
	],
	'descriptionmsg' => 'twittercards-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TwitterCards'
];

$dir = dirname( __FILE__ ) . '/';

// Classes
$wgAutoloadClasses['TwitterCards'] = $dir . 'TwitterCards.class.php';
$wgAutoloadClasses['TwitterCardsHooks'] = $dir . 'TwitterCardsHooks.class.php';

// Hooks
$wgHooks['BeforePageDisplay'][] = 'TwitterCardsHooks::onBeforePageDisplay';

// i18n mapping
$wgExtensionMessagesFiles['TwitterCards'] = $dir . 'TwitterCards.i18n.php';
