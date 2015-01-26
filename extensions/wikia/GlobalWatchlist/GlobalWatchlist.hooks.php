<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 ) ;
}

class GlobalWatchlistHook {

	const tableName = 'global_watchlist';
	const columnUserID = 'gwa_user_id';
	const columnCityID = 'gwa_city_id';
	const columnNameSpace = 'gwa_namespace';
	const columnTitle = 'gwa_title';
	const columnRevisionID = 'gwa_rev_id';
	const columnTimeStamp = 'gwa_timestamp';
	const columnRevisionTimeStamp = 'gwa_rev_timestamp';

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
		global $wgExternalDatawareDB, $wgCityId;

		if ( !$watchItem instanceof WatchedItem ) {
			return true;
		}

		if ( $watchItem->userID == 0 ) {
			return true;
		}

		$title = Title::makeTitle( $watchItem->nameSpace, $watchItem->databaseKey );
		if ( !is_object( $title ) ) {
			return true;
		}

		$revision = Revision::newFromTitle( $title );
		if ( !is_object( $revision ) ) {
			return true;
		}

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

		return true;
	}

	/**
	 * Hook function calls when watch was removed from database
	 * @param $watchItem WatchedItem: object
	 * @param $success Boolean: removed successfully
	 * @return bool (always true)
	 */		
	static public function removeGlobalWatch( $watchItem, $success ) {
		global $wgExternalDatawareDB, $wgCityId;

		if ( !$watchItem instanceof WatchedItem ) {
			return true;
		}

		if ( !$success ) {
			/* some errors when update in local watchlist table */
			return true;
		}

		if ( $watchItem->userID == 0 ) {
			return true;
		}

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
		global $wgExternalDatawareDB, $wgCityId;

		if ( !$watchItem instanceof WatchedItem ) {
			return true;
		}

		$title = Title::makeTitle( $watchItem->nameSpace, $watchItem->databaseKey );
		if ( !is_object( $title ) ) {
			return true;
		}

		$revision = Revision::newFromTitle( $title );
		if ( !is_object( $revision ) ) {
			return true;
		}

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

		return true;
	}

	/**
	 * Hook function to replace watch records in database
	 * @param $oldTitle Title
	 * @param $newTitle Title
	 * @param $rows Array: array of records to replace:
	 * array(
	 *   'wl_user' => integer,
	 *   'wl_namespace' => integer,
	 *   'wl_title' => string
	 * );
	 * @return bool (always true)
	 */
	static public function replaceGlobalWatch( $oldTitle, $newTitle, $rows ) {
		global $wgExternalDatawareDB, $wgCityId;

		if ( !$oldTitle instanceof Title ) {
			return true;
		}

		if ( !$newTitle instanceof Title ) {
			return true;
		}

		if ( !is_array($rows) ) {
			return true;
		}

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		foreach ( $rows as $row ) {
			if ( empty($row['wl_user']) ) {
				continue;
			}

			$title = Title::makeTitle( $row['wl_namespace'], $row['wl_title'] );
			if ( !is_object( $title ) ) {
				continue;
			}

			$revision = Revision::newFromTitle( $title );
			if ( !is_object( $revision ) ) {
				continue;
			}

			$revisionID = $revision->getId();
			$revisionTimeStamp = $revision->getTimestamp();
			( new WikiaSQL() )
				->UPDATE( static::tableName )
				->SET( static::columnNameSpace, $row['wl_namespace'] )
				->SET( static::columnTitle, $row['wl_title'] )
				->SET( static::columnRevisionID, $revisionID )
				->SET( static::columnRevisionTimeStamp, $revisionTimeStamp )
				->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
				->AND_( static::columnTitle )->EQUAL_TO( $oldTitle->getDBkey() )
				->AND_( static::columnNameSpace )->EQUAL_TO( $oldTitle->getNamespace() )
				->AND_( static::columnUserID )->EQUAL_TO( $row['wl_user'] )
				->run( $db );
		}

		return true;
	}

	/**
	 * Hook function to delete all watches for User
	 * @param $user User: object
	 * @return bool (always true)
	 */
	static public function clearGlobalWatch( $user) {
		global $wgExternalDatawareDB, $wgCityId;

		if ( !$user instanceof User ) {
			return true;
		}

		$userID = $user->getId();

		if ( empty( $userID ) ) {
			return true;
		}

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( static::tableName )
			->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnUserID )->EQUAL_TO( $userID )
			->run( $db );

		return true;
	}


	/**
	 * Hook function to reset all watches for User
	 * @param $user_id Integer: User ID
	 * @return bool (always true)
	 */
	static public function resetGlobalWatch( $user_id ) {
		global $wgExternalDatawareDB, $wgCityId;

		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( static::tableName )
			->SET( static::columnTimeStamp, null )
			->WHERE( static::columnCityID )->EQUAL_TO( $wgCityId )
			->AND_( static::columnUserID )->EQUAL_TO( $user_id )
			->run( $db );

		return true;
	}	
}
