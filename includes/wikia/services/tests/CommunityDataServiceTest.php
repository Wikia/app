<?php

class CommunityDataServiceTest extends WikiaBaseTest {


	/**
	 * @dataProvider hasDataTestsProvider
	 */
	public function testHasDataMethod( $data, $expected, $message ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected, ( new CommunityDataService( 1 ) )->hasData(), $message );
	}

	public function hasDataTestsProvider() {
		return [
			[ '', false, 'No data in empty curated content' ],
			[ [ ], false, 'No data in empty curated content' ],
			[ [ 'community_data' => [ 'description' => 'Test', 'image_id' => 0 ] ], true, 'Should have data if community data present' ],
			[ [ 'community_data' => [ 'description' => '', 'image_id' => 0 ] ], false, 'Empty community data should be treated as empty' ],
			[ [ 'optional' => [ ], 'featured' => [ ], 'curated' => [ ] ], false, 'Empty sections should be treated as empty' ],
			[ [ 'optional' => [ 'items' => [ ] ], 'featured' => [ ], 'curated' => [ ] ], true, 'Should have data if any section set' ],
		];
	}
}
