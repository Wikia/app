<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\NearbyPOISearchService;
use Wikia\Search\Test\BaseTest;

class NearbyPOISearchServiceTest extends BaseTest {

	/** @test */
	public function shouldReturnCorrectFormat() {
		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );
		$movieSearch = new NearbyPOISearchService( $mock );

		$movieSearch->setLang( 'en' );

		$res = $movieSearch->newQuery()->search();
		$this->assertEquals( [ [
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
		]
		], $res );
	}

	public function mock_getCurrentStagingHost( $arg1, $arg2 ) {
		return 'newhost';
	}

	private function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	private function getResultMock( $responseType ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->{$responseType}()
		);

		return $mock;
	}

	private function getSolariumMainResponse() {
		$body = '{"responseHeader":{"status":0,"QTime":1,"params":{"fl":"id,metadata*","sort":"score desc","q":"metadata_map_location_sr:*","wt":"json","rows":"122"}},"response":{"numFound":2,"start":0,"docs":[{"id":"831_155836","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,-1.21412","metadata_map_region_s":"Map_Region_1"},{"id":"831_8938","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,1.11412","metadata_map_region_s":"Map_Region_1"}]}}';
		$mock = new \Solarium_Client_Response(
			$body,
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}
}
