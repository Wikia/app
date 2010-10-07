<?php
class PageStatsService extends Service {

	const CACHE_TTL = 86400;

	private $pageId;

	/**
	 * Pass page ID of an article you want to get data about
	 */
	function __construct($pageId) {
		$this->pageId = intval($pageId);
	}

	/**
	 * Get cache key for given entry
	 */
	private function getKey($entry) {
		return wfMemcKey('services', 'pageheader', $entry, $this->pageId);
	}

	/**
	 * Refresh cache when article is edited
	 */
	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {

		wfProfileIn(__METHOD__);

		$articleId = $article->getId();

		// tell service to invalidate cached data for edited page
		$service = new self($articleId);
		$service->regenerateData();

		wfDebug(__METHOD__ . ": cache cleared for page #{$articleId}\n");

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Refresh cache when article is deleted
	 */
	static function onArticleDeleteComplete(&$article, &$user, $reason, $articleId) {
		wfProfileIn(__METHOD__);

		// tell service to invalidate cached data for deleted page
		$service = new self($articleId);
		$service->regenerateData();

		wfDebug(__METHOD__ . ": cache cleared for page #{$articleId}\n");

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Regenerate / invalidate service cache for current page
	 */
	public function regenerateData() {
		global $wgMemc;

		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": page #{$this->pageId}\n");

		// invalidate cached data from getMostLinkedCategories()
		$wgMemc->delete($this->getKey('mostlinkedcategories'));

		// invalidate cached data from getRecentRevisions()
		$wgMemc->delete($this->getKey('revisions3'));

		// invalidate cached data from getCommentsCount()
		$title = Title::newFromId($this->pageId, GAID_FOR_UPDATE /* fix for slave lag */);

		if (!empty($title)) {
			$pageName = $title->getPrefixedText();
			wfDebug(__METHOD__ . ": page '{$pageName}' has been touched\n");

			// invalidate cache with number of comments / talk page revisions
			if ($title->isTalkPage()) {
				if (self::isArticleCommentsEnabled() && ArticleComment::isTitleComment($title)) {
					// get subject page for this article comment
					$parts = ArticleComment::explode($title->getText());
					$title = Title::newFromText($parts['title'], MWNamespace::getSubject($title->getNamespace()));

					wfDebug(__METHOD__ . ": article comment added\n");
				}
				else {
					// get subject page for this talk page
					$title = $title->getSubjectPage();
				}

				$contentPageName = $title->getPrefixedText();
				wfDebug(__METHOD__ . ": talk page / article comment for '{$contentPageName}' has been touched\n");

				$contentPageService = new self($title->getArticleId());
				$contentPageService->regenerateCommentsCount();
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Invalidate cache for article comments count
	 */
	public function regenerateCommentsCount() {
		global $wgMemc;
		$wgMemc->delete($this->getKey('comments6'));

		wfDebug(__METHOD__ . ": page #{$this->pageId}\n");
	}

	/**
	 * Checks whether ArticleComments extension is enabled
	 */
	private static function isArticleCommentsEnabled() {
		return class_exists('ArticleCommentInit');
	}

	/**
	 * Checks whether given category is blacklisted in $wgBiggestCategoriesBlacklist
	 */
	private function isCategoryBlacklisted($category) {
		wfProfileIn(__METHOD__);

		global $wgBiggestCategoriesBlacklist;

		$blacklist = array_merge(
			$wgBiggestCategoriesBlacklist,
			explode( "\n", wfMsgForContent( 'oasis-article-readmore-filter' ) )
		);

		// perfrom case insensitive check
		$category = strtolower($category);

		foreach($blacklist as $word) {
			$word = trim( strtolower($word), '* ' );
			if (strpos($category, $word) !== false) {
				wfProfileOut(__METHOD__);
				return true;
			}
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * Get list of two most linked categories current article is in
	 */
	public function getMostLinkedCategories() {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgMemc;

		// check whether current article belongs to any category
		$categoryLinks = $wgOut->getCategoryLinks();
		if (empty($categoryLinks)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		// try to get cached data
		$key = $this->getKey('mostlinkedcategories');

		$categories = $wgMemc->get($key);
		if (!is_array($categories)) {
			wfProfileIn(__METHOD__ . '::miss');

			// get list of articles categories with number of articles "linked" to them
			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select(
				array('categorylinks AS c1', 'categorylinks AS c2'),
				array('c2.cl_to, count(c2.cl_from) as cnt'),
				array(),
				__METHOD__,
				array(
					'GROUP BY' => 'c2.cl_to',
				),
				array(
					'categorylinks AS c2' => array(
						'JOIN',
						implode (' AND ',
							array(
								'c1.cl_to = c2.cl_to',
								"c2.cl_from = {$this->pageId}",
							)
						)
					),
				)
			);

			// order and filter out blacklisted categories
			$categories = array();

			while($obj = $dbr->fetchObject($res)) {
				if (!$this->isCategoryBlacklisted($obj->cl_to)) {
					$categories[$obj->cl_to] = $obj->cnt;
				}
			}

			arsort($categories);

			// get two most linked categories and store in cache
			$categories = array_slice($categories, 0, 2);
			$wgMemc->set($key, $categories, self::CACHE_TTL);

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return $categories;
	}

	/**
	 * Get number of article comments for current page (if enabled) or get number of revisions of talk page
	 */
	public function getCommentsCount() {
		wfProfileIn(__METHOD__);

		global $wgMemc;

		// handle not existing pages
		if ($this->pageId == 0) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$title = Title::newFromId($this->pageId);

		// don't perform for talk pages
		if (empty($title) || $title->isTalkPage()) {
			wfProfileOut(__METHOD__);
			return 0;
		}

		// try to get cached data
		$key = $this->getKey('comments6');

		$ret = $wgMemc->get($key);
		if (!is_numeric($ret)) {
			wfProfileIn(__METHOD__ . '::miss');

			// new comments extension
			if (self::isArticleCommentsEnabled() && ArticleCommentInit::ArticleCommentCheckTitle($title)) {
				// get number of article comments
				$commentList = ArticleCommentList::newFromTitle($title);

				$data = $commentList->getData();
				$ret = $data['countCommentsNested'];

				wfDebug(__METHOD__ . "::miss - using comments count\n");
			}
			else {
				// get number of revisions of talk page
				$talkPage = $title->getTalkPage();

				// check if talk page exists
				if (!empty($talkPage) && $talkPage->exists()) {
					$dbr = wfGetDB(DB_SLAVE);
					$ret = $dbr->selectField('revision', 'count(*)', array('rev_page' => $talkPage->getArticleId()), __METHOD__);
				}
				else {
					$ret = 0;
				}

				wfDebug(__METHOD__ . "::miss - using talk page revisions count\n");
			}

			$wgMemc->set($key, $ret, self::CACHE_TTL);

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return intval($ret);
	}

	/**
	 * Get number of article likes
	 *
	 * TODO: to be implemented as a separate project
	 */
	public function getLikesCount() {
		wfProfileIn(__METHOD__);

		// handle not existing pages
		if ($this->pageId == 0) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$ret = rand(0, 100);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Callback method for filtering out bots and blocked users
	 */
	private static function filterOutEditors($entry) {
		wfProfileIn(__METHOD__);

		static $resultsCache;

		// use local caching
		$userName = $entry['user'];
		$res = false;

		if (isset($resultsCache[$userName])) {
			$res = $resultsCache[$userName];
		}
		else {
			// show anons
			if (User::isIP($entry['user'])) {
				$res = true;
			}
			else {
				$user = User::newFromName($entry['user']);

				if (!empty($user)) {
					// remove bots and blocked users
					$res = !$user->isBlocked() && !$user->isAllowed('bot');
				}
			}

			// store result in local cache
			$resultsCache[$userName] = $res;
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Get current revision data and authors of five recent edits (filter out bots and blocked users)
	 */
	public function getRecentRevisions() {
		wfProfileIn(__METHOD__);

		global $wgMemc;

		// handle not existing pages
		if ($this->pageId == 0) {
			wfProfileOut(__METHOD__);
			return false;
		}

		// try to get cached data
		$key = $this->getKey('revisions3');

		$ret = $wgMemc->get($key);
		if (!is_array($ret)) {
			wfProfileIn(__METHOD__ . '::miss');

			// get last five revisions (including the current one)
			$recentRevisionsLimit = 5;

			$apiData = ApiService::call(array(
				'action' => 'query',
				'prop' => 'revisions',
				'pageids' => $this->pageId,
				'rvlimit' => $recentRevisionsLimit * 4,
				'rvprop' => 'timestamp|user',
			));

			if (empty($apiData)) {
				wfProfileOut(__METHOD__);
				return false;
			}

			$pageData = array_pop($apiData['query']['pages']);

			// article has no revisions
			if (empty($pageData['revisions'])) {
				wfProfileOut(__METHOD__);
				return false;
			}

			$revisions = $pageData['revisions'];

			// get timestamp of most recent edit
			$latestEditTimestamp = $revisions[0]['timestamp'];

			// filter out bots and blocked users
			$revisions = array_values(array_filter($revisions, 'PageStatsService::filterOutEditors'));

			// prepare result
			$ret = array(
				'current' => array(),
			);

			// no revisions left - show only timestamp of most recent edit
			if (empty($revisions)) {
				$ret['current']['timestamp'] = $latestEditTimestamp;
			}
			else {
				$ret['current'] = array_shift($revisions);
				$ret = array_merge($ret, array_slice($revisions, 0, 5));
			}

			$wgMemc->set($key, $ret, self::CACHE_TTL);

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get timestamp of first revision
	 */
	public function getFirstRevisionTimestamp() {
		wfProfileIn(__METHOD__);
		global $wgMemc;

		// try to get cached data
		$key = $this->getKey('firstrevision');

		$timestamp = $wgMemc->get($key);
		if (empty($timestamp)) {
			wfProfileIn(__METHOD__ . '::miss');

			$dbr = wfGetDB(DB_SLAVE);
			$timestamp = $dbr->selectField('revision', 'rev_timestamp', array('rev_page' => $this->pageId), __METHOD__, array('ORDER BY' => 'rev_timestamp'));

			$timestamp = wfTimestamp(TS_MW, $timestamp);
			$wgMemc->set($key, $timestamp, self::CACHE_TTL);

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return $timestamp;
	}
}
