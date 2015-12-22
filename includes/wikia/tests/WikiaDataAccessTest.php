<?php

/**
* @category Wikia
*/
class WikiaDataAccessTest extends WikiaBaseTest {

	function testCacheMiss() {
		$key = 'TESTKEY';
		$value = 'TESTVALUE' . rand();
		$ttl = 568;

		// Mock our memcache class
		$memc = $this->getMock( 'MemcachedPhpBagOStuff' );

		// 'get' should be called and return null
		$memc->expects( $this->once() )
			->method( 'get' )
			->willReturn( null );

		// Our data should be accessed and passed to set
		$memc->expects( $this->once() )
			->method( 'set' )
			->with( $this->equalTo( $key ), $this->equalTo( $value ), $this->equalTo( $ttl ) );

		// Set the memc used to our mock object
		$this->mockGlobalVariable( 'wgMemc', $memc );

		// Cache backed data access
		$returnValue = WikiaDataAccess::cache( $key, $ttl, function () use ( $value ) { return $value; } );

		// Make sure we get back what we expect
		$this->assertEquals( $value, $returnValue, 'Cache HIT test' );
	}

	function testCacheHit() {
		$key = 'TESTKEY';
		$value = 'TESTVALUE' . rand();
		$ttl = 568;

		// Mock our memcache class
		$memc = $this->getMock( 'MemcachedPhpBagOStuff' );

		// 'get' should be called and return our value
		$memc->expects( $this->once() )
			->method( 'get' )
			->willReturn( $value );

		// 'set' should never be called
		$memc->expects( $this->never() )
			->method( 'set' );

		// Set the memc used to our mock object
		$this->mockGlobalVariable( 'wgMemc', $memc );

		// Cache backed data access
		$returnValue = WikiaDataAccess::cache( $key, $ttl, function () use ( $value ) { return $value; } );

		// Make sure we get back what we expect
		$this->assertEquals( $value, $returnValue, 'Cache MISS test' );
	}
}
