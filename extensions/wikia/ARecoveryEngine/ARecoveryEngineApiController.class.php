<?php
class ARecoveryEngineApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getDelivery() {


		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSDelivery();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$source = $resourceLoader->getScript($resourceLoaderContext);
		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setVal('code', $source);
		$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);
	}
}
