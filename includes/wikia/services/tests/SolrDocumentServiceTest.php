<?php

class SolrDocumentServiceTest extends WikiaBaseTest
{
	public function testGetResultNoResult() {
		$service = $this->getMock( 'SolrDocumentService', [ 'getConfig', 'getFactory', 'getDocumentId' ] );
		$factory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setQuery' ] );
		$queryService = $this->getMock( 'Wikia\Search\QueryService\Lucene\Lucene', [ 'search' ] );
		$resultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'offsetGet', 'offsetExists' ] )
		                  ->getMock();
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getDocumentId' )
		    ->will   ( $this->returnValue( '123_456' ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( Wikia\Search\Utilities::valueForField( 'id', '123_456' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getFactory' )
		    ->will   ( $this->returnValue( $factory ) )
		;
		$factory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->with   ( $config )
		    ->will   ( $this->returnValue( $queryService ) )
		;
		$queryService
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $resultSet ) )
		;
		$resultSet
		    ->expects( $this->once() )
		    ->method ( 'offsetExists' )
		    ->with   ( '123_456' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertNull(
				$service->getResult()
		);
		$this->assertArrayNotHasKey(
				'123_456',
				SolrDocumentService::$documentCache
		);
	}
	
	public function testGetDocumentWithResult() {
		$service = $this->getMock( 'SolrDocumentService', [ 'getConfig', 'getFactory', 'getDocumentId' ] );
		$factory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setQuery' ] );
		$queryService = $this->getMock( 'Wikia\Search\QueryService\Lucene\Lucene', [ 'search' ] );
		$resultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'offsetGet', 'offsetExists' ] )
		                  ->getMock();
		$result = $this->getMock( 'Wikia\Search\Result' );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getDocumentId' )
		    ->will   ( $this->returnValue( '123_456' ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( Wikia\Search\Utilities::valueForField( 'id', '123_456' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getFactory' )
		    ->will   ( $this->returnValue( $factory ) )
		;
		$factory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->with   ( $config )
		    ->will   ( $this->returnValue( $queryService ) )
		;
		$queryService
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $resultSet ) )
		;
		$resultSet
		    ->expects( $this->once() )
		    ->method ( 'offsetExists' )
		    ->with   ( '123_456' )
		    ->will   ( $this->returnValue( true ) )
		;
		$resultSet
		    ->expects( $this->once() )
		    ->method ( 'offsetGet' )
		    ->with   ( '123_456' )
		    ->will   ( $this->returnValue( $result ) )
		;
		$this->assertEquals(
				$result,
				$service->getResult()
		);
		$this->assertArrayHasKey(
				'123_456',
				SolrDocumentService::$documentCache
		);
	}
	
	public function testGetDocumentWithCachedResult() {
		$service = $this->getMock( 'SolrDocumentService', [ 'getConfig', 'getFactory', 'getDocumentId' ] );
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setQuery' ] );
		$this->assertArrayHasKey(
				'123_456',
				SolrDocumentService::$documentCache
		);
		$service
		    ->expects( $this->never() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getDocumentId' )
		    ->will   ( $this->returnValue( '123_456' ) )
		;
		$this->assertInstanceOf(
				'Wikia\Search\Result',
				$service->getResult()
		);
	}
	
	/**
	 * @covers SolrDocumentService::setArticleId
	 * @covers SolrDocumentService::getArticleId
	 */
	public function testSetGetArticleId() {
		$ds = new SolrDocumentService();
		$this->assertAttributeEmpty(
				'articleId',
				$ds
		);
		$this->assertEquals(
				$ds,
				$ds->setArticleId( 123 )
		);
		$this->assertAttributeEquals(
				123,
				'articleId',
				$ds
		);
		$this->assertEquals(
				123,
				$ds->getArticleId()
		);
	}
	
	/**
	 * @covers SolrDocumentService::setWikiId
	 * @covers SolrDocumentService::getWikiId
	 */
	public function testSetGetWikiId() {
		$ds = new SolrDocumentService();
		$this->assertAttributeEmpty(
				'wikiId',
				$ds
		);
		global $wgCityId;
		$this->assertEquals(
				$wgCityId,
				$ds->getWikiId()
		);
		$this->assertAttributeEquals(
				$wgCityId,
				'wikiId',
				$ds
		);
		$this->assertEquals(
				$ds,
				$ds->setWikiId( 123 )
		);
		$this->assertAttributeEquals(
				123,
				'wikiId',
				$ds
		);
		$this->assertEquals(
				123,
				$ds->getWikiId()
		);
	}
	
	/**
	 * @covers SolrDocumentService::getDocumentId
	 */
	public function testGetDocumentIdMain() {
		$ds = $this->getMock( 'SolrDocumentService', [ 'getCrossWiki', 'getWikiId', 'getArticleId' ] );
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getCrossWiki' )
		    ->will   ( $this->returnValue( false ) )
		;
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getArticleId' )
		    ->will   ( $this->returnValue( 234 ) ) 
		;
		$get = new ReflectionMethod( $ds, 'getDocumentId' );
		$get->setAccessible( true );
		$this->assertEquals(
				'123_234',
				$get->invoke( $ds )
		);
	}
	
	/**
	 * @covers SolrDocumentService::getDocumentId
	 */
	public function testGetDocumentIdXwiki() {
		$ds = $this->getMock( 'SolrDocumentService', [ 'getCrossWiki', 'getWikiId', 'getArticleId' ] );
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getCrossWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$ds
		    ->expects( $this->never() )
		    ->method ( 'getArticleId' )
		;
		$get = new ReflectionMethod( $ds, 'getDocumentId' );
		$get->setAccessible( true );
		$this->assertEquals(
				123,
				$get->invoke( $ds )
		);
	}
	
	/**
	 * @covers SolrDocumentService::getConfig
	 */
	public function testGetConfigCrossWiki() {
		$ds = $this->getMock( 'SolrDocumentService', [ 'getCrossWiki' ] );
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setCrossWikiLuceneQuery', 'setDirectLuceneQuery', 'setLimit' ] );
		
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getCrossWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setLimit' )
		    ->with   ( 1 )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setCrossWikiLuceneQuery' )
		    ->with   ( true )
		;
		$this->proxyClass( 'Wikia\Search\Config', $config );
		$get = new ReflectionMethod( $ds, 'getConfig' );
		$get->setAccessible( true );
		$this->assertEquals(
				$config,
				$get->invoke( $ds )
		);
	}
	
	/**
	 * @covers SolrDocumentService::getConfig
	 */
	public function testGetConfigMain() {
		$ds = $this->getMock( 'SolrDocumentService', [ 'getCrossWiki' ] );
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setCrossWikiLuceneQuery', 'setDirectLuceneQuery', 'setLimit' ] );
		
		$ds
		    ->expects( $this->once() )
		    ->method ( 'getCrossWiki' )
		    ->will   ( $this->returnValue( false ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setLimit' )
		    ->with   ( 1 )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setDirectLuceneQuery' )
		    ->with   ( true )
		;
		$this->proxyClass( 'Wikia\Search\Config', $config );
		$get = new ReflectionMethod( $ds, 'getConfig' );
		$get->setAccessible( true );
		$this->assertEquals(
				$config,
				$get->invoke( $ds )
		);
	}
	
	/**
	 * @covers SolrDocumentService::getFactory
	 */
	public function testGetFactory() {
		$ds = new SolrDocumentService;
		$get = new ReflectionMethod( $ds, 'getFactory' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'Wikia\Search\QueryService\Factory',
				$get->invoke( $ds )
		);
	}
	
	/**
	 * @covers SolrDocumentService::getCrossWiki
	 * @covers SolrDocumentService::setCrossWiki
	 */
	public function testSetGetCrossWiki() {
		$ds = new SolrDocumentService;
		$this->assertAttributeEquals(
				false,
				'crossWiki',
				$ds
		);
		$this->assertFalse(
				$ds->getCrossWiki()
		);
		$this->assertEquals(
				$ds,
				$ds->setCrossWiki( true )
		);
		$this->assertAttributeEquals(
				true,
				'crossWiki',
				$ds
		);
		$this->assertTrue(
				$ds->getCrossWiki()
		);
	}
	
}
