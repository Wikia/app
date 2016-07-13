<?php

use Wikia\Logger\WikiaLogger;

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

		$stats = $this->getStats( Title::GAID_FOR_UPDATE );

		// update edit counts on wiki
		if ( empty( $stats['editcount'] ) ) {
			$stats['editcount'] = $this->calculateEditCountWiki( Title::GAID_FOR_UPDATE );
		} elseif ( $this->updateEditCount( 'editcount' ) ) {
			$stats['editcount']++;
		}

		// update weekly edit counts on wiki
		if ( empty( $stats['editcountThisWeek'] ) ) {
			$stats['editcountThisWeek'] = $this->calculateEditCountFromWeek( Title::GAID_FOR_UPDATE );
		} elseif ( $this->updateEditCount( 'editcountThisWeek' ) ) {
			$stats['editcountThisWeek']++;
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
		$stats = WikiaDataAccess::cache(
			self::getUserStatsMemcKey( $this->userId, $this->getWikiId() ),
			self::CACHE_TTL,
			function () use ( $flags ) {
				$stats = $this->loadUserStatsFromDB();

				echo "STATS = ";
				var_dump($stats);

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
			[ 'ar_user_text' => User::newFromId( $this->userId )->getName() ],
			__METHOD__
		);

		$this->setUserStat( 'editcount', $editCount );
		return $editCount;
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
				'ar_user_text' => User::newFromId( $this->userId )->getName(),
				'ar_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))'
			],
			__METHOD__
		);

		$this->setUserStat( 'editcountThisWeek', $editCount );
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

		var_dump($res);

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
	 * @param String $optionName name of wiki specific user option
	 * @param String $optionValue option value to be set
	 * @return $optionVal string|null
	 */
	private function setUserStat( $statName, $statVal ) {
		if ( !$this->validateUser() ) {
			return false;
		}

		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		echo "HERE IT IS!";
		$tmp = $dbw->replace(
			'wikia_user_properties',
			[],
			[
				'wup_user' => $this->userId,
				'wup_property' => $statName,
				'wup_value' => $statVal
			],
			__METHOD__
		);

		echo "TMP = ";
		var_dump($tmp);

		if($dbw->affectedRows()===1)
			echo "TRUE";
		else
			echo "FALSE";

		echo $dbw->lastQuery();

		var_dump($statName);
		var_dump($statVal);
		return $dbw->affectedRows() === 1;
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
			$this->setUserStat( 'lastContributionTimestamp', $lastContributionTimestamp );
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
		$dbType = ( $flags & Title::GAID_FOR_UPDATE ) ? DB_MASTER : DB_SLAVE;

		return $this->getWikiDB( $dbType, $dbName );
	}

	private static function getUserStatsMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'userStats', $wikiId, $userId, self::CACHE_VERSION );
	}

	private function validateUser() {
		return $this->userId > 0;
	}
}
