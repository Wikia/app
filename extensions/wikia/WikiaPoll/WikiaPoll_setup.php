<?php

/**
 * WikiaPoll
 *
 * Provides an easy way to create and manage polls.
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiaPoll/WikiaPoll_setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Wikia Poll',
	'version' => '0.1',
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'wikiapoll-desc',
);

$dir = dirname(__FILE__);

// i18n
$wgExtensionMessagesFiles['WikiaPoll'] = "{$dir}/WikiaPoll.i18n.php";

// setup "Poll" namespace
define('NS_WIKIA_POLL', 800);
define('NS_WIKIA_POLL_TALK', 801);

$wgExtensionNamespacesFiles['WikiaPoll'] = "{$dir}/WikiaPoll.namespaces.php";
wfLoadExtensionNamespaces('WikiaPoll', array(NS_WIKIA_POLL, NS_WIKIA_POLL_TALK));
// use comments and not talk pages for poll pages
$wgArticleCommentsNamespaces[] = NS_WIKIA_POLL;

// classes
$wgAutoloadClasses['WikiaPoll'] = "{$dir}/WikiaPoll.class.php";
$wgAutoloadClasses['WikiaPollAjax'] = "{$dir}/WikiaPollAjax.class.php";
$wgAutoloadClasses['WikiaPollArticle'] = "{$dir}/WikiaPollArticle.class.php";
$wgAutoloadClasses['WikiaPollHooks'] = "{$dir}/WikiaPollHooks.class.php";
$wgAutoloadClasses['SpecialCreateWikiaPoll'] = "{$dir}/SpecialCreateWikiaPoll.class.php";
// modules
$wgAutoloadClasses['WikiaPollController'] = "{$dir}/WikiaPollController.class.php";

// Special Page
$wgSpecialPages['CreatePoll'] = 'SpecialCreateWikiaPoll';

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaPollHooks::onArticleFromTitle';
$wgHooks['ArticleSaveComplete'][] = 'WikiaPollHooks::onArticleSaveComplete';
$wgHooks['AlternateEdit'][] = 'WikiaPollHooks::onAlternateEdit';
$wgHooks['MenuButtonIndexAfterExecute'][] = 'WikiaPollHooks::onMenuButtonAfterExecute';
$wgHooks['ParserReplaceInternalLinks2NoForce'][] = 'WikiaPollHooks::onParserReplaceInternalLinks2NoForce';

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaPollAjax';
function WikiaPollAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaPollAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = WikiaPollAjax::$method();

		// send array as JSON
		$json = json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}

//Edit page
$wgHooks['EditPage::showEditForm:initial2'][] = 'CreatePollSetup';
function CreatePollSetup($editform) {
	global $wgOut, $wgExtensionsPath, $wgStylePath;
	$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaPoll/js/CreateWikiaPoll.js"></script>');
	return true;
}

//WikiaMobile

JSMessages::registerPackage( 'WikiaMobilePolls', array(
	'wikiamobile-wikiapoll-thanks-voting',
	'wikiamobile-wikiapoll-poll',
	'wikiapoll-vote'
) );
