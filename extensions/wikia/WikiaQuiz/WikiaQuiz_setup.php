<?php

/**
 * WikiaQuiz
 *
 * Provides an easy way to create and manage quizzes.
 *
 * @author Will Lee <wlee at wikia-inc.com>, Hyun Lim <hyun at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
     *     require_once("$IP/extensions/wikia/WikiaQuiz/WikiaQuiz_setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Wikia Quiz',
	'version' => '0.1',
	'author' => array('Will Lee', 'Hyun Lim'),
	'descriptionmsg' => 'wikiaquiz-desc',
);

$dir = dirname(__FILE__);

// i18n
$wgExtensionMessagesFiles['WikiaQuiz'] = "{$dir}/WikiaQuiz.i18n.php";

// setup "Quiz" namespace
define('NS_WIKIA_QUIZ', 900);
define('NS_WIKIA_QUIZ_TALK', 901);

$wgExtensionNamespacesFiles['WikiaQuiz'] = "{$dir}/WikiaQuiz.namespaces.php";
wfLoadExtensionNamespaces('WikiaQuiz', array(NS_WIKIA_QUIZ, NS_WIKIA_QUIZ_TALK));
// use comments and not talk pages for quiz pages
$wgArticleCommentsNamespaces[] = NS_WIKIA_QUIZ;

// classes
$wgAutoloadClasses['WikiaQuiz'] = "{$dir}/WikiaQuiz.class.php";
$wgAutoloadClasses['WikiaQuizElement'] = "{$dir}/WikiaQuizElement.class.php";
$wgAutoloadClasses['SpecialCreateWikiaQuiz'] = "{$dir}/SpecialCreateWikiaQuiz.class.php";
// modules
$wgAutoloadClasses['WikiaQuizModule'] = "{$dir}/WikiaQuizModule.class.php";

// Special Page
$wgSpecialPages['CreateQuiz'] = 'SpecialCreateWikiaQuiz';

// hooks

// Ajax dispatcher

//Edit page