<?php

namespace Wikia\AutoFollow;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Logger\WikiaLogger;

class AutoFollowTask extends BaseTask {

	public function addUserToDefaultWatchlistTask( $iUserId ) {
		global $wgAutoFollowWatchlist;

		if ( !empty( $wgAutoFollowWatchlist ) ) {
			$oUser = \User::newFromId( $iUserId );
			$aWatchSuccess = $aWatchFail = [];

			foreach ( $wgAutoFollowWatchlist as $sTitleText ) {
				$oTitle = \Title::newFromText( $sTitleText );

				if ( $oTitle instanceof \Title ) {
					\WatchAction::doWatch( $oTitle, $oUser );
					$aWatchSuccess[] = $sTitleText;
				} else {
					$aWatchFail[] = $sTitleText;
				}
			}

			if ( count( $aWatchFail ) === 0 ) {
				$this->setFlag( $oUser );
			}

			$this->logResults( $oUser, $aWatchSuccess, $aWatchFail );
		}
	}

	private function setFlag( \User $oUser ) {
		global $wgAutoFollowFlag;

		$oUser->setOption( $wgAutoFollowFlag, 1 );
		$oUser->saveSettings();
	}

	private function logResults( \User $oUser, Array $aWatchSuccess, Array $aWatchFail ) {
		global $wgSitename;

		$iFailures = count( $aWatchFail );
		$sUserName = $oUser->getName();
		$aLogParams = [
			'failures' => $iFailures,
			'user_id' => $oUser->getId(),
			'user_name' => $sUserName,
			'user_lang' => $oUser->getOption( 'language' ),
			'watched' => $aWatchSuccess,
			'watched_failed' => $aWatchFail,
		];

		if ( $iFailures === 0 ) {
			WikiaLogger::instance()->info(
				"AutoFollow log: User {$sUserName} added to watchlist at {$wgSitename}.",
				$aLogParams
			);
		} else {
			WikiaLogger::instance()->info(
				"AutoFollow log: {$iFailures} happened when adding {$sUserName} to watchlist at {$wgSitename}.",
				$aLogParams
			);
		}
	}
}
