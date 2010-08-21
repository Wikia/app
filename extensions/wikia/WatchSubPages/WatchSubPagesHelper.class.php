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
		wfLoadExtensionMessages( 'WatchSubPages' );
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

	static public function NotifyOnSubPageChange( $watchers, $title, $editor, $notificationTimeoutSql, $method, $dbtype ) {
		$subpagesWatchers  = array();

		// Gets parent data
		$arrTitle = explode( '/' , $title->getDBkey() );
		$dbw = wfGetDB( $dbtype );
		$res = $dbw->select( array( 'watchlist' ),
				array( 'wl_user' ),
				array(
					"wl_title" => $arrTitle[0],
					'wl_namespace' => $title->getNamespace(),
					'wl_user != ' . intval( $editor->getID() ),
					$notificationTimeoutSql
				),
			$method
		);

		// Gets user settings
		while ( $row = $dbw->fetchObject( $res ) ) {

			$tmpUser = New User();
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
		$parentOnlyWatchers = array_diff( $parentpagesWatchers, $watchers );
		$dbw->begin();
		$dbw->update( 'watchlist',
			array( /* SET */
				'wl_notificationtimestamp' => $dbw->timestamp( $timestamp )
			), array( /* WHERE */
				'wl_title' => $title-> $arrTitle[0],
				'wl_namespace' => $title->getNamespace(),
				'wl_user' => $parentOnlyWatchers
			), __METHOD__
		);
		$dbw->commit();

		return true;
	}
}
