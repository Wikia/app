<?php

/**
 * AdEngine Controller
 */
class AdEngineController extends WikiaController {
	public function postLog() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );
			return;
		}

		\Wikia\Logger\WikiaLogger::instance()
			->info(
				'AdEngine log',
				$this->context->getRequest()->getValues()
			);

		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT );
	}
}
