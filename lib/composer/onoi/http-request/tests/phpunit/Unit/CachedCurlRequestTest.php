<?php

namespace Onoi\HttpRequest\Tests;

use Onoi\HttpRequest\CachedCurlRequest;

/**
 * @covers \Onoi\HttpRequest\CachedCurlRequest
 * @group onoi-http-request
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CachedCurlRequestTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance = new CachedCurlRequest( curl_init(), $cache );

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\CurlRequest',
			$instance
		);

		$this->assertInstanceOf(
			'\Onoi\HttpRequest\CachedCurlRequest',
			$instance
		);
	}

	public function testExecuteForRepeatedRequest() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->setMethods( array( 'contains', 'fetch' ) )
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'contains' )
			->with( $this->equalTo( 'foo:onoi:http:39aa03567d7d983dab1f1bdc5dc75e84' ) )
			->will( $this->returnValue( true ) );

		$cache->expects( $this->once() )
			->method( 'fetch' )
			->will( $this->returnValue( 22 ) );

		$instance = new CachedCurlRequest( curl_init(), $cache );

		$instance->setCachePrefix( 'foo:' );
		$instance->setOption( CURLOPT_RETURNTRANSFER, true );

		$this->assertEquals(
			22,
			$instance->execute()
		);

		$this->assertTrue(
			$instance->isCached()
		);
	}

	public function testDifferentOptionsToGenerateDifferentKeys() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->setMethods( array( 'contains' ) )
			->getMockForAbstractClass();

		$cache->expects( $this->at( 0 ) )
			->method( 'contains' )
			->with( $this->equalTo( 'onoi:http:7ccbcfd552a597d67077d6cc037580ac' ) );

		$cache->expects( $this->at( 1 ) )
			->method( 'contains' )
			->with( $this->equalTo( 'onoi:http:e2015ad4244c4663f10f305e299d5c4f' ) );

		$instance = new CachedCurlRequest( curl_init(), $cache );

		$instance->setOption( CURLOPT_RETURNTRANSFER, true );
		$instance->execute();

		$instance->setOption( CURLOPT_RETURNTRANSFER, false );
		$instance->execute();
	}

	public function testToHaveTargetUrlAsPartOfTheCacheKey() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->setMethods( array( 'contains', 'save' ) )
			->getMockForAbstractClass();

		$cache->expects( $this->at( 0 ) )
			->method( 'contains' )
			->with( $this->equalTo( 'onoi:http:236b194825be3d614ce5fc1b7763a278' ) );

		$cache->expects( $this->at( 2 ) )
			->method( 'contains' )
			->with( $this->equalTo( 'onoi:http:823a603f972819c10d13f32b14460573' ) );

		$instance = new CachedCurlRequest( curl_init( 'http://example.org' ), $cache );

		$instance->setOption( CURLOPT_RETURNTRANSFER, true );
		$instance->execute();

		$instance->setOption( CURLOPT_RETURNTRANSFER, true );
		$instance->setOption( CURLOPT_URL, 'http://example.org' );
		$instance->execute();
	}

	public function testSaveResponse() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->setMethods( array( 'save', 'contains' ) )
			->getMockForAbstractClass();

		$cache->expects( $this->once() )
			->method( 'save' )
			->with(
				$this->equalTo( 'foo:onoi:http:b87e897ea862a410aff82e3122e2d955' ),
				$this->anything(),
				$this->equalTo( 42 ) );

		$instance = new CachedCurlRequest(
			curl_init(),
			$cache
		);

		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL, 42 );
		$instance->setOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX, 'foo:' );

		$instance->setOption( CURLOPT_URL, 'http://example.org' );
		$instance->setOption( CURLOPT_RETURNTRANSFER, true );

		$instance->execute();
	}

	public function testDefinedConstants() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$constants = array(
			'ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX',
			'ONOI_HTTP_REQUEST_RESPONSECACHE_TTL'
		);

		$instance = new CachedCurlRequest( curl_init(), $cache );

		foreach ( $constants as $constant ) {
			$this->assertTrue( defined( $constant ) );
		}
	}

	public function testDeprecatedFunctions() {

		$cache = $this->getMockBuilder( '\Onoi\Cache\Cache' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$instance = new CachedCurlRequest( curl_init(), $cache );

		$instance->setExpiryInSeconds( 42 );
		$instance->setCachePrefix( 'Foo' );

		$this->assertEquals(
			42,
			$instance->getOption( ONOI_HTTP_REQUEST_RESPONSECACHE_TTL )
		);

		$this->assertEquals(
			'Foo',
			$instance->getOption( ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX )
		);
	}

}
