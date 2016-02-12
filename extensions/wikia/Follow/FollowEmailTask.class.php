<?php

use Wikia\Tasks\Tasks\BaseTask;

class FollowEmailTask extends BaseTask {

	/**
	 * Given some information about a notification, sends emails to all following users
	 *
	 * @param int $initiatingUser The user that initiated this by making a change
	 * @param array $watchers A mapping of titles to an array of users following that title
	 * @param int $userId The editor of whatever changed.  Likely the same as $initiatingUser
	 * @param int $namespace The namespace of the title which changed
	 * @param string $message The commit message for the change
	 * @param string $action The action taken (create, edit, delete, etc)
	 */
	public function emailFollowNotifications( $initiatingUser, $watchers, $userId, $namespace, $message, $action ) {
		Wikia::initAsyncRequest( $this->getWikiId(), $initiatingUser );

		$targetUser = User::newFromId( $userId );

		$this->logWatchers( $watchers, $action );

		foreach ( $watchers as $titleText => $followingUsers ) {
			$title = Title::makeTitle( $namespace, $titleText );
			$emailNotification = new EmailNotification( $targetUser, $title,
				wfTimestampNow(),
				$message,
				false,
				$currentRevId = 0,
				$previousRevId = 0,
				$action,
				[ 'notisnull' => 1, 'childTitle' => $this->title ]
			);
			$emailNotification->notifyOnPageChange( $followingUsers );
		}
	}

	private function logWatchers( $watchers, $action ) {
		if ( $action == FollowHelper::LOG_ACTION_BLOG_POST ) {
			$msg = 'WatchlistLogs: Sending bloglisting watchlist updates';
		} elseif ( $action == FollowHelper::LOG_ACTION_CATEGORY_ADD ) {
			$msg = 'WatchlistLogs: Sending categoryadd watchlist updates';
		} else {
			$msg = 'WatchlistLogs: Sending other watchlist updates';
		}

		$this->info( $msg, [ 'watchers' => $watchers, 'action' => $action ] );
	}
}
