<?php
/**
 * Class definition for Wikia\Search\Test\IndexerTest
 */
namespace Wikia\Search\Test;
use ReflectionProperty, ReflectionMethod;
/**
 * Tests Wikia\Search\Indexer
 * @author relwell
 *
 * @group Broken
 */
class IndexerTest extends BaseTest
{
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08802 ms
	 * @covers Wikia\Search\Indexer::getPages
	 */
	public function testGetPages() {
		$indexer = $this->getMockBuilder( 'Wikia\Search\Indexer' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getPage' ) )
		                ->getMock();
		$exception = $this->getMockBuilder( '\Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$resultArray = array( 'value doesnt matter' );
		$indexer
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getPage' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $resultArray ) )
		;
		$indexer
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getPage' )
		    ->with   ( 234 )
		    ->will   ( $this->throwException( $exception ) )
		;
		$this->assertEquals(
				array( 'pages' => array( 123 => $resultArray ), 'missingPages' => array( 234 ) ),
				$indexer->getPages( array( 123, 234 ) )
		);
	}

	/**
	 * @covers Wikia\Search\Indexer::getPage
	 */
	public function testGetPage() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', array( 'getMwService', 'getIndexService' ) );
		$reflServiceNames = new ReflectionProperty( 'Wikia\Search\Indexer', 'serviceNames' );
		$reflServiceNames->setAccessible( true );
		$reflServiceNames->setValue( $indexer, array( 'DefaultContent' ) );
		$mockIndexService = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'setPageId', 'getResponse' ) );
		$mockMwService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'getWikiId', 'getCanonicalPageIdFromPageId' ) );
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 234 )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$resultArray = array( 'this value' => 'not important' );
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getIndexService' )
		    ->with   ( 'DefaultContent' )
		    ->will   ( $this->returnValue( $mockIndexService ) )
		;
		$mockIndexService
		    ->expects( $this->once() )
		    ->method ( 'setPageId' )
		    ->with   ( 234 )
		    ->will   ( $this->returnValue( $mockIndexService ) )
		;
		$mockIndexService
		    ->expects( $this->once() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->returnValue( $resultArray ) )
		;
		$this->assertEquals(
				array_merge( array( 'id' => '123_456' ), $resultArray ),
				$indexer->getPage( 234 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08473 ms
	 * @covers Wikia\Search\Indexer::getIndexService
	 */
	public function testGetIndexService() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer' );
		$servicesRefl = new ReflectionProperty( 'Wikia\Search\Indexer', 'indexServices' );
		$servicesRefl->setAccessible( true );
		$services = $servicesRefl->getValue( $indexer );
		$this->assertEmpty( $services['DefaultContent'] );
		$get = new ReflectionMethod( 'Wikia\Search\Indexer', 'getIndexService' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'Wikia\Search\IndexService\DefaultContent',
				$get->invoke( $indexer, 'DefaultContent' )
		);
		$services = $servicesRefl->getValue( $indexer );
		$this->assertInstanceOf(
				 'Wikia\Search\IndexService\DefaultContent',
				$services['DefaultContent']
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08582 ms
	 * @covers Wikia\Search\Indexer::getSolrDocument
	 */
	public function testGetSolrDocument() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', array( 'getPage', 'getMwService' ) );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'setGlobal' ) );
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'setGlobal' )
		    ->with   ( 'AppStripsHtml', true )
		;
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getPage' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( array( 'id' => 123 ) ) )
		;
		$result = $indexer->getSolrDocument( 123 );
		$this->assertInstanceOf(
				'Wikia\Search\Result',
				$result
		);
		$this->assertEquals(
				123,
				$result['id']
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08538 ms
	 * @covers Wikia\Search\Indexer::reindexBatch
	 */
	public function testReindexBatch() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', array( 'getSolrDocument', 'updateDocuments' ) );
		$result = $this->getMock( 'Wikia\Search\Result' );
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getSolrDocument' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $result ) )
		;
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'updateDocuments' )
		    ->with   ( array( $result ) )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$indexer->reindexBatch( array( 123 ) )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0905 ms
	 * @covers Wikia\Search\Indexer::updateDocuments
	 */
	public function testUpdateDocuments() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getClient', 'getLogger' ] );
		$logger = $this->getMock( 'Wikia', [ 'log' ] );
		$client = $this->getMockBuilder( 'Solarium_Client' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'createUpdate', 'update' ] )
		               ->getMock();
		$update = $this->getMockBuilder( 'Solarium_Query_Update' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'addDocuments', 'addCommit' ] )
		               ->getMock();
		$exception = $this->getMockBuilder( 'Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$documents = [ $this->getMock( 'Wikia\Search\Result' ) ];
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getClient' )
		    ->will   ( $this->returnValue( $client ) )
		;
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getLogger' )
		    ->will   ( $this->returnValue( $logger ) )
		;
		$client
		    ->expects( $this->any() )
		    ->method ( 'createUpdate' )
		    ->will   ( $this->returnValue( $update ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addDocuments' )
		    ->with   ( $documents )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addCommit' )
		;
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		;
		$this->assertTrue(
				$indexer->updateDocuments( $documents )
		);
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->will   ( $this->throwException( $exception ) )
		;
		/* causes test to hang
		$logger
		    ->staticExpects( $this->at( 0 ) )
		    ->method ( 'log' )
		    ->with   ( 'Wikia\Search\Indexer::updateDocuments', '', $exception )
		;*/
		$this->assertTrue(
				$indexer->updateDocuments( $documents )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.09558 ms
	 * @covers Wikia\Search\Indexer::reindexWiki
	 */
	public function testReindexWiki() {
		$dataSource = $this->getMockBuilder( 'WikiaDataSource' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getDB' ] )
		                   ->getMock();
		$dbHandler = $this->getMockBuilder( 'DatabaseMysqli' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'query', 'fetchObject'] )
		                  ->getMock();
		$rows = $this->getMockBuilder( 'ResultWrapper' )
		             ->disableOriginalconstructor()
		             ->getMock();
		$sp = $this->getMockBuilder( 'ScribeProduce' )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'reindexPage' ] )
		           ->getMock();
		$exception = $this->getMockBuilder( '\Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$logger = $this->getMock( 'Wikia', [ 'log' ] );
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getLogger' ] );

		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getLogger' )
		    ->will   ( $this->returnValue( $logger ) )
		;
		$dataSource
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDB' )
		    ->will   ( $this->returnValue( $dbHandler ) )
		;
		$dbHandler
		    ->expects( $this->at( 0 ) )
		    ->method ( 'query' )
		    ->with   ( 'SELECT page_id FROM page' )
		    ->will   ( $this->returnValue( $rows ) )
		;
		$dbHandler
		    ->expects( $this->at( 1 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $rows )
		    ->will   ( $this->returnValue( (object) array( 'page_id' => 123 ) ) )
		;
		$dbHandler
		    ->expects( $this->at( 2 ) )
		    ->method ( 'fetchObject' )
		    ->with   ( $rows )
		    ->will   ( $this->returnValue( null ) )
		;
		$sp
		    ->expects( $this->once() )
		    ->method ( 'reindexPage' )
		;
		$this->mockClass( 'ScribeProducer', $sp );
		$this->mockClass( 'WikiDataSource', $dataSource );
		$indexer->reindexWiki( 123 );
		$dataSource
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDB' )
		    ->will   ( $this->throwException( $exception ) )
		;
		$this->assertTrue( $indexer->reindexWiki( 123 ) );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08961 ms
	 * @covers Wikia\Search\Indexer::deleteWikiDocs
	 */
	public function testDeleteWikiDocs() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getClient', 'getLogger' ] );
		$logger = $this->getMock( 'Wikia', [ 'log' ] );
		$client = $this->getMockBuilder( 'Solarium_Client' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'createUpdate', 'update' ] )
		               ->getMock();
		$update = $this->getMockBuilder( 'Solarium_Query_Update' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'addDeleteQuery', 'addCommit' ] )
		               ->getMock();
		$exception = $this->getMockBuilder( 'Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getClient' )
		    ->will   ( $this->returnValue( $client ) )
		;
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getLogger' )
		    ->will   ( $this->returnValue( $logger ) )
		;
		$client
		    ->expects( $this->any() )
		    ->method ( 'createUpdate' )
		    ->will   ( $this->returnValue( $update ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addDeleteQuery' )
		    ->with   ( \Wikia\Search\Utilities::valueForField( 'wid', 123 ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addCommit' )
		;
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->returnValue( $this->getMockBuilder( 'Solarium_Result' )->disableOriginalConstructor()->getMock() ) )
		;
		$this->assertInstanceOf(
				'Solarium_Result',
				$indexer->deleteWikiDocs( 123 )
		);
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->throwException( $exception ) )
		;
		/* causes test to hang
		$logger
		    ->staticExpects( $this->at( 0 ) )
		    ->method ( 'log' )
		    ->with   ( 'Wikia\Search\Indexer::updateDocuments', '', $exception )
		;*/
		$this->assertTrue(
				$indexer->deleteWikiDocs( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0923 ms
	 * @covers Wikia\Search\Indexer::deleteManyWikiDocs
	 */
	public function testDeleteManyWikiDocs() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getClient', 'getLogger' ] );
		$logger = $this->getMock( 'Wikia', [ 'log' ] );
		$client = $this->getMockBuilder( 'Solarium_Client' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'createUpdate', 'update' ] )
		               ->getMock();
		$update = $this->getMockBuilder( 'Solarium_Query_Update' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'addDeleteQuery', 'addCommit' ] )
		               ->getMock();
		$exception = $this->getMockBuilder( 'Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getClient' )
		    ->will   ( $this->returnValue( $client ) )
		;
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getLogger' )
		    ->will   ( $this->returnValue( $logger ) )
		;
		$client
		    ->expects( $this->any() )
		    ->method ( 'createUpdate' )
		    ->will   ( $this->returnValue( $update ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addDeleteQuery' )
		    ->with   ( \Wikia\Search\Utilities::valueForField( 'wid', 123 ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addCommit' )
		;
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->returnValue( $this->getMockBuilder( 'Solarium_Result' )->disableOriginalConstructor()->getMock() ) )
		;
		$this->assertInstanceOf(
				'Solarium_Result',
				$indexer->deleteManyWikiDocs( array( 123 ) )
		);
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->throwException( $exception ) )
		;
		/* causes test to hang
		$logger
		    ->staticExpects( $this->at( 0 ) )
		    ->method ( 'log' )
		    ->with   ( 'Wikia\Search\Indexer::updateDocuments', '', $exception )
		;*/
		$this->assertNull(
				$indexer->deleteManyWikiDocs( array( 123 ) )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08713 ms
	 * @covers Wikia\Search\Indexer::deleteBatch
	 */
	public function testDeleteBatch() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getClient', 'getLogger' ] );
		$logger = $this->getMock( 'Wikia', [ 'log' ] );
		$client = $this->getMockBuilder( 'Solarium_Client' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'createUpdate', 'update' ] )
		               ->getMock();
		$update = $this->getMockBuilder( 'Solarium_Query_Update' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'addDeleteQuery', 'addCommit' ] )
		               ->getMock();
		$exception = $this->getMockBuilder( 'Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getClient' )
		    ->will   ( $this->returnValue( $client ) )
		;
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getLogger' )
		    ->will   ( $this->returnValue( $logger ) )
		;
		$client
		    ->expects( $this->any() )
		    ->method ( 'createUpdate' )
		    ->will   ( $this->returnValue( $update ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addDeleteQuery' )
		    ->with   ( \Wikia\Search\Utilities::valueForField( 'id', '123_234' ) )
		;
		$update
		    ->expects( $this->any() )
		    ->method ( 'addCommit' )
		;
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->returnValue( $this->getMockBuilder( 'Solarium_Result' )->disableOriginalConstructor()->getMock() ) )
		;
		$this->assertTrue(
				$indexer->deleteBatch( array( '123_234' ) )
		);
		$client
		    ->expects( $this->at( 1 ) )
		    ->method ( 'update' )
		    ->with   ( $update )
		    ->will   ( $this->throwException( $exception ) )
		;
		/* causes test to hang
		$logger
		    ->staticExpects( $this->at( 0 ) )
		    ->method ( 'log' )
		    ->with   ( 'Wikia\Search\Indexer::updateDocuments', '', $exception )
		;*/
		$this->assertTrue(
				$indexer->deleteBatch( array( '123_234' ) )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08382 ms
	 * @covers Wikia\Search\Indexer::reindexPage
	 */
	public function testReindexPage() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getSolrDocument', 'reindexBatch' ] );
		$doc = $this->getMock( 'Wikia\Search\Result' );
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'getSolrDocument' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $doc ) )
		;
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'reindexBatch' )
		    ->with   ( array( $doc ) )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertTrue(
				$indexer->reindexPage( 123 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08377 ms
	 * @covers Wikia\Search\Indexer::deleteArticle
	 */
	public function testDeleteArticle() {
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiId' ] );
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'deleteBatch', 'getMwService' ] );
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$indexer
		    ->expects( $this->once() )
		    ->method ( 'deleteBatch' )
		    ->with   ( array( '123_234' ) )
		;
		$this->assertTrue(
				$indexer->deleteArticle( 234 )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0845 ms
	 * @covers Wikia\Search\Indexer::getClient
	 */
	public function testGetClient() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer', [ 'getMwService' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal', 'isOnDbCluster' ] );
		$indexer
		    ->expects( $this->any() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->any() )
		    ->method ( 'isOnDbCluster' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
			->expects( $this->any() )
			->method ( 'getGlobal' )
			// first called with 'SolrMaster' then with 'SolrDefaultPort'
			->will   ( $this->onConsecutiveCalls( 'search', 1234 ) )
		;
		$this->assertAttributeEmpty(
				'client',
				$indexer
		);
		$get = new ReflectionMethod( 'Wikia\Search\Indexer', 'getClient' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'Solarium_Client',
				$get->invoke( $indexer )
		);
		$this->assertAttributeInstanceOf(
				'Solarium_Client',
				'client',
				$indexer
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08199 ms
	 * @covers Wikia\Search\Indexer::getLogger
	 */
	public function testGetLogger() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer' );
		$get = new ReflectionMethod( 'Wikia\Search\Indexer', 'getLogger' );
		$get->setAccessible( true );
		$this->assertAttributeEmpty(
				'logger',
				$indexer
		);
		$this->assertInstanceOf(
				'Wikia',
				$get->invoke( $indexer )
		);
		$this->assertAttributeInstanceOf(
				'Wikia',
				'logger',
				$indexer
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08387 ms
	 * @covers Wikia\Search\Indexer::getMwService
	 */
	public function testGetMwService() {
		$indexer = $this->getMock( 'Wikia\Search\Indexer' );
		$get = new ReflectionMethod( 'Wikia\Search\Indexer', 'getMwService' );
		$get->setAccessible( true );
		$this->assertAttributeEmpty(
				'mwService',
				$indexer
		);
		$this->assertInstanceOf(
				'Wikia\Search\MediaWikiService',
				$get->invoke( $indexer )
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService',
				'mwService',
				$indexer
		);
	}
}
