<?php 

require_once( 'WikiaSearchBaseTest.php' );

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
	    $this->assertInstanceOf	( 'stdClass', $invocationResult, 'getWikiViews should have fallback result of type stdClass.' );
	    $this->assertEquals		( 0, $invocationResult->weekly, 'getWikiViews fallback result should have a weekly property with a numerical value of 0');
	    $this->assertEquals		( 0, $invocationResult->monthly, 'getWikiViews fallback result should have a monthly property with a numerical value of 0');
	}
	
}