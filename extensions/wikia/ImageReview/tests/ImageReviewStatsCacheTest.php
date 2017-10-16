<?php
/**
 * Created by PhpStorm.
 * User: harnas
 * Date: 26/07/16
 * Time: 14:48
 */

class ImageReviewStatsCacheTest extends \WikiaBaseTest
{
	/**
	 * @var PHPUnit_Framework_MockObject_MockObject
     */
	var $memCacheMock;

	/**
	 * @var ImageReviewStatsCache
     */
	var $imageReviewStatsCache;
	const TEST_USER_ID = 12345;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ImageReview.setup.php';
		parent::setUp();

		$this->memCacheMock = $this->getMockBuilder( 'MemcachedPhpBagOStuff' )
			->disableOriginalConstructor()
			->setMethods( [ 'get', 'set', 'incr', 'decr' ] )
			->getMock();

		$this->imageReviewStatsCache = new ImageReviewStatsCache( self::TEST_USER_ID, $this->app->wg );
	}

	public function testGetStats() {
		$this->memCacheMock
			->expects( $this->at( 0 ) )
			->method( 'get' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_REVIEWER ) )
			->willReturn( 1 );

		$this->memCacheMock
			->expects( $this->at( 1 ) )
			->method( 'get' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_QUESTIONABLE ) )
			->willReturn( 2 );

		$this->memCacheMock
			->expects( $this->at( 2 ) )
			->method( 'get' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_REJECTED ) )
			->willReturn( 3 );

		$this->memCacheMock
			->expects( $this->at( 3 ) )
			->method( 'get' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_INVALID ) )
			->willReturn( 4 );

		$this->memCacheMock
			->expects( $this->at( 4 ) )
			->method( 'get' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_UNREVIEWED ) )
			->willReturn( 10 );

		$this->mockGlobalVariable( 'wgMemc', $this->memCacheMock );

		$stats = $this->imageReviewStatsCache->getStats();

		foreach ( $this->imageReviewStatsCache->getAllowedStats() as $key ) {
			$this->assertArrayHasKey( $key, $stats );
		}
	}

	public function testStatsUpdate() {
		$newStats = [
			ImageReviewStatsCache::STATS_REVIEWER => 10,
			ImageReviewStatsCache::STATS_INVALID => 4,
		];

		$this->memCacheMock
			->expects( $this->at( 0 ) )
			->method( 'set' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_REVIEWER ), 10, ImageReviewStatsCache::CACHE_EXPIRE_TIME );

		$this->memCacheMock
			->expects( $this->at( 1 ) )
			->method( 'set' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_INVALID ), 4, ImageReviewStatsCache::CACHE_EXPIRE_TIME );

		$this->mockGlobalVariable( 'wgMemc', $this->memCacheMock );

		$this->imageReviewStatsCache->setStats( $newStats );
	}

	public function testStatsOffset() {
		$this->memCacheMock
			->expects( $this->at( 0 ) )
			->method( 'incr' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_QUESTIONABLE) , 10 );

		$this->memCacheMock
			->expects( $this->at( 1 ) )
			->method( 'decr' )
			->with( $this->imageReviewStatsCache->getStatsKey( ImageReviewStatsCache::STATS_REVIEWER) , 3 );

		$this->mockGlobalVariable( 'wgMemc', $this->memCacheMock );

		$this->imageReviewStatsCache->offsetStats( ImageReviewStatsCache::STATS_QUESTIONABLE, 10 );
		$this->imageReviewStatsCache->offsetStats( ImageReviewStatsCache::STATS_REVIEWER, -3 );
	}
}
