<?php

use Wikia\Search\Test\BaseTest;

include_once dirname( __FILE__ ) . '/../../../Services/QuestDetails/' . "QuestDetailsSolrHelper.class.php";
include_once dirname( __FILE__ ) . '/../../../Services/QuestDetails/' . "QuestDetailsSearchService.class.php";

/**
 * Class QuestDetailsSearchServiceMock - used to mock calls of static methods (which must not be tested)
 */
class QuestDetailsSearchSolrHelperMock extends QuestDetailsSolrHelper {

	protected function getRevision( &$item ) {
		$revision = [
			'id' => 1234,
			'user' => 'test_user',
			'user_id' => 1111,
			'timestamp' => '1234567'
		];
		return $revision;
	}

	protected function getCommentsNumber( &$item ) {
		return 0;
	}

	protected function getArticlesThumbnails( $articles, $width = self::DEFAULT_THUMBNAIL_WIDTH, $height = self::DEFAULT_THUMBNAIL_HEIGHT ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [ ];
		foreach ( $ids as $id ) {
			$data = [
				'thumbnail' => null,
				'original_dimensions' => null
			];
			$result[ $id ] = $data;
		}
		return $result;
	}
}

class QuestDetailsSearchServiceTest extends WikiaBaseTest {

	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	/**
	 * @covers       QuestDetailsSearchService::makeQuery
	 * @dataProvider makeCriteriaQuery_Provider
	 */
	public function testCorrectnessOfQueryBuilding( $criteria, $expectedQuery ) {
		$questDetailsSearch = new QuestDetailsSearchService();

		if( empty( $criteria[ 'fingerprint' ] ) ) {
			$criteria[ 'fingerprint' ] = null;
		}
		if( empty( $criteria[ 'questId' ] ) ) {
			$criteria[ 'questId' ] = null;
		}
		if( empty( $criteria[ 'category' ] ) ) {
			$criteria[ 'category' ] = null;
		}

		$this->assertEquals(
			$expectedQuery,
			$questDetailsSearch->newQuery()
				->withFingerprint( $criteria[ 'fingerprint' ] )
				->withQuestId( $criteria[ 'questId' ] )
				->withCategory( $criteria[ 'category' ] )
				->makeQuery()
		);
	}

	/**
	 * @covers       QuestDetailsSolrHelper::parseCoordinates
	 * @dataProvider makeParseCoordinates_Provider
	 */
	public function testParseCoordinatesString( $str, $x, $y ) {
		$solrHelper = new QuestDetailsSolrHelper();

		$parseCoordinates = self::getFn( $solrHelper, 'parseCoordinates' );

		$result = $parseCoordinates( $str );

		$this->assertEquals( $x, $result[ 'x' ] );
		$this->assertEquals( $y, $result[ 'y' ] );
	}

	/**
	 * @covers       QuestDetailsSolrHelper::parseCoordinates
	 */
	public function testParseCoordinatesInvalidString() {
		$solrHelper = new QuestDetailsSolrHelper();

		$parseCoordinates = self::getFn( $solrHelper, 'parseCoordinates' );

		$exceptionBeenThrown = false;
		try {
			$parseCoordinates( 'invalid' );
		} catch ( Exception $e ) {
			$exceptionBeenThrown = true;
		}

		if ( !$exceptionBeenThrown ) {
			$this->fail( 'Whet parsing invalid coordinates - exception must be thrown' );
		}
	}

	public function testShouldReturnCorrectResponseFormat() {
		$questDetailsSearch = $this->getMockedQuestDetailsSearchService();
		$result = $questDetailsSearch->newQuery()->search();
		$expected = [
			'1018050_2151' =>
				[
					'poi_id_s' => '15908',
					'poi_category_id_s' => '5062',
					'map_region_s' => '1b',
					'map_id_s' => '2303',
					'fingerprint_ids_mv_s' => [
							0 => 'f31'
						],
					'parent_poi_category_id_s' => '3',
					'map_location_sr' => '-75.737305,-112.851562',
					'ability_id_s' => '33',
					'quest_id_s' => 'f32',
					'id' => '1018050_2151',
					'wid_i' => 1018050,
					'_version_' => 1478885727304417300
				]
			];
		$this->assertEquals( $expected, $result );
	}

