<?php
class UserStatsService extends Service {

	const CACHE_TTL = 86400;
	const GET_GLOBAL_STATS_CACHE_VER = 'v1.0';

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
		
		if ($revision !== NULL) {	// // do not count null edits
			// tell service to update cached data for user who edited the page
			if (!$user->isAnon()) {
				$service = new UserStatsService($user->getId());
				$service->increaseEditsCount();
			}
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

		// update edit counts
		$key = $this->getKey('stats4');
		$stats = $wgMemc->get($key);

		if (!empty($stats)) {
			$stats['edits']++;

			// populate 'member since' date if it's not set (i.e. it's the first edit)
			if ( empty( $stats['date'] ) && $stats['edits'] == 1 ) {
				$stats['date'] = wfTimestampNow();
			}

			$wgMemc->set($key, $stats, self::CACHE_TTL);

			wfDebug(__METHOD__ . ": user #{$this->userId}\n");
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Get likes count, edit points and date of first edit done by the user
	 */
	function getStats() {
		wfProfileIn(__METHOD__);

		// try to get cached data
		$key = $this->getKey('stats4');

		$stats = F::app()->wg->memc->get($key);
		if (empty($stats)) {
			wfProfileIn(__METHOD__ . '::miss');
			wfDebug(__METHOD__ . ": cache miss\n");

			// get edit points / first edit date
			$dbr = wfGetDB(DB_SLAVE);
			$stats = $this->doStatsQuery($dbr);

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if (!empty($stats)) {
				F::app()->wg->memc->set($key, $stats, self::CACHE_TTL);
			}

			wfProfileOut(__METHOD__ . '::miss');
		}

		// allow other extensions to update edits points
		$stats['points'] = isset($stats['edits']) ? $stats['edits'] : 0;
		wfRunHooks('Masthead::editCounter', array(&$stats['points'], User::newFromId($this->userId)));

		wfProfileOut(__METHOD__);
		return $stats;
	}

	/**
	 * Get likes count, edit points and date of first edit done by the user on wiki with provided $wikiId
	 *
	 * @param int $wikiId city_id of a wiki
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function getGlobalStats($wikiId) {
		wfProfileIn(__METHOD__);

		// try to get cached data
		$key = $this->getKey('stats5' . self::GET_GLOBAL_STATS_CACHE_VER);
		$stats = F::app()->wg->memc->get($key);

		if( empty($stats) ) {
			wfProfileIn(__METHOD__ . '::miss');
			wfDebug(__METHOD__ . ": cache miss\n");

			$wikiDbName = WikiFactory::IDtoDB($wikiId);

			if( !empty($wikiDbName) ) {
				// get edit points / first edit date
				$dbr = wfGetDB( DB_SLAVE, array(), $wikiDbName );
				$stats = $this->doStatsQuery($dbr);

				// TODO: get likes
				$stats['likes'] = 20 + ($this->userId % 50);

				if( !empty($stats) ) {
					F::app()->wg->memc->set($key, $stats, self::CACHE_TTL);
				}
			}

			wfProfileOut(__METHOD__ . '::miss');
		}

		// allow other extensions to update edits points
		$stats['points'] = isset($stats['edits']) ? $stats['edits'] : 0;
		wfRunHooks('Masthead::editCounter', array(&$stats['points'], User::newFromId($this->userId)));

		wfProfileOut(__METHOD__);
		return $stats;
	}

	/**
	 * @desc Sends a query to database and returns an array based on database results; used by UserStatsService::getStats() and UserStatsService::getGlobalStats()
	 * @param $dbr
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	private function doStatsQuery($dbr) {
		$stats = array();

		$res = $dbr->selectRow(
			'revision',
			array('min(rev_timestamp) AS date, count(*) AS edits'),
			array('rev_user' => $this->userId),
			__METHOD__
		);

		if( !empty($res) ) {
			$stats = array(
				'edits' => intval($res->edits),
				'date' => $res->date,
			);
		}

		return $stats;
	}
}
