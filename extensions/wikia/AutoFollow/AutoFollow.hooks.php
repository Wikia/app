<?php
/**
 * @package Wikia\extensions\AutoFollow
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\AutoFollow;

class AutoFollowHooks {

	public static function onSignupConfirmEmailComplete( \User $oUser ) {
		$instance = new self;
		$instance->addAutoFollowTask( $oUser );
		return true;
	}

	/**
	 * Checks if a user's language in one of the sanctioned ones
	 * and has agreed to receive marketing information.
	 * If yes it adds a task to add the user to watchlists.
	 * @param  \User object The user's object
	 * @return bool
	 */
	public function addAutoFollowTask( \User $oUser ) {
		global $wgAutoFollowLangCityIdMap;
		// Check only a core of the language code
		$sUserLanguage = explode( '-', $oUser->getGlobalPreference( 'language' ) )[0];
		if ( isset( $wgAutoFollowLangCityIdMap[ $sUserLanguage ] ) &&
			$this->checkAutoFollowConditions( $oUser )
		) {
			$iCityId = $wgAutoFollowLangCityIdMap[ $sUserLanguage ];
			$oAutoFollowTask = new AutoFollowTask();
			$oAutoFollowTask->call( 'addUserToDefaultWatchlistTask', $oUser->getId() );
			$oAutoFollowTask->wikiId( $iCityId );
			$oAutoFollowTask->queue();
		}
	}

	/**
	 * Check if the user hasn't been subscribed to a watchlist
	 * and if he agreed to receive marketing information
	 * @param  \User $oUser A user's object
	 * @return bool
	 */
	private function checkAutoFollowConditions( \User $oUser ) {
		global $wgAutoFollowFlag;
		if ( (bool)$oUser->getGlobalFlag( $wgAutoFollowFlag ) === true ) {
			return false;
		} elseif ( (bool)$oUser->getGlobalPreference( 'marketingallowed' ) === false ) {
			return false;
		}

		return true;
	}
}
