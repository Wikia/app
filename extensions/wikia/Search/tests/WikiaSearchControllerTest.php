<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchControllerTest extends WikiaSearchBaseTest {
	
	public function setUp() {
		global $wgWikiaSearchIsDefault;
		$wgWikiaSearchIsDefault = true;
		$this->searchController = F::build( 'WikiaSearchController' );
		parent::setUp();
	}
	
	
	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithMatch() {
		
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
		$mockTrack
			->staticExpects	( $this->once() )
			->method	( 'event' )
			->with		( 'search_start_gomatch', array( 'sterm' => $searchConfig->getOriginalQuery(), 'rver' => 0 ) )
		;
		$mockRequest
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( '0' ) )
		;

		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();		
		
		$this->searchController->setRequest( $mockRequest );
		$this->searchController->setResponse( $mockResponse );
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $this->searchController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}
	
	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithoutMatch() {
		
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
			->will		( $this->returnValue( false ) )
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

		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();		
		
		$this->searchController->setRequest( $mockRequest );
		$this->searchController->setResponse( $mockResponse );
		
		$searchConfig->setArticleMatch( $mockArticleMatch );
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $this->searchController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
		$method->invoke( $this->searchController, $searchConfig );
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
				$this->searchController->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
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
		        $this->searchController->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
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
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$searchConfig		=	F::build( 'WikiaSearchConfig' );
		
		try {
			$this->searchController->pagination();
			$this->assertFalse( 
					true, 
					'WikiaSearchController::pagination should throw an exception if the "config" is not set in the request.'
			);
		} catch ( Exception $e ) { }
		$this->searchController->getRequest()->setVal( 'config', 'foo' );
		try {
			$this->searchController->pagination();
			$this->assertFalse( 
					true, 
					'WikiaSearchController::pagination should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
			);
		} catch ( Exception $e ) { }
		
		$mockRequest
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $searchConfig ) )
		;
		
		$this->searchController->setRequest( $mockRequest );
		$this->assertFalse(
				$this->searchController->pagination(),
				'WikiaSearchController::pagination should return false if search config set in the request does not have its resultsFound value set, or that value is 0.'
		);
		$searchConfig->setResultFound( 0 );
		$this->assertFalse(
		        $this->searchController->pagination(),
		        'WikiaSearchController::pagination should return false if search config set in the request does not have its resultsFound value set, or that value is 0.'
		);
		
		$searchConfig
			->setResultsFound	( 200 )
			->setPage			( 2 )
		;
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'query', $searchConfig->getQuery( WikiaSearchConfig::QUERY_RAW ) )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'pagesNum', $searchConfig->getNumPages() )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'currentPage', $searchConfig->getPage() )
		;
		$mockResponse
			->expects	( $this->at( 6 ) )
			->method	( 'setVal' )
			->with		( 'crossWikia', $searchConfig->isInterWiki() )
		;
		$mockResponse
			->expects	( $this->at( 7 ) )
			->method	( 'setVal' )
			->with		( 'resultsCount', $searchConfig->getResultsFound() )
		;
		$mockResponse
			->expects	( $this->at( 8 ) )
			->method	( 'setVal' )
			->with		( 'skipCache', $searchConfig->getSkipCache() )
		;
		$mockResponse
			->expects	( $this->at( 9 ) )
			->method	( 'setVal' )
			->with		( 'debug', $searchConfig->getDebug() )
		;
		$mockResponse
			->expects	( $this->at( 10 ) )
			->method	( 'setVal' )
			->with		( 'namespaces', $searchConfig->getNamespaces() )
		;
		$mockResponse
			->expects	( $this->at( 11 ) )
			->method	( 'setVal' )
			->with		( 'advanced', $searchConfig->getAdvanced() )
		;
		$mockResponse
			->expects	( $this->at( 12 ) )
			->method	( 'setVal' )
			->with		( 'redirs', $searchConfig->getIncludeRedirects() )
		;
		$mockResponse
			->expects	( $this->at( 13 ) )
			->method	( 'setVal' )
			->with		( 'limit', $searchConfig->getLimit() )
		;
		
		$this->searchController->setResponse( $mockResponse );
		
		$this->searchController->pagination();
		
		//@todo it would be radical if a front-endian could do some assertions about what the markup should look like in the templates.
	}
	
	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabs() {
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
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
		
		try {
		    $this->searchController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->searchController->getRequest()->setVal( 'config', 'foo' );
		try {
		    $this->searchController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
		    );
		} catch ( Exception $e ) { }
		
		$mockRequest
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		
		$this->searchController->setRequest( $mockRequest );
		
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getSearchProfiles' )
			->will		( $this->returnValue( $searchProfileArray ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getIncludeRedirects' )
			->will		( $this->returnValue( false ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getActiveTab' )
			->will		( $this->returnValue( 'default' ) )
		;
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'bareterm' )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'searchProfiles' )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'redirs' )
		;
		$mockResponse
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'activeTab' )
		;
		
		$this->searchController->setResponse( $mockResponse );
		
		$this->mockApp();
		
		$this->searchController->tabs();
		/**
		 * @todo need front-end help unit-testing template evaluation
		 * We need to make sure, for instance, that the appropriate tab is bolded.
		 */
	}
	
	/**
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBox() {
		$mockResponse			=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest			=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockSearchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getNamespaces', 'getIncludeRedirects', 'getAdvanced' ) );
		$mockSearchEngine		=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces' ) );
		$searchableNamespaces	=	array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
		
		try {
		    $this->searchController->advancedBox();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::advancedBox should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->searchController->getRequest()->setVal( 'config', 'foo' );
		try {
		    $this->searchController->advancedBox();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::advancedBox should throw an exception if the "config" is set in the request, but is not an instance of WikiaSearchConfig.'
		    );
		} catch ( Exception $e ) { }
		
		$mockRequest
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		
		$this->searchController->setRequest( $mockRequest );
		
		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableNamespaces ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( 0, 14 ) )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'searchableNamespaces', $searchableNamespaces )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'redirs', true )
		;
		$mockResponse
			->expects	( $this->at( 3 ) )
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
		
		$this->searchController->setResponse( $mockResponse );
		
		$this->searchController->advancedBox();
		
		/**
		 * @todo write tests for template evaluation
		 */
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
				$method->invoke( $this->searchController ),
				'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is empty.'
		);
		
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', null );
		$this->mockApp();
		
		$this->assertFalse(
		        $method->invoke( $this->searchController ),
		        'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is empty.'
		);
		
		$this->mockGlobalVariable( 'wgEnableWikiaHomePageExt', true );
		$this->mockApp();

		$this->searchController->setApp( F::app() );
		
		$this->assertTrue(
		        $method->invoke( $this->searchController ),
		        'WikiaSearchController::isCorporateWiki should return false if wgEnableWikiaHomePageExt is not empty.'
		);
		
	}
	
	/**
	 * @see WikiaSearch
	 */
	public function testSkinSettings() {
		
		//@todo  fix skin mocking
		return true;
		
		$mockSkinMonoBook		=	$this->getMock( 'stdClass', array(), array(), 'SkinMonoBook' );
		$mockSkinOasis			=	$this->getMock( 'stdClass', array(), array(), 'SkinOasis' );
		$mockSkinWikiaMobile	=	$this->getMock( 'stdClass', array(), array(), 'SkinWikiaMobile' );
		$mockResponse			=	$this->getMock( 'WikiaResponse', array( 'addAsset' ), array( 'html' ) );
		$mockRequestContext		=	$this->getMock( 'RequestContext', array( 'getSkin' ) );
		
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
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleSkinSettings' );
		$method->setAccessible( true );
		
		$this->searchController->setResponse( $mockResponse );
		
		$this->assertTrue(
				$method->invoke( $this->searchController, $mockSkinMonoBook ),
				'WikiaSearchController::handleSkinSettings should always return true.' 
		);
		$this->assertTrue(
		        $method->invoke( $this->searchController, $mockSkinOasis ),
		        'WikiaSearchController::handleSkinSettings should always return true.'
		);
		$this->assertTrue(
		        $method->invoke( $this->searchController, $mockSkinWikiaMobile ),
		        'WikiaSearchController::handleSkinSettings should always return true.'
		);
	}
	
	/**
	 * @covers WikiaSearchController::setNamespacesFromRequest
	 */
	public function testSetNamespacesFromRequest() {
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
		$mockRequest
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
		
		$this->searchController->setRequest( $mockRequest );
		
		$this->assertTrue(
				$method->invoke( $this->searchController, $searchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
		        $defaultArray,
		        $searchConfig->getNamespaces(),
		        'WikiaSearchController::setNamespacesFromRequest should set an empty array that causes WikiaSearchConfig::getNamespaces ' . 
				'to populate namespaces with SearchEngine::DefaultNamespaces if no namespaces are set in the request, and the user has not chosen to search all namespaces..'
		);
		$this->assertTrue(
		        $method->invoke( $this->searchController, $searchConfig, $mockUser ),
		        'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
		        array_keys( $searchableArray ),
		        $searchConfig->getNamespaces(),
		        'WikiaSearchController::setNamespacesFromRequest should set namespaces to all namespaces if the user has chosen to search all namespaces, and no namespaces are passed in the request.'
		);
		$mockRequest = $this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockRequest
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'ns14', false )
			->will		( $this->returnValue( true ) )
		;
		$this->searchController->setRequest( $mockRequest );
		$this->assertTrue(
		        $method->invoke( $this->searchController, $searchConfig, $mockUser ),
		        'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
		$this->assertEquals(
				array( 14 ),
				$searchConfig->getNamespaces(),
				'WikiaSearchController::setNamespacesFromRequest should set namespaces in WikiaSearchConfig if they are passed in the request.'
		);
	}
	
	/**
	 * Helper hook for testing article match
	 */
	public static function gomatch() {
		global $hookGoMatch;
		$hookGoMatch = true;
		return true;
	}
	
	/**
	 * Helper hook for testing article match
	 */
	public static function nogomatch() {
		global $hookNoGoMatch;
		$hookNoGoMatch = true;
		return true;
	}
	
	/**
	 * Helper hook for testing skins
	 */
	public static function requestContextCreateSkin( RequestContext $context, &$skin = null ) {
		
		var_dump($skin);
		
	}
	
}