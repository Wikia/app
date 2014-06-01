<?php
class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const GET_GLOBAL_STATS_CACHE_VER = 'v1.0';

	private $userId;
	private $user;

	/**
	 * Pass user ID of user you want to get data about
	 */
	function __construct($userId) {
		$this->userId = intval($userId);
		$this->user = null;
		parent::__construct();
	}

	/**
	 * Get user object based on $this->userId
	 * @return User
	 */
	function getUser() {
		if ( empty($this->user) ) {
			$this->user = User::newFromId( $this->userId );
		}
		return $this->user;
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
	 * Counts contributions from revision and archive
	 * and resets value in wikia_user_properties table
	 * for specified wiki.
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param $dbName String Name of wiki database, false to connect current wiki
	 * @return Int Number of edits
	 */
	public function resetEditCountWiki( $dbName = false ) {
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );
		$userName = $this->getUser()->getName();

		$editCount = $dbr->selectField(
			'revision', 'count(*)',
			array( 'rev_user' => $this->userId ),
			__METHOD__
		);

		$editCount += $dbr->selectField(
			'archive', 'count(*)',
			array( 'ar_user_text' => $userName ),
			__METHOD__
		);

		$dbw = $this->getWikiDB( DB_MASTER, $dbName );
		$dbw->replace(
			'wikia_user_properties',
			array(),
			array( 'wup_user' => $this->userId,
			'wup_property' => 'editcount',
			'wup_value' => $editCount),
			__METHOD__
		);

		return $editCount;
	}

	/**
	 * Get the user's edit count for specified wiki.
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param $userId Integer Id of user
	 * @param $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param $skipCache boolean On true ignores cache
	 * @return Int Number of edits
	 */
	public function getEditCountWiki( $wikiId = 0, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		/* Get editcount from memcache */
		$key = wfSharedMemcKey( 'editcount', $wikiId, $this->userId );
		$editCount = $this->wg->Memc->get($key);

		if ( !empty( $editCount ) && !$skipCache ) {
			wfProfileOut( __METHOD__ );
			return $editCount;
		}

		$dbName = ( $wikiId != $this->wg->CityId ) ? WikiFactory::IDtoDB( $wikiId ) : false;

		/* Get editcount from database */
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );
		$field = $dbr->selectField(
			'wikia_user_properties',
			'wup_value',
			array( 'wup_user' => $this->userId,
				'wup_property' => 'editcount' ),
			__METHOD__
		);

		if( $field === null or $field === false ) { // editcount has not been initialized. do so.

			$editCount = $this->resetEditCountWiki( $dbName );

		} else {
			$editCount = $field;
		}

		$this->wg->Memc->set( $key,$editCount, 86400 );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}


	/**
	 * Get the user's global edit count.
	 * (editcount field from user table)
	 * Functionality from User::getEditCount before Feb 2013
	 *
	 * Returns editcount field from user table, which is summary editcount from all wikis
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param $wikiId Integer Id of wiki - specifies wiki from which to init editcount, 0 for current wiki
	 * @param $skipCache boolean On true ignores cache
	 *
	 * @return Int
	 */
	public function getEditCountGlobal( $wikiId, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$key = wfSharedMemcKey( 'editcount-global', $this->userId );
		$editCount = $this->wg->Memc->get($key);

		if ( !empty( $editCount ) && !$skipCache ) {
			wfProfileOut( __METHOD__ );
			return $editCount;
		}

		$dbr = wfGetDB( DB_SLAVE, $this->wg->ExternalSharedDB );
		// check if the user_editcount field has been initialized
		$field = $dbr->selectField(
			'user', 'user_editcount',
			array( 'user_id' => $this->userId ),
			__METHOD__
		);

		if( $field === null ) { // it has not been initialized. do so.

			$userName = $this->getUser()->getName();
			
			//count revisions
			$editCount = $dbr->selectField(
				'revision', 'count(*)',
				array( 'rev_user' => $this->userId ),
				__METHOD__
			);
			$editCount += $dbr->selectField(
				'archive', 'count(*)',
				array( 'ar_user' => $userName ),
				__METHOD__
			);
			
			$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
			$dbname = ( $wikiId != $this->wg->CityId ) ? WikiFactory::IDtoDB( $wikiId ) : false;
			$dbw = wfGetDB( DB_MASTER, array(), $dbname );

			//write to wikicities (acting 'user' will redirect result to wikicites)
			$dbw->update(
				'user',
				array( 'user_editcount' => $editCount ),
				array( 'user_id' => $this->userId ),
				__METHOD__
			);

		} else {
			$editCount = $field;
		}

		$this->wg->Memc->set( $key,$editCount, 86400 );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	/**
	 * Update service cache for current user
	 */
	function increaseEditsCount() {
		wfProfileIn(__METHOD__);

		// update edit counts
		$key = $this->getKey('stats4');
		$stats = $this->wg->Memc->get($key);

		if (!empty($stats)) {
			$stats['edits']++;

			// populate 'member since' date if it's not set (i.e. it's the first edit)
			if ( empty( $stats['date'] ) && $stats['edits'] == 1 ) {
				$stats['date'] = wfTimestampNow();
			}

			$this->wg->Memc->set($key, $stats, self::CACHE_TTL);

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

		$stats = $this->wg->memc->get($key);
		if (empty($stats)) {
			wfProfileIn(__METHOD__ . '::miss');
			wfDebug(__METHOD__ . ": cache miss\n");

			// get edit points / first edit date
			$dbr = wfGetDB(DB_SLAVE);
			$stats = $this->doStatsQuery($dbr);

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if (!empty($stats)) {
				$this->wg->memc->set($key, $stats, self::CACHE_TTL);
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
		$stats = $this->wg->memc->get($key);

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
					$this->wg->memc->set($key, $stats, self::CACHE_TTL);
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
			array('min(rev_timestamp) AS date, max(rev_timestamp) AS last_revision,  count(*) AS edits'),
			array('rev_user' => $this->userId),
			__METHOD__
		);

		if( !empty($res) ) {
			$stats = array(
				'edits' => intval($res->edits),
				'date' => $res->date,
				'lastRevision' => $res->last_revision
			);
		}

		return $stats;
	}
}
