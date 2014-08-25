<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\NearbyPOISearchService;

class NearbyPOISearchServiceTest extends SearchServiceBaseTest {

	/**
	 * @test
	 * @dataProvider testsProvider
	 */
	public function shouldReturnCorrectFormat(
		callable $paramsFunction,
		$expectedOutput,
		$request = null,
		$response = null
	) {
		$service = new NearbyPOISearchService( $this->useSolariumMock( $request, $response ) );
		$paramsFunction( $service );
		$res = $service->search();
		$this->assertEquals( $expectedOutput, $res );
	}

	/**
	 * Provide tests in format [[callable function($serviceObject), output, request, response]]
	 * @return mixed
	 */
	public function testsProvider() {
		return [
			[ function ( NearbyPOISearchService &$svc ) {
				$svc->newQuery();
			},
				$this->getBaseOutput(), $this->getBaseRequest(), $this->getMockResponse() ],
			[ function ( NearbyPOISearchService &$svc ) {
				$svc->newQuery()->setLang( 'en' )->limit( 100 );
			},
				$this->getBaseOutput(), $this->get100LimitRequest(), $this->getMockResponse() ],
			[ function ( NearbyPOISearchService &$svc ) {
				$svc->newQuery()->setLang( 'en' )->latitude( 5 )->longitude( 5 );
			},
				$this->getBaseOutput(), $this->get55CordsRequest(), $this->getMockResponse() ],
		];
	}

	/**
	 * Sets solr response body
	 * @return string Solr response body
	 */
	protected function getMockResponse() {
		return '{"responseHeader":{"status":0,"QTime":1,"params":{"fl":"id,metadata*","sort":"score desc","q":"metadata_map_location_sr:*","wt":"json","rows":"122"}},"response":{"numFound":2,"start":0,"docs":[{"id":"831_155836","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,-1.21412","metadata_map_region_s":"Map_Region_1"},{"id":"831_8938","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,1.11412","metadata_map_region_s":"Map_Region_1"}]}}';
	}

	protected function getBaseOutput() {
		return [ [
			'id' => '831_155836',
			'metadata_fingerprint_ids_ss' => [ "amazing", "great_job", "best" ],
			'metadata_quest_id_s' => "very_good",
			"metadata_map_location_sr" => "1.11244,-1.21412",
			'metadata_map_region_s' => 'Map_Region_1' ], [
			'id' => '831_8938',
			'metadata_fingerprint_ids_ss' => [ "amazing", "great_job", "best" ],
			'metadata_quest_id_s' => 'very_good',
			'metadata_map_location_sr' => '1.11244,1.11412',
			'metadata_map_region_s' => 'Map_Region_1'
		] ];
	}

	protected function getBaseRequest() {
		$mockQuery = new \Solarium_Query_Select();

		$mockQuery->setQuery( '({!geofilt score=distance sfield=metadata_map_location_sr pt=0,0 d=300})' );
		$mockQuery->setRows( 200 );

		$mockQuery->setFields( [ 'id', 'metadata_*', 'score' ] );
		$mockQuery->addSort( 'score', 'asc' );

		return $mockQuery;
	}

	protected function get100LimitRequest() {
		$mockQuery = $this->getBaseRequest();
		$mockQuery->setRows( 100 );
		return $mockQuery;
	}

	protected function get55CordsRequest() {
		$mockQuery = $this->getBaseRequest();
		$mockQuery->setQuery( '({!geofilt score=distance sfield=metadata_map_location_sr pt=5,5 d=300})' );
		return $mockQuery;
	}

}
