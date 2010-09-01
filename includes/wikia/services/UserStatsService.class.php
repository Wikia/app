<?php
class UserStatsService extends Service {

	const CACHE_TTL = 86400;

	private $userId;

	/**
	 * Pass user ID of user you want to get data about
	 */
	function __construct($userId) {
			$this->userId = intval($userId);
	}

	/**
	 * Get cache key for given entry
	 */
	private function getKey($entry) {
		return wfMemcKey('services', 'userstats', $entry, $this->userId);
	}

	/**
	 * Refresh cache when article is edited
	 */
	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {

		wfProfileIn(__METHOD__);

		// tell service to update cached data for user who edited the page
		if (!$user->isAnon()) {
			$service = new UserStatsService($user->getId());
			$service->increaseEditsCount();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Update service cache for current user
	 */
	function increaseEditsCount() {
		global $wgMemc;

		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": user #{$this->userId}\n");

		// update edit counts
		$key = $this->getKey('stats3');
		$stats = $wgMemc->get($key);

		if (!empty($stats)) {
			$stats['edits']++;
			$wgMemc->set($key, $stats, self::CACHE_TTL);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Get likes count, edit points and date of first edit done by the user
	 */
	function getStats() {
		wfProfileIn(__METHOD__);

		global $wgMemc;

		// try to get cached data
		$key = $this->getKey('stats3');

		$stats = $wgMemc->get($key);
		if (empty($stats)) {
			wfProfileIn(__METHOD__ . '::miss');

			$stats = array();

			// get edit points / first edit date
			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->selectRow(
				'revision',
				array('min(rev_timestamp) AS date, count(*) AS edits'),
				array('rev_user' => $this->userId),
				__METHOD__
			);

			if (!empty($res)) {
				$stats = array(
					'edits' => intval($res->edits),
					'date' => $res->date,
				);
			}

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if (!empty($stats)) {
				$wgMemc->set($key, $stats, self::CACHE_TTL);
			}

			wfProfileOut(__METHOD__ . '::miss');
		}

		// allow other extensions to update edits points
		$stats['points'] = $stats['edits'];
		wfRunHooks('Masthead::editCounter', array(&$stats['points'], User::newFromId($this->userId)));

		wfProfileOut(__METHOD__);
		return $stats;
	}
}