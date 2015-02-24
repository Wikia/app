<?php

use Wikia\Tasks\Tasks\BaseTask;

class FollowEmailTask extends BaseTask {

	public function emailFollowNotifications( $aWatchers, $iUserId, $iNamespace, $sMessage, $sAction ) {
		$now = wfTimestampNow();
		$oUser = User::newFromId( $iUserId );

		$this->info( 'WatchlistLogs: Sending bloglisting watchlist updates', [
			'watchedPages' => $aWatchers,
		] );

		foreach ( $aWatchers as $sKey => $sValue ) {
			$oEmailNotification = new EmailNotification();
			$oTitle = Title::makeTitle( $iNamespace, $sKey );
			$oEmailNotification->notifyOnPageChange( $oUser, $oTitle,
				$now,
				$sMessage,
				0,
				0,
				$sAction,
				[ 'notisnull' => 1, 'childTitle' => $this->title ]
			);
		}
	}
}
