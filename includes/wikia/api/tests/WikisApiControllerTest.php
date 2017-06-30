<?php

class WikisApiControllerTest extends WikiaBaseTest {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WikisApiController.class.php';
	}

	/**
	 * @expectedException MissingParameterApiException
	 * @expectedExceptionMessage Bad request
	 * @expectedExceptionCode 400
	 */
	public function testGetDetailsMethodFailsWithoutIds() {
		$request = new WikiaRequest( [] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );
		$wikisApiController = new WikisApiController();

		$wikisApiController->setRequest( $request );
		$wikisApiController->setResponse( $response );
		$wikisApiController->getDetails();
	}

	/**
	 * SUS-2012: Verify that WikisApiController getDetails endpoint returns a limited number of
	 * results.
	 * @see WikisApiController::getDetails()
	 * @see WikisApiController::MAX_WIKIS
	 *
	 * @dataProvider provideWikiIds
	 *
	 * @param $requestedIds
	 */
	public function testGetDetailsMethodRespectsLimits( $requestedIds ) {
		$serviceMock = $this->getMockBuilder( WikiDetailsService::class )
			->setMethods( [ 'getWikiDetails' ] )
			->getMock();

		$serviceMock->expects( $this->atMost( WikisApiController::MAX_WIKIS ) )
			->method( 'getWikiDetails' )
			->willReturn( new stdClass() );

		$request = new WikiaRequest( [
			WikisApiController::PARAMETER_WIKI_IDS => $requestedIds
		] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );

		$wikisApiController = new WikisApiController();

		$serviceProperty = new ReflectionProperty( WikisApiController::class, 'wikiDetails' );
		$serviceProperty->setAccessible( true );
		$serviceProperty->setValue( $wikisApiController, $serviceMock );

		$wikisApiController->setRequest( $request );
		$wikisApiController->setResponse( $response );
		$wikisApiController->getDetails();

		$actualDetailsCount = count( $response->getVal( 'items' ) );
		$this->assertLessThanOrEqual( WikisApiController::MAX_WIKIS, $actualDetailsCount );
	}

	/**
	 * @expectedException MissingParameterApiException
	 * @expectedExceptionMessage Bad request
	 * @expectedExceptionCode 400
	 */
	public function testGetWikiDataMethodFailsWithoutIds() {
		$request = new WikiaRequest( [] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );
		$wikisApiController = new WikisApiController();

		$wikisApiController->setRequest( $request );
		$wikisApiController->setResponse( $response );
		$wikisApiController->getWikiData();
	}

	/**
	 * SUS-2012: Verify that WikisApiController getWikiData endpoint returns a limited number of
	 * results.
	 * @see WikisApiController::getWikiData()
	 * @see WikisApiController::MAX_WIKIS
	 * @dataProvider provideWikiIds
	 *
	 * @param $requestedIds
	 */
	public function testGetWikiDataMethodRespectsLimits( $requestedIds ) {
		$cacheMock = $this->getMockBuilder( HashBagOStuff::class )
			->setMethods( [ 'get' ] )
			->getMock();

		$cacheMock->expects( $this->atMost( WikisApiController::MAX_WIKIS ) )
			->method( 'get' )
			->willReturn( [] );

		$this->mockGlobalVariable( 'wgMemc', $cacheMock );

		$serviceMock = $this->getMockBuilder( WikiService::class )
			->setMethods( [ 'getWikiDescription' ] )
			->getMock();

		$serviceMock->expects( $this->atMost( WikisApiController::MAX_WIKIS ) )
			->method( 'getWikiDescription' )
			->willReturn( [] );

		$request = new WikiaRequest( [
			WikisApiController::PARAMETER_WIKI_IDS => $requestedIds
		] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );

		$wikisApiController = new WikisApiController();

		$serviceProperty = new ReflectionProperty( WikisApiController::class, 'service' );
		$serviceProperty->setAccessible( true );
		$serviceProperty->setValue( $wikisApiController, $serviceMock );

		$wikisApiController->setRequest( $request );
		$wikisApiController->setResponse( $response );
		$wikisApiController->getWikiData();

		$actualDetailsCount = count( $response->getVal( 'items' ) );
		$this->assertLessThanOrEqual( WikisApiController::MAX_WIKIS, $actualDetailsCount );
	}

	public function provideWikiIds() {
		$data = [];
		$idCounts = [ 1, 10, 100, 300 ];

		foreach ( $idCounts as $count ) {
			$paramValue = '';

			for ( $i = 1; $i <= $count; $i++ ) {
				$paramValue .= "$i,";
			}

			$data["$count requested wiki IDs"] = [ $paramValue ];
		}

		return $data;
	}
}
