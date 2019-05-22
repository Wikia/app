<?php

use PHPUnit\Framework\TestCase;

class AdEngine3ApiControllerTest extends TestCase {
	public function testBTEndpointResponse() {
		$response = $this->requestRecCode('bt');

		$this->assertEquals('text/javascript', $response->getContentType());
		$this->assertContains("window['BT']", $response->getBody());
	}

	public function testHMDEndpointResponse() {
		$response = $this->requestRecCode('hmd');

		$this->assertEquals('text/javascript', $response->getContentType());
		$this->assertContains("getHmdConfig", $response->getBody());
	}

	private function requestRecCode($type) {
		$api = new AdEngine3ApiController();
		$request = new WikiaRequest([
			'type' => $type,
		]);
		$response = new WikiaResponse(WikiaResponse::FORMAT_HTML);

		$api->setRequest($request);
		$api->setResponse($response);

		$api->getRecCode();

		return $api->getResponse();
	}
}
