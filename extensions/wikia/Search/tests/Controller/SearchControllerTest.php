<?php
/**
 * Class definition for Wikia\Search\Test\Controller\ControllerTest
 */
namespace Wikia\Search\Test\Controller;
use Exception;
use ReflectionMethod;
use ReflectionProperty;
use SearchEngine;
use Title;
use Wikia;
use Wikia\Search\SearchResult;
use Wikia\Search\Test\BaseTest;
use WikiaSearchController;

/**
 * Tests WikiaSearchController, currently in global namespace
 */
class SearchControllerTest extends BaseTest {

	/** @var \PHPUnit_Framework_MockObject_MockObject|WikiaSearchController $searchController */
	private $searchController;

	/** @var \PHPUnit_Framework_MockObject_MockObject|Wikia\Search\QueryService\Factory $mockFactory */
	private $mockFactory;

	protected function setUp() {
		parent::setUp();
		$this->searchController = $this->getMockBuilder( WikiaSearchController::class );
		$this->mockFactory = $this->getMockBuilder( Wikia\Search\QueryService\Factory::class )
			->setMethods( [ 'get', 'getFromConfig' ] )
			->getMock();

		$this->mockClass( 'Wikia\Search\QueryService\Factory', $this->mockFactory );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09205 ms
	 * @covers WikiaSearchController::index
	 */
	public function testIndex() {
		$methods = array( 'handleSkinSettings', 'getSearchConfigFromRequest', 'getResponse',
				'handleArticleMatchTracking', 'setPageTitle', 'setResponseValues', 'setJsonResponse',
				'getVal', 'handleLayoutAbTest' );
		$mockController = $this->searchController->setMethods( $methods )->getMock();

		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'hasTerms' ), array( 'foo' ) );

