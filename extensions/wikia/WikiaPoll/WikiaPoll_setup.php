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

// classes
$wgAutoloadClasses['WikiaPoll'] = "{$dir}/WikiaPoll.class.php";
$wgAutoloadClasses['WikiaPollAjax'] = "{$dir}/WikiaPollAjax.class.php";
$wgAutoloadClasses['WikiaPollArticle'] = "{$dir}/WikiaPollArticle.class.php";
$wgAutoloadClasses['WikiaPollHooks'] = "{$dir}/WikiaPollHooks.class.php";

// modules
$wgAutoloadClasses['WikiaPollModule'] = "{$dir}/WikiaPollModule.class.php";

// hooks
$wgHooks['ArticleFromTitle'][] = 'WikiaPollHooks::onArticleFromTitle';
$wgHooks['ArticleSaveComplete'][] = 'WikiaPollHooks::onArticleSaveComplete';
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'WikiaPollHooks::onFetchTemplateAndTitle';
$wgHooks['ParserAfterTidy'][] = 'WikiaPollHooks::onParserAfterTidy';

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaPollAjax';
function WikiaPollAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaPollAjax', $method)) {
		wfProfileIn(__METHOD__);

		// construct poll's object and check its existance
		$pollId = $wgRequest->getInt('pollId');
		$poll = WikiaPoll::newFromId($pollId);

		if (!empty($poll) && $poll->exists()) {
			wfLoadExtensionMessages('WikiaPoll');

			$data = WikiaPollAjax::$method($poll);
		}
		else {
			$data = array();
		}

		// send array as JSON
		$json = Wikia::json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}