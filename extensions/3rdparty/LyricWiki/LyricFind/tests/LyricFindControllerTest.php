<?php

class LyricFindControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();
		$this->mockApp();
	}

	/**
	 *
	 * @dataProvider trackDataProvider
	 * @param $pageId
	 * @param $trackResult
	 * @param $responseCode
	 */
	public function testTrack($pageId, $trackResult, $responseCode) {
		$controller = new LyricFindController();

		$controller->setRequest(new WikiaRequest(['pageid' => $pageId]));
		$controller->setResponse(new WikiaResponse('json'));

		$this->mockClassWithMethods('LyricFindTrackingService', ['track' => $trackResult]);

		$controller->track();
		$this->assertEquals($responseCode, $controller->getResponse()->getCode(), 'HTTP response code should match the expected value');
	}

	public function trackDataProvider() {
		return [
			[
				'pageId' => 1,
				'trackResult' => true,
				'responseCode' => 204
			],
			[
				'pageId' => 1,
				'trackResult' => false,
				'responseCode' => 400
			],
			[
				'pageId' => 0,
				'trackResult' => true,
				'responseCode' => 400
			],
		];
	}
}
