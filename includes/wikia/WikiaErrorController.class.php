<?php

class WikiaErrorController extends WikiaController {

	public function error() {
		switch($this->getResponse()->getException()->getCode()) {
			case 404:
				//$this->getResponse()->setHttpResponseCode(404);
				break;
			case 501:
			default:
				//$this->getResponse()->setHttpResponseCode(501);
		}

		if ($this->getResponse()->getPrinter() instanceof WikiaResponseJSONPrinter) {
			//$this->getResponse()->setHttpHeader('FedericoErrorHeader', $this->getResponse()->getException()->getMessage());
		}
	}
}