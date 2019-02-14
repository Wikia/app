<?php

use PHPUnit\Framework\TestCase;

class CachedFandomArticleServiceTest extends TestCase {

	/** @var BagOStuff $cacheService */
	private $cacheService;
	/** @var FandomArticleService|PHPUnit_Framework_MockObject_MockObject $mockArticleService */
	private $mockArticleService;

	/** @var CachedFandomArticleService $cachedFandomArticleService */
	private $cachedFandomArticleService;

	protected function setUp() {
		parent::setUp();

		$this->cacheService = new HashBagOStuff();
		$this->mockArticleService = $this->getMockForAbstractClass( FandomArticleService::class );

		$this->cachedFandomArticleService = new CachedFandomArticleService(
			$this->cacheService,
			$this->mockArticleService
		);
	}

	public function testShouldFetchAndCacheData() {
		$limit = 10;
		$data = [ [] ];

		$this->mockArticleService->expects( $this->once() )
			->method( 'getTrendingFandomArticles' )
			->with( $limit )
			->willReturn( $data );

		$fresh = $this->cachedFandomArticleService->getTrendingFandomArticles( $limit );
		$cached = $this->cachedFandomArticleService->getTrendingFandomArticles( $limit );

		$this->assertEquals( $data, $fresh );
		$this->assertEquals( $data, $cached );
	}
}
