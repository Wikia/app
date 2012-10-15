<?php
/**
 * QuizGame extension - interactive question game that uses AJAX
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author Ashish Datta <ashish@setfive.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:QuizGame Documentation
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'QuizGame',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'Ashish Datta', 'David Pean', 'Jack Phoenix' ),
	'description' => '[[Special:QuizGameHome|Interactive question game that uses AJAX]]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:QuizGame',
);

// ResourceLoader support for MediaWiki 1.17+
$quizGameResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'QuizGame',
	'position' => 'top' // available since r85616
);

$wgResourceModules['ext.quizGame'] = $quizGameResourceTemplate + array(
	'styles' => 'questiongame.css',
	'scripts' => 'js/QuizGame.js',
	'messages' => array(
		'quiz-create-error-numanswers', 'quiz-create-error-noquestion',
		'quiz-create-error-numcorrect', 'quiz-js-reloading',
		'quiz-js-errorwas', 'quiz-js-timesup', 'quiz-js-points',
		'quiz-pause-continue', 'quiz-pause-view-leaderboard',
		'quiz-pause-create-question', 'quiz-main-page-button',
		'quiz-js-loading', 'quiz-lightbox-pause-quiz',
		'quiz-lightbox-breakdown', 'quiz-lightbox-breakdown-percent',
		'quiz-lightbox-correct', 'quiz-lightbox-incorrect',
		'quiz-lightbox-correct-points', 'quiz-lightbox-incorrect-correct'
	)
);

$wgResourceModules['ext.quizGame.lightBox'] = $quizGameResourceTemplate + array(
	'scripts' => 'js/LightBox.js'
);

// quizgame_questions.q_flag used to be an enum() and that sucked, big time
define( 'QUIZGAME_FLAG_NONE', 0 );
define( 'QUIZGAME_FLAG_FLAGGED', 1 );
define( 'QUIZGAME_FLAG_PROTECT', 2 );

// Set up the new special pages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['QuizGame'] = $dir . 'QuestionGame.i18n.php';
$wgExtensionMessagesFiles['QuizGameAlias'] = $dir . 'QuestionGame.alias.php';
$wgAutoloadClasses['QuizGameHome'] = $dir . 'QuestionGameHome.body.php';
$wgAutoloadClasses['SpecialQuestionGameUpload'] = $dir . 'QuestionGameUpload.php';
$wgAutoloadClasses['QuestionGameUploadForm'] = $dir . 'QuestionGameUpload.php';
$wgAutoloadClasses['QuizLeaderboard'] = $dir . 'QuizLeaderboard.php';
$wgAutoloadClasses['QuizRecalcStats'] = $dir . 'RecalculateStats.php';
$wgAutoloadClasses['ViewQuizzes'] = $dir . 'ViewQuizzes.php';
$wgSpecialPages['QuizGameHome'] = 'QuizGameHome';
$wgSpecialPages['QuestionGameUpload'] = 'SpecialQuestionGameUpload';
$wgSpecialPages['QuizLeaderboard'] = 'QuizLeaderboard';
$wgSpecialPages['QuizRecalcStats'] = 'QuizRecalcStats';
$wgSpecialPages['ViewQuizzes'] = 'ViewQuizzes';

// New user right for protecting/deleting/unflagging questions
$wgAvailableRights[] = 'quizadmin';
$wgGroupPermissions['sysop']['quizadmin'] = true;
$wgGroupPermissions['staff']['quizadmin'] = true;

// Should we log quiz creations, deletions, flaggings and unflaggings?
$wgQuizLogs = true;

// If so, set up the new log
// Note: while this may look like as if overriding $wgQuizLogs is impossible,
// this works just as intended; I've tested this.
if( $wgQuizLogs ) {
	$wgLogTypes[]              = 'quiz';
	$wgLogNames['quiz']        = 'quiz-questions-log-page';
	$wgLogHeaders['quiz']      = 'quiz-questions-log-page-text';
	$wgLogActions['quiz/quiz'] = 'quiz-questions-log-entry';
}	

// For example: 'edits' => 5 if you want to require users to have at least 5
// edits before they can create new quiz games.
$wgCreateQuizThresholds = array();

// Load the required AJAX functions
require_once( 'QuestionGame_AjaxFunctions.php' );

// Hooked functions
$wgAutoloadClasses['QuizGameHooks'] = $dir . 'QuizGameHooks.php';

$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] = 'QuizGameHooks::addQuizContentActions';
$wgHooks['MakeGlobalVariablesScript'][] = 'QuizGameHooks::addJSGlobals';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'QuizGameHooks::addTables';
$wgHooks['RenameUserSQL'][] = 'QuizGameHooks::onUserRename';