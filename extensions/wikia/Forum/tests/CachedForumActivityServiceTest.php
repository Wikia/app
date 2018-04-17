<?php

use PHPUnit\Framework\TestCase;

class CachedForumActivityServiceTest extends TestCase {
	/** @var PHPUnit_Framework_MockObject_MockObject|BagOStuff $cacheServiceSpy */
	private $cacheServiceSpy;
	/** @var PHPUnit_Framework_MockObject_MockObject|ForumActivityService $forumActivityServiceMock */
	private $forumActivityServiceMock;

	/** @var ForumActivityService $cachedForumActivityService */
	private $cachedForumActivityService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Forum.setup.php';

		$this->cacheServiceSpy = $this->getMockBuilder( HashBagOStuff::class )
			->enableProxyingToOriginalMethods()
			->getMock();

		$this->forumActivityServiceMock = $this->getMockBuilder( ForumActivityService::class )
			->getMockForAbstractClass();

		$this->cachedForumActivityService =
			new CachedForumActivityService( $this->forumActivityServiceMock, $this->cacheServiceSpy );
	}

	/**
	 * @dataProvider provideFreshValues
	 * @param array $freshValue
	 */
	public function testFreshResultFetchedOnCacheMissThenCached( array $freshValue ) {
		$this->cacheServiceSpy->expects( $this->exactly( 2 ) )
			->method( 'get' );

		$this->cacheServiceSpy->expects( $this->once() )
			->method( 'set' )
			->with( $this->anything(), $this->equalTo( $freshValue ), CachedForumActivityService::CACHE_TTL );

		$this->forumActivityServiceMock->expects( $this->once() )
			->method( 'getRecentlyUpdatedThreads' )
			->willReturn( $freshValue );

		$freshResult = $this->cachedForumActivityService->getRecentlyUpdatedThreads();
		$cachedResult = $this->cachedForumActivityService->getRecentlyUpdatedThreads();

		$this->assertEquals( $freshValue, $freshResult );
		$this->assertEquals( $freshValue, $cachedResult );
	}

	public function provideFreshValues() {
		yield 'empty array' => [ [] ];
		yield 'non-empty data' => [ [ 'authorId' => 0, 'authorName' => 'Foo' ] ];
	}
}
