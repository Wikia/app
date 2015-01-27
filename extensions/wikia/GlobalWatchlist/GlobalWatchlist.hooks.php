<?php

use \Wikia\Tasks\AsyncTaskList;

class GlobalWatchlistHook {

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
	 * Hook function calls when watch was added to database
	 * @param $watchItem WatchedItem: object
	 * @return bool (always true)
	 */
	static public function addGlobalWatch ( $watchItem ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'addToGlobalWatchlist', $watchItem ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Hook function calls when watch was removed from database
	 * @param $watchItem WatchedItem: object
	 * @param $success Boolean: removed successfully
	 * @return bool (always true)
	 */		
	static public function removeGlobalWatch( $watchItem, $success ) {

		if ( !$success ) {
			/* some errors when update in local watchlist table */
			return true;
		}

		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'removeFromGlobalWatchlist', $watchItem ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Hook function calls when watch was updated in database
	 * @param $watchItem WatchedItem: object
	 * @param $users Array or Integer: array of user IDs or user ID
	 * @param $timestamp Datetime or null
	 * @return bool (always true)
	 */
	static public function updateGlobalWatch( $watchItem, $users, $timestamp ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'updateGlobalWatchlist', $watchItem, $users, $timestamp ) )
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
	static public function replaceGlobalWatch( $oldTitle, $newTitle ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'replaceWatchlist', $oldTitle, $newTitle ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Hook function to delete all watches for User
	 * @param $user User: object
	 * @return bool (always true)
	 */
	static public function clearGlobalWatch( $user) {

		$userID = $user->getId();
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'clearGlobalWatchlist', $userID ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Hook function to reset all watches for User
	 * @param $userID Integer: User ID
	 * @return bool (always true)
	 */
	static public function resetGlobalWatch( $userID ) {

		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'resetGlobalWatchlist', $userID ) )
			->dupCheck()
			->queue();

		return true;
	}	
}
