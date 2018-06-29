<?php
class AdEngine2ApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function getCollapse() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function getModelData() {
		$cors = new CrossOriginResourceSharingHeaderHelper();
		$cors->setAllowAllOrigins();
		$cors->setHeaders( $this->response );

		$params = $this->request->getParams();

		switch ( $params['id'] ) {
			case 'n1dtc':
				$json = file_get_contents( __DIR__ . '/resources/ml/n1dtc.json' );
				break;
			default:
				$json = '{}';
		}

		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setContentType( 'application/json' );
		$this->response->setBody( $json );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );
	}

	public function getBlockthroughCode() {
		$resourceLoader = new ResourceLoaderAdEngineBlockthroughCode();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );

		$this->response->setContentType( 'text/javascript' );
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );
		$this->response->setBody( $resourceLoader->getScript( $resourceLoaderContext ) );
	}

	public function getInstartLogicCode() {
		$resourceLoader = new ResourceLoaderAdEngineInstartLogicCode();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );

		$this->response->setContentType( 'text/javascript' );
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );
		$this->response->setBody( $resourceLoader->getScript( $resourceLoaderContext ) );
	}
}
