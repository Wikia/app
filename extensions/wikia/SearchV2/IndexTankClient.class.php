<?php

class IndexTankClient extends WikiaSearchClient {

	/**
	 * IndexTank API
	 * @var Indextank_Api
	 */
	private $client = null;

	public function __construct( $apiUrl, $httpProxy = false) {
		$this->client = F::build( 'Indextank_Api', array( $apiUrl ) );

		if( !empty($httpProxy) ) {
			$this->client->set_http_options( array( CURLOPT_PROXY => $httpProxy ) );
		}
	}

	public function search( $query, $start, $length ) {
		$index = $this->client->get_index("WikiaTest");
		return $index->search( $query, $start, $length, null, 'text', '*' );
	}

}
