<?php

use \Wikia\Tasks\AsyncTaskList;

class GlobalWatchlistHooks {

	public static function getPreferences( $user, &$defaultPreferences ) {

		$defaultPreferences['watchlistdigest'] = [
			'type' => 'toggle',
			'label-message' => 'tog-watchlistdigest',
			'section' => 'watchlist/advancedwatchlist',
		];

		$defaultPreferences['watchlistdigestclear'] = [
			'type' => 'toggle',
			'label-message' => 'tog-watchlistdigestclear',
			'section' => 'watchlist/advancedwatchlist',
		];
		
		return true;
	}

	/**
	 * Check if the user is unsubscribing from either the weekly digest or email altogether and, if so,
	 * clears all their entries from the global_watchlist table.
	 * @param $formData
	 * @param $error
	 * @return bool
	 */
	static public function savePreferences( &$formData, &$error ) {

		if ( self::userUnsubscribingFromAllEmail( $formData ) || self::userUnsubscribingFromWeeklyDigest( $formData ) ) {
			$task = new GlobalWatchlistTask();
			( new AsyncTaskList() )
				->wikiId( F::app()->wg->CityId )
				->add( $task->call( 'clearGlobalWatchlistAll', F::app()->wg->User->getId() ) )
				->queue();
		}

		return true;
	}

	/**
	 * Returns if the user is unsubscribing from all email from Wikia.
	 * @param $formData
	 * @return bool
	 */
	static private function userUnsubscribingFromAllEmail ( $formData ) {
		return (
			$formData['unsubscribed'] == true &&
			F::app()->wg->User->getBoolOption( 'unsubscribed' ) == false
		);
	}

	/**
	 * Returns if the user is unsubscribing from the weekly digest.
	 * @param $formData
	 * @return bool
	 */
	static private function userUnsubscribingFromWeeklyDigest( $formData ) {
		return (
			$formData['watchlistdigest'] == false &&
			F::app()->wg->User->getBoolOption( 'watchlistdigest' ) == true
		);
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
	}

	/**
	 * Hook function calls when watch was removed from database
	 * @param $watchedItem WatchedItem: object
	 * @param $success Boolean: removed successfully
	 * @return bool (always true)
	 */		
	static public function removeWatcher( $watchedItem, $success ) {

		// some errors when update in local watchlist table
		if ( !$success ) {
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
