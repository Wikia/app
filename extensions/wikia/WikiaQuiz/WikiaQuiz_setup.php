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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaQuiz'
);

$dir = dirname(__FILE__);

// i18n
$wgExtensionMessagesFiles['WikiaQuiz'] = "{$dir}/WikiaQuiz.i18n.php";

// setup "Quiz" namespace
define('NS_WIKIA_QUIZ', 1000);
define('NS_WIKIA_QUIZARTICLE', 1010);
define('NS_WIKIA_PLAYQUIZ', 1020);

$wgExtensionNamespacesFiles['WikiaQuiz'] = "{$dir}/WikiaQuiz.namespaces.php";
wfLoadExtensionNamespaces('WikiaQuiz', array(NS_WIKIA_QUIZ, NS_WIKIA_QUIZARTICLE, NS_WIKIA_PLAYQUIZ));

// classes
$wgAutoloadClasses['WikiaQuiz'] = "{$dir}/WikiaQuiz.class.php";
$wgAutoloadClasses['WikiaQuizAjax'] = "{$dir}/WikiaQuizAjax.class.php";
$wgAutoloadClasses['WikiaQuizArticle'] = "{$dir}/WikiaQuizArticle.class.php";
$wgAutoloadClasses['WikiaQuizElement'] = "{$dir}/WikiaQuizElement.class.php";
$wgAutoloadClasses['WikiaQuizHooks'] = "{$dir}/WikiaQuizHooks.class.php";
$wgAutoloadClasses['WikiaQuizIndexArticle'] = "{$dir}/WikiaQuizIndexArticle.class.php";
$wgAutoloadClasses['WikiaQuizPlayArticle'] = "{$dir}/WikiaQuizPlayArticle.class.php";
$wgAutoloadClasses['SpecialCreateWikiaQuiz'] = "{$dir}/SpecialCreateWikiaQuiz.class.php";
$wgAutoloadClasses['SpecialCreateWikiaQuizArticle'] = "{$dir}/SpecialCreateWikiaQuizArticle.class.php";
// modules
$wgAutoloadClasses['WikiaQuizController'] = "{$dir}/WikiaQuizController.class.php";

// Special Page
$wgSpecialPages['CreateQuiz'] = 'SpecialCreateWikiaQuiz';
$wgSpecialPages['CreateQuizArticle'] = 'SpecialCreateWikiaQuizArticle';

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

		$data = WikiaQuizAjax::$method();

		// send array as JSON
		$json = json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}

//Edit page
$wgNamespaceProtection[NS_WIKIA_QUIZ]      = array( 'wikiaquiz' );
$wgNamespaceProtection[NS_WIKIA_QUIZARTICLE] = array( 'wikiaquiz' );
$wgNamespaceProtection[NS_WIKIA_PLAYQUIZ] = array( 'wikiaquiz' );

$wgNonincludableNamespaces[] = NS_WIKIA_QUIZ;
$wgNonincludableNamespaces[] = NS_WIKIA_QUIZARTICLE;
$wgNonincludableNamespaces[] = NS_WIKIA_PLAYQUIZ;
