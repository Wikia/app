<?php

use Wikia\Service\Gateway\KubernetesExternalUrlProvider;

class AutoLoginController extends WikiaController {

	private $kubernetesExternalUrlProvider;

	public function __construct() {
		parent::__construct();
		$this->kubernetesExternalUrlProvider = new KubernetesExternalUrlProvider();
	}

	public function index() {
		\Wikia\Logger\WikiaLogger::instance()->info("IFRAME", ["data" => $this->getData()]);
		$this->setVal( 'url', $this->getData() );
	}

	public function getData() {
		return $this->kubernetesExternalUrlProvider->getUrl( 'autologin' ).'/frame';
	}
}
