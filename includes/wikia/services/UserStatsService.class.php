<?php

use Wikia\Logger\WikiaLogger;

class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const CACHE_VERSION = 'v1.0';
	const USER_STATS_PROPERTIES = [
		'editcount',
		'editcountThisWeek',
		'firstContributionTimestamp',
		'lastContributionTimestamp'
	];

	private $userId;
	private $wikiId;

	/**
	 * Pass user ID of user you want to get data about
	 * @param int $userId User ID
	 * @param int $wikiId Wiki ID (skip for current wiki)
	 */
	function __construct( $userId, $wikiId = 0 ) {
		$this->userId = intval( $userId );
		parent::__construct();
		$this->initWikiId( $wikiId );
	}

	/**
	 * Get the user's edit count for specified wiki.
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 * @return Int Number of edits
	 */
	public function getEditCountWiki() {
		wfProfileIn( __METHOD__ );

		$stats = $this->getStats();

		wfProfileOut( __METHOD__ );
		return $stats['editcount'];
	}

	/**
	 * Get the user's edit count from last week for specified wiki.
	 *
	 * @return int Number of edits
	 */
	public function getEditCountFromWeek() {
		wfProfileIn( __METHOD__ );

		$stats = $this->getStats();

		wfProfileOut( __METHOD__ );
		return (int)$stats['editcountThisWeek'];
	}

	/**
	 * Update localized value of editcount and editcountThisWeek in wikia_user_properties
	 * and bump mcached values for stats and localized user options
	 */
	public function increaseEditsCount() {
		wfProfileIn( __METHOD__ );

		$stats = $this->getStats( Title::GAID_FOR_UPDATE );

		// update edit counts on wiki
		$this->updateEditCount( 'editcount' );
		$stats['editcount']++;

		// update weekly edit counts on wiki
		$this->updateEditCount( 'editcountThisWeek' );
		$stats['editcountThisWeek']++;

		// update last revision timestamp
		$stats['lastRevisionTimestamp'] = $this->initLastContributionTimestamp();

		// first user edit on given wiki
		if ( $stats['editcount'] === 1 ) {
			wfRunHooks( 'UserFirstEditOnLocalWiki', [ $this->userId, $this->getWikiId() ] );
		}

		wfProfileOut( __METHOD__ );
	}


	/**
	 * Get user wiki contributions details like
	 * - first contribution date
	 * - last contribution date
	 * - number of edits on given wiki
	 * - number of edits in current week
	 * @return array
	 */
	public function getStats( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$stats = WikiaDataAccess::cacheWithLock(
			self::getUserStatsMemcKey( $this->userId, $this->getWikiId() ),
			self::CACHE_TTL,
			function () use ( $flags ) {
				$stats = $this->loadUserStatsFromDB();

				if ( empty( $stats['editcount'] ) ) {
					$stats['editcount'] = $this->calculateEditCountWiki( $flags );
				}

				if ( empty( $stats['editcount'] ) ) {
					return [
						'firstContributionTimestamp' => null,
						'lastRevisionDate' => null,
						'edits' => 0,
						'editsThisWeek' => 0
					];
				}

				if ( isset( $stats['editcountThisWeek'] ) ) {
					$stats['editcountThisWeek'] = $this->calculateEditCountFromWeek( $flags );
				}

				if ( empty( $stats['firstContributionTimestamp'] ) ) {
					$stats['firstContributionTimestamp'] = $this->initFirstContributionTimestamp();
				}

				if ( empty( $stats['firstContributionTimestamp'] ) ) {
					$stats['lastContributionTimestamp'] = $this->initLastContributionTimestamp();
				}

				return $stats;
			}
		);

		wfProfileOut( __METHOD__ );
		return $stats;
	}

	public static function purgeOptionsWikiCache( $userId, $wikiId ) {
		global $wgMemc;

		$wgMemc->delete( self::getUserStatsMemcKey( $userId, $wikiId ) );
	}

	/**
	 * Counts contributions from revision and archive
	 * and resets value in wikia_user_properties table
	 * for specified wiki.
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	public function calculateEditCountWiki( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase( $flags );

		$editCount = $dbr->selectField(
			'revision', 'count(*)',
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$editCount += $dbr->selectField(
			'archive', 'count(*)',
			[ 'ar_user_text' => User::newFromId( $this->userId )->getName() ],
			__METHOD__
		);

		$this->setUserStat( 'editcount', $editCount );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	private function updateEditCount( $propertyName ) {
		wfProfileIn( __METHOD__ );

		//update edit counts in options
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'wikia_user_properties',
			[ 'wup_value=wup_value+1' ],
			[ 'wup_user' => $this->userId, 'wup_property' => $propertyName ],
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return $dbw->affectedRows() === 1;
	}

	/**
	 * Counts contributions in last week from revision and archive
	 * and resets value in wikia_user_properties table
	 * for specified wiki.
	 *
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	private function calculateEditCountFromWeek( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase( $flags );

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
				'ar_user_text' => User::newFromId( $this->userId )->getName(),
				'ar_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))'
			],
			__METHOD__
		);

		$this->setUserStat( 'editcountThisWeek', $editCount );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	/**
	 * Load user options localized per wiki from DB
	 * (wikia_user_properties table)
	 * @since Nov 2013
	 * @author Kamil Koterba
	 * @return array
	 */
	private function loadUserStatsFromDB() {
		wfProfileIn(__METHOD__);
		$stats = [];

		$wikiId = $this->getWikiId();

		/* Get option value from wiki specific user properties */
		$dbr = $this->getDatabase( $wikiId );
		$res = $dbr->select(
			'wikia_user_properties',
			[ 'wup_property', 'wup_value' ],
			[ 'wup_user' => $this->userId, 'wup_property' => self::USER_STATS_PROPERTIES ],
			__METHOD__
		);

		foreach( $res as $row ) {
			$stats[ $row->wup_property ] = $row->wup_value;
		}

		wfProfileOut( __METHOD__ );
		return $stats;
	}

	/**
	 * Sets wiki specific user option
	 * into wikia_user_properties table from wiki DB
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param String $optionName name of wiki specific user option
	 * @param String $optionValue option value to be set
	 * @return $optionVal string|null
	 */
	private function setUserStat( $statName, $statVal ) {
		wfProfileIn( __METHOD__ );
		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		$dbw->replace(
			'wikia_user_properties',
			[],
			[ 'wup_user' => $this->userId, 'wup_property' => $statName, 'wup_value' => $statVal ],
			__METHOD__
		);
		wfProfileOut( __METHOD__ );
		return $statVal;
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

		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		$res = $dbw->selectRow(
			'revision',
			[ 'min(rev_timestamp) AS firstContributionTimestamp' ],
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$firstContributionTimestamp = null;
		if( !empty( $res ) ) {
			$firstContributionTimestamp = $res->firstContributionTimestamp;
			$this->setUserStat( 'firstContributionTimestamp', $firstContributionTimestamp );
		}

		wfProfileOut( __METHOD__ );
		return $firstContributionTimestamp;
	}

	private function initLastContributionTimestamp() {
		wfProfileIn( __METHOD__ );

		/* Get lastContributionTimestamp from database */
		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		$res = $dbw->selectRow(
			'revision',
			[ 'max(rev_timestamp) AS lastContributionTimestamp' ],
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);
		$lastContributionTimestamp = null;
		if( !empty( $res ) ) {
			$lastContributionTimestamp = $res->lastContributionTimestamp;
			$this->setUserStat( 'lastContributionTimestamp', $lastContributionTimestamp );
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
		$dbName = ( $this->getWikiId() === $this->wg->CityId ) ? false : WikiFactory::IDtoDB( $this->getWikiId() );
		$dbType = ( $flags & Title::GAID_FOR_UPDATE ) ? DB_MASTER : DB_SLAVE;

		return $this->getWikiDB( $dbType, $dbName );
	}

	private static function getUserStatsMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'userStats', $wikiId, $userId, self::CACHE_VERSION );
	}
}
