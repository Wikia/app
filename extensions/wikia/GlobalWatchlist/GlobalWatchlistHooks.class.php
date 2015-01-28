<?php

use \Wikia\Tasks\AsyncTaskList;

class GlobalWatchlistHooks {

	public static function getPreferences( $user, &$defaultPreferences ) {

		$defaultPreferences['watchlistdigest'] = array(
			'type' => 'toggle',
			'label-message' => 'tog-watchlistdigest',
			'section' => 'watchlist/advancedwatchlist',
		);

		$defaultPreferences['watchlistdigestclear'] = array(
			'type' => 'toggle',
			'label-message' => 'tog-watchlistdigestclear',
			'section' => 'watchlist/advancedwatchlist',
		);
		
		return true;
	}

	/**
	 * Hook function calls when watch was updated in database
	 * @param $watchedItem WatchedItem: object
	 * @param $watchers Array or Integer: array of user IDs or user ID
	 * @param $timestamp Datetime or null
	 * @return bool (always true)
	 */
	static public function updateGlobalWatchList( WatchedItem $watchedItem, $watchers, $timestamp ) {
		$watchers = wfReturnArray( $watchers );
		if ( is_null( $timestamp ) ) {
			self::removeWatchers( $watchedItem, $watchers );
		} else {
			self::addWatchers( $watchedItem, $watchers );
		}

		return true;
	}

	/**
	 * Remove watchers from the global_watchlist table
	 * @param $watchedItem WatchedItem
	 * @param $watchers
	 */
	static public function removeWatchers( WatchedItem $watchedItem, array $watchers ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'removeWatchers', $watchedItem->databaseKey, $watchedItem->nameSpace, $watchers ) )
			->dupCheck()
			->queue();
	}

	/**
	 * Add watchers to the global_watchlist table
	 * @param $watchedItem
	 * @param $watchers
	 */
	static public function addWatchers( WatchedItem $watchedItem, array $watchers ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'addWatchers', $watchedItem->databaseKey, $watchedItem->nameSpace, $watchers ) )
			->dupCheck()
			->queue();

		self::scheduleWeeklyDigest( $watchers );
	}

	/**
	 * Schedule a weekly digest to be sent to the user 7 days from now
	 * @param $watchers
	 */
	static public function scheduleWeeklyDigest( $watchers ) {
		foreach ( $watchers as $watcher ) {
			$task = new GlobalWatchlistTask();
			( new AsyncTaskList() )
				->wikiId( F::app()->wg->CityId )
				->add( $task->call( 'sendWeeklyDigest', $watcher ) )
				->dupCheck()
				->delay( '1 week' )
				->queue();
		}
	}

	/**
	 * Hook function calls when watch was removed from database
	 * @param $watchedItem WatchedItem: object
	 * @param $success Boolean: removed successfully
	 * @return bool (always true)
	 */		
	static public function removeGlobalWatch( $watchedItem, $success ) {

		if ( !$success ) {
			/* some errors when update in local watchlist table */
			return true;
		}

		self::removeWatchers( $watchedItem, [ $watchedItem->userID ] );

		return true;
	}

	/**
	 * Hook function to delete all watches for User
	 * @param $userID integer
	 * @return bool (always true)
	 */
	static public function clearGlobalWatch( $userID ) {

		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'clearGlobalWatchlist', $userID ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Hook function to replace watch records in database
	 * @param $oldTitle Title
	 * @param $newTitle Title
	 * @return bool (always true)
	 */
	static public function renameTitleInGlobalWatchlist( $oldTitle, $newTitle ) {
		$oldTitleValues = [
			'databaseKey' => $oldTitle->getDBkey(),
			'nameSpace' => $oldTitle->getNamespace()
		];
		$newTitleValues = [
			'databaseKey' => $newTitle->getDBkey(),
			'nameSpace' => $newTitle->getNamespace()
		];

		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'renameTitleInGlobalWatchlist', $oldTitleValues, $newTitleValues ) )
			->dupCheck()
			->queue();

		return true;
	}
}
