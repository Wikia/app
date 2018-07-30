<?php
/**
 * The following test class has been created while fixing SUS-198.
 * @group Integration
 */
class MediaQueryServiceIntegrationTest extends WikiaDatabaseTest {

	public function testGetVideoListSortInvalid() {
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( "\$sort was none of '" .
									   MediaQueryService::SORT_RECENT_FIRST . "', '" .
									   MediaQueryService::SORT_POPULAR_FIRST . "', '" .
									   MediaQueryService::SORT_TRENDING_FIRST . "', '" .
									   MediaQueryService::SORT_TRENDING_FIRST_LEGACY . "'." );

		$service = new MediaQueryService();
		$service->getVideoList(
			1,			// limit
			1, 			// page
			['testProvider'],	// providers
			['testCategory'],	// categories
			'invalidSort'		// sort
		);
	}

	/**
	 * A simple sanity test.
	 */
	public function testGetVideoListGeneral() {
		$service = new MediaQueryService();
		$list = $service->getVideoList(
			2,			// limit
			1, 			// page
			[],			// providers
			[],			// categories
			'recent'		// sort
		);
		$this->assertInternalType( 'array', $list );
		$this->assertCount( 2, $list );
		$this->assertInternalType( 'array',      $list[0] );
		$this->assertArrayHasKey(  'title',      $list[0] );
		$this->assertArrayHasKey(  'provider',   $list[0] );
		$this->assertArrayHasKey(  'addedAt',    $list[0] );
		$this->assertArrayHasKey(  'addedBy',    $list[0] );
		$this->assertArrayHasKey(  'duration',   $list[0] );
		$this->assertArrayHasKey(  'viewsTotal', $list[0] );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/media_query_service.yaml' );
	}
}
