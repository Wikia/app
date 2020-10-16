<?php

class DesignSystemApiControllerTest extends WikiaBaseTest {
	/**
	 * Test IntentX API
	 */
	public function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../DesignSystemApiController.class.php';
	}

	public function testGetValidRepsonse() {
		$validCityId = 147;

		$client = new GuzzleHttp\Client([
			'base_uri' => 'https://community.fandom.com/wikia.php'
		]);

		$params = [
			'controller' => 'DesignSystemApi',
			'method' => 'getFandomShopDataFromIntentX',
			'id' => $validCityId
		];
		$response = $client->get('', [
			'query' => GuzzleHttp\Psr7\build_query($params, PHP_QUERY_RFC1738),
			'headers' => [
				'X-Wikia-Internal-Request' => '1',
			]
		]);

		$body = $response->getBody();
		$data = json_decode($body);

		// check for successful response
		$this->assertEquals(200, $response->getStatusCode());

		// check for proper content type
		$contentType = $response->getHeaders()["Content-Type"][0];
		$this->assertEquals("application/json; charset=utf-8", $contentType);

		// check for links
		$this->assertGreaterThan(0, count($data));

		// check links have valid properties
		foreach ($data as $link) {
			$this->assertObjectHasAttribute('text', $link);
			$this->assertObjectHasAttribute('url', $link);
		}
	}

	public function testReturnsEmptyForInvalidCommunity() {
		$invalidCityId = 999;

		$client = new GuzzleHttp\Client([
			'base_uri' => 'https://community.fandom.com/wikia.php'
		]);

		$params = [
			'controller' => 'DesignSystemApi',
			'method' => 'getFandomShopDataFromIntentX',
			'id' => $invalidCityId
		];

		$response = $client->get('', [
			'query' => GuzzleHttp\Psr7\build_query($params, PHP_QUERY_RFC1738),
		]);

		$body = $response->getBody();
		$data = json_decode($body);

		// test for empty result
		$this->assertEquals($data, []);
	}
}
