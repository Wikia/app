<?php
/**
 * The following test class has been created while fixing SUS-198.
 */
class MediaQueryServiceTest extends WikiaBaseTest {

	public function testGetVideoListSortInvalid() {
		try {		
			$service = new MediaQueryService();
			$list = $service->getVideoList(
				'all',			// filter
				1,			// limit
				1, 			// page
				['testProvider'],	// providers
				['testCategory'],	// categories
				'invalidSort'		// sort
			);

		} catch ( InvalidArgumentException $e ) {
			$this->assertEquals( $e->getMessage(), "\$sort was none of '"
				. MediaQueryService::SORT_RECENT_FIRST . "', '"
				. MediaQueryService::SORT_POPULAR_FIRST . "', '"
				. MediaQueryService::SORT_TRENDING_FIRST . "'."
			);
			return;
		}

		$this->fail( 'InvalidArgumentException expected but not thrown.' );
	}

	/**
	 * A simple sanity test.
	 */
	public function testGetVideoListGeneral() {
		$service = new MediaQueryService();
		$list = $service->getVideoList(
			'all',			// filter
			1,			// limit
			1, 			// page
			[],			// providers
			[],			// categories
			'recent'		// sort
		);
		$this->assertInternalType( 'array', $list );
		$this->assertCount( 1, $list );
		$this->assertInternalType( 'array',      $list[0] );
		$this->assertArrayHasKey(  'title',      $list[0] );
		$this->assertArrayHasKey(  'provider',   $list[0] );
		$this->assertArrayHasKey(  'addedAt',    $list[0] );
		$this->assertArrayHasKey(  'addedBy',    $list[0] );
		$this->assertArrayHasKey(  'duration',   $list[0] );
		$this->assertArrayHasKey(  'viewsTotal', $list[0] );
	}
}
