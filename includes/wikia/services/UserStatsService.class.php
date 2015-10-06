<?php
class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const GET_GLOBAL_STATS_CACHE_VER = 'v1.0';

	private $userId;
	private $user;
	private $optionsAllWikis;

	/**
	 * Pass user ID of user you want to get data about
	 */
	function __construct($userId) {
		$this->userId = intval($userId);
		$this->user = null;
		$this->optionsAllWikis = array();
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
	 * Counts contributions from revision and archive
	 * and resets value in wikia_user_properties table
	 * for specified wiki.
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param int $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return Int Number of edits
	 */
	public function resetEditCountWiki( $wikiId = 0 ) {
		wfProfileIn(__METHOD__);

		$dbName = false;
		if ( $wikiId != 0 ) {
			$dbName = WikiFactory::IDtoDB( $wikiId );
		} else {
			$wikiId = $this->wg->CityId;
		}

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

		// Store editcount value
		$this->setOptionWiki( 'editcount', $editCount, $wikiId );

		wfProfileOut(__METHOD__);
		return $editCount;
	}

	/**
	 * Get the user's edit count for specified wiki.
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param Int $userId  Id of user
	 * @param Int $wikiId  Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param Boolean $skipCache  On true ignores cache
	 * @return Int Number of edits
	 */
	public function getEditCountWiki( $wikiId = 0, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( $wikiId == 0 ) ? $this->wg->CityId : $wikiId ;

		$editCount = $this->getOptionWiki( 'editcount', $wikiId, $skipCache );

		if( $editCount === null or $editCount === false ) { // editcount has not been initialized. do so.

			$editCount = $this->resetEditCountWiki( $wikiId );

		}

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
	public function getEditCountGlobal( $wikiId = 0, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$key = wfSharedMemcKey( 'editcount-global', $this->userId );

		if ( !$skipCache ) {

			$editCount = $this->wg->Memc->get($key);

			if ( !empty( $editCount ) ) {
				wfProfileOut( __METHOD__ );
				return $editCount;
			}

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

			$dbName = ( $wikiId == 0 ) ? false : WikiFactory::IDtoDB( $wikiId );
			$dbw = wfGetDB( DB_MASTER, array(), $dbName );

			// write to wikicities (acting 'user' will redirect result to wikicities)
			$dbw->update(
				'user',
				array( 'user_editcount' => $editCount ),
				array( 'user_id' => $this->userId ),
				__METHOD__
			);

		} else {
			$editCount = $field;
		}

		$this->wg->Memc->set( $key, $editCount, 86400 );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}


	/**
	 * Get user options localized per wiki, load if necessary
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param Integer $wikiId Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param bool $skipCache skip cache, reload from DB
	 * @return array
	 */
	public function getOptionsWiki( $wikiId = 0, $skipCache = false ) {
		wfProfileIn(__METHOD__);

		if ( !empty( $this->optionsAllWikis[ $wikiId ] ) ) {
			wfProfileOut( __METHOD__ );
			return $this->optionsAllWikis[ $wikiId ];
		}

		wfProfileOut( __METHOD__ );
		return $this->loadOptionsWiki( $wikiId, $skipCache );
	}


	/**
	 * Load user options localized per wiki from DB
	 * (wikia_user_properties table)
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param $wikiId Integer $wikiId Id of wiki - specifies wiki from which to load editcount, 0 for current wiki
	 * @param bool $skipCache, skip cache, reload from DB
	 * @return array
	 */
	private function loadOptionsWiki( $wikiId = 0, $skipCache = false ) {
		wfProfileIn(__METHOD__);
		$wikiId = ( $wikiId == 0 ) ? $this->wg->CityId : $wikiId ;

		/* Get option value from memcache */
		$key = wfSharedMemcKey( 'optionsWiki', $wikiId, $this->userId );

		if ( !$skipCache ) {

			$this->optionsAllWikis[ $wikiId ] = $this->wg->Memc->get( $key );

			if ( !empty( $this->optionsAllWikis[ $wikiId ] ) ) {
				wfProfileOut( __METHOD__ );
				return $this->optionsAllWikis[ $wikiId ];
			}

		}

		$dbName = ( $wikiId == $this->wg->CityId ) ? false : WikiFactory::IDtoDB( $wikiId );

		/* Get option value from wiki specific user properties */
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );
		$res = $dbr->select(
			'wikia_user_properties',
			array ( 'wup_property', 'wup_value' ),
			array(
				'wup_user' => $this->userId
			),
			__METHOD__
		);
		$this->optionsAllWikis[ $wikiId ] = array();
		foreach( $res as $row ) {
			$this->optionsAllWikis[ $wikiId ][ $row->wup_property ] = $row->wup_value;
		}
		$this->wg->Memc->set( $key, $this->optionsAllWikis[ $wikiId ], self::CACHE_TTL );

		wfProfileOut( __METHOD__ );
		return $this->optionsAllWikis[ $wikiId ];
	}


	/**
	 * Update localized value of editcount in wikia_user_properties
	 * and bump mcached values for stats and localized user options
	 */
	function increaseEditsCount() {
		wfProfileIn(__METHOD__);

		// update edit counts in stats
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

		//update edit counts in options
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'wikia_user_properties',
			array( 'wup_value=wup_value+1' ),
			array( 'wup_user' => $this->userId,
				'wup_property' => 'editcount' ),
			__METHOD__ );

		if ($dbw->affectedRows() == 1) {
			//increment memcache also
			$key = wfSharedMemcKey( 'optionsWiki', $this->wg->CityId, $this->userId );
			$optionsWiki = $this->wg->Memc->get( $key );

			$optionsWiki[ 'editcount' ]++;
			$this->wg->Memc->set( $key, $optionsWiki, self::CACHE_TTL );
		} else {
			//initialize editcount skipping memcache
			$this->getEditCountWiki( 0, true );
		}

		wfProfileOut(__METHOD__);
		return true;
	}


	/**
	 * Get likes count, edit points and date of first edit done by the user
	 */
	public function getStats() {
		wfProfileIn(__METHOD__);

		// try to get cached data
		$key = $this->getKey('stats4');

		$stats = $this->wg->memc->get($key);
		if (empty($stats)) {
			wfProfileIn(__METHOD__ . '::miss');
			wfDebug(__METHOD__ . ": cache miss\n");

			// get edit points / first edit date
			$stats = array();

			$stats[ 'lastRevision' ] = $this->getLastContributionTimestamp();
			$stats[ 'date' ] = $this->getFirstContributionTimestamp();
			$stats[ 'edits' ] = $this->getEditCountWiki();

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

			// get edit points / first edit date and last edit date
			$stats = array();

			$stats[ 'lastRevision' ] = $this->getLastContributionTimestamp( $wikiId );
			$stats[ 'date' ] = $this->getFirstContributionTimestamp( $wikiId );
			$stats[ 'edits' ] = $this->getEditCountWiki( $wikiId );

			// TODO: get likes
			$stats['likes'] = 20 + ($this->userId % 50);

			if( !empty($stats) ) {
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
	 * Retrives wiki specific user option
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param String $optionName  name of wiki specific user option
	 * @param int $wikiId Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param boolean $skipCache On true ignores cache
	 * @return String|null $optionVal
	 */
	public function getOptionWiki( $optionName, $wikiId = 0, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		// Get all options for wiki
		$optionsWiki = $this->getOptionsWiki( $wikiId, $skipCache );

		// Return specific option
		if ( isset( $optionsWiki[ $optionName ] ) ) {
			wfProfileOut( __METHOD__ );
			return $optionsWiki[ $optionName ];
		}

		wfProfileOut( __METHOD__ );
		return null;
	}


	/**
	 * Sets wiki specific user option
	 * into wikia_user_properties table from wiki DB
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param String $optionName name of wiki specific user option
	 * @param String $optionValue option value to be set
	 * @param int $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return $optionVal string|null
	 */
	public function setOptionWiki( $optionName, $optionVal, $wikiId = 0 ) {

		wfProfileIn( __METHOD__ );

		$dbName = false;
		if ( $wikiId != 0 ) {
			$dbName = WikiFactory::IDtoDB( $wikiId );
		} else {
			$wikiId = $this->wg->CityId;
		}

		$this->loadOptionsWiki( $wikiId ); // checks if isset and loads if empty (to make sure we don't loose anything

		$dbw = $this->getWikiDB( DB_MASTER, $dbName );
		$dbw->replace(
			'wikia_user_properties',
			array(),
			array( 'wup_user' => $this->userId,
				'wup_property' => $optionName,
				'wup_value' => $optionVal ),
			__METHOD__
		);

		$this->optionsAllWikis[ $wikiId ][ $optionName ] = $optionVal;

		$key = wfSharedMemcKey( 'optionsWiki', $wikiId, $this->userId );
		$this->wg->Memc->set( $key, $this->optionsAllWikis[ $wikiId ], self::CACHE_TTL );

		wfProfileOut( __METHOD__ );
		return $optionVal;
	}


	/**
	 * Get timestamp of first user's contribution on specified wiki.
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return String Timestamp in format YmdHis e.g. 20131107192200 or null
	 */
	private function getFirstContributionTimestamp( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$firstContributionTimestamp = $this->getOptionWiki( 'firstContributionTimestamp', $wikiId );

		if( empty( $firstContributionTimestamp ) ) {
			// firstContributionTimestamp has not been initialized. do so.
			$firstContributionTimestamp = $this->initFirstContributionTimestamp( $wikiId );
		}

		wfProfileOut( __METHOD__ );
		return $firstContributionTimestamp;
	}


	/**
	 * Initialize firstContributionTimestamp in wikia specific user properties from revision table
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param int $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return String Timestamp in format YmdHis e.g. 20131107192200 or empty string
	 */
	private function initFirstContributionTimestamp( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbName = false;
		if ( $wikiId != 0 ) {
			$dbName = WikiFactory::IDtoDB( $wikiId );
		} else {
			$wikiId = $this->wg->CityId;
		}

		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );

		$res = $dbr->selectRow(
			'revision',
			array('min(rev_timestamp) AS firstContributionTimestamp'),
			array('rev_user' => $this->userId),
			__METHOD__
		);
		$firstContributionTimestamp = null;
		if( !empty($res) ) {
			$firstContributionTimestamp = $res->firstContributionTimestamp;
			$this->setOptionWiki( 'firstContributionTimestamp', $firstContributionTimestamp, $wikiId );
		}

		wfProfileOut( __METHOD__ );
		return $firstContributionTimestamp;
	}


	/**
	 * Get timestamp of last (most recent) user's contribution on specified wiki.
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return String Timestamp in format YmdHis e.g. 20131107192200 or null
	 */
	private function getLastContributionTimestamp( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbName = ( $wikiId == 0 ) ? false : WikiFactory::IDtoDB( $wikiId );

		/* Get lastContributionTimestamp from database */
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );

		$res = $dbr->selectRow(
			'revision',
			array('max(rev_timestamp) AS lastContributionTimestamp'),
			array('rev_user' => $this->userId),
			__METHOD__
		);
		$lastContributionTimestamp = null;
		if( !empty($res) ) {
			$lastContributionTimestamp = $res->lastContributionTimestamp;
		}

		wfProfileOut( __METHOD__ );
		return $lastContributionTimestamp;
	}

}
