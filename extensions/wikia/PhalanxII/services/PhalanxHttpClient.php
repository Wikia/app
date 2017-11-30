<?php

use Wikia\Service\Gateway\KubernetesUrlProvider;
use Wikia\Service\Gateway\UrlProvider;

class PhalanxHttpClient {
	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	public function __construct( KubernetesUrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	public function matchRequest( PhalanxMatchParams $phalanxMatchParams ) {
		return $this->doRequest( 'match', $phalanxMatchParams->buildQueryParams() );
	}

	public function regexValidationRequest( string $regex ) {
		return $this->doRequest( 'validate', http_build_query( [ 'regex' => $regex ] ) );
	}

	private function doRequest( string $action, string $queryParams ) {
		global $wgPhalanxServiceOptions;

		$url = $this->getServiceUrl( $action );
		$options = $wgPhalanxServiceOptions;

		$options['postData'] = $queryParams;

		return Http::post( $url, $options );
	}

	private function getServiceUrl( string $action ) {
		global $wgPhalanxServiceUrl;

		if ( !empty( $wgPhalanxServiceUrl ) ) {
			return "http://$wgPhalanxServiceUrl/$action";
		}

		return "http://{$this->urlProvider->getUrl( 'phalanx' )}/$action";
	}
}
