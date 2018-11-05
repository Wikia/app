<?php
class PageStatsService {

	const CACHE_TTL = 86400;

	private $mTitle = null;
	private $pageId;

	/**
	 * Pass page ID of an article you want to get data about
	 */
	function __construct($pageId) {
		$this->pageId = intval($pageId);
	}

	/**
	 * @static
	 * @param Title $title
	 * @return PageStatsService
	 */
	public static function newFromTitle( $title ) {
		$service = new self( $title->getArticleId() );
		$service->mTitle = $title;

		return $service;
	}

	/**
	 * Get cache key for given entry
	 */
	private function getKey($entry) {
		return wfMemcKey('services', 'pageheader', $entry, $this->pageId);
	}

	/**
	 * Get title or create new from id
	 */
	private function getTitle() {
		if(empty($this->mTitle)){
			$this->mTitle = Title::newFromId($this->pageId, Title::GAID_FOR_UPDATE /* fix for slave lag */);
		}
		return $this->mTitle;
	}

	/**
	 * Refresh cache when article is edited
	 *
	 * @param WikiPage $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param Status $status
	 * @param $baseRevId
	 * @return bool
	 */
	static function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor,
		$flags, $revision, Status &$status, $baseRevId
	): bool {

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
	 * @param WikiPage $article
	 * @param User $user
	 * @param $reason
	 * @param $articleId
	 * @return bool
	 */
	static function onArticleDeleteComplete(
		WikiPage $article, User $user, $reason, $articleId
	): bool {
		wfProfileIn(__METHOD__);

		$title = $article->getTitle();

		// tell service to invalidate cached data for deleted page
		if (!empty($title)) {
			$service = self::newFromTitle($title);
			$service->regenerateData();

			wfDebug(__METHOD__ . ": cache cleared for page #{$articleId}\n");
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Regenerate / invalidate service cache for current page
	 */
	public function regenerateData() {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": page #{$this->pageId}\n");

		// invalidate cached data from getCommentsCount()
		$title = $this->getTitle();

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
	 * Get number of article comments for current page (if enabled) or get number of revisions of talk page
	 */
	public function getCommentsCount() {
		wfProfileIn(__METHOD__);

		global $wgMemc;

		if ( !is_null( $this->mTitle ) ) {
			$title = $this->mTitle;
		} else {
			$title = Title::newFromId( $this->pageId );
		}
		// don't perform for talk pages or special pages
		if (empty($title) || $title->isTalkPage() || $title->isSpecialPage() ) {
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
