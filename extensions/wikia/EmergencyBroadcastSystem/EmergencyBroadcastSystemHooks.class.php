<?php

class EmergencyBroadcastSystemHooks extends WikiaController {
	public function onBeforePageDisplay( OutputPage $out, $skin ) {
		$app = F::app();
		$assetsManager = AssetsManager::getInstance();

		if ( $app->checkSkin( 'oasis' ) ) {
			$scss = 'emergency_broadcast_system_scss';

			foreach ( $assetsManager->getURL( $scss ) as $url ) {
				$out->addStyle( $url );
			}
		}
		return true;
	}
}
