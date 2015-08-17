<?php
/**
 * Class creating a subscribing task for a given user
 * @package Wikia\extensions\AutoFollow
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\AutoFollow;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Logger\WikiaLogger;

class AutoFollowTask extends BaseTask {

	/**
	 * Adds a user to watchlists of all articles defined in the
	 * global $wgAutoFollowWatchlist variable.
	 * @param integer $iUserId The user's ID
	 */
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

	/**
	 * Sets the 'autowatched-already' option to 1
	 * @param \User $oUser A user's object
	 */
	private function setFlag( \User $oUser ) {
		global $wgAutoFollowFlag;

		$oUser->setGlobalFlag( $wgAutoFollowFlag, 1 );
		$oUser->saveSettings();
	}

	/**
	 * Logs the results of all add-to-watchlist actions
	 * @param \User $oUser A user's object
	 * @param Array $aWatchSuccess An array of successfully watched articles' titles
	 * @param Array $aWatchFail An array of articles' titles that failed from being watched
	 */
	private function logResults( \User $oUser, Array $aWatchSuccess, Array $aWatchFail ) {
		global $wgSitename;

		$iFailures = count( $aWatchFail );
		$sUserName = $oUser->getName();
		$aLogParams = [
			'failures' => $iFailures,
			'user_id' => $oUser->getId(),
			'user_name' => $sUserName,
			'user_lang' => $oUser->getGlobalPreference( 'language' ),
			'watched' => $aWatchSuccess,
			'watched_failed' => $aWatchFail,
		];

		if ( $iFailures === 0 ) {
			WikiaLogger::instance()->info(
				"AutoFollow log: User {$sUserName} added to watchlist at {$wgSitename}.",
				$aLogParams
			);
		} else {
			WikiaLogger::instance()->error(
				"AutoFollow log: {$iFailures} happened when adding {$sUserName} to watchlist at {$wgSitename}.",
				$aLogParams
			);
		}
	}
}
