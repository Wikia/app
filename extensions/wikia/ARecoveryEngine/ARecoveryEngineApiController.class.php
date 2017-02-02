<?php
class ARecoveryEngineApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_EVENT_INTERVAL = 900;

	public function getDelivery() {
		$this->loadScript(new ResourceLoaderAdEngineSourcePointCSDelivery());
	}

	public function getSourcePointMessaging() {
		$this->loadScript(new ResourceLoaderAdEngineSourcePointMessage());
	}

	public function getSourcePointMMSClient() {
		$this->loadScript(new ResourceLoaderAdEngineSourcePointMMSClient());
	}

	public function getBootstrap() {
		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSBootstrap();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$this->response->setVal( 'code', $resourceLoader->getScript( $resourceLoaderContext ) );
		$this->response->setVal( 'domain', F::app()->wg->server );
		$this->response->setVal( 'cs_endpoint', ResourceLoaderAdEngineSourcePointCSDelivery::CS_ENDPOINT );
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

	private function loadScript(\ResourceLoaderModule $resourceLoader) {
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$source = $resourceLoader->getScript( $resourceLoaderContext );

		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setBody( $source );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}
}
