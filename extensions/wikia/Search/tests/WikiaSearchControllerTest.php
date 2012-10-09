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
	public function testArticleMatchTracking() {
		
		$searchConfig		=	F::build( 'WikiaSearchConfig' );
		$mockTitle			=	$this->getMock( 'Title',  array( 'newFromText', 'getFullUrl' ) );
		$mockArticle		=	$this->getMock( 'Article', array( 'getTitle' ), array( $mockTitle ) );
		$mockArticleMatch	=	$this->getMock( 'WikiaSearchArticleMatch', array( 'getArticle' ), array( $mockArticle ) );
		$mockResponse		=	$this->getMock( 'WikiaResponse', array( 'redirect' ), array( 'html' ) );
		$mockRequest		=	$this->getMock( 'WikiaRequest', array( 'getVal', 'setVal' ), array( array() ) );
		$mockTrack			=	$this->getMock( 'Track', array( 'event' ) );
		
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
		// @todo get event tracking calls to work
		$mockRequest
			->expects	( $this->at( 0 ) )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( 'Search' ) )
		;
		$mockRequest
			->expects	( $this->at( 1 ) )
			->method	( 'getVal' )
			->with		( 'fulltext', '0' )
			->will		( $this->returnValue( '0' ) )
		;
		
		$searchConfig->setQuery( 'unittestfoo' );
		
		global $hookGoMatch, $hookNoGoMatch;
		$hookGoMatch = false;
		$hookNoGoMatch = false;

		$this->mockClass( 'Track', $mockTrack );
		$this->mockApp();
		F::app()->registerHook('SpecialSearchIsgomatch', 'WikiaSearchControllerTest', 'gomatch');
		F::app()->registerHook('SpecialSearchNogomatch', 'WikiaSearchControllerTest', 'nogomatch');
		F::app()->registerClass( 'Track', $mockTrack );
		
		
		$this->searchController->setRequest( $mockRequest );
		$this->searchController->setResponse( $mockResponse );
		
		$method = new ReflectionMethod( 'WikiaSearchController', 'handleArticleMatchTracking' );
		$method->setAccessible( true );
		
		$this->assertTrue(
				$method->invoke( $this->searchController, $searchConfig ),
				'WikiaSearchController::handleArticleMatchTracking should return true.'
		);
		$this->assertTrue(
				$hookNoGoMatch,
				'WikiaSearchController should run the SpecialSearchNogomatch hook if there is a title that can be built from a query with no article match.'
		);
		
		$searchConfig->setArticleMatch( $mockArticleMatch );
		
		$method->invoke( $this->searchController, $searchConfig );
		
		$method->invoke( $this->searchController, $searchConfig );
		
	}
	
	public static function gomatch() {
		global $hookGoMatch;
		$hookGoMatch = true;
		return true;
	}
	
	public static function nogomatch() {
		global $hookNoGoMatch;
		$hookNoGoMatch = true;
		return true;
	}
	
}