<?php
/**
 * @package Wikia\extensions\AutoFollow
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\AutoFollow;

class AutoFollowHooks {

	/**
	 * Check if a user's language in one of the sanctioned ones
	 * @param  User object The user's object
	 * @return {bool} true
	 */
	public static function onConfirmEmailComplete( \User $oUser ) {
		$this->addAutoFollowTask( $oUser );
		return true;
	}

	public function addAutoFollowTask( \User $oUser ) {
		global $wgAutoFollowLangCityIdMap;
		// Check only a core of the language code
		$sUserLanguage = explode( '-', $oUser->getOption( 'language' ) )[0];

		if ( isset( $wgAutoFollowLangCityIdMap[ $sUserLanguage ] ) &&
			$this->checkAutoFollowConditions( $oUser )
		) {
			$iCityId = $wgAutoFollowLangCityIdMap[ $sUserLanguage ];
			$oAutoFollowTasks = new AutoFollowTask();
			$oAutoFollowTasks->call( 'addUserToDefaultWatchlistTask', $oUser );
			$oAutoFollowTasks->wikiId( $iCityId );
			$oAutoFollowTasks->queue();
		}
	}

	public function checkAutoFollowConditions( \User $oUser ) {
		global $wgAutoFollowFlag;

		if ( $oUser->getOption( $wgAutoFollowFlag ) === 1 ) {
			return false;
		} elseif ( $oUser->getOption( 'marketingallowed' ) === 1 ) {
			return false;
		}

		return true;
	}
}
