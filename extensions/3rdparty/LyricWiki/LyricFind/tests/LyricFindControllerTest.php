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

		// mock request and controller's response
		$controller->setRequest(new WikiaRequest(array(
			'pageid' => $pageId
		)));

		$response = new WikiaResponse('json');
		$controller->setResponse($response);

		$this->mockClassWithMethods('LyricFindTrackingService', array(
			'track' => $trackResult
		));

		$controller->track();
		$this->assertEquals($responseCode, $controller->getResponse()->getCode(), 'HTTP response code should match the expected value');
	}

	public function trackDataProvider() {
		return array(
			array(
				'pageId' => 1,
				'trackResult' => true,
				'responseCode' => 204
			),
			array(
				'pageId' => 1,
				'trackResult' => false,
				'responseCode' => 400
			),
			array(
				'pageId' => 0,
				'trackResult' => true,
				'responseCode' => 400
			),
		);
	}
}
