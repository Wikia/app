<?php
/**
 * Class definition for \Wikia\Search\Test\MediaWikiInterfaceTest
 * @author relwell
 */
namespace Wikia\Search\Test;
use Wikia\Search\MediaWikiInterface;
use \ReflectionProperty;
use \ReflectionMethod;
require_once( 'WikiaSearchBaseTest.php' );
/**
 * Tests the methods found in \Wikia\Search\MediaWikiInterface
 * @author relwell
 */
class MediaWikiInterfaceTest extends \WikiaSearchBasetest
{
	/**
	 * @var \Wikia\Search\MediaWikiInterface
	 */
	protected $interface;
	
	/**
	 * @var int
	 */
	protected $pageId;
	
	public function setUp() {
		parent::setUp();
		$this->pageId = 123;
		$this->interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiInterface' )
                                ->disableOriginalConstructor();
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getInstance
	 */
	public function testGetInstance() {
		$mockMediaWikiInterface = $this->interface->setMethods( array( 'foo' ) )
		                                          ->getMock();
		
		$instanceRefl = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'instance' );
		$instanceRefl->setAccessible( true );
		$instanceRefl->setValue( null );
		
		$instance = $mockMediaWikiInterface->getInstance();
		
		$this->assertInstanceOf(
				'\Wikia\Search\MediaWikiInterface',
				$instance,
				'\Wikia\Search\MediaWikiInterface::getInstance should create an instance of \Wikia\Search\MediaWikiInterface if one has not been constructed'
		);
		$this->assertNotEmpty(
				$instanceRefl->getValue(),
				'\Wikia\Search\MediaWikiInterface should store its singleton instance in \Wikia\Search\MediaWikiInterface::$instance'
		);
		$this->assertEquals(
				$instance,
				$mockMediaWikiInterface->getInstance(),
				'\Wikia\Search\MediaWikiInterface should return its stored instance on subsequent calls to getInstance()'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleStringFromPageId
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
				'\Wikia\Search\MediaWikiInterface::getTitleStringFromPageId should return the string value of a title based on a page ID'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleFromPageId
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
		
		$getRefl = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleFromPageId' );
		$getRefl->setAccessible( true );

		$pageIdsToTitles = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'pageIdsToTitles' );
		$pageIdsToTitles->setAccessible( true ) ;
		
		$this->assertEquals(
				$mockTitle,
				$getRefl->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getTitleFromPageId should return an instance of Title corresponding to the provided page ID' 
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToTitles->getValue( $interface ),
				'\Wikia\Search\MediaWikiInterface::getTitleFromPageId should store any titles it access for a page in the pageIdsToTitles array'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleFromPageId
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
		
		$getRefl = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleFromPageId' );
		$getRefl->setAccessible( true );

		$pageIdsToTitles = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'pageIdsToTitles' );
		$pageIdsToTitles->setAccessible( true );
		$pageIdsToTitles->setValue( $interface, array( $this->pageId => $mockTitle ) );
		
		$this->assertEquals(
				$mockTitle,
				$getRefl->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getTitleFromPageId should return an instance of Title corresponding to the provided page ID' 
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsCanonical() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		
		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );
		
		$this->assertEquals(
				$this->pageId,
				$getCanonicalPageIdFromPageId->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::getCanonicalPageIdFromPageId
	 */
	public function testGetCanonicalPageIdFromPageIdIsRedirect() {
		$interface = $this->interface->setMethods( array( 'getPageFromPageId' ) )->getMock();
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPageFromPageId' )
		    ->with   ( $this->pageId )
		;
		
		$canonicalPageId = 54321;
		
		$redirectsToCanonicalIds = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'redirectsToCanonicalIds' );
		$redirectsToCanonicalIds->setAccessible( true );
		$redirectsToCanonicalIds->setValue( $interface, array( $this->pageId => $canonicalPageId ) );
		
		$getCanonicalPageIdFromPageId = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getCanonicalPageIdFromPageId' );
		$getCanonicalPageIdFromPageId->setAccessible( true );
		
		$this->assertEquals(
				$canonicalPageId,
				$getCanonicalPageIdFromPageId->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getCanonicalPageIdFromPageId should return the value provided to it if a value is not stored in the redirect ID array'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::isPageIdContent
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
	 * @covers \Wikia\Search\MediaWikiInterface::isPageIdContent
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
	 * @covers \Wikia\Search\MediaWikiInterface::getLanguageCode
	 */
	public function testGetLanguageCode() {
		global $wgContLang;
		$this->assertEquals(
				$wgContLang->getCode(),
				MediaWikiInterface::getInstance()->getLanguageCode(),
				'\Wikia\Search\MediaWikiInterface::getLanguageCode should provide an interface to $wgContLang->getCode()'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getUrlFromPageId
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
				'\Wikia\Search\MediaWikiInterface::getUrlFromPageId should return the full URL from the title instance associated with the provided page id'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::getNamespaceFromPageId
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
				'\Wikia\Search\MediaWikiInterface::getNamespaceFromPageId should return the namespace from the title instance associated with the provided page id'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getMainPageArticleId
	 */
	public function testGetMainPageArticleId() {
		$this->assertEquals(
				\Title::newMainPage()->getArticleId(),
				MediaWikiInterface::getInstance()->getMainPageArticleId()
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getSimpleLanguageCode
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
				'\Wikia\Search\MediaWikiInterface::getSimpleLanguageCode should strip any extensions from the two-letter language code'
		);
	}
	
	/**
	 * Note: we actually expect an array here but since static method calls are tricky here 
	 * we're using proxyClass with translated version of a response array
	 * @covers \Wikia\Search\MediaWikiInterface::getParseResponseFromPageId
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
				MediaWikiInterface::getInstance()->getParseResponseFromPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getCacheKey
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
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface' , 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $mockWf ) );
		
		$this->assertEquals(
				'bar',
				$interface->getCacheKey( $key )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getCacheResult
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
				'\WikiaSearch\MediaWikiInterface::getCacheResult should provide an interface to $wgMemc->get()'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getCacheResultFromString
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
				'\WikiaSearch\MediaWikiInterface::getCacheResultFromString should provide an interface for accessing a cached value from a plaintext key'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::setCacheFromStringKey
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
				'\WikiaSearch\MediaWikiInterface::setCacheResultForStringKey should set a cache value in memcached provided a given plaintext key'
		);
	}
	
	/**
	 * One day this test will actually work as advertised.
	 * @covers \Wikia\Search\MediaWikiInterface::getBacklinksCountFromPageId
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
	 * @covers \Wikia\Search\MediaWikiInterface::getGlobal
	 */
	public function testGetGlobal() {
		$interface = MediaWikiInterface::getInstance();
		$app = \F::app();
		$app->wg->Foo = 'bar';
		
		$this->assertEquals(
				'bar',
				$interface->getGlobal( 'Foo' ),
				'\WikiaSearch\MediaWikiInterface::getGlobal should provide an interface to MediaWiki wg-prefixed global variables'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getGlobalWithDefault
	 */
	public function testGetGlobalWithDefault() {
		$interface = MediaWikiInterface::getInstance();
		$app = \F::app();
		$app->wg->Foo = null;
		
		$this->assertEquals(
				'bar',
				$interface->getGlobalWithDefault( 'Foo', 'bar' ),
				'\WikiaSearch\MediaWikiInterface::getGlobalWithDefault should return the default value if the global value is null.'
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::setGlobal
	 */
	public function testSetGlobal() {
		$interface = MediaWikiInterface::getInstance();
		$app = \F::app();
		
		$this->assertEquals(
				$interface,
				$interface->setGlobal( 'Foo', 'bar' )
		);
		$this->assertEquals(
				'bar',
				$app->wg->Foo,
				'\WikiaSearch\MediaWikiInterface::setGlobal should set the provided key as a global variable name with the provided value'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getWikiId
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
	 * @covers \Wikia\Search\MediaWikiInterface::getMediaDataFromPageId
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
				'\WikiaSearch\MediaWikiInterface::getMediaDataFromPageId should return an empty string if the page id is not a file'
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
				'\WikiaSearch\MediaWikiInterface::getMediaDataFromPageId should return the serialized file metadata array for a file page id'
		);
	}

    /**
     * @covers\Wikia\Search\MediaWikiInterface::pageIdHasFile 
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
	 * @covers \Wikia\Search\MediaWikiInterface::getApiStatsForPageId 
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
			    MediaWikiInterface::getInstance()->getApiStatsForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::pageIdExists 
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
			'\WikiaSearch\MediaWikiInterface::pageExists should catch exceptions thrown by \WikiaSearch\MediaWikiInterface::getPageFromPageId and return false'
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
				'\WikiaSearch\MediaWikiInterface::pageExists should pass the return value of Article::exists'
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
				'\WikiaSearch\MediaWikiInterface::pageExists should pass the return value of Article::exists'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getRedirectTitlesForPageId
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
		$method = 'Wikia\Search\MediaWikiInterface::getRedirectTitlesForPageId';
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
		$reflApp = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'app' );
		$reflApp->setAccessible( true );
		$reflApp->setValue( $interface, (object) array( 'wf' => $mockWrapper ) );
		
		$this->assertEquals(
				$expectedResult,
				$interface->getRedirectTitlesForPageId( $this->pageId )
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getMediaDetailFromPageId
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
				'\Wikia\Search\MediaWikiInterface::getMediaDetailFromPageId should return the array result of \WikiaFileHelper::getMediaDetail'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::pageIdIsVideoFile
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
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleKeyFromPageId
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleKeyFromPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$dbKey,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getTitleKeyFromPageId should return the db key for the canonical title associated with the provided page ID'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getFileForPageId
	 */
	public function testGetFileForPageId() {
		$interface = $this->interface->setMethods( array( 'getTitleStringFromPageId' ) )->getMock();
		$mockFile = $this->getMockBuilder( '\File' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		
		$mockWrapper = $this->getMockBuilder( '\WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'findFile' ) )
		                    ->getMock();
		$titleString = 'Foo.jpg';
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $titleString ) )
		;
		$mockWrapper
		    ->expects( $this->at( 0 ) )
		    ->method ( 'findFile' )
		    ->with   ( $titleString )
		    ->will   ( $this->returnValue( $mockFile ) )
		;
		$app = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'app' );
		$app->setAccessible( true );
		$app->setValue( $interface, (object) array( 'wf' => $mockWrapper ) );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getFileForPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockFile,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getFileForPageId should return a file for the provided page ID'
		);
		$pageIdsToFiles = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'pageIdsToFiles' );
		$pageIdsToFiles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockFile ),
				$pageIdsToFiles->getValue( $interface ),
				'\Wikia\Search\MediaWikiInterface::getFileForPageId should store the file instance keyed by page id'
		);
		$interface
		    ->expects( $this->never() )
		    ->method ( 'getTitleStringFromPageId' )
		;
		$this->assertEquals(
				$mockFile,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getFileForPageId should return a cached file for the provided page ID if already invoked'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getPageFromPageId
	 */
	public function testGetPageFromPageIdThrowsException() {
		$this->proxyClass( 'Article', null, 'newFromID' );
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getPageFromPageId' );
		$get->setAccessible( true );
		try {
			$get->invoke( MediaWikiInterface::getInstance(), $this->pageId );
		} catch ( \Exception $e ) {}
		
		$this->assertInstanceOf(
				'\Exception',
				$e,
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should throw an exception when provided a nonexistent page id'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getPageFromPageId
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should return an instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertEquals(
				array( $this->pageId => $mockArticle ),
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiInterface::getPageFromPageId should cache any instantiations of \Article for a canonical page ID'
		);
		$this->assertEquals(
				$mockArticle,
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should return a cached instance of \Article for a provided page id upon consecutive invocations'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getPageFromPageId
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getPageFromPageId' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should return the canonical instance of \Article for a provided page id'
		);
		$pageIdsToArticles = new ReflectionProperty( '\Wikia\Search\MediaWikiInterface', 'pageIdsToArticles' );
		$pageIdsToArticles->setAccessible( true );
		$this->assertArrayHasKey(
				$pageId2,
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiInterface::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertArrayHasKey(
				$this->pageId,
				$pageIdsToArticles->getValue( $interface ),
				 '\Wikia\Search\MediaWikiInterface::getPageFromPageId should cache the canonical \Article for both the redirect and canonical page ID'
		);
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $this->pageId ),
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should return a cached instance of \Article for a provided redirect page id upon consecutive invocations'
		);
		$this->assertInstanceOf(
				'\WikiaMockProxy',
				$get->invoke( $interface, $pageId2 ),
				'\Wikia\Search\MediaWikiInterface::getPageFromPageId should return a cached instance of \Article for a provided canonical page id upon consecutive invocations, even if the redirect was accessed'
		);
	}
	
	/**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleString
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'title',
				$get->invoke( $interface, $title )
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleString
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $interface, $title )
		);
	}
	
    /**
	 * @covers \Wikia\Search\MediaWikiInterface::getTitleString
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
		$get = new ReflectionMethod( '\Wikia\Search\MediaWikiInterface', 'getTitleString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'wall message title',
				$get->invoke( $interface, $title )
		);
	}
	
	/**
	 * @covers Wikia\Search\MediaWikiInterface::getNamespaceIdForString
	 */
	public function testGetNamespaceIdForString() {
		$this->assertEquals( NS_CATEGORY, MediaWikiInterface::getInstance()->getNamespaceIdForString( 'Category' ) );
	}
}