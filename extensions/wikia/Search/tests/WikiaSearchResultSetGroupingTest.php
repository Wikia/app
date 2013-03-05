<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetGroupingGroupingTest extends WikiaSearchBaseTest
{
	
	/**
	 * Convenience method to easily handle the necessary dependencies & method mocking for recurrent mocks
	 * @param array $resultSetMethods
	 * @param array $configMethods
	 * @param array $resultMethods
	 */
	protected function prepareMocks( $resultSetMethods = array(), $configMethods = array(), $resultMethods = array() ) { 
	
		$this->searchResult		=	$this->getMockBuilder( 'Solarium_Result_Select' )
									->disableOriginalConstructor()
									->setMethods( $resultMethods )
									->getMock();
		
		$this->config		=	$this->getMockBuilder( 'WikiaSearchConfig' )
									->disableOriginalConstructor()
									->setMethods( $configMethods )
									->getMock();
		
		$this->resultSet	=	$this->getMockBuilder( '\Wikia\Search\ResultSet\Grouping' )
									->disableOriginalConstructor()
									->setMethods( $resultSetMethods )
									->getMock();
		
		$reflResult = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'searchResultObject' );
		$reflResult->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->searchResult );
		
		$reflConfig = new ReflectionProperty(  '\Wikia\Search\ResultSet\Base', 'searchConfig' );
		$reflConfig->setAccessible( true );
		$reflConfig->setValue( $this->resultSet, $this->config );
	}

	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWithoutGrouping() {
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( null ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should throw an exception if called in a situation where we are not grouping results'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWithoutHostGrouping() {
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Result_Select_Grouping' )
							->disableOriginalConstructor()
							->setMethods( array( 'getGroup' ) )
							->getMock();
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
			->expects	( $this->at( 0 ) )
			->method	( 'getGroup' )
			->with		( 'host' )
			->will		( $this->returnValue( null ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should throw an exception if called in a situation where we are not grouping results by host'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWorks() {
		
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Result_Select_Grouping' )
							->disableOriginalConstructor()
							->setMethods( array( 'getGroup' ) )
							->getMock();
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getValueGroups' ) )
							->getMock();
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
			->expects	( $this->at( 0 ) )
			->method	( 'getGroup' )
			->with		( 'host' )
			->will		( $this->returnValue( $mockFieldGroup ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		$this->assertEquals(
				$mockFieldGroup,
				$method->invoke( $this->resultSet ),
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should return an instance of Solarium_Result_Select_Grouping_FieldGroup'
		);
	}
}