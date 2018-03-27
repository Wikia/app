<?php

class LyricFindControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();

		// mock title and prevent DB changes
		$titleMock = $this->createConfiguredMock( Title::class, [
			'getArticleID' => 123,
		] );

		$this->mockGlobalVariable('wgTitle', $titleMock );
		$this->mockStaticMethod(LyricFindTrackingService::class, 'isWebCrawler', false);
	}

	/**
	 * @dataProvider trackDataProvider
	 * @param $amgId
	 * @param $trackResult
	 * @param $responseCode
	 */
	public function testTrack($amgId, $trackResult, $responseCode) {
		$controller = new LyricFindController();

		$controller->setRequest(new WikiaRequest(['amgid' => $amgId]));
		$controller->setResponse(new WikiaResponse('json'));

		$this->mockClassWithMethods('LyricFindTrackingService', ['track' => $trackResult ? Status::newGood() : Status::newFatal('foo')]);

		$controller->track();
		$this->assertEquals($responseCode, $controller->getResponse()->getCode(), 'HTTP response code should match the expected value');
	}

	public function trackDataProvider() {
		return [
			[
				'amgId' => 1,
				'trackResult' => true,
				'responseCode' => 200
			],
			[
				'amgId' => 1,
				'trackResult' => false,
				'responseCode' => 404
			],
			// should be ok, despite missing amg ID
			[
				'amgId' => 0,
				'trackResult' => true,
				'responseCode' => 200
			],
		];
	}
}
