<?php
class PageStatsService {

	const CACHE_TTL = 86400;

	/** @var Title $mTitle */
	private $mTitle;

	public function __construct( Title $title ) {
		$this->mTitle = $title;
	}

	/**
	 * Get cache key for given entry
	 */
	private function getKey($entry) {
		return wfMemcKey( 'services', 'pageheader', $entry, $this->mTitle->getArticleID() );
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

		$articleId = $article->getId();

		// tell service to invalidate cached data for edited page
		$service = new self( $article->getTitle() );
		$service->regenerateData();

		wfDebug(__METHOD__ . ": cache cleared for page #{$articleId}\n");
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
		$service = new self( $article->getTitle() );
		$service->regenerateData();

		return true;
	}

	/**
	 * Regenerate / invalidate service cache for current page
	 */
	public function regenerateData() {
		$pageName = $this->mTitle->getPrefixedText();
		wfDebug( __METHOD__ . ": page '{$pageName}' has been touched\n" );

		// invalidate cache with number of comments / talk page revisions
		if ( $this->mTitle->isTalkPage() ) {
			if ( self::isArticleCommentsEnabled() && ArticleComment::isTitleComment( $this->mTitle ) ) {
				// get subject page for this article comment
				$parts = ArticleComment::explode( $this->mTitle->getText() );
				$title = Title::newFromText( $parts['title'], MWNamespace::getSubject( $this->mTitle->getNamespace() ) );

				wfDebug( __METHOD__ . ": article comment added\n" );
			} else {
				// get subject page for this talk page
				$title = $this->mTitle->getSubjectPage();
			}

			$contentPageName = $title->getPrefixedText();
			wfDebug( __METHOD__ .
					 ": talk page / article comment for '{$contentPageName}' has been touched\n" );

			$contentPageService = new self( $title );
			$contentPageService->regenerateCommentsCount();
		}

		return true;
	}

	/**
	 * Invalidate cache for article comments count
	 */
	public function regenerateCommentsCount() {
		global $wgMemc;
		$wgMemc->delete($this->getKey('comments6'));
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

		$title = $this->mTitle;

		// don't perform for talk pages or special pages
		if ( $title->isTalkPage() || $title->isSpecialPage() ) {
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
			$timestamp = $dbr->selectField('revision', 'rev_timestamp', array('rev_page' => $this->mTitle->getArticleID()), __METHOD__, array('ORDER BY' => 'rev_timestamp'));

			$timestamp = wfTimestamp(TS_MW, $timestamp);
			$wgMemc->set($key, $timestamp, self::CACHE_TTL);

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return $timestamp;
	}
}
