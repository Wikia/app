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
define('NS_WIKIA_QUIZ', 700);
define('NS_WIKIA_QUIZARTICLE', 710);

$wgExtensionNamespacesFiles['WikiaQuiz'] = "{$dir}/WikiaQuiz.namespaces.php";
wfLoadExtensionNamespaces('WikiaQuiz', array(NS_WIKIA_QUIZ, NS_WIKIA_QUIZARTICLE));

// classes
$wgAutoloadClasses['WikiaQuiz'] = "{$dir}/WikiaQuiz.class.php";
$wgAutoloadClasses['WikiaQuizAjax'] = "{$dir}/WikiaQuizAjax.class.php";
$wgAutoloadClasses['WikiaQuizArticle'] = "{$dir}/WikiaQuizArticle.class.php";
$wgAutoloadClasses['WikiaQuizElement'] = "{$dir}/WikiaQuizElement.class.php";
$wgAutoloadClasses['WikiaQuizHooks'] = "{$dir}/WikiaQuizHooks.class.php";
$wgAutoloadClasses['WikiaQuizIndexArticle'] = "{$dir}/WikiaQuizIndexArticle.class.php";
$wgAutoloadClasses['SpecialCreateWikiaQuiz'] = "{$dir}/SpecialCreateWikiaQuiz.class.php";
$wgAutoloadClasses['SpecialCreateWikiaQuizArticle'] = "{$dir}/SpecialCreateWikiaQuizArticle.class.php";
$wgAutoloadClasses['SpecialWikiaQuiz'] = "{$dir}/SpecialWikiaQuiz.class.php";
// modules
$wgAutoloadClasses['WikiaQuizModule'] = "{$dir}/WikiaQuizModule.class.php";

// Special Page
$wgSpecialPages['CreateQuiz'] = 'SpecialCreateWikiaQuiz';
$wgSpecialPages['CreateQuizArticle'] = 'SpecialCreateWikiaQuizArticle';
$wgSpecialPages['WikiaQuiz'] = 'SpecialWikiaQuiz';

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaQuizHooks::onArticleFromTitle';
$wgHooks['ArticleSaveComplete'][] = 'WikiaQuizHooks::onArticleSaveComplete';
$wgHooks['AlternateEdit'][] = 'WikiaQuizHooks::onAlternateEdit';

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaQuizAjax';
function WikiaQuizAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaQuizAjax', $method)) {
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('WikiaQuiz');
		$data = WikiaQuizAjax::$method();

		// send array as JSON
		$json = Wikia::json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}

//Edit page

// permissions
$wgNamespaceProtection[NS_WIKIA_QUIZ]      = array( 'quiz-edit' );
$wgNamespaceProtection[NS_WIKIA_QUIZARTICLE] = array( 'quizarticle-edit' );
$wgGroupPermissions['staff']['quiz-edit'] = true;
$wgGroupPermissions['staff']['quizarticle-edit'] = true;

$wgNonincludableNamespaces[] = NS_WIKIA_QUIZ;
$wgNonincludableNamespaces[] = NS_WIKIA_QUIZARTICLE;
