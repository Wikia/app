<?php

/**
 * Discussions
 */

$dir = __DIR__ . '/';

$wgExtensionCredits['EnableDiscussions'][] = [
	'name' => 'EnableDiscussions',
	'author' => [ 'Michal "slayful" Turek' ],
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EnableDiscussions',
];

$wgAutoloadClasses['EnableDiscussionsController'] = $dir . 'EnableDiscussionsController.class.php';
$wgAutoloadClasses['EnableDiscussionsHooks'] =
	$dir . 'EnableDiscussionsHooks.class.php';

$wgHooks['BeforeInitialize'][] = 'EnableDiscussionsHooks::onBeforeInitialize';
