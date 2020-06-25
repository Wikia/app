<?php

declare( strict_types=1 );

final class AnonymizeIpController extends WikiaController {
	public function allowsExternalRequests() {
		return false;
	}

	/**
	 * Introduced for UCP. This method will be triggered by UCP to anonymize IP.
	 * This should be executed in context of a wiki.
	 */
	public function anonymizeIp() {
		// Set initial response code to 500. It will be overridden when request is successful
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );

			return;
		}
		$ip = $this->getVal( 'ip' );
		if ( empty( $ip ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );

			return;
		}
		$ipAnonymizer = new IpAnonymizer();
		$ipAnonymizer->anonymizeIp( $ip );
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}
}
