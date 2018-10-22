<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

class AutoLoginService extends WikiaService {
	/**
	 * @var KubernetesExternalUrlProvider
	 */
	private static $kubernetesExternalUrlProvider;

	const SYNC_COOKIE_NAME = 'autologin_done';

	public static function cookieSyncEnabled( WebRequest $request ) {
		return $request->getCookie( self::SYNC_COOKIE_NAME, "" ) !== '1' && $request->getCookie( self::SYNC_COOKIE_NAME, "" ) !== '2';
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

	protected function getServiceUrl() {
		return self::$kubernetesExternalUrlProvider->getUrl( 'autologin' ) . '/frame';
	}
}
