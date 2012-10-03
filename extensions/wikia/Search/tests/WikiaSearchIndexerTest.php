<?php 

require_once( 'WikiaSearchBaseTest.php' );

/**
 * @todo   Find ways to handle all the MW API querying we're doing in tests
 * @author Robert Elwell <robert@wikia-inc.com>
 */
class WikiaSearchIndexerTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers WikiaSearchIndexer::getWikiViews
	 */
	public function testGetWikiViewsWithCache() {
		
		/**
		 * A cached value with weekly and monthly rows greater than 0 should get returned
		 */
		$mockTitle		=	$this->getMock( 'Title' );
		$mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
		$mockResult		=	$this->getMock( 'stdClass' );
		
		$mockMemc
			->expects	( $this->any() )
			->method	( 'get' )
			->will		( $this->returnValue( $mockResult ) )
		;
		
		// need values greater than 1
		$mockResult->weekly		= 1;
		$mockResult->monthly	= 1;

		$this->mockGlobalVariable( 'wgMemc', $mockMemc );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getWikiViews' );
		$method->setAccessible( true );
		
		$this->assertEquals( $mockResult, $method->invoke( $indexer, $mockArticle ), 'A cached value with weekly and monthly rows greater than 0 should get returned' );
	}
	
	/**
	 * @covers WikiaSearchIndexer::getWikiViews
	 */
	public function testGetWikiViewsNoCacheYesDb() {
		$mockTitle		=	$this->getMock( 'Title' );
		$mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
		$mockResult		=	$this->getMock( 'stdClass' );
		$mockDbResult	=	$this->getMock( 'stdClass' );
		$mockDb 		=	$this->getMock( 'stdClass', array( 'selectRow' ) );
		
		$mockResult->weekly		= 0;
		$mockResult->monthly	= 0;
		$mockDbResult->weekly	= 1234;
		$mockDbResult->monthly	= 12345;
		
		$mockMemc
			->expects	( $this->any() )
			->method	( 'get' )
			->will		( $this->returnValue( $mockResult ) )
		;
		$mockMemc
			->expects	( $this->any() )
			->method	( 'set' )
		;
		$mockDb
			->expects	( $this->any() )
			->method	( 'selectRow' )
			->will		( $this->returnValue( $mockDbResult ) )
		;
		
		$this->mockGlobalFunction( 'GetDB', $mockDb );
		$this->mockGlobalVariable( 'wgMemc', $mockMemc );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getWikiViews' );
		$method->setAccessible( true );
		
		$this->assertEquals( $mockDbResult, $method->invoke( $indexer, $mockArticle ), 'A cached result without weekly or monthly values should query the DB for a result' );
	}
	
	/**
	 * @covers WikiaSearchIndexer::getWikiViews
	 */
	public function testGetWikiViewsNoCacheNoDb() {
	    $mockTitle		=	$this->getMock( 'Title' );
	    $mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
	    $mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
	    $mockDb 		=	$this->getMock( 'stdClass', array( 'selectRow' ) );
	
	    $mockMemc
		    ->expects	( $this->any() )
		    ->method	( 'get' )
		    ->will		( $this->returnValue( null) )
	    ;
	    $mockMemc
		    ->expects	( $this->any() )
		    ->method	( 'set' )
	    ;
	    $mockDb
		    ->expects	( $this->any() )
		    ->method	( 'selectRow' )
		    ->will		( $this->returnValue( null ) )
	    ;
	
	    $this->mockGlobalFunction( 'GetDB', $mockDb );
	    $this->mockGlobalVariable( 'wgMemc', $mockMemc );
	    $this->mockApp();
	
	    $indexer 	= F::build( 'WikiaSearchIndexer' );
	    $method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getWikiViews' );
	    $method->setAccessible( true );
	
	    $invocationResult = $method->invoke( $indexer, $mockArticle );
	    $this->assertInstanceOf	( 'stdClass', $invocationResult,	'getWikiViews should have fallback result of type stdClass.' );
	    $this->assertEquals		( 0, $invocationResult->weekly,		'getWikiViews fallback result should have a weekly property with a numerical value of 0.' );
	    $this->assertEquals		( 0, $invocationResult->monthly,	'getWikiViews fallback result should have a monthly property with a numerical value of 0.' );
	}
	
	/**
	 * @covers WikiaSearchIndexer::getRedirectTitles
	 */
	public function testGetRedirectTitlesNoResults() {
		$mockTitle		=	$this->getMock( 'Title', array( 'getDbKey' ) );
		$mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
		$mockDb 		=	$this->getMock( 'stdClass', array( 'selectRow' ) );

		// couldn't get the constructor stuff to work right for mock article
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle')
			->will		( $this->returnValue( $mockTitle ) )
		;
		
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getDbKey' )
			->will		( $this->returnValue( 'foo' ) )
		;
		
		$mockDb
			->expects	( $this->any() )
			->method	( 'selectRow' )
			->will		( $this->returnValue( null ) )
		;
		
		$this->mockGlobalFunction( 'GetDB', $mockDb );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getRedirectTitles' );
		$method->setAccessible( true );
		
		$this->assertEmpty( $method->invoke( $indexer, $mockArticle ), 'A query for redirect titles without a result should return an empty string.' );
	}
	
	/**
	 * @covers WikiaSearchIndexer::getRedirectTitles
	 */
	public function testGetRedirectTitlesWithResults() {
		$mockTitle		=	$this->getMock( 'Title', array( 'getDbKey' ) );
		$mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
		$mockDb 		=	$this->getMock( 'stdClass', array( 'selectRow' ) );
		$mockResultRow	=	$this->getMock( 'stdClass' );
		
		$mockResultRow->redirect_titles = 'Foo_Bar | Baz_Qux';
		
		// couldn't get the constructor stuff to work right for mock article
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle')
			->will		( $this->returnValue( $mockTitle ) )
		;
		
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getDbKey' )
			->will		( $this->returnValue( 'foo' ) )
		;
		
		$mockDb
			->expects	( $this->any() )
			->method	( 'selectRow' )
			->will		( $this->returnValue( $mockResultRow ) )
		;
		
		$this->mockGlobalFunction( 'GetDB', $mockDb );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getRedirectTitles' );
		$method->setAccessible( true );
		
		$this->assertEquals( 'Foo Bar | Baz Qux', $method->invoke( $indexer, $mockArticle ), 'A query for redirect titles with result rows should be pipe-joined with underscores replaced with spaces.' );
	}
	
}