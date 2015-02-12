<?php

namespace Wikia\PowerUser;

class PowerUserHooks {

	public function onEditCountIncreased( \User $oUser ) {
		if ( !$oUser->isSpecificPowerUser( PowerUser::TYPE_LIFETIME ) ) {
			
		}
	}
}