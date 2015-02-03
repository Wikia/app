<?php

use Wikia\Tasks\Tasks\BaseTask;
use \Wikia\Tasks\AsyncTaskList;

class GlobalWatchlistTask extends BaseTask {

	const tableName = 'global_watchlist';
	const columnUserID = 'gwa_user_id';
	const columnCityID = 'gwa_city_id';
	const columnNameSpace = 'gwa_namespace';
	const columnTitle = 'gwa_title';
	const columnRevisionID = 'gwa_rev_id';
	const columnTimeStamp = 'gwa_timestamp';
	const columnRevisionTimeStamp = 'gwa_rev_timestamp';

	/**
	 * Sends the weekly digest to the user
	 * @param $userID
	 */
	public function sendWeeklyDigest( $userID ) {
		$globalWatchlistBot = new GlobalWatchlistBot();
		$globalWatchlistBot->sendDigestToUser( $userID );
		$this->clearWatchLists( $userID );
	}

	/**
	 * Clear the global_watchlist and local watchlists for a given user.
	 * This is done after we send them the weekly digest which effectively
	 * means they have "seen" all the watched pages and will receive notifications
	 * for new edits.
	 * @param $userID
	 */
	private function clearWatchLists( $userID ) {
		$this->clearLocalWatchlists( $userID );
		$this->clearGlobalWatchlistAll( $userID );
	}

	/**
	 * Clears the local watchlist tables for a given user.
	 * @param $userID
	 */
	private function clearLocalWatchlists( $userID ) {
		global $wgExternalDatawareDB;

		$db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$wikiIDs = ( new WikiaSQL() )
			->SELECT()->DISTINCT( self::columnCityID )
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
	 * Clears all watched pages from all wikis for the given user in
	 * the global_watchlist table.
	 * @param $userID
	 */
	public function clearGlobalWatchlistAll( $userID ) {
		global $wgExternalDatawareDB;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( self::tableName )
			->WHERE( self::columnUserID )->EQUAL_TO( $userID )
			->run( $db );
	}

	/**
	 * Clears all watched pages from the current wiki for the given
	 * user in the global_watchlist table.
	 * @param $userID
	 */
	public function clearGlobalWatchlist( $userID ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( self::tableName )
			->WHERE( self::columnUserID )->EQUAL_TO( $userID )
			->AND_( self::columnCityID )->EQUAL_TO( $wgCityId )
			->run( $db );
	}

	/**
	 * Adds entries for watched pages in the global_watchlist table. This
	 * also kicks off a job to send the weekly digest 7 days from now. Since
	 * that job does a dedup check, any subsequent attempts to schedule that
	 * weekly digest job will be ignored until the initial one is sent.
	 * @param $databaseKey String
	 * @param $nameSpace String
	 * @param $watchers
	 */
	public function addWatchers( $databaseKey, $nameSpace, array $watchers ) {
		global $wgExternalDatawareDB, $wgCityId;

		$titleObj = Title::newFromText( $databaseKey, $nameSpace );
		$revision = Revision::newFromTitle( $titleObj );
		$globalWatchlistBot = new GlobalWatchlistBot();

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		foreach ( $watchers as $watcherID ) {
			if ( $globalWatchlistBot->shouldNotSendDigest( $watcherID ) ) {
				$this->clearGlobalWatchlistAll( $watcherID );
				continue;
			}

			( new WikiaSQL() )
				->INSERT()->INTO( self::tableName )
				->SET( self::columnUserID, $watcherID )
				->SET( self::columnCityID, $wgCityId )
				->SET( self::columnTitle, $databaseKey )
				->SET( self::columnNameSpace, $nameSpace )
				->SET( self::columnRevisionID, $revision->getId() )
				->SET( self::columnRevisionTimeStamp, $revision->getTimestamp() )
				->SET( self::columnTimeStamp, $revision->getTimestamp() )
				->run( $db );
			$this->scheduleWeeklyDigest( $watcherID );
		}
	}

	/**
	 * Schedules the weekly digest to be sent to the given user in 7 days. A dedup check is
	 * performed to prevent additional weekly digests from being scheduled.
	 * @param $userID
	 */
	private function scheduleWeeklyDigest( $userID ) {
		$task = new self();
		( new AsyncTaskList() )
			->add( $task->call( 'sendWeeklyDigest', $userID ) )
			->delay( '7 days' )
			->dupCheck()
			->queue();
	}

	/**
	 * Clears all records in the global_watchlist table with the given name, namespace,
	 * and watchers.
	 * @param $databaseKey
	 * @param $nameSpace
	 * @param array $watchers
	 */
	public function removeWatchers( $databaseKey, $nameSpace, array $watchers ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( self::tableName )
			->WHERE( self::columnUserID )->IN( $watchers )
			->AND_( self::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( self::columnTitle )->EQUAL_TO( $databaseKey )
			->AND_( self::columnNameSpace )->EQUAL_TO( $nameSpace )
			->run( $db );
	}

	/**
	 * Updates records in the global_watchlist table when a page has been renamed,
	 * aka, moved.
	 * @param $oldTitleValues array
	 * @param $newTitleValues array
	 */
	public function renameTitleInGlobalWatchlist( array $oldTitleValues, array $newTitleValues ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( self::tableName )
			->SET( self::columnTitle, $newTitleValues['databaseKey'] )
			->SET( self::columnNameSpace, $newTitleValues['nameSpace'] )
			->WHERE( self::columnTitle )->EQUAL_TO( $oldTitleValues['databaseKey'] )
			->AND_( self::columnNameSpace )->EQUAL_TO( $oldTitleValues['nameSpace'] )
			->AND_( self::columnCityID )->EQUAL_TO( $wgCityId )
			->run( $db );
	}
}


