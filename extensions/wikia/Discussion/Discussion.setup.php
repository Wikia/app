<?php
$dir = __DIR__ . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Discussion',
	'author' => [
		'Michal "slayful" Turek'
	],
	'descriptionmsg' => 'wikia-discussion-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Discussion'
];

$wgAutoloadClasses[ 'DiscussionSpecialController' ] = $dir . 'DiscussionSpecialController.class.php';
$wgSpecialPages[ 'Discussion' ] = 'DiscussionSpecialController';
