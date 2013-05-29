<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\VideoEmbedToolTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia\Search\Test\BaseTest, ReflectionMethod;
/**
 * Responsible for testing VideoEmbedTool query service.
 * @author relwell
 */
class VideoEmbedToolTest extends BaseTest
{
	const CLASSNAME = 'Wikia\Search\QueryService\Select\VideoEmbedTool';
	
	/**
	 * @covers Wikia\Search\QueryService\Select\VideoEmbedTool::getFormulatedQuery
	 */
	public function testGetFormulatedQuery() {
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
		$get = new ReflectionMethod( self::CLASSNAME, 'getFormulatedQuery' );
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
	 * @covers Wikia\Search\QueryService\Select\VideoEmbedTool::getTransformedQuery
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
	 * @covers Wikia\Search\QueryService\Select\VideoEmbedTool::getTopicsAsQuery
	 */
	public function testGetTopicsAsQuery() {
		
	}
	
}