<?php

use Wikia\Logger\Loggable;

class TestWikisController extends WikiaController {
	use Loggable;
	const WIKI_ID = 'wikiId';

	public function getIp() {
		$context = $this->getContext();
		$request = $context->getRequest();




		$this->response->setCode( 200 );

		$this->response->setVal("message", "I AM WORKING");
	}

	public function allowsExternalRequests() {
		return false;
	}
}