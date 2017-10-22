<?php
namespace Wikia\Tasks\Tasks;

use User;
use WatchedItem;

/**
 * Asynchronous task to update an user's watchlist
 *
 * @see https://wikia-inc.atlassian.net/browse/SUS-1924
 */
class WatchlistUpdateTask extends BaseTask {
	/**
	 * Remove the watchlist notification for the current page for this user.
	 *
	 * @param int $userId Watchlist owner
	 */
	public function clearWatch( int $userId ) {
		$user = User::newFromId( $userId );

		if ( $user ) {
			$watchedItem = WatchedItem::fromUserTitle( $user, $this->title );
			$watchedItem->clearWatch();
		}
	}

	/**
	 * Clear the "You have new messages!" notification for this user
	 * Does not use user ID, because anons may have talk pages, and they don't have an user ID.
	 *
	 * @param string $userNameOrIpAddress
	 */
	public function clearMessageNotification( string $userNameOrIpAddress ) {
		$user = User::newFromName( $userNameOrIpAddress );

		if ( $user ) {
			$user->setNewtalk( false );
		}
	}
}
