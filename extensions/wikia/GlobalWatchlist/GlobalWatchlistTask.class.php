<?php

use Wikia\Tasks\Tasks\BaseTask;
use \Wikia\Tasks\AsyncTaskList;

class GlobalWatchlistTask extends BaseTask {

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
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$wikiIDs = ( new WikiaSQL() )
			->SELECT()->DISTINCT( GlobalWatchlistTable::COLUMN_CITY_ID )
			->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userID )
			->AND_( GlobalWatchlistTable::COLUMN_TIMESTAMP )->IS_NOT_NULL()
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
		$db = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userID )
			->run( $db );
	}

	/**
	 * Clears all watched pages from the current wiki for the given
	 * user in the global_watchlist table.
	 * @param $userID
	 */
	public function clearGlobalWatchlist( $userID ) {
		$db = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userID )
			->AND_( GlobalWatchlistTable::COLUMN_CITY_ID )->EQUAL_TO( \F::app()->wg->CityId )
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
		$titleObj = Title::newFromText( $databaseKey, $nameSpace );
		if ( $titleObj instanceof Title && $titleObj->exists() ) {
			$revision = Revision::newFromTitle( $titleObj );
			$globalWatchlistBot = new GlobalWatchlistBot();

			$db = wfGetDB( DB_MASTER, [ ], \F::app()->wg->ExternalDatawareDB );
			foreach ( $watchers as $watcherID ) {
				if ( $globalWatchlistBot->shouldNotSendDigest( $watcherID ) ) {
					$this->clearGlobalWatchlistAll( $watcherID );
					continue;
				}

				( new WikiaSQL() )
					->INSERT()->INTO( GlobalWatchlistTable::TABLE_NAME )
					->SET( GlobalWatchlistTable::COLUMN_USER_ID, $watcherID )
					->SET( GlobalWatchlistTable::COLUMN_CITY_ID, \F::app()->wg->CityId )
					->SET( GlobalWatchlistTable::COLUMN_TITLE, $databaseKey )
					->SET( GlobalWatchlistTable::COLUMN_NAMESPACE, $nameSpace )
					->SET( GlobalWatchlistTable::COLUMN_REVISION_ID, $revision->getId() )
					->SET( GlobalWatchlistTable::COLUMN_REVISION_TIMESTAMP, $revision->getTimestamp() )
					->SET( GlobalWatchlistTable::COLUMN_TIMESTAMP, $revision->getTimestamp() )
					->run( $db );
				$this->scheduleWeeklyDigest( $watcherID );
			}
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
		$db = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->IN( $watchers )
			->AND_( GlobalWatchlistTable::COLUMN_CITY_ID )->EQUAL_TO( \F::app()->wg->CityId )
			->AND_( GlobalWatchlistTable::COLUMN_TITLE )->EQUAL_TO( $databaseKey )
			->AND_( GlobalWatchlistTable::COLUMN_NAMESPACE )->EQUAL_TO( $nameSpace )
			->run( $db );
	}

	/**
	 * Updates records in the global_watchlist table when a page has been renamed,
	 * aka, moved.
	 * @param $oldTitleValues array
	 * @param $newTitleValues array
	 */
	public function renameTitleInGlobalWatchlist( array $oldTitleValues, array $newTitleValues ) {
		$db = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );

		// If the rename is overwriting an existing page, delete those records so we don't
		// run into conflicts from the update below.
		( new WikiaSQL() )
			->DELETE()->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_TITLE )->EQUAL_TO( $newTitleValues['databaseKey'] )
			->AND_( GlobalWatchlistTable::COLUMN_NAMESPACE )->EQUAL_TO( $newTitleValues['nameSpace'] )
			->AND_( GlobalWatchlistTable::COLUMN_CITY_ID )->EQUAL_TO( \F::app()->wg->CityId )
			->run( $db );

		( new WikiaSQL() )
			->UPDATE( GlobalWatchlistTable::TABLE_NAME )
			->SET( GlobalWatchlistTable::COLUMN_TITLE, $newTitleValues['databaseKey'] )
			->SET( GlobalWatchlistTable::COLUMN_NAMESPACE, $newTitleValues['nameSpace'] )
			->WHERE( GlobalWatchlistTable::COLUMN_TITLE )->EQUAL_TO( $oldTitleValues['databaseKey'] )
			->AND_( GlobalWatchlistTable::COLUMN_NAMESPACE )->EQUAL_TO( $oldTitleValues['nameSpace'] )
			->AND_( GlobalWatchlistTable::COLUMN_CITY_ID )->EQUAL_TO( \F::app()->wg->CityId )
			->run( $db );
	}
}


