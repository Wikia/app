<?php
/*
 * Author: Jakub Kurcek <jakub@wikia-inc.com>
 * Helper function for extension hook etc.
 */

class WatchSubPagesHelper {

	/*
	 * Add togglers and translations\
	 *
	 * @author Jakub Kurcek <jakub@wikia-inc.com>
	 */

	public static function AddToUserMenu( &$extraToggles ) {
		$extraToggles[] = 'watchlistsubpages';
		return true;
	}

	static public function AddUsedToggles( &$obj ) {
		$obj->mUsedToggles['watchsubpages'] = true;
		return true;
	}

	/*
	 * Clears notification for parent pages if:
	 * - User is NOT watching currently viewed subpage
	 * - User is watching parent page
	 * - User has 'watchlistsubpages' turned on
	 * 	 *
	 * @param $article Article object ( subpage )
	 *
	 * @author Jakub Kurcek <jakub@wikia-inc.com>
	 */

	static public function ClearParentNotification( $article ) {
		global $wgUser;

		if ( $wgUser->getBoolOption( 'watchlistsubpages' ) ) {
			if ( ! $article->getTitle()->userIsWatching() ) {
				$tmpDBkey = $article->getTitle()->getDBkey();
				$arrTitle = explode( '/', $tmpDBkey );
				if ( count( $arrTitle > 1 ) ) {
					$parentTitle = Title::newFromDBkey( $arrTitle[0] );
					if ( $parentTitle->userIsWatching() ) {
						$wgUser->clearNotification( $parentTitle );
					}
				}
			}
		}
		return true;
	}

	/*
	 * Adds users to watchlist if:
	 * - User is watching parent page
	 * - User has 'watchlistsubpages' turned on
	 *
	 * @param $watchers array of user ID
	 * @param $title Title object
	 * @param $editor User object
	 * @param $notificationTimeoutSql string | timeout to the watchlist
	 * @param $method __METHOD__
	 * @param $dbtypestring database type
	 *
	 * @author Jakub Kurcek <jakub@wikia-inc.com>
	 */

	static public function NotifyOnSubPageChange( $watchers, $title, $editor, $notificationTimeoutSql ) {
		// Gets parent data
		$arrTitle = explode( '/' , $title->getDBkey() );
		
		if ( empty($arrTitle) ) {
			return true;
		}
		
		// make Title		
		$t = reset( $arrTitle );
		$newTitle = Title::newFromDBkey( $t );
		if ( ! ( $newTitle instanceof Title ) ) {
			return true;
		}
		
		$parentOnlyWatchers = array();
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select( array( 'watchlist' ),
			array( 'wl_user' ),
			array(
				'wl_title' => $newTitle->getDBkey(),
				'wl_namespace' => $newTitle->getNamespace(),
				'wl_user != ' . intval( $editor->getID() ),
				$notificationTimeoutSql
			),
			__METHOD__
		);

		// Gets user settings
		while ( $row = $dbw->fetchObject( $res ) ) {

			$tmpUser = new User();
			$tmpUser->setId( intval( $row->wl_user ) );
			$tmpUser->loadFromId();
			
			$userToggles = $tmpUser->getToggles();
			WatchSubPagesHelper::AddToUserMenu( &$userToggles );
			if ( $tmpUser->getBoolOption( 'watchlistsubpages' ) ) {
				$parentpageWatchers[] = (integer)$row->wl_user;
			}
			
			unset( $tmpUser );
		}

		// Updates parent watchlist timestamp for $parentOnlyWatchers.
		$parentOnlyWatchers = array_diff( $parentpageWatchers, $watchers );
		
		$wl = WatchedItem::fromUserTitle( $editor, $newTitle );
		$wl->updateWatch( $parentOnlyWatchers, $timestamp );

		return true;
	}
}
