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
		
		$mockWikia		=	$this->getMock( 'Wikia' );
		
		$mockException	=	$this->getMock( 'Exception' );
		
		$mockMemc
			->expects	( $this->at( 0 ) )
			->method	( 'get' )
			->will		( $this->returnValue( $mockResult ) )
		;
		
		// need values greater than 1
		$mockResult->weekly		= 1;
		$mockResult->monthly	= 1;
		$this->mockGlobalVariable( 'wgMemc', $mockMemc );
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
	}
	
	/**
	 * @covers WikiaSearchIndexer::getWikiViews
	 */
	public function testGetWikiViewsNoCache() {
		$mockTitle		=	$this->getMock( 'Title' );
		$mockArticle	=	$this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockMemc		=	$this->getMock( 'stdClass', array( 'get', 'set' ) );
		$mockResult		=	$this->getMock( 'stdClass' );
		$mockDataMart	=	$this->getMock( 'DataMartService', array( 'getPageviewsWeekly', 'getPageviewsMonthly' ) );
		
		$mockMemc
			->expects	( $this->any() )
			->method	( 'get' )
			->will		( $this->returnValue( null ) )
		;
		$mockMemc
			->expects	( $this->any() )
			->method	( 'set' )
		;
		$mockDataMart
			->staticExpects	( $this->any() )
			->method		( 'getPageviewsWeekly' )
			->will			( $this->returnValue( array( 1234 ) ) )
		;
		$mockDataMart
			->staticExpects	( $this->any() )
			->method		( 'getPageviewsMonthly' )
			->will			( $this->returnValue( array( 12345 ) ) )
		;
		
		$this->mockGlobalVariable( 'wgMemc', $mockMemc );
		$this->mockClass( 'DataMartService', $mockDataMart );
		$this->mockApp();
		
		$indexer 	= F::build( 'WikiaSearchIndexer' );
		$method		= new ReflectionMethod( 'WikiaSearchIndexer', 'getWikiViews' );
		$method->setAccessible( true );
		
		$this->assertEquals( 
				(object) array( 'weekly' => 1234, 'monthly' => 12345 ), 
				$method->invoke( $indexer, $mockArticle ), 
				'A non-cached result should contain weekly and monthly values' 
		);
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
	 */
	public function testGetPageMetadata() {
		$mockSearchIndexer 	= $this->getMockBuilder( 'WikiaSearchIndexer' )
									->disableOriginalConstructor()
									->setMethods( array( 'getRedirectTitles', 'getWikiViews' ) )
									->getMock();
		
		$mockArticle		= $this->getMockBuilder( 'Article' )
									->disableOriginalConstructor()
									->setMethods( array( 'getTitle', 'getId' ) )
									->getMock();
		
		$mockApiService		= $this->getMock( 'ApiService', array( 'call' ) );
		$mockDataMart		= $this->getMock( 'DataMartServie', array( 'getCurrentWamScoreForWiki' ) );
		
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
		$mockBacklinks = array( 'query' => array( 'backlinks_count' => 20 ) );
		$mockApiService
			->staticExpects	( $this->at( 0 ) )
			->method		( 'call' )
			->will			( $this->returnValue( $mockBacklinks ) )
		;
		$mockPageData = array( 'query' => array( 'pages' => array( $mockId => 
				array( 'views' => 100, 
						'revcount' => 20, 
						'created' => date( 'Y-m-d' ), 
						'touched' => date( 'Y-m-d' ),
						'categories' => array( array( 'title' => 'Category:Stuff' ), array( 'title' => 'Category:Things' ), array( 'title' => 'Category:Miscellany' ) ) 
						) ) ) );
		$mockApiService
			->staticExpects	( $this->at( 1 ) )
			->method		( 'call' )
			->will			( $this->returnValue( $mockPageData ) )
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
		$mockDataMart
			->expects	( $this->once() )
			->method	( 'getCurrentWamScoreForWiki' )
		;
		
		$wgProperty = new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$wgProperty->setAccessible( true );
		$wgProperty->setValue( $mockSearchIndexer, (object) array( 'CityId' => 123, 'ExternalSharedDB' => true ) );
		
		$method = new ReflectionMethod( 'WikiaSearchIndexer', 'getPageMetaData' );
		$method->setAccessible( true );
		
		$this->mockClass( 'ApiService', $mockApiService );
		$this->mockClass( 'DataMartService', $mockDataMart );
		$this->mockApp();

		$result = $method->invoke( $mockSearchIndexer, $mockArticle );
		
		$this->tearDown();
	}
	
	/**
	 * @covers WikiaSearchIndexer::deleteArticle
	 */
	public function testDeleteArticleCityId() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'deleteBatch' ) )
								->getMock();

		$reflectionWg	=	new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) array( 'CityId' => 123 ) );
		
		$mockIndexer
			->expects	( $this->once() )
			->method	( 'deleteBatch' )
			->with		( array( '123_234' ) )
		;
		
		$this->assertTrue( 
				$mockIndexer->deleteArticle( 234 ),
				'WikiaSearchIndexer::deleteArticle should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::deleteArticle
	 */
	public function testDeleteArticleNoCityId() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'deleteBatch' ) )
								->getMock();

		$reflectionWg	=	new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) array( 'CityId' => null, 'SearchWikiId' => 123 ) );
		
		$mockIndexer
			->expects	( $this->once() )
			->method	( 'deleteBatch' )
			->with		( array( '123_234' ) )
		;
		
		$this->assertTrue( 
				$mockIndexer->deleteArticle( 234 ),
				'WikiaSearchIndexer::deleteArticle should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::reindexPage
	 */
	public function testReindexPage() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getSolrDocument', 'reindexBatch' ) )
								->getMock();
		
		$mockDocument	=	$this->getMock( 'Solarium_Document_ReadWrite' );
		
		$mockWikia		= $this->getMock( 'Wikia', array( 'log' ) );

		$mockIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'getSolrDocument' )
			->with		( 123 )
			->will		( $this->returnValue( $mockDocument ) )
		;
		$mockIndexer
			->expects	( $this->at( 1 ) )
			->method	( 'reindexBatch' )
			->with		( array( $mockDocument ) )
		;
		$mockWikia
			->expects	( $this->any() )
			->method	( 'log' )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$this->assertTrue(
				$mockIndexer->reindexPage( 123 ),
				'WikiaSearchIndexer::reindexPage should always return true'
				);

	}
	
	/**
	 * @covers WikiaSearchIndexer::deleteBatch
	 */
	public function testDeletBatchWorks() {
		$mockClient		=	$this->getMock( 'Solarium_Client', array( 'update', 'createUpdate' ) );
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setConstructorArgs( array( $mockClient ) )
								->setMethods( array( 'getSolrDocument', 'reindexBatch' ) )
								->getMock();
		
		$mockHandler	=	$this->getMock( 'Solarium_Query_Update', array( 'addDeleteQuery', 'addCommit' ) );
		
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'createUpdate' )
			->will		( $this->returnValue( $mockHandler ) )
		;
		$mockHandler
			->expects	( $this->at( 0 ) )
			->method	( 'addDeleteQuery' )
			->with		( WikiaSearch::valueForField( 'id', 123 ) )
		;
		$mockHandler
			->expects	( $this->at( 1 ) )
			->method	( 'addCommit' )
		;
		$mockClient
			->expects	( $this->at( 1 ) )
			->method	( 'update' )
			->with		( $mockHandler )
		;
		
		$this->assertTrue(
				$mockIndexer->deleteBatch( array( 123 ) ),
				'WikiaSearchIndexer::deleteBatch should always return true'
		);
		
	}
	
	/**
	 * @covers WikiaSearchIndexer::deleteBatch
	 */
	public function testDeletBatchBreaks() {
		$mockClient		=	$this->getMock( 'Solarium_Client', array( 'update', 'createUpdate' ) );
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setConstructorArgs( array( $mockClient ) )
								->setMethods( array( 'getSolrDocument', 'reindexBatch' ) )
								->getMock();
		
		$mockHandler	=	$this->getMock( 'Solarium_Query_Update', array( 'addDeleteQuery', 'addCommit' ) );
		
		$mockException	=	$this->getMock( 'Exception' );
		
		$mockWikia		=	$this->getMock( 'Wikia', array( 'log' ) );
		
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'createUpdate' )
			->will		( $this->returnValue( $mockHandler ) )
		;
		$mockHandler
			->expects	( $this->at( 0 ) )
			->method	( 'addDeleteQuery' )
			->with		( WikiaSearch::valueForField( 'id', 123 ) )
		;
		$mockHandler
			->expects	( $this->at( 1 ) )
			->method	( 'addCommit' )
		;
		$mockClient
			->expects	( $this->at( 1 ) )
			->method	( 'update' )
			->with		( $mockHandler )
			->will		( $this->throwException( $mockException ) )
		;
		$mockWikia
			->expects	( $this->any() )
			->method	( 'log' )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$this->assertTrue(
				$mockIndexer->deleteBatch( array( 123 ) ),
				'WikiaSearchIndexer::deleteBatch should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::reindexBatch
	 */
	public function testReindexBatchWorks() {
		$mockClient		=	$this->getMock( 'Solarium_Client', array( 'update', 'createUpdate' ) );
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setConstructorArgs( array( $mockClient ) )
								->setMethods( array( 'getSolrDocument' ) )
								->getMock();
		
		$mockDocument	=	$this->getMock( 'Solarium_Document_ReadWrite' );
		
		$mockHandler	=	$this->getMock( 'Solarium_Query_Update', array( 'addDocuments', 'addCommit' ) );
		
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'createUpdate' )
			->will		( $this->returnValue( $mockHandler ) )
		;
		$mockIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'getSolrDocument' )
			->with		( 123 )
			->will		( $this->returnValue( $mockDocument ) )
		;
		$mockHandler
			->expects	( $this->at( 0 ) )
			->method	( 'addDocuments' )
			->with		( array( $mockDocument ) )
		;
		$mockHandler
			->expects	( $this->at( 1 ) )
			->method	( 'addCommit' )
		;
		$mockClient
			->expects	( $this->at( 1 ) )
			->method	( 'update' )
			->with		( $mockHandler )
		;
		
		$this->assertTrue(
				$mockIndexer->reindexBatch( array( 123 ) ),
				'WikiaSearchIndexer::reindexBatch should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::reindexBatch
	 */
	public function testReindexBatchBreaks() {
		$mockClient		=	$this->getMock( 'Solarium_Client', array( 'update', 'createUpdate' ) );
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->setConstructorArgs( array( $mockClient ) )
								->setMethods( array( 'getSolrDocument' ) )
								->getMock();
		
		$mockDocument	=	$this->getMock( 'Solarium_Document_ReadWrite' );
		
		$mockException	=	$this->getMock( 'Exception' );
		
		$mockHandler	=	$this->getMock( 'Solarium_Query_Update', array( 'addDocuments', 'addCommit' ) );
		
		$mockWikia		=	$this->getMock( 'Wikia', array( 'log' ) );
		
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'createUpdate' )
			->will		( $this->returnValue( $mockHandler ) )
		;
		$mockIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'getSolrDocument' )
			->with		( 123 )
			->will		( $this->returnValue( $mockDocument ) )
		;
		$mockHandler
			->expects	( $this->at( 0 ) )
			->method	( 'addDocuments' )
			->with		( array( $mockDocument ) )
		;
		$mockHandler
			->expects	( $this->at( 1 ) )
			->method	( 'addCommit' )
		;
		$mockClient
			->expects	( $this->at( 1 ) )
			->method	( 'update' )
			->with		( $mockHandler )
			->will		( $this->throwException( $mockException ) )
		;
		$mockWikia
			->expects	( $this->any() )
			->method	( 'log' )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$this->assertTrue(
				$mockIndexer->reindexBatch( array( 123 ) ),
				'WikiaSearchIndexer::reindexBatch should always return true'
		);
	}
	
	/**
	 * @covers WikiaSearch::getSolrDocument
	 */
	public function testGetSolrDocument() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPage' ) )
								->getMock();
		
		$pageData = array(
				'id'	=>	'234_123',
				'title'	=>	'my crappy test',
				'html'	=>	'foo bar baz yes i am skipping testing regexes that is a trap',
				);
		
		$mockIndexer
			->expects	( $this->once() )
			->method	( 'getPage' )
			->with		( 123 )
			->will		( $this->returnValue( $pageData ) )
		;
		
		$doc = $mockIndexer->getSolrDocument( 123 );
		
		$this->assertInstanceOf(
				'Solarium_Document_ReadWrite',
				$doc,
				'WikiaSearchIndexer::getSolrDocument should return an instance of Solarium_Document_ReadWrite'
		);
		$this->assertEquals(
				'234_123',
				$doc['id'],
				'The return value of WikiaSearchIndexer::getSolrDocument should have the values retrieved from getPage() set in the Solr document'
		);
		$this->assertEquals(
				$doc['html_en'],
				$doc['html'],
				'Language fields should be transformed during WikiaSearchIndexer::getSolrDocument'
		);
	}
}