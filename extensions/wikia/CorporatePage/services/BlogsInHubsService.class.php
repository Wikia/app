<?php
/**
 * Provides data for Blogs in hubs module
 *
 * @author macbre
 */

class BlogsInHubsService extends WikiaService {

	const HOT_NEWS_CACHE_TTL = 259200; // 72 hours
	const HOT_NEWS_MESSAGE_SUFFIX = '-hub-hot-today';

	/**
	 * Get memcache key name for a given hub
	 *
	 * @param string $hubName hub name
	 * @return string memcache key name
	 */
	private function getHotNewsMemcKey($hubName) {
		return $this->app->wf->MemcKey('hubs', 'hotnews', strtolower($hubName));
	}

	/**
	 * Purge hub page on Varnish
	 *
	 * @param string $hubName hub name
	 */
	private function purgeHubPage($hubName) {
		$hubName = ucfirst($hubName);
		$title = F::build('Title', array($hubName), 'newFromText');

		if ($title instanceof Title) {
			$title->purgeSquid();
			wfDebug(__METHOD__ . ": {$hubName}\n");
		}
	}

	/**
	 * Returns parsed MW message value for a given hub
	 *
	 * @param string $hubName name of the hub
	 * @return mixed parsed message
	 */
	private function parseHotNewsMessage($hubName) {
		// example: glee|User_blog:AnimeTomboy1998/Glee:_The_Secret_Student_Files
		$msg = $this->app->wf->msg($hubName . self::HOT_NEWS_MESSAGE_SUFFIX);
		$parts = explode('|', trim($msg), 2);

		if (count($parts) == 2) {
			return array(
				'dbname' => $parts[0],
				'title' => urldecode($parts[1]),
			);
		}
		else {
			return false;
		}
	}

	/**
	 * Return snippet of a given HTML
	 *
	 * @param string $text HTML to generate snippet from
	 * @param int $limit limit snippet size
	 * @return string text snippet
	 */
	private function getSnippet($text, $limit = 500) {
		$text = strip_tags($text);

		$firstDot = mb_strpos($text, '.');
		$firstDot = ($firstDot !== false) ? min($firstDot + 1, $limit) : $limit;

		$text = mb_substr($text, 0, $firstDot);

		return $text;
	}

	/**
	 * Returns given blog post data
	 *
	 * @param string $dbname database name
	 * @param string $title page title
	 * @param boolean $getSnippet include blog post snippet in the data
	 * @return mixed blog post data
	 */
	private function getBlogPostData($dbname, $title, $getSnippet = false) {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": '{$title}' ({$dbname})\n");

		$cityId = WikiFactory::DBtoID($dbname);

		// get blog info
		$data = ApiService::foreignCall($dbname, array(
			'action' => 'query',
			'prop' => 'revisions',
			'titles' => $title,
			'rvprop' => 'timestamp|user|content',
		));

		$blogPostData = reset($data['query']['pages']);
		$revisionData = array_shift($blogPostData['revisions']);

		// page ID
		$pageId = intval($blogPostData['pageid']);

		// parse blog post wikitext and get summary
		if ($getSnippet === true) {
			$data = ApiService::foreignCall($dbname, array(
				'action' => 'parse',
				'text' => $revisionData['*'],
				'title' => $title,
			));

			$snippet = $this->getSnippet($data['parse']['text']['*']);
		}

		// generate full URL to blog post
		$blogPostTitle = F::build('GlobalTitle', array($pageId, $cityId), 'newFromId');

		if (empty($blogPostTitle)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$blogPostUrl = $blogPostTitle->getFullURL();

		// get blog post title
		$title = end(explode('/', $blogPostTitle->getText(), 2));

		// get creator real name
		$creator = F::build('User', array($revisionData['user']), 'newFromName');
		if (!empty($creator)) {
			$creatorName = $creator->getRealName();
			if ($creatorName == '') {
				$creatorName = $creator->getName();
			}
		}
		else {
			$creatorName = $revisionData['user'];
		}

		// get creator user page URL
		$blogCreatorPageTitle = F::build('GlobalTitle', array($revisionData['user'], NS_USER, $cityId), 'newFromText');

		// get 220x140 image
		$imageData = ApiService::foreignCall($dbname, array(
			'action' => 'imagecrop',
			'imgId' => $pageId,
			'imgSize' => 220,
			'imgHeight' => 140,
		));

		// data
		$res = array(
			#'__raw' => $blogPostData,

			'pageId' => $pageId,
			'cityId' => $cityId,
			'wikiname' => WikiFactory::getVarValueByName('wgSitename', $cityId),
			'wikiUrl' => 'http://' . parse_url($blogPostUrl, PHP_URL_HOST),
			'title' => $title,
			'url' => $blogPostUrl,
			'created' => $revisionData['timestamp'],
			'creator' => $creatorName,
			'creatorUrl' => $blogCreatorPageTitle->getFullURL(),
			'snippet' => !empty($snippet) ? $snippet : false,
			'image' => $imageData['image']['imagecrop'],
		);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Get hot news blog post data from memcache entry
	 */
	public function getHotNews() {
		wfProfileIn(__METHOD__);

		$hubName = $this->request->getVal('hubName');
		$blogPostData = $this->wg->Memc->get($this->getHotNewsMemcKey($hubName));

		if (!empty($blogPostData)) {
			$this->response->setData($blogPostData);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Set hot news cache when hub specific MW message is updated
	 *
	 * @param string $title name of the page changed.
	 * @param string $text new contents of the page
	 * @return bool return true
	 */
	public function onMessageCacheReplace($title, $text) {
		if (strpos($title, self::HOT_NEWS_MESSAGE_SUFFIX) !== false) {
			$hubName = reset(explode('-', $title));

			// get selected blog post data and store it in memcache
			$parsedMessage = $this->parseHotNewsMessage($hubName);
			$blogPostData = $this->getBlogPostData($parsedMessage['dbname'], $parsedMessage['title'], true /* $getSnippet */);

			if (empty($blogPostData)) {
				wfDebug(__METHOD__ . ": no blog post data!\n");
			}

			$this->wg->Memc->set($this->getHotNewsMemcKey($hubName), $blogPostData, self::HOT_NEWS_CACHE_TTL);
			wfDebug(__METHOD__ . ": {$hubName} hub cache set\n");

			// purge hub page on Varnish
			$this->purgeHubPage($hubName);
		}

		return true;
	}
}
