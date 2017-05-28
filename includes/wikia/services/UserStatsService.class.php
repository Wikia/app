<?php

class UserStatsService extends WikiaModel implements IDBAccessObject {

	const CACHE_TTL = 86400;
	const CACHE_VERSION = 'v2';

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
		$stats = $this->getStats();
		return $stats['editcount'];
	}

	/**
	 * Get the user's edit count from last week for specified wiki.
	 *
	 * @return int Number of edits
	 */
	public function getEditCountFromWeek() {
		$stats = $this->getStats();
		return (int)$stats['editcountThisWeek'];
	}

	/**
	 * Update localized value of editcount and editcountThisWeek in wikia_user_properties
	 * and bump mcached values for stats and localized user options
	 */
	public function increaseEditsCount() {
		global $wgMemc;

		if ( !$this->validateUser() ) {
			return false;
		}

		$stats = $this->getStats( static::READ_LATEST );

		// update edit counts on wiki
		if ( empty( $stats['editcount'] ) ) {
			$stats['editcount'] = $this->calculateEditCountWiki( static::READ_LATEST );
		} else {
			$stats['editcount'] = $stats['editcount'] + 1;
		}

		// update weekly edit counts on wiki
		if ( empty( $stats['editcountThisWeek'] ) ) {
			$stats['editcountThisWeek'] = $this->calculateEditCountFromWeek( static::READ_LATEST );
		} else {
			$stats['editcountThisWeek'] = $stats['editcountThisWeek'] + 1;
		}

		// update first revision timestamp
		if ( empty( $stats['firstContributionTimestamp']) ) {
			$stats['firstContributionTimestamp'] = $this->initFirstContributionTimestamp();
		}

		// update last revision timestamp
		$stats['lastContributionTimestamp'] = $this->initLastContributionTimestamp();

		$wgMemc->set(
			self::getUserStatsMemcKey( $this->userId, $this->getWikiId() ),
			$stats,
			self::CACHE_TTL
		);

		// first user edit on given wiki
		if ( $stats['editcount'] === 1 ) {
			wfRunHooks( 'UserFirstEditOnLocalWiki', [ $this->userId, $this->getWikiId() ] );
		}

		$this->scheduleStatsUpdateTask( $stats );
		return true;
	}

	/**
	 * Get user wiki contributions details like
	 * - first contribution date
	 * - last contribution date
	 * - number of edits on given wiki
	 * - number of edits in current week
	 * @param int $flags bitfield determining if we should read from master on cache miss
	 * @return array|UserStats
	 */
	public function getStats( $flags = 0 ) {
		$stats = WikiaDataAccess::cache(
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
						'lastContributionTimestamp' => null,
						'editcount' => 0,
						'editcountThisWeek' => 0
					];
				}

				if ( !isset( $stats['editcountThisWeek'] ) ) {
					$stats['editcountThisWeek'] = $this->calculateEditCountFromWeek( $flags );
				}

				if ( !isset( $stats['firstContributionTimestamp'] ) ) {
					$stats['firstContributionTimestamp'] = $this->initFirstContributionTimestamp();
				}

				if ( !isset( $stats['lastContributionTimestamp'] ) ) {
					$stats['lastContributionTimestamp'] = $this->initLastContributionTimestamp();
				}

				if ( $stats->needsUpdate() ) {
					$this->scheduleStatsUpdateTask( $stats );
				}

				return $stats;
			}
		);
		return $stats;
	}

	public static function purgeOptionsWikiCache( $userId, $wikiId ) {
		global $wgMemc;

		$wgMemc->delete( self::getUserStatsMemcKey( $userId, $wikiId ) );
	}

	/**
	 * Counts contributions from revision and archive tables
	 * on the specified wiki.
	 *
	 * @since Feb 2013
	 * @author Kamil Koterba
	 *
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	private function calculateEditCountWiki( $flags = 0 ) {
		if ( !$this->validateUser() ) {
			return 0;
		}

		$dbr = $this->getDatabase( $flags );

		$editCount = $dbr->selectField(
			'revision', 'count(*)',
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$editCount += $dbr->selectField(
			'archive', 'count(*)',
			[ 'ar_user' => $this->userId ],
			__METHOD__
		);

		return $editCount;
	}

	/**
	 * Counts contributions in last week from revision and archive tables
	 * for specified wiki.
	 *
	 * @param int $flags bit flags with options (ie. to force DB_MASTER)
	 * @return Int Number of edits
	 */
	private function calculateEditCountFromWeek( $flags = 0 ) {
		if ( !$this->validateUser() ) {
			return 0;
		}

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
				'ar_user' => $this->userId,
				'ar_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))'
			],
			__METHOD__
		);

		return $editCount;
	}

	/**
	 * Load user stats localized per wiki from DB
	 * (wikia_user_properties table)
	 * @since Nov 2013
	 * @author Kamil Koterba
	 * @return array|UserStats
	 */
	private function loadUserStatsFromDB() {
		$wikiId = $this->getWikiId();

		/* Get option value from wiki specific user properties */
		$dbr = $this->getDatabase( $wikiId );

		$stats = new UserStats( $this->userId );
		$stats->load( $dbr );

		return $stats;
	}

	/**
	 * Initialize firstContributionTimestamp in wikia specific user properties from revision table
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @return String Timestamp in format YmdHis e.g. 20131107192200 or empty string
	 */
	private function initFirstContributionTimestamp() {
		$dbw = $this->getDatabase( static::READ_LATEST );
		$res = $dbw->selectRow(
			'revision',
			[ 'min(rev_timestamp) AS firstContributionTimestamp' ],
			[ 'rev_user' => $this->userId ],
			__METHOD__
		);

		$firstContributionTimestamp = null;
		if( !empty( $res ) ) {
			$firstContributionTimestamp = $res->firstContributionTimestamp;
		}
		return $firstContributionTimestamp;
	}

	private function initLastContributionTimestamp() {
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
		}
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
		$dbType = ( $flags & static::READ_LATEST ) ? DB_MASTER : DB_SLAVE;

		return $this->getWikiDB( $dbType, $dbName );
	}

	/**
	 * SUS-1771: Enqueue a background task to update user stats of this user.
	 *
	 * @param UserStats $userStats updated stats to persist to database
	 */
	private function scheduleStatsUpdateTask( UserStats $userStats ) {
		$task = new \Wikia\Tasks\Tasks\UserStatsUpdateTask();
		$task->wikiId( $this->wikiId );
		$task->call( 'update', $this->userId, $userStats );
		$task->queue();
	}

	private static function getUserStatsMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'userStats', $wikiId, $userId, self::CACHE_VERSION );
	}

	private function validateUser() {
		return $this->userId > 0;
	}
}
