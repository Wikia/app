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

		$items = $response->getVal( 'items' );

		$this->assertInternalType( 'object', $items );

		$actualDetailsCount = count( (array) $items );
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

	/**
	 * Test the WikisApiController::getWikisUnderDomain method
	 *
	 * @param $domain domain parameter passed in the request
	 * @param $localize "localizeUrls" param passed in the request
	 * @param $env environment to mock
	 * @param $wfMocks WikiFactory method names mapped to return values
	 * @param $extectedResponseValues response field names mapped to expected values
	 * @param $exception Expected failure (if any)
	 *
	 * @dataProvider provideGetWikisUnderDomain
	 */
	public function testGetWikisUnderDomain( $domain, $localize, $env, $wfMocks,
											 $extectedResponseValues, $exception = null ) {
		$this->mockEnvironment( $env );
		$request = new WikiaRequest( [ 'domain' => $domain, 'localizeUrls' => $localize ] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );
		$wikisApiController = new WikisApiController();
		$wikisApiController->setRequest( $request );
		$wikisApiController->setResponse( $response );

		foreach( $wfMocks as $method=>$result ) {
			$this->mockStaticMethod( 'WikiFactory', $method, $result );
		}
		if ( $exception ) {
			$this->expectException( $exception );
			$wikisApiController->getWikisUnderDomain();
		} else {
			$wikisApiController->getWikisUnderDomain();
			foreach( $extectedResponseValues as $name=>$expectedValue ) {
				//print_r($response->getVal( $name ));
				$this->assertEquals( $expectedValue, $response->getVal( $name ), $name . ' response field mismatch' );
			}
		}
	}

	/**
	 * Test cases for WikisApiController::getWikisUnderDomain
	 * @return Generator
	 */
	public function provideGetWikisUnderDomain() {
		// --------- Test case ------------
		// 1. Make sure api works for a single wiki accessed through the primary wikia domain
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'http://test.wikia.com/',
				'city_dbname' => 'test'
			]
		];
		yield [
			'test.wikia.com',	// request domain parameter
			false,				// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://test.wikia.com/',
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'wikis' => $wikis
			]
		];
		// --------- Test case ------------
		// 2. Also a simple test case, but for a fandom.com domain (so the url should be a https)
		yield [
			'test.fandom.com',	// request domain parameter
			true,				// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://test.fandom.com/',
				'isPublic' => true,
				'getWikisUnderDomain' => [
					[
						'city_id' => 123,
						'city_url' => 'http://test.fandom.com/',
						'city_dbname' => 'test'
					]
				],
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => false,
				'isPublic' => true,
				'wikis' => [
					[
						'city_id' => 123,
						'city_url' => 'https://test.fandom.com/',	// expect HTTPS here!
						'city_dbname' => 'test'
					]
				]
			]
		];
		// --------- Test case ------------
		// 3. Use secondary fandom domain, expect a redirect to primary domain over https
		yield [
			'secondary.fandom.com',	// request domain parameter
			false,					// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://primary.fandom.com/',
				'isPublic' => true,
				'getWikisUnderDomain' => [
					[
						'city_id' => 123,
						'city_url' => 'http://primary.fandom.com/',
						'city_dbname' => 'test'
					]
				],
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => 'primary.fandom.com',
				'primaryProtocol' => 'https://',
				'isBlocked' => false,
				'wikis' => []
			]
		];
		// --------- Test case ------------
		// 4. Use secondary fandom domain, expect a localized redirect to primary domain over https
		yield [
			'secondary.fandom.com',	// request domain parameter
			true,					// localizeUrls param
			WIKIA_ENV_PREVIEW,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'getWikiByID' => (object) [
					'city_id' => 123,
					'city_public' => 1,
					'city_url' => 'http://primary.fandom.com/',

				],
				'getWikisUnderDomain' => [
					[
						'city_id' => 123,
						'city_url' => 'http://primary.fandom.com/',
						'city_dbname' => 'test'
					]
				],
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => 'primary.preview.fandom.com',
				'primaryProtocol' => 'https://',
				'isBlocked' => false,
				'wikis' => []
			]
		];
		// --------- Test case ------------
		// 5. Use secondary wikia domain, expect a redirect to primary domain over http
		yield [
			'secondary.wikia.com',	// request domain parameter
			true,					// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://primary.wikia.com/',
				'isPublic' => true,
				'getWikisUnderDomain' => [
					[
						'city_id' => 123,
						'city_url' => 'http://primary.wikia.com/',
						'city_dbname' => 'test'
					]
				],
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => 'primary.wikia.com',
				'primaryProtocol' => 'http://',
				'isBlocked' => false,
				'wikis' => []
			]
		];
		// --------- Test case ------------
		// 6. Check blocked robots flag
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'http://blocked.wikia.com/',
				'city_dbname' => 'test'
			]
		];
		yield [
			'blocked.wikia.com',	// request domain parameter
			false,					// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://blocked.wikia.com/',
				'isPublic' => true,
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => true
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => true,
				'isPublic' => true,
				'wikis' => $wikis
			]
		];
		// --------- Test case ------------
		// 7. Check public flag flag
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'http://closed.wikia.com/',
				'city_dbname' => 'test'
			]
		];
		yield [
			'closed.wikia.com',	// request domain parameter
			false,				// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => 123,
				'isLanguageWikisIndex' => false,
				'cityIDtoDomain' => 'http://closed.wikia.com/',
				'isPublic' => false,
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => false,
				'isPublic' => false,
				'wikis' => $wikis
			]
		];
		// --------- Test case ------------
		// 8. Empty domain root with language wikis underneath
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'http://empty.wikia.com/de/',
				'city_dbname' => 'test'
			]
		];
		$localizedWikis = [
			[
				'city_id' => 123,
				'city_url' => 'http://empty.preview.wikia.com/de/',
				'city_dbname' => 'test'
			]
		];
		yield [
			'emptyroot.wikia.com',	// request domain parameter
			true,					// localizeUrls param
			WIKIA_ENV_PREVIEW,
			// WF mocks...
			[
				'DomainToID' => null,
				'isLanguageWikisIndex' => true,
				'isPublic' => true,
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => false,
				'isPublic' => false,
				'wikis' => $localizedWikis
			]
		];
		// --------- Test case ------------
		// 9. Corrupted domain parameter
		yield [
			'wiki.fake.hacked',
			false,				// localizeUrls param
			WIKIA_ENV_PROD,
			[],
			[],
			NotFoundApiException::class	// expected exception
		];
		// --------- Test case ------------
		// 10. Unknown domain
		yield [
			'empty.fandom.com',	// request domain parameter
			false,					// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => null,
				'isLanguageWikisIndex' => false,
				'isPublic' => true,
				'getWikisUnderDomain' => [],
				'getVarValueByName' => false
			],
			[],
			NotFoundApiException::class	// expected exception
		];
		// --------- Test case ------------
		// 11. Wiki with city_public set to -1 (marked for closing)
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'https://markedforclosing.fandom.com/',
				'city_dbname' => 'markedforclosing'
			]
		];
		yield [
			'markedforclosing.fandom.com',	// request domain parameter
			false,							// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => null,
				'isLanguageWikisIndex' => false,
				'getWikiByID' => (object) [
					'city_id' => 123,
					'city_public' => -1
				],
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => false,
				'isPublic' => false,
				'wikis' => $wikis
			]
		];
		// --------- Test case ------------
		// 12. wiki with city_public set to -2 (marked as spam)
		$wikis = [
			[
				'city_id' => 123,
				'city_url' => 'https://spam.fandom.com/',
				'city_dbname' => 'spam'
			]
		];
		yield [
			'spam.fandom.com',	// request domain parameter
			false,				// localizeUrls param
			WIKIA_ENV_PROD,
			// WF mocks...
			[
				'DomainToID' => null,
				'isLanguageWikisIndex' => false,
				'getWikiByID' => (object) [
					'city_id' => 123,
					'city_public' => -2
				],
				'getWikisUnderDomain' => $wikis,
				'getVarValueByName' => false
			],
			// expected response
			[
				'primaryDomain' => '',
				'primaryProtocol' => '',
				'isBlocked' => false,
				'isPublic' => false,
				'wikis' => $wikis
			]
		];

	}
}
