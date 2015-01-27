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
		$globalWatchlistBot = new GlobalWatchlistBot( $user );
		$globalWatchlistBot->sendDigestToUser( $user );
		$globalWatchlistBot->clearWatchLists( $user );
	}

	public function addToGlobalWatchlist( $watchItem ) {
		global $wgExternalDatawareDB, $wgCityId;

		$title = Title::newFromText( $watchItem->databaseKey, $watchItem->nameSpace );
		$revision = Revision::newFromTitle( $title );
		foreach ( array ( MWNamespace::getSubject( $watchItem->nameSpace ), MWNamespace::getTalk( $watchItem->nameSpace ) ) as $nameSpace ) {
			$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
			( new WikiaSQL() )
				->INSERT()->INTO( static::tableName )
				->SET( static::columnUserID, $watchItem->userID )
				->SET( static::columnCityID, $wgCityId )
				->SET( static::columnTitle, $watchItem->databaseKey )
				->SET( static::columnNameSpace, $nameSpace )
				->SET( static::columnRevisionID, $revision->getId() )
				->SET( static::columnRevisionTimeStamp, $revision->getTimestamp() )
				->run( $db );
		}
	}

	public function removeFromGlobalWatchlist( $watchItem ) {
		global $wgExternalDatawareDB, $wgCityId;

		foreach ( array ( MWNamespace::getSubject( $watchItem->nameSpace ), MWNamespace::getTalk( $watchItem->nameSpace ) ) as $nameSpace ) {
			$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
			( new WikiaSQL() )
				->DELETE()->FROM( static::tableName )
				->WHERE( static::columnUserID )->EQUAL_TO( $watchItem->userID )
				->AND_( static::columnCityID )->EQUAL_TO( $wgCityId )
				->AND_( static::columnTitle )->EQUAL_TO( $watchItem->databaseKey )
				->AND_( static::columnNameSpace )->EQUAL_TO( $nameSpace )
				->run( $db );
		}
	}

	public function updateGlobalWatchlist( $watchItem, $users, $timestamp ) {
		global $wgExternalDatawareDB, $wgCityId;

		$title = Title::makeTitle( $watchItem->nameSpace, $watchItem->databaseKey );
		$revision = Revision::newFromTitle( $title );
		$users = wfReturnArray( $users );
		$rev_id = $revision->getId();
		$rev_timestamp = $revision->getTimestamp();

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( static::tableName )
			->SET( static::columnRevisionID, $rev_id )
			->SET( static::columnRevisionTimeStamp, $rev_timestamp )
			->SET( static::columnTimeStamp, $timestamp )
			->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnNameSpace )->EQUAL_TO( $watchItem->nameSpace )
			->AND_( static::columnTitle )->EQUAL_TO( $watchItem->databaseKey )
			->AND_( static::columnUserID )->IN( $users )
			->run( $db );
	}

	public function resetGlobalWatchlist( $userID ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( static::tableName )
			->SET( static::columnTimeStamp, null )
			->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnUserID )->EQUAL_TO( $userID )
			->run( $db );
	}

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
	 * @param $oldTitle Title
	 * @param $newTitle Title
	 */
	public function replaceWatchlist( $oldTitle, $newTitle ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( static::tableName )
			->SET( static::columnTitle, $newTitle->getDBkey() )
			->SET( static::columnNameSpace, $newTitle->getNamespace() )
			->WHERE( static::columnTitle )->EQUAL_TO( $oldTitle->getDBkey() )
			->AND_( static::columnNameSpace )->EQUAL_TO( $oldTitle->getNamespace() )
			->AND_( static::columnCityID )->EQUAL_TO( $wgCityId )
			->run( $db );
	}
}


