<?php
$wgExtensionCredits['other'][] = [
    'name' => 'Trivia Quizzes',
    'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TriviaQuizzes',
];

/**
 * Resources Loader modules
 */
$wgResourceModules['ext.wikia.TriviaQuizzes'] = [
    'remoteExtPath' => 'wikia/TriviaQuizzes',
    'localBasePath' => __DIR__,
    'scripts' => [
        'js/ext.TriviaQuizzes.js',
        'node_modules/@wikia/content-types-consumption/dist/consumption.umd.js' // dist-only verison of consumption lib
    ],
];

// hooks
$wgAutoloadClasses['TriviaQuizzesHooks'] = __DIR__ . '/TriviaQuizzesHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'TriviaQuizzesHooks::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['TriviaQuizzes'] = __DIR__ . '/TriviaQuizzes.i18n.php';
