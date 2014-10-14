<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchControllerTest extends WikiaSearchBaseTest {

	public function setUp() {
		$this->searchController = $this->getMockBuilder( 'WikiaSearchController' )
										->disableOriginalConstructor();
		parent::setUp();
	}

	/**
	 * @covers WikiaSearchController::index
	 */
	public function testIndexDefault() {
		$configMethods = array(
				'setQuery', 'setCityId', 'setLimit', 'setPage', 'setRank', 'setDebug', 'setSkipCache',
				'setAdvanced', 'setHub', 'setRedirs', 'getAdvanced', 'setIsInterWiki', 'setVideoSearch',
				'setGroupResults', 'isInterWiki', 'setFilterQueriesFromCodes', 'getResults',
				'getResultsFound', 'getTruncatedResultsNum', 'getNumPages', 'getPage', 'getQuery', 'getLimit',
				'getDebug', 'getIsInterWiki', 'getNamespaces', 'getHub', 'hasArticleMatch', 'getQueryNoQuotes'
				);

		$controllerMethods = array(
				'handleSkinSettings', 'getVal', 'isCorporateWiki', 'setVal',
				'setNamespacesFromRequest', 'sendSelfRequest', 'handleArticleMatchTracking'
				);

		$mockController	=	$this->searchController
								->disableOriginalConstructor()
								->setMethods( $controllerMethods )
								->getMock();

		$mockOut		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'addHTML', 'setPageTitle' ) )
								->getMock();

		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'getBool' ) )
								->getMock();

		$mockUser		=	$this->getMockBuilder( 'User' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSkin' ) )
								->getMock();

		$mockConfig		=	$this->getMockBuilder( 'WikiaSearchConfig' )
								->disableOriginalConstructor()
								->setMethods( $configMethods )
								->getMock();

		$mockLang		=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->setMethods( array( 'formatNum' ) )
								->getMock();

		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMatch', 'doSearch' ) )
								->getMock();

		$mockWf			=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
								->disableOriginalConstructor()
								->setMethods( array( 'msg' ) )
								->getMock();

		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFormat' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFullUrl' ) )
								->getMock();

		$mockTrack		=	$this->getMock( 'Track' );

		$mockJsSnippets	=	$this->getMock( 'JSSnippets', array( 'addToStack' ) );

		$mockWg			=	( object ) array(
								'Out'			=>	$mockOut,
								'User'			=>	$mockUser,
								'suppressRail'	=>	false,
								'CityId'		=>	123,
								'Sitename'		=>	'Sitename',
								'Lang'			=>	$mockLang,
								'Title'			=>	$mockTitle,
								'SolrHost'		=>	'search'
								);


		$query = 'my mock query';

		$controllerIncr = 0;
		$configIncr = 0;
		$requestIncr = 0;

		$mockJsSnippets
			->expects	( $this->once() )
			->method	( 'addToStack' )
			->with		( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) )
			->will		( $this->returnValue( 'mocksnippet' ) );
		;
		$mockOut
			->expects	( $this->at( 0 ) )
			->method	( 'addHTML' )
			->with		( 'mocksnippet' )
		;
		$mockUser
			->expects	( $this->any() )
			->method	( 'getSkin' )
			->will		( $this->returnValue( 'Oasis' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleSkinSettings' )
			->with		( 'Oasis' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'search' )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'query', $query )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setCityId' )
			->with		( $mockWg->CityId )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'limit', WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setLimit' )
			->with		( WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'page', 1 )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setPage' )
			->with		( 1 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'rank', 'default' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRank' )
			->with		( 'default' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'debug', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setDebug' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'skipCache', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setSkipCache' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'advanced', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setAdvanced' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'nohub' )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'hub', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setHub' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRedirs' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'crossWikia', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setIsInterWiki' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'videoSearch', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setVideoSearch' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'isInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'grouped', false )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setGroupResults' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'filters', array() )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setFilterQueriesFromCodes' )
			->with		( array() )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setNamespacesFromRequest' )
			->with		( $mockConfig, $mockUser )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getMatch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleArticleMatchTracking' )
			->with		( $mockConfig, $mockTrack )
		;
		$mockSearch
			->expects	( $this->at( 1 ) )
			->method	( 'doSearch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( $query ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'msg' )
			->with		( 'wikiasearch2-page-title-with-query', array( 'My Mock Query' , 'Sitename' ) )
			->will		( $this->returnValue( 'Search results for My Mock Query | Sitename' ) )
		;
		$mockOut
			->expects	( $this->at( 1 ) )
			->method	( 'setPageTitle' )
			->with		( 'Search results for My Mock Query | Sitename' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'advancedBox', array( 'config' => $mockConfig ) )
			->will		( $this->returnValue( 'ssr_advanced_result' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'advancedSearchBox', 'ssr_advanced_result' )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'getFormat' )
			->will		( $this->returnValue( 'html' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'results', $mockResultSet )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFound', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getTruncatedResultsNum' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'formatNum' )
			->with		( 20 )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFoundTruncated', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isOneResultsPageOnly', true )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pagesCount', 1 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 1 )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'pagination', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_pagination' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'paginationLinks', 'ssr_pagination' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'tabs', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_tabs' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'tabs', 'ssr_tabs' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'query', $query )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsPerPage', WikiaSearchController::RESULTS_PER_PAGE )
		;
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'getFullUrl' )
			->will		( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pageUrl', 'foo.wikia.com' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'solrHost', 'search' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isInterWiki', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getHub' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hub', false )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hasArticleMatch', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isMonobook', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isCorporateWiki', false )
		;

		$reflReq = new ReflectionProperty( 'WikiaSearchController', 'request' );
		$reflReq->setAccessible( true );
		$reflReq->setValue( $mockController, $mockRequest );

		$reflResp = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$reflResp->setAccessible( true );
		$reflResp->setValue( $mockController, $mockResponse );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$reflWf = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockController, $mockWf );

		$reflSearch = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$reflSearch->setAccessible( true );
		$reflSearch->setValue( $mockController, $mockSearch );

		$this->mockClass( 'JSSnippets', $mockJsSnippets );
		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();

		$mockController->index();

		$this->assertEquals(
				true,
				$mockController->wg->SuppressRail,
				'WikiaSearchController::index should set wgSuppressRail to false'
		);
	}
	
	/**
	 * @covers WikiaSearchController::index
	 */
	public function testIndexDefaultAsJson() {
		$configMethods = array(
				'setQuery', 'setCityId', 'setLimit', 'setPage', 'setRank', 'setDebug', 'setSkipCache',
				'setAdvanced', 'setHub', 'setRedirs', 'getAdvanced', 'setIsInterWiki', 'setVideoSearch',
				'setGroupResults', 'isInterWiki', 'setFilterQueriesFromCodes', 'getResults', 'setResults',
				'getResultsFound', 'getTruncatedResultsNum', 'getNumPages', 'getPage', 'getQuery', 'getLimit',
				'getDebug', 'getIsInterWiki', 'getNamespaces', 'getHub', 'hasArticleMatch', 'getQueryNoQuotes'
				);

		$controllerMethods = array(
				'handleSkinSettings', 'getVal', 'isCorporateWiki', 'setVal',
				'setNamespacesFromRequest', 'sendSelfRequest', 'handleArticleMatchTracking'
				);

		$mockController	=	$this->searchController
								->disableOriginalConstructor()
								->setMethods( $controllerMethods )
								->getMock();

		$mockOut		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'addHTML', 'setPageTitle' ) )
								->getMock();

		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'getBool' ) )
								->getMock();

		$mockUser		=	$this->getMockBuilder( 'User' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSkin' ) )
								->getMock();

		$mockConfig		=	$this->getMockBuilder( 'WikiaSearchConfig' )
								->disableOriginalConstructor()
								->setMethods( $configMethods )
								->getMock();

		$mockLang		=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->setMethods( array( 'formatNum' ) )
								->getMock();

		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMatch', 'doSearch' ) )
								->getMock();

		$mockWf			=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
								->disableOriginalConstructor()
								->setMethods( array( 'msg' ) )
								->getMock();

		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFormat' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'toNestedArray' ) )
								->getMock();

		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFullUrl' ) )
								->getMock();

		$mockTrack		=	$this->getMock( 'Track' );

		$mockJsSnippets	=	$this->getMock( 'JSSnippets', array( 'addToStack' ) );

		$resultsPerPage = 10;
		$mockWg			=	( object ) array(
								'Out'			=>	$mockOut,
								'User'			=>	$mockUser,
								'suppressRail'	=>	false,
								'CityId'		=>	123,
								'Sitename'		=>	'Sitename',
								'Lang'			=>	$mockLang,
								'Title'			=>	$mockTitle,
								'SolrHost'		=>	'search',
								'SearchResultsPerPage'=>  $resultsPerPage
								);


		$query = 'my mock query';

		$controllerIncr = 0;
		$configIncr = 0;
		$requestIncr = 0;

		$mockJsSnippets
			->expects	( $this->once() )
			->method	( 'addToStack' )
			->with		( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) )
			->will		( $this->returnValue( 'mocksnippet' ) );
		;
		$mockOut
			->expects	( $this->at( 0 ) )
			->method	( 'addHTML' )
			->with		( 'mocksnippet' )
		;
		$mockUser
			->expects	( $this->any() )
			->method	( 'getSkin' )
			->will		( $this->returnValue( 'Oasis' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleSkinSettings' )
			->with		( 'Oasis' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'search' )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'query', $query )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setCityId' )
			->with		( $mockWg->CityId )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'limit', $resultsPerPage )
			->will		( $this->returnValue( $resultsPerPage ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setLimit' )
			->with		( $resultsPerPage )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'page', 1 )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setPage' )
			->with		( 1 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'rank', 'default' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRank' )
			->with		( 'default' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'debug', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setDebug' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'skipCache', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setSkipCache' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'advanced', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setAdvanced' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'nohub' )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'hub', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setHub' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRedirs' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'crossWikia', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setIsInterWiki' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'videoSearch', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setVideoSearch' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'isInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'grouped', false )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setGroupResults' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'filters', array() )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setFilterQueriesFromCodes' )
			->with		( array() )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setNamespacesFromRequest' )
			->with		( $mockConfig, $mockUser )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getMatch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleArticleMatchTracking' )
			->with		( $mockConfig, $mockTrack )
		;
		$mockSearch
			->expects	( $this->at( 1 ) )
			->method	( 'doSearch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( $query ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'msg' )
			->with		( 'wikiasearch2-page-title-with-query', array( 'My Mock Query' , 'Sitename' ) )
			->will		( $this->returnValue( 'Search results for My Mock Query | Sitename' ) )
		;
		$mockOut
			->expects	( $this->at( 1 ) )
			->method	( 'setPageTitle' )
			->with		( 'Search results for My Mock Query | Sitename' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'advancedBox', array( 'config' => $mockConfig ) )
			->will		( $this->returnValue( 'ssr_advanced_result' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'advancedSearchBox', 'ssr_advanced_result' )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'getFormat' )
			->will		( $this->returnValue( 'json' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$resultArray = array( 'result set as array' );
		$mockResultSet
			->expects	( $this->at( 0 ) )
			->method	( 'toNestedArray' )
			->will		( $this->returnValue( $resultArray ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setResults' )
			->with		( $resultArray )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $resultArray ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'results', $resultArray )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFound', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getTruncatedResultsNum' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'formatNum' )
			->with		( 20 )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFoundTruncated', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isOneResultsPageOnly', true )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pagesCount', 1 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 1 )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'pagination', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_pagination' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'paginationLinks', 'ssr_pagination' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'tabs', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_tabs' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'tabs', 'ssr_tabs' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'query', $query )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( $resultsPerPage ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsPerPage', $resultsPerPage )
		;
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'getFullUrl' )
			->will		( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pageUrl', 'foo.wikia.com' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'solrHost', 'search' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isInterWiki', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getHub' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hub', false )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hasArticleMatch', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isMonobook', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isCorporateWiki', false )
		;

		$reflReq = new ReflectionProperty( 'WikiaSearchController', 'request' );
		$reflReq->setAccessible( true );
		$reflReq->setValue( $mockController, $mockRequest );

		$reflResp = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$reflResp->setAccessible( true );
		$reflResp->setValue( $mockController, $mockResponse );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$reflWf = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockController, $mockWf );

		$reflSearch = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$reflSearch->setAccessible( true );
		$reflSearch->setValue( $mockController, $mockSearch );

		$this->mockClass( 'JSSnippets', $mockJsSnippets );
		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();

		$mockController->index();

		$this->assertEquals(
				true,
				$mockController->wg->SuppressRail,
				'WikiaSearchController::index should set wgSuppressRail to false'
		);
	}


	/**
	 * @covers WikiaSearchController::index
	 */
	public function testIndexDefaultNoQuery() {
		$configMethods = array(
				'setQuery', 'setCityId', 'setLimit', 'setPage', 'setRank', 'setDebug', 'setSkipCache',
				'setAdvanced', 'setHub', 'setRedirs', 'getAdvanced', 'setIsInterWiki', 'setVideoSearch',
				'setGroupResults', 'isInterWiki', 'setFilterQueriesFromCodes', 'getResults',
				'getResultsFound', 'getTruncatedResultsNum', 'getNumPages', 'getPage', 'getQuery', 'getLimit',
				'getDebug', 'getIsInterWiki', 'getNamespaces', 'getHub', 'hasArticleMatch', 'getQueryNoQuotes'
				);

		$controllerMethods = array(
				'handleSkinSettings', 'getVal', 'isCorporateWiki', 'setVal',
				'setNamespacesFromRequest', 'sendSelfRequest', 'handleArticleMatchTracking'
				);

		$mockController	=	$this->searchController
								->disableOriginalConstructor()
								->setMethods( $controllerMethods )
								->getMock();

		$mockOut		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'addHTML', 'setPageTitle' ) )
								->getMock();

		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'getBool' ) )
								->getMock();

		$mockUser		=	$this->getMockBuilder( 'User' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSkin' ) )
								->getMock();

		$mockConfig		=	$this->getMockBuilder( 'WikiaSearchConfig' )
								->disableOriginalConstructor()
								->setMethods( $configMethods )
								->getMock();

		$mockLang		=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->setMethods( array( 'formatNum' ) )
								->getMock();

		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMatch', 'doSearch' ) )
								->getMock();

		$mockWf			=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
								->disableOriginalConstructor()
								->setMethods( array( 'msg' ) )
								->getMock();

		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFormat' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFullUrl' ) )
								->getMock();

		$mockTrack		=	$this->getMock( 'Track' );

		$mockJsSnippets	=	$this->getMock( 'JSSnippets', array( 'addToStack' ) );

		$mockWg			=	( object ) array(
								'Out'			=>	$mockOut,
								'User'			=>	$mockUser,
								'suppressRail'	=>	false,
								'CityId'		=>	123,
								'Sitename'		=>	'Sitename',
								'Lang'			=>	$mockLang,
								'Title'			=>	$mockTitle,
								'SolrHost'		=>	'search'
								);


		$query = '';

		$controllerIncr = 0;
		$configIncr = 0;
		$requestIncr = 0;

		$mockJsSnippets
			->expects	( $this->once() )
			->method	( 'addToStack' )
			->with		( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) )
			->will		( $this->returnValue( 'mocksnippet' ) );
		;
		$mockOut
			->expects	( $this->at( 0 ) )
			->method	( 'addHTML' )
			->with		( 'mocksnippet' )
		;
		$mockUser
			->expects	( $this->any() )
			->method	( 'getSkin' )
			->will		( $this->returnValue( 'Oasis' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleSkinSettings' )
			->with		( 'Oasis' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'search' )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'query', $query )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setCityId' )
			->with		( $mockWg->CityId )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'limit', WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setLimit' )
			->with		( WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'page', 1 )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setPage' )
			->with		( 1 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'rank', 'default' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRank' )
			->with		( 'default' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'debug', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setDebug' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'skipCache', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setSkipCache' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'advanced', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setAdvanced' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'nohub' )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'hub', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setHub' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRedirs' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'crossWikia', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setIsInterWiki' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'videoSearch', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setVideoSearch' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'isInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'grouped', false )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setGroupResults' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'filters', array() )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setFilterQueriesFromCodes' )
			->with		( array() )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setNamespacesFromRequest' )
			->with		( $mockConfig, $mockUser )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'msg' )
			->with		( 'wikiasearch2-page-title-no-query-intrawiki', array( 'Sitename' ) )
			->will		( $this->returnValue( 'Enter a search query | Sitename' ) )
		;
		$mockOut
			->expects	( $this->at( 1 ) )
			->method	( 'setPageTitle' )
			->with		( 'Enter a search query | Sitename' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'advancedBox', array( 'config' => $mockConfig ) )
			->will		( $this->returnValue( 'ssr_advanced_result' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'advancedSearchBox', 'ssr_advanced_result' )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'getFormat' )
			->will		( $this->returnValue( 'html' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'results', $mockResultSet )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFound', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getTruncatedResultsNum' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'formatNum' )
			->with		( 0 )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFoundTruncated', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isOneResultsPageOnly', true )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pagesCount', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 0 )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'pagination', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_pagination' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'paginationLinks', 'ssr_pagination' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'tabs', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_tabs' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'tabs', 'ssr_tabs' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'query', $query )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsPerPage', WikiaSearchController::RESULTS_PER_PAGE )
		;
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'getFullUrl' )
			->will		( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pageUrl', 'foo.wikia.com' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'solrHost', 'search' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isInterWiki', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getHub' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hub', false )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hasArticleMatch', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isMonobook', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isCorporateWiki', false )
		;

		$reflReq = new ReflectionProperty( 'WikiaSearchController', 'request' );
		$reflReq->setAccessible( true );
		$reflReq->setValue( $mockController, $mockRequest );

		$reflResp = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$reflResp->setAccessible( true );
		$reflResp->setValue( $mockController, $mockResponse );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$reflWf = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockController, $mockWf );

		$reflSearch = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$reflSearch->setAccessible( true );
		$reflSearch->setValue( $mockController, $mockSearch );

		$this->mockClass( 'JSSnippets', $mockJsSnippets );
		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();

		$mockController->index();

		$this->assertEquals(
				true,
				$mockController->wg->SuppressRail,
				'WikiaSearchController::index should set wgSuppressRail to false'
		);
	}

	/**
	 * @covers WikiaSearchController::index
	 */
	public function testIndexDefaultOnWikiaDotCom() {
		$configMethods = array(
				'setQuery', 'setCityId', 'setLimit', 'setPage', 'setRank', 'setDebug', 'setSkipCache',
				'setAdvanced', 'setHub', 'setRedirs', 'getAdvanced', 'setIsInterWiki', 'setVideoSearch',
				'setGroupResults', 'isInterWiki', 'setFilterQueriesFromCodes', 'getResults',
				'getResultsFound', 'getTruncatedResultsNum', 'getNumPages', 'getPage', 'getQuery', 'getLimit',
				'getDebug', 'getIsInterWiki', 'getNamespaces', 'getHub', 'hasArticleMatch', 'getQueryNoQuotes'
				);

		$controllerMethods = array(
				'handleSkinSettings', 'getVal', 'isCorporateWiki', 'setVal',
				'setNamespacesFromRequest', 'sendSelfRequest', 'handleArticleMatchTracking'
				);

		$mockController	=	$this->searchController
								->disableOriginalConstructor()
								->setMethods( $controllerMethods )
								->getMock();

		$mockOut		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'addHTML', 'setPageTitle' ) )
								->getMock();

		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'getBool' ) )
								->getMock();

		$mockUser		=	$this->getMockBuilder( 'User' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSkin' ) )
								->getMock();

		$mockConfig		=	$this->getMockBuilder( 'WikiaSearchConfig' )
								->disableOriginalConstructor()
								->setMethods( $configMethods )
								->getMock();

		$mockLang		=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->setMethods( array( 'formatNum' ) )
								->getMock();

		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMatch', 'doSearch' ) )
								->getMock();

		$mockWf			=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
								->disableOriginalConstructor()
								->setMethods( array( 'msg' ) )
								->getMock();

		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFormat' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFullUrl' ) )
								->getMock();

		$mockOasis		=	$this->getMockBuilder( 'OasisController' )
								->disableOriginalConstructor()
								->setMethods( array( 'addBodyClass' ) )
								->getMock();

		$mockTrack		=	$this->getMock( 'Track' );

		$mockJsSnippets	=	$this->getMock( 'JSSnippets', array( 'addToStack' ) );

		$mockWg			=	( object ) array(
								'Out'			=>	$mockOut,
								'User'			=>	$mockUser,
								'suppressRail'	=>	false,
								'CityId'		=>	123,
								'Sitename'		=>	'Sitename',
								'Lang'			=>	$mockLang,
								'Title'			=>	$mockTitle,
								'SolrHost'		=>	'search'
								);


		$query = 'my mock query';

		$controllerIncr = 0;
		$configIncr = 0;
		$requestIncr = 0;

		$mockJsSnippets
			->expects	( $this->once() )
			->method	( 'addToStack' )
			->with		( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) )
			->will		( $this->returnValue( 'mocksnippet' ) );
		;
		$mockOut
			->expects	( $this->at( 0 ) )
			->method	( 'addHTML' )
			->with		( 'mocksnippet' )
		;
		$mockUser
			->expects	( $this->any() )
			->method	( 'getSkin' )
			->will		( $this->returnValue( 'Oasis' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleSkinSettings' )
			->with		( 'Oasis' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'search' )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'query', $query )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setCityId' )
			->with		( $mockWg->CityId )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'limit', WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setLimit' )
			->with		( WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'page', 1 )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setPage' )
			->with		( 1 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'rank', 'default' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRank' )
			->with		( 'default' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'debug', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setDebug' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'skipCache', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setSkipCache' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'advanced', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setAdvanced' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'nohub' )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'hub', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setHub' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRedirs' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'crossWikia', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setIsInterWiki' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'videoSearch', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setVideoSearch' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'isInterWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setGroupResults' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'filters', array() )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setFilterQueriesFromCodes' )
			->with		( array() )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setNamespacesFromRequest' )
			->with		( $mockConfig, $mockUser )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( true ) )
		;
		/* @todo: still not working
		$mockOasis
			::staticExpects	( $this->once() )
			->method		( 'addBodyClass' )
			->with			( 'inter-wiki-search' )
		; */
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getMatch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleArticleMatchTracking' )
			->with		( $mockConfig, $mockTrack )
		;
		$mockSearch
			->expects	( $this->at( 1 ) )
			->method	( 'doSearch' )
			->with		( $mockConfig )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( $query ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'msg' )
			->with		( 'wikiasearch2-page-title-with-query', array( 'My Mock Query' , 'Sitename' ) )
			->will		( $this->returnValue( 'Search results for My Mock Query | Sitename' ) )
		;
		$mockOut
			->expects	( $this->at( 1 ) )
			->method	( 'setPageTitle' )
			->with		( 'Search results for My Mock Query | Sitename' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'advancedBox', array( 'config' => $mockConfig ) )
			->will		( $this->returnValue( 'ssr_advanced_result' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'advancedSearchBox', 'ssr_advanced_result' )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'getFormat' )
			->will		( $this->returnValue( 'html' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'results', $mockResultSet )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFound', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getTruncatedResultsNum' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'formatNum' )
			->with		( 20 )
			->will		( $this->returnValue( 20 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFoundTruncated', 20 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isOneResultsPageOnly', true )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pagesCount', 1 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 1 )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'pagination', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_pagination' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'paginationLinks', 'ssr_pagination' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'tabs', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_tabs' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'tabs', 'ssr_tabs' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'query', $query )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsPerPage', WikiaSearchController::RESULTS_PER_PAGE )
		;
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'getFullUrl' )
			->will		( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pageUrl', 'foo.wikia.com' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'solrHost', 'search' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isInterWiki', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getHub' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hub', false )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hasArticleMatch', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isMonobook', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isCorporateWiki', false )
		;

		$reflReq = new ReflectionProperty( 'WikiaSearchController', 'request' );
		$reflReq->setAccessible( true );
		$reflReq->setValue( $mockController, $mockRequest );

		$reflResp = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$reflResp->setAccessible( true );
		$reflResp->setValue( $mockController, $mockResponse );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$reflWf = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockController, $mockWf );

		$reflSearch = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$reflSearch->setAccessible( true );
		$reflSearch->setValue( $mockController, $mockSearch );

		$this->mockClass( 'JSSnippets', $mockJsSnippets );
		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'OasisController', $mockOasis );
		$this->mockApp();

		$mockController->index();

		$this->assertEquals(
				true,
				$mockController->wg->SuppressRail,
				'WikiaSearchController::index should set wgSuppressRail to false'
		);
	}

	/**
	 * @covers WikiaSearchController::index
	 */
	public function testIndexDefaultOnWikiaDotComNoQuery() {
		$configMethods = array(
				'setQuery', 'setCityId', 'setLimit', 'setPage', 'setRank', 'setDebug', 'setSkipCache',
				'setAdvanced', 'setHub', 'setRedirs', 'getAdvanced', 'setIsInterWiki', 'setVideoSearch',
				'setGroupResults', 'isInterWiki', 'setFilterQueriesFromCodes', 'getResults',
				'getResultsFound', 'getTruncatedResultsNum', 'getNumPages', 'getPage', 'getQuery', 'getLimit',
				'getDebug', 'getIsInterWiki', 'getNamespaces', 'getHub', 'hasArticleMatch', 'getQueryNoQuotes'
				);

		$controllerMethods = array(
				'handleSkinSettings', 'getVal', 'isCorporateWiki', 'setVal',
				'setNamespacesFromRequest', 'sendSelfRequest', 'handleArticleMatchTracking'
				);

		$mockController	=	$this->searchController
								->disableOriginalConstructor()
								->setMethods( $controllerMethods )
								->getMock();

		$mockOut		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'addHTML', 'setPageTitle' ) )
								->getMock();

		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'getBool' ) )
								->getMock();

		$mockUser		=	$this->getMockBuilder( 'User' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSkin' ) )
								->getMock();

		$mockConfig		=	$this->getMockBuilder( 'WikiaSearchConfig' )
								->disableOriginalConstructor()
								->setMethods( $configMethods )
								->getMock();

		$mockLang		=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->setMethods( array( 'formatNum' ) )
								->getMock();

		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMatch', 'doSearch' ) )
								->getMock();

		$mockWf			=	$this->getMockBuilder( 'WikiaFunctionWrapper' )
								->disableOriginalConstructor()
								->setMethods( array( 'msg' ) )
								->getMock();

		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFormat' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFullUrl' ) )
								->getMock();

		$mockOasis		=	$this->getMockBuilder( 'OasisController' )
								->disableOriginalConstructor()
								->setMethods( array( 'addBodyClass' ) )
								->getMock();

		$mockTrack		=	$this->getMock( 'Track' );

		$mockJsSnippets	=	$this->getMock( 'JSSnippets', array( 'addToStack' ) );

		$mockWg			=	( object ) array(
								'Out'			=>	$mockOut,
								'User'			=>	$mockUser,
								'suppressRail'	=>	false,
								'CityId'		=>	123,
								'Sitename'		=>	'Sitename',
								'Lang'			=>	$mockLang,
								'Title'			=>	$mockTitle,
								'SolrHost'		=>	'search'
								);


		$query = '';

		$controllerIncr = 0;
		$configIncr = 0;
		$requestIncr = 0;

		$mockJsSnippets
			->expects	( $this->once() )
			->method	( 'addToStack' )
			->with		( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) )
			->will		( $this->returnValue( 'mocksnippet' ) );
		;
		$mockOut
			->expects	( $this->at( 0 ) )
			->method	( 'addHTML' )
			->with		( 'mocksnippet' )
		;
		$mockUser
			->expects	( $this->any() )
			->method	( 'getSkin' )
			->will		( $this->returnValue( 'Oasis' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'handleSkinSettings' )
			->with		( 'Oasis' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'search' )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'query', $query )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setCityId' )
			->with		( $mockWg->CityId )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'limit', WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setLimit' )
			->with		( WikiaSearchController::RESULTS_PER_PAGE )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'page', 1 )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setPage' )
			->with		( 1 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'rank', 'default' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRank' )
			->with		( 'default' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'debug', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setDebug' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'skipCache', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setSkipCache' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'advanced', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setAdvanced' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'nohub' )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'hub', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setHub' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setRedirs' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
			->expects	( $this->at( $requestIncr++ ) )
			->method	( 'getBool' )
			->with		( 'crossWikia', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setIsInterWiki' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'videoSearch', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setVideoSearch' )
			->with		( false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'isInterWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setGroupResults' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'filters', array() )
			->will		( $this->returnValue( array() ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'setFilterQueriesFromCodes' )
			->with		( array() )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setNamespacesFromRequest' )
			->with		( $mockConfig, $mockUser )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( true ) )
		;
		/* @todo: still not working
		$mockOasis
			::staticExpects	( $this->once() )
			->method		( 'addBodyClass' )
			->with			( 'inter-wiki-search' )
		; */
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'msg' )
			->with		( 'wikiasearch2-page-title-no-query-interwiki' )
			->will		( $this->returnValue( 'Please enter a search term' ) )
		;
		$mockOut
			->expects	( $this->at( 1 ) )
			->method	( 'setPageTitle' )
			->with		( 'Please enter a search term' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'advancedBox', array( 'config' => $mockConfig ) )
			->will		( $this->returnValue( 'ssr_advanced_result' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'advancedSearchBox', 'ssr_advanced_result' )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'getFormat' )
			->will		( $this->returnValue( 'html' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'results', $mockResultSet )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFound', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getTruncatedResultsNum' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'formatNum' )
			->with		( 0 )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsFoundTruncated', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isOneResultsPageOnly', true )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pagesCount', 0 )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 0 )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'pagination', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_pagination' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'paginationLinks', 'ssr_pagination' )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'sendSelfRequest' )
			->with		( 'tabs', array( 'config' => $mockConfig, 'by_category' => false ) )
			->will		( $this->returnValue( 'ssr_tabs' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'tabs', 'ssr_tabs' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( $query ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'query', $query )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( WikiaSearchController::RESULTS_PER_PAGE ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'resultsPerPage', WikiaSearchController::RESULTS_PER_PAGE )
		;
		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'getFullUrl' )
			->will		( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'pageUrl', 'foo.wikia.com' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'solrHost', 'search' )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isInterWiki', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'getHub' )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hub', false )
		;
		$mockConfig
			->expects	( $this->at( $configIncr++ ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'hasArticleMatch', true )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isMonobook', false )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'isCorporateWiki' )
			->will		( $this->returnValue( true ) )
		;
		$mockController
			->expects	( $this->at( $controllerIncr++ ) )
			->method	( 'setVal' )
			->with		( 'isCorporateWiki', true )
		;

		$reflReq = new ReflectionProperty( 'WikiaSearchController', 'request' );
		$reflReq->setAccessible( true );
		$reflReq->setValue( $mockController, $mockRequest );

		$reflResp = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$reflResp->setAccessible( true );
		$reflResp->setValue( $mockController, $mockResponse );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$reflWf = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockController, $mockWf );

		$reflSearch = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$reflSearch->setAccessible( true );
		$reflSearch->setValue( $mockController, $mockSearch );

		$this->mockClass( 'JSSnippets', $mockJsSnippets );
		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'OasisController', $mockOasis );
		$this->mockApp();

		$mockController->index();

		$this->assertEquals(
				true,
				$mockController->wg->SuppressRail,
				'WikiaSearchController::index should set wgSuppressRail to false'
		);
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

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );

		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );

		$this->mockClass( 'Title', $mockTitle );
		$this->mockApp();

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig, $mockTrack ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithoutMatch() {

		$mockController = $this->searchController->setMethods( array( 'getVal' ) )->getMock();

		$searchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getArticleMatch' ) );
		$mockTitle			=	$this->getMock( 'Title',  array( 'newFromText', 'getFullUrl' ) );
		$mockArticle		=	$this->getMock( 'Article', array( 'getTitle' ), array( $mockTitle ) );
		$mockArticleMatch	=	$this->getMock( 'WikiaSearchArticleMatch', array( 'getArticle' ), array( $mockArticle ) );
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockWrapper		=	$this->getMock( 'WikiaFunctionWrapper', array( 'RunHooks' ) );
		$mockTrack			=	$this->getMock( 'Track' );

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

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );

		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );


		$this->mockClass( 'Title', $mockTitle );
		$this->mockApp();

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig, $mockTrack ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testHandleArticleMatchTrackingWithoutGoSearch() {

		$mockController		=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();

		$searchConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getArticleMatch' ) );
		$mockArticleMatch	=	$this->getMockBuilder( 'WikiaSearchArticleMatch' )->disableOriginalConstructor()->getMock();
		$mockTrack			=	$this->getMock( 'Track', array( 'event' ) );
		$mockWrapper		=	$this->getMock( 'WikiaFunctionWrapper', array( 'RunHooks' ) );

		$searchConfig
			->expects	( $this->once() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( $mockArticleMatch ) )
		;
		$searchConfig
			->expects	( $this->once() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( 'unittestfoo' ) )
		;
		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( 'Search' ) )
		;

		$wfrefl = new ReflectionProperty( 'WikiaSearchController', 'wf' );
		$wfrefl->setAccessible( true );
		$wfrefl->setValue( $mockController, $mockWrapper );

		$this->mockApp();

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig, $mockTrack ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}


	/**
	 * @covers WikiaSearchController
	 */
	public function testOnWikiaMobileAssetsPackages() {

		$mockSearch		= $this->getMockBuilder( 'WikiaSearch' )->disableOriginalConstructor()->getMock();
		$mockIndexer	= $this->getMockBuilder( 'WikiaSearchIndexer' )->disableOriginalConstructor()->getMock();
		$controller		= F::build( 'WikiaSearchController', array( $mockSearch, $mockIndexer ) );

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
				$controller->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
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
		        $controller->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
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
	public function testPaginationWithoutConfig() {

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
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( false ) )
		;
		$e = null;
		try {
			$mockController->pagination();
			$this->assertFalse(
					true,
					'WikiaSearchController::pagination should throw an exception if the "config" is not set in the request.'
			);
		} catch ( Exception $e ) { }

		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::pagination should throw an exception if an instance of WikiaSearchConfig is not set in the request'
		);
	}

	public function testPaginationMalformedConfig() {

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
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		$e = null;
		try {
			$mockController->pagination();
			$this->assertFalse(
					true,
					'WikiaSearchController::pagination should throw an exception if the "config" is not set in the request.'
			);
		} catch ( Exception $e ) { }

		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::pagination should throw an exception if an instance of WikiaSearchConfig is not set in the request'
		);
	}


	/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationWithConfigNoResults1() {
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
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( false ) )
		;
		$this->assertFalse(
				$mockController->pagination(),
				'WikiaSearchController::pagination should return false if search config set in the request does not have its resultsFound value set, or that value is 0.'
		);
	}

