<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetAbstractResultSetTest extends WikiaSearchBaseTest {
	
	/**
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
	 * @covers Wikia\Search\ResultSet\AbstractResultSet::getQuery
	 */
	public function testGetQuery() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\AbstractResultSet' )
		                  ->disableOriginalConstructor()
		                  ->getMockForAbstractClass();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery' ) );
		$configRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\AbstractResultSet', 'searchConfig' );
		$configRefl->setAccessible( true );
		$configRefl->setValue( $resultSet, $mockConfig );
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->with   ( Wikia\Search\Config::QUERY_ENCODED )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$this->assertEquals(
				'foo',
				$resultSet->getQuery()
		);
	}
	
	/**
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
		    ->with   ( array( 'title', 'url' ) )
		    ->will   ( $this->returnValue( $docArray ) )
		;
		$this->assertEquals(
				array( $docArray ),
				$resultSet->toArray()
		);
	}
	
	/**
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
	
}