<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\AbstractDismaxTest
 */
namespace Wikia\Search\Test\QueryService\Select\Dismax;
use Wikia\Search\Test\BaseTest, ReflectionMethod;
/**
 * Tests default functionality shared by all dismax-style query services
 * @author relwell
 */
class AbstractDismaxTest extends BaseTest
{

	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQuery
	 */
	public function testGetQuery() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQuery' ] );
		
		$dc = new \Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( [ $dc ] )
		                   ->setMethods( array( 'getQueryClausesString' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSolrQuery' ], [ 'foo' ] );
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSolrQuery' )
		    ->with   ( 10 )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$method = new ReflectionMethod( $mockSelect, 'getFormulatedQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'+(foo) AND (bar)',
				$method->invoke( $mockSelect )
		);
	}
	
}