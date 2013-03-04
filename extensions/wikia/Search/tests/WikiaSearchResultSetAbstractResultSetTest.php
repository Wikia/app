<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetAbstractResultSetTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers Wikia\Search\ResultSet\AbstractResultSet
	 */
	public function testGetResultsFound() {
		$resultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\AbstractResultSet' )
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
	
}