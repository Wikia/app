<?php

class CommunityDataServiceTest extends WikiaBaseTest {
	const FEATURED_SECTION = 'featured';
	const CURATED_SECTION = 'curated';
	const OPTIONAL_SECTION = 'optional';
	const COMMUNITY_DATA = 'community_data';

	/**
	 * @dataProvider hasDataTestsProvider
	 */
	public function testHasDataMethod( $data, $expected, $message ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected, ( new CommunityDataService( 1 ) )->hasData(), $message );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetCommunityData( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::COMMUNITY_DATA], ( new CommunityDataService( 1 ) )->getCommunityData(),
			'can not get community data correctly' );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetCommunityImageId( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::COMMUNITY_DATA]['image_id'], ( new CommunityDataService( 1 ) )->getCommunityImageId(),
			'can not get community image id correctly' );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetCommunityDescription( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::COMMUNITY_DATA]['description'], ( new CommunityDataService( 1 ) )->getCommunityDescription(),
			'can not get community description correctly' );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetCurated( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::CURATED_SECTION], ( new CommunityDataService( 1 ) )->getCurated(),
			'can not get curated correctly' );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetFeatured( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::FEATURED_SECTION], ( new CommunityDataService( 1 ) )->getFeatured(),
			'can not get featured correctly' );
	}

	/**
	 * @dataProvider getDataProvider
	 */
	public function testGetOptional( $data, $expected ) {
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', $data );
		$this->assertEquals( $expected[self::OPTIONAL_SECTION], ( new CommunityDataService( 1 ) )->getOptional(),
			'can not get optional correctly' );
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

	public function getDataProvider() {
		return [
			[
				[ 'community_data' => [ 'description' => 'Test', 'image_id' => 10 ],
					'curated' => ['label' => 'string', 'article_id' => 2, 'image_id'=> 2],
					'featured' => ['items' => ['article_id' => 1, 'image_id' => 1, 'label' => 'label', 'title' => 'title']],
					'optional' => ['label' => 'label', 'items' => []]],
				[ 'community_data' => [ 'description' => 'Test', 'image_id' => 10 ],
					'curated' => ['label' => 'string', 'article_id' => 2, 'image_id'=> 2],
					'featured' => ['items' => ['article_id' => 1, 'image_id' => 1, 'label' => 'label', 'title' => 'title']],
					'optional' => ['label' => 'label', 'items' => []]]
			],

			[
				[ 'community_data' => [],
					'curated' => [],
					'featured' => [],
					'optional' => []],
				[ 'community_data' => [],
					'curated' => [],
					'featured' => [],
					'optional' => []]
			],

			[[ ],  ['community_data' => [],
					'curated' => [],
					'featured' => [],
					'optional' => []]]
		];
	}
}
