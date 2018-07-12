<?php

/**
 * Helper class for JSMessages used for generating proper cache buster values based on revision ID from NS_MEDIAWIKI
 */

class JSMessagesHelper {

	// database name of messaging.wikia.com
	const MESSAGING = 'messaging';

	// cache revison IDs for a week
	const TTL = 604800;

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
	static public function getMessagesCacheBuster() {
		global $wgStyleVersion;
		wfProfileIn(__METHOD__);

		$parts = array(
			$wgStyleVersion,
			static::getWikiRevisionId()
		);

		$ret = implode('.', $parts);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get latest revision ID of articles from NS_MEDIAWIKI
	 */
	static private function getWikiRevisionId() {
		global $wgMemc;
		return intval($wgMemc->get(static::getMemcacheKey()));
	}

	/**
	 * Set latest revision ID of articles from NS_MEDIAWIKI an a current wiki
	 *
	 * @param integer $revId - revision ID to be stored
	 */
	static private function setWikiRevisionId($revId) {
		global $wgMemc;
		$wgMemc->set(static::getMemcacheKey(), $revId, self::TTL);
	}

	/**
	 * Get latest revision ID of articles from NS_MEDIAWIKI
	 */
	static private function getMemcacheKey() {
		return wfMemcKey( 'JSMessages', 'MWrevID' );
	}

	/**
	 * Update revision ID data when message in NS_MEDIAWIKI is changed
	 *
	 * @param string $title - message name
	 * @param string $text - message content
	 * @return true - it's a hook
	 */
	static public function onMessageCacheReplace($title, $text) {
		global $wgArticle;

		if (!empty($wgArticle)) {
			static::setWikiRevisionId(intval($wgArticle->getLatest()));
		}

		return true;
	}
}
