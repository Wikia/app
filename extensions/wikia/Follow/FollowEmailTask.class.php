<?php

use Wikia\Tasks\Tasks\BaseTask;

class FollowEmailTask extends BaseTask {

	public function emailFollowNotifications( $initiatingUser, $aWatchers, $iUserId, $iNamespace, $sMessage, $sAction ) {
		$wg = F::app()->wg;
		$wg->DBname = WikiFactory::IDtoDB( $this->getWikiId() );
		$wg->Server = trim( WikiFactory::DBtoUrl( F::app()->wg->DBname ), '/' );

		if ( !empty( $wg->DevelEnvironment ) ) {
			$wg->Server = WikiFactory::getLocalEnvURL( $wg->Server );
		}

		$wg->User = User::newFromId( $initiatingUser );

		$targetUser = User::newFromId( $iUserId );

		$this->logWatchers( $aWatchers, $sAction );

		foreach ( $aWatchers as $sKey => $sValue ) {
			$oTitle = Title::makeTitle( $iNamespace, $sKey );
			$oEmailNotification = new EmailNotification( $targetUser, $oTitle,
				wfTimestampNow(),
				$sMessage,
				false,
				$currentRevId = 0,
				$previousRevId = 0,
				$sAction,
				[ 'notisnull' => 1, 'childTitle' => $this->title ]
			);
			$oEmailNotification->notifyOnPageChange();
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
