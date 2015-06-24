<?php

namespace Wikia\Service\Gateway;


use Http;

class ConsulUrlProvider implements UrlProviderInterface {

	private $healthUrlSchema = '{consulUrl}/v1/health/service/{serviceName}?passing&tag={serviceTag}';
	private $healthUrl;

	function __construct( $consulUrl, $serviceName, $serviceTag ) {
		if ( empty( $serviceName ) || empty( $serviceTag ) ) {
			throw new \InvalidArgumentException ( "serviceName or serviceTag not set" );
		}
		$this->healthUrl = strtr( $this->healthUrlSchema, [
			'{consulUrl}' => $consulUrl,
			'{serviceName}' => $serviceName,
			'{serviceTag}' => $serviceTag
		] );
	}

	public function getUrl() {
		$response = Http::Request( "GET", $this->healthUrl, [ 'noProxy' => true ] );
		$json_response = json_decode($response, true);
		if ( !empty( $json_response ) && is_array( $json_response ) ) {
			return implode(":",[$json_response[0]['Node']['Address'], $json_response[0]['Service']['Port']]);
		}
		return "";
	}
}
