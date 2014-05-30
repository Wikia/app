<?php

class OptimizelyController extends WikiaController {

	const OPTIMIZELY_SCRIPT_KEY = 'optimizelyScriptV.1.0';
	const CACHE_DURATION = 300; /* 5 minutes */

	public function getCode() {
		$response = $this->getResponse();
		$response->setContentType( 'text/javascript; charset=utf-8' );

		$storageModel = new MysqlKeyValueModel();
		try {
			$this->code = $storageModel->get( self::OPTIMIZELY_SCRIPT_KEY );
		} catch (Exception $e) {
			Wikia::log( __METHOD__, false, 'Cannot read optimizely code from storage' );
			$this->code = '';
		}

		$response->setCacheValidity( self::CACHE_DURATION );
	}
}
