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
		$this->clearWatchLists( $user );
	}

	private function clearWatchLists( $userID ) {
		$this->clearLocalWatchlists( $userID );
		$this->clearGlobalWatchlist( $userID, $clearAllWikis = true );
	}

	private function clearLocalWatchlists( $userID ) {
		global $wgExternalDatawareDB;

		$db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$wikiIDs = ( new WikiaSQL() )
			->SELECT( self::columnCityID )
			->FROM( self::tableName )
			->WHERE( self::columnUserID )->EQUAL_TO( $userID )
			->AND_( self::columnTimeStamp )->IS_NOT_NULL()
			->runLoop( $db, function ( &$wikiIDs, $row ) {
				$wikiIDs[] = $row->gwa_city_id;
			} );

		foreach ( $wikiIDs as $wikiID ) {
			$db = wfGetDB( DB_MASTER, [], WikiFactory::IDtoDB( $wikiID ) );
			( new WikiaSQL() )
				->UPDATE( 'watchlist' )
				->SET( 'wl_notificationtimestamp', null )
				->WHERE( 'wl_user' )->EQUAL_TO( $userID )
				->run( $db );
		}
	}

	/**
	 * @param $userID
	 * @param $clearAllWikis bool
	 */
	public function clearGlobalWatchlist( $userID, $clearAllWikis = false ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$sql = ( new WikiaSQL() )
			->DELETE()->FROM( static::tableName )
			->WHERE( static::columnUserID )->EQUAL_TO( $userID );

		if ( !$clearAllWikis ) {
			$sql->AND_( static::columnCityID )->EQUAL_TO( $wgCityId );
		}

		$sql->run( $db );
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


