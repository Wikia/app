<?php

/**
 * Discussions
 */

$dir = __DIR__ . '/';

$wgExtensionCredits['Discussions'][] = [
	'name' => 'Discussions',
	'author' => ['Michal "slayful" Turek'],
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Discussions',
];

$wgAutoloadClasses['EnableDiscussionsController'] = $dir . 'EnableDiscussionsController.class.php';
