<?php
class ARecoveryEngineApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_EVENT_INTERVAL = 900;

	public function getPageFairBootstrapHead() {
		$resourceLoader = new ResourceLoaderAdEnginePageFairRecoveryModule();
		$this->response->getView()->setTemplate( 'ARecoveryEngineApiController', 'getPageFairBootstrap' );
		$this->response->setVal( 'code', $resourceLoader->getScriptObserver() );
		$this->response->setVal( 'methodName', 'runPFCodeHead' );
	}

	public function getPageFairBootstrapTopBody() {
		$resourceLoader = new ResourceLoaderAdEnginePageFairRecoveryModule();
		$this->response->getView()->setTemplate( 'ARecoveryEngineApiController', 'getPageFairBootstrap' );
		$this->response->setVal( 'code', $resourceLoader->getScriptWrapper() );
		$this->response->setVal( 'methodName', 'runPFCodeTopBody' );
	}

	public function getPageFairBootstrapBottomBody() {
		$resourceLoader = new ResourceLoaderAdEnginePageFairRecoveryModule();
		$this->response->setVal( 'code', $resourceLoader->getScriptLoader() );
	}

	public function getInstartLogicBootstrap() {
		$resourceLoader = new ResourceLoaderAdEngineInstartLogicModule();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$this->response->setVal( 'code', $resourceLoader->getScript( $resourceLoaderContext ) );
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
