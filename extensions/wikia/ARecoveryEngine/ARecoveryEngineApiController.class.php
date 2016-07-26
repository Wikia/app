<?php
class ARecoveryEngineApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_EVENT_INTERVAL = 900;

	/**
	 * @param ResourceLoaderAdEngineBase $resourceLoader
	 * @param int $cache
	 */
	protected function loadJSResource($resourceLoader, $cache = WikiaResponse::CACHE_STANDARD) {
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$source = $resourceLoader->getScript( $resourceLoaderContext );

		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setBody( $source );
		$this->response->setCacheValidity( $cache );
	}

	public function getDelivery() {
		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSDelivery();
		$this->loadJSResource( $resourceLoader );
	}

	public function getPageFairDetection() {
		$resourceLoader = new ResourceLoaderAdEnginePageFairDetectionModule();
		$this->loadJSResource( $resourceLoader );
	}

	public function getBootstrap() {
		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSBootstrap();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$this->response->setVal( 'code', $resourceLoader->getScript( $resourceLoaderContext ) );
		$this->response->setVal( 'domain', F::app()->wg->server );
	}

	public function getLogInfo() {
		\Wikia\Logger\WikiaLogger::instance()
			->warning( 'AdBlock Interference',
				[ 'action' => $this->request->getVal('kind') ]
			);
		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setBody( 'var arecoveryEngineLogInfoStatus=1;' );
		$this->response->setCacheValidity( self::MAX_EVENT_INTERVAL );
	}
}