/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationWithConfigNoResults2() {
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
	}

	/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationWithConfig() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockTitle			=	$this->getMockBuilder( 'Title' )->disableOriginalConstructor()->getMock();
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect', 'setVal' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$configMethods		=	array( 'getResultsFound', 'getPage', 'getQuery', 'getNumPages', 'getIsInterWiki',
										'getSkipCache', 'getDebug', 'getNamespaces', 'getAdvanced', 'getIncludeRedirects',
										'getLimit', 'getPublicFilterKeys', 'getRank' );
		$mockConfig			=	$this->getMock( 'WikiaSearchConfig', $configMethods );

		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'Title' => $mockTitle ) );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$incr = 0;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 10 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getNumPages' )
			->will		( $this->returnValue( 10 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getSkipCache' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getDebug' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( NS_MAIN ) ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getAdvanced' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getIncludeRedirects' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getLimit' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getPublicFilterKeys' )
			->will		( $this->returnValue( array( 'is_image' ) ) )
		;
		$mockConfig
			->expects	( $this->at( $incr++ ) )
			->method	( 'getRank' )
			->will		( $this->returnValue( 'default' ) )
		;
		$incr2 = 1;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'query', 'foo' )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'pagesNum', '10' )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'currentPage', 2 )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'windowFirstPage', 1 )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'windowLastPage', 7 )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'pageTitle', $mockTitle )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'crossWikia', false )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'resultsCount', 200 )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'skipCache', false )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'debug', false )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( NS_MAIN ) )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'advanced', false )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'redirs', false )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'limit', 20 )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'filters', array( 'is_image' ) )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'rank', 'default' )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
		;
		$mockController
			->expects	( $this->at( $incr2++ ) )
			->method	( 'setVal' )
			->with		( 'by_category', false )
		;


		$mockController->pagination();
	}

	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabsWithoutConfig() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockController
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( false ) )
		;
		$e = null;
		$this->mockApp();
		try {
		    $mockController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::tabs should throw an exception if search config is not set'
		);
	}

	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabsWithBadConfig() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockController
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		$e = null;
		$this->mockApp();
		try {
		    $mockController->tabs();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::tabs should throw an exception if the "config" is not set in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::tabs should throw an exception if search config is set incorrectly'
		);
	}

	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabs() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchConfig	=	$this->getMockBuilder( 'WikiaSearchConfig' )
									->disableOriginalConstructor()
									->setMethods( array( 'getNamespaces', 'getQuery', 'getSearchProfiles', 'getIncludeRedirects', 'getActiveTab', 'getFilterQueries', 'getRank' ) )
									->getMock();

		$this->mockGlobalVariable( 'wgDefaultSearchProfile', SEARCH_PROFILE_DEFAULT );

		$defaultNamespaces = array( NS_MAIN, NS_CATEGORY );

		$searchProfileArray = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => SearchEngine::namespacesAsText( $defaultNamespaces ),
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
	                    'namespaces' => array( NS_MAIN, NS_TALK, NS_CATEGORY, NS_CATEGORY_TALK, NS_FILE, NS_USER ),
	            ),
	            SEARCH_PROFILE_ADVANCED => array(
	                    'message' => 'searchprofile-advanced',
	                    'tooltip' => 'searchprofile-advanced-tooltip',
	                    'namespaces' => array( NS_MAIN, NS_CATEGORY ),
	                    'parameters' => array( 'advanced' => 1 ),
	            )
		);

		$form = array(
				'no_filter' =>          false,
				'by_category' =>        false,
				'cat_videogames' =>     false,
				'cat_entertainment' =>  false,
				'cat_lifestyle' =>      false,
				'is_hd' =>              false,
				'is_image' =>           false,
				'is_video' =>           false,
				'sort_default' =>       true,
				'sort_longest' =>       false,
				'sort_newest' =>        false,
				'no_filter' =>          true,
		);

		$incr = 0;

		$wg = (object) array( 'CityId' => 123 );

		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getFilterQueries' )
			->will		( $this->returnValue( array() ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getRank' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
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
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'bareterm', 'foo' )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'searchProfiles', $searchProfileArray )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'redirs', false )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'activeTab', 'default' )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'form', $form )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'is_video_wiki', false )
		;

		$this->mockApp();

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $wg );

		$mockController->tabs();
	}

	/**
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabsVideoWithNoFilter() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchConfig	=	$this->getMockBuilder( 'WikiaSearchConfig' )
									->disableOriginalConstructor()
									->setMethods( array( 'getNamespaces', 'getQuery', 'getSearchProfiles', 'getIncludeRedirects', 'getActiveTab', 'getFilterQueries', 'getRank' ) )
									->getMock();

		$this->mockGlobalVariable( 'wgDefaultSearchProfile', SEARCH_PROFILE_DEFAULT );

		$defaultNamespaces = array( NS_MAIN, NS_CATEGORY );

		$searchProfileArray = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => SearchEngine::namespacesAsText( $defaultNamespaces ),
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
	                    'namespaces' => array( NS_MAIN, NS_TALK, NS_CATEGORY, NS_CATEGORY_TALK, NS_FILE, NS_USER ),
	            ),
	            SEARCH_PROFILE_ADVANCED => array(
	                    'message' => 'searchprofile-advanced',
	                    'tooltip' => 'searchprofile-advanced-tooltip',
	                    'namespaces' => array( NS_MAIN, NS_CATEGORY ),
	                    'parameters' => array( 'advanced' => 1 ),
	            )
		);

		$form = array(
				'no_filter' =>          0,
				'by_category' =>        false,
				'cat_videogames' =>     false,
				'cat_entertainment' =>  false,
				'cat_lifestyle' =>      false,
				'is_hd' =>              false,
				'is_image' =>           false,
				'is_video' =>           1,
				'sort_default' =>       true,
				'sort_longest' =>       false,
				'sort_newest' =>        false,
		);

		$incr = 0;

		$wg = (object) array( 'CityId' => WikiaSearch::VIDEO_WIKI_ID );

		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getFilterQueries' )
			->will		( $this->returnValue( array() ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getRank' )
			->will		( $this->returnValue( 'default' ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'by_category', false )
			->will		( $this->returnValue( false ) )
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
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'bareterm', 'foo' )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'searchProfiles', $searchProfileArray )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'redirs', false )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'activeTab', 'default' )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'form', $form )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'is_video_wiki', true )
		;

		$this->mockApp();

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $wg );

		$mockController->tabs();
	}

	/**
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBoxWithoutConfig() {
		$mockController			=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();

		$mockController
			->expects	( $this->any() )
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

	}

	/**
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBoxWithBadConfig() {
		$mockController			=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();

		$mockController
			->expects	( $this->any() )
			->method	( 'getVal' )
			->with		( 'config', false )
			->will		( $this->returnValue( 'foo' ) )
		;
		$e = null;
		try {
		    $mockController->advancedBox();
		    $this->assertFalse(
		            true,
		            'WikiaSearchController::advancedBox should throw an exception if the "config" is set incorrectly in the request.'
		    );
		} catch ( Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::advancedBox should throw an exception if there is an improper search config set'
		);

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
			->expects	( $this->any() )
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
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'namespaces', array( 0, 14 ) )
		;
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'searchableNamespaces', $searchableNamespaces )
		;
		$mockController
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'redirs', true )
		;
		$mockController
			->expects	( $this->at( 4 ) )
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

		$this->assertFalse(
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
	public function testSetNamespacesFromRequestHasNamespaces() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchEngine	=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces', 'DefaultNamespaces' ) );
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$defaultArray		=	array( 0, 14 );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockUser			=	$this->getMock( 'User', array( 'getOption' ) );
		$mockSearchConfig	=	$this->getMock( 'WikiaSearchConfig', array( 'setNamespaces', 'getSearchProfiles' ) );

		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableArray ) )
		;
		$incr = 0;
		foreach ( $searchableArray as $ns => $name ) {
			$bool = $ns == 14;
			$mockController
				->expects		( $this->at( $incr++ ) )
				->method		( 'getVal' )
				->with			( 'ns'.$ns, false )
				->will			( $this->returnValue( $bool ) )
			;
		}
		$mockSearchConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setNamespaces' )
			->with		( array( 14 ) )
		;

		$this->mockClass( 'SearchEngine', $mockSearchEngine );
		$this->mockApp();


		$method = new ReflectionMethod( 'WikiaSearchController', 'setNamespacesFromRequest' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $mockSearchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::setNamespacesFromRequest
	 */
	public function testSetNamespacesFromRequestAllNamespaces() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchEngine	=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces', 'DefaultNamespaces' ) );
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$defaultArray		=	array( 0, 14 );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockUser			=	$this->getMock( 'User', array( 'getOption' ) );
		$mockSearchConfig	=	$this->getMock( 'WikiaSearchConfig', array( 'setNamespaces', 'getSearchProfiles' ) );

		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableArray ) )
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
			->will			( $this->returnValue( true ) )
		;
		$mockSearchConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setNamespaces' )
			->with		( array_keys($searchableArray) )
		;

		$this->mockClass( 'SearchEngine', $mockSearchEngine );
		$this->mockApp();


		$method = new ReflectionMethod( 'WikiaSearchController', 'setNamespacesFromRequest' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $mockSearchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::setNamespacesFromRequest
	 */
	public function testSetNamespacesFromRequestDefaultNamespaces() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchEngine	=	$this->getMock( 'SearchEngine', array( 'searchableNamespaces', 'DefaultNamespaces' ) );
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$defaultArray		=	array( 0, 14 );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal' ), array( array() ) );
		$mockUser			=	$this->getMock( 'User', array( 'getOption' ) );
		$mockSearchConfig	=	$this->getMock( 'WikiaSearchConfig', array( 'setNamespaces', 'getSearchProfiles' ) );

		$mockSearchEngine
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( $searchableArray ) )
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
		$mockSearchConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getSearchProfiles' )
			->will		( $this->returnValue( array( 'default' => array( 'namespaces' => $defaultArray ) ) ) )
		;
		$mockSearchConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setNamespaces' )
			->with		( $defaultArray )
		;

		$this->mockClass( 'SearchEngine', $mockSearchEngine );
		$this->mockApp();


		$method = new ReflectionMethod( 'WikiaSearchController', 'setNamespacesFromRequest' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $mockSearchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::getKeywords
	 */
	public function testGetKeywordsBreaks() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();

		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'id' )
			->will		( $this->returnValue( null ) )
		;

		try {
			$mockController->getKeywords();
		} catch ( Exception $e ) { }

		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::getKeywords should throw an exception if not passed an id via request'
		);

	}

	/**
	 * @covers WikiaSearchController::getKeywords
	 */
	public function testGetKeywordsWorks() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )->setMethods( array( 'getKeywords' ) )->disableOriginalConstructor()->getMock();
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setPageId' ) );
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$responseArray = array( 'foo' => 'bar' );
		$id = 123;

		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'id' )
			->will		( $this->returnValue( $id ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setPageId' )
			->with		( $id )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'getKeywords' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $responseArray ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $responseArray )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$mockController->getKeywords();
	}

	/**
	 * @covers WikiaSearchController::getSimilarPagesExternal
	 */
	public function testGetSimilarPagesExternalWithQuery() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setQuery', 'setStreamUrl', 'setStreamBody' ) );
		$mockController	=	$this->searchController
								->setMethods( array( 'getVal' ) )
								->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'getSimilarPages' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$responseArr = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'q', null )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'url', null )
			->will		( $this->returnValue( 'foo.com' ) )
		;
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'contents', null )
			->will		( $this->returnValue( 'the contents are foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setQuery' )
			->with		( 'foo' )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSimilarPages' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $responseArr ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $responseArr )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$mockController->getSimilarPagesExternal();

	}

	/**
	 * @covers WikiaSearchController::getSimilarPagesExternal
	 */
	public function testGetSimilarPagesExternalWithStreamUrl() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setQuery', 'setStreamUrl', 'setStreamBody' ) );
		$mockController	=	$this->searchController
								->setMethods( array( 'getVal' ) )
								->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'getSimilarPages' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$responseArr = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'q', null )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'url', null )
			->will		( $this->returnValue( 'foo.com' ) )
		;
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'contents', null )
			->will		( $this->returnValue( 'the contents are foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setStreamUrl' )
			->with		( 'foo.com' )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSimilarPages' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $responseArr ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $responseArr )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$mockController->getSimilarPagesExternal();
	}

	/**
	 * @covers WikiaSearchController::getSimilarPagesExternal
	 */
	public function testGetSimilarPagesExternalWithStreamBody() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setQuery', 'setStreamUrl', 'setStreamBody' ) );
		$mockController	=	$this->searchController
								->setMethods( array( 'getVal' ) )
								->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'getSimilarPages' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$responseArr = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'q', null )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'url', null )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'contents', null )
			->will		( $this->returnValue( 'the contents are foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setStreamBody' )
			->with		( 'the contents are foo' )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSimilarPages' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $responseArr ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $responseArr )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$mockController->getSimilarPagesExternal();
	}

	/**
	 * @covers WikiaSearchController::getSimilarPagesExternal
	 */
	public function testGetSimilarPagesExternalWithNothing() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setQuery', 'setStreamUrl', 'setStreamBody' ) );
		$mockController	=	$this->searchController
								->setMethods( array( 'getVal' ) )
								->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'getSimilarPages' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$responseArr = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'q', null )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'url', null )
			->will		( $this->returnValue( null ) )
		;
		$mockController
			->expects	( $this->at( 2 ) )
			->method	( 'getVal' )
			->with		( 'contents', null )
			->will		( $this->returnValue( null ) )
		;

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		try {
			$mockController->getSimilarPagesExternal();
		} catch ( Exception $e ) { }

		$this->assertInstanceOf(
				'Exception',
				$e,
				'WikiaSearchController::getSimilarPagesExternal should throw an exception if a query, url, or stream body is not set'
		);
	}

	/**
	 * @covers WikiaSearchController::videoSearch
	 */
	public function testVideoSearch() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setCityId', 'setQuery', 'setNamespaces', 'setVideoSearch', 'getResults' ) );
		$mockController	=	$this->searchController->setMethods( array( 'getResponse', 'getVal' ) )->getMock();
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'doSearch' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResults	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'toNestedArray' ) )
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'cityId' => 123 ) );

		$responseArr = array( 'foo' => 'bar' );

		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setCityId' )
			->with		( 123 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'q' )
			->will		( $this->returnValue( 'query' ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setQuery' )
			->with		( 'query' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setNamespaces' )
			->with		( array( NS_FILE ) )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'setVideoSearch' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'doSearch' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResults ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResults ) )
		;
		$mockConfig
			->expects	( $this->at( 5 ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResults ) )
		;
		$mockResults
			->expects	( $this->at( 0 ) )
			->method	( 'toNestedArray' )
			->will		( $this->returnValue( $responseArr ) )
		;
		$mockController
			->expects	( $this->any() )
			->method	( 'getResponse' )
			->will		( $this->returnValue( $mockResponse ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setData' )
			->with		( $responseArr )
		;

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$mockController->videoSearch();
	}

	/**
	 * @covers WikiaSearchController::getRelatedVideos
	 */
	public function testGetRelatedVideos() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'setPageId', 'setStart', 'setSize' ) );
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->setMethods( array( 'getRelatedVideos' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResults	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'toNestedArray' ) )
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockDocument	=	$this->getMockBuilder( 'Solarium_Document_ReadOnly' )
								->disableOriginalConstructor()
								->setMethods( array( 'getFields', 'offsetGet' ) )
								->getMock();

		$responseArr = array( 'foo.com' => array( 'id' => 123, 'html' => 'foo' ) );

		$mockController
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'id', false )
			->will		( $this->returnValue( 123 ) )
		;
		$mockController
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'id' )
			->will		( $this->returnValue( 123 ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setPageId' )
			->with		( 123 )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setStart' )
			->with		( 0 )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setSize' )
			->with		( 20 )
		;
		$mockDocument
			->expects	( $this->once() )
			->method	( 'offsetGet' )
			->with		( 'url' )
			->will		( $this->returnValue( 'foo.com' ) )
		;
		$mockDocument
			->expects	( $this->once() )
			->method	( 'getFields' )
			->will		( $this->returnValue( array( 'id' => 123, 'html' => 'foo' ) ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $responseArr )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$resultsRefl = new ReflectionProperty( 'WikiaSearchResultSet', 'results' );
		$resultsRefl->setAccessible( true );
		$resultsRefl->setValue( $mockResults, array( $mockDocument ) );

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearch' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockSearch );

		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getRelatedVideos' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResults ) )
		;

		$this->mockClass( 'WikiaSearchConfig', $mockConfig );
		$this->mockApp();

		$mockController->getRelatedVideos();

	}

	/**
	 * @covers WikiaSearchController::getPages
	 */
	public function testGetPages() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setMethods( array( 'getPages' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$mockRetVal = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'ids' )
			->will		( $this->returnValue( '123|321' ) )
		;
		$mockIndexer
			->expects	( $this->once() )
			->method	( 'getPages' )
			->with		( array( '123', '321' ) )
			->will		( $this->returnValue( $mockRetVal ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $mockRetVal )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearchIndexer' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockIndexer );

		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'AllowMemcacheWrites' => true ) );

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$mockController->getPages();

		$this->assertFalse(
				$mockController->wg->AllowMemcacheWrites,
				'WikiaSearchController::getPages should set wgAllowMemcacheWrites to false'
		);

	}

	/**
	 * @covers WikiaSearchController::getPage
	 */
	public function testGetPage() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setMethods( array( 'getPage' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$mockRetVal = array( 'foo' => 'bar' );

		$mockController
			->expects	( $this->once() )
			->method	( 'getVal' )
			->with		( 'id' )
			->will		( $this->returnValue( 123 ) )
		;
		$mockIndexer
			->expects	( $this->once() )
			->method	( 'getPage' )
			->with		( '123' )
			->will		( $this->returnValue( $mockRetVal ) )
		;
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setData' )
			->with		( $mockRetVal )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setFormat' )
			->with		( 'json' )
		;

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'wikiaSearchIndexer' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockIndexer );

		$respRefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$respRefl->setAccessible( true );
		$respRefl->setValue( $mockController, $mockResponse );

		$mockController->getPage();

	}

	/**
	 * @covers WikiaSearchController::advancedTabLink
	 */
	public function testAdvancedTabLink() {

		$term = 'foo';
		$namespaces = array( 0, 14 );
		$label = 'bar';
		$class = str_replace( ' ', '-', strtolower( $label ) );
		$tooltip = 'tooltip';
		$params = array( 'filters' => array('is_video') );
		$redirs = false;
		$href = 'foo.com';

		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSpecialPage	=	$this->getMockBuilder( 'SpecialPage' )
									->disableOriginalConstructor()
									->setMethods( array( 'getLocalURL' ) )
									->getMock();

		$stParams = array(
				'search'	=>	$term,
				'filters'	=>	array( 'is_video' ),
				'ns0'		=>	1,
				'ns14'		=>	1,
				'redirs'	=>	0
		);

		$incr = 0;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'term' )
			->will		( $this->returnValue( $term ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'namespaces' )
			->will		( $this->returnValue( $namespaces ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'label' )
			->will		( $this->returnValue( $label ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'tooltip' )
			->will		( $this->returnValue( $tooltip ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'params' )
			->will		( $this->returnValue( $params ) )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'getVal' )
			->with		( 'redirs' )
			->will		( $this->returnValue( $redirs ) )
		;
		$mockSpecialPage
			->expects	( $this->once() )
			->method	( 'getLocalURL' )
			->with		( $stParams )
			->will		( $this->returnValue( $href ) );
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'class', $class )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'href', $href )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'title', $tooltip )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'label', $label )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'tooltip', $tooltip )
		;
		$this->mockClass( 'SpecialPage', $mockSpecialPage );
		$this->mockApp();

		$mockController->advancedTabLink();
	}
}