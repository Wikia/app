<?php

declare( strict_types=1 );

final class AnonymizeIpController extends WikiaController {
	public function allowsExternalRequests() {
		return false;
	}

	/**
	 * Introduced for UCP. This method will be triggered by UCP to anonymize ip.
	 * This should be executed in context of a wiki.
	 */
	public function anonymizeIp() {
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
	}
}
