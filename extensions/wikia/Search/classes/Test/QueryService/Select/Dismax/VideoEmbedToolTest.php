<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\VideoEmbedToolTest
 */
namespace Wikia\Search\Test\QueryService\Select\Dismax;
use Wikia\Search\Test\BaseTest, ReflectionMethod, Wikia\Search\Utilities;
/**
 * Responsible for testing VideoEmbedTool query service.
 * @author relwell
 */
class VideoEmbedToolTest extends BaseTest
{
	const CLASSNAME = 'Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool';
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getQuery
	 */
	public function testGetQuery() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getQueryClausesString', 'getTopicsAsQuery', 'getTransformedQuery' ] )
		                ->getMock();
		
		$qc = '"query clauses"';
		$topicq = 'kendrick lamar OR kdot OR goat';
		$transq = 'swimming pools';
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->will   ( $this->returnValue( $qc ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTopicsAsQuery' )
		    ->will   ( $this->returnValue( $topicq ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTransformedQuery' )
		    ->will   ( $this->returnValue( $transq ) )
		;
		$get = new ReflectionMethod( self::CLASSNAME, 'getQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				sprintf( '+(%s) AND ( +(%s)^1000 AND +(%s)^2000 )', $qc, $topicq, $transq ),
				$get->invoke( $service )
		);
	}
	
	public function queryProvider() {
		return [
		    [ 'singleword', 'singleword' ],
		    [ 'multiple words', 'multiple^5 words' ]
		];
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getTransformedQuery
	 * @dataProvider queryProvider
	 */
	public function testGetTransformedQuery( $queryString, $expected ) {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getConfig' ] )
		                ->getMock();
		$config = $this->getMock( 'Wikia\Search\Config', [ 'getQuery' ] );
		$query = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSolrQuery' ], [ 'foo' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getQuery" )
		    ->will   ( $this->returnValue( $query ) )
		;
		$query
		    ->expects( $this->once() )
		    ->method ( 'getSolrQuery' )
		    ->will   ( $this->returnValue( $queryString ) )
		;
		$get = new ReflectionMethod( self::CLASSNAME, 'getTransformedQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getTopicsAsQuery
	 */
	public function testGetTopicsAsQueryWithTopics() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiVideoSearchTopics', [] )
		    ->will   ( $this->returnValue( [ 'topic 1', 'topic2' ] ) )
		;
		
		$get = new ReflectionMethod( self::CLASSNAME, 'getTopicsAsQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				'"topic 1" OR "topic2"',
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getTopicsAsQuery
	 */
	public function testGetTopicsAsQueryNoTopics() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal', 'getGlobalWithDefault' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiVideoSearchTopics', [] )
		    ->will   ( $this->returnValue( [] ) )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( 'Diamond Lane Wiki' ) )
		;
		$get = new ReflectionMethod( self::CLASSNAME, 'getTopicsAsQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				'"diamond lane"',
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getConfig' ] )
		                ->getMock();
		
		$config = $this->getMock( 'Wikia\Search\Config', [ 'getWikiId' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		
		$get = new ReflectionMethod( self::CLASSNAME, 'getQueryClausesString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'(' . implode( ' AND ', [ Utilities::valueForField( 'wid', 123 ), Utilities::valueForField( 'is_video', 'true' ), Utilities::valueForField( 'ns', \NS_FILE ) ] ) . ')',
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoEmbedTool::getBoostQueryString
	 */
	public function testGetBoostQueryString() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getConfig', 'getTopicsAsQuery', 'getService' ] )
		                ->getMock();
		
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getHubForWikiId', 'getWikiId' ] ); 
		$config = $this->getMock( 'Wikia\Search\Config', [ 'getQuery' ] );
		$query = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSolrQuery' ], [ 'foo' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getHubForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'Entertainment' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $query ) )
		;
		$query
		    ->expects( $this->once() )
		    ->method ( 'getSolrQuery' )
		    ->will   ( $this->returnValue( 'solrquery' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTopicsAsQuery' )
		    ->will   ( $this->returnValue( 'topicquery' ) )
		;
		$this->assertEquals(
				sprintf( '%s^150 AND (%s)^250 AND (html_media_extras_txt:(%s))^300', Utilities::valueForField( 'categories', 'Entertainment' ), 'solrquery', 'topicquery' ),
				$service->getBoostQueryString()
		);
	}
	
}