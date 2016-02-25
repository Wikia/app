<?php
/**
 * The following test class has been created while fixing SUS-198.
 */
class MediaQueryServiceTest extends WikiaBaseTest {

	/**
         * @expectedException InvalidArgumentException
         * @expectedExceptionMessage $sort was none of 'recent', 'popular', 'trend'.
	 */
	public function testGetVideoListSortInvalid() {
		$service = new MediaQueryService();
		$list = $service->getVideoList(
			'all',			// filter
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
