<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Trivia Quizzes',
	'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TriviaQuizzes',
];

/**
 * Resources Loader modules
 */
$wgResourceModules['ext.wikia.TriviaQuizzes'] = [
    /** The directory where this extension's folder is located, relative to the extensions/ folder
     * For Wikia extensions, this is "wikia", since they live under extensions/wikia.
     */
    'remoteExtPath' => 'wikia/TriviaQuizzes',
    /** The path of this extension, relative to the remote extension path we defined above.
     * Simply the folder of this extension.
     */
    'localBasePath' => __DIR__,
    /** Optional: A single JS file in a string or multiple files in an array that this module should load.
     * Any directory paths here are relative to the localBasePath we defined above.
     */
    'scripts' => [
        'js/ext.TriviaQuizzes.js'
    ],
    /** Optional: Array of MediaWiki messages that should be available to JS on the client side
     */
    'messages' => [
    ],
    /** Optional: Array of modules this module depends on. */
    // 'dependencies' => [ 'mediawiki.jqueryMsg' ],
    /** Optional: Where to load this script on the page. Available values are 'top' and 'bottom'.
     * By default, all Wikia assets are loaded in the bottom of the <body>.
     * Use 'top' to force a script to load in the <head>.
     * For performance reasons, only use this for crucial blocking assets.
     */
    'position' => 'bottom',
    /** Optional: Whether to cache this module in CDN.
     * By default, modules are cached on a per-wiki basis.
     */
    'source' => 'common'
];

// controller
$wgAutoloadClasses['TriviaQuizzesController'] = __DIR__ . '/TriviaQuizzesController.class.php';

// hooks
//$wgHooks['ParserFirstCallInit'][] = 'TriviaQuizzesController::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'TriviaQuizzesController::onBeforePageDisplay';

// i18n
// $wgExtensionMessagesFiles['TriviaQuizzes'] = __DIR__ . '/TriviaQuizzes.i18n.php';
