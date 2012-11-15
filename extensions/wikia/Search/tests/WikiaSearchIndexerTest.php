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
		$mockMemc		=	$this->getMockBuilder( 'MemcachedClient' )
								->disableOriginalConstructor()
								->setMethods( array( 'get', 'set' ) )
								->getMock();
		$mockResult		=	$this->getMock( 'stdClass' );
		
		$mockDb			=	$this->getMockBuilder( 'DatabaseMysql' )
								->setMethods( array( 'selectRow' ) )
								->getMock();
		
		$mockWikia		=	$this->getMock( 'Wikia' );
		
		$mockException	=	$this->getMock( 'Exception' );
		
		$mockMemc
			->expects	( $this->at( 0 ) )
			->method	( 'get' )
			->will		( $this->returnValue( $mockResult ) )
		;
		$mockMemc
			->expects	( $this->at( 1 ) )
			->method	( 'get' )
			->will		( $this->returnValue( null ) )
		;
		$mockMemc
			->expects	( $this->at( 2 ) )
			->method	( 'get' )
			->will		( $this->returnValue( null ) )
		;
		$mockDb
			->expects	( $this->at( 0 ) )
			->method	( 'selectRow' )
			->will		( $this->returnValue( $mockResult ) )
		;
		$mockDb
			->expects	( $this->at( 1 ) )
			->method	( 'selectRow' )
			->will		( $this->throwException( $mockException ) )
		;
		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;
		// need values greater than 1
		$mockResult->weekly		= 1;
		$mockResult->monthly	= 1;
		$statsDb = 'stats';
		$this->mockGlobalVariable( 'wgStatsDBEnabled', true );
		$this->mockGlobalVariable( 'wgMemc', $mockMemc );
		$this->mockGlobalVariable( 'wgStatsDB', $statsDb );
		$this->mockGlobalFunction( 'getDB', $mockDb, 2, array( DB_SLAVE, array(), $statsDb ) );
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getWikiViews' );
		$method->setAccessible( true );
		
		$this->assertEquals( 
				$mockResult, 
				$method->invoke( $indexer, $mockArticle ), 
				'A cached value with weekly and monthly rows greater than 0 should get returned' 
		);
		$this->assertEquals( 
				$mockResult, 
				$method->invoke( $indexer, $mockArticle ), 
				'An uncached value with weekly and monthly rows greater than 0 should get returned' 
		);
		$backoffResult = $method->invoke( $indexer, $mockArticle );
		$this->assertEquals(
				0,
				$backoffResult->weekly + $backoffResult->monthly,
				'In case of an error, a row with zeros for the expected values should be returned'
		); 
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
	
	/**
	 * @covers WikiaSearchIndexer::onArticleUndelete
	 */
	public function testOnArticleUndelete() {
		$mockSearchIndexer 	= $this->getMockBuilder( 'WikiaSearchIndexer' )
									->disableOriginalConstructor()
									->setMethods( array( 'reindexBatch' ) )
									->getMock();
		
		$mockTitle			= $this->getMock( 'Title', array( 'getArticleID' ) );
		$mockWikia			= $this->getMock( 'Wikia', array( 'log' ) );
		
		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getArticleID' )
			->will		( $this->returnValue( 1234 ) )
		;
		$mockSearchIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'reindexBatch' ) 
			->with		( array( 1234 ) )
			->will		( $this->returnValue( true ) )
		;
		
		$mockException = $this->getMock( 'Exception' );
		
		$mockSearchIndexer
			->expects	( $this->at( 1 ) )
			->method	( 'reindexBatch' )
			->will		( $this->throwException ( $mockException ) )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$this->assertTrue(
				$mockSearchIndexer->onArticleUndelete( $mockTitle, true ),
				'WikiaSearchIndexer::onArticleUndelete should always return true'
		);
		$this->assertTrue(
				$mockSearchIndexer->onArticleUndelete( $mockTitle, true ),
				'WikiaSearchIndexer::onArticleUndelete should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::onArticleSaveComplete
	 */
	public function testOnArticleSaveComplete() {
		$mockSearchIndexer 	= $this->getMockBuilder( 'WikiaSearchIndexer' )
									->disableOriginalConstructor()
									->setMethods( array( 'reindexBatch' ) )
									->getMock();
		
		$mockArticle		= $this->getMockBuilder( 'Article' )
									->disableOriginalConstructor()
									->setMethods( array( 'getTitle' ) )
									->getMock();
		
		$mockTitle			= $this->getMock( 'Title', array( 'getArticleID' ) );
		$mockWikia			= $this->getMock( 'Wikia', array( 'log' ) );
		
		$mockUser 			= $this->getMockBuilder( 'User' )
									->disableOriginalConstructor()
									->getMock();
		
		$mockRevision		= $this->getMockBuilder( 'Revision' )
									->disableOriginalConstructor()
									->getMock();
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getArticleID' )
			->will		( $this->returnValue( 1234 ) )
		;
		$mockSearchIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'reindexBatch' ) 
			->with		( array( 1234 ) )
			->will		( $this->returnValue( true ) )
		;
		
		$mockException = $this->getMock( 'Exception' );
		
		$mockSearchIndexer
			->expects	( $this->at( 1 ) )
			->method	( 'reindexBatch' )
			->will		( $this->throwException ( $mockException ) )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		//stupid pass by reference params
		$array = array();
		$int = 1;
		$this->assertTrue(
				$mockSearchIndexer->onArticleSaveComplete( $mockArticle, $mockUser, '', '', true, true, '', $array, $mockRevision, $int, $int ),
				'WikiaSearchIndexer::onArticleSaveComplete should always return true'
		);
		$this->assertTrue(
				$mockSearchIndexer->onArticleSaveComplete( $mockArticle, $mockUser, '', '', true, true, '', $array, $mockRevision, $int, $int ),
				'WikiaSearchIndexer::onArticleSaveComplete should always return true'
		);
		
	}

	/**
	 * @covers WikiaSearchIndexer::onArticleDeleteComplete
	 */
	public function testOnArticleDeleteComplete() {
		$mockSearchIndexer 	= $this->getMockBuilder( 'WikiaSearchIndexer' )
									->disableOriginalConstructor()
									->setMethods( array( 'deleteArticle' ) )
									->getMock();
		
		$mockArticle		= $this->getMockBuilder( 'Article' )
									->disableOriginalConstructor()
									->setMethods( array( 'getTitle' ) )
									->getMock();
		
		$mockTitle			= $this->getMock( 'Title', array( 'getArticleID' ) );
		$mockWikia			= $this->getMock( 'Wikia', array( 'log' ) );
		
		$mockUser 			= $this->getMockBuilder( 'User' )
									->disableOriginalConstructor()
									->getMock();
		
		$mockId = 1235;
		
		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;
		$mockSearchIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'deleteArticle' ) 
			->with		( $mockId )
			->will		( $this->returnValue( true ) )
		;
		
		$mockException = $this->getMock( 'Exception' );
		
		$mockSearchIndexer
			->expects	( $this->at( 1 ) )
			->method	( 'deleteArticle' )
			->will		( $this->throwException ( $mockException ) )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$this->assertTrue(
				$mockSearchIndexer->onArticleDeleteComplete( $mockArticle, $mockUser, 123, $mockId ),
				'WikiaSearchIndexer::onArticleDeleteComplete should always return true'
		);
		$this->assertTrue(
				$mockSearchIndexer->onArticleDeleteComplete( $mockArticle, $mockUser, 123, $mockId ),
				'WikiaSearchIndexer::onArticleDeleteComplete should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::onParserClearState
	 */
	public function testOnParserClearState() {
		$mockParser			= $this->getMockBuilder( 'Parser' )
									->disableOriginalConstructor()
									->setMethods( array( 'getOutput' ) )
									->getMock();
		
		$mockParserOutput	= $this->getMockBuilder( 'Parser' )
									->disableOriginalConstructor()
									->setMethods( array( 'setCacheTime' ) )
									->getMock();
		
		$mockParser
			->expects	( $this->once() )
			->method	( 'getOutput' )
			->will		( $this->returnValue( $mockParserOutput ) )
		;
		$mockParserOutput
			->expects	( $this->once() )
			->method	( 'setCacheTime' )
			->with		( -1 )
		;
		
		$this->assertTrue(
				WikiaSearchIndexer::onParserClearState( $mockParser ),
				'WikiaSearchIndexer::onParserClearState should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::getPageMetaData
	 * @todo this needs to be fixed
	 */
	public function testGetPageMetadata() {
		$mockSearchIndexer 	= $this->getMockBuilder( 'WikiaSearchIndexer' )
									->disableOriginalConstructor()
									->setMethods( array( 'getRedirectTitles', 'getWikiViews' ) )
									->getMock();
		
		$mockArticle		= $this->getMockBuilder( 'Article' )
									->disableOriginalConstructor()
									->setMethods( array( 'getTitle' ) )
									->getMock();
		
		$mockApiService		= $this->getMock( 'ApiService', array( 'call' ) );
		
		$mockTitle			= 'PHPUnit/Being_Awesome';
		$mockId				= 123;
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getId' )
			->will		( $this->returnValue( $mockId ) )
		;
		
		$expectedPageData = array(
				'backlinks'			=>	321,
				'views'				=>	213,
				'revcount'			=>	51341,
				'created'			=>	time(), // don't really care about the value here
				'touched'			=>	time(), // don't really care about the value here
				'categories'		=>	array( 'Chopped and screwed', 'H-town', 'Dirty souf' ),
				'hub'				=>	'Entertainment',
				'wikititle'			=>	'Rando Wiki',
				'redirect_titles'	=>	array( 'foo', 'bar', 'baz', 'qux' ),
				'wikiviews_weekly'	=>	10,
				'wikiviews_monthly'	=>	100
				);
				
		$basicParams = array(
				'titles'	=>	$mockTitle,
				'bltitle'	=>	$mockTitle,
				'action'	=>	'query',
				'list'		=>	'backlinks',
				'blcount'	=>	1
				);
		
		$queryResponse = array(
				'query'	=>	array( 
						'backlinks_count'	=>	50 
						)
				);
		
		$statsParams = array(
				'pageids'	=>	$mockId,
				'action'	=>	'query',
				'prop'		=>	'info|categories',
				'inprop'	=>	'url|created|views|revcount',
				'meta'		=>	'siteinfo',
				'siprop'	=>	'statistics|wikidesc|variables|namespaces|category'
				);
		
		$statsResponse = array(
				'query'	=> array(
						'pages'	=> array(
								$mockId => array(
										'views'		=>	123,
										'revcount'	=>	234,
										'created'	=>	$expectedPageData['created'],
										'touched'	=>	$expectedPageData['touched'],
										'categories'=>	array(
												'Category:Chopped and screwed',
												'Category:H-town',
												'Category:Dirty souf'
												)
										)
								),
						'category'	=>	array(
								'catname'	=>	'Entertainment'
								),
						'wikidesc'	=>	array(
								'pagetitle'	=>	'Rando Wiki'
								)
						)
				);
		
		$mockApiService
			->expects	( $this->once() )
			->method		( 'call' )
			->with			( $basicParams )
			->will			( $this->returnValue( $queryResponse ) )
		;
		$mockApiService
			->expects	( $this->once() )
			->method		( 'call' )
			->with			( $statsParams )
			->will			( $this->returnValue( $statsResponse ) )
		;
		$mockSearchIndexer
			->expects	( $this->once() )
			->method	( 'getWikiViews' )
			->with		( $mockArticle )
			->will		( $this->returnValue( (object) array( 'weekly' => 10, 'monthly' => 100 ) ) )
		;
		$redirectTitles = array( 'foo', 'bar', 'baz', 'qux' );
		$mockSearchIndexer
			->expects	( $this->once() )
			->method	( 'getRedirectTitles' )
			->with		( $mockArticle )
			->will		( $this->returnValue( $redirectTitles ) )
		;
		
		$method = new ReflectionMethod( 'WikiaSearchIndexer', 'getPageMetaData' );
		$method->setAccessible( true );
		$result = $method->invoke( $mockSearchIndexer, $mockArticle );
		
		$this->mockClass( 'ApiService', $mockApiService );
		$this->mockGlobalVariable( 'wgExternalSharedDB', true );
		
		global $wgExternalSharedDB;
		$prevDbVal = $wgExternalSharedDB;
		$wgExternalSharedDB = true;
		
		$this->mockApp();
		
		$this->assertEquals(
				$expectedPageData,
				$result
		);
		
		$wgExternalSharedDB = $prevDbVal;
	}
}