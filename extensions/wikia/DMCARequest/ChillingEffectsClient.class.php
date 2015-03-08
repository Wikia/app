<?php

namespace DMCARequest;

class ChillingEffectsClient {
	const BASE_URL = 'https://chillingeffects.org/notices';
	private $apiToken;

	public function __construct( $apiToken ) {
		$this->apiToken = $apiToken;
	}

	public function send( $noticeData ) {
		$requestData = [
			'authentication_token' => $this->apiToken,
			'notice' => $noticeData,
		];

		return \Http::post( self::BASE_URL, [ 'postData' => $requestData ] );
	}
}
