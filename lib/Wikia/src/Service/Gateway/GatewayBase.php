<?php

namespace Wikia\Service\Gateway;

use Http;

class GatewayBase {

	private $urlProvider;

	function __construct( UrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	public function get( $path, $headers = null ) {
		return $this->doRequest( "GET", $path, $headers );
	}

	public function put( $path, $headers = null, $data = null ) {
		return $this->doRequest( "PUT", $path, $headers, $data );
	}

	public function post( $path, $headers = null, $data = null ) {
		return $this->doRequest( "POST", $path, $headers, $data );
	}

	public function delete( $path, $headers = null ) {
		return $this->doRequest( "DELETE", $path, $headers );
	}

	private function doRequest( $method, $path, $headers = null, $data = null ) {
		$url = $this->getUrl( $path );
		$options = $this->getHttpRequestOption( $headers, $data );
		$response = Http::Request( $method, $url, $options );
		return $response;
	}

	private function getHttpRequestOption( $headers, $data ) {
		$options = [ ];
		$options[ "postData" ] = $data;
		$options[ "headers" ] = $headers;
		$options[ "noProxy" ] = true;

		return $options;
	}

	private function getUrl( $path ) {
		$url = $this->urlProvider->getUrl();
		return $url . $path;
	}
}
