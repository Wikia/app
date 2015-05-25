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
	public static function savePreferences( &$formData, &$error ) {

		if ( self::userUnsubscribingFromAllEmail( $formData ) || self::userUnsubscribingFromWeeklyDigest( $formData ) ) {
			$wg = \F::app()->wg;
			$task = new GlobalWatchlistTask();
			( new AsyncTaskList() )
				->add( $task->call( 'clearGlobalWatchlistAll', $wg->User->getId() ) )
				->queue();
		}

		return true;
	}

	/**
	 * Returns if the user is unsubscribing from all email from Wikia.
	 * @param $formData
	 * @return bool
	 */
	private static function userUnsubscribingFromAllEmail ( array $formData ) {
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
	private static function userUnsubscribingFromWeeklyDigest( array $formData ) {
		return (
			$formData['watchlistdigest'] == false &&
			F::app()->wg->User->getBoolOption( 'watchlistdigest' ) == true
		);
	}

	/**
	 * Called when a watched item is being updated. If the timestamp is null, this indicates the
	 * watchers have seen the page so the watch can be cleared. If the time stamp is not null,
	 * this indicates the watchers need to be notified and should be added to the global_watchlist.
	 * @param $watchedItem WatchedItem: object
	 * @param $watchers Array or Integer: array of user IDs or user ID
	 * @param $timestamp Datetime or null
	 * @return bool (always true)
	 */
	public static function updateGlobalWatchList( WatchedItem $watchedItem, $watchers, $timestamp = null ) {
		$watchers = wfReturnArray( $watchers );
		if ( is_null( $timestamp ) ) {
			self::removeWatchers( $watchedItem, $watchers );
		} else {
			self::addWatchers( $watchedItem, $watchers );
		}

		return true;
	}

	/**
	 * Remove watchers from the global_watchlist table for the given page.
	 * @param $watchedItem WatchedItem
	 * @param $watchers
	 */
	public static function removeWatchers( WatchedItem $watchedItem, array $watchers ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'removeWatchers', $watchedItem->databaseKey, $watchedItem->nameSpace, $watchers ) )
			->dupCheck()
			->queue();
	}

	/**
	 * Add watchers to the global_watchlist table for the given page.
	 * @param $watchedItem
	 * @param $watchers
	 */
	public static function addWatchers( WatchedItem $watchedItem, array $watchers ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'addWatchers', $watchedItem->databaseKey, $watchedItem->nameSpace, $watchers ) )
			->dupCheck()
			->queue();
	}

	/**
	 * Delete all watches from the global_watchlist table for the given user on this wiki
	 * @param $userID integer
	 * @return bool (always true)
	 */
	public static function clearGlobalWatch( $userID ) {
		$task = new GlobalWatchlistTask();
		( new AsyncTaskList() )
			->wikiId( F::app()->wg->CityId )
			->add( $task->call( 'clearGlobalWatchlist', $userID ) )
			->dupCheck()
			->queue();

		return true;
	}

	/**
	 * Updates records in the global_watchlist table when a page has been renamed,
	 * aka, moved.
	 * @param $oldTitle Title
	 * @param $newTitle Title
	 * @return bool (always true)
	 */
	public static function renameTitleInGlobalWatchlist( \Title $oldTitle, \Title $newTitle ) {
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
