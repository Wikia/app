<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchControllerTest extends WikiaSearchBaseTest {
	
	public function setUp() {
		$this->searchController = $this->getMockBuilder( 'WikiaSearchController' )
										->disableOriginalConstructor();
		parent::setUp();
	}
	
	
	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithMatch() {
		
		$this->searchController->setMethods( array( 'getVal' ) );
		$mockController = $this->searchController->getMock();
		
		$searchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getArticleMatch' ) );
		$mockTitle			=	$this->getMock( 'Title',  array( 'newFromText', 'getFullUrl' ) );
		$mockArticle		=	$this->getMock( 'Article', array( 'getTitle' ), array( $mockTitle ) );
		$mockArticleMatch	=	$this->getMock( 'WikiaSearchArticleMatch', array( 'getArticle' ), array( $mockArticle ) );
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockTrack			=	$this->getMock( 'Track', array( 'event' ) );
		$mockWrapper		=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
									->disableOriginalConstructor()
									->setMethods( array( 'RunHoooks' ) )
									->getMock();

		$searchConfig
			->expects	( $this->any() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( $mockArticleMatch ) )
		;
		$searchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( 'unittestfoo' ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'newFromTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getFullURL' )
			->will		( $this->returnValue( 'http://foo.wikia.com/Wiki/foo' ) )
		;
		$mockResponse
			->expects	( $this->once() )
			->method	( 'redirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticleMatch
			->expects	( $this->once() )
			->method	( 'getArticle' )
			->will		( $this->returnValue( $mockArticle ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( '0' ) )
		;
		$mockTrack
			->expects	( $this->once() )
			->method	( 'event' )
			->with		( 'search_start_gomatch', array( 'sterm' => 'unittestfoo', 'rver' => 0 ) )
		;
		$mockWrapper
			->expects	( $this->once() )
			->method	( 'RunHooks' )
			->with		( 'SpecialSearchIsgomatch', array( $mockTitle, 'unittestfoo' ) )
		;

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );
		
		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );
		
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'Title', $mockTitle );
		$this->mockApp();
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $this->searchController->getMock(), $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}
	
	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithoutMatch() {
		
		$mockController = $this->searchController->getMock();
		
		$searchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getArticleMatch' ) );
		$mockTitle			=	$this->getMock( 'Title',  array( 'newFromText', 'getFullUrl' ) );
		$mockArticle		=	$this->getMock( 'Article', array( 'getTitle' ), array( $mockTitle ) );
		$mockArticleMatch	=	$this->getMock( 'WikiaSearchArticleMatch', array( 'getArticle' ), array( $mockArticle ) );
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal', 'setVal' ), array( array() ) );
		$mockTrack			=	$this->getMock( 'Track', array( 'event' ) );
		$mockWrapper		=	$this->getMock( 'WikiaFunctionWrapper', array( 'RunHooks' ) );

		$searchConfig
			->expects	( $this->any() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( false ) )
		;
		$searchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( 'unittestfoo' ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getFullURL' )
			->will		( $this->returnValue( 'http://foo.wikia.com/Wiki/foo' ) )
		;
		$mockArticleMatch
			->expects	( $this->never() )
			->method	( 'getArticle' )
			->will		( $this->returnValue( $mockArticle ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTrack
			->expects	( $this->once() )
			->method	( 'event' )
			->with		( 'search_start_gomatch', array( 'sterm' => 'unittestfoo', 'rver' => 0 ) )
		;
		$mockWrapper
			->expects	( $this->once() )
			->method	( 'RunHooks' )
			->with		( 'SpecialSearchNogomatch', array( $mockTitle ) )
		;

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );
		
		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
		
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'Title', $mockTitle );
		$this->mockApp();
		
		$method->invoke( $mockController, $searchConfig );
	}
	
	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function handleArticleMatchTrackingWithoutGoSearch() {
		
		$mockController		=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		
		$searchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getArticleMatch' ) );
		$mockTitle			=	$this->getMock( 'Title',  array( 'newFromText', 'getFullUrl' ) );
		$mockArticle		=	$this->getMock( 'Article', array( 'getTitle' ), array( $mockTitle ) );
		$mockArticleMatch	=	$this->getMock( 'WikiaSearchArticleMatch', array( 'getArticle' ), array( $mockArticle ) );
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal', 'setVal' ), array( array() ) );
		$mockTrack			=	$this->getMock( 'Track', array( 'event' ) );

		$searchConfig
			->expects	( $this->any() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( $mockArticleMatch ) )
		;
		$searchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( 'unittestfoo' ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'newFromTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getFullURL' )
			->will		( $this->returnValue( 'http://foo.wikia.com/Wiki/foo' ) )
		;
		$mockResponse
			->expects	( $this->once() )
			->method	( 'redirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticleMatch
			->expects	( $this->once() )
			->method	( 'getArticle' )
			->will		( $this->returnValue( $mockArticle ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockRequest
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( 'Search' ) )
		;
		$mockTrack
			->expects	( $this->once() )
			->method	( 'event' )
			->with		( 'search_start_match', array( 'sterm' => 'unittestfoo', 'rver' => 0 ) )
		;

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );
		
		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );
		
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'Title', $mockTitle );
		$this->mockApp();
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $this->searchController->getMock(), $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}
	
	
	/**
	 * @covers WikiaSearchController
	 */
	public function testOnWikiaMobileAssetsPackages() {
		
		$mockTitle	= $this->getMock( 'Title', array( 'isSpecial' ) );	
		$jsHead		= array();
		$jsBody		= array();
		$cssPkg		= array();
		
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( false ) )
		;
		$mockTitle
			->expects	( $this->at( 1 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( true ) )
		;
		
		$this->mockGlobalVariable( 'wgTitle', $mockTitle );
		$this->mockApp();
		
		$this->assertTrue( 
				$this->searchController->getMock()->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
				'As a hook, WikiaSearchController::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertEmpty(
		        $jsBody,
		        'WikiaSearchController::onWikiaMobileAssetsPackages shoudl not append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array if the title is not special search.'
		);
		$this->assertEmpty(
		        $cssPkg,
		        'WikiaSearchController::onWikiaMobileAssetsPackages should not append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array  if the title is not special search.'
		);
		$this->assertTrue(
		        $this->searchController->getMock()->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
		        'As a hook, WikiaSearchController::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertContains(
				'wikiasearch_js_wikiamobile',
				$jsBody,
				'WikiaSearchController::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array.'
		);
		$this->assertContains(
		        'wikiasearch_scss_wikiamobile',
		        $cssPkg,
		        'WikiaSearchController::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array.'
		);
		
	}

	/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPagination() {
		
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockTitle			=	$this->getMockBuilder( 'Title' )->disableOriginalConstructor()->getMock();
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$configMethods		=	array( 'getResultsFound', 'getPage', 'getQuery', 'getNumPages', 'getIsInterWiki', 
										'getSkipCache', 'getDebug', 'getNamespaces', 'getAdvanced', 'getIncludeRedirects', 'getLimit' );
		$mockConfig			=	$this->getMock( 'WikiaSearchConfig', $configMethods );
		
		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'Title' => $mockTitle ) );
		
		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		
		try {
			$mockController->pagination();
			$this->assertFalse( 
					true, 
					'WikiaSearchController::pagination should throw an exception if the "config" is not set in the request.'
			);
		} catch ( Exception $e ) { }
		
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		
		try {
			$mockController->pagination();
			$this->assertFalse( 
					true, 
					'WikiaSearchController::pagination should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
			);
		} catch ( Exception $e ) { }
		
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 0 ) )
		;
		$this->assertFalse(
				$mockController->pagination(),
				'WikiaSearchController::pagination should return false if search config set in the request does not have its resultsFound value set, or that value is 0.'
		);
		$mockController
			->expects	( $this->at( 3 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 0 ) )
		;
		$this->assertFalse(
		        $mockController->pagination(),
		        'WikiaSearchController::pagination should return false if search config set in the request does not have its resultsFound value set, or that value is 0.'
		);
		
		$mockController
			->expects	( $this->at( 4 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'getOriginalQuery', WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 5 ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 10 ) )
		;
		$mockConfig
			->expects	( $this->at( 6 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		$mockConfig
			->expects	( $this->at( 7 ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( 2 ) )
		;
		$mockConfig
			->expects	( $this->at( 8 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->at( 9 ) )
			->method	( 'getSkipCache' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 10 ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 11 ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockConfig
			->expects	( $this->at( 12 ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 13 ) )
			->method	( 'getIncludeRedirects' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 14 ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( 5 ) )
			->method	( 'setVal' )
			->with		( 'query', 'foo' )
		;
		$mockController
			->expects	( $this->at( 6 ) )
			->method	( 'setVal' )
			->with		( 'pagesNum', '10' )
		;
		$mockController
			->expects	( $this->at( 7 ) )
			->method	( 'setVal' )
			->with		( 'pageTitle', $mockTitle )
		;
		$mockController
			->expects	( $this->at( 8 ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 2 )
		;
		$mockController
			->expects	( $this->at( 9 ) )
			->method	( 'setVal' )
			->with		( 'crossWikia', false )
		;
		$mockController
			->expects	( $this->at( 10 ) )
			->method	( 'setVal' )
			->with		( 'resultsCount', 200 )
		;
		$mockController
			->expects	( $this->at( 11 ) )
			->method	( 'setVal' )
			->with		( 'skipCache', false )
		;
		$mockController
			->expects	( $this->at( 12 ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( 13 ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockController
			->expects	( $this->at( 14 ) )
			->method	( 'setVal' )
			->with		( 'advanced', false )
		;
		$mockController
			->expects	( $this->at( 15 ) )
			->method	( 'setVal' )
			->with		( 'redirs', false )
		;
		$mockController
			->expects	( $this->at( 16 ) )
			->method	( 'setVal' )
			->with		( 'limit', 20 )
		;
	}
	
	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabs() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockSearchConfig	=	$this->getMock( 'WikiaSearchConfig', array( 'getNamespaces', 'getQuery' ) );
		$mockSearchEngine   =   $this->getMock( 'SearchEngine', array( 'defaultNamespaces', 'namespacesAsText', 'searchableNamespaces' ) );
		
		$mockSearchEngine->staticExpects( $this->any() )->method( 'defaultNamespaces' )->will( $this->returnValue( array( NS_MAIN, NS_CATEGORY ) ) );
		$mockSearchEngine->staticExpects( $this->any() )->method( 'namespacesAsText' )->will( $this->returnValue( array( 'Article', 'Category' ) ) );
		$mockSearchEngine->staticExpects( $this->any() )->method( 'searchableNamespaces' )->will( $this->returnValue( array( NS_MAIN, NS_CATEGORY, NS_FILE, NS_USER ) ) );
		$mockSearchConfig->expects( $this->any() )->method( 'getNamespaces' )->will( $this->returnValue( array( NS_MAIN, NS_CATEGORY, NS_FILE, NS_USER ) ) );
		$defaultNamespaces = $mockSearchEngine->defaultNamespaces();
		
		$nsAllSet = $mockSearchEngine->searchableNamespaces();
		
		$this->mockGlobalVariable( 'wgDefaultSearchProfile', SEARCH_PROFILE_DEFAULT );
		
		$searchProfileArray = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => $mockSearchEngine->namespacesAsText( $defaultNamespaces ),
	            ),
	            SEARCH_PROFILE_IMAGES => array(
	                    'message' => 'wikiasearch2-tabs-photos-and-videos',
	                    'tooltip' => 'searchprofile-images-tooltip',
	                    'namespaces' => array( NS_FILE ),
	            ),
	            SEARCH_PROFILE_USERS => array(
	                    'message' => 'wikiasearch2-users',
	                    'tooltip' => 'wikiasearch2-users-tooltip',
	                    'namespaces' => array( NS_USER )
	            ),
	            SEARCH_PROFILE_ALL => array(
	                    'message' => 'searchprofile-everything',
	                    'tooltip' => 'searchprofile-everything-tooltip',
	                    'namespaces' => $nsAllSet,
	            ),
	            SEARCH_PROFILE_ADVANCED => array(
	                    'message' => 'searchprofile-advanced',
	                    'tooltip' => 'searchprofile-advanced-tooltip',
	                    'namespaces' => $mockSearchConfig->getNamespaces(),
	                    'parameters' => array( 'advanced' => 1 ),
	            )
		);
		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( false ) )
		;
		try {
		    $mockController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		try {
		    $mockController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
		    );
		} catch ( Exception $e ) { }
		
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getSearchProfiles' )
			->will		( $this->returnValue( $searchProfileArray ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getIncludeRedirects' )
			->will		( $this->returnValue( false ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getActiveTab' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockController
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'bareterm', 'foo' )
		;
		$mockController
			->expects	( $this->at( 4 ) )
			->method	( 'setVal' )
			->with		( 'searchProfiles', $searchProfileArray )
		;
		$mockController
			->expects	( $this->at( 5 ) )
			->method	( 'setVal' )
			->with		( 'redirs', 'false' )
		;
		$mockController
			->expects	( $this->at( 6 ) )
			->method	( 'setVal' )
			->with		( 'activeTab', 'default' )
		;
		
		$this->mockApp();
		
		$mockController->tabs();
	}
	
	/**
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBox() {
		$mockController			=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockResponse			=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest			=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockSearchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getNamespaces', 'getIncludeRedirects', 'getAdvanced' ) );
		$mockSearchEngine		=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces' ) );
		$searchableNamespaces	=	array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
		
		$mockController
			->expects	( $this->at ( 0 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( false ) )
		;
		$e = null;
		try {
		    $mockController->advancedBox();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::advancedBox should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::advancedBox should throw an exception if there is no search config set'
		);
		$mockController
			->expects	( $this->at ( 2 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		$e = null;
		try {
		    $mockController->advancedBox();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::advancedBox should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
		    );
		} catch ( Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::advancedBox should throw an exception if there is no search config set'
		);
		
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		
		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableNamespaces ) )
		;
		$mockController
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( 0, 14 ) )
		;
		$mockController
			->expects	( $this->at( 4 ) )
			->method	( 'setVal' )
			->with		( 'searchableNamespaces', $searchableNamespaces )
		;
		$mockController
			->expects	( $this->at( 5 ) )
			->method	( 'setVal' )
			->with		( 'redirs', true )
		;
		$mockResponse
			->expects	( $this->at( 6 ) )
			->method	( 'setVal' )
			->with		( 'advanced', true )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( 0, 14) ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getIncludeRedirects' )
			->will		( $this->returnValue( true ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( true ) )
		;
		
		$this->mockClass( 'SearchEngine', $mockSearchEngine );
		
		$this->mockApp();
		
		F::setInstance( 'SearchEngine', $mockSearchEngine );
		
		$mockController->advancedBox();

	}
	
	/**
	 * @covers WikiaSearchController::isCorporateWiki
	 */
	public function testIsCorporateWiki() {

		$method = new ReflectionMethod( 'WikiaSearchController', 'isCorporateWiki' );
		$method->setAccessible( true );
		
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', false );
		$this->mockApp();
		
		$this->assertFalse(
				$method->invoke( $this->searchController->getMock() ),
				'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is empty.'
		);
		
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', null );
		$this->mockApp();
		
		$this->assertFalse(
		        $method->invoke( $this->searchController->getMock() ),
		        'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is empty.'
		);
		
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', true );
		$this->mockApp();

		$this->searchController->getMock()->setApp( F::app() );
		
		$this->assertTrue(
		        $method->invoke( $this->searchController->getMock() ),
		        'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is not empty.'
		);
		
	}
	
	/**
	 * @see WikiaSearch
	 */
	public function testSkinSettings() {
		
		$mockSearchController	=	$this->getMockBuilder( 'WikiaSearchController' )
										->disableOriginalConstructor()
										->setMethods( array( 'overrideTemplate' ) )
										->getMock();
		
		$mockSkinMonoBook		=	$this->getMockBuilder( 'SkinMonoBook' )
										->disableOriginalConstructor()
										->getMock();
		$mockSkinOasis			=	$this->getMockBuilder( 'SkinOasis' )
										->disableOriginalConstructor()
										->getMock();
		$mockSkinWikiaMobile	=	$this->getMockBuilder( 'SkinWikiaMobile' )
										->disableOriginalConstructor()
										->getMock();
		$mockResponse			=	$this->getMockBuilder( 'WikiaResponse' )
										->disableOriginalConstructor()
										->setMethods( array( 'addAsset' ) )
										->getMock();
		$mockRequestContext		=	$this->getMockBuilder( 'RequestContext' )
										->setMethods( array( 'getSkin' ) )
										->disableOriginalConstructor()
										->getMock();
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'addAsset' )
			->with		( 'extensions/wikia/Search/monobook/monobook.scss' )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'addAsset' )
			->with		( 'extensions/wikia/Search/css/WikiaSearch.scss' )
		;
		$mockSearchController
			->expects	( $this->once() )
			->method	( 'overrideTemplate' )
			->with		( 'WikiaMobileIndex' )
		;
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleSkinSettings' );
		$method->setAccessible( true );
		
		$mockSearchController->setResponse( $mockResponse );
		
		$this->assertTrue(
				$method->invoke( $mockSearchController, $mockSkinMonoBook ),
				'WikiaSearchController::handleSkinSettings should always return true.' 
		);
		$this->assertTrue(
		        $method->invoke( $mockSearchController, $mockSkinOasis ),
		        'WikiaSearchController::handleSkinSettings should always return true.'
		);
		$this->assertTrue(
		        $method->invoke( $mockSearchController, $mockSkinWikiaMobile ),
		        'WikiaSearchController::handleSkinSettings should always return true.'
		);
	}
	
	/**
	 * @covers WikiaSearchController::setNamespacesFromRequest
	 */
	public function testSetNamespacesFromRequest() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchEngine	=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces', 'DefaultNamespaces' ) );
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$defaultArray		=	array( 0, 14 );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockUser			=	$this->getMock( 'User', array( 'getOption' ) );
		
		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableArray ) )
		;
		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'DefaultNamespaces' )
			->will			( $this->returnValue( $defaultArray ) )
		;
		$mockController
			->expects		( $this->any() )
			->method		( 'getVal' )
			->will			( $this->returnValue( false ) )
		;
		$mockUser
			->expects		( $this->at( 0 ) )
			->method		( 'getOption' )
			->with			( 'searchAllNamespaces' )
			->will			( $this->returnValue( false ) )
		;
		$mockUser
			->expects		( $this->at( 1 ) )
			->method		( 'getOption' )
			->with			( 'searchAllNamespaces' )
			->will			( $this->returnValue( true ) )
		;
		
		$this->mockClass( 'SearchEngine', $mockSearchEngine );
		$this->mockApp();
		$searchConfig = F::build( 'WikiaSearchConfig' );
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'setNamespacesFromRequest' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
		        $defaultArray,
		        $searchConfig->getNamespaces(),
		        'WikiaSearchController::setNamespacesFromRequest should set an empty array that causes WikiaSearchConfig::getNamespaces ' . 
				'to populate namespaces with SearchEngine::DefaultNamespaces if no namespaces are set in the request, and the user has not chosen to search all namespaces..'
		);
		$this->assertTrue(
		        $method->invoke( $mockController, $searchConfig, $mockUser ),
		        'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
		        array_keys( $searchableArray ),
		        $searchConfig->getNamespaces(),
		        'WikiaSearchController::setNamespacesFromRequest should set namespaces to all namespaces if the user has chosen to search all namespaces, and no namespaces are passed in the request.'
		);
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'ns14', false )
			->will		( $this->returnValue( true ) )
		;
		$this->assertTrue(
		        $method->invoke( $mockController, $searchConfig, $mockUser ),
		        'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
				array( 14 ),
				$searchConfig->getNamespaces(),
				'WikiaSearchController::setNamespacesFromRequest should set namespaces in WikiaSearchConfig if they are passed in the request.'
		);
	}
}