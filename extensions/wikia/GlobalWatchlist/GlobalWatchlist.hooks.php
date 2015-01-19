<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 ) ;
}

class GlobalWatchlistHook {
	
	public static function getPreferences( &$defaultPreferences ) {

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
	 * @param $oWatchItem WatchedItem: object
	 * @return bool (always true)
	 */
	static public function addGlobalWatch ( $oWatchItem ) {
		global $wgEnableScribeReport, $wgCityId;

		if ( empty($wgEnableScribeReport) ) {
			return true;
		}
		
		if ( !$oWatchItem instanceof WatchedItem ) {
			return true;
		}
		
		if ( $oWatchItem->userID == 0 ) {
			return true;			
		}
		
		$oTitle = Title::makeTitle( $oWatchItem->nameSpace, $oWatchItem->databaseKey );
		if ( !is_object( $oTitle ) ) {
			return true;
		}
		
		$oRevision = Revision::newFromTitle( $oTitle );
		if ( !is_object( $oRevision ) ) {
			return true;
		}
				
		foreach ( array ( MWNamespace::getSubject( $oWatchItem->nameSpace ), MWNamespace::getTalk( $oWatchItem->nameSpace ) ) as $nameSpace ) {
			$params = array (
				'wl_user' => $oWatchItem->userID,
				'wl_namespace' => $nameSpace,
				'wl_title' => $oWatchItem->databaseKey,
				'wl_notificationtimestamp' => null,
				'wl_wikia' => $wgCityId,
				'wl_revision' => $oRevision->getId(),
				'wl_rev_timestamp' =>  $oRevision->getTimestamp()
			);
	
			try {
				$message = array(
					'method' => 'addWatch',
					'params' => $params
				);
				$data = json_encode( $message );
				WScribeClient::singleton('trigger')->send($data);
			}
			catch( Exception $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

		return true;
	}
	
	/**
	 * Hook function calls when watch was removed from database
	 * @param $oWatchItem WatchedItem: object
	 * @param $success Boolean: removed successfully
	 * @return bool (always true)
	 */		
	static public function removeGlobalWatch( $oWatchItem, $success ) {
		global $wgEnableScribeReport, $wgCityId;

		if ( empty($wgEnableScribeReport) ) {
			return true;
		}

		if ( !$oWatchItem instanceof WatchedItem ) {
			return true;
		}

		if ( !$success ) {
			/* some errors when update in local watchlist table */
			return true;
		}

		if ( $oWatchItem->userID == 0 ) {
			return true;
		}

		foreach ( array ( MWNamespace::getSubject( $oWatchItem->nameSpace ), MWNamespace::getTalk( $oWatchItem->nameSpace ) ) as $nameSpace ) {
			$params = array (
				'wl_user' => $oWatchItem->userID,
				'wl_namespace' => $nameSpace,
				'wl_title' => $oWatchItem->databaseKey,
				'wl_wikia' => $wgCityId
			);

			try {
				$message = array(
					'method' => 'removeWatch',
					'params' => $params
				);
				$data = json_encode( $message );
				WScribeClient::singleton('trigger')->send($data);
			}
			catch( Exception $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

		return true;
	}

	/**
	 * Hook function calls when watch was updated in database
	 * @param $oWatchItem WatchedItem: object
	 * @param $user Array or Integer: array of user IDs or user ID
	 * @param $timestamp Datetime or null
	 * @return bool (always true)
	 */
	static public function updateGlobalWatch( $oWatchItem, $user, $timestamp ) {
		global $wgEnableScribeReport, $wgCityId;

		if ( empty($wgEnableScribeReport) ) {
			return true;
		}

		if ( !$oWatchItem instanceof WatchedItem ) {
			return true;
		}

		if ( empty($user) ) {
			return true;
		}

		$oTitle = Title::makeTitle( $oWatchItem->nameSpace, $oWatchItem->databaseKey );
		if ( !is_object( $oTitle ) ) {
			return true;
		}

		$oRevision = Revision::newFromTitle( $oTitle );
		if ( !is_object( $oRevision ) ) {
			return true;
		}

		if ( !is_array($user) ) {
			$user = array( $user );
		}

		$rev_id = $oRevision->getId();
		$rev_timestamp = $oRevision->getTimestamp();

		foreach ( $user as $user_id ) {

			$params = array (
				'update' => array (
					'wl_notificationtimestamp' => $timestamp,
					'wl_revision' => $rev_id,
					'wl_rev_timestamp' => $rev_timestamp
				),
				'where' => array (
					'wl_title' => $oWatchItem->databaseKey,
					'wl_namespace' => $oWatchItem->nameSpace,
					'wl_user' => $user_id,
				),
				'wl_wikia' => $wgCityId
			);

			try {
				$message = array(
					'method' => 'updateWatch',
					'params' => $params
				);
				$data = json_encode( $message );
				WScribeClient::singleton('trigger')->send($data);
			}
			catch( Exception $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

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
		global $wgEnableScribeReport, $wgCityId;

		if ( empty($wgEnableScribeReport) ) {
			return true;
		}

		if ( !$oldTitle instanceof Title ) {
			return true;
		}

		if ( !$newTitle instanceof Title ) {
			return true;
		}

		if ( !is_array($rows) ) {
			return true;
		}

		foreach ( $rows as $row ) {
			if ( empty($row['wl_user']) ) {
				continue;
			}

			$oTitle = Title::makeTitle( $row['wl_namespace'], $row['wl_title'] );
			if ( !is_object( $oTitle ) ) {
				continue;
			}

			$oRevision = Revision::newFromTitle( $oTitle );
			if ( !is_object( $oRevision ) ) {
				continue;
			}

			$row['wl_revision'] = $oRevision->getId();
			$row['wl_rev_timestamp'] = $oRevision->getTimestamp();

			$params = array (
				'update' => $row,
				'where' => array(
					'wl_title' => $oldTitle->getDBkey(),
					'wl_namespace' => $oldTitle->getNamespace(),
					'wl_user' => $row['wl_user']
				),
				'wl_wikia' => $wgCityId
			);

			try {
				$message = array(
					'method' => 'updateWatch',
					'params' => $params
				);
				$data = json_encode( $message );
				WScribeClient::singleton('trigger')->send($data);
			}
			catch( Exception $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

		return true;
	}

	/**
	 * Hook function to delete all watches for User
	 * @param $oUser User: object
	 * @return bool (always true)
	 */
	static public function clearGlobalWatch( $oUser) {
		global $wgEnableScribeReport, $wgCityId;

		if ( empty($wgEnableScribeReport) ) {
			return true;
		}

		if ( !$oUser instanceof User ) {
			return true;
		}

		$user_id = $oUser->getId();

		if ( empty( $user_id ) ) {
			return true;
		}

		$params = array(
			'wl_user' => $user_id,
			'wl_wikia' => $wgCityId
		);

		try {
			$message = array(
				'method' => 'removeWatch',
				'params' => array( $params )
			);
			$data = json_encode( $message );
			WScribeClient::singleton('trigger')->send($data);
		}
		catch( Exception $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}

		return true;
	}


	/**
	 * Hook function to reset all watches for User
	 * @param $user_id Integer: User ID
	 * @return bool (always true)
	 */
	static public function resetGlobalWatch( $user_id ) {

		$oUser = User::newFromId( $user_id );
		$result = self::clearGlobalWatch( $oUser );


		return $result;
	}	
}
