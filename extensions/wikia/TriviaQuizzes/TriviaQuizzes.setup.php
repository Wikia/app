<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Trivia Quizzes',
	'author' => [
		'jshepherd',
        'cake-team',
	],
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TriviaQuizzes',
];

// model
$wgAutoloadClasses['TriviaQuizzesQuizModel'] = __DIR__ . '/models/TriviaQuizzesQuizModel.class.php';

// controller
$wgAutoloadClasses['TriviaQuizzesController'] = __DIR__ . '/TriviaQuizzesController.class.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'TriviaQuizzesController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['TriviaQuizzes'] = __DIR__ . '/TriviaQuizzes.i18n.php';

// resources
$wgResourceModules['ext.MyExtension'] = [
    /** The directory where this extension's folder is located, relative to the extensions/ folder
     * For Wikia extensions, this is "wikia", since they live under extensions/wikia.
     */
    'remoteExtPath' => 'wikia',
    /** The path of this extension, relative to the remote extension path we defined above.
     * Simply the folder of this extension.
     */
    'localBasePath' => __DIR__,
    /** Optional: A single JS file in a string or multiple files in an array that this module should load.
     * Any directory paths here are relative to the localBasePath we defined above.
     */
    'js' => [
        'modules/ext.MyExtension.main.js',
        'modules/ext.MyExtension.other.js'
    ],
    /** Optional: A single CSS file in a string or multiple files in an array that this module should load.
     * Any directory paths here are relative to the localBasePath we defined above.
     */
    'styles' => [
        'modules/ext.MyExtension.css',
        'modules/ext.MyExtensionSass.scss'
    ],
    /** Optional: Array of MediaWiki messages that should be available to JS on the client side
     */
    'messages' => [
        'a-message',
        'some-other-message'
    ],
    /** Optional: Array of modules this module depends on. */
    'dependencies' => [ 'mediawiki.jqueryMsg' ],
    /** Optional: Where to load this script on the page. Available values are 'top' and 'bottom'.
     * By default, all Wikia assets are loaded in the bottom of the <body>.
     * Use 'top' to force a script to load in the <head>.
     * For performance reasons, only use this for crucial blocking assets.
     */
    'position' => 'top',
    /** Optional: Whether to cache this module in CDN.
     * By default, modules are cached on a per-wiki basis.
     */
    'source' => 'common'
];

// messages exported to JS
JSMessages::registerPackage( 'TriviaQuizzes', [
	'trivia-quizzes-featured-quizzes-header',
] );
