<?php

class AssetsManagerController extends WikiaController {

	/**
	 * Return different type of assets in a single request
	 */
	public function getMultiTypePackage() {
		// TODO: handle templates via sendRequest

		// TODO: handle CSS/SASS files

		// TODO: handle JS files / assets manager packages

		// handle JSmessages
		$messages = $this->request->getVal('messages');
		if (!is_null($messages)) {
			$messagePackages = explode(',', $messages);
			$this->response->setVal('messages', F::getInstance('JSMessages')->getPackages($messagePackages));
		}

		// handle cache time
		$ttl = $this->request->getVal('ttl');
		if ($ttl > 0) {
			$this->response->setCacheValidity($ttl, $ttl, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		}

		$this->response->setFormat('json');
	}
}
