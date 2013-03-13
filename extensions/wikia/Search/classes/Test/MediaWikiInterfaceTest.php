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
	protected $interface;
	
	/**
	 * @var int
	 */
	protected $pageId;
	
	public function setUp() {
		parent::setUp();
		$this->pageId = 123;
		$this->interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
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
	 * @covers \Wikia\Search\MediaWikiService::getTitleStringFromPageId
	 */
	public function testGetTitleStringFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleString', 'getTitleFromPageId' ) )->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockTitleString = 'Mock Title';
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFrompageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getTitleString' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $mockTitleString ) )
		;
		$this->assertEquals(
				$mockTitleString,
				$interface->getTitleStringFrompageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleStringFromPageId should return the string value of a title based on a page ID'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getTitleFromPageId
	 */
	public function testGetTitleFromPageIdFreshPage() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$mockPage = $this->getMockBuilder( 'Article' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getTitle' ) )
		                 ->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$interface
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
				$getRefl->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should return an instance of Title corresponding to the provided page ID' 
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToTitles->getValue( $interface ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should store any titles it access for a page in the pageIdsToTitles array'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::getTitleFromPageId
	 */
	public function testGetTitleFromPageIdCachedPage() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$mockPage = $this->getMockBuilder( 'Article' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getTitle' ) )
		                 ->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$interface
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
		$pageIdsToTitles->setValue( $interface, array( $this->pageId => $mockTitle ) );
		
		$this->assertEquals(
				$mockTitle,
				$getRefl->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleFromPageId should return an instance of Title corresponding to the provided page ID' 
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsCanonical() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		
		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );
		
		$this->assertEquals(
				$this->pageId,
				$getCanonicalPageIdFromPageId->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsException() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		$ex = $this->getMockBuilder( '\Exception' )
		           ->disableOriginalConstructor()
		           ->getMock();
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->throwException( $ex ) )
		;
		
		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );
		
		$this->assertEquals(
				$this->pageId,
				$getCanonicalPageIdFromPageId->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if an exception is thrown'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsRedirect() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		
		$canonicalPageId = 54321;
		
		$redirectsToCanonicalIds = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'redirectsToCanonicalIds' );
		$redirectsToCanonicalIds->setAccessible( true );
		$redirectsToCanonicalIds->setValue( $interface, array( $this->pageId => $canonicalPageId ) );
		
		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );
		
		$this->assertEquals(
				$canonicalPageId,
				$getCanonicalPageIdFromPageId->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::isPageIdContent
	 */
	public function testIsPageIdContentYes() {
		$interface = $this->interface->setMethods( array( 'getNamespaceFromPageId', 'getGlobal' ) )->getMock();
		
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( NS_MAIN ) )
		;
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ContentNamespaces' )
		    ->will   ( $this->returnValue( array( NS_MAIN, NS_CATEGORY ) ) ) 
		;
		$this->assertTrue(
				$interface->isPageIdContent( $this->pageId )
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::isPageIdContent
	 */
	public function testIsPageIdContentNo() {
		$interface = $this->interface->setMethods( array( 'getNamespaceFromPageId', 'getGlobal' ) )->getMock();
		
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( NS_FILE ) )
		;
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ContentNamespaces' )
		    ->will   ( $this->returnValue( array( NS_MAIN, NS_CATEGORY ) ) ) 
		;
		$this->assertFalse(
				$interface->isPageIdContent( $this->pageId )
		);
	}
	
	/**
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
	 * @covers \Wikia\Search\MediaWikiService::getUrlFromPageId
	 */
	public function testGetUrlFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		
		$url = 'http://foo.wikia.com/wiki/Bar';
		
		$interface
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
				$interface->getUrlFromPageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getUrlFromPageId should return the full URL from the title instance associated with the provided page id'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::getNamespaceFromPageId
	 */
	public function testGetNamespaceFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getNamespace' ) )
		                  ->getMock();
		
		$interface
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
				$interface->getNamespaceFromPageId( $this->pageId ),
				'\Wikia\Search\MediaWikiService::getNamespaceFromPageId should return the namespace from the title instance associated with the provided page id'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getMainPageArticleId
	 */
	public function testGetMainPageArticleId() {
		$this->assertEquals(
				\Title::newMainPage()->getArticleId(),
				(new MediaWikiService)->getMainPageArticleId()
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getSimpleLanguageCode
	 */
	public function testGetsimpleLanguageCode() {
		$interface = $this->interface->setMethods( array( 'getLanguageCode' ) )->getMock();
		
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en-ca' ) )
		;
		$this->assertEquals(
				'en',
				$interface->getSimpleLanguageCode(),
				'\Wikia\Search\MediaWikiService::getSimpleLanguageCode should strip any extensions from the two-letter language code'
		);
	}
	
	/**
	 * Note: we actually expect an array here but since static method calls are tricky here 
	 * we're using proxyClass with translated version of a response array
	 * @covers \Wikia\Search\MediaWikiService::getParseResponseFromPageId
	 */
	public function testGetParseResponseFromPageId() {
		$mockApiService = $this->getMockBuilder( '\ApiService' )
		                       ->setMethods( array( 'call' ) )
		                       ->getMock();
		
		$mockResultArray = (object) array( 'foo' => 'bar' );
		
		// hack to make this work in our framework
		$this->proxyClass( '\ApiService', $mockResultArray, 'call' );
		$this->mockApp();
		
		$this->assertEquals(
				$mockResultArray,
				(new MediaWikiService)->getParseResponseFromPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getCacheKey
	 */
	public function testGetCacheKey() {
		$interface = $this->interface->setMethods( array( 'getWikiId' ) )->getMock();
		
		$mockWf = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'SharedMemcKey' ) )
		              ->getMock();
		
		$wid = 567;
		$key = 'foo';
		
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( $wid ) )
		;
		$mockWf
		    ->expects( $this->any() )
		    ->method ( 'SharedMemcKey' )
		    ->with   ( $key, $wid )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiService' , 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $mockWf ) );
		
		$this->assertEquals(
				'bar',
				$interface->getCacheKey( $key )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getCacheResult
	 */
	public function testGetCacheResult() {
		
		$interface = $this->interface->setMethods( array( 'getGlobal' ) )->getMock();
		
		$mockMc = $this->getMockBuilder( '\MemcachedClientForWiki' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'get' ) )
		               ->getMock();

		$key = 'bar';
		$result = 'foo';
		
		$interface
		    ->expects( $this->any() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Memc' )
		    ->will   ( $this->returnValue( $mockMc ) )
		;
		$mockMc
		    ->expects( $this->any() )
		    ->method ( 'get' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( $result ) )
		;
		$this->assertEquals(
				$result,
				$interface->getCacheResult( $key ),
				'\WikiaSearch\MediaWikiService::getCacheResult should provide an interface to $wgMemc->get()'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getCacheResultFromString
	 */
	public function testGetCacheResultFromString() {
		$interface = $this->interface->setMethods( array( 'getCacheResult', 'getCacheKey' ) )->getMock();
		
		$key = 'foo';
		$val = 'bar';
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCacheKey' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( sha1( $key ) ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getCacheResult' )
		    ->with   ( sha1( $key ) )
		    ->will   ( $this->returnValue( $val ) )
		;
		$this->assertEquals(
				$val,
				$interface->getCacheResultFromString( $key ),
				'\WikiaSearch\MediaWikiService::getCacheResultFromString should provide an interface for accessing a cached value from a plaintext key'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::setCacheFromStringKey
	 */
	public function testSetCacheFromStringKey() {
		
		$interface = $this->interface->setMethods( array( 'getCacheKey', 'getGlobal' ) )->getMock();
		
		$mockMc = $this->getMockBuilder( '\MemcachedClientForWiki' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'set' ) )
		               ->getMock();

		$key = 'bar';
		$value = 'foo';
		$ttl = 3600;
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Memc' )
		    ->will   ( $this->returnValue( $mockMc ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getCacheKey' )
		    ->with   ( $key )
		    ->will   ( $this->returnValue( sha1( $key ) ) )
		;
		$mockMc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'set' )
		    ->with   ( sha1( $key ), $value, $ttl )
		;
		$this->assertEquals(
				$interface,
				$interface->setCacheFromStringKey( $key, $value, $ttl ),
				'\WikiaSearch\MediaWikiService::setCacheResultForStringKey should set a cache value in memcached provided a given plaintext key'
		);
	}
	
	/**
	 * One day this test will actually work as advertised.
	 * @covers \Wikia\Search\MediaWikiService::getBacklinksCountFromPageId
	 */
	public function testGetBacklinksCountFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleStringFromPageId' ) )->getMock();
		
		$mockApiService = $this->getMock( '\ApiService', array( 'call' ) );
		
		$title = "Foo Bar";
		
		$data = array( 'query' => array( 'backlinks_count' => 0 ) );
		
		$interface
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
		
		$this->proxyClass( '\ApiService', $mockApiService );
		$this->mockClass( '\ApiService', $mockApiService );
		$this->mockApp();
		
		$this->assertEquals(
				0,
				$interface->getBacklinksCountFromPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getGlobal
	 */
	public function testGetGlobal() {
		$interface = new MediaWikiService;
		$app = \F::app();
		$app->wg->Foo = 'bar';
		
		$this->assertEquals(
				'bar',
				$interface->getGlobal( 'Foo' ),
				'\WikiaSearch\MediaWikiService::getGlobal should provide an interface to MediaWiki wg-prefixed global variables'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getGlobalWithDefault
	 */
	public function testGetGlobalWithDefault() {
		$interface = new MediaWikiService;
		$app = \F::app();
		$app->wg->Foo = null;
		
		$this->assertEquals(
				'bar',
				$interface->getGlobalWithDefault( 'Foo', 'bar' ),
				'\WikiaSearch\MediaWikiService::getGlobalWithDefault should return the default value if the global value is null.'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::setGlobal
	 */
	public function testSetGlobal() {
		$interface = new MediaWikiService;
		$app = \F::app();
		
		$this->assertEquals(
				$interface,
				$interface->setGlobal( 'Foo', 'bar' )
		);
		$this->assertEquals(
				'bar',
				$app->wg->Foo,
				'\WikiaSearch\MediaWikiService::setGlobal should set the provided key as a global variable name with the provided value'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getWikiId
	 */
	public function testGetWikiId() {
		$interface = $this->interface->setMethods( array( 'getGlobal' ) )->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'CityId' )
		    ->will   ( $this->returnValue( 7734 ) )
		;
		$this->assertEquals(
				7734,
				$interface->getWikiId()
		);
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( false ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'SearchWikiId' )
		    ->will   ( $this->returnValue( 7735 ) )
		;
		$this->assertEquals(
				7735,
				$interface->getWikiId()
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getMediaDataFromPageId
	 */
	public function testGetMediaDataFromPageId() {
		$interface = $this->interface->setMethods( array( 'pageIdHasFile', 'getFileForPageId' ) )->getMock();
		
		$mockFile = $this->getMockBuilder( 'File' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getMetadata' ) )
		                 ->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdHasFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'',
				$interface->getMediaDataFromPageId( $this->pageId ),
				'\WikiaSearch\MediaWikiService::getMediaDataFromPageId should return an empty string if the page id is not a file'
		);
		
		$serialized = serialize( array( 'foo' => 'bar' ) );
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdHasFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( true ) )
		;
		$interface
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
				$interface->getMediaDataFromPageId( $this->pageId ),
				'\WikiaSearch\MediaWikiService::getMediaDataFromPageId should return the serialized file metadata array for a file page id'
		);
	}

    /**
     * @covers\Wikia\Search\MediaWikiService::pageIdHasFile 
     */	
	public function testPageIdHasFile() {
		$interface = $this->interface->setMethods( array( 'getFileForPageId' ) )->getMock();
		
		$mockFile = $this->getMockBuilder( 'File' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertFalse(
				$interface->pageIdHasFile( $this->pageId )
		);
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$this->assertTrue(
				$interface->pageIdHasFile( $this->pageId )
		);
	}
	
	/**
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
	 * @covers \Wikia\Search\MediaWikiService::pageIdExists 
	 */
	public function testPageIdExists() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		$page = $this->getMockBuilder( 'Article' )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'exists' ) )
		             ->getMock();
		
		$mockException = $this->getMock( '\Exception' );
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->throwException( $mockException ) )
		;
		$this->assertFalse(
			$interface->pageIdExists( $this->pageId ),
			'\WikiaSearch\MediaWikiService::pageExists should catch exceptions thrown by \WikiaSearch\MediaWikiService::getPageFromPageId and return false'
		);
		$interface
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
				$interface->pageIdExists( $this->pageId ),
				'\WikiaSearch\MediaWikiService::pageExists should pass the return value of Article::exists'
		);
		$interface
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
				$interface->pageIdExists( $this->pageId ),
				'\WikiaSearch\MediaWikiService::pageExists should pass the return value of Article::exists'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getRedirectTitlesForPageId
	 */
	public function testGetRedirectTitlesForPageID() {
		$interface = $this->interface->setMethods( array( 'getTitleKeyFromPageId' ) )->getMock();
		
		$mockDbr = $this->getMockBuilder( '\DatabaseMysql' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'select', 'fetchObject' ) )
		                ->getMock();
		
		$mockWrapper = $this->getMockBuilder( '\WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'GetDB' ) )
		                    ->getMock();
		
		$mockResult = $this->getMockBuilder( '\ResultWrapper' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockRow = (object) array( 'page_title' => 'Bar_Foo' );
		$titleKey = 'Foo_Bar';
		$method = 'Wikia\Search\MediaWikiService::getRedirectTitlesForPageId';
		$fields = array( 'redirect', 'page' );
		$table = array( 'page_title' );
		$group = array( 'GROUP' => 'rd_title' );
		$join = array( 'page' => array( 'INNER JOIN', array( 'rd_title' => $titleKey, 'page_id = rd_from' ) ) );
		$expectedResult = array( 'Bar Foo' );
		
		$mockWrapper
		    ->expects( $this->once() )
		    ->method ( 'GetDB' )
		    ->with   ( DB_SLAVE )
		    ->will   ( $this->returnValue( $mockDbr ) )
		;
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getTitleKeyFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $titleKey ) )
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
		$reflApp = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, (object) array( 'wf' => $mockWrapper ) );
		
		$this->assertEquals(
				$expectedResult,
				$interface->getRedirectTitlesForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getMediaDetailFromPageId
	 */
	public function testGetMediaDetailFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$fileHelper = $this->getMock( '\WikiaFileHelper' );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$detailArray = array( 'these my' => 'details' );
		
		$interface
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
		$this->mockApp();
		$this->assertTrue(
				is_array( $interface->getMediaDetailFromPageId( $this->pageId ) ),
				'\Wikia\Search\MediaWikiService::getMediaDetailFromPageId should return the array result of \WikiaFileHelper::getMediaDetail'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::pageIdIsVideoFile
	 */
	public function testPageIdIsVideoFile() {
		$interface = $this->interface->setMethods( array( 'getFileForPageId' ) )->getMock();
		
		$mockFile = $this->getMockBuilder( '\LocalFile' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'getHandler' ) )
		                 ->getMock();
		
		$mockVideoHandler = $this->getMockBuilder( '\VideoHandler' )->getMock();
		// again, mocking stuff we don't really want to here because of static methods
		$interface
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
				$interface->pageIdIsVideoFile( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getTitleKeyFromPageId
	 */
	public function testGetTitleKeyFromPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getDbKey' ) )
		              ->getMock();
		$dbKey = 'Foo_Bar_Baz';
		$interface
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
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getTitleKeyFromPageId should return the db key for the canonical title associated with the provided page ID'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getFileForPageId
	 */
	public function testGetFileForPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId' ) )->getMock();
		$mockFile = $this->getMockBuilder( '\File' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		
		$mockWrapper = $this->getMockBuilder( '\WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'FindFile' ) )
		                    ->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockWrapper
		    ->expects( $this->at( 0 ) )
		    ->method ( 'FindFile' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $mockWrapper ) );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getFileForPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockFile,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should return a file for the provided page ID'
		);
		$pageIdsToFiles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToFiles' );
		$pageIdsToFiles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockFile ),
				$pageIdsToFiles->getValue( $interface ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should store the file instance keyed by page id'
		);
		$interface
		    ->expects( $this->never() )
		    ->method ( 'getTitleStringFromPageId' )
		;
		$this->assertEquals(
				$mockFile,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getFileForPageId should return a cached file for the provided page ID if already invoked'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageIdThrowsException() {
		$this->proxyClass( 'Article', null, 'newFromID' );
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
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageCanonicalArticle() {
		$interface = $this->interface->getMock();
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
		$this->proxyClass( 'Article', $mockArticle, 'newFromID' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return an instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockArticle ),
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache any instantiations of \Article for a canonical page ID'
		);
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided page id upon consecutive invocations'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getPageFromPageId
	 */
	public function testGetPageFromPageRedirectArticle() {
		$interface = $this->interface->getMock();
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
		$this->proxyClass( 'Article', $mockArticle, 'newFromID' );
		$this->proxyClass( 'Article', $mockArticle );
		$this->mockClass( 'Article', $mockArticle );
		$this->mockApp();
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return the canonical instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertArrayHasKey(
				$pageId2,
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiService::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided redirect page id upon consecutive invocations'
		);
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $pageId2 ),
				'\Wikia\Search\MediaWikiService::getPageFromPageId should return a cached instance of \Article for a provided canonical page id upon consecutive invocations, even if the redirect was accessed'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 */
	public function testGetTitleStringDefault() {
		$interface = $this->interface->getMock();
		
		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( '__toString', 'getNamespace' ) )
		              ->getMock();
		
		$title
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_MAIN ) )
		;
		$title
		    ->expects( $this->at( 1 ) )
		    ->method ( '__toString' )
		    ->will   ( $this->returnValue( 'title' ) )
		;
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'title',
				$get->invoke( $interface, $title )
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 */
	public function testGetTitleStringChildWallMessage() {
		$interface = $this->interface->getMock();
		
		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getArticleID', 'getNamespace', '__toString' ) )
		              ->getMock();
		
		$wm = $this->getMockBuilder( '\WallMessage' )
		           ->disableOriginalConstructor()
		           ->setMethods( array( 'load', 'isMain', 'getTopParentObj', 'getMetaTitle' ) )
		           ->getMock();
		
		$title
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$title
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getArticleID' )
		    ->will    ( $this->returnValue( $this->pageId ) )
		;
		$title
		    ->expects( $this->at( 2 ) )
		    ->method ( '__toString' )
		    ->will   ( $this->returnValue( 'wall message title' ) )
		;
		$wm
		    ->expects( $this->at( 0 ) )
		    ->method ( 'load' )
		;
		$wm
		    ->expects( $this->at( 1 ) )
		    ->method ( 'isMain' )
		    ->will   ( $this->returnValue( false ) )
		;
		$wm
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getTopParentObj' )
		    ->will   ( $this->returnValue( $wm ) )
		;
		$wm
		    ->expects( $this->at( 3 ) )
		    ->method ( 'load' )
		;
		$wm
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getMetaTitle' )
		    ->will   ( $this->returnValue( $title ) )
		;
		$this->proxyClass( '\WallMessage', $wm, 'newFromId' );
		$this->mockApp();
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $interface, $title )
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiService::getTitleString
	 **/
	public function testGetTitleStringMainWallMessage() {
		$interface = $this->interface->getMock();
		
		$title = $this->getMockBuilder( '\Title' )
		              ->disableOriginalConstructor()
		              ->setMethods( array( 'getArticleID', 'getNamespace', '__toString' ) )
		              ->getMock();
		
		$wm = $this->getMockBuilder( '\WallMessage' )
		           ->disableOriginalConstructor()
		           ->setMethods( array( 'load', 'isMain', 'getTopParentObj', 'getMetaTitle' ) )
		           ->getMock();
		
		$title
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespace' )
		    ->will   ( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$title
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getArticleID' )
		    ->will    ( $this->returnValue( $this->pageId ) )
		;
		$title
		    ->expects( $this->at( 2 ) )
		    ->method ( '__toString' )
		    ->will   ( $this->returnValue( 'wall message title' ) )
		;
		$wm
		    ->expects( $this->at( 0 ) )
		    ->method ( 'load' )
		;
		$wm
		    ->expects( $this->at( 1 ) )
		    ->method ( 'isMain' )
		    ->will   ( $this->returnValue( true ) )
		;
		$wm
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaTitle' )
		    ->will   ( $this->returnValue( $title ) )
		;
		$this->proxyClass( '\WallMessage', $wm, 'newFromId' );
		$this->mockApp();
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiService', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $interface, $title )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getNamespaceIdForString
	 */
	public function testGetNamespaceIdForString() {
		$this->assertEquals( NS_CATEGORY, (new MediaWikiService)->getNamespaceIdForString( 'Category' ) );
	}
	
	/**
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
		$this->proxyClass( 'WikiFactory', $wf );
		$this->mockApp();
		$this->assertEquals(
				[ 'bar' ],
				(new MediaWikiService)->getGlobalForWiki( 'foo', 123 )
		);
	}
	
	/**
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
		$interface = $this->interface->setMethods( null )->getMock();
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, $app );
		$this->assertTrue(
				$interface->isSkinMobile()
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::isOnDbCluster
	 */
	public function testIsOnDbCluster() {
		$interface = $this->interface->setMethods( array( 'getGlobal' ) )->getMock();
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertFalse(
				$interface->isOnDbCluster()
		);
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( 'this value just needs to not be empty' ) )
		;
		$this->assertTrue(
				$interface->isOnDbCluster()
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getDefaultNamespacesFromSearchEngine
	 */
	public function testGetDefaultNamespacesFromSearchEngine() {
		$this->assertEquals(
				\SearchEngine::defaultNamespaces(),
				(new MediaWikiService)->getDefaultNamespacesFromSearchEngine()
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getSearchableNamespacesFromSearchEngine
	 */
	public function testGetSearchableNamespacesFromSearchEngine() {
		$this->assertEquals(
				\SearchEngine::searchableNamespaces(),
				(new MediaWikiService)->getSearchableNamespacesFromSearchEngine()
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getTextForNamespaces
	 */
	public function testGetTextForNamespaces() {
		$this->assertEquals(
				\SearchEngine::namespacesAsText( array( 0, 14 ) ),
				(new MediaWikiService)->getTextForNamespaces( array( 0, 14 ) )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getFirstRevisionTimestampForPageId()
	 */
	public function testGetFirstRevisionTimestampForPageId() {
		$interface = $this->interface->setMethods( array( 'getFormattedTimestamp', 'getTitleFromPageId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFirstRevision' ) )
		                  ->getMock();
		$mockRev = $this->getMockBuilder( 'Revision' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getTimestamp' ) )
		                ->getMock();
		$timestamp = 'whatever o clock';
		$interface
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
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getFormattedTimestamp' )
		    ->with   ( $timestamp )
		    ->will   ( $this->returnValue( '11/11/11' ) )
		;
		$this->assertEquals(
				'11/11/11',
				$interface->getFirstRevisionTimestampForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getSnippetForPageId
	 */
	public function testGetSnippetForPageId() {
		$mockservice = $this->getMock( 'ArticleService', array( 'getTextSnippet' ) );
		$interface = $this->interface->setMethods( array( 'getCanonicalPageIdFromPageId' ) )->getMock();
		$interface
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
		$this->proxyClass( 'ArticleService', $mockservice );
		$this->mockApp();
		$this->assertEquals(
				'snippet',
				$interface->getSnippetForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getNonCanonicalTitleStringFromPageId
	 */
	public function testGetNonCanonicalTitleStringFromPageId() { 
		$interface = $this->interface->setMethods( array( 'getTitleStringFromPageId', 'getTitleString' ) )->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$string = 'title';
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $string ) )
		;
		$this->assertEquals(
				$string,
				$interface->getNonCanonicalTitleStringFromPageId( $this->pageId )
		);
		$reflRedirs = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'redirectArticles' );
		$reflRedirs->setAccessible( true );
		$reflRedirs->setValue( $interface, array( $this->pageId => $mockArticle ) );
		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getTitleString' )
		    ->with   ( $mockTitle )
		    ->will   ( $this->returnValue( $string ) )
	    ;
		$this->assertEquals(
				$string,
				$interface->getNonCanonicalTitleStringFromPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getNonCanonicalUrlFromPageId
	 */
	public function testGetNonCanonicalUrlFromPageId() { 
		$interface = $this->interface->setMethods( array( 'getUrlFromPageId' ) )->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		$string = 'http://foo.wikia.com/wiki/Foo';
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getUrlFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $string ) )
		;
		$this->assertEquals(
				$string,
				$interface->getNonCanonicalUrlFromPageId( $this->pageId )
		);
		$reflRedirs = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'redirectArticles' );
		$reflRedirs->setAccessible( true );
		$reflRedirs->setValue( $interface, array( $this->pageId => $mockArticle ) );
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
				$interface->getNonCanonicalUrlFromPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getArticleMatchForTermAndNamespaces
	 */
	public function testGetArticleMatchForTermAndNamespaces() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
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
		$this->proxyClass( 'SearchEngine', $mockEngine );
		$this->proxyClass( 'Wikia\Search\Match\Article', $mockMatch );
		$this->mockApp();
		$this->assertNull(
				$interface->getArticleMatchForTermAndNamespaces( $term, $namespaces )
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
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		$this->proxyClass( 'SearchEngine', $mockEngine );
		$this->proxyClass( 'Wikia\Search\Match\Article', $mockMatch );
		$this->mockApp();
		$this->assertInstanceOf(
				$interface->getArticleMatchForTermAndNamespaces( $term, $namespaces )->_mockClassName,
				$mockMatch
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getWikiMatchByHost
	 */
	public function testGetWikiMatchByHost() {
		$interface = $this->interface->setMethods( null )->getMock();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockWrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'GetDB' ) )
		                    ->getMock();
		
		$mockDb = $this->getMockBuilder( 'DatabaseMysql' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'select', 'fetchObject' ) )
		               ->getMock();
		
		$mockResult = $this->getMockBuilder( 'ResultWrapper' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockRow = (object) array( 'city_id' => 321 );
		$domain = 'foo';
		$db = 'foo';
		$wg = (object) array( 'ExternalSharedDB' => $db );
		$app = (object) array( 'wf' => $mockWrapper, 'wg' => $wg );
		
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, $app );
		
		$mockWrapper
		    ->expects( $this->once() )
		    ->method ( 'GetDB' )
		    ->with   ( DB_SLAVE, array(), $db )
		    ->will   ( $this->returnValue( $mockDb ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'select' )
		    ->with   ( array( 'city_domains' ), array( 'city_id' ), array( 'city_domain' => "{$domain}.wikia.com" ) )
		    ->will   ( $this->returnValue( $mockResult ) ) 
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'fetchObject' )
		    ->with   ( $mockResult ) 
		    ->will   ( $this->returnValue( $mockRow ) )
		;
		
		$this->proxyClass( 'Wikia\Search\Match\Wiki', $mockMatch );
		$this->mockApp();
		$this->assertInstanceOf(
				$interface->getWikiMatchByHost( $domain )->_mockClassName,
				$mockMatch
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getMainPageUrlForWikiId
	 */
	public function testGetMainPageUrlForWikiId() {
		$interface = $this->interface->setMethods( array( 'getMainPageTitleForWikiId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'GlobalTitle' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		$url = 'http://foo.wikia.com/wiki/foo';
		$interface
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
				$interface->getMainPageUrlForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getDbNameForWikiId
	 */
	public function testGetDbNameForWikiId() {
		$interface = $this->interface->setMethods( array( 'getDataSourceForWikiId' ) )->getMock();
		$mockSource = $this->getMockBuilder( 'WikiaDataSource' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getDbName' ) )
		                   ->getMock();
		$dbName = 'foo';
		$interface
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
				$reflGet->invoke( $interface, 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getLastRevisionTimestampForPageId()
	 */
	public function testGetLastRevisionTimestampForPageId() {
		$interface = $this->interface->setMethods( array( 'getFormattedTimestamp', 'getTitleFromPageId' ) )->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getLatestRevId' ) )
		                  ->getMock();
		$mockRev = $this->getMockBuilder( 'Revision' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getTimestamp' ) )
		                ->getMock();
		$timestamp = 'whatever o clock';
		$interface
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
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getFormattedTimestamp' )
		    ->with   ( $timestamp )
		    ->will   ( $this->returnValue( '11/11/11' ) )
		;
		$this->proxyClass( 'Revision', $mockRev, 'newFromId' );
		$this->mockApp();
		$this->assertEquals(
				'11/11/11',
				$interface->getLastRevisionTimestampForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getMediaWikiFormattedTimestamp
	 */
	public function testGetMediaWikiFormattedTimestamp() {
		$interface = $this->interface->setMethods( null )->getMock();
		$lang = $this->getMockBuilder( 'Language' )
		             ->disableOriginalConstructor()
		             ->setMethods( array( 'date' ) )
		             ->getMock();
		$wrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'Timestamp' ) )
		                ->getMock();
		
		$app = (object) array( 'wg' => (object) array( 'Lang' => $lang ), 'wf' => $wrapper );
		$reflApp = new ReflectionProperty( 'Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, $app );
		
		$wrapper
		    ->expects( $this->once() )
		    ->method ( 'Timestamp' )
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
				$interface->getMediaWikiFormattedTimestamp( '11/11/11' )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::searchSupportsCurrentLanguage
	 */
	public function testSearchSupportsCurrentLanguage() {
		$interface = $this->interface->setMethods( array( 'searchSupportsLanguageCode', 'getLanguageCode' ) )->getMock();
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$interface
		    ->expects( $this->once() )
		    ->method ( 'searchSupportsLanguageCode' )
		    ->with   ( 'en' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$interface->searchSupportsCurrentLanguage()
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getThumbnailHtmlForPageId
	 */
	public function testGetThumbnailHtmlForPageId() {
		$interface = $this->interface->setMethods( array( 'getFileForPageId' ) )->getMock();
		$mockFile = $this->getMockBuilder( 'File' )
		                 ->disableOriginalConstructor()
		                 ->setMethods( array( 'transform' ) )
		                 ->getMock();
		$mockTransform = $this->getMockBuilder( 'MediaTransformOutput' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'toHtml' ) )
		                      ->getMock();
		$html = 'this value does not matter';
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getFileForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$mockFile
		    ->expects( $this->once() )
		    ->method ( 'transform' )
		    ->with   ( array( 'width' => 160 ) )
		    ->will   ( $this->returnValue( $mockTransform ) )
		;
		$mockTransform
		    ->expects( $this->once() )
		    ->method ( 'toHtml' )
		    ->with   ( array('desc-link'=>true, 'img-class'=>'thumbimage', 'duration'=>true) )
		    ->will   ( $this->returnValue( $html ) )
		;
		$this->assertEquals(
				$html,
				$interface->getThumbnailHtmlForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getVideoViewsForPageId
	 */
	public function testGetVideoViewsForPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleFromPageId', 'formatNumber' ) )->getMock();
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
		
		$wrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'MsgExt' ) )
		                ->getMock();
		
		$interface
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
		$interface
		    ->expects( $this->once() )
		    ->method ( 'formatNumber' )
		    ->with   ( 1234 )
		    ->will   ( $this->returnValue( '1,234' ) )
		;
		$wrapper
		    ->expects( $this->once() )
		    ->method ( 'MsgExt' )
		    ->with   ( 'videohandler-video-views', array( 'parsemag' ), '1,234' )
		    ->will   ( $this->returnValue( '1,234 views' ) )
		;
		$reflApp = new ReflectionProperty( '\Wikia\Search\MediaWikiService', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, (object) array( 'wf' => $wrapper ) );
		$this->proxyClass( 'WikiaFileHelper', $wfh );
		$this->proxyClass( 'MediaQueryService', $mqs );
		$this->mockApp();
		$this->assertEquals(
				'1,234 views',
				$interface->getVideoViewsForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::formatNumber
	 */
	public function testFormatNumber() {
		$interface = $this->interface->setMethods( null )->getMock();
		
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
		$app->setValue( $interface, (object) array( 'wg' => $wg ) );
		$this->assertEquals(
				'10,000',
				$interface->formatNumber( 10000 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getVisualizationInfoForWikiId
	 */
	public function testGetVisualizationInfoForWikiId() {
		$interface = $this->interface->setMethods( array( 'getLanguageCode' ) )->getMock();
		$hph = $this->getMock( 'WikiaHomePageHelper', array( 'getWikiInfoForVisualization' ) );
		
		$info = array( 'yup' );
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$hph
		    ->expects( $this->once() )
		    ->method ( 'getWikiInfoForVisualization' )
		    ->with   ( 123, 'en' )
		    ->will   ( $this->returnValue( $info ) )
		;
		$this->proxyClass( 'WikiaHomePageHelper', $hph );
		$this->mockApp();
		$this->assertEquals(
				$info,
				$interface->getVisualizationInfoForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getStatsInfoForWikiId
	 */
	public function testGetStatsInfoForWikiId() {
		$interface = $this->interface->setMethods( null )->getMock();
		$hph = $this->getMock( 'WikiaHomePageHelper', array( 'getWikiStats' ) );
		
		$info = array( 'this' => 'yup' );
		$hph
		    ->expects( $this->once() )
		    ->method ( 'getWikiStats' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $info ) )
		;
		$this->proxyClass( 'WikiaHomePageHelper', $hph );
		$this->mockApp();
		$this->assertEquals(
				array( 'this_count' => 'yup' ),
				$interface->getStatsInfoForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getFormattedTimestamp
	 */
	public function testGetFormattedTimestamp() {
		$mockWf = $this->getMock( 'WikiaFunctionWrapper', array( 'Timestamp' ) );
		$interface = $this->interface->setMethods( null )->getMock();
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiService' , 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $mockWf ) );
		$timestamp = 'whatever';
		$mockWf
		    ->expects( $this->once() )
		    ->method ( 'Timestamp' )
		    ->with   ( TS_ISO_8601, $timestamp )
		    ->will   ( $this->returnValue( 'result' ) )
		;
		$meth = $app = new ReflectionMethod( '\Wikia\Search\MediaWikiService' , 'getFormattedTimestamp' );
		$meth->setAccessible( true );
		$this->assertEquals(
				'result',
				$meth->invoke( $interface, $timestamp )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getDataSourceForWikiId
	 */
	public function testGetDataSourceForWikiId() {
		$interface = $this->interface->setMethods( null )->getMock();
		$ds = $this->getMockBuilder( 'WikiDataSource' )
		           ->disableOriginalConstructor()
		           ->getMock();
		
		$this->proxyClass( 'WikiDataSource', $ds );
		$this->mockApp();
		$meth = $app = new ReflectionMethod( '\Wikia\Search\MediaWikiService' , 'getDataSourceForWikiId' );
		$meth->setAccessible( true );
		$result = $meth->invoke( $interface, 123 );
		$this->assertInstanceOf(
				$result->_mockClassName,
				$ds
		);
		$this->assertAttributeContains(
				$result,
				'wikiDataSources',
				$interface
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getMainPageTitleForWikiId
	 */
	public function testGetMainPageTitleForWikiId() {
		$interface = $this->interface->setMethods( [ 'getDbNameForWikiId', 'getGlobalForWiki' ] )->getMock();
		$service = $this->getMock( 'ApiService', [ 'foreignCall' ] );
		$title = $this->getMockBuilder( 'GlobalTitle' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'isRedirect', 'getRedirectTarget' ] )
		              ->getMock();
		
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$interface
		    ->expects( $this->once() )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgLanguageCode', 123 )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$fcArray = [ 'action' => 'query', 'meta' => 'allmessages', 'ammessages' => 'mainpage', 'amlang' => 'en' ];
		$responseArray = [ 'query' => ['allmessages' => [ ['*' => 'main' ] ] ] ];
		$service
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
		$this->proxyClass( 'ApiService', $service );
		$this->proxyClass( 'GlobalTitle', $title, 'newFromText' );
		$this->mockApp();
		$reflGet = new ReflectionMethod( 'Wikia\Search\MediaWikiService', 'getMainPageTitleForWikiId' );
		$reflGet->setAccessible( true );
		$result = $reflGet->invoke( $interface, 123 );
		$this->assertEquals(
				$result,
				$title
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getDescriptionTextForWikiId
	 */
	public function testGetDescriptionTextForWikiId() {
		$interface = $this->interface->setMethods( [ 'getDbNameForWikiId', 'getGlobalForWiki' ] )->getMock();
		$service = $this->getMock( 'ApiService', [ 'foreignCall' ] );
		
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgLanguageCode', 123 )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$interface
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgSitename', 123 )
		    ->will   ( $this->returnValue( 'foo wiki' ) )
		;
		$fcArray = [ 'action' => 'query', 'meta' => 'allmessages', 'ammessages' => 'description', 'amlang' => 'en' ];
		$responseArray = [ 'query' => ['allmessages' => [ ['*' => '{{SITENAME}} is a wiki' ] ] ] ];
		$service
		    ->staticExpects( $this->once() )
		    ->method ( 'foreignCall' )
		    ->with   ( 'foo', $fcArray )
		    ->will   ( $this->returnValue( $responseArray ) )
		;
		$this->proxyClass( 'ApiService', $service );
		$this->mockApp();
		$this->assertEquals(
				'foo wiki is a wiki',
				$interface->getDescriptionTextForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getHubForWikiId
	 */
	public function testGetHubForWikiId() {
		$interface = $this->interface->setMethods( null )->getMock();
		$wf = $this->getMock( 'WikiFactory', [ 'getCategory' ] );
		$wf
		    ->staticExpects( $this->once() )
		    ->method       ( 'getCategory' )
		    ->with         ( 123 )
		    ->will         ( $this->returnValue( (object) [ 'cat_name' => 'Entertainment' ] ) )
		;
		$this->proxyClass( 'WikiFactory', $wf );
		$this->mockApp();
		$this->assertEquals(
				'Entertainment',
				$interface->getHubForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::getMainPageTextForWikiId
	 */
	public function testGetMainPageTextForWikiId() {
		$interface = $this->interface->setMethods( [ 'getMainPageTitleForWikiId', 'getDbNameForWikiId' ] )->getMock();
		$service = $this->getMock( 'ApiService', [ 'foreignCall' ] );
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
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMainPageTitleForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $title ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getDbNameForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$responseArray = [ 'items' => [ [ 'abstract' => 'and if you dont know now you know' ] ] ];
		$service
		    ->staticExpects( $this->once() )
		    ->method ( 'foreignCall' )
		    ->with   ( 'foo', $params, \ApiService::WIKIA )
		    ->will   ( $this->returnValue( $responseArray ) )
		;
		$this->proxyClass( 'ApiService', $service );
		$this->mockApp();
		$this->assertEquals(
				'and if you dont know now you know',
				$interface->getMainPageTextForWikiId( 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::invokeHook
	 */
	public function testInvokeHook() {
		$interface = $this->interface->setMethods( null )->getMock();
		$wf = $this->getMock( 'WikiaFunctionWrapper', [ 'RunHooks' ] );
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiService' , 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $wf ) );
		$wf
		    ->expects( $this->once() )
		    ->method ( 'RunHooks' )
		    ->with   ( 'onwhatever', [ 'foo', 123 ] )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$interface->invokeHook( 'onwhatever', [ 'foo', 123 ] )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiService::__construct
	 */
	public function test__construct() {
		$interface = (new MediaWikiService);
		$this->assertAttributeEquals(
				\F::app(),
				'app',
				$interface
		);
	}
}