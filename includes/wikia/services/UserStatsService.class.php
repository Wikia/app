<?php
class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const GET_GLOBAL_STATS_CACHE_VER = 'v1.0';

	private $userId;
	private $user;
	private $wikiId;
	private $optionsAllWikis;

	/**
	 * Pass user ID of user you want to get data about
	 */
	function __construct( $userId, $wikiId = 0 ) {
		$this->userId = intval( $userId );
		$this->user = null;
		$this->optionsAllWikis = [];
		$this->initWikiId( $wikiId );
		parent::__construct();
	}

	public function setWikiId( $wikiId ) {
		$this->wikiId = $wikiId;
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
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	public function resetEditCountWiki( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase( $flags );

		$userName = $this->getUser()->getName();

		$editCount = $dbr->selectField(
			'revision', 'count(*)',
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$editCount += $dbr->selectField(
			'archive', 'count(*)',
			[ 'ar_user_text' => $userName ],
			__METHOD__
		);

		// Store editcount value
		$this->setOptionWiki( 'editcount', $editCount );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	/**
	 * Get the user's edit count for specified wiki.
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param Int $wikiId  Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param Boolean $skipCache  On true ignores cache
	 * @param int $flags bit flags with options
	 * @return Int Number of edits
	 */
	public function getEditCountWiki( $skipCache = false, $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$editCount = $this->getOptionWiki( 'editcount', $skipCache );

		if( $editCount === null || $editCount === false ) { // editcount has not been initialized. do so.
			$editCount = $this->resetEditCountWiki( $flags );
		}

		wfProfileOut( __METHOD__ );
		return (int)$editCount;
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
	public function getEditCountGlobal( $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$key = self::getUserGlobalCountMemcKey( $this->userId );

		if ( !$skipCache ) {
			$editCount = $this->wg->Memc->get( $key );

			if ( !empty( $editCount ) ) {
				wfProfileOut( __METHOD__ );
				return $editCount;
			}
		}

		$dbr = wfGetDB( DB_SLAVE, $this->wg->ExternalSharedDB );
		// check if the user_editcount field has been initialized
		$field = $dbr->selectField(
			'user', 'user_editcount',
			[ 'user_id' => $this->userId ],
			__METHOD__
		);

		if( $field === null ) { // it has not been initialized. do so.
			$userName = $this->getUser()->getName();

			//count revisions
			$editCount = $dbr->selectField(
				'revision', 'count(*)',
				[ 'rev_user' => $this->userId ],
				__METHOD__
			);
			$editCount += $dbr->selectField(
				'archive', 'count(*)',
				[ 'ar_user' => $userName ],
				__METHOD__
			);

			$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
			// write to wikicities (acting 'user' will redirect result to wikicities)
			$dbw->update(
				'user',
				[ 'user_editcount' => $editCount ],
				[ 'user_id' => $this->userId ],
				__METHOD__
			);

		} else {
			$editCount = $field;
		}

		$this->wg->Memc->set( $key, $editCount, 86400 );

		wfProfileOut( __METHOD__ );
		return (int)$editCount;
	}

	/**
	 * Get the user's edit count from last week for specified wiki.
	 *
	 * @param Int $wikiId  Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param Boolean $skipCache  On true ignores cache
	 * @return Int Number of edits
	 */
	public function getEditCountFromWeek( $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$editCount = $this->getOptionWiki( 'editcountThisWeek', $skipCache );

		if( $editCount === null || $editCount === false ) { // editcount has not been initialized. do so.
			$editCount = $this->calculateEditCountFromWeek();
		}

		wfProfileOut( __METHOD__ );
		return (int)$editCount;
	}

	/**
	 * Update localized value of editcount and editcountThisWeek in wikia_user_properties
	 * and bump mcached values for stats and localized user options
	 */
	public function increaseEditsCount() {
		wfProfileIn( __METHOD__ );

		// update edit counts in stats
		self::purgeStatsCache( $this->userId, $this->getWikiId() );

		// update edit counts on wiki
		$editCount = $this->getOptionWiki( 'editcount' );
		if ( !is_null( $editCount ) ) {
			$this->updateEditCount( 'editcount' );
		} else {
			$this->resetEditCountWiki( Title::GAID_FOR_UPDATE );
		}

		// update weekly edit counts on wiki
		$editCount = $this->getOptionWiki( 'editcountThisWeek' );
		if ( !is_null( $editCount ) ) {
			$this->updateEditCount( 'editcountThisWeek' );
		} else {
			$this->calculateEditCountFromWeek( Title::GAID_FOR_UPDATE );
		}

		// update last revision timestamp
		$this->initLastContributionTimestamp();

		wfProfileOut( __METHOD__ );
	}


	/**
	 * Get likes count, edit points and date of first edit done by the user
	 */
	public function getStats() {
		wfProfileIn( __METHOD__ );

		// try to get cached data
		$key = self::getStatsMemcKey( $this->userId, $this->getWikiId() );

		$stats = $this->wg->memc->get( $key );
		if ( empty( $stats ) ) {
			wfProfileIn( __METHOD__ . '::miss' );
			wfDebug( __METHOD__ . ": cache miss\n" );

			// get edit points / first edit date
			$stats = $this->getStatsData();

			if ( !empty( $stats ) ) {
				$this->wg->memc->set( $key, $stats, self::CACHE_TTL );
			}

			wfProfileOut( __METHOD__ . '::miss' );
		}

		// allow other extensions to update edits points
		$stats['points'] = isset( $stats['edits'] ) ? $stats['edits'] : 0;
		wfRunHooks( 'Masthead::editCounter', [ &$stats['points'], User::newFromId( $this->userId )] );

		wfProfileOut( __METHOD__ );
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
	public function getGlobalStats() {
		wfProfileIn(__METHOD__);

		$stats = $this->getStats();

		wfProfileOut(__METHOD__);
		return $stats;
	}

	public static function purgeStatsCache( $userId, $wikiId ) {
		global $wgMemc;

		$wgMemc->delete( self::getStatsMemcKey( $userId, $wikiId ) );
	}

	public static function purgeOptionsWikiCache( $userId, $wikiId ) {
		global $wgMemc;

		$wgMemc->delete( self::getOptionsWikiMemcKey( $userId, $wikiId ) );
	}

	public static function purgeUserGlobalCountCache( $userId ) {
		global $wgMemc;

		$wgMemc->delete( self::getUserGlobalCountMemcKey( $userId ) );
	}

	private function updateEditCount( $propertyName ) {
		//update edit counts in options
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'wikia_user_properties',
			[ 'wup_value=wup_value+1' ],
			[ 'wup_user' => $this->userId, 'wup_property' => $propertyName ],
			__METHOD__
		);

		if ( $dbw->affectedRows() === 1 ) {
			//increment memcache also
			$key = self::getOptionsWikiMemcKey( $this->userId, $this->getWikiId() );
			$optionsWiki = $this->wg->Memc->get( $key );

			$optionsWiki[ $propertyName ]++;
			$this->wg->Memc->set( $key, $optionsWiki, self::CACHE_TTL );
		}
	}

	/**
	 * Counts contributions in last week from revision and archive
	 * and resets value in wikia_user_properties table
	 * for specified wiki.
	 *
	 * @param int $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	private function calculateEditCountFromWeek( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase( $flags );
		$userName = $this->getUser()->getName();

		$editCount = $dbr->selectField(
			'revision', 'count(*)',
			[
				'rev_user' => $this->userId,
				'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))'
			],
			__METHOD__
		);

		$editCount += $dbr->selectField(
			'archive', 'count(*)',
			[
				'ar_user_text' => $userName,
				'ar_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))'
			],
			__METHOD__
		);

		// Store editcount value
		$this->setOptionWiki( 'editcountThisWeek', $editCount );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	private function getStatsData() {
		$stats[ 'lastRevision' ] = $this->getLastContributionTimestamp();
		$stats[ 'date' ] = $this->getFirstContributionTimestamp();
		$stats[ 'edits' ] = $this->getEditCountWiki();
		$stats[ 'editsThisWeek'] = $this->getEditCountFromWeek();

		return $stats;
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
	private function getOptionsWiki( $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		$wikiId = $this->getWikiId();

		if ( !$skipCache && !empty( $this->optionsAllWikis[ $wikiId ] ) ) {
			wfProfileOut( __METHOD__ );
			return $this->optionsAllWikis[ $wikiId ];
		}

		wfProfileOut( __METHOD__ );
		return $this->loadOptionsWiki( $skipCache );
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
	private function loadOptionsWiki( $skipCache = false ) {
		wfProfileIn(__METHOD__);
		$wikiId = $this->getWikiId();

		/* Get option value from memcache */
		$key = self::getOptionsWikiMemcKey( $this->userId, $wikiId );

		if ( !$skipCache ) {
			$this->optionsAllWikis[ $wikiId ] = $this->wg->Memc->get( $key );

			if ( !empty( $this->optionsAllWikis[ $wikiId ] ) ) {
				wfProfileOut( __METHOD__ );
				return $this->optionsAllWikis[ $wikiId ];
			}
		}

		/* Get option value from wiki specific user properties */
		$dbr = $this->getDatabase( $wikiId );
		$res = $dbr->select(
			'wikia_user_properties',
			[ 'wup_property', 'wup_value' ],
			[ 'wup_user' => $this->userId ],
			__METHOD__
		);
		$this->optionsAllWikis[ $wikiId ] = [];
		foreach( $res as $row ) {
			$this->optionsAllWikis[ $wikiId ][ $row->wup_property ] = $row->wup_value;
		}
		$this->wg->Memc->set( $key, $this->optionsAllWikis[ $wikiId ], self::CACHE_TTL );

		wfProfileOut( __METHOD__ );
		return $this->optionsAllWikis[ $wikiId ];
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
	private function getOptionWiki( $optionName, $skipCache = false ) {
		wfProfileIn( __METHOD__ );

		// Get all options for wiki
		$optionsWiki = $this->getOptionsWiki( $skipCache );

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
	private function setOptionWiki( $optionName, $optionVal ) {
		wfProfileIn( __METHOD__ );

		$wikiId = $this->getWikiId();

		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		$dbw->replace(
			'wikia_user_properties',
			[],
			[ 'wup_user' => $this->userId, 'wup_property' => $optionName, 'wup_value' => $optionVal ],
			__METHOD__
		);

		$this->loadOptionsWiki( $wikiId ); // checks if isset and loads if empty (to make sure we don't loose anything
		$this->optionsAllWikis[ $wikiId ][ $optionName ] = $optionVal;

		$key = self::getOptionsWikiMemcKey( $this->userId, $wikiId );
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
	public function getFirstContributionTimestamp() {
		wfProfileIn( __METHOD__ );

		$firstContributionTimestamp = $this->getOptionWiki( 'firstContributionTimestamp' );

		if( empty( $firstContributionTimestamp ) ) {
			// firstContributionTimestamp has not been initialized. do so.
			$firstContributionTimestamp = $this->initFirstContributionTimestamp();
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
	private function getLastContributionTimestamp() {
		wfProfileIn( __METHOD__ );

		$lastContributionTimestamp = $this->getOptionWiki( 'lastContributionTimestamp' );

		if ( empty( $lastContributionTimestamp ) ) {
			// lastContributionTimestamp has not been initialized. do so.
			$lastContributionTimestamp = $this->initLastContributionTimestamp();
		}

		wfProfileOut( __METHOD__ );
		return $lastContributionTimestamp;
	}

	/**
	 * Initialize firstContributionTimestamp in wikia specific user properties from revision table
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param int $wikiId Integer Id of wiki - specifies wiki from which to get editcount, 0 for current wiki
	 * @return String Timestamp in format YmdHis e.g. 20131107192200 or empty string
	 */
	private function initFirstContributionTimestamp() {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase();
		$res = $dbr->selectRow(
			'revision',
			[ 'min(rev_timestamp) AS firstContributionTimestamp' ],
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$firstContributionTimestamp = null;
		if( !empty( $res ) ) {
			$firstContributionTimestamp = $res->firstContributionTimestamp;
			$this->setOptionWiki( 'firstContributionTimestamp', $firstContributionTimestamp );
		}

		wfProfileOut( __METHOD__ );
		return $firstContributionTimestamp;
	}

	private function initLastContributionTimestamp() {
		/* Get lastContributionTimestamp from database */
		$dbr = $this->getDatabase();
		$res = $dbr->selectRow(
			'revision',
			[ 'max(rev_timestamp) AS lastContributionTimestamp' ],
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);
		$lastContributionTimestamp = null;
		if( !empty( $res ) ) {
			$lastContributionTimestamp = $res->lastContributionTimestamp;
			$this->setOptionWiki( 'lastContributionTimestamp', $lastContributionTimestamp );
		}

		wfProfileOut( __METHOD__ );
		return $lastContributionTimestamp;
	}

	private function initWikiId( $wikiId ) {
		$this->wikiId = ( $wikiId === 0 ) ? $this->wg->CityId : $wikiId;
	}

	private function getWikiId() {
		return $this->wikiId;
	}

	private function getDatabase( $flags = 0 ) {
		$dbName = ( $this->getWikiId() !== $this->wg->CityId ) ? false : WikiFactory::IDtoDB( $this->getWikiId() );
		$dbType = ( $flags & Title::GAID_FOR_UPDATE ) ? DB_MASTER : DB_SLAVE;

		return $this->getWikiDB( $dbType, $dbName );
	}

	private static function getStatsMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'services', 'userstats', 'stats4', $wikiId, $userId );
	}

	private static function getOptionsWikiMemcKey( $userId, $wikiId ) {
		return wfMemcKey( 'optionsWiki', $wikiId, $userId );
	}

	private static function getUserGlobalCountMemcKey( $userId ) {
		return wfSharedMemcKey( 'editcount-global', $userId );
	}

	/**
	 * Get user object based on $this->userId
	 * @return User
	 */
	private function getUser() {
		if ( empty( $this->user ) ) {
			$this->user = User::newFromId( $this->userId );
		}
		return $this->user;
	}
}
