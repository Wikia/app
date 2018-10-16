<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

class AutoLoginHooks
{
	/**
	 * @var KubernetesExternalUrlProvider
	 */
	private static $kubernetesExternalUrlProvider;

	/**
	 * @param KubernetesExternalUrlProvider $kubernetesExternalUrlProvider
	 */
	public static function setKubernetesExternalUrlProvider( $kubernetesExternalUrlProvider ) {
		self::$kubernetesExternalUrlProvider = $kubernetesExternalUrlProvider;
	}

	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function onWikiaSkinTopScripts( array &$vars, &$scripts ) {
		$vars['wgPassiveAutologinUrl'] = self::$kubernetesExternalUrlProvider->getAlternativeUrl( 'autologin' ) . '/passive_frame';
		$vars['wgTrustedAutologinUrl'] = rtrim( self::$kubernetesExternalUrlProvider->getAlternativeUrl( '' ), '/' );
	}
}
