<?php

class OptimizelyController extends WikiaController {

	use Wikia\Logger\Loggable;

	const OPTIMIZELY_SCRIPT_KEY = 'optimizely_script_v.1.0';

	public function getCode() {
		$response = $this->getResponse();
		$response->setContentType( 'text/javascript; charset=utf-8' );

		$storageModel = new MySQLKeyValueModel();
		try {
			$this->code = $storageModel->get( self::OPTIMIZELY_SCRIPT_KEY );
		} catch ( Exception $e ) {
			$this->error( __METHOD__ . ' - cannot read Optimizely code from storage.', [ 'exception' => $e ] );
			$this->code = '';
		}

		$response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}
}
