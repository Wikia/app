<?php
class AdEngine2ApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getCollapse() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function getBTCode() {
		global $wgUser;

		$this->response->setContentType( 'text/javascript' );
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		if ($wgUser->isAnon()) {
			$resourceLoader = new ResourceLoaderAdEngineBTCode();
			$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
			$this->response->setBody( $resourceLoader->getScript( $resourceLoaderContext ) );
		} else {
			$this->response->setBody( '' );
		}
	}

	public function getHMDCode() {
		global $wgUser;

		$this->response->setContentType( 'text/javascript' );
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		if ($wgUser->isAnon()) {
			$resourceLoader = new ResourceLoaderAdEngineHMDCode();
			$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
			$this->response->setBody( $resourceLoader->getScript( $resourceLoaderContext ) );
		} else {
			$this->response->setBody( '' );
		}
	}
}
