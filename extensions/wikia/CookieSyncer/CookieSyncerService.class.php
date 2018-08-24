<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

class CookieSyncerService extends WikiaService {
	private $kubernetesExternalUrlProvider;

	public function __construct() {
		parent::__construct();
		$this->kubernetesExternalUrlProvider = new KubernetesExternalUrlProvider();
	}

	public function index() {
		$this->setVal( 'url', $this->getServiceUrl() );
	}

	protected function getServiceUrl() {
		return $this->kubernetesExternalUrlProvider->getUrl( 'cookiesyncer' ) . '/frame';
	}
}
