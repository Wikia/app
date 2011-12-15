<?php

class AmazonCSClient extends WikiaSearchClient {

	protected $searchEndpoint;
	protected $rankName;
	protected $httpProxy;

	public function __construct( $searchEndpoint, $rankName, $httpProxy ) {
		$this->searchEndpoint = $searchEndpoint;
		$this->rankName = $rankName;
		$this->httpProxy = $httpProxy;
	}

	public function search( $query, $start, $size, $cityId = 0 ) {
		$params = array(
			'q' => $query,
			'rank' => $this->rankName,
			'start' => $start,
			'size' => $size,
			'return-fields' => 'title,url,text,canonical'
		);
		if( !empty( $cityId ) ) {
			// inter-wiki search
			$params['bq'] = "cityid:$cityId";
		}

		list($responseCode, $response) = $this->apiCall( $this->searchEndpoint, $params );

		if($responseCode == 200) {
			$response = json_decode( $response );
			return $response->hits;
		}
		else {
			throw new WikiaException('Search Failed: ' . $response);
		}
	}

	private function apiCall( $url, $params = array()) {
		$paramsEncoded = '';
		foreach($params as $key => $value ) {
			$paramsEncoded .= ( !empty($paramsEncoded) ? '&' : '' ) . $key . '=' . urlencode($value);
		}

		$session = curl_init($url . '?' . $paramsEncoded);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'GET'); // Tell curl to use HTTP method of choice
		curl_setopt($session, CURLOPT_HEADER, false); // Tell curl not to return headers
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Tell curl to return the response

		if( !empty($this->httpProxy) ) {
			curl_setopt($session, CURLOPT_PROXY, $this->httpProxy);
		}

		$response = curl_exec($session);
		$responseCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
		curl_close($session);

		return array( $responseCode, $response );
	}
}