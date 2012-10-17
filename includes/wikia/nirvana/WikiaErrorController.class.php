<?php

/**
 * Nirvana Framework - Error controller
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaErrorController extends WikiaController {

	public function error() {
		$code = $this->response->getException()->getCode();

		if( empty( $code ) || !$this->isValidHTTPCode( $code ) ) {
			$code = WikiaResponse::RESPONSE_CODE_ERROR;
		}

		$this->response->setCode( $code );
		$this->response->setVal( 'request', $this->request );
		$this->response->setVal( 'response', $this->response );
		$this->response->setVal( 'devel', $this->app->wg->DevelEnvironment );
	}

	private function isValidHTTPCode( $code ) {
		//HTTP response codes MUST be 3 digits and 500 MUST be avoided since it fallbacks to Iowa
		return ( ($code > 99) && ($code < 999) && ($code != 500) );
	}
}