		$mockSearch = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setMethods( array( 'search', 'getMatch' ) )
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$mockFactory = $this->getMockBuilder( 'Wikia\Search\QueryService\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getFromConfig' ) )
		                    ->getMock();

		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
			->disableOriginalConstructor()
			->setMethods( [ 'getFormat' ] )
			->getMock();

		$mockController->expects( $this->once() )
			->method	( 'getResponse' )
			->will		( $this->returnValue( $mockResponse ) )
		;

		$mockResponse->expects( $this->once() )
			->method( 'getFormat' )
			->will( $this->returnValue( 'html' ) )
		;

		$mockController
		    ->expects( $this->once() )
		    ->method ( 'handleSkinSettings' )
		;
		$mockController
			->expects( $this->exactly(2) )
			->method ( 'getVal' )
		;
		$mockController
			->expects( $this->once() )
			->method ( 'handleLayoutAbTest' )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'getSearchConfigFromRequest' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->exactly( 2 ) )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->with   ( $mockConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'getMatch' )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'handleArticleMatchTracking' )
		    ->with   ( $mockConfig )
		;
		$mockSearch
		    ->expects( $this->once() )
		    ->method( 'search' )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'setPageTitle' )
		    ->with   ( $mockConfig )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'setResponseValues' )
		;
		$reflProperty = new ReflectionProperty( 'WikiaSearchController', 'queryServiceFactory' );
		$reflProperty->setAccessible( true );
		$reflProperty->setValue( $mockController, $mockFactory );
		$mockController->index();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07788 ms
	 */
	public function testHandleArticleMatchTrackingPage2() {
		$mockController = $this->searchController->setMethods( null )->getMock();
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getPage' ) );
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getPage' )
		    ->will   ( $this->returnValue( 2 ) )
		;
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		$this->assertFalse(
				$method->invoke( $mockController, $mockConfig ),
				"WikiaSearchController::handleArticleMatchTracking should return false if not on page 1"
				);

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07889 ms
	 */
	public function testHandleLayoutAbTest() {
		$mockController = $this->searchController->setMethods( array( 'templateExists', 'setVal' ) )->getMock();

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleLayoutAbTest' );
		$method->setAccessible( true );

		$this->assertTrue(
			$method->invoke( $mockController, null )
		);

		$mockController
			->expects( $this->at( 0 ) )
			->method ( 'templateExists' )
			->will	 ( $this->returnValue( false ) )
		;

		$mockController
			->expects( $this->at( 1 ) )
			->method ( 'setVal' )
			->with	 ( 'resultView', WikiaSearchController::WIKIA_DEFAULT_RESULT )
		;

		$this->assertTrue(
			$method->invoke( $mockController, 'Atest' )
		);

		$mockController
			->expects( $this->at( 0 ) )
			->method ( 'templateExists' )
			->will	 ( $this->returnValue( true ) )
		;

		$mockController
			->expects( $this->at( 1 ) )
			->method ( 'setVal' )
			->with	 ( 'resultView', 'Btest' )
		;

		$this->assertTrue(
			$method->invoke( $mockController, 'Btest' )
		);

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.16654 ms
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithMatch() {
		$mockController = $this->searchController->setMethods( [ 'getVal' ] )->getMock();
		$searchConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQuery', 'getPage', 'hasArticleMatch', 'getArticleMatch' ] );
		$mockQuery = $this->getMock( 'Wikia\Search\Query', [ 'getSanitizedQuery' ] );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getFullUrl' ] )
		                  ->getMock();
		$mockResponse = $this->getMock( 'WikiaResponse', [ 'redirect' ], [ 'html' ] );
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getId' ] )
		                  ->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getTitle' ] )
		                    ->getMock();
		$mockRunHooks = $this->getStaticMethodMock( 'Hooks', 'run' );

		$redirectUrl = 'http://foo.wikia.com/Wiki/foo';

		$searchConfig
			->expects( $this->any() )
			->method( 'getPage' )
			->will( $this->returnValue( 1 ) );
		$searchConfig
		    ->expects( $this->any() )
		    ->method( 'getQuery' )
		    ->will( $this->returnValue( $mockQuery ) );
		$mockQuery
		    ->expects( $this->once() )
		    ->method( 'getSanitizedQuery' )
		    ->will( $this->returnValue( 'foo' ) );
		$searchConfig
		    ->expects( $this->any() )
		    ->method( 'getArticleMatch' )
		    ->will( $this->returnValue( $mockMatch) );
		$mockMatch
		    ->expects( $this->once() )
		    ->method( 'getId' )
		    ->will( $this->returnValue( 123 ) );
		$mockArticle
		    ->expects( $this->once() )
		    ->method( 'getTitle' )
		    ->will( $this->returnValue( $mockTitle ) );
		$searchConfig
			->expects( $this->any() )
			->method( 'hasArticleMatch' )
			->will( $this->returnValue( true ) );
		$mockController
			->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( '0' ) );
		$mockRunHooks
			->expects( $this->once() )
			->method( 'run' );
		$mockTitle
			->expects( $this->any() )
			->method( 'getFullURL' )
			->will( $this->returnValue( $redirectUrl ) );
		$mockResponse
			->expects( $this->once() )
			->method( 'redirect' )
			->with( $redirectUrl )
			->will( $this->returnValue( true ) );

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );

		$this->mockClass( 'Article', $mockArticle );
		$this->mockClass( 'Article', $mockArticle, 'newFromID' );

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.17231 ms
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testArticleMatchTrackingWithoutMatch() {

		$mockController = $this->searchController->setMethods( array( 'getVal' ) )->getMock();
		$searchConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery', 'getPage', 'hasArticleMatch' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query', array( 'getSanitizedQuery' ) );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getFullUrl' ) )
		                  ->getMock();
		$mockResponse = $this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockRunHooks = $this->getStaticMethodMock( 'Hooks', 'run' );

		$originalQuery = 'foo';

		$searchConfig
			->expects	( $this->any() )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$searchConfig
		    ->expects( $this->any() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( $originalQuery ) )
		;
		$searchConfig
			->expects	( $this->any() )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( false ) )
		;
		$mockRunHooks
		    ->expects( $this->once() )
		    ->method ( 'run' )
		    ->with   ( 'SpecialSearchNogomatch', array( $mockTitle ) )
		;


		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );

		$this->mockClass( 'Title', $mockTitle );
		$this->mockClass( 'Title', $mockTitle, 'newFromText' );

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12615 ms
	 * @covers WikiaSearchController::handleArticleMatchTracking
	 */
	public function testHandleArticleMatchTrackingWithoutGoSearch() {
		$mockController = $this->searchController->setMethods( [ 'getVal' ] )->getMock();
		$searchConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQuery', 'getPage', 'hasArticleMatch', 'getArticleMatch' ] );
		$mockQuery = $this->getMock( 'Wikia\Search\Query', [ 'getSanitizedQuery' ] );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getFullUrl' ] )
		                  ->getMock();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getId' ] )
		                  ->getMock();
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getTitle' ] )
		                    ->getMock();
		$mockResponse = $this->getMock( 'WikiaResponse', [ 'redirect' ], [ 'html' ] );

		$originalQuery = 'foo';

		$searchConfig
			->expects( $this->once() )
			->method( 'getArticleMatch' )
			->will( $this->returnValue( $mockMatch ) );
		$mockMatch
			->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 123 ) );
		$mockArticle
			->expects( $this->once() )
			->method( 'getTitle' )
			->will( $this->returnValue( $mockTitle ) );
		$searchConfig
			->expects( $this->any() )
			->method( 'getPage' )
			->will( $this->returnValue( 1 ) );
		$searchConfig
			->expects( $this->any() )
			->method( 'getQuery' )
			->will( $this->returnValue( $mockQuery ) );
		$mockQuery
			->expects( $this->once() )
			->method( 'getSanitizedQuery' )
			->will( $this->returnValue( $originalQuery ) );
		$searchConfig
			->expects( $this->any() )
			->method( 'hasArticleMatch' )
			->will( $this->returnValue( true ) );
		$mockController
			->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( 'Search' ) );

		$responserefl = new ReflectionProperty( 'WikiaSearchController', 'response' );
		$responserefl->setAccessible( true );
		$responserefl->setValue( $mockController, $mockResponse );

		$this->mockClass( 'Article', $mockArticle, 'newFromID' );

		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
	}

	/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationInvalidRequests() {
		$extRes = $this->app->sendExternalRequest( WikiaSearchController::class, 'pagination' );
		$this->assertEquals( \WikiaResponse::RESPONSE_CODE_BAD_REQUEST, $extRes->getCode(), 'Search controller pagination must not allow external requests' );
		$this->assertEmpty( $extRes->getBody(), 'Search controller pagination must render no response for external requests' );

		$intRes = $this->app->sendRequest( WikiaSearchController::class, 'pagination' );
		$this->assertEmpty( $intRes->getBody(), 'Search controller pagination must render no response if no config was supplied' );
	}

	/**
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationWithConfigNoResults() {
		$configMock = $this->getMockBuilder( Wikia\Search\Config::class )
			->getMock();
		$mockResult = $this->getMockBuilder( SearchResult::class )
			->setMethods( [ 'getResultsFound' ] )
			->getMock();

		$mockResult
			->expects( $this->once() )
			->method( 'hasResults' )
			->willReturn( true );

		$res = $this->app->sendRequest( WikiaSearchController::class, 'pagination', [
			'config' => $configMock,
			'result' => $mockResult,
		] );

		$this->assertEmpty( $res->getBody(), 'WikiaSearchController::pagination must render no response if search config set in the request does not have its resultsFound value set, or that value is 0.' );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.18153 ms
	 * @covers WikiaSearchController::pagination
	 */
	public function testPaginationWithConfig() {
		$mockQuery = $this->getMock( Wikia\Search\Query\Select::class, [ 'getSanitizedQuery' ], [ 'foo' ] );
		$mockQuery
			->expects( $this->once() )
			->method( 'getSanitizedQuery' )
			->will( $this->returnValue( 'foo' ) );

		$mockConfig = $this->getMockBuilder( Wikia\Search\Config::class )
			->setMethods([ 'getResultsFound', 'getPage', 'getQuery', 'getNumPages', 'getInterWiki',
					   'getSkipCache', 'getDebug', 'getNamespaces', 'getAdvanced',
					   'getLimit', 'getPublicFilterKeys', 'getRank' ])
			->getMock();

		$mockResult = $this->getMockBuilder( SearchResult::class )
			->setMethods( [ 'getResultsFound' ] )
			->getMock();

		$mockResult
			->expects( $this->once() )
			->method( 'hasResults' )
			->willReturn(true );

		$mockResult
			->expects( $this->once() )
			->method( 'getPage' )
			->will( $this->returnValue( 2 ) );

		$mockResult
			->expects( $this->atLeastOnce() )
			->method( 'getNumPages' )
			->will( $this->returnValue( 10 ) );

		$mockConfig
			->expects( $this->once() )
			->method( 'getQuery' )
			->will( $this->returnValue( $mockQuery ) );

		$mockConfig
			->expects( $this->once() )
			->method( 'getInterWiki' )
			->will( $this->returnValue( false ) );

		$mockConfig
			->expects( $this->once() )
			->method( 'getNamespaces' )
			->will( $this->returnValue( [ NS_MAIN ] ) );

		$mockConfig
			->expects( $this->once() )
			->method( 'getLimit' )
			->will( $this->returnValue( 20 ) );

		$mockConfig
			->expects( $this->once() )
			->method( 'getPublicFilterKeys' )
			->will( $this->returnValue( [ 'is_image' ] ) );

		$mockTitle = new Title();
		$this->mockStaticMethod( \SpecialPage::class, 'getTitleFor', $mockTitle );

		$res = $this->app->sendRequest( WikiaSearchController::class, 'pagination', [
			'config' => $mockConfig,
			'result' => $mockResult,
		] );

		$expectedExtraParams = [
			'ns0' => 1,
			'limit' => 20,
			'filters' => [ 'is_image' ]
		];
		$this->assertEquals( [
			'query' => 'foo',
			'pagesNum' => 10,
			'currentPage' => 2,
			'windowFirstPage' => 1,
			'windowLastPage' => 7,
			'extraParams' => $expectedExtraParams,
			'pageTitle' => $mockTitle
		], $res->getData() );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.10098 ms
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
	 * @group Slow
	 * @slowExecutionTime 0.07783 ms
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
	 * @group Slow
	 * @slowExecutionTime 0.11167 ms
	 * @covers WikiaSearchController::tabs
	 */
	public function testTabs() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSearchConfig	=	$this->getMockBuilder( 'Wikia\Search\Config' )
									->disableOriginalConstructor()
									->setMethods( array( 'getNamespaces', 'getQuery', 'getSearchProfiles', 'getActiveTab', 'getFilterQueries', 'getRank' ) )
									->getMock();

		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );


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
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getQuery' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects   ( $this->once() )
		    ->method    ( 'getSanitizedQuery' )
		    ->will      ( $this->returnValue( 'foo' ) )
		;
		$mockSearchConfig
			->expects	( $this->once() )
			->method	( 'getSearchProfiles' )
			->will		( $this->returnValue( $searchProfileArray ) )
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
			->with		( 'activeTab', 'default' )
		;
		$mockController
			->expects	( $this->at( $incr++ ) )
			->method	( 'setVal' )
			->with		( 'form', $form )
		;

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $wg );

		$mockController->tabs();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08604 ms
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBoxWithoutConfig() {
		$mockController = $this->searchController->setMethods( [ 'getVal', 'setVal' ] )->getMock();

		$mockController->expects( $this->any() )
			->method( 'getVal' )
			->with( 'namespaces' )
			->will( $this->returnValue( false ) );
		$exception = null;
		try {
			$mockController->advancedBox();
			$this->assertFalse( true,
				'WikiaSearchController::advancedBox should throw an exception if the "namespaces" is not set in the request.' );
		}
		catch ( Exception $e ) {
			$exception = $e;
		}
		$this->assertInstanceOf( 'BadRequestException', $exception,
			'WikiaSearchController::advancedBox should throw an exception if "namespaces" have not been set' );
	}

	/**
	 * @covers WikiaSearchController::advancedBox
	 */
	public function testAdvancedBox() {
		$mockController = $this->searchController->setMethods( [ 'getVal', 'setVal' ] )->getMock();
		$searchableNamespaces = [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ];

		$mockController->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( 'namespaces' )
			->will( $this->returnValue( [ 0, 14 ] ) );

		$this->getStaticMethodMock( SearchEngine::class, 'searchableNamespaces' )
			->expects( $this->any() )
			->method( 'searchableNamespaces' )
			->will( $this->returnValue( $searchableNamespaces ) );

		$mockController->expects( $this->at( 1 ) )
			->method( 'setVal' )
			->with( 'namespaces', [ 0, 14 ] );
		$mockController->expects( $this->at( 2 ) )
			->method( 'setVal' )
			->with( 'searchableNamespaces', $searchableNamespaces );

		$mockController->advancedBox();
	}

	/**
	 * @covers WikiaSearchController::setNamespacesFromRequest
	 */
	public function testSetNamespacesFromRequestHasNamespaces() {
		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$mockUser			=	$this->getMock( 'User', array( 'getOption' ) );
		$mockSearchConfig	=	$this->getMock( 'Wikia\Search\Config', array( 'setNamespaces', 'getSearchProfiles' ) );

		$this->getStaticMethodMock( SearchEngine::class, 'searchableNamespaces' )
			->expects( $this->any() )
			->method( 'searchableNamespaces' )
			->will( $this->returnValue( $searchableArray ) );

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
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$mockUser			=	$this->createMock( \User::class );
		$mockSearchConfig	=	$this->getMock( 'Wikia\Search\Config', array( 'setNamespaces', 'getSearchProfiles' ) );

		$this->getStaticMethodMock( SearchEngine::class, 'searchableNamespaces' )
			->expects	( $this->any() )
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
			->method		( 'getGlobalPreference' )
			->with			( 'searchAllNamespaces' )
			->will			( $this->returnValue( true ) )
		;
		$mockSearchConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setNamespaces' )
			->with		( array_keys($searchableArray) )
		;


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
		$searchableArray	=	array( 0 => 'Article', 14 => 'Category', 6 => 'File' );
		$defaultArray		=	array( 0, 14 );
		$mockUser			=	$this->createMock( \User::class );
		$mockSearchConfig	=	$this->getMock( 'Wikia\Search\Config', array( 'setNamespaces', 'getSearchProfiles' ) );

		$this->getStaticMethodMock( SearchEngine::class, 'searchableNamespaces' )
			->expects	( $this->any() )
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
			->method		( 'getGlobalPreference' )
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


		$method = new ReflectionMethod( 'WikiaSearchController', 'setNamespacesFromRequest' );
		$method->setAccessible( true );

		$this->assertTrue(
				$method->invoke( $mockController, $mockSearchConfig, $mockUser ),
				'WikiaSearchController::setNamespacesFromRequest should return true.'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08516 ms
	 * @covers WikiaSearchController::videoSearch
	 */
	public function testVideoSearch() {
		$mockConfig		=	$this->getMock( 'Wikia\Search\Config', array( 'setCityId', 'setQuery', 'setNamespaces', 'setVideoSearch', 'getResults' ) );
		$mockController	=	$this->searchController->setMethods( array( 'getResponse', 'getVal' ) )->getMock();
		$mockSearch		=	$this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\Video' )
								->setMethods( array( 'search' ) )
								->disableOriginalConstructor()
								->getMock();
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\QueryService\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getFromConfig' ) )
		                    ->getMock();
		$mockResults	=	$this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
								->disableOriginalConstructor()
								->setMethods( array( 'toArray' ) )
								->getMock();
		$mockResponse	=	$this->getMockBuilder( 'WikiaResponse' )
								->setMethods( array( 'setData', 'setFormat' ) )
								->disableOriginalConstructor()
								->getMock();

		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'CityId' => 123 ) );

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
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'search' )
			->will		( $this->returnValue( $mockResults ) )
		;
		$mockResults
			->expects	( $this->at( 0 ) )
			->method	( 'toArray' )
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

		$searchRefl = new ReflectionProperty( 'WikiaSearchController', 'queryServiceFactory' );
		$searchRefl->setAccessible( true );
		$searchRefl->setValue( $mockController, $mockFactory );

		$this->mockClass( 'Wikia\Search\Config', $mockConfig );

		$mockController->videoSearch();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0823 ms
	 * @covers WikiaSearchController::getPages
	 */
	public function testGetPages() {
		$mockController	=	$this->searchController->setMethods( array( 'getVal', 'getResponse' ) )->getMock();
		$mockIndexer	=	$this->getMockBuilder( 'Wikia\Search\Indexer' )
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
		$mockController
		    ->expects( $this->any() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->returnValue( $mockResponse ) )
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

		$mockWgRefl = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$mockWgRefl->setAccessible( true );
		$mockWgRefl->setValue( $mockController, (object) array( 'AllowMemcacheWrites' => true ) );

		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$mockController->getPages();

		$this->assertFalse(
				$mockController->wg->AllowMemcacheWrites,
				'WikiaSearchController::getPages should set wgAllowMemcacheWrites to false'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.14503 ms
	 * @covers WikiaSearchController::advancedTabLink
	 */
	public function testAdvancedTabLink() {

		$term = 'foo';
		$namespaces = array( 0, 14 );
		$label = 'bar';
		$class = str_replace( ' ', '-', strtolower( $label ) );
		$tooltip = 'tooltip';
		$params = array( 'filters' => array('is_video') );
		$href = 'foo.com';

		$mockController		=	$this->searchController->setMethods( array( 'getVal', 'setVal' ) )->getMock();
		$mockSpecialPageTitle	=	$this->getMockBuilder( 'SpecialPage' )
									->disableOriginalConstructor()
									->setMethods( array( 'getLocalURL' ) )
									->getMock();

		$stParams = array(
				'search'	=>	$term,
				'filters'	=>	array( 'is_video' ),
				'ns0'		=>	1,
				'ns14'		=>	1,
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
		$mockSpecialPageTitle
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
		$this->mockClass( 'SpecialPage', $mockSpecialPageTitle, 'getTitleFor' );

		$mockController->advancedTabLink();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12295 ms
	 * @covers WikiaSearchController::setPageTitle
	 */
	public function testSetPageTitle()
	{
		$mockController = $this->getMockBuilder( 'WikiaSearchController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( array() )
		                       ->getMock();

		$mockMsg = $this->getGlobalFunctionMock( 'wfMsg' );

		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'hasTerms', 'getSanitizedQuery' ), array( 'foo' ) );

		$mockOut = $this->getMockBuilder( 'OutputPage' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'setPageTitle' ) )
		                ->getMock();

		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getQuery', 'getInterWiki' ) )
		                   ->getMock();

		$sitename = "Foo Wiki";
		$query = "Foo";
		$message = "The contents of this message does not matter here";
		$mockWg = (object) array( 'Out' => $mockOut, 'Sitename' => $sitename );

		$reflWg = new ReflectionProperty( 'WikiaSearchController', 'wg' );
		$reflWg->setAccessible( true );
		$reflWg->setValue( $mockController, $mockWg );

		$this->mockGlobalVariable( 'wgOut', $mockOut );
		$this->mockGlobalVariable( 'wgSitename', $sitename );

		$reflSet = new ReflectionMethod( 'WikiaSearchController', 'setPageTitle' );
		$reflSet->setAccessible( true );

		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( $query ) )
		;
		$mockMsg
		    ->expects( $this->at( 0 ) )
		    ->method ( 'wfMsg' )
		    ->with   ( 'wikiasearch2-page-title-with-query', array( $query, $sitename ) )
		    ->will   ( $this->returnValue( $message ) )
		;
		$mockOut
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setPageTitle' )
		    ->with   ( $message )
		;

		$reflSet->invoke( $mockController, $mockConfig );

		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getInterWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockMsg
		    ->expects( $this->at( 0 ) )
		    ->method ( 'wfMsg' )
		    ->with   ( 'wikiasearch2-page-title-no-query-interwiki' )
		    ->will   ( $this->returnValue( $message ) )
		;
		$mockOut
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setPageTitle' )
		    ->with   ( $message )
		;

		$reflSet->invoke( $mockController, $mockConfig );

		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getInterWiki' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockMsg
		    ->expects( $this->at( 0 ) )
		    ->method ( 'wfMsg' )
		    ->with   ( 'wikiasearch2-page-title-no-query-intrawiki', array( $sitename ) )
		    ->will   ( $this->returnValue( $message ) )
		;
		$mockOut
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setPageTitle' )
		    ->with   ( $message )
		;

		$reflSet->invoke( $mockController, $mockConfig );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08588 ms
	 * @covers WikiaSearchController::setResponseValuesFromConfig
	 */
	public function testSetResponseValuesFromConfigAsJson()
	{
		$mockController = $this->getMockBuilder( 'WikiaSearchController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getResponse', 'getVal' ] )
			->getMock();

		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
			->disableOriginalConstructor()
			->setMethods( [ 'getFormat', 'setData' ] )
			->getMock();

		$mockView = $this->getMockBuilder( 'Wikia\Search\SearchResult' )
			->setMethods( [ 'toArray', 'hasResults' ] )
			->getMock();

		$mockController
			->expects(  $this->once() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'getVal' )
		    ->with   ( 'jsonfields', 'title,url,pageid' )
		    ->will   ( $this->returnValue( 'title,url,pageid' ) )
		;
		$mockResponse
			->expects( $this->once() )
			->method( 'setData' )
			->with( [ 'foo' ] )
		;
		$mockView
			->expects( $this->once() )
			->method( 'hasResults' )
			->will( $this->returnValue( true ) );

		$mockView
			->expects( $this->once() )
			->method( 'toArray' )
			->with( [ 'title', 'url', 'pageid' ] )
			->will( $this->returnValue( [ 'foo' ] ) );

		$reflSet = new ReflectionMethod( 'WikiaSearchController', 'setJsonResponse' );
		$reflSet->setAccessible( true );
		$reflSet->invoke( $mockController, 	$mockView );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07834 ms
	 * @covers WikiaSearchController::processArticleItem
	 * @dataProvider articleItemProvider
	 */
	public function testProcessArticleItem( $item, $len, $abstract ) {
		$mockController = $this->getMockBuilder( 'WikiaSearchController' )
			->disableOriginalConstructor()
			->getMock();

		$method = new ReflectionMethod( 'WikiaSearchController', 'processArticleItem' );
		$method->setAccessible( true );
		$result = $method->invoke( $mockController, $item, $len );

		$this->assertEquals( $abstract, $result[ 'abstract' ] );
	}

	public function articleItemProvider() {
		return [
			//item, expected abstract
			[
				[ 'title' => '', 'abstract' => '' ],
				150,
				''
			],
			[
				[ 'title' => 'Jakis title', 'abstract' => 'Jakis titl bla bla bla' ],
				150,
				' - Jakis titl bla bla bla'
			],
			[
				[ 'title' => 'ABC', 'abstract' => 'ABCś l bla bla bla' ],
				150,
				' - ABCś l bla bla bla'
			],
			[
				[ 'title' => 'Ian (Fallout)', 'abstract' => 'Ian is short' ],
				150,
				' is short'
			],
			[
				[ 'title' => 'Followers of the Apocalypse', 'abstract' => 'Reputation image from Fallout: New Vegas. The Followers of the Apocalypse, or simply the Followers...' ],
				150,
				' - Reputation image from Fallout: New Vegas. The Followers of the Apocalypse, or simply the Followers...'
			],
			[
				[ 'title' => 'Lancaster (film)', 'abstract' => 'Lancaster was set to appear as a location in the cancelled Fallout film. It was going to be...' ],
				150,
				' was set to appear as a location in the cancelled Fallout film. It was going to be...'
			],
			[
				[ 'title' => 'Assault rifle', 'abstract' => '  ...  An assault rifle is a selective fire rifle that uses an intermediate cartridge and a...' ],
				150,
				' is a selective fire rifle that uses an intermediate cartridge and a...'
			],
			[
				[ 'title' => 'Dart gun', 'abstract' => '   The dart gun is a constructable small gun in Fallout 3. Characteristics The dart gun is a...' ],
				150,
				' is a constructable small gun in Fallout 3. Characteristics The dart gun is a...'
			],
			[
				[ 'title' => '9mm', 'abstract' => '   9mm is an ammunition type in Fallout, Fallout 2, Fallout: New Vegas, Fallout Tactics...' ],
				150,
				' is an ammunition type in Fallout, Fallout 2, Fallout: New Vegas, Fallout Tactics...'
			],
			[
				[ 'title' => 'Raseleanne', 'abstract' => '   Paladin Raseleanne was a Paladin sent out to scout Nellis Air Force Base. She was killed and...' ],
				150,
				' was a Paladin sent out to scout Nellis Air Force Base. She was killed and...'
			],
			[
				[ 'title' => 'Nathan Drake', 'abstract' => ' Nathan \"Nate\" Drake is a treasure hunter and fortune seeker, as well as a deep-sea salvage...' ],
				150,
				' - Nathan \"Nate\" Drake is a treasure hunter and fortune seeker, as well as a deep-sea salvage...'
			],
			[
				[ 'title' => 'Gonzo', 'abstract' => ' Gonzo, formally known as \"The Great Gonzo\" or \"Gonzo the Great,\" is the resident daredevil...' ],
				150,
				', formally known as \"The Great Gonzo\" or \"Gonzo the Great,\" is the resident daredevil...'
			],
			[
				[ 'title' => 'Character', 'abstract' => ' ...  Characters are the representations of persons in works of art. In the Fallout series, the...' ],
				150,
				' - Characters are the representations of persons in works of art. In the Fallout series, the...'
			],
			[
				[ 'title' => 'Tranquility Lane', 'abstract' => '   “ Just who are you? ”— The Lone Wanderer when asking who Betty actually is. Tranquility Lane theme “ 同志站开，我们正在处理这些帝国主义走狗。 (Pinyin: Tóngzhì...' ],
				150,
				' - “ Just who are you? ”— The Lone Wanderer when asking who Betty actually is. Tranquility Lane theme “ 同志站开，我们正在处理这些帝国主义走狗。...'
			],
			[
				[ 'title' => 'Origins', 'abstract' => ' "Every story has a beginning...and an end." — "Origins" trailer "Unleashed after the Germans unearthed the mysterious Element 115, this next chapter in the Zombies legacy will explore the saga’s...'],
				150,
				' - "Every story has a beginning...and an end." — "Origins" trailer "Unleashed after the Germans unearthed the mysterious Element 115, this...'
			],
			[
				[ 'title' => 'x', 'abstract' => 'a b ...'],
				11,
				' - a b ...'
			],
			[
				[ 'title' => 'x', 'abstract' => 'a b c d e f ...'],
				11,
				' - a b...'
			],
		];
	}
}
