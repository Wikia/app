<?php

class LyricFindControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();
	}

	/**
	 *
	 * @dataProvider trackDataProvider
	 * @param $amgId
	 * @param $trackResult
	 * @param $responseCode
	 */
	public function testTrack($amgId, $trackResult, $responseCode) {
		$controller = new LyricFindController();

		$controller->setRequest(new WikiaRequest(['amgid' => $amgId]));
		$controller->setResponse(new WikiaResponse('json'));

		$this->mockClassWithMethods('LyricFindTrackingService', ['track' => $trackResult]);

		$controller->track();
		$this->assertEquals($responseCode, $controller->getResponse()->getCode(), 'HTTP response code should match the expected value');
	}

	public function trackDataProvider() {
		return [
			[
				'amgId' => 1,
				'trackResult' => true,
				'responseCode' => 204
			],
			[
				'amgId' => 1,
				'trackResult' => false,
				'responseCode' => 404
			],
			[
				'amgId' => 0,
				'trackResult' => true,
				'responseCode' => 404
			],
		];
	}
}
