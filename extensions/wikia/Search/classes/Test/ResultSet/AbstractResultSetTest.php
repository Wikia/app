<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet\AbstractResultSetTest
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionProperty, ReflectionMethod, ArrayIterator;
/**
 * Tests abstract result set class
 */
class AbstractResultSetTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09747 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::__construct
	 */
	public function testConstruct() {
		$dc = new Wikia\Search\ResultSet\DependencyContainer();
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->setConstructorArgs( array( $dc ) )
		                  ->getMockForAbstractClass();
		
		// constructor should call configure(), but we have no way of asserting this
		// (other than everything else breaking in other tests)
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09517 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getResultsFound
	 */
	public function testGetResultsFound() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$resultsFound = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'resultsFound' );
		$resultsFound->setAccessible( true );
		$resultsFound->setValue( $resultSet, 20 );
		$this->assertEquals(
				20,
				$resultSet->getResultsFound()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09598 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::hasResults
	 */
	public function testHasResults() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$this->assertFalse(
				$resultSet->hasResults()
		);
		$resultsFound = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'results' );
		$resultsFound->setAccessible( true );
		$resultsFound->setValue( $resultSet, new ArrayIterator( array( 123, 456 ) ) );
		$this->assertTrue(
				$resultSet->hasResults()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09766 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getResultsNum
	 */
	public function testGetResultsNum() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$resultsFound = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'results' );
		$resultsFound->setAccessible( true );
		$resultsFound->setValue( $resultSet, new ArrayIterator( array( 123, 456 ) ) );
		$this->assertEquals(
				2,
				$resultSet->getResultsNum()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09813 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::setHeader
	 */
	public function testSetHeader() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$this->assertEquals(
				$resultSet,
				$resultSet->setHeader( 'foo', 'bar' )
		);
		$headers = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'header' );
		$headers->setAccessible( true );
		$this->assertEquals(
				array( 'foo' => 'bar' ),
				$headers->getValue( $resultSet )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09916 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::addHeaders
	 */
	public function testAddHeaders() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'setHeader' ) )
		                  ->getMockForAbstractClass();
		
		$resultSet
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setHeader' )
		    ->with   ( 'foo', 'bar' )
		;
		$resultSet
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setHeader' )
		    ->with   ( 'baz', 'qux' )
		;
		$this->assertEquals(
				$resultSet,
				$resultSet->addHeaders( array( 'foo' => 'bar', 'baz' => 'qux' ) )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09601 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getHeader
	 */
	public function testGetHeader() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		$headers = array( 'foo' => 'bar' );
		$headersRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'header' );
		$headersRefl->setAccessible( true );
		$headersRefl->setValue( $resultSet, $headers );
		
		$this->assertEquals(
				$headers,
				$resultSet->getHeader()
		);
		$this->assertEquals(
				'bar',
				$resultSet->getHeader( 'foo' )
		);
		$this->assertNull(
				$resultSet->getHeader( 'baz' )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getResults
	 */
	public function testGetResults() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		$this->assertAttributeNotInstanceOf(
				'ArrayIterator',
				'results',
				$resultSet
		);
		$this->assertInstanceOf(
				'ArrayIterator',
				$resultSet->getResults()
		);
		$this->assertAttributeInstanceOf(
				'ArrayIterator',
				'results',
				$resultSet
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09642 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getQuery
	 */
	public function testGetQuery() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getQueryForHtml' ), array( 'foo' ) );
		$configRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'searchConfig' );
		$configRefl->setAccessible( true );
		$configRefl->setValue( $resultSet, $mockConfig );
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
	    ;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getQueryForHtml' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$this->assertEquals(
				'foo',
				$resultSet->getQuery()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0982 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::toArray
	 */
	public function testToArray() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getResults' ) )
		                  ->getMockForAbstractClass();
		
		$mockResult = $this->getMock( 'Wikia\Search\Result', array( 'toArray' ) );
		
		$docArray = array( 'title' => 'foo', 'url' => 'wikia.com/foo' );
		$resultSet
		    ->expects( $this->once() )
		    ->method ( 'getResults' )
		    ->will   ( $this->returnValue( new ArrayIterator( array( $mockResult ) ) ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'toArray' )
		    ->with   ( array( 'title', 'url', 'pageid' ) )
		    ->will   ( $this->returnValue( $docArray ) )
		;
		$this->assertEquals(
				array( $docArray ),
				$resultSet->toArray()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09603 ms
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getIterable
	 */
	public function testGetIterable() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getResults' ) )
		                  ->getMockForAbstractClass();
		
		$whoCares = 'This result type does not matter';
		$resultSet
		    ->expects( $this->once() )
		    ->method ( 'getResults' )
		    ->will   ( $this->returnValue( $whoCares ) )
		;
		$this->assertEquals(
				$whoCares,
				$resultSet->getIterable()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.11333 ms
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::offsetExists
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::offsetGet
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::offsetSet
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::offsetUnset
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::append
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::rewind
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::current
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::key
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::next
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::valid
	 * @covers Wikia\Search\Traits\AttributeIterableTrait::seek
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::offsetExists
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::offsetGet
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::offsetSet
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::offsetUnset
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::append
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::rewind
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::current
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::key
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::next
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::valid
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::seek
	 */
	public function testAttributeIterable() {
		$methodArgs = array(
				'offsetExists' => array( 'foo' ),
				'offsetSet'    => array( 'foo', 'bar' ),
				'offsetGet'    => array( 'foo' ),
				'offsetUnset'  => array( 'foo' ),
				'append'       => array( 'foo' ),
				'seek'         => array( 'foo' ),
				);
		$methods = array( 
				'offsetExists', 'offsetGet', 'offsetSet', 'offsetUnset', 
				'append', 'rewind', 'current', 'key', 'next', 'valid', 'seek' 
				);
		$mockIterator = $this->getMock( '\ArrayIterator', $methods, array( array() ) );
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getIterable' ) )
		                  ->getMockForAbstractClass();
		$resultSet
		    ->expects( $this->any() )
		    ->method ( 'getIterable' )
		    ->will   ( $this->returnValue( $mockIterator ) )
		;
		foreach ( $methods as $method ) {
			$with = $mockIterator
			            ->expects( $this->once() )
			            ->method ( $method )
			;
			if ( isset( $methodArgs[$method] ) ) {
				$with = call_user_func_array( array( $with, 'with' ), $methodArgs[$method] );
				call_user_func_array( array( $resultSet, $method ), $methodArgs[$method] );
			} else {
				$resultSet->{$method}();
			}
			
		}
	}
	
}
