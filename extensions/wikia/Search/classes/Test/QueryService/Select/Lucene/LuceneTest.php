<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Lucene\LuceneTest
 */
namespace Wikia\Search\Test\QueryService\Select\Lucene;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests functionality of Wikia\Search\QueryService\Select\Lucene\Lucene
 */
class LuceneTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Lucene\Lucene::getQuery
	 */
	public function testGetQuery() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Lucene\Lucene' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
	    ;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo:bar' ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Lucene\Lucene', 'getQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'foo:bar',
				$method->invoke( $mockSelect )
		);
	}
}