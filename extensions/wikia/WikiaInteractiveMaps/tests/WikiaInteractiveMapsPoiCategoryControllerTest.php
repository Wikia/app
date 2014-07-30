<?php
class WikiaInteractiveMapsPoiCategoryControllerTest extends WikiaBaseTest {
	const DEFAULT_PARENT_POI_CATEGORY = 1;

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider cleanUpPoiCategoryDataDataProvider
	 */
	public function testCleanUpPoiCategoryData( $message, $params, $expected ) {
		$mapModelMock = $this->getMock( 'WikiaMaps', [ 'getDefaultParentPoiCategory' ], [], '', false );

		$mapModelMock->expects( $this->any() )
			->method( 'getDefaultParentPoiCategory' )
			->will( $this->returnValue( self::DEFAULT_PARENT_POI_CATEGORY ) );

		$poiCategoryControllerMock = $this->getMock( 'WikiaInteractiveMapsPoiCategoryController', [ 'getMapsModel' ], [], '', false );
		$poiCategoryControllerMock->mapsModel = $mapModelMock;

		/* @var $poiCategoryControllerMock WikiaInteractiveMapsPoiCategoryController */
		$this->assertEquals(
			$expected,
			$poiCategoryControllerMock->cleanUpPoiCategoryData( $params ),
			$message
		);
	}

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
}
