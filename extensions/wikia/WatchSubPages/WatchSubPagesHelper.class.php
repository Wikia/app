<?php
/**
 * Author: Jakub Kurcek <jakub@wikia-inc.com>
 * Helper function for extension hook etc.
 */
class WatchSubPagesHelper {

	const PREFERENCES_ENTRY = 'watchsubpages';

	/**
	 * Add a checkbox to user preferences
	 *
	 * @param $user User current user
	 * @param $preferences array preferences to modify
	 */
	static public function onGetPreferences( User $user, Array &$preferences ) {
		$preferences[self::PREFERENCES_ENTRY] = array(
			'type' => 'toggle',
			'section' => 'watchlist/advancedwatchlist',
			'label' => wfMsg('tog-watchlistsubpages'),
		);
		return true;
	}

	/**
	 * Clears notification for parent pages if:
	 * - User is NOT watching currently viewed subpage
	 * - User is watching parent page
	 * - User has 'watchlistsubpages' turned on
	 *
	 * @param $article WikiPage object ( subpage )
	 *
	 * @author Jakub Kurcek <jakub@wikia-inc.com>
	 */
	static public function ClearParentNotification( WikiPage $page ) {
		global $wgUser;

		if ( (bool)$wgUser->getGlobalPreference( self::PREFERENCES_ENTRY ) ) {
			if ( ! $page->getTitle()->userIsWatching() ) {
				$tmpDBkey = $page->getTitle()->getDBkey();
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

	/**
	 * Adds users to watchlist if:
	 * - User is watching parent page
	 * - User has 'watchlistsubpages' turned on
	 *
	 * @param $watchers array of user ID
	 * @param $title Title object
	 * @param $editor User object
	 * @param $notificationTimeoutSql string timeout to the watchlist
	 *
	 * @author Jakub Kurcek <jakub@wikia-inc.com>
	 */
	static public function NotifyOnSubPageChange( $watchers, $title, $editor, $notificationTimeoutSql ) {
		wfProfileIn(__METHOD__);

		// Gets parent data
		$arrTitle = explode( '/' , $title->getDBkey() );

		if ( empty($arrTitle) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// make Title
		$t = reset( $arrTitle );
		$newTitle = Title::newFromDBkey( $t );
		if ( ! ( $newTitle instanceof Title ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

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
		$parentpageWatchers = array();

		while ( $row = $dbw->fetchObject( $res ) ) {
			$userId = intval($row->wl_user);
			$tmpUser = User::newFromId($userId);

			if ( (bool)$tmpUser->getGlobalPreference( self::PREFERENCES_ENTRY ) ) {
				$parentpageWatchers[] = $userId;
			}

			unset( $tmpUser );
		}

		// Updates parent watchlist timestamp for $parentOnlyWatchers.
		$parentOnlyWatchers = array_diff( $parentpageWatchers, $watchers );

		$wl = WatchedItem::fromUserTitle( $editor, $newTitle );
		$wl->updateWatch( $parentOnlyWatchers );

		wfProfileOut(__METHOD__);
		return true;
	}
}
