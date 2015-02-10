<?php

use Wikia\Tasks\Tasks\BaseTask;

class FollowEmailTask extends BaseTask {

	public function emailFollowNotifications( $aWatchers, $iUserId, $iNamespace, $sMessage, $sAction, $sChildTitleDBKey ) {
		$now = wfTimestampNow();
		$user = User::newFromId( $iUserId );
		$childTitle = Title::newFromDBkey( $sChildTitleDBKey );

		\Wikia\Logger\WikiaLogger::instance()->info( "WatchlistLogs: Sending bloglisting watchlist updates", [
			'listings' => $aWatchers,
		] );

		foreach ($aWatchers as $key => $value) {
			$enotif = new EmailNotification();
			$title = Title::makeTitle( $iNamespace, $key );
			$enotif->notifyOnPageChange( $user, $title,
				$now,
				$sMessage,
				0,
				0,
				$sAction,
				array('notisnull' => 1, 'childTitle' => $childTitle) );
		}
	}
}