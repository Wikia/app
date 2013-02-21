<?php
class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const GET_GLOBAL_STATS_CACHE_VER = 'v1.0';

	private $userId;

	/**
	 * Pass user ID of user you want to get data about
	 */
	function __construct($userId) {
		$this->userId = intval($userId);
		parent::__construct();
	}

	/**
	 * Get cache key for given entry
	 */
	private function getKey($entry) {
		return $this->wf->MemcKey('services', 'userstats', $entry, $this->userId);
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
	 * Get the user's edit count for specified wiki.
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param $userId Integer Id of user
	 * @param $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param $skipCache boolean On true ignores cache
	 * @return Int Number of edits
	 */
	public function getEditCountWiki( $wikiId = 0, $skipCache = true ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		/* Get editcount from memcache */
		$key = wfSharedMemcKey( 'editcount', $wikiId, $this->userId );
		$editCount = $this->wg->Memc->get($key);

		if ( !empty( $editCount ) && !$skipCache ) {
			$this->wf->ProfileOut( __METHOD__ );
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
			$dbw = $this->getWikiDB( DB_MASTER, array(), $dbName );
			$editCount = $dbr->selectField(
				'revision', 'count(*)',
				array( 'rev_user' => $this->userId ),
				__METHOD__
			);

			$editCount += $dbr->selectField(
				'archive', 'count(*)',
				array( 'ar_user' => $this->userId ),
				__METHOD__
			);

			$dbw->insert(
				'wikia_user_properties',
				array( 'wup_user' => $this->userId,
					'wup_property' => 'editcount',
					'wup_value' => $editCount),
				__METHOD__
			);

		} else {
			$editCount = $field;
		}

		$this->wg->Memc->set( $key,$editCount, 86400 );

		$this->wf->ProfileOut( __METHOD__ );
		return $editCount;
	}


	/**
	 * Get the user's global edit count.
	 * Functionality from getEditCount before Feb 2013
	 *
	 * Returns editcount field from user table, which is summary editcount from all wikis
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @return Int
	 */
	public function getEditCountGlobal( $userId, $wikiId, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		$key = wfSharedMemcKey( 'editcount-global', $wikiId, $userId );
		$editCount = $this->wg->Memc->get($key);

		if ( !empty( $editCount ) && !$skipCache ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $editCount;
		}

		$dbr = wfGetDB( DB_SLAVE, $this->wg->ExternalSharedDB );
		// check if the user_editcount field has been initialized
		$field = $dbr->selectField(
			'user', 'user_editcount',
			array( 'user_id' => $userId ),
			__METHOD__
		);

		$dbname = ( $wikiId != $this->wg->CityId ) ? WikiFactory::IDtoDB( $wikiId ) : false;

		if( $field === null ) { // it has not been initialized. do so.
			$dbw = wfGetDB( DB_MASTER, array(), $dbname );
			//count revisions
			$editCount = $dbr->selectField(
				'revision', 'count(*)',
				array( 'rev_user' => $userId ),
				__METHOD__
			);
			$editCount += $dbr->selectField(
				'archive', 'count(*)',
				array( 'ar_user' => $userId ),
				__METHOD__
			);
			//write to wikicities (acting 'user' will redirect result to wikicites)
			$dbw->update(
				'user',
				array( 'user_editcount' => $editCount ),
				array( 'user_id' => $userId ),
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
	 * Retrieves date of first contribution to wiki by user
	 * @param $wikiId ID of wiki
	 * @return first edit date i.e. 20061210153740
	 *
	 * @author Kamil Koterba
	 */
	private function getFirstEditDate( $wikiId = 0, $skipCache = true ) {
		$this->wf->ProfileIn( __METHOD__ );
		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		/* Get first-edit-date from memcache */
		$key = wfSharedMemcKey( 'first-edit-date', $wikiId, $this->userId );
		$firstEditDate = $this->wg->Memc->get($key);

		if ( !empty( $firstEditDate ) && !$skipCache ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $firstEditDate;
		}

		$dbName = ( $wikiId != $this->wg->CityId ) ? WikiFactory::IDtoDB( $wikiId ) : false;

		/* Get first-edit-date from database */
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );

		$firstEditDate = $dbr->selectField(
			'revision',
			'min(rev_timestamp) AS date',
			array('rev_user' => $this->userId),
			__METHOD__
		);

		$this->wg->Memc->set( $key,$firstEditDate, 86400 );

		$this->wf->ProfileOut( __METHOD__ );
		return $firstEditDate;
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
				$stats['date'] = $this->wf->TimestampNow();
			}

			$this->wg->Memc->set($key, $stats, self::CACHE_TTL);

			$this->wf->Debug(__METHOD__ . ": user #{$this->userId}\n");
		}

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Get likes count, edit points and date of first edit done by the user
	 */
	function getStats() {
		$this->wf->ProfileIn(__METHOD__);
		// try to get cached data
		$key = $this->getKey('stats4');

		$stats = $this->wg->memc->get($key);
		if (empty($stats)) {
			$this->wf->ProfileIn(__METHOD__ . '::miss');
			$this->wf->Debug(__METHOD__ . ": cache miss\n");

			// get edit points
			$stats['edits'] = $this->getEditCountWiki();

			// get first edit date
			$date = $this->getFirstEditDate();
			if ( !empty($date) ) {
				$stats['date'] = $date;
			}

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if (!empty($stats)) {
				$this->wg->memc->set($key, $stats, self::CACHE_TTL);
			}

			$this->wf->ProfileOut(__METHOD__ . '::miss');
		}

		// allow other extensions to update edits points
		$stats['points'] = isset($stats['edits']) ? $stats['edits'] : 0;
		$this->wf->RunHooks('Masthead::editCounter', array(&$stats['points'], User::newFromId($this->userId)));

		$this->wf->ProfileOut(__METHOD__);
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
		$this->wf->ProfileIn(__METHOD__);

		// try to get cached data
		$key = $this->getKey('stats5' . self::GET_GLOBAL_STATS_CACHE_VER);
		$stats = $this->wg->memc->get($key);

		if( empty($stats) ) {
			$this->wf->ProfileIn(__METHOD__ . '::miss');
			$this->wf->Debug(__METHOD__ . ": cache miss\n");


			// get edit points
			$stats['edits'] = $this->getEditCountWiki( $wikiId );

			// get first edit date
			$date = $this->getFirstEditDate( $wikiId );
			if ( !empty($date) ) {
				$stats['date'] = $date;
			}

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if( !empty($stats) ) {
				$this->wg->memc->set($key, $stats, self::CACHE_TTL);
			}

			$this->wf->ProfileOut(__METHOD__ . '::miss');
		}

		// allow other extensions to update edits points
		$stats['points'] = isset($stats['edits']) ? $stats['edits'] : 0;
		$this->wf->RunHooks('Masthead::editCounter', array(&$stats['points'], User::newFromId($this->userId)));

		$this->wf->ProfileOut(__METHOD__);
		return $stats;
	}

}