	public function testShouldProcessMetadata() {
		$questDetailsSearch = $this->getMockedQuestDetailsSearchService();
		$helper = new QuestDetailsSolrHelper();
		$result = $questDetailsSearch->newQuery()->search();
		$processed = $helper->processMetadata( $result );
		$expected = [
			'1018050_2151' =>
				[
					'map_location' =>
						[
							'region' => '1b',
							'id' => '2303',
							'latitude' => -75.737305,
							'longitude' => -112.851562,
						],
					'poi_id' => '15908',
					'poi_category_id' => '5062',
					'fingerprints' =>
						[
							0 => 'f31',
						],
					'parent_poi_category_id' => '3',
					'ability_id' => '33',
					'quest_id' => 'f32',
				]
			];
		$this->assertEquals( $expected, $processed );
	}

	protected function getMockedQuestDetailsSearchService() {

		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );

		$questDetailsSearch = new QuestDetailsSearchService( $mock );

		$questDetailsSearch->setSolrHelper( new QuestDetailsSearchSolrHelperMock() );

		return $questDetailsSearch;
	}

	protected function mock_getCurrentStagingHost( $arg1, $arg2 ) {
		return 'newhost';
	}

	protected function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	protected function getResultMock( $responseType ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->{$responseType}()
		);

		return $mock;
	}

	protected function getSolariumMainResponse() {
		$body = <<<SOLR_RESPONSE_MOCK
{
  "responseHeader": {
    "status": 0,
    "QTime": 0,
    "params": {
      "indent": "true",
      "q": "*:*",
      "wt": "json",
      "fq": "+id:(1018050_2151)"
    }
  },
  "response": {
    "numFound": 1,
    "start": 0,
    "docs": [
      {
        "poi_id_s": "15908",
        "poi_category_id_s": "5062",
        "map_region_s": "1b",
        "map_id_s": "2303",
        "fingerprint_ids_mv_s": [
          "f31"
        ],
        "parent_poi_category_id_s": "3",
        "map_location_sr": "-75.737305,-112.851562",
        "ability_id_s": "33",
        "quest_id_s": "f32",
        "id": "1018050_2151",
        "wid_i": 1018050,
        "_version_": 1478885727304417300
      }
    ]
  }
}
SOLR_RESPONSE_MOCK;

		$mock = new \Solarium_Client_Response(
			$body,
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}

	public function makeCriteriaQuery_Provider() {
		return [
			[ [ 'fingerprint' => 'test' ], 'fingerprint_ids_mv_s:"test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => null, 'category' => null ], 'fingerprint_ids_mv_s:"test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => '', 'category' => '' ], 'fingerprint_ids_mv_s:"test"' ],
			[ [ 'questId' => '123' ], 'quest_id_s:"123"' ],
			[ [ 'category' => 'Test' ], 'categories_mv_en:"Test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => '123' ], 'fingerprint_ids_mv_s:"test" AND quest_id_s:"123"' ],
			[ [ 'fingerprint' => 'test', 'category' => 'Test' ], 'fingerprint_ids_mv_s:"test" AND categories_mv_en:"Test"' ],
			[ [ 'questId' => '123', 'category' => 'Test' ], 'quest_id_s:"123" AND categories_mv_en:"Test"' ],
		];
	}

	public function makeParseCoordinates_Provider() {
		return [
			[ '1, 1', 1, 1 ],
			[ '1, -1', 1, -1 ],
			[ '-1, 1', -1, 1 ],
			[ '1.0, 1.0', 1, 1 ],
			[ '1.23, 4.56', 1.23, 4.56 ],
			[ '1.23, -4.56', 1.23, -4.56 ],
			[ '-1.23, 4.56', -1.23, 4.56 ],
			[ '-1.23, -4.56', -1.23, -4.56 ],
		];
	}
}