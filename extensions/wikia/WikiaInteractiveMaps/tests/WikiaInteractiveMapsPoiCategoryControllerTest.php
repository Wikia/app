<?php
class WikiaInteractiveMapsPoiCategoryControllerTest extends WikiaBaseTest {
	const DEFAULT_PARENT_POI_CATEGORY = 1;

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
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

	/**
	 * Tests if validatePoiCategories method throws PermissionsException when user is not logged in
	 */
	public function testValidatePoiCategories_user_not_logged_in() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();
		$poiCategoryControllerMock->wg->User = $this->getUserMock( false );

		$this->setExpectedException( 'PermissionsException', 'No Permissions' );

		$poiCategoryControllerMock->validatePoiCategories();
	}

	/**
	 * Tests if validatePoiCategories method throws InvalidParameterApiException when mapId is invalid
	 */
	public function testValidatePoiCategories_invalid_mapId() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'mapId', false, 'invalidOne' ]
		] );

		$this->setExpectedException( 'InvalidParameterApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategories();
	}

	/**
	 * Tests if validatePoiCategories method throws InvalidParameterApiException when validatePoiCategoriesToDelete returns false
	 */
	public function testValidatePoiCategories_invalid_poiCategoriesToDelete() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock( [
			[ 'mapId', false, 1 ] //valid mapId
		], [ 'validatePoiCategoriesToDelete' ] );

		$poiCategoryControllerMock->expects( $this->once() )
			->method( 'validatePoiCategoriesToDelete' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( 'InvalidParameterApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategories();
	}

	/**
	 * Tests if validatePoiCategory method throws BadRequestApiException when there is empty string for POI category name
	 */
	public function testValidatePoiCategory_invalid() {
		$poiCategoryControllerMock = $this->getPoiCategoryControllerMock();

		$this->setExpectedException( 'BadRequestApiException', 'Bad request' );

		$poiCategoryControllerMock->validatePoiCategory( [
			'name' => ' '
		] );
	}

	/**
	 * Tests validatePoiCategoriesToDelete method
	 *
	 * @dataProvider validatePoiCategoriesToDeleteDataProvider
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
	 * Prepares and returns mock for WikiaInteractiveMapsPoiCategoryController
	 *
	 * @param array $params - parameters that getData method should return
	 * @see http://phpunit.de/manual/3.7/en/test-doubles.html#test-doubles.stubs.examples.StubTest5.php
	 * @see http://stackoverflow.com/a/15300642/1050577
	 *
	 * @param array $additionalMethodsToMock - array of names of methods to mock
	 * @return PHPUnit_Framework_MockObject_MockObject|WikiaInteractiveMapsPoiCategoryController
	 */
	private function getPoiCategoryControllerMock( $params = [], $additionalMethodsToMock = [] ) {
		$poiCategoryControllerMock = $this->getMock(
			'WikiaInteractiveMapsPoiCategoryController',
			array_merge( [ 'getData' ], $additionalMethodsToMock ),
			[], '', false );

		$poiCategoryControllerMock->wg->User = $this->getUserMock( true );

		$poiCategoryControllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->returnValueMap( $params ) );

		return $poiCategoryControllerMock;
	}

	/**
	 * Returns mock for User
	 *
	 * @param $isLoggedIn - is user logged in
	 * @return PHPUnit_Framework_MockObject_MockObject|User
	 */
	private function getUserMock( $isLoggedIn ) {
		$userMock = $this->getMock( 'User', [ 'isLoggedIn' ], [], '', false );
		$userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isLoggedIn ) );

		return $userMock;
	}
}
