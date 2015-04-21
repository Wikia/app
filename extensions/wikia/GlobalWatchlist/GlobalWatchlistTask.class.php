<?php

use Wikia\Tasks\Tasks\BaseTask;

class GlobalWatchlistTask extends BaseTask {

	/**
	 * Clear all watched pages from all wikis for the given user in
	 * the global_watchlist table. This logic was already implemented in
	 * the GlobalWatchListBot class since it's needed when we send out
	 * the weekly digest.
	 * @param int $watcherID
	 */
	public function clearGlobalWatchlistAll( $watcherID ) {
		$watchlistBot = new GlobalWatchlistBot();
		$watchlistBot->clearGlobalWatchlistAll( $watcherID );
	}

	/**
	 * Clears all watched pages from the current wiki for the given
	 * user in the global_watchlist table.
	 * @param int $userID
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
	 * @param String $databaseKey
	 * @param String $nameSpace
	 * @param array $watchers
	 */
	public function addWatchers( $databaseKey, $nameSpace, array $watchers ) {
		$titleObj = Title::newFromText( $databaseKey, $nameSpace );
		if ( $titleObj instanceof Title && $titleObj->exists() ) {
			$revision = Revision::newFromTitle( $titleObj );

			// Skip revisions that doesn't exist
			if ( !empty($revision) ) {
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
				}
			}
		}
	}

	/**
	 * Clears all records in the global_watchlist table with the given name, namespace,
	 * and watchers.
	 * @param String $databaseKey
	 * @param String $nameSpace
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
	 * @param array $oldTitleValues
	 * @param array $newTitleValues
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


