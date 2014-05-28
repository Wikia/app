<?php

class OptimizelyController extends WikiaController {

	const OPTIMIZELY_SCRIPT_KEY = 'optimizelyScript';
	const CACHE_DURATION = 300; /* 5 minutes */

	public function getCode() {
		$response = $this->getResponse();
		$response->setContentType( 'text/javascript; charset=utf-8' );

		$storageModel = new MysqlKeyValueModel();
		$storedData = $storageModel->get( self::OPTIMIZELY_SCRIPT_KEY );
		$this->code = $storedData[ 'script' ];

		$response->setCacheValidity( self::CACHE_DURATION );
	}
}
