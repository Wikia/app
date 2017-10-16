<?php

/**
* @category Wikia
*/
class WikiaDataAccessTest extends WikiaBaseTest {

	/** @var PHPUnit_Framework_MockObject_MockObject $memc */
	private $memc;

	protected function setUp() {
		parent::setUp();

		$this->memc = $this->getMockBuilder( MemcachedPhpBagOStuff::class )
			->disableOriginalConstructor()
			->getMock();

		$this->mockGlobalVariable( 'wgMemc', $this->memc );
	}

	function testCacheMiss() {
		$key = 'TESTKEY';
		$value = 'TESTVALUE' . rand();
		$ttl = 568;
		// 'get' should be called and return null
		$this->memc->expects( $this->once() )
			->method( 'get' )
			->willReturn( null );

		// Our data should be accessed and passed to set
		$this->memc->expects( $this->once() )
			->method( 'set' )
			->with( $this->equalTo( $key ), $this->equalTo( $value ), $this->equalTo( $ttl ) );


		// Cache backed data access
		$returnValue = WikiaDataAccess::cache( $key, $ttl, function () use ( $value ) { return $value; } );

		// Make sure we get back what we expect
		$this->assertEquals( $value, $returnValue, 'Cache HIT test' );
	}

	function testCacheHit() {
		$key = 'TESTKEY';
		$value = 'TESTVALUE' . rand();
		$ttl = 568;

		// 'get' should be called and return our value
		$this->memc->expects( $this->once() )
			->method( 'get' )
			->willReturn( $value );

		// 'set' should never be called
		$this->memc->expects( $this->never() )
			->method( 'set' );

		// Cache backed data access
		$returnValue = WikiaDataAccess::cache( $key, $ttl, function () use ( $value ) { return $value; } );

		// Make sure we get back what we expect
		$this->assertEquals( $value, $returnValue, 'Cache MISS test' );
	}
}
