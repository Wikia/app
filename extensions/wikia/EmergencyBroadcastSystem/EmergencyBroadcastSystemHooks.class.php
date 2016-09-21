<?php

class EmergencyBroadcastSystemHooks extends WikiaController {

	public static function onBeforePageDisplay( OutputPage $out, $skin ) {
		global $wgUser;

		if ( F::app()->checkSkin( 'oasis' ) && $wgUser->isPowerUser() ) {
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL(
				'extensions/wikia/EmergencyBroadcastSystem/css/EmergencyBroadcastSystem.scss'
			) );
		}

		return true;
	}

}
