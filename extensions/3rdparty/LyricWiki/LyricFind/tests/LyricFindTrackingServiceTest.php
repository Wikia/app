<?php

/**
 * @group LyricFindTracking
 */
class LyricFindTrackingServiceTest extends WikiaBaseTest {

	const SERVICE_URL = 'http://api.foo.net/service/';
	const API_KEY = '123456';

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();

		// mock API settings
		$this->mockGlobalVariable('wgLyricFindApiUrl', self::SERVICE_URL);
		$this->mockGlobalVariable('wgLyricFindApiKeys', ['display' => self::API_KEY]);

		// prevent DB changes
		$this->mockGlobalFunction('wfSetWikiaPageProp', null);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05467 ms
	 * @dataProvider formatTrackIdProvider
	 * @param $amgId
	 * @param $gracenoteId
	 * @param $title
	 * @param $expected
	 */
	public function testFormatTrackId($amgId, $gracenoteId, $title, $expected) {
		$service = new LyricFindTrackingService();

		$method = new ReflectionMethod('LyricFindTrackingService', 'formatTrackId');
		$method->setAccessible(true);

		$trackId = $method->invoke($service, [
			'amg' => $amgId,
			'gracenote' => $gracenoteId,
			'title' => $title
		]);

		$this->assertEquals($expected, $trackId, 'Track ID should match expected value');
	}

	public function formatTrackIdProvider() {
		return [
			[
				'amgId' => 0,
				'gracenoteId' => 0,
				'title' => 'Paradise_Lost:Forever_Failure',
				'expected' => 'trackname:forever_failure,artistname:paradise_lost'
			],
			// strip commas
			[
				'amgId' => 0,
				'gracenoteId' => 0,
				'title' => 'Paradise_Lost:Forever_Failure,123',
				'expected' => 'trackname:forever_failure 123,artistname:paradise_lost'
			],
			// use the first semicolon to separate artist and track name
			[
				'amgId' => 0,
				'gracenoteId' => 0,
				'title' => 'Paradise_Lost:Forever_Failure:foo:bar',
				'expected' => 'trackname:forever_failure foo bar,artistname:paradise_lost'
			],
			// pass additional IDs
			[
				'amgId' => 123,
				'gracenoteId' => 0,
				'title' => 'Paradise_Lost:Forever_Failure',
				'expected' => 'amg:123,trackname:forever_failure,artistname:paradise_lost'
			],
			[
				'amgId' => 123,
				'gracenoteId' => 456,
				'title' => 'Paradise_Lost:Forever_Failure',
				'expected' => 'amg:123,gnlyricid:456,trackname:forever_failure,artistname:paradise_lost'
			],
			// UTF should not be encoded
			[
				'amgId' => 0,
				'gracenoteId' => 0,
				'title' => 'Sólstafir:Þín Orð',
				'expected' => 'trackname:þín orð,artistname:sólstafir'
			],
		];
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.11328 ms
	 * @dataProvider trackResponseCodeProvider
	 * @param $amgId
	 * @param $trackId
	 * @param $res
	 */
	public function testTrackResponseCode($amgId, $apiResponse, $res) {
		// mock API response
		$respMock = is_array($apiResponse) ? json_encode($apiResponse) : $apiResponse;

		$this->mockStaticMethod('Http', 'request', $respMock);
		$this->mockGlobalVariable('wgTitle', $this->mockClassWithMethods('Title', [
			'getArticleID' => 666,
			'getText' => 'Paradise_Lost:Forever_Failure'
		]));

		$service = new LyricFindTrackingService();
		$status = $service->track($amgId, 0, $this->app->wg->Title);

		$this->assertEquals($res, $status->isOK(), 'API response code should match expected value');
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
			// API request failed
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
			],
			// mark lyric for removal
			[
				'amgId' => 1234,
				'apiResponse' => [
					'response' => [
						'code' => 206
					]
				],
				'res' => true
			],
		];
	}
}
