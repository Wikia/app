<?php

/**
 * Nirvana Framework - Error controller
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaErrorController extends WikiaController {

	public function error() {
		$code = $this->getResponse()->getException()->getCode();

		if( empty( $code ) || !$this->isValidHTTPCode( $code ) ) {
			$code = WikiaResponse::RESPONSE_CODE_ERROR;
		}

		$this->getResponse()->setCode( $code );
		$this->getResponse()->setVal('request', $this->request);
		$this->getResponse()->setVal('response', $this->response);
		$this->getResponse()->setVal('devel', $this->app->getGlobal( 'wgDevelEnvironment' ) );
	}

	private function isValidHTTPCode( $code ) {
		//HTTP response codes MUST be 3 digits and 500 MUST be avoided since it fallbacks to Iowa
		return (($code > 99) && ($code < 999) && ($code != 500));
	}
}
