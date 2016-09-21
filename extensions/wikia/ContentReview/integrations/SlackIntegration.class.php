<?php

namespace Wikia\ContentReview\Integrations;

class SlackIntegration {

	private $webhook;

	function __construct() {
		global $wgContentReviewSlackWebhook;
		$this->webhook = $wgContentReviewSlackWebhook;
	}

	/**
	 * @param array $data
	 * @return bool|MWHttpRequest - false on failure
	 */
	public function sendMessage( array $data ) {
		$options = [
			'postData' => json_encode( $data ),
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			'returnInstance' => true,
		];

		$response = \Http::post( $this->webhook, $options );

		return $response;
	}
}
