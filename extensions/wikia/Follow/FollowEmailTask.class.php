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

		$this->info( 'WatchlistLogs: Sending bloglisting watchlist updates', [
			'watchedPages' => $aWatchers,
		] );

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
}
