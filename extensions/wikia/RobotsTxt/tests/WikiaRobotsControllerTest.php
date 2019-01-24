<?php

class WikiaRobotsControllerTest extends WikiaBaseTest {

	private $localCityId = 321;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WikiaRobotsController.class.php';
		$this->mockGlobalVariable( 'wgCityId', $this->localCityId );
	}

	private function getLocalWikiData() {
		return [
			'city_id' => $this->localCityId,
			'city_dbname' => 'a'
		];
	}

	private function getController() {
		$request = new WikiaRequest( [] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );
		$wikiaRobotsController = $this->createPartialMock( 'WikiaRobotsController', [ 'getLocalRules' ] );
		$wikiaRobotsController->setRequest( $request );
		$wikiaRobotsController->setResponse( $response );
		return $wikiaRobotsController;
	}

	public function testUsesLocalCallForCurrentWiki() {
		$wikiaRobotsController = $this->getController();

		$this->mockStaticMethod('WikiFactory', 'getWikisUnderDomain',
			[ $this->getLocalWikiData() ]
		);

		$wikiaRobotsController->expects( $this->once() )->method( 'getLocalRules' )->will(
			$this->returnValue( [ 'allowed' => ['a1'], 'disallowed' => ['d1'], 'sitemaps' => ['s1']]
			) );

		$wikiaRobotsController->getRulesForDomain();

		$this->assertFalse( $wikiaRobotsController->getResponse()->getVal( 'Degraded') );
		$this->assertEquals( [ 'a1' ], $wikiaRobotsController->getResponse()->getVal( 'Allow' ),
			'Allow rules mismatch' );
		$this->assertEquals( [ 'd1' ], $wikiaRobotsController->getResponse()->getVal( 'Noindex' ),
			'Noindex rules mismatch' );
		$this->assertEquals( [ 'd1' ], $wikiaRobotsController->getResponse()->getVal( 'Disallow' ),
			'Disallow rules mismatch' );
		$this->assertEquals( [ 's1' ], $wikiaRobotsController->getResponse()->getVal( 'Sitemap' ),
			'Sitemap entries mismatch' );
	}

	public function testMergesLanguageWikisRules() {
		$wikiaRobotsController = $this->getController();

		$this->mockStaticMethod('WikiFactory', 'getWikisUnderDomain',
			[ $this->getLocalWikiData(), [ 'city_id' => 2, 'city_dbname' => 'b' ] ]
		);

		$wikiaRobotsController->expects( $this->once() )->method( 'getLocalRules' )->will(
			$this->returnValue( [ 'allowed' => ['a1'], 'disallowed' => ['d1'], 'sitemaps' => ['s1'] ]
			) );

		$this->mockStaticMethod( 'ApiService', 'foreignCall',
			[ 'allowed' => ['a2'], 'disallowed' => ['d2'], 'sitemaps' => ['s2'] ] );

		$wikiaRobotsController->getRulesForDomain();

		$this->assertFalse( $wikiaRobotsController->getResponse()->getVal( 'Degraded') );
		$this->assertEquals( [ 'a1', 'a2' ], $wikiaRobotsController->getResponse()->getVal( 'Allow'),
			'Allow rules mismatch' );
		$this->assertEquals( [ 'd1', 'd2' ], $wikiaRobotsController->getResponse()
			->getVal( 'Noindex' ), 'Noindex rules mismatch' );
		$this->assertEquals( [ 'd1', 'd2' ], $wikiaRobotsController->getResponse()
			->getVal( 'Disallow' ), 'Disallow rules mismatch' );
		$this->assertEquals( [ 's1', 's2' ], $wikiaRobotsController->getResponse()
			->getVal( 'Sitemap' ), 'Sitemap entries mismatch' );
	}

	public function testDegradedFlagOnFailedForeignCall() {
		$wikiaRobotsController = $this->getController();

		$this->mockStaticMethod('WikiFactory', 'getWikisUnderDomain',
			[ $this->getLocalWikiData(), [ 'city_id' => 2, 'city_dbname' => 'b' ] ]
		);

		$wikiaRobotsController->expects( $this->once() )->method( 'getLocalRules' )->will(
			$this->returnValue( [ 'allowed' => ['a1'], 'disallowed' => ['d1'], 'sitemaps' => ['s1'] ]
			) );

		$this->mockStaticMethod( 'ApiService', 'foreignCall', null );

		$wikiaRobotsController->getRulesForDomain();

		$this->assertTrue( $wikiaRobotsController->getResponse()->getVal( 'Degraded') );
		$this->assertEquals( [ 'a1' ], $wikiaRobotsController->getResponse()->getVal( 'Allow'),
			'Allow rules mismatch' );
		$this->assertEquals( [ 'd1' ], $wikiaRobotsController->getResponse()
			->getVal( 'Noindex' ), 'Noindex rules mismatch' );
		$this->assertEquals( [ 'd1' ], $wikiaRobotsController->getResponse()
			->getVal( 'Disallow' ), 'Disallow rules mismatch' );
		$this->assertEquals( [ 's1' ], $wikiaRobotsController->getResponse()
			->getVal( 'Sitemap' ), 'Sitemap entries mismatch' );
	}
}
