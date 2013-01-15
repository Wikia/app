<?php
/**
 * fix Navigation Messages (bugid: 13714)
 *
 * This script runs through MediaWiki:Wiki-navigation messages on wikis
 * and replaces default message keys with their respective message
 * values
 *
 * Usage: SERVER_ID=80433 php fixNavMessages.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 *
 * @addto maintenance
 * @author Sebastian Marzjan <sebastianm at wikia-inc.com>
 * @see https://wikia.fogbugz.com/default.asp?13714
 */

ini_set("include_path", dirname(__FILE__) . "/..");
require_once('commandLine.inc');

echo date("Y-m-d H:i:s");
echo " / Processing navigation message for " . WikiFactory::getWikiByID($wgCityId)->city_title . "...\n";

$handler = new NavMessageHandler();
$handler->fixNavMessage();

echo date("Y-m-d H:i:s");
echo " / Script finished running!\n";

class NavMessageHandler {
	const DEFAULT_USER_NAME = 'Default';
	private $messagesToReplace = array(
		'blogs-recent-url-text',
		'blogs-recent-url',
		'portal-url',
		'forum-url'
	);
	private $user = null;

	/**
	 * Main function fixing message for current (SERVER_ID) wiki
	 */
	public function fixNavMessage () {
		$title = Title::newFromText(NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI);

		if ($title->exists()) {
			$this->processTitle($title);
		}
	}

	/**
	 * Process the title - create Article instance,
	 * check if it exists locally and if so - process it.
	 *
	 * @param $title Title
	 */
	private function processTitle ($title) {
		echo date("Y-m-d H:i:s");
		echo " / Processing title\n";
		$article = new Article($title);
		$revision = $article->getRevisionFetched();

		if ($revision != null) {
			$this->processExistingArticle($article, $revision);
		}
	}

	/**
	 * Process the Article containing Navigation Message:
	 * instantiate the user and call function to replace
	 * message keys in the Article text with their translations
	 *
	 * @param $article Article
	 * @param $revision Revision
	 */
	private function processExistingArticle ($article, $revision) {
		echo date("Y-m-d H:i:s");
		echo " / Processing article\n";

		// predefined global config variable
		$wikiaBotName = F::app()->wg->wikiaBotUsers['bot']['username'];
		$this->user = $user = User::newFromName($wikiaBotName);

		/**
		 * We want to replace messages in all cases except
		 * when there is a Nav Article with only one revision
		 * edited by user Default - which means it is an
		 * import from starter Wiki
		 */
		$previousRevision = $revision->getPrevious();
		if (
			($previousRevision == null)
			&& ($revision->getRawUserText() == self::DEFAULT_USER_NAME)
		) {
			$this->deleteArticle($article);
		} else {
			$this->replaceMessages($article);
		}
	}

	/**
	 * Replace known message keys in Article containing
	 * Navigation with their respective translations
	 * Save the Article.
	 *
	 * @param $article Article
	 *
	 */
	private function replaceMessages ($article) {
		echo date("Y-m-d H:i:s");
		echo " / Replacing messages\n";
		$articleText = $article->getText();
		foreach ($this->messagesToReplace as $message) {
			$articleText = mb_ereg_replace($message, wfMessage($message)->text(), $articleText);
		}
		$page = $article->getPage();
		wfWaitForSlaves();
		$page->doEdit($articleText, '', 0, false, $this->user);
	}

	/**
	 * Removes the Article containing Navigation
	 *
	 * @param $article Article
	 */
	private function deleteArticle ($article) {
		echo date("Y-m-d H:i:s");
		echo " / Removing article\n";
		$page = $article->getPage();
		$errors = '';
		wfWaitForSlaves();
		$page->doDeleteArticle('', false, 0, true, $errors, $this->user);
	}
}