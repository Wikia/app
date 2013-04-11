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
	 * @param $pageId
	 * @param $trackId
	 * @param $res
	 */
	public function testTrackResponseCode($pageId, $trackId, $apiResponse, $res) {
		// mock API response
		$respMock = json_encode([
			'response' => [
				'code' => $apiResponse
			]
		]);

		$this->mockClassStaticMethod('Http', 'post', $respMock);

		// mock database
		$this->mockGlobalFunction('GetDB', $this->mockClassWithMethods('DatabaseMysql', ['selectField' => $trackId]));
		$this->mockApp();

		$service = new LyricFindTrackingService();
		$this->assertEquals($res, $service->track($pageId), 'API response code should match expected value');
	}

	public function trackResponseCodeProvider() {
		return [
			[
				'pageId' => 123,
				'trackId' => 45812,
				'apiResponse' => 101,
				'res' => true
			],
			// can't map given article to lyric ID
			[
				'pageId' => 1234,
				'trackId' => false,
				'apiResponse' => 101,
				'res' => false
			],
			// API key was incorrect
			[
				'pageId' => 1234,
				'trackId' => 45812,
				'apiResponse' => 200,
				'res' => false
			]
		];
	}
}
