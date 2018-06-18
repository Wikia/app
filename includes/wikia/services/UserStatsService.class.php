<?php

class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const CACHE_VERSION = 'v1.2';
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
		$this->wikiId = ( $wikiId === 0 ) ? $this->wg->CityId : $wikiId;
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
			return;
		}

		$stats = $this->getStats();

		$this->setUserStat( 'editcount', ++$stats['editcount'] );
		$this->setUserStat( 'editcountThisWeek', ++$stats['editcountThisWeek'] );

		$now = wfTimestampNow();

		// if first revision timestamp was not known before - this is their first edit, set it now!
		if ( empty( $stats['firstContributionTimestamp'] ) ) {
			$stats['firstContributionTimestamp'] = $now;
			$this->setUserStat( 'firstContributionTimestamp', $now );
		}

		// update last revision timestamp
		$stats['lastContributionTimestamp'] = $now;
		$this->setUserStat( 'lastContributionTimestamp', $now );

		$wgMemc->set(
			self::getUserStatsMemcKey( $this->userId, $this->wikiId ),
			$stats,
			self::CACHE_TTL
		);

		// first user edit on given wiki
		if ( $stats['editcount'] === 1 ) {
			Hooks::run( 'UserFirstEditOnLocalWiki', [ $this->userId, $this->wikiId ] );
		}
	}

	/**
	 * Get user wiki contributions details like
	 * - first contribution date
	 * - last contribution date
	 * - number of edits on given wiki
	 * - number of edits in current week
	 * @return array
	 */
	public function getStats() {
		// anons don't have edit stats
		if ( !$this->validateUser() ) {
			return [
				'firstContributionTimestamp' => null,
				'lastContributionTimestamp' => null,
				'editcount' => 0,
				'editcountThisWeek' => 0
			];
		}

		$stats = WikiaDataAccess::cache(
			self::getUserStatsMemcKey( $this->userId, $this->wikiId ),
			self::CACHE_TTL,
			function () {
				$stats = $this->loadUserStatsFromDB();

				if ( !isset( $stats['editcount'] ) ) {
					// editcount not set yet, so user has no edits
					return [
						'firstContributionTimestamp' => null,
						'lastContributionTimestamp' => null,
						'editcount' => 0,
						'editcountThisWeek' => 0
					];
				} else {
					// make sure this value is an integer
					$stats['editcount'] = (int) $stats['editcount'];
					$stats['editcountThisWeek'] = (int) ( $stats['editcountThisWeek'] ?? 0);
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
	 * Load user stats localized per wiki from DB
	 * (wikia_user_properties table)
	 * @since Nov 2013
	 * @author Kamil Koterba
	 * @return array
	 */
	private function loadUserStatsFromDB() {
		$stats = [];

		/* Get option value from wiki specific user properties */
		$dbName = ( $this->wikiId === $this->wg->CityId ) ? false : WikiFactory::IDtoDB( $this->wikiId );
		$dbr = $this->getWikiDB( DB_SLAVE, $dbName );

		$res = $dbr->select(
			'wikia_user_properties',
			[ 'wup_property', 'wup_value' ],
			[ 'wup_user' => $this->userId, 'wup_property' => self::USER_STATS_PROPERTIES ],
			__METHOD__
		);

		foreach( $res as $row ) {
			$stats[ $row->wup_property ] = $row->wup_value;
		}

		return $stats;
	}

	/**
	 * Sets wiki specific user option
	 * into wikia_user_properties table from wiki DB
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param String $statName name of wiki specific user stat
	 * @param String $statVal stat value to be set
	 */
	private function setUserStat( $statName, $statVal ) {
		if ( !$this->validateUser() || wfReadOnly() ) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER );

		$dbw->update(
			'wikia_user_properties',
			[ 'wup_value' => $statVal ],
			[
				'wup_user' => $this->userId,
				'wup_property' => $statName,
			],
			__METHOD__
		);

		// SUS-4773: In the vast majority of cases the above UPDATE will have handled setting proper edit count
		// We only need to INSERT if this is the user's first edit on this wiki
		if ( !$dbw->affectedRows() ) {
			$dbw->upsert(
				'wikia_user_properties',
				[
					 'wup_user' => $this->userId,
					 'wup_property' => $statName,
					 'wup_value' => $statVal
				 ],
				[ [ 'wup_user', 'wup_property' ] ],
				[ 'wup_value = wup_value + 1' ],
				__METHOD__
			);
		}
	}

	private static function getUserStatsMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'userStats', $wikiId, $userId, self::CACHE_VERSION );
	}

	private function validateUser() {
		return $this->userId > 0;
	}
}
