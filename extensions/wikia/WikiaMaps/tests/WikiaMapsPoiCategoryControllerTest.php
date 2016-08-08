<?php
class WikiaMapsPoiCategoryControllerTest extends WikiaBaseTest {

	const DEFAULT_PARENT_POI_CATEGORY = 1;
	const USER_TYPE_LOGGED_IN = 'logged-in';
	const USER_TYPE_LOGGED_OUT = 'logged-out';
	const USER_TYPE_BLOCKED = 'blocked';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	/**
	 * Tests cleanUpPoiCategoryData method
	 *
	 * @dataProvider cleanUpPoiCategoryDataDataProvider
	 * @param $message
	 * @param $params
	 * @param $expected
	 */
	public function testCleanUpPoiCategoryData( $message, $params, $expected ) {
		$mapModelMock = $this->getMock( 'WikiaMaps', [ 'getDefaultParentPoiCategory' ], [], '', false );

		$mapModelMock->expects( $this->any() )
			->method( 'getDefaultParentPoiCategory' )
			->will( $this->returnValue( self::DEFAULT_PARENT_POI_CATEGORY ) );

		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();
		$poiCategoryControllerMock->mapsModel = $mapModelMock;

		$this->assertEquals(
			$expected,
			$poiCategoryControllerMock->cleanUpPoiCategoryData( $params ),
			$message
		);
	}

	/**
	 * Provides dataset for testCleanUpPoiCategoryData
	 *
	 * @return array
	 */
	public function cleanUpPoiCategoryDataDataProvider() {
		return [
			[
				'Id converted to integer',
				[
					'id' => '1'
				],
				[
					'id' => 1,
					'parent_poi_category_id' => self::DEFAULT_PARENT_POI_CATEGORY
				]
			],
			[
				'Empty id removed',
				[
					'id' => ''
				],
				[
					'parent_poi_category_id' => self::DEFAULT_PARENT_POI_CATEGORY
				]
			],
			[
				'Name trimmed',
				[
					'name' => 'name with a space '
				],
				[
					'name' => 'name with a space',
					'parent_poi_category_id' => self::DEFAULT_PARENT_POI_CATEGORY
				]
			],
			[
				'Parent POI category id converted to integer',
				[
					'parent_poi_category_id' => '3'
				],
				[
					'parent_poi_category_id' => 3
				]
			],
			[
				'Empty marker removed',
				[
					'marker' => ''
				],
				[
					'parent_poi_category_id' => self::DEFAULT_PARENT_POI_CATEGORY
				]
			]
		];
	}

	public function testValidatePoiCategoriesData_user_not_logged_in() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();
		$poiCategoryControllerMock->wg->User = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$this->setExpectedException( 'WikiaMapsPermissionException' );

