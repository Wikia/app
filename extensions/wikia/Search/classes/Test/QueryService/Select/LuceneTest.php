<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\LuceneTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests functionality of Wikia\Search\QueryService\Select\Lucene
 */
class LuceneTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Lucene::getFormulatedQuery
	 */
	public function testGetFormulatedQuery() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Lucene' )
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
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Lucene', 'getFormulatedQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'foo:bar',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Lucene::getQueryFieldsString
	 * @todo this violates LSP so we need to not have this here
	 */
	public function testGetQueryFieldsString() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Lucene' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( null )
		                   ->getMock();
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Lucene', 'getQueryFieldsString' );
		$method->setAccessible( true );
		$this->assertEquals(
				'',
				$method->invoke( $mockSelect )
		);
	}
	
}