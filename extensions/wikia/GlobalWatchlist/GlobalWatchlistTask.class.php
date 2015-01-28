<?php

use Wikia\Tasks\Tasks\BaseTask;

class GlobalWatchlistTask extends BaseTask {

	const tableName = 'global_watchlist';
	const columnUserID = 'gwa_user_id';
	const columnCityID = 'gwa_city_id';
	const columnNameSpace = 'gwa_namespace';
	const columnTitle = 'gwa_title';
	const columnRevisionID = 'gwa_rev_id';
	const columnTimeStamp = 'gwa_timestamp';
	const columnRevisionTimeStamp = 'gwa_rev_timestamp';

	public function sendWeeklyDigest( $user ) {
		$globalWatchlistBot = new GlobalWatchlistBot();
		$globalWatchlistBot->sendDigestToUser( $user );
		$globalWatchlistBot->clearWatchLists( $user );
	}

	/**
	 * @param $databaseKey String
	 * @param $nameSpace String
	 * @param $watchers
	 */
	public function addWatchers( $databaseKey, $nameSpace, array $watchers ) {
		global $wgExternalDatawareDB, $wgCityId;

		$titleObj = Title::newFromText( $databaseKey, $nameSpace );
		$revision = Revision::newFromTitle( $titleObj );

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		foreach ( $watchers as $watcher ) {
			( new WikiaSQL() )
				->INSERT()->INTO( static::tableName )
				->SET( static::columnUserID, $watcher )
				->SET( static::columnCityID, $wgCityId )
				->SET( static::columnTitle, $databaseKey )
				->SET( static::columnNameSpace, $nameSpace )
				->SET( static::columnRevisionID, $revision->getId() )
				->SET( static::columnRevisionTimeStamp, $revision->getTimestamp() )
				->SET( static::columnTimeStamp, $revision->getTimestamp() )
				->run( $db );
		}
	}

	/**
	 * @param $databaseKey
	 * @param $nameSpace
	 * @param array $watchers
	 */
	public function removeWatchers( $databaseKey, $nameSpace, array $watchers ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( static::tableName )
			->WHERE( static::columnUserID )->IN( $watchers )
			->AND_( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnTitle )->EQUAL_TO( $databaseKey )
			->AND_( static::columnNameSpace )->EQUAL_TO( $nameSpace )
			->run( $db );
	}

	/**
	 * @param $userID
	 */
	public function clearGlobalWatchlist( $userID ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( static::tableName )
			->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnUserID )->EQUAL_TO( $userID )
			->run( $db );
	}

	/**
	 * @param $oldTitleValues array
	 * @param $newTitleValues array
	 */
	public function renameTitleInGlobalWatchlist( array $oldTitleValues, array $newTitleValues ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( static::tableName )
			->SET( static::columnTitle, $newTitleValues['databaseKey'] )
			->SET( static::columnNameSpace, $newTitleValues['nameSpace'] )
			->WHERE( static::columnTitle )->EQUAL_TO( $oldTitleValues['databaseKey'] )
			->AND_( static::columnNameSpace )->EQUAL_TO( $oldTitleValues['nameSpace'] )
			->AND_( static::columnCityID )->EQUAL_TO( $wgCityId )
			->run( $db );
	}
}


