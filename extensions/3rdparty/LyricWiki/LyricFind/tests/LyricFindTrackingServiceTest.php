<?php

class LyricFindTrackingServiceTest extends WikiaBaseTest {

	const SERVICE_URL = 'http://api.foo.net/service/';
	const API_KEY = '123456';

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();

		// mock API settings
		$this->mockGlobalVariable('wgLyricFindApiUrl', self::SERVICE_URL);
		$this->mockGlobalVariable('wgLyricFindApiKeys', ['display' => self::API_KEY]);
	}

	/**
	 * @dataProvider trackResponseCodeProvider
	 * @param $amgId
	 * @param $trackId
	 * @param $res
	 */
	public function testTrackResponseCode($amgId, $apiResponse, $res) {
		// mock API response
		$respMock = is_array($apiResponse) ? json_encode($apiResponse) : $apiResponse;

		$this->mockStaticMethod('Http', 'post', $respMock);

		$service = new LyricFindTrackingService();
		$this->assertEquals($res, $service->track($amgId), 'API response code should match expected value');
	}

	public function trackResponseCodeProvider() {
		return [
			[
				'amgId' => 123,
				'apiResponse' => [
					'response' => [
						'code' => 101
					]
				],
				'res' => true
			],
			// API key was incorrect
			[
				'amgId' => 1234,
				'apiResponse' => [
					'response' => [
						'code' => 200
					]
				],
				'res' => false
			],
			// API request fauled
			[
				'amgId' => 1234,
				'apiResponse' => false,
				'res' => false
			],
			// malformed API request
			[
				'amgId' => 1234,
				'apiResponse' => ['foo' => 'bar'],
				'res' => false
			]
		];
	}
}
