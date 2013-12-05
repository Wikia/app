<?php


namespace Wikia\ApiDocs\Services;


class CachingApiDocsServiceTest extends \WikiaBaseTest {
	protected function setUp() {
		global $IP;
		$this->setupFile = "{$IP}/extensions/wikia/ApiDocs/ApiDocs.setup.php";

		parent::setUp();
	}

	public function testGetDocListCacheHit() {
		$cacheBuster = 132;
		$this->getGlobalFunctionMock("wfMemcKey")
			->expects( $this->once() )
			->method( "wfMemcKey" )
			->with( "ApiDocsService", "getDocList", $cacheBuster )
			->will( $this->returnValue( "cacheKey" ) );
		$wikiaDataAccessMock = $this->getStaticMethodMock("WikiaDataAccess", "cache");
		$wikiaDataAccessMock
			->expects( $this->once() )
			->method( "cache" )
			->with( "cacheKey" )
			->will( $this->returnValue([ 'foo' ]) );
		$internalApiDocsService = $this->getMock('\Wikia\ApiDocs\Services\IApiDocsService');

		$cachingApiDocsService = new CachingApiDocsService( $internalApiDocsService, $cacheBuster );
		$result = $cachingApiDocsService->getDocList();

		$this->assertEquals( [ 'foo' ], $result );
	}


	public function testGetDocListCacheMiss() {
		$cacheBuster = 132;
		$cacheKey = "fooKey";

		$this->getGlobalFunctionMock("wfMemcKey")
			->expects( $this->once() )
			->method( "wfMemcKey" )
			->with( "ApiDocsService", "getDocList", $cacheBuster )
			->will( $this->returnValue( $cacheKey) );
		$this->getStaticMethodMock("WikiaDataAccess", "cache")
			->expects( $this->once() )
			->method( "cache" )
			->with( $cacheKey, 12 * 60 * 60 )
			->will( $this->returnCallback( function( $key, $time, $callback ) { return $callback(); } ) )
		;

		$internalApiDocsService = $this->getMock('\Wikia\ApiDocs\Services\IApiDocsService');
		$internalApiDocsService->expects( $this->once() )
			->method( "getDocList" )
			->will( $this->returnValue( [ 'foo' ] ) );

		$cachingApiDocsService = new CachingApiDocsService( $internalApiDocsService, $cacheBuster );
		$result = $cachingApiDocsService->getDocList();
		$this->assertEquals( [ 'foo' ], $result );
	}

	public function testGetDocCacheHit() {
		$cacheBuster = 132;
		$this->getGlobalFunctionMock("wfMemcKey")
			->expects( $this->once() )
			->method( "wfMemcKey" )
			->with( "ApiDocsService", "fooApi", $cacheBuster )
			->will( $this->returnValue( "cacheKey" ) );
		$wikiaDataAccessMock = $this->getStaticMethodMock("WikiaDataAccess", "cache");
		$wikiaDataAccessMock
			->expects( $this->once() )
			->method( "cache" )
			->with( "cacheKey" )
			->will( $this->returnValue([ 'foo' ]) );
		$internalApiDocsService = $this->getMock('\Wikia\ApiDocs\Services\IApiDocsService');

		$cachingApiDocsService = new CachingApiDocsService( $internalApiDocsService, $cacheBuster );
		$result = $cachingApiDocsService->getDoc( "fooApi" );

		$this->assertEquals( [ 'foo' ], $result );
	}


	public function testGetDocCacheMiss() {
		$cacheBuster = 132;
		$cacheKey = "fooKey";

		$this->getGlobalFunctionMock("wfMemcKey")
			->expects( $this->once() )
			->method( "wfMemcKey" )
			->with( "ApiDocsService", "fooApi", $cacheBuster )
			->will( $this->returnValue( $cacheKey) );
		$this->getStaticMethodMock("WikiaDataAccess", "cache")
			->expects( $this->once() )
			->method( "cache" )
			->with( $cacheKey, 12 * 60 * 60 )
			->will( $this->returnCallback( function( $key, $time, $callback ) { return $callback(); } ) )
		;

		$internalApiDocsService = $this->getMock('\Wikia\ApiDocs\Services\IApiDocsService');
		$internalApiDocsService->expects( $this->once() )
			->method( "getDoc" )
			->with( "fooApi" )
			->will( $this->returnValue( [ 'foo' ] ) );

		$cachingApiDocsService = new CachingApiDocsService( $internalApiDocsService, $cacheBuster );
		$result = $cachingApiDocsService->getDoc( "fooApi" );

		$this->assertEquals( [ 'foo' ], $result );
	}
}
