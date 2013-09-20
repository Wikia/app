<?php

class RTEController extends WikiaController {

	public function i18n() {
		global $wgResourceLoaderMaxage;

		$this->response->setVal('code',RTEAjax::getMessagesScript());
		$this->response->setContentType( 'text/javascript' );

		$currentCb = (new JSMessagesHelper)->getMessagesCacheBuster();
		$requestedCb = $this->request->getVal('cb');
		$key = $currentCb == $requestedCb ? 'versioned' : 'unversioned';

		$this->response->setCacheValidity(null,$wgResourceLoaderMaxage[$key]['client'],
			array(WikiaResponse::CACHE_TARGET_VARNISH));
		$this->response->setCacheValidity(null,$wgResourceLoaderMaxage[$key]['server'],
			array(WikiaResponse::CACHE_TARGET_BROWSER));
	}

}
