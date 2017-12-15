<?php

class RTEController extends WikiaController {

	public function i18n() {
		global $wgResourceLoaderMaxage;

		$this->response->setVal('code',RTEAjax::getMessagesScript());
		$this->response->setContentType( 'text/javascript' );

		$currentCb = (new JSMessagesHelper)->getMessagesCacheBuster();
		$requestedCb = $this->request->getVal('cb');
		$key = $currentCb == $requestedCb ? 'versioned' : 'unversioned';

		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity($wgResourceLoaderMaxage[$key]['server']. $wgResourceLoaderMaxage[$key]['client']);
	}

}
