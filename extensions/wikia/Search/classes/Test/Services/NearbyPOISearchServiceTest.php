<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\NearbyPOISearchService;

class NearbyPOISearchServiceTest extends SearchServiceBaseTest {

	/** @test */
	public function shouldReturnCorrectFormat() {
		$service = new NearbyPOISearchService( $this->useSolariumMock() );

		$res = $service->newQuery()
			->setLang('en')
			->search();
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

	/**
	 * Sets solr response body
	 * @return string Solr response body
	 */
	protected function getMockResponse() {
		return '{"responseHeader":{"status":0,"QTime":1,"params":{"fl":"id,metadata*","sort":"score desc","q":"metadata_map_location_sr:*","wt":"json","rows":"122"}},"response":{"numFound":2,"start":0,"docs":[{"id":"831_155836","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,-1.21412","metadata_map_region_s":"Map_Region_1"},{"id":"831_8938","metadata_fingerprint_ids_ss":["amazing","great_job","best"],"metadata_quest_id_s":"very_good","metadata_map_location_sr":"1.11244,1.11412","metadata_map_region_s":"Map_Region_1"}]}}';
	}
}
