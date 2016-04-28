<?php
/**
 * Class definition for \Wikia\Search\Test\MediaWikiServiceTest
 * @author relwell
 */
namespace Wikia\Search\Test;
use Wikia\Search\MediaWikiService;
use \ReflectionProperty;
use \ReflectionMethod;
/**
 * Tests the methods found in \Wikia\Search\MediaWikiService
 * @author relwell
 */
class MediaWikiServiceTest extends BaseTest
{
	/**
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected $service;

	/**
	 * @var int
	 */
	protected $pageId;

	public function setUp() {
		parent::setUp();
		$this->pageId = 123;
		$this->service = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
                                ->disableOriginalConstructor();

		// re-initialize static vars
		$staticVars = array(
				'pageIdsToArticles', 'pageIdsToTitles', 'redirectsToCanonicalIds',
				'pageIdsToFiles', 'redirectArticles', 'wikiDataSources'
		);
		foreach ( $staticVars as $var ) {
			$refl = new ReflectionProperty( 'Wikia\Search\MediaWikiService', $var );
			$refl->setAccessible( true );
			$refl->setValue( array() );
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08676 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleStringFromPageId
	 */
	public function testGetTitleStringFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleString', 'getTitleFromPageId' ) )->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$mockTitleString = 'Mock Title';

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFrompageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getTitleString' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $mockTitleString ) )
		;
		$this->assertEquals(
				$mockTitleString,
				$service->getTitleStringFrompageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleStringFromPageId should return the string value of a title based on a page ID'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08731 ms
	 * @covers \Wikia\Search\MediaWikiService::getLocalUrlForPageId
	 */
	public function testGetLocalUrlForPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getLocalUrl' ) )
		                  ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFrompageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getLocalUrl' )
		    ->with   ( [ 'foo' => 'bar' ], false )
		    ->will   ( $this->returnValue( 'Stuff?foo=bar' ) )
		;
		$this->assertEquals(
				'Stuff?foo=bar',
				$service->getLocalUrlForPageId( $this->pageId, [ 'foo' => 'bar' ] ),
				'\Wikia\Search\MediaWikiService::getLocalUrlFromPageId should return the string value of local url based on a page ID'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08611 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleFromPageId
	 */
	public function testGetTitleFromPageIdFreshPage() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();

		$mockPage = $this->getMockBuilder( 'Article' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getTitle' ) )
		                 ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockPage ) )
		;
		$mockPage
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;

		$getRefl = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleFromPageId' );
		$getRefl->setAccessible( true );

		$pageIdsToTitles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToTitles' );
		$pageIdsToTitles->setAccessible( true ) ;

		$this->assertEquals(
				$mockTitle,
				$getRefl->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should return an instance of Title corresponding to the provided page ID'
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToTitles->getValue( $service ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should store any titles it access for a page in the pageIdsToTitles array'
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.08477 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleFromPageId
	 */
	public function testGetTitleFromPageIdCachedPage() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();

		$mockPage = $this->getMockBuilder( 'Article' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getTitle' ) )
		                 ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$service
		    ->expects( $this->never() )
		    ->method ( 'getPageFromPageId' )
		;
		$mockPage
		    ->expects( $this->never() )
		    ->method ( 'getTitle' )
		;

		$getRefl = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleFromPageId' );
		$getRefl->setAccessible( true );

		$pageIdsToTitles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToTitles' );
		$pageIdsToTitles->setAccessible( true );
		$pageIdsToTitles->setValue( $service, array( $this->pageId => $mockTitle ) );

		$this->assertEquals(
				$mockTitle,
				$getRefl->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should return an instance of Title corresponding to the provided page ID'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08548 ms
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsCanonical() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;

		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );

		$this->assertEquals(
				$this->pageId,
				$getCanonicalPageIdFromPageId->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08534 ms
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsException() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();
		$ex = $this->getMockBuilder( '\Exception' )
		           ->disableOriginalConstructor()
		           ->getMock();
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->throwException( $ex ) )
		;

		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );

		$this->assertEquals(
				$this->pageId,
				$getCanonicalPageIdFromPageId->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if an exception is thrown'
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.08506 ms
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsRedirect() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;

		$canonicalPageId = 54321;

		$redirectsToCanonicalIds = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'redirectsToCanonicalIds' );
		$redirectsToCanonicalIds->setAccessible( true );
		$redirectsToCanonicalIds->setValue( $service, array( $this->pageId => $canonicalPageId ) );

		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );

		$this->assertEquals(
				$canonicalPageId,
				$getCanonicalPageIdFromPageId->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08618 ms
	 * @covers \Wikia\Search\MediaWikiService::isPageIdContent
	 */
	public function testIsPageIdContentYes() {
		$service = $this->service->setMethods( array( 'getNamespaceFromPageId', 'getGlobal' ) )->getMock();

		$service
		    ->expects( $this->any() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( NS_MAIN ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ContentNamespaces' )
		    ->will   ( $this->returnValue( array( NS_MAIN, NS_CATEGORY ) ) )
		;
		$this->assertTrue(
				$service->isPageIdContent( $this->pageId )
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.08544 ms
	 * @covers \Wikia\Search\MediaWikiService::isPageIdContent
	 */
	public function testIsPageIdContentNo() {
		$service = $this->service->setMethods( array( 'getNamespaceFromPageId', 'getGlobal' ) )->getMock();

		$service
		    ->expects( $this->any() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( NS_FILE ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ContentNamespaces' )
		    ->will   ( $this->returnValue( array( NS_MAIN, NS_CATEGORY ) ) )
		;
		$this->assertFalse(
				$service->isPageIdContent( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08566 ms
	 * @covers \Wikia\Search\MediaWikiService::getLanguageCode
	 */
	public function testGetLanguageCode() {
		global $wgContLang;
		$this->assertEquals(
				$wgContLang->getCode(),
				(new MediaWikiService)->getLanguageCode(),
				'\Wikia\Search\MediaWikiService::getLanguageCode should provide an interface to $wgContLang->getCode()'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08422 ms
	 * @covers \Wikia\Search\MediaWikiService::getUrlFromPageId
	 */
	public function testGetUrlFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();

		$url = 'http://foo.wikia.com/wiki/Bar';

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFullUrl' )
		    ->will   ( $this->returnValue( $url ) )
		;
		$this->assertEquals(
				$url,
				$service->getUrlFromPageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getUrlFromPageId should return the full URL from the title instance associated with the provided page id'
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.08527 ms
	 * @covers \Wikia\Search\MediaWikiService::getNamespaceFromPageId
	 */
	public function testGetNamespaceFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getNamespace' ) )
		                  ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_TALK ) )
		;
		$this->assertEquals(
				NS_TALK,
				$service->getNamespaceFromPageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getNamespaceFromPageId should return the namespace from the title instance associated with the provided page id'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08489 ms
	 * @covers \Wikia\Search\MediaWikiService::getMainPageArticleId
	 */
	public function testGetMainPageArticleId() {
		$this->assertEquals(
				\Title::newMainPage()->getArticleId(),
				(new MediaWikiService)->getMainPageArticleId()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08549 ms
	 * @covers Wikia\Search\MediaWikiService::getMainPageIdForWikiId
	 */
	public function testGetMainPageIdForWikiId() {
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getArticleId' ] )
		                  ->getMock();

		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getMainPageTitleForWikiId' ] );
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getMainPageTitleForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getArticleId' )
		    ->will   ( $this->returnValue( 321 ) )
		;
		$this->assertEquals(
				321,
				$mockService->getMainPageIdForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08591 ms
	 * @covers \Wikia\Search\MediaWikiService::getSimpleLanguageCode
	 */
	public function testGetsimpleLanguageCode() {
		$service = $this->service->setMethods( array( 'getLanguageCode' ) )->getMock();

		$service
		    ->expects( $this->any() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en-ca' ) )
		;
		$this->assertEquals(
				'en',
				$service->getSimpleLanguageCode(),
				'\Wikia\Search\MediaWikiService::getSimpleLanguageCode should strip any extensions from the two-letter language code'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12579 ms
	 * Note: we actually expect an array here but since static method calls are tricky here
	 * we're using mockClass with translated version of a response array
	 * @covers \Wikia\Search\MediaWikiService::getParseResponseFromPageId
	 */
	public function testGetParseResponseFromPageId() {
		$mockApiService = $this->getMockBuilder( '\ApiService' )
		                       ->setMethods( array( 'call' ) )
		                       ->getMock();

		$mockResultArray = (object) array( 'foo' => 'bar' );

		// hack to make this work in our framework
		$this->mockClass( '\ApiService', $mockResultArray, 'call' );

		$this->assertEquals(
				$mockResultArray,
				(new MediaWikiService)->getParseResponseFromPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12603 ms
	 * @covers \Wikia\Search\MediaWikiService::getCacheKey
	 */
	public function testGetCacheKey() {
		$service = $this->service->setMethods( array( 'getWikiId'  ) )->getMock();

		$mockSharedMemcKey = $this->getGlobalFunctionMock( 'wfSharedMemcKey' );

		$wid = 567;
		$key = 'foo';

		$service
		    ->expects( $this->any() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( $wid ) )
		;
		$mockSharedMemcKey
		    ->expects( $this->any() )
		    ->method ( 'wfSharedMemcKey' )
		    ->with   ( $key, $wid )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$this->assertEquals(
				'bar',
				$service->getCacheKey( $key )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08632 ms
	 * @covers \Wikia\Search\MediaWikiService::getCacheResult
	 */
	public function testGetCacheResult() {

		$service = $this->service->setMethods( array( 'getGlobal' ) )->getMock();

		$mockMc = $this->getMockBuilder( '\MemcachedClientForWiki' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'get' ) )
		               ->getMock();

		$key = 'bar';
		$result = 'foo';

		$app = (object) array( 'wg' => (object ) array( 'Memc' => $mockMc ) );
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $service, $app );

		$mockMc
		    ->expects( $this->any() )
		    ->method ( 'get' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( $result ) )
		;
		$this->assertEquals(
				$result,
				$service->getCacheResult( $key ),
				'\WikiaSearch\MediaWikiService::getCacheResult should provide an interface to $wgMemc->get()'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08651 ms
	 * @covers \Wikia\Search\MediaWikiService::getCacheResultFromString
	 */
	public function testGetCacheResultFromString() {
		$service = $this->service->setMethods( array( 'getCacheResult', 'getCacheKey' ) )->getMock();

		$key = 'foo';
		$val = 'bar';

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCacheKey' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( sha1( $key ) ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getCacheResult' )
		    ->with   ( sha1( $key ) )
		    ->will   ( $this->returnValue( $val ) )
		;
		$this->assertEquals(
				$val,
				$service->getCacheResultFromString( $key ),
				'\WikiaSearch\MediaWikiService::getCacheResultFromString should provide an interface for accessing a cached value from a plaintext key'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08869 ms
	 * @covers \Wikia\Search\MediaWikiService::setCacheFromStringKey
	 */
	public function testSetCacheFromStringKey() {

		$service = $this->service->setMethods( array( 'getCacheKey', 'getWg' ) )->getMock();

		$mockMc = $this->getMockBuilder( '\MemcachedClientForWiki' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'set' ) )
		               ->getMock();

		$key = 'bar';
		$value = 'foo';
		$ttl = 3600;

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCacheKey' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( sha1( $key ) ) )
		;
		$mockMc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'set' )
		    ->with   ( sha1( $key ), $value, $ttl )
		;
		$app = (object) array( 'wg' => (object ) array( 'Memc' => $mockMc ) );
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $service, $app );
		$this->assertEquals(
				$service,
				$service->setCacheFromStringKey( $key, $value, $ttl ),
				'\WikiaSearch\MediaWikiService::setCacheResultForStringKey should set a cache value in memcached provided a given plaintext key'
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.11852 ms
	 * One day this test will actually work as advertised.
	 * @covers \Wikia\Search\MediaWikiService::getBacklinksCountFromPageId
	 */
	public function testGetBacklinksCountFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleStringFromPageId' ) )->getMock();

		$mockApiService = $this->getMock( '\ApiService', array( 'call' ) );

		$title = "Foo Bar";

		$data = array( 'query' => array( 'backlinks_count' => 0 ) );

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $title ) )
		;
		$mockApiService
		    ->staticExpects( $this->any() )
		    ->method       ( 'call' )
		    ->with         ( $title )
		    ->will         ( $this->returnValue( $data ) )
		;

		$this->mockClass( '\ApiService', $mockApiService );
		$this->mockClass( '\ApiService', $mockApiService );

		$this->assertEquals(
				0,
				$service->getBacklinksCountFromPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08564 ms
	 * @covers \Wikia\Search\MediaWikiService::getGlobal
	 */
	public function testGetGlobal() {
		$service = new MediaWikiService;
		$app = \F::app();
		$app->wg->Foo = 'bar';

		$this->assertEquals(
				'bar',
				$service->getGlobal( 'Foo' ),
				'\WikiaSearch\MediaWikiService::getGlobal should provide an interface to MediaWiki wg-prefixed global variables'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09211 ms
	 * @covers \Wikia\Search\MediaWikiService::getGlobalWithDefault
	 */
	public function testGetGlobalWithDefault() {
		$service = new MediaWikiService;
		$app = \F::app();
		$app->wg->Foo = null;

		$this->assertEquals(
				'bar',
				$service->getGlobalWithDefault( 'Foo', 'bar' ),
				'\WikiaSearch\MediaWikiService::getGlobalWithDefault should return the default value if the global value is null.'
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.08814 ms
	 * @covers \Wikia\Search\MediaWikiService::setGlobal
	 */
	public function testSetGlobal() {
		$service = new MediaWikiService;
		$app = \F::app();

		$this->assertEquals(
				$service,
				$service->setGlobal( 'Foo', 'bar' )
		);
		$this->assertEquals(
				'bar',
				$app->wg->Foo,
				'\WikiaSearch\MediaWikiService::setGlobal should set the provided key as a global variable name with the provided value'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08829 ms
	 * @covers \Wikia\Search\MediaWikiService::getWikiId
	 */
	public function testGetWikiId() {
		$service = $this->service->setMethods( array( 'getGlobal' ) )->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'CityId' )
		    ->will   ( $this->returnValue( 7734 ) )
		;
		$this->assertEquals(
				7734,
				$service->getWikiId()
		);
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( false ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'SearchWikiId' )
		    ->will   ( $this->returnValue( 7735 ) )
		;
		$this->assertEquals(
				7735,
				$service->getWikiId()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09124 ms
	 * @covers \Wikia\Search\MediaWikiService::getMediaDataFromPageId
	 */
	public function testGetMediaDataFromPageId() {
		$service = $this->service->setMethods( array( 'pageIdHasFile', 'getFileForPageId' ) )->getMock();

		$mockFile = $this->getMockBuilder( 'File' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getMetadata' ) )
		                 ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdHasFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'',
				$service->getMediaDataFromPageId( $this->pageId ),
				'\WikiaSearch\MediaWikiService::getMediaDataFromPageId should return an empty string if the page id is not a file'
		);

		$serialized = serialize( array( 'foo' => 'bar' ) );

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdHasFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$mockFile
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMetadata' )
		    ->will   ( $this->returnValue( $serialized ) )
		;
		$this->assertEquals(
				$serialized,
				$service->getMediaDataFromPageId( $this->pageId ),
				'\WikiaSearch\MediaWikiService::getMediaDataFromPageId should return the serialized file metadata array for a file page id'
		);
	}

    /**
	 * @group Slow
	 * @slowExecutionTime 0.09431 ms
     * @covers\Wikia\Search\MediaWikiService::pageIdHasFile
     */
	public function testPageIdHasFile() {
		$service = $this->service->setMethods( array( 'getFileForPageId' ) )->getMock();

		$mockFile = $this->getMockBuilder( 'File' )
		                 ->disableOriginalConstructor()
		                 ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertFalse(
				$service->pageIdHasFile( $this->pageId )
		);
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$this->assertTrue(
				$service->pageIdHasFile( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.20025 ms
	 * @covers \Wikia\Search\MediaWikiService::getApiStatsForPageId
	 */
	public function testGetApiStatsForPageId() {
		$this->assertEquals(
				\ApiService::call( array(
        				'pageids'  => $this->pageId,
        				'action'   => 'query',
        				'prop'     => 'info',
        				'inprop'   => 'url|created|views|revcount',
        				'meta'     => 'siteinfo',
        				'siprop'   => 'statistics|wikidesc|variables|namespaces|category'
        		) ),
			    (new MediaWikiService)->getApiStatsForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.14909 ms
	 * @covers \Wikia\Search\MediaWikiService::getApiStatsForWiki
	 */
	public function testGetApiStatsForWiki() {
		global $wgCityId;
		$this->assertEquals(
				\ApiService::call( array(
						'action'   => 'query',
						'prop'     => 'info',
						'inprop'   => 'url|created|views|revcount',
						'meta'     => 'siteinfo',
						'siprop'   => 'statistics'
						) ),
			    (new MediaWikiService)->getApiStatsForWiki( $wgCityId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08778 ms
	 * @covers \Wikia\Search\MediaWikiService::pageIdExists
	 */
	public function testPageIdExists() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();
		$page = $this->getMockBuilder( 'Article' )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'exists' ) )
		             ->getMock();

		$mockException = $this->getMock( '\Exception' );

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->throwException( $mockException ) )
		;
		$this->assertFalse(
			$service->pageIdExists( $this->pageId ),
			'\WikiaSearch\MediaWikiService::pageExists should catch exceptions thrown by \WikiaSearch\MediaWikiService::getPageFromPageId and return false'
		);
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $page ) )
		;
		$page
		    ->expects( $this->at( 0 ) )
		    ->method ( 'exists' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertFalse(
				$service->pageIdExists( $this->pageId ),
				'\WikiaSearch\MediaWikiService::pageExists should pass the return value of Article::exists'
		);
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $page ) )
		;
		$page
		    ->expects( $this->at( 0 ) )
		    ->method ( 'exists' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$service->pageIdExists( $this->pageId ),
				'\WikiaSearch\MediaWikiService::pageExists should pass the return value of Article::exists'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.1391 ms
	 * @covers \Wikia\Search\MediaWikiService::getRedirectTitlesForPageId
	 */
	public function testGetRedirectTitlesForPageID() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();

		$mockDbr = $this->getMockBuilder( '\DatabaseMysqli' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'select', 'fetchObject' ) )
		                ->getMock();

		$mockGetDB = $this->getGlobalFunctionMock( 'wfGetDB' );

		$mockResult = $this->getMockBuilder( '\ResultWrapper' )
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$mockRow = (object) array( 'page_title' => 'Bar_Foo' );
		$titleKey = 'foo_page';
		$titleNs = 13;
		$titleMock = $this->getMockBuilder( '\Title' )
			->disableOriginalConstructor()
			->setMethods([ 'getDbKey', 'getNamespace' ])
			->getMock();
		$method = 'Wikia\Search\MediaWikiService::getRedirectTitlesForPageId';
		$fields = array( 'redirect', 'page' );
		$table = array( 'page_title' );
		$group = array( 'GROUP' => 'rd_title' );
		$join = array( 'page' => array( 'INNER JOIN', array( 'rd_title' => $titleKey, 'rd_namespace' => $titleNs, 'page_id = rd_from' ) ) );
		$expectedResult = array( 'Bar Foo' );

		$mockGetDB
		    ->expects( $this->once() )
		    ->method ( 'wfGetDB' )
		    ->with   ( DB_SLAVE )
		    ->will   ( $this->returnValue( $mockDbr ) )
		;
		$service
			->expects( $this->once() )
			->method ( 'getTitleFromPageId' )
			->with   ( $this->pageId )
			->will   ( $this->returnValue( $titleMock ) )
		;
		$titleMock
			->expects( $this->once() )
			->method ( 'getDbKey' )
			->will   ( $this->returnValue( $titleKey ) )
		;
		$titleMock
			->expects( $this->once() )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( $titleNs ) )
		;
		$mockDbr
		    ->expects( $this->at( 0 ) )
		    ->method ( 'select' )
		    ->with   ( $fields, $table, array(), $method, $group, $join )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDbr
		    ->expects( $this->at( 1 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $mockResult )
		    ->will   ( $this->returnValue( $mockRow ) )
		;
		$mockDbr
		    ->expects( $this->at( 2 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $mockResult )
		    ->will   ( $this->returnValue( null ) )
		;

		$this->assertEquals(
				$expectedResult,
				$service->getRedirectTitlesForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09684 ms
	 * @covers \Wikia\Search\MediaWikiService::getMediaDetailFromPageId
	 */
	public function testGetMediaDetailFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$fileHelper = $this->getMock( '\WikiaFileHelper' );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$detailArray = array( 'these my' => 'details' );

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$fileHelper::staticExpects( $this->any() )
		    ->method ( 'getMediaDetail' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $detailArray ) )
		;
		$this->mockClass( '\WikiaFileHelper', $fileHelper );
		$this->assertTrue(
				is_array( $service->getMediaDetailFromPageId( $this->pageId ) ),
				'\Wikia\Search\MediaWikiService::getMediaDetailFromPageId should return the array result of \WikiaFileHelper::getMediaDetail'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.10581 ms
	 * @covers \Wikia\Search\MediaWikiService::pageIdIsVideoFile
	 */
	public function testPageIdIsVideoFile() {
		$service = $this->service->setMethods( array( 'getFileForPageId' ) )->getMock();

		$mockFile = $this->getMockBuilder( '\LocalFile' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getHandler' ) )
		                 ->getMock();

		$mockVideoHandler = $this->getMockBuilder( '\VideoHandler' )->getMock();
		// again, mocking stuff we don't really want to here because of static methods
		$service
		    ->expects( $this->any() )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$mockFile
		    ->expects( $this->any() )
		    ->method ( 'getHandler' )
		    ->will   ( $this->returnValue( $mockVideoHandler ) )
		;
		$this->assertTrue(
				$service->pageIdIsVideoFile( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09202 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleKeyFromPageId
	 */
	public function testGetTitleKeyFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getDbKey' ) )
		              ->getMock();
		$dbKey = 'Foo_Bar_Baz';
		$service
		    ->expects( $this->any() )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $title ) )
		;
		$title
		    ->expects( $this->any() )
		    ->method ( 'getDbKey' )
		    ->will   ( $this->returnValue( $dbKey ) )
		;
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleKeyFromPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$dbKey,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleKeyFromPageId should return the db key for the canonical title associated with the provided page ID'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.16046 ms
	 * @covers \Wikia\Search\MediaWikiService::getFileForPageId
	 */
	public function testGetFileForPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$mockFile = $this->getMockBuilder( '\File' )
		                 ->disableOriginalConstructor()
		                 ->getMock();

		$mockFindFile = $this->getGlobalFunctionMock( 'wfFindFile' );

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockFindFile
		    ->expects( $this->at( 0 ) )
		    ->method ( 'wfFindFile' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getFileForPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockFile,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should return a file for the provided page ID'
		);
		$pageIdsToFiles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToFiles' );
		$pageIdsToFiles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockFile ),
				$pageIdsToFiles->getValue( $service ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should store the file instance keyed by page id'
		);
		$service
		    ->expects( $this->never() )
		    ->method ( 'getTitleStringFromPageId' )
		;
		$this->assertEquals(
				$mockFile,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should return a cached file for the provided page ID if already invoked'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.14926 ms
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageIdThrowsException() {
		$this->mockClass( 'Article', null, 'newFromID' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getPageFromPageId' );
		$get->setAccessible( true );
		try {
			$get->invoke( (new MediaWikiService), $this->pageId );
		} catch ( \Exception $e ) {}

		$this->assertInstanceOf(
				'\Exception',
				$e,
				'\Wikia\Search\MediaWikiService::getPageFromPageId should throw an exception when provided a nonexistent page id'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.16001 ms
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageCanonicalArticle() {
		$service = $this->service->getMock();
		$mockArticle = $this->getMockBuilder( '\Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( '__call' ) )
		                    ->getMock();

		$mockArticle
		    ->expects( $this->any() )
		    ->method ( '__call' )
		    ->with   ( 'isRedirect' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->mockClass( 'Article', $mockArticle );
		$this->mockClass( 'Article', $mockArticle, 'newFromID' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return an instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockArticle ),
				$pageIdsToArticles->getValue( $service ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache any instantiations of \Article for a canonical page ID'
		);
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided page id upon consecutive invocations'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.16608 ms
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageRedirectArticle() {
		ini_set('xdebug.var_display_max_depth',4);
		$service = $this->service->getMock();
		$mockArticle = $this->getMockBuilder( '\Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( '__call', 'getRedirectTarget', 'getID' ) )
		                    ->getMock();
		$mockTitle = $this->getMockBuilder( '\Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$pageId2 = 321;
		$mockArticle
		    ->expects( $this->at( 0 ) )
		    ->method ( '__call' )
		    ->with   ( 'isRedirect' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockArticle
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getRedirectTarget' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockArticle
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getID' )
		    ->will   ( $this->returnValue( $pageId2 ) )
		;
		$this->mockClass( 'Article', $mockArticle, 'newFromID' );
		$this->mockClass( 'Article', $mockArticle );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertSame(
				$mockArticle,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return the canonical instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertArrayHasKey(
				$pageId2,
				$pageIdsToArticles->getValue( $service ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToArticles->getValue( $service ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertSame(
				$mockArticle,
				$get->invoke( $service, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided redirect page id upon consecutive invocations'
		);
		$this->assertSame(
				$mockArticle,
				$get->invoke( $service, $pageId2 ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided canonical page id upon consecutive invocations, even if the redirect was accessed'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08691 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 */
	public function testGetTitleStringDefault() {
		$service = $this->service->getMock();

		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getFullText', 'getNamespace' ) )
		              ->getMock();

		$title
		    ->expects( $this->once() )
		    ->method ( 'getFullText' )
		    ->will   ( $this->returnValue( 'title' ) )
		;
		$title
		    ->expects( $this->once() )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_MAIN ) )
		;
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'title',
				$get->invoke( $service, $title )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.1397 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 */
	public function testGetTitleStringChildWallMessage() {
		$service = $this->service->getMock();

		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getArticleID', 'getNamespace', 'getFullText' ) )
		              ->getMock();

		$wm = $this->getMockBuilder( '\WallMessage' )
		           ->disableOriginalConstructor()
		           ->setMethods( array( 'load', 'isMain', 'getTopParentObj', 'getMetaTitle' ) )
		           ->getMock();

		$title
			->expects( $this->once() )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;

		$title
			->expects( $this->once() )
			->method ( 'getArticleID' )
			->will    ( $this->returnValue( $this->pageId ) )
		;

		$wm
			->expects( $this->exactly( 2 ) )
			->method ( 'load' )
		;

		$wm
			->expects( $this->once() )
			->method ( 'isMain' )
			->will   ( $this->returnValue( false ) )
		;

		$wm
			->expects( $this->once() )
			->method ( 'getTopParentObj' )
			->will   ( $this->returnValue( $wm ) )
		;

		$wm
			->expects( $this->once() )
			->method ( 'getMetaTitle' )
			->will   ( $this->returnValue( 'wall message title' ) )
		;

		$this->mockClass( '\WallMessage', $wm, 'newFromId' );

		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $service, $title )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13248 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 */
	public function testGetTitleStringEmptyChildWallMessage() {
		$service = $this->service->getMock();

		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getArticleID', 'getNamespace', 'getFullText' ) )
		              ->getMock();

		$wm = $this->getMockBuilder( '\WallMessage' )
		           ->disableOriginalConstructor()
		           ->setMethods( array( 'load', 'isMain', 'getTopParentObj', 'getMetaTitle' ) )
		           ->getMock();

		$title
		    ->expects( $this->once() )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$title
		    ->expects( $this->once() )
		    ->method ( 'getArticleID' )
		    ->will    ( $this->returnValue( $this->pageId ) )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'load' )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'isMain' )
		    ->will   ( $this->returnValue( false ) )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'getTopParentObj' )
		    ->will   ( $this->returnValue( null ) )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'getMetaTitle' )
		    ->will   ( $this->returnValue( 'wall message title' ) )
		;
		$this->mockClass( '\WallMessage', $wm, 'newFromId' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $service, $title )
		);
	}

//	/**
//	 * @covers \Wikia\Search\MediaWikiService::getTitleString
//	 */
//	public function testGetTitleStringEmptyWallMessage() {
//		$service = $this->service->getMock();
//
//		$title = $this->getMockBuilder( '\Title' )
//		              ->disableOriginalConstructor()
//		              ->setMethods( array( 'getFullText', 'getNamespace' ) )
//		              ->getMock();
//
////		$title
////		    ->expects( $this->once() )
////		    ->method ( 'getFullText' )
////		    ->will   ( $this->returnValue( 'title' ) )
////		;
//		$title
//		    ->expects( $this->exactly( 2 ) )
//		    ->method ( 'getNamespace' )
//		    ->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
//		;
//		$title
//		    ->expects( $this->once() )
//		    ->method ( 'getArticleID' )
//		    ->will    ( $this->returnValue( $this->pageId ) )
//		;
//		$this->mockClass( '\WallMessage', null, 'newFromId' );

//		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
//		$get->setAccessible( true );
//		$this->assertEquals(
//				'wall message title',
//				$get->invoke( $service, $title )
//		);
//	}


	/**
	 * @group Slow
	 * @slowExecutionTime 0.13071 ms
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 **/
	public function testGetTitleStringMainWallMessage() {
		$service = $this->service->getMock();

		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getArticleID', 'getNamespace', 'getFullText' ) )
		              ->getMock();

		$wm = $this->getMockBuilder( '\WallMessage' )
		           ->disableOriginalConstructor()
		           ->setMethods( array( 'load', 'isMain', 'getTopParentObj', 'getMetaTitle' ) )
		           ->getMock();

		$title
		    ->expects( $this->once() )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$title
		    ->expects( $this->once() )
		    ->method ( 'getArticleID' )
		    ->will    ( $this->returnValue( $this->pageId ) )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'load' )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'isMain' )
		    ->will   ( $this->returnValue( true ) )
		;
		$wm
		    ->expects( $this->once() )
		    ->method ( 'getMetaTitle' )
		    ->will   ( $this->returnValue( 'wall message title' ) )
		;
		$this->mockClass( '\WallMessage', $wm, 'newFromId' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $service, $title )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08616 ms
	 * @covers Wikia\Search\MediaWikiService::getNamespaceIdForString
	 */
	public function testGetNamespaceIdForString() {
		$this->assertEquals( NS_CATEGORY, (new MediaWikiService)->getNamespaceIdForString( 'Category' ) );
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.08865 ms
	 * @covers Wikia\Search\MediaWikiService::getGlobalForWiki
	 */
	public function testGetGlobalForWiki() {
		global $wgSitename, $wgCityId;
		$sitename = $wgSitename;
		$this->assertEquals(
				$wgSitename,
				(new MediaWikiService)->getGlobalForWiki( 'wgSitename', $wgCityId )
		);
		$this->assertEquals(
				$wgSitename,
				(new MediaWikiService)->getGlobalForWiki( 'Sitename', $wgCityId )
		);
		$wf = $this->getMock( 'WikiFactory', [ 'getVarValueByName' ] );
		$wf
		    ->staticExpects( $this->once() )
		    ->method ( 'getVarValueByName' )
		    ->with   ( 'wgFoo', 123 )
		    ->will   ( $this->returnValue( (object) [ 'cv_value' => serialize( [ 'bar' ] ) ] ) )
		;
		$this->mockClass( 'WikiFactory', $wf );
		$this->assertEquals(
				[ 'bar' ],
				(new MediaWikiService)->getGlobalForWiki( 'foo', 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.10373 ms
	 * @covers Wikia\Search\MediaWikiService::isSkinMobile
	 */
	public function testIsSkinMobile() {
		$user = $this->getMockBuilder( 'User' )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'getSkin' ) )
		             ->getMock();
		$skin = $this->getMockBuilder( '\SkinWikiaMobile' )
		             ->disableOriginalConstructor()
		             ->getMock();
		$user
		    ->expects( $this->once() )
		    ->method ( 'getSkin' )
		    ->will   ( $this->returnValue( $skin ) )
		;
		$app = (object) array( 'wg' => (object ) array( 'User' => $user ) );
		$service = $this->service->setMethods( null )->getMock();
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $service, $app );
		$this->assertTrue(
				$service->isSkinMobile()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08888 ms
	 * @covers Wikia\Search\MediaWikiService::isOnDbCluster
	 */
	public function testIsOnDbCluster() {
		$service = $this->service->setMethods( array( 'getGlobal' ) )->getMock();
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertFalse(
				$service->isOnDbCluster()
		);
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( 'this value just needs to not be empty' ) )
		;
		$this->assertTrue(
				$service->isOnDbCluster()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08666 ms
	 * @covers Wikia\Search\MediaWikiService::getDefaultNamespacesFromSearchEngine
	 */
	public function testGetDefaultNamespacesFromSearchEngine() {
		$this->assertEquals(
				\SearchEngine::defaultNamespaces(),
				(new MediaWikiService)->getDefaultNamespacesFromSearchEngine()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09002 ms
	 * @covers Wikia\Search\MediaWikiService::getSearchableNamespacesFromSearchEngine
	 */
	public function testGetSearchableNamespacesFromSearchEngine() {
		$this->assertEquals(
				\SearchEngine::searchableNamespaces(),
				(new MediaWikiService)->getSearchableNamespacesFromSearchEngine()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08619 ms
	 * @covers Wikia\Search\MediaWikiService::getTextForNamespaces
	 */
	public function testGetTextForNamespaces() {
		$this->assertEquals(
				\SearchEngine::namespacesAsText( array( 0, 14 ) ),
				(new MediaWikiService)->getTextForNamespaces( array( 0, 14 ) )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0894 ms
	 * @covers Wikia\Search\MediaWikiService::getFirstRevisionTimestampForPageId()
	 */
	public function testGetFirstRevisionTimestampForPageId() {
		$service = $this->service->setMethods( array( 'getFormattedTimestamp', 'getTitleFromPageId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFirstRevision' ) )
		                  ->getMock();
		$mockRev = $this->getMockBuilder( 'Revision' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getTimestamp' ) )
		                ->getMock();
		$timestamp = 'whatever o clock';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getFirstRevision' )
		    ->will   ( $this->returnValue( $mockRev ) )
		;
		$mockRev
		    ->expects( $this->once() )
		    ->method ( 'getTimestamp' )
		    ->will   ( $this->returnValue( $timestamp ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getFormattedTimestamp' )
		    ->with   ( $timestamp )
		    ->will   ( $this->returnValue( '11/11/11' ) )
		;
		$this->assertEquals(
				'11/11/11',
				$service->getFirstRevisionTimestampForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09075 ms
	 * @covers Wikia\Search\MediaWikiService::getSnippetForPageId
	 */
	public function testGetSnippetForPageId() {
		$mockservice = $this->getMock( 'ArticleService', array( 'getTextSnippet' ) );
		$service = $this->service->setMethods( array( 'getCanonicalPageIdFromPageId' ) )->getMock();
		$service
		    ->expects( $this->once() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $this->pageId ) )
		;
		$mockservice
		    ->expects( $this->once() )
		    ->method ( 'getTextSnippet' )
		    ->with   ( 250 )
		    ->will   ( $this->returnValue( 'snippet' ) )
		;
		$this->mockClass( 'ArticleService', $mockservice );
		$this->assertEquals(
				'snippet',
				$service->getSnippetForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09298 ms
	 * @covers Wikia\Search\MediaWikiService::getNonCanonicalTitleStringFromPageId
	 */
	public function testGetNonCanonicalTitleStringFromPageId() {
		$service = $this->service->setMethods( array( 'getTitleStringFromPageId', 'getTitleString' ) )->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$string = 'title';
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $string ) )
		;
		$this->assertEquals(
				$string,
				$service->getNonCanonicalTitleStringFromPageId( $this->pageId )
		);
		$reflRedirs = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'redirectArticles' );
		$reflRedirs->setAccessible( true );
		$reflRedirs->setValue( $service, array( $this->pageId => $mockArticle ) );
		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTitleString' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $string ) )
	    ;
		$this->assertEquals(
				$string,
				$service->getNonCanonicalTitleStringFromPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09138 ms
	 * @covers Wikia\Search\MediaWikiService::getNonCanonicalUrlFromPageId
	 */
	public function testGetNonCanonicalUrlFromPageId() {
		$service = $this->service->setMethods( array( 'getUrlFromPageId' ) )->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		$string = 'http://foo.wikia.com/wiki/Foo';
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getUrlFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $string ) )
		;
		$this->assertEquals(
				$string,
				$service->getNonCanonicalUrlFromPageId( $this->pageId )
		);
		$reflRedirs = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'redirectArticles' );
		$reflRedirs->setAccessible( true );
		$reflRedirs->setValue( $service, array( $this->pageId => $mockArticle ) );
		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getFullUrl' )
		    ->will   ( $this->returnValue( $string ) )
		;
		$this->assertEquals(
				$string,
				$service->getNonCanonicalUrlFromPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09557 ms
	 * @covers Wikia\Search\MediaWikiService::getArticleMatchForTermAndNamespaces
	 */
	public function testGetArticleMatchForTermAndNamespaces() {
		$service = $this->service->setMethods( array( 'getPageFromPageId' ) )->getMock();
		$mockEngine = $this->getMockBuilder( 'SearchEngine' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNearMatch' ) )
		                   ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getNamespace', 'getArticleId' ) )
		                  ->getMock();

		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$term = 'Foo';
		$namespaces = array( 0, 14 );

		$mockEngine
		    ->staticExpects( $this->at( 0 ) )
		    ->method       ( 'getNearMatch' )
		    ->with         ( $term )
		    ->will         ( $this->returnValue( null ) )
		;
		$this->mockClass( 'SearchEngine', $mockEngine );
		$this->mockClass( 'Wikia\Search\Match\Article', $mockMatch );
		$this->assertNull(
				$service->getArticleMatchForTermAndNamespaces( $term, $namespaces )
		);
		$mockEngine
		    ->staticExpects( $this->at( 0 ) )
		    ->method       ( 'getNearMatch' )
		    ->with         ( $term )
		    ->will         ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mockTitle
		    ->expects( $this->any() )
		    ->method ( 'getArticleId' )
		    ->will   ( $this->returnValue( $this->pageId ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		$this->mockClass( 'SearchEngine', $mockEngine );
		$this->mockClass( 'Wikia\Search\Match\Article', $mockMatch );
		$this->assertEquals(
				$service->getArticleMatchForTermAndNamespaces( $term, $namespaces ),
				$mockMatch
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09007 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostWithNoDomain() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode' ] );
		$mws
		    ->expects( $this->never() )
		    ->method ( 'getLanguageCode' )
		;
		$this->assertNull(
				$mws->getWikiMatchByHost( '' ),
				"Empty domain should return null"
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09183 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostNoWikiIdFound() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$mws
		    ->expects( $this->once() )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( \Wikia\Search\MediaWikiService::WIKI_DEFAULT_LANG_CODE ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'foo.wikia.com' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mws
		    ->expects( $this->never() )
		    ->method ( 'getWikiFromWikiId' )
		;
		$this->assertNull(
				$mws->getWikiMatchByHost( $host ),
				'If no wiki ID is found for a host, no match is returned'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0899 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostWorksDefaultLanguage() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$wiki = (object) [ 'city_public' => 1, 'city_lang' => 'en' ];
		$mws
		    ->expects( $this->once() )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( \Wikia\Search\MediaWikiService::WIKI_DEFAULT_LANG_CODE ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'foo.wikia.com' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiFromWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $wiki ) )
		;
		$this->assertInstanceOf(
				'Wikia\Search\Match\Wiki',
				$mws->getWikiMatchByHost( $host ),
				'A host that corresponds to a public wiki matching the current language should return a match'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08665 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostWorksForeignLanguage() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$wiki = (object) [ 'city_public' => 1, 'city_lang' => 'pl' ];
		$mws
		    ->expects( $this->at( 0 ) )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( 'pl' ) )
		;
		$mws
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'pl.foo.wikia.com' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mws
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getWikiFromWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $wiki ) )
		;
		$this->assertInstanceOf(
				'Wikia\Search\Match\Wiki',
				$mws->getWikiMatchByHost( $host ),
				'A host that corresponds to a public wiki matching the current language should return a match'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08709 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostForeignLanguageTld() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$wiki = (object) [ 'city_public' => 1, 'city_lang' => 'pl' ];
		$mws
		    ->expects( $this->at( 0 ) )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( 'pl' ) )
		;
		$mws
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'pl.foo.wikia.com' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mws
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'foo.pl' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mws
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getWikiFromWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $wiki ) )
		;
		$this->assertInstanceOf(
				'Wikia\Search\Match\Wiki',
				$mws->getWikiMatchByHost( $host ),
				'A host that corresponds to a public wiki matching the current language should return a match'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08804 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostClosedWiki() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$wiki = (object) [ 'city_public' => 0, 'city_lang' => 'en' ];
		$mws
		    ->expects( $this->once() )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( \Wikia\Search\MediaWikiService::WIKI_DEFAULT_LANG_CODE ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'foo.wikia.com' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiFromWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $wiki ) )
		;
		$this->assertNull(
				$mws->getWikiMatchByHost( $host ),
				'We should not return a wiki match for a wiki that is closed'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08925 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHostLanguageMismatch() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getLanguageCode', 'getWikiIdByHost', 'getWikiFromWikiId' ] );
		$host = 'foo';
		$wiki = (object) [ 'city_public' => 1, 'city_lang' => 'de' ];
		$mws
		    ->expects( $this->once() )
		    ->method ( "getLanguageCode" )
		    ->will   ( $this->returnValue( \Wikia\Search\MediaWikiService::WIKI_DEFAULT_LANG_CODE ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiIdByHost' )
		    ->with   ( 'foo.wikia.com' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mws
		    ->expects( $this->once() )
		    ->method ( 'getWikiFromWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $wiki ) )
		;
		$this->assertNull(
				$mws->getWikiMatchByHost( $host ),
				'We should not return a wiki match for a non language-matching wiki'
		);
	}


	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.08756 ms
	 * @covers Wikia\Search\MediaWikiService::getWikiFromWikiId
	 */
	public function testGetWikiFromWikiId() {
		$mockWf = $this->getMock( 'WikiFactory', [ 'getWikiById' ] );
		$wiki = (object) [ 'foo' => 'bar' ]; #values don't matter here
		$mws = new \Wikia\Search\MediaWikiService;
		$mockWf
		    ->staticExpects( $this->once() )
		    ->method       ( 'getWikiById' )
		    ->with         ( 123 )
		    ->will         ( $this->returnValue( $wiki ) )
		;
		$this->mockClass( 'WikiFactory', $mockWf );
		$refl = new ReflectionMethod( $mws, 'getWikiFromWikiId' );
		$refl->setAccessible( true );
		$this->assertEquals(
				$wiki,
				$refl->invoke( $mws, 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08833 ms
	 * @covers Wikia\Search\MediaWikiService::getMainPageUrlForWikiId
	 */
	public function testGetMainPageUrlForWikiId() {
		$service = $this->service->setMethods( array( 'getMainPageTitleForWikiId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'GlobalTitle' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		$url = 'http://foo.wikia.com/wiki/foo';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMainPageTitleForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getFullUrl' )
		    ->will   ( $this->returnValue( $url ) )
		;
		$this->assertEquals(
				$url,
				$service->getMainPageUrlForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08847 ms
	 * @covers Wikia\Search\MediaWikiService::getDbNameForWikiId
	 */
	public function testGetDbNameForWikiId() {
		$service = $this->service->setMethods( array( 'getDataSourceForWikiId' ) )->getMock();
		$mockSource = $this->getMockBuilder( 'WikiaDataSource' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getDbName' ) )
		                   ->getMock();
		$dbName = 'foo';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getDataSourceForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $mockSource ) )
		;
		$mockSource
		    ->expects( $this->once() )
		    ->method ( 'getDbName' )
		    ->will   ( $this->returnValue( $dbName ) )
		;
		$reflGet = new ReflectionMethod( 'Wikia\Search\MediaWikiService', 'getDbNameForWikiId' );
		$reflGet->setAccessible( true );
		$this->assertEquals(
				$dbName,
				$reflGet->invoke( $service, 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13295 ms
	 * @covers Wikia\Search\MediaWikiService::getLastRevisionTimestampForPageId()
	 */
	public function testGetLastRevisionTimestampForPageId() {
		$service = $this->service->setMethods( array( 'getFormattedTimestamp', 'getTitleFromPageId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getLatestRevId' ) )
		                  ->getMock();
		$mockRev = $this->getMockBuilder( 'Revision' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getTimestamp' ) )
		                ->getMock();
		$timestamp = 'whatever o clock';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getLatestRevId' )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$mockRev
		    ->expects( $this->once() )
		    ->method ( 'getTimestamp' )
		    ->will   ( $this->returnValue( $timestamp ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getFormattedTimestamp' )
		    ->with   ( $timestamp )
		    ->will   ( $this->returnValue( '11/11/11' ) )
		;
		$this->mockClass( 'Revision', $mockRev, 'newFromId' );
		$this->assertEquals(
				'11/11/11',
				$service->getLastRevisionTimestampForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12891 ms
	 * @covers Wikia\Search\MediaWikiService::getMediaWikiFormattedTimestamp
	 */
	public function testGetMediaWikiFormattedTimestamp() {
		$service = $this->service->setMethods( null )->getMock();
		$lang = $this->getMockBuilder( 'Language' )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'date' ) )
		             ->getMock();

		$mockTimestamp = $this->getGlobalFunctionMock( 'wfTimestamp' );

		$app = (object) array( 'wg' => (object) array( 'Lang' => $lang ) );
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $service, $app );

		$mockTimestamp
		    ->expects( $this->once() )
		    ->method ( 'wfTimestamp' )
		    ->with   ( TS_MW, '11/11/11' )
		    ->will   ( $this->returnValue( 'timestamp' ) )
		;
		$lang
		    ->expects( $this->once() )
		    ->method ( 'date' )
		    ->with   ( 'timestamp' )
		    ->will   ( $this->returnValue( 'mw formatted timestamp' ) )
		;
		$this->assertEquals(
				'mw formatted timestamp',
				$service->getMediaWikiFormattedTimestamp( '11/11/11' )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08929 ms
	 * @covers Wikia\Search\MediaWikiService::searchSupportsCurrentLanguage
	 */
	public function testSearchSupportsCurrentLanguage() {
		$service = $this->service->setMethods( array( 'searchSupportsLanguageCode', 'getLanguageCode' ) )->getMock();
		$service
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'searchSupportsLanguageCode' )
		    ->with   ( 'en' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$service->searchSupportsCurrentLanguage()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09356 ms
	 * @covers Wikia\Search\MediaWikiService::getThumbnailUrl
	 */
	public function testGetThumbnailUrl() {
		$mockImgServing = $this->getMockBuilder( 'ImageServing' )
			->disableOriginalConstructor()
			->setMethods( array( 'getImages' ) )
			->getMock();

		$url = 'http://some.test.url';
		$service = $this->service->setMethods( array( 'getImageServing' ) )->getMock();
		$mockImgServing
			->expects( $this->any() )
			->method ( 'getImages' )
			->will	 ( $this->returnValue( array( 0 => array( 0 => array( 'url' => 'http://some.test.url' ) ) ) ) )
		;

		$service
			->expects( $this->at( 0 ) )
			->method ( 'getImageServing' )
			->with	 ( 0, 100, 100 )
			->will	 ( $this->returnValue( $mockImgServing ) )
		;

		$this->assertEquals(
			$url,
			$service->getThumbnailUrl( 0, array( 'width' => 100, 'height' => 100 ) )
		);

		$service
			->expects( $this->at( 0 ) )
			->method ( 'getImageServing' )
			->with	 ( 0, 100, MediaWikiService::THUMB_DEFAULT_HEIGHT )
			->will	 ( $this->returnValue( $mockImgServing ) )
		;

		$this->assertEquals(
			$url,
			$service->getThumbnailUrl( 0, array( 'width' => 100 ) )
		);

		$service
			->expects( $this->at( 0 ) )
			->method ( 'getImageServing' )
			->with	 ( 0, MediaWikiService::THUMB_DEFAULT_WIDTH, 100 )
			->will	 ( $this->returnValue( $mockImgServing ) )
		;

		$this->assertEquals(
			$url,
			$service->getThumbnailUrl( 0, array( 'height' => 100 ) )
		);

		$service
			->expects( $this->at( 0 ) )
			->method ( 'getImageServing' )
			->with	 ( 0, MediaWikiService::THUMB_DEFAULT_WIDTH, MediaWikiService::THUMB_DEFAULT_HEIGHT )
			->will	 ( $this->returnValue( $mockImgServing ) )
		;

		$this->assertEquals(
			$url,
			$service->getThumbnailUrl( 0 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08881 ms
	 * @covers Wikia\Search\MediaWikiService::getThumbnailUrl
	 */
	public function testGetThumbnailUrlNoResults() {
		$mockImgServing = $this->getMockBuilder( 'ImageServing' )
			->disableOriginalConstructor()
			->setMethods( array( 'getImages' ) )
			->getMock();
		$service = $this->service->setMethods( array( 'getImageServing' ) )->getMock();

		$service
			->expects( $this->once() )
			->method ( 'getImageServing' )
			->with	 ( 0, MediaWikiService::THUMB_DEFAULT_WIDTH, MediaWikiService::THUMB_DEFAULT_HEIGHT )
			->will	 ( $this->returnValue( $mockImgServing ) )
		;

		$mockImgServing
			->expects( $this->once() )
			->method ( 'getImages' )
			->will	 ( $this->returnValue( false ) )
		;

		$this->assertEquals(
			false,
			$service->getThumbnailUrl( 0 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.10257 ms
	 * @covers Wikia\Search\MediaWikiService::getThumbnailHtml
	 */
	public function testGetThumbnailHtml() {
		$service = $this->service->setMethods( array( 'getImageServing', 'getFileForPageId' ) )->getMock();
		$imgObj = $this->getMockBuilder( 'WikiaLocalFile' )
			->disableOriginalConstructor()
			->setMethods( array( 'transform' ) )
			->getMock();
		//	ThumbnailImage
		$thumbObj = $this->getMockBuilder( 'ThumbnailVideo' )
			->disableOriginalConstructor()
			->setMethods( array( 'toHtml' ) )
			->getMock();
		//default value return ''
		$service
			->expects	( $this->at( 0 ) )
			->method	( 'getFileForPageId' )
			->with		( 0 )
			->will		( $this->returnValue( false ) )
		;
		$this->assertEmpty(
			$service->getThumbnailHtml( 0 )
		);
		//something returned
		$service
			->expects	( $this->at( 0 ) )
			->method	( 'getFileForPageId' )
			->with		( 0 )
			->will		( $this->returnValue( $imgObj ) )
		;
		$imgObj
			->expects	( $this->at( 0 ) )
			->method	( 'transform' )
			->with		( array( 'width' => MediaWikiService::THUMB_DEFAULT_WIDTH, 'height' => MediaWikiService::THUMB_DEFAULT_HEIGHT ) )
			->will		( $this->returnValue( $thumbObj ) )
		;
		$thumbObj
			->expects	( $this->at( 0 ) )
			->method	( 'toHtml' )
			->with		( array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) )
			->will		( $this->returnValue( '<html></html>' ) )
		;
		$this->assertEquals(
			'<html></html>',
			$service->getThumbnailHtml( 0 )
		);

		$service
			->expects	( $this->at( 0 ) )
			->method	( 'getFileForPageId' )
			->with		( 0 )
			->will		( $this->returnValue( $imgObj ) )
		;
		$imgObj
			->expects	( $this->at( 0 ) )
			->method	( 'transform' )
			->with		( array( 'width' => MediaWikiService::THUMB_DEFAULT_WIDTH, 'height' => 100 ) )
			->will		( $this->returnValue( $thumbObj ) )
		;
		$thumbObj
			->expects	( $this->at( 0 ) )
			->method	( 'toHtml' )
			->with		( array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) )
			->will		( $this->returnValue( '<html></html>' ) )
		;
		$this->assertEquals(
			'<html></html>',
			$service->getThumbnailHtml( 0, array( 'height' => 100 ) )
		);

		$service
			->expects	( $this->at( 0 ) )
			->method	( 'getFileForPageId' )
			->with		( 0 )
			->will		( $this->returnValue( $imgObj ) )
		;
		$imgObj
			->expects	( $this->at( 0 ) )
			->method	( 'transform' )
			->with		( array( 'width' => 100, 'height' => MediaWikiService::THUMB_DEFAULT_HEIGHT ) )
			->will		( $this->returnValue( $thumbObj ) )
		;
		$thumbObj
			->expects	( $this->at( 0 ) )
			->method	( 'toHtml' )
			->with		( array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) )
			->will		( $this->returnValue( '<html></html>' ) )
		;
		$this->assertEquals(
			'<html></html>',
			$service->getThumbnailHtml( 0, array( 'width' => 100 ) )
		);

		$service
			->expects	( $this->at( 0 ) )
			->method	( 'getFileForPageId' )
			->with		( 0 )
			->will		( $this->returnValue( $imgObj ) )
		;
		$imgObj
			->expects	( $this->at( 0 ) )
			->method	( 'transform' )
			->with		( array( 'width' => 1, 'height' => 1 ) )
			->will		( $this->returnValue( $thumbObj ) )
		;
		$thumbObj
			->expects	( $this->at( 0 ) )
			->method	( 'toHtml' )
			->with		( array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) )
			->will		( $this->returnValue( '<html></html>' ) )
		;
		$this->assertEquals(
			'<html></html>',
			$service->getThumbnailHtml( 0, array( 'width' => 1, 'height' => 1 ) )
		);
	}
	/**
	 * @group Slow
	 * @slowExecutionTime 0.22076 ms
	 * @covers Wikia\Search\MediaWikiService::getThumbnailHtmlFromFileTitle
	 */
	public function testGetThumbnailHtmlFromFileTitle() {
		$service = $this->service->setMethods( null )->getMock();
		$title = $this->getMock( 'Title' );

		$this->getStaticMethodMock( 'Title', 'newFromText' )
			->expects( $this->once() )
			->method( 'newFromText' )
			->with( 'x', NS_FILE )
			->will( $this->returnValue($title) );

		$this->getStaticMethodMock( 'WikiaFileHelper', 'getVideoThumbnailHtml' )
			->expects( $this->once() )
			->method( 'getVideoThumbnailHtml' )
			->with( $title, 12, 13, false )
			->will( $this->returnValue( 'bar' ) );

		$this->assertEquals(
			'bar',
			$service->getThumbnailHtmlFromFileTitle( 'x', array( 'width' => 12, 'height' => 13 ) )
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09379 ms
	 * @covers Wikia\Search\MediaWikiService::getVideoViewsForPageId
	 */
	public function testGetVideoViewsForPageId() {
		$service = $this->service->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getDBKey' ) )
		                  ->getMock();
		// i'm sure marissa mayer will love this
		$wfh = $this->getMockBuilder( 'WikiaFileHelper' )
		            ->disableOriginalConstructor()
		            ->setMethods( array( 'isFileTypeVideo' ) )
		            ->getMock();

		$mqs = $this->getMockBuilder( 'MediaQueryService' )
		            ->disableOriginalConstructor()
		            ->setMethods( array( 'getTotalVideoViewsByTitle' ) )
		            ->getMock();
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$wfh
		    ->staticExpects( $this->once() )
		    ->method ( 'isFileTypeVideo' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getDBKey' )
		    ->will   ( $this->returnValue( 'Foo_bar' ) )
		;
		$mqs
		    ->staticExpects( $this->once() )
		    ->method ( 'getTotalVideoViewsByTitle' )
		    ->with   ( 'Foo_bar' )
		    ->will   ( $this->returnValue( 1234 ) )
		;
		$this->mockClass( 'WikiaFileHelper', $wfh );
		$this->mockClass( 'MediaQueryService', $mqs );
		$this->assertEquals(
				1234,
				$service->getVideoViewsForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13485 ms
	 * @covers Wikia\Search\MediaWikiService::getFormattedVideoViewsForPageId
	 */
	public function testGetFormattedVideoViewsForPageId() {
		$service = $this->service->setMethods( array( 'getVideoViewsForPageId', 'formatNumber' ) )->getMock();

		$mockMsgExt = $this->getGlobalFunctionMock( 'wfMsgExt' );

		$service
		    ->expects( $this->once() )
		    ->method ( 'getVideoViewsForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( 1234 ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'formatNumber' )
		    ->with   ( 1234 )
		    ->will   ( $this->returnValue( '1,234' ) )
		;
		$mockMsgExt
		    ->expects( $this->once() )
		    ->method ( 'wfMsgExt' )
		    ->with   ( 'videohandler-video-views', array( 'parsemag' ), '1,234' )
		    ->will   ( $this->returnValue( '1,234 views' ) )
		;
		$this->assertEquals(
				'1,234 views',
				$service->getFormattedVideoViewsForPageId( $this->pageId )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09123 ms
	 * @covers Wikia\Search\MediaWikiService::formatNumber
	 */
	public function testFormatNumber() {
		$service = $this->service->setMethods( null )->getMock();

		$lang = $this->getMockBuilder( "Language" )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'formatNum' ) )
		             ->getMock();

		$lang
		    ->expects( $this->once() )
		    ->method ( 'formatNum' )
		    ->with   ( 10000 )
		    ->will   ( $this->returnValue( '10,000' ) )
		;
		$wg = (object) array( 'Lang' => $lang );
		$app = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$app->setAccessible( true );
		$app->setValue( $service, (object) array( 'wg' => $wg ) );
		$this->assertEquals(
				'10,000',
				$service->formatNumber( 10000 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09122 ms
	 * @covers Wikia\Search\MediaWikiService::getVisualizationInfoForWikiId
	 */
	public function testGetVisualizationInfoForWikiId() {
		$service = $this->service->setMethods( array( 'getLanguageCode' ) )->getMock();
		$model = $this->getMock( 'WikisModel', array( 'getDetails' ) );
		$details = [ 'yup' ];
		$info = [ 123 => $details ];
		$model
		    ->expects( $this->exactly( 2 ) )
		    ->method ( 'getDetails' )
		    ->will   ( $this->returnValueMap( [
				[ [ 123 ], true, $info ],
				[ [ 321 ], true, [] ]
			] ) )
		;
		$this->mockClass( 'WikisModel', $model );
		$this->assertEquals(
				$details,
				$service->getVisualizationInfoForWikiId( 123 )
		);
		$this->assertEquals(
			[],
			$service->getVisualizationInfoForWikiId( 321 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09316 ms
	 * @covers Wikia\Search\MediaWikiService::getStatsInfoForWikiId
	 */
	public function testGetStatsInfoForWikiId() {
		$service = $this->service->setMethods( null )->getMock();
		$wikisvc = $this->getMock( 'WikiService', array( 'getSiteStats', 'getTotalVideos' ) );

		$info = array( 'this' => 'yup' );
		$wikisvc
		    ->expects( $this->once() )
		    ->method ( 'getSiteStats' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $info ) )
		;
		$wikisvc
		    ->expects( $this->once() )
		    ->method ( 'getTotalVideos' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 4321 ) )
		;
		$this->mockClass( 'WikiService', $wikisvc );
		$method = new ReflectionMethod( 'Wikia\Search\MediaWikiService', 'getStatsInfoForWikiId' );
		$method->setAccessible( true );
		$this->assertEquals(
				array( 'this_count' => 'yup', 'videos_count' => 4321 ),
				$service->getStatsInfoForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13199 ms
	 * @covers Wikia\Search\MediaWikiService::getFormattedTimestamp
	 */
	public function testGetFormattedTimestamp() {
		$mockTimestamp = $this->getGlobalFunctionMock( 'wfTimestamp' );

		$service = $this->service->setMethods( null )->getMock();
		$timestamp = 'whatever';
		$mockTimestamp
		    ->expects( $this->once() )
		    ->method ( 'wfTimestamp' )
		    ->with   ( TS_ISO_8601, $timestamp )
		    ->will   ( $this->returnValue( 'result' ) )
		;
		$meth = $app = new ReflectionMethod( '\Wikia\Search\MediaWikiService' , 'getFormattedTimestamp' );
		$meth->setAccessible( true );
		$this->assertEquals(
				'result',
				$meth->invoke( $service, $timestamp )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09136 ms
	 * @covers Wikia\Search\MediaWikiService::getDataSourceForWikiId
	 */
	public function testGetDataSourceForWikiId() {
		$service = $this->service->setMethods( null )->getMock();
		$ds = $this->getMockBuilder( 'WikiDataSource' )
		           ->disableOriginalConstructor()
		           ->getMock();

		$this->mockClass( 'WikiDataSource', $ds );
		$meth = $app = new ReflectionMethod( '\Wikia\Search\MediaWikiService' , 'getDataSourceForWikiId' );
		$meth->setAccessible( true );
		$result = $meth->invoke( $service, 123 );
		$this->assertEquals(
				$result,
				$ds
		);
		$this->assertAttributeContains(
				$result,
				'wikiDataSources',
				$service
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.14423 ms
	 * @covers Wikia\Search\MediaWikiService::getMainPageTitleForWikiId
	 */
	public function testGetMainPageTitleForWikiId() {
		$service = $this->service->setMethods( [ 'getDbNameForWikiId', 'getGlobalForWiki' ] )->getMock();
		$apiservice = $this->getMock( 'ApiService', [ 'foreignCall' ] );
		$title = $this->getMockBuilder( 'GlobalTitle' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'isRedirect', 'getRedirectTarget' ] )
		              ->getMock();

		$service
		    ->expects( $this->once() )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgLanguageCode', 123 )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$fcArray = [ 'action' => 'query', 'meta' => 'allmessages', 'ammessages' => 'mainpage', 'amlang' => 'en' ];
		$responseArray = [ 'query' => ['allmessages' => [ ['*' => 'main' ] ] ] ];
		$apiservice
		    ->staticExpects( $this->once() )
		    ->method ( 'foreignCall' )
		    ->with   ( 'foo', $fcArray )
		    ->will   ( $this->returnValue( $responseArray ) )
		;
		$title
		    ->expects( $this->once() )
		    ->method ( 'isRedirect' )
		    ->will   ( $this->returnValue( true ) )
		;
		$title
		    ->expects( $this->once() )
		    ->method ( 'getRedirectTarget' )
		    ->will   ( $this->returnValue( $title ) )
		;
		$this->mockClass( 'ApiService', $apiservice );
		$this->mockClass( 'GlobalTitle', $title, 'newFromText' );
		$reflGet = new ReflectionMethod( 'Wikia\Search\MediaWikiService', 'getMainPageTitleForWikiId' );
		$reflGet->setAccessible( true );
		$result = $reflGet->invoke( $service, 123 );
		$this->assertEquals(
				$result,
				$title
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09433 ms
	 * @covers Wikia\Search\MediaWikiService::getDescriptionTextForWikiId
	 */
	public function testGetDescriptionTextForWikiId() {
		$service = $this->service->setMethods( [ 'getDbNameForWikiId', 'getGlobalForWiki' ] )->getMock();
		$apiservice = $this->getMock( 'ApiService', [ 'foreignCall' ] );


		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgLanguageCode', 123 )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$service
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgSitename', 123 )
		    ->will   ( $this->returnValue( 'foo wiki' ) )
		;
		$fcArray = [ 'action' => 'query', 'meta' => 'allmessages', 'ammessages' => 'description', 'amlang' => 'en' ];
		$responseArray = [ 'query' => ['allmessages' => [ ['*' => '{{SITENAME}} is a wiki' ] ] ] ];
		$apiservice
		    ->staticExpects( $this->once() )
		    ->method ( 'foreignCall' )
		    ->with   ( 'foo', $fcArray )
		    ->will   ( $this->returnValue( $responseArray ) )
		;
		$this->mockClass( 'ApiService', $apiservice );
		$this->assertEquals(
				'foo wiki is a wiki',
				$service->getDescriptionTextForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09148 ms
	 * @covers Wikia\Search\MediaWikiService::getHubForWikiId
	 */
	public function testGetHubForWikiId() {
		$service = $this->service->setMethods( null )->getMock();
		$hs = $this->getMock( 'HubService', [ 'getCategoryInfoForCity' ] );
		$hs
		    ->staticExpects( $this->once() )
		    ->method       ( 'getCategoryInfoForCity' )
		    ->with         ( 123 )
		    ->will         ( $this->returnValue( (object) [ 'cat_name' => 'Entertainment' ] ) )
		;
		$this->mockClass( 'HubService', $hs );
		$this->assertEquals(
				'Entertainment',
				$service->getHubForWikiId( 123 )
		);
	}


	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09163 ms
	 * @covers Wikia\Search\MediaWikiService::getSubHubForWikiId
	 */
	public function testGetSubHubForWikiId() {
		$service = $this->service->setMethods( null )->getMock();
		$wf = $this->getMock( 'WikiFactory', [ 'getCategory' ] );
		$wf
		    ->staticExpects( $this->once() )
		    ->method       ( 'getCategory' )
		    ->with         ( 123 )
		    ->will         ( $this->returnValue( (object) [ 'cat_name' => 'Entertainment' ] ) )
		;
		$this->mockClass( 'WikiFactory', $wf );
		$this->assertEquals(
				'Entertainment',
				$service->getSubHubForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.09473 ms
	 * @covers Wikia\Search\MediaWikiService::getMainPageTextForWikiId
	 */
	public function testGetMainPageTextForWikiId() {
		$service = $this->service->setMethods( [ 'getMainPageTitleForWikiId', 'getDbNameForWikiId' ] )->getMock();
		$apiservice = $this->getMock( 'ApiService', [ 'foreignCall' ] );
		$title = $this->getMockBuilder( 'GlobalTitle' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'getDbKey' ] )
		              ->getMock();

		$params = [ 'controller' => 'ArticlesApiController', 'method' => 'getDetails', 'titles' => 'Foo_bar' ];
		$title
		    ->expects( $this->once() )
		    ->method ( 'getDbKey' )
		    ->will   ( $this->returnValue( 'Foo_bar' ) )
		;
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMainPageTitleForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $title ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$responseArray = [ 'items' => [ [ 'abstract' => 'and if you dont know now you know' ] ] ];
		$apiservice
		    ->staticExpects( $this->once() )
		    ->method ( 'foreignCall' )
		    ->with   ( 'foo', $params, \ApiService::WIKIA )
		    ->will   ( $this->returnValue( $responseArray ) )
		;
		$this->mockClass( 'ApiService', $apiservice );
		$this->assertEquals(
				'and if you dont know now you know',
				$service->getMainPageTextForWikiId( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13325 ms
	 * @covers Wikia\Search\MediaWikiService::invokeHook
	 */
	public function testInvokeHook() {
		$service = $this->service->setMethods( null )->getMock();
		$mockRunHooks = $this->getGlobalFunctionMock( 'wfRunHooks' );
		$mockRunHooks
		    ->expects( $this->once() )
		    ->method ( 'wfRunHooks' )
		    ->with   ( 'onwhatever', [ 'foo', 123 ] )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$service->invokeHook( 'onwhatever', [ 'foo', 123 ] )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09113 ms
	 * @covers Wikia\Search\MediaWikiService::__construct
	 */
	public function test__construct() {
		$service = (new MediaWikiService);
		$this->assertAttributeEquals(
				\F::app(),
				'app',
				$service
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09036 ms
	 * @covers Wikia\Search\MediaWikiService::getHostName
	 */
	public function testGetHostName() {
		$service = (new MediaWikiService);
		$this->assertEquals(
				substr( $service->getGlobal( 'Server' ), 7 ),
				$service->getHostName()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0917 ms
	 * @covers Wikia\Search\MediaWikiService::isPageIdMainPage
	 */
	public function testPageIdIsMainPage() {
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getMainPageArticleId' ] );
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMainPageArticleId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$this->assertTrue(
				$mockService->isPageIdMainPage( 123 )
		);
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMainPageArticleId' )
		    ->will   ( $this->returnValue( 234 ) )
		;
		$this->assertFalse(
				$mockService->isPageIdMainPage( 123 )
		);
		$this->assertFalse(
				$mockService->isPageIdMainPage( 0 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13433 ms
	 * @covers Wikia\Search\MediaWikiService::shortNumForMsg
	 * @dataProvider dataShortNumForMsg
	 */
	public function testShortNumForMsg($number, $baseMessageId, $usedNumber, $usedMessageId) {
		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMessage' )
			->with( $usedMessageId, $usedNumber, $number )
			->will( $this->returnValue( 'mocked message' ) );

		$service = (new MediaWikiService);
		$this->assertEquals('mocked message', $service->shortNumForMsg($number, $baseMessageId));

	}

	public function dataShortNumForMsg() {
		return array(
			array(1, 'message-id', 1, 'message-id'),
			array(999, 'message-id', 999, 'message-id'),
			array(1000, 'message-id', 1, 'message-id-k'),
			array(999999, 'message-id', 999, 'message-id-k'),
			array(1000000, 'message-id', 1, 'message-id-M'),
			array(10000000000, 'message-id', 10000, 'message-id-M'),
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13412 ms
	 * @covers Wikia\Search\MediaWikiService::getSimpleMessage
	 */
	public function testGetSimpleMessage() {

		$mockWfMessage = $this->getGlobalFunctionMock( 'wfMessage' );
		$mockMessage = $this->getMockBuilder( 'Message' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'text' ) )
		                    ->getMock();

		$service = $this->service->setMethods( null )->getMock();
		$params = array( 'whatever' );
		$mockWfMessage
		    ->expects( $this->once() )
		    ->method ( 'wfMessage' )
		    ->with   ( 'foo', $params )
		    ->will   ( $this->returnValue( $mockMessage ) )
		;
		$mockMessage
		    ->expects( $this->once() )
		    ->method ( 'text' )
		    ->will   ( $this->returnValue( 'bar whatever' ) )
		;

		$this->assertEquals(
				'bar whatever',
				$service->getSimpleMessage( 'foo', $params )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.13765 ms
	 * @covers Wikia\Search\MediaWikiService::getDomainsForWikiId
	 */
	public function testGetDomainsForWikiId() {
		$mws = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal', 'getWikiId' ] );

		$mockDbr = $this->getMockBuilder( '\DatabaseMysqli' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'select', 'fetchObject' ) )
		                ->getMock();

		$mockGetDB = $this->getGlobalFunctionMock( 'wfGetDB' );

		$mockResult = $this->getMockBuilder( '\ResultWrapper' )
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$mockObject = (object) [ 'city_domain' => 'foo.wikia.com' ];

		$mws
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockGetDB
		    ->expects( $this->once() )
		    ->method ( 'wfGetDB' )
		    ->with   ( DB_SLAVE, [], true )
		    ->will   ( $this->returnValue( $mockDbr ) )
		;
		$mockDbr
		    ->expects( $this->at( 0 ) )
		    ->method ( 'select' )
		    ->with   ( [ 'city_domains' ], [ '*' ], [ 'city_id' => 123 ] )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDbr
		    ->expects( $this->at( 1 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $mockResult )
		    ->will   ( $this->returnValue( $mockObject ) )
		;
		$mockDbr
		    ->expects( $this->at( 2 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $mockResult )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertEquals(
				[ 'foo.wikia.com' ],
				$mws->getDomainsForWikiId( 123 )
		);
	}
}
