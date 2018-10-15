<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

class AutoLoginService extends WikiaService {
	/**
	 * @var KubernetesExternalUrlProvider
	 */
	private static $kubernetesExternalUrlProvider;

	const SYNC_COOKIE_NAME = 'autologin_done';

	public static function cookieSyncEnabled( WebRequest $request ) {
		return $request->getCookie( self::SYNC_COOKIE_NAME, "" ) !== '1';
	}

	/**
	 * @param KubernetesExternalUrlProvider $kubernetesExternalUrlProvider
	 */
	public static function setKubernetesExternalUrlProvider( $kubernetesExternalUrlProvider ) {
		self::$kubernetesExternalUrlProvider = $kubernetesExternalUrlProvider;
	}

	public function index() {
		$this->setVal( 'url', $this->getServiceUrl() );
	}

	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function onWikiaSkinTopScripts( array &$vars, &$scripts ) {
		$vars['wgPassiveAutologinUrl'] = self::$kubernetesExternalUrlProvider->getAlternativeUrl( 'autologin' ) . '/passive_frame';
		$vars['wgTrustedAutologinUrl'] = rtrim( self::$kubernetesExternalUrlProvider->getAlternativeUrl( '' ), '/' );
	}


	protected function getServiceUrl() {
		return self::$kubernetesExternalUrlProvider->getUrl( 'autologin' ) . '/frame';
	}
}
