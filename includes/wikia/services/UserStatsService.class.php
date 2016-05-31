<?php

use Wikia\Logger\WikiaLogger;

class UserStatsService extends WikiaModel {

	const CACHE_TTL = 86400;
	const CACHE_VERSION = 'v1.0';

	private $userId;
	private $wikiId;
	private $wikiOptions;

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

		$editCount = $this->getOptionWiki( 'editcount' );

		if( $editCount === null || $editCount === false ) { // editcount has not been initialized. do so.
			$editCount = $this->calculateEditCountWiki();
		}

		wfProfileOut( __METHOD__ );
		return (int)$editCount;
	}

	/**
	 * Get the user's edit count from last week for specified wiki.
	 *
	 * @return int Number of edits
	 */
	public function getEditCountFromWeek() {
		wfProfileIn( __METHOD__ );

		$editCount = $this->getOptionWiki( 'editcountThisWeek' );

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

		// update edit counts on wiki
		if ( !is_null( $this->getOptionWiki( 'editcount' ) ) ) {
			$this->updateEditCount( 'editcount' );
		} else {
			$this->calculateEditCountWiki( Title::GAID_FOR_UPDATE );
			$this->debugEditCountIfNotExists( 'editcount' );
		}

		// update weekly edit counts on wiki
		if ( !is_null( $this->getOptionWiki( 'editcountThisWeek' ) ) ) {
			$this->updateEditCount( 'editcountThisWeek' );
		} else {
			$this->calculateEditCountFromWeek( Title::GAID_FOR_UPDATE );
			$this->debugEditCountIfNotExists( 'editcountThisWeek' );
		}

		if ( is_null( $this->getOptionWiki( 'firstRevision' ) ) ) {
			$this->initFirstContributionTimestamp();
		}

		// update last revision timestamp
		$this->initLastContributionTimestamp();

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
	public function getStats() {
		wfProfileIn( __METHOD__ );

		$stats = [
			'firstRevisionDate' => null,
			'lastRevisionDate' => null,
			'edits' => 0,
			'editsThisWeek' => 0
		];

		if ( $this->getEditCountWiki() > 0 ) {
			$stats = [
				'firstRevisionDate' => $this->getFirstContributionTimestamp(),
				'lastRevisionDate' => $this->getLastContributionTimestamp(),
				'edits' => $this->getEditCountWiki(),
				'editsThisWeek' => $this->getEditCountFromWeek()
			];
		}

		wfProfileOut( __METHOD__ );
		return $stats;
	}

	public static function purgeOptionsWikiCache( $userId, $wikiId ) {
		global $wgMemc;

		$wgMemc->delete( self::getOptionsWikiMemcKey( $userId, $wikiId ) );
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

		// Store editcount value
		$this->setOptionWiki( 'editcount', $editCount );

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

		if ( $dbw->affectedRows() === 1 ) {
			$this->wikiOptions[ $propertyName ]++;
			$this->saveOptionsWikiToCache( $this->wikiOptions );
		}

		wfProfileOut( __METHOD__ );
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

		// Store editcount value
		$this->setOptionWiki( 'editcountThisWeek', $editCount );

		wfProfileOut( __METHOD__ );
		return $editCount;
	}

	/**
	 * Retrives wiki specific user option
	 * @since Nov 2013
	 * @author Kamil Koterba
	 *
	 * @param String $optionName  name of wiki specific user option
	 * @return String|null $optionVal
	 */
	private function getOptionWiki( $optionName ) {
		wfProfileIn( __METHOD__ );

		// Get all options for wiki
		$this->loadOptionsWiki();

		// Return specific option
		if ( isset( $this->wikiOptions[ $optionName ] ) ) {
			wfProfileOut( __METHOD__ );
			return $this->wikiOptions[ $optionName ];
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	private function loadOptionsWiki() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->wikiOptions ) ) {
			$this->wikiOptions = $this->getOptionsWikiFromCache();
		}

		if ( empty( $this->wikiOptions ) ) {
			wfProfileOut( __METHOD__ );
			$this->wikiOptions = $this->getOptionsWikiFromDB();
		}

		wfProfileOut( __METHOD__ );
		return $this->wikiOptions;
	}

	/**
	 * Load user options localized per wiki from DB
	 * (wikia_user_properties table)
	 * @since Nov 2013
	 * @author Kamil Koterba
	 * @return array
	 */
	private function getOptionsWikiFromDB() {
		wfProfileIn(__METHOD__);

		$wikiId = $this->getWikiId();

		/* Get option value from wiki specific user properties */
		$dbr = $this->getDatabase( $wikiId );
		$res = $dbr->select(
			'wikia_user_properties',
			[ 'wup_property', 'wup_value' ],
			[ 'wup_user' => $this->userId ],
			__METHOD__
		);

		foreach( $res as $row ) {
			$this->wikiOptions[ $row->wup_property ] = $row->wup_value;
		}

		$this->saveOptionsWikiToCache(  $this->wikiOptions );

		wfProfileOut( __METHOD__ );
		return $this->wikiOptions;
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
	private function setOptionWiki( $optionName, $optionVal ) {
		wfProfileIn( __METHOD__ );

		$dbw = $this->getDatabase( Title::GAID_FOR_UPDATE );
		$dbw->replace(
			'wikia_user_properties',
			[],
			[ 'wup_user' => $this->userId, 'wup_property' => $optionName, 'wup_value' => $optionVal ],
			__METHOD__
		);

		$this->wikiOptions[ $optionName ] = $optionVal;
		$this->saveOptionsWikiToCache(  $this->wikiOptions );

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
	private function getFirstContributionTimestamp() {
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
		wfProfileIn( __METHOD__ );

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
		$dbName = ( $this->getWikiId() === $this->wg->CityId ) ? false : WikiFactory::IDtoDB( $this->getWikiId() );
		$dbType = ( $flags & Title::GAID_FOR_UPDATE ) ? DB_MASTER : DB_SLAVE;

		return $this->getWikiDB( $dbType, $dbName );
	}

	private function getOptionsWikiFromCache() {
		$key = self::getOptionsWikiMemcKey( $this->userId, $this->getWikiId() );
		return $this->wg->Memc->get( $key );
	}

	private function saveOptionsWikiToCache( $optionsWiki ) {
		$key = self::getOptionsWikiMemcKey( $this->userId, $this->getWikiId() );
		$this->wg->Memc->set( $key, $optionsWiki, self::CACHE_TTL );
	}

	private static function getOptionsWikiMemcKey( $userId, $wikiId ) {
		return wfSharedMemcKey( 'optionsWiki', $wikiId, $userId, self::CACHE_VERSION );
	}

	private function debugEditCountIfNotExists( $property ) {
		$editCount = (int)$this->getOptionWiki( $property );
		if ( $editCount !== 1 ) {
			WikiaLogger::instance()->warning(
				'UserStatsService calculate ' . $property,
				[ $property => $editCount, 'user_id' => $this->userId ]
			);
		}
	}
}
