<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Trivia Quizzes',
	'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TriviaQuizzes',
];

/**
 * Resources Loader modules
 */
$wgResourceModules['quizzes.consumption'] = [
    'remoteExtPath' => 'wikia/TriviaQuizzes',
    'localBasePath' => __DIR__,
    'scripts' => [ 'js/consumption.umd.js' ],
];

$wgResourceModules['ext.wikia.TriviaQuizzes'] = [
    'remoteExtPath' => 'wikia/TriviaQuizzes',
    'localBasePath' => __DIR__,
    'scripts' => [ 'js/ext.TriviaQuizzes.js' ],
    'dependencies' => [
        'quizzes.consumption'
    ],
];

// controller
$wgAutoloadClasses['TriviaQuizzesController'] = __DIR__ . '/TriviaQuizzesController.class.php';

// hooks
//$wgHooks['ParserFirstCallInit'][] = 'TriviaQuizzesController::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'TriviaQuizzesController::onBeforePageDisplay';

// i18n
// $wgExtensionMessagesFiles['TriviaQuizzes'] = __DIR__ . '/TriviaQuizzes.i18n.php';
