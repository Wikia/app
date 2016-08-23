<?php
class ARecoveryEngineApiController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_EVENT_INTERVAL = 900;

	public function getDelivery() {
		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSDelivery();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$source = $resourceLoader->getScript( $resourceLoaderContext );

		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setBody( $source );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function getSourcePointStatus() {

		$wgGlobalEnableSourcePoint = WikiFactory::getVarValueByName( 'wgGlobalEnableSourcePoint', Wikia::COMMUNITY_WIKI_ID );

		$varId = WikiFactory::getVarIdByName( 'wgEnableUsingSourcePointProxyForCSS' );
		$sourcePointEnabledWikis = array_keys( WikiFactory::getListOfWikisWithVar( $varId, 'bool', '=', true ) );

		$resoponseBody = 'window.wikiaSourcePointStatus = ' . ( $wgGlobalEnableSourcePoint ? 'true;' : 'false;' ) . PHP_EOL;
		$resoponseBody .= 'window.wikiaSourcePointEnabledWikis = ' . json_encode( $sourcePointEnabledWikis ) . ';';

		$this->response->setContentType( 'text/javascript; charset=utf-8' );
		$this->response->setBody( $resoponseBody );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD, WikiaResponse::CACHE_DISABLED );
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
}
