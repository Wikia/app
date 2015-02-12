<?php

namespace Wikia\PowerUser;

class PowerUserHooks {

	public static function setupHooks() {
		$oPowerUserHooks = new self();
		\Hooks::register( 'NewRevisionFromEditComplete', [ $oPowerUserHooks, 'onNewRevisionFromEditComplete' ] );
	}

	public function onNewRevisionFromEditComplete( $oArticle, $oRevision, $iBaseRevId, $oUser ) {
		$oUserStatsService = new \UserStatsService( $oUser->getId() );

		if ( !$oUser->isSpecificPowerUser( PowerUser::TYPE_LIFETIME ) &&
			$oUserStatsService->getEditCountGlobal() > PowerUser::MIN_LIFETIME_EDITS
		) {
			$oPowerUser = new PowerUser( $oUser );
			$oPowerUser->addPowerUserProperty( PowerUser::TYPE_LIFETIME );
		}

		return true;
	}
}
