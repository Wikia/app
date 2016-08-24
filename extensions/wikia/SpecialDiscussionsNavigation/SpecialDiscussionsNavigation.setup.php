<?php
$dir = __DIR__ . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'SpecialDiscussionsNavigation',
	'author' => [
		'Michal "slayful" Turek'
	],
	'descriptionmsg' => 'wikia-discussion-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussionsNavigation'
];

$wgAutoloadClasses[ 'SpecialDiscussionsNavigationController' ] = $dir . 'SpecialDiscussionsNavigationController.class.php';
$wgSpecialPages[ 'DiscussionsNavigation' ] = 'SpecialDiscussionsNavigationController';