		$poiCategoryControllerMock->validatePoiCategoriesData();
	}

	public function testValidatePoiCategoriesData_user_blocked() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();
		$poiCategoryControllerMock->wg->User = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$this->setExpectedException( 'WikiaMapsPermissionException' );

		$poiCategoryControllerMock->validatePoiCategoriesData();
	}

	/**
	 * Tests if validatePoiCategoriesData method throws InvalidParameterApiException when mapId is invalid
	 */
	public function testValidatePoiCategoriesData_invalid_mapId() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'mapId', false, 'invalidOne' ]
		] );
		$poiCategoryControllerMock->wg->User = $this->getUserMock( self::USER_TYPE_LOGGED_IN );

		$this->setExpectedException( 'InvalidParameterApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategoriesData();
	}

	/**
	 * Tests if validatePoiCategoriesData method throws InvalidParameterApiException when validatePoiCategoriesToDelete returns false
	 */
	public function testValidatePoiCategoriesData_invalid_poiCategoriesToCreate() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'mapId', false, 1 ] //valid mapId
		], [ 'validatePoiCategories' ] );
		$poiCategoryControllerMock->wg->User = $this->getUserMock( self::USER_TYPE_LOGGED_IN );

		$poiCategoryControllerMock->expects( $this->once() )
			->method( 'validatePoiCategories' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( 'InvalidParameterApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategoriesData();
	}

	/**
	 * Tests if validatePoiCategories method throws InvalidParameterApiException when validatePoiCategoriesToDelete returns false
	 */
	public function testValidatePoiCategoriesData_invalid_poiCategoriesToDelete() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'mapId', false, 1 ] //valid mapId
		], [ 'validatePoiCategoriesToDelete' ] );
		$poiCategoryControllerMock->wg->User = $this->getUserMock( self::USER_TYPE_LOGGED_IN );

		$poiCategoryControllerMock->expects( $this->once() )
			->method( 'validatePoiCategoriesToDelete' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( 'InvalidParameterApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategoriesData();
	}

	/**
	 * Tests validatePoiCategories method
	 *
	 * @dataProvider validatePoiCategoriesDataProvider
	 * @param $message
	 * @param $params
	 * @param $expected
	 */
	public function testValidatePoiCategories( $message, $params, $expected ) {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();

		$this->assertEquals(
			$expected,
			$poiCategoryControllerMock->validatePoiCategories( $params ),
			$message
		);
	}

	/**
	 * Provides dataset for testValidatePoiCategories
	 *
	 * @return array
	 */
	public function validatePoiCategoriesDataProvider() {
		return [
			[
				'valid POI category',
				[
					[
						'name' => 'Some POI category'
					]
				],
				true
			],
			[
				'empty POI category name',
				[
					[
						'name' => ''
					]
				],
				false
			]
		];
	}

	/**
	 * Tests validatePoiCategoriesToDelete method
	 *
	 * @dataProvider validatePoiCategoriesToDeleteDataProvider
	 * @param $message
	 * @param $params
	 * @param $expected
	 */
	public function testValidatePoiCategoriesToDelete( $message, $params, $expected ) {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'poiCategoriesToDelete', false, $params ]
		] );

		$this->assertEquals(
			$expected,
			$poiCategoryControllerMock->validatePoiCategoriesToDelete(),
			$message
		);
	}

	/**
	 * Provides dataset for testValidatePoiCategoriesToDelete
	 *
	 * @return array
	 */
	public function validatePoiCategoriesToDeleteDataProvider() {
		return [
			[
				'poiCategoriesToDelete is empty array',
				[],
				true
			],
			[
				'poiCategoriesToDelete is null',
				null,
				true
			],
			[
				'poiCategoriesToDelete is valid array',
				[ 1, 2, 3 ],
				true
			],
			[
				'poiCategoriesToDelete is invalid array',
				[ -1, 'string' ],
				false
			],
		];
	}

	/**
	 * Prepares and returns mock for WikiaMapsPoiCategoryController
	 *
	 * @param array $params - parameters that getData method should return
	 * @see http://phpunit.de/manual/3.7/en/test-doubles.html#test-doubles.stubs.examples.StubTest5.php
	 * @see http://stackoverflow.com/a/15300642/1050577
	 *
	 * @param array $additionalMethodsToMock - array of names of methods to mock
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaMapsPoiCategoryController
	 */
	private function getPoiCategoryControllerMock( $params = [], $additionalMethodsToMock = [] ) {
		$poiCategoryControllerMock = $this->getMock(
			'WikiaMapsPoiCategoryController',
			array_merge( [ 'getData' ], $additionalMethodsToMock ),
			[], '', false
		);

		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getArray', 'getInt' ] )
			->disableOriginalConstructor()
			->getMock();
		$poiCategoryControllerMock->request = $requestMock;

		$poiCategoryControllerMock->wg->User = $this->getUserMock();

		$poiCategoryControllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->returnValueMap( $params ) );

		return $poiCategoryControllerMock;
	}

	private function getUserMock( $type = 'default' ) {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getName', 'isLoggedIn', 'isBlocked' ] )
			->disableOriginalConstructor()
			->getMock();

		switch( $type ) {
			case self::USER_TYPE_LOGGED_OUT:
				$userMock->expects( $this->once() )
					->method( 'isLoggedIn' )
					->willReturn( false );
				break;
			/** @noinspection PhpMissingBreakStatementInspection */
			case self::USER_TYPE_BLOCKED:
				$userMock->expects( $this->once() )
					->method( 'isBlocked' )
					->willReturn( true );
			// no break for purpose - if user is blocked he's logged-in as well
			case self::USER_TYPE_LOGGED_IN:
				$userMock->expects( $this->once() )
					->method( 'isLoggedIn' )
					->willReturn( true );
				break;
		}

		return $userMock;
	}
}
