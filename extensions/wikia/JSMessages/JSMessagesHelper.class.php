<?php

/**
 * Helper class for JSMessages used for generating proper cache buster values based on revision ID from NS_MEDIAWIKI
 */

class JSMessagesHelper {

	// database name of messaging.wikia.com
	const MESSAGING = 'messaging';

	// cache revison IDs for a week
	const TTL = 604800;

	// application
	private $app;

	function __construct() {
		$this->app = F::app();
	}

	/**
	 * Get cache buster value for external package with messages
	 *
	 * Cache buster value is generated using:
	 *   - $wgStyleVersion,
	 *   - latest revision ID of an article in NS_MEDIAWIKI (local wiki)
	 *   - latest revision ID of an article in NS_MEDIAWIKI (messaging wiki)
	 *
	 * @return string - cache buster value
	 */
	public function getMessagesCacheBuster() {
		$this->app->wf->ProfileIn(__METHOD__);

		$parts = array(
			$this->app->wg->StyleVersion,
			$this->getWikiRevisionId(),
			$this->getWikiRevisionId(self::MESSAGING),
		);

		$ret = implode('.', $parts);

		$this->app->wf->ProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get latest revision ID of articles from NS_MEDIAWIKI for a given wiki
	 *
	 * @param integer $dbName - wiki database name (defaults to local wiki)
	 */
	private function getWikiRevisionId($dbName = null) {
		return intval($this->app->wg->Memc->get($this->getMemcacheKey($dbName)));
	}

	/**
	 * Set latest revision ID of articles from NS_MEDIAWIKI an a current wiki
	 *
	 * @param integer $revId - revision ID to be stored
	 */
	private function setWikiRevisionId($revId) {
		$this->app->wg->Memc->set($this->getMemcacheKey(), $revId, self::TTL);
	}

	/**
	 * Get latest revision ID of articles from NS_MEDIAWIKI for a given wiki
	 *
	 * @param integer $dbName - wiki database name (defaults to local wiki)
	 */
	private function getMemcacheKey($dbName = null) {
		if (is_null($dbName)) {
			$dbName = $this->app->wg->DBname;
		}

		$key = $this->app->wf->ForeignMemcKey($dbName /* $db */, null /* $prefix */, 'JSMessages', 'MWrevID');

		return $key;
	}

	/**
	 * Update revision ID data when message in NS_MEDIAWIKI is changed
	 *
	 * @param string $title - message name
	 * @param string $text - message content
	 * @return true - it's a hook
	 */
	public function onMessageCacheReplace($title, $text) {
		$article = $this->app->wg->Article;

		if (!empty($article)) {
			$this->setWikiRevisionId(intval($article->getLatest()));
		}

		return true;
	}
}
