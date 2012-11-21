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
	 * @covers WikiaSearchIndexer::getSolrDocument
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
	
	/**
	 * @covers WikiaSearchIndexer::getPages
	 */
	public function testGetPages() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPage' ) )
								->getMock();
		
		$mockException	=	$this->getMockBuilder( 'WikiaException' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockIndexer
			->expects	( $this->at( 0 ) )
			->method	( 'getPage' )
			->with		( 123 )
			->will		( $this->returnValue( array( 'here be my page data' ) ) )
		;
		$mockIndexer
			->expects	( $this->at( 1 ) )
			->method	( 'getPage' )
			->with		( 234 )
			->will		( $this->throwException( $mockException ) )
		;
		
		$this->assertEquals(
				array( 'pages' => array( 123 => array( 'here be my page data' ) ), 'missingPages' => array( 234 ) ),
				$mockIndexer->getPages( array( 123, 234 ) ),
				'WikiaSearchIndexer::getPages should set pagedata for each page it successfully grabs, and list each problematic page as missing.'
		);
	}
	
	/**
	 * @covers WikiaSearchIndexer::getPage
	 */
	public function testGetPage() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPageMetaData' ) )
								->getMock();
		
		$mockArticle	=	$this->getMockBuilder( 'Article' )
								->disableOriginalConstructor()
								->setMethods( array( 'isRedirect', 'getRedirectTarget', 'loadContent', 'render', 'getId', 'getTitle' ) )
								->getMock();
		
		$mockApp		=	$this->getMockBuilder( 'WikiaApp' )
								->disableOriginalConstructor()
								->setMethods( array( 'registerHook' ) )
								->getMock();
		
		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPrefixedText', 'getNamespace', 'getText', 'getFullUrl', 'getTitle' ) )
								->getMock();
		
		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'setVal' ) )
								->getMock();
		
		$mockOutput		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'getHTML', 'clearHTML' ) )
								->getMock();
		
		$mockContLang	=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->getMock();
		
		$reflectionApp = new ReflectionProperty( 'WikiaSearchIndexer', 'app' );
		$reflectionApp->setAccessible( true );
		$reflectionApp->setValue( $mockIndexer, $mockApp );
		
		$mockGlobals = array( 
				'Title'				=>	$mockTitle, 
				'Request'			=>	$mockRequest, 
				'Out'				=>	$mockOutput, 
				'ExternalSharedDB'	=>	true, 
				'CityId'			=>	123, 
				'Server'			=>	'http://foo.wikia.com', 
				'ContLang'			=>	(object) array( 'mCode' => 'en' ),
				'ContentNamespaces'	=>	array( NS_MAIN, NS_CATEGORY ) 
				);
		
		$reflectionWg = new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) $mockGlobals );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockIndexer
			->expects	( $this->any() )
			->method	( 'getPageMetaData' )
			->will		( $this->returnValue( array() ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getRedirectTarget' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		
		$this->mockClass( 'Article', $mockArticle );
		$this->mockApp();
		
		$mockIndexer->getPage( 123 );
	}
	
	/**
	 * @covers WikiaSearchIndexer::getPage
	 */
	public function testGetPageVideo() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPageMetaData' ) )
								->getMock();
		
		$mockArticle	=	$this->getMockBuilder( 'Article' )
								->disableOriginalConstructor()
								->setMethods( array( 'isRedirect', 'getRedirectTarget', 'loadContent', 'render', 'getId', 'getTitle' ) )
								->getMock();
		
		$mockApp		=	$this->getMockBuilder( 'WikiaApp' )
								->disableOriginalConstructor()
								->setMethods( array( 'registerHook' ) )
								->getMock();
		
		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPrefixedText', 'getNamespace', 'getText', 'getFullUrl', 'getTitle' ) )
								->getMock();
		
		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'setVal' ) )
								->getMock();
		
		$mockOutput		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'getHTML', 'clearHTML' ) )
								->getMock();
		
		$mockContLang	=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockFile		=	$this->getMockBuilder( 'File' )
								->disableOriginalConstructor()
								->setMethods( array( 'getMetadata', 'getMediaDetail', 'isVideo' ) )
								->getMock();
		
		$mockWfs		=	$this->getMock( 'stdClass', array( 'findFile' ) );
		
		$mockFileHelper	=	$this->getMock( 'WikiaFileHelper', array( 'getMediaDetail', 'isVideoFile' ) );
		
		$reflectionApp = new ReflectionProperty( 'WikiaSearchIndexer', 'app' );
		$reflectionApp->setAccessible( true );
		$reflectionApp->setValue( $mockIndexer, $mockApp );
		
		$mockGlobals = array( 
				'Title'				=>	$mockTitle, 
				'Request'			=>	$mockRequest, 
				'Out'				=>	$mockOutput, 
				'ExternalSharedDB'	=>	true, 
				'CityId'			=>	123, 
				'Server'			=>	'http://foo.wikia.com', 
				'ContLang'			=>	(object) array( 'mCode' => 'en' ),
				'ContentNamespaces'	=>	array( NS_MAIN, NS_CATEGORY ) 
				);
		
		$mockWfs
			->expects	( $this->any() )
			->method	( 'findFile' )
			->will		( $this->returnValue( $mockFile ) )
		;
		
		$reflectionWg = new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) $mockGlobals );
		
		$reflectionWf = new ReflectionProperty( 'WikiaSearchIndexer', 'wf' );
		$reflectionWf->setAccessible( true );
		$reflectionWf->setValue( $mockIndexer, (object) $mockWfs );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockIndexer
			->expects	( $this->any() )
			->method	( 'getPageMetaData' )
			->will		( $this->returnValue( array() ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( false ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getRedirectTarget' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getNamespace' )
			->will		( $this->returnValue( NS_FILE ) )
		;
		$mockFileHelper
			->staticExpects	( $this->once() )
			->method		( 'getMediaDetail' )
			->with			( $mockTitle )
			->will			( $this->returnValue( array( 'mediaType' => 'video' ) ) )
		;
		$mockFileHelper
			->staticExpects	( $this->once() )
			->method		( 'isVideoFile' )
			->with			( $mockFile )
			->will			( $this->returnValue( 'true' ) )
		;
		
		$videoMetadata = array(
				'description'			=>	'Video of Usher Raymond kickin it',
				'keywords'				=>	'R&B, awesome, amazing',
				'movieTitleAndYear'		=>	'The Usher Movie (1999)',
				'videoTitle'			=>	'Usher kickin it (usher movie)',
				'title'					=>	'Usher kickin it',
				'tags'					=>	'R&B, usher',
				'category'				=>	'Entertainment',
				'duration'				=>	110,
				'provider'				=>	'FictionalClips',
				'videoId'				=>	sha1('woot'),
				'altVideoId'			=>	1234,
				'aspectRatio'			=>	4/3,
				'hd'					=>	1,
				'genres'				=>	'R&B, Soul, Great music, 90s',
				'actors'				=>	'Usher Raymond, Lil Jon, Justin Bieber'
				);
		
		$mockFile
			->expects	( $this->once() )
			->method	( 'getMetadata' )
			->will		( $this->returnValue( serialize( $videoMetadata ) ) )
		;
		
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );
		$this->mockClass( 'Article', $mockArticle );
		$this->mockApp();
		
		$page = $mockIndexer->getPage( 123 );
		
		$this->assertEquals(
				'true',
				$page['video_hd_b'],
				'An HD video should have a boolean HD field set to string "true" for indexing'
		);
		$this->assertEquals(
				array( 'R&B', 'Soul', 'Great music', '90s' ),
				$page['video_genres_txt'],
				'A video with genres should be transformed into an array for a multivalued text field'
		);
		$this->assertEquals(
				array( 'Usher Raymond', 'Lil Jon', 'Justin Bieber' ),
				$page['video_actors_txt'],
				'A video with actors should be transformed into an array for a multivalued text field'
		);
		$this->assertEquals(
				110,
				$page['video_duration_i'],
				'Video fields that match values in the video metadata mapper array should be transformed into their appropriate document field'
		);
		foreach ( array( 'description', 'keywords', 'movieTitleAndYear', 'videoTitle', 'tags', 'title', 'category' ) as $dumpedField ) {
			$this->assertContains(
					$videoMetadata[$dumpedField],
					$page['html'],
					"The field {$dumpedField} should be dumped into the content body and treated as 'HTML' by the document response"
			);
		}
	}
	

	/**
	 * @covers WikiaSearchIndexer::getPage
	 */
	public function testGetPageCommentMain() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPageMetaData' ) )
								->getMock();
		
		$mockArticle	=	$this->getMockBuilder( 'Article' )
								->disableOriginalConstructor()
								->setMethods( array( 'isRedirect', 'getRedirectTarget', 'loadContent', 'render', 'getId', 'getTitle' ) )
								->getMock();
		
		$mockApp		=	$this->getMockBuilder( 'WikiaApp' )
								->disableOriginalConstructor()
								->setMethods( array( 'registerHook' ) )
								->getMock();
		
		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPrefixedText', 'getNamespace', 'getText', 'getFullUrl', 'getTitle' ) )
								->getMock();
		
		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'setVal' ) )
								->getMock();
		
		$mockOutput		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'getHTML', 'clearHTML' ) )
								->getMock();
		
		$mockContLang	=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockWallMsg	=	$this->getMockBuilder( 'WallMessage' )
								->disableOriginalConstructor()
								->setMethods( array( 'load', 'isMain', 'getMetaTitle', 'getTopParentObj' ) )
								->getMock();
		
		$reflectionApp = new ReflectionProperty( 'WikiaSearchIndexer', 'app' );
		$reflectionApp->setAccessible( true );
		$reflectionApp->setValue( $mockIndexer, $mockApp );
		
		$mockGlobals = array( 
				'Title'				=>	$mockTitle, 
				'Request'			=>	$mockRequest, 
				'Out'				=>	$mockOutput, 
				'ExternalSharedDB'	=>	true, 
				'CityId'			=>	123, 
				'Server'			=>	'http://foo.wikia.com', 
				'ContLang'			=>	(object) array( 'mCode' => 'en' ),
				'ContentNamespaces'	=>	array( NS_MAIN, NS_CATEGORY ) 
				);
		
		$reflectionWg = new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) $mockGlobals );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockIndexer
			->expects	( $this->any() )
			->method	( 'getPageMetaData' )
			->will		( $this->returnValue( array() ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getRedirectTarget' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getNamespace' )
			->will		( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$commentTitle = "my comment title";
		$mockWallMsg
			->expects	( $this->any() )
			->method	( 'getMetaTitle' )
			->will		( $this->returnValue( $commentTitle ) )
		;
		$mockWallMsg
			->expects	( $this->any() )
			->method	( 'isMain' )
			->will		( $this->returnValue( true ) )
		;
		
		
		$this->mockClass( 'Article', $mockArticle );
		$this->mockClass( 'WallMessage', $mockWallMsg );
		$this->mockApp();
		
		$page = $mockIndexer->getPage( 123 );
		
		$this->assertEquals(
				$commentTitle,
				$page['title'],
				"WikiaSearchIndexer::getPage should index the main comment title as the title, not the main comment's page title"
		);
	}
	

	/**
	 * @covers WikiaSearchIndexer::getPage
	 */
	public function testGetPageCommentNotMain() {
		$mockIndexer	=	$this->getMockBuilder( 'WikiaSearchIndexer' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPageMetaData' ) )
								->getMock();
		
		$mockArticle	=	$this->getMockBuilder( 'Article' )
								->disableOriginalConstructor()
								->setMethods( array( 'isRedirect', 'getRedirectTarget', 'loadContent', 'render', 'getId', 'getTitle' ) )
								->getMock();
		
		$mockApp		=	$this->getMockBuilder( 'WikiaApp' )
								->disableOriginalConstructor()
								->setMethods( array( 'registerHook' ) )
								->getMock();
		
		$mockTitle		=	$this->getMockBuilder( 'Title' )
								->disableOriginalConstructor()
								->setMethods( array( 'getPrefixedText', 'getNamespace', 'getText', 'getFullUrl', 'getTitle' ) )
								->getMock();
		
		$mockRequest	=	$this->getMockBuilder( 'RequestContext' )
								->disableOriginalConstructor()
								->setMethods( array( 'setVal' ) )
								->getMock();
		
		$mockOutput		=	$this->getMockBuilder( 'OutputPage' )
								->disableOriginalConstructor()
								->setMethods( array( 'getHTML', 'clearHTML' ) )
								->getMock();
		
		$mockContLang	=	$this->getMockBuilder( 'Language' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockWallMsg	=	$this->getMockBuilder( 'WallMessage' )
								->disableOriginalConstructor()
								->setMethods( array( 'load', 'isMain', 'getMetaTitle', 'getTopParentObj' ) )
								->getMock();
		
		$reflectionApp = new ReflectionProperty( 'WikiaSearchIndexer', 'app' );
		$reflectionApp->setAccessible( true );
		$reflectionApp->setValue( $mockIndexer, $mockApp );
		
		$mockGlobals = array( 
				'Title'				=>	$mockTitle, 
				'Request'			=>	$mockRequest, 
				'Out'				=>	$mockOutput, 
				'ExternalSharedDB'	=>	true, 
				'CityId'			=>	123, 
				'Server'			=>	'http://foo.wikia.com', 
				'ContLang'			=>	(object) array( 'mCode' => 'en' ),
				'ContentNamespaces'	=>	array( NS_MAIN, NS_CATEGORY ) 
				);
		
		$reflectionWg = new ReflectionProperty( 'WikiaSearchIndexer', 'wg' );
		$reflectionWg->setAccessible( true );
		$reflectionWg->setValue( $mockIndexer, (object) $mockGlobals );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getTitle' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockIndexer
			->expects	( $this->any() )
			->method	( 'getPageMetaData' )
			->will		( $this->returnValue( array() ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getRedirectTarget' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getNamespace' )
			->will		( $this->returnValue( NS_WIKIA_FORUM_BOARD_THREAD ) )
		;
		$commentTitle = "my comment title";
		$mockWallMsg
			->expects	( $this->any() )
			->method	( 'getMetaTitle' )
			->will		( $this->returnValue( $commentTitle ) )
		;
		$mockWallMsg
			->expects	( $this->any() )
			->method	( 'isMain' )
			->will		( $this->returnValue( false ) )
		;
		$mockWallMsg
			->expects	( $this->any() )
			->method	( 'getTopParentObj' )
			->will		( $this->returnValue( $mockWallMsg ) )
		;
		
		
		$this->mockClass( 'Article', $mockArticle );
		$this->mockClass( 'WallMessage', $mockWallMsg );
		$this->mockApp();
		
		$page = $mockIndexer->getPage( 123 );
		
		$this->assertEquals(
				$commentTitle,
				$page['title'],
				"WikiaSearchIndexer::getPage should index the main comment title as the title, not the child comment's page title"
		);
	}
	
}