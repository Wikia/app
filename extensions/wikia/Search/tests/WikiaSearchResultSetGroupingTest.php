<?php

class WikiaSearchResultSetGroupingTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @covers WikiaSearchResultSet::getHostGrouping
	public function testGetHostGroupingWithoutGrouping() {
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( null ) )
		;
		
		$method = new ReflectionMethod( 'WikiaSearchResultSet', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'WikiaSearchResultSet::getHostGrouping should throw an exception if called in a situation where we are not grouping results'
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::getHostGrouping
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
		
		$method = new ReflectionMethod( 'WikiaSearchResultSet', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'WikiaSearchResultSet::getHostGrouping should throw an exception if called in a situation where we are not grouping results by host'
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::getHostGrouping
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
		
		$method = new ReflectionMethod( 'WikiaSearchResultSet', 'getHostGrouping' );
		$method->setAccessible( true );
		
		$this->assertEquals(
				$mockFieldGroup,
				$method->invoke( $this->resultSet ),
				'WikiaSearchResultSet::getHostGrouping should return an instance of Solarium_Result_Select_Grouping_FieldGroup'
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::setResultGroupings
	public function testSetResultGroupings() {
		$this->prepareMocks( array( 'getHostGrouping', 'getHeader' ) );
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getValueGroups' ) )
							->getMock();
		
		$mockValueGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_ValueGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getNumFound', 'getValue', 'getDocuments' ) )
							->getMock();
		
		$resultSet2 = clone $this->resultSet;
		
		$url = 'http://foo.wikia.com';
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getHostGrouping' )
			->will		( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
			->expects	( $this->at( 0 ) )
			->method	( 'getValueGroups' )
			->will		( $this->returnValue( array( 'foo' ) ) ) // value doesn't matter
		;
		$resultSet2
			->expects	( $this->at( 0 ) )
			->method	( 'getHeader' )
			->will		( $this->returnValue( $url ) )
		;
		
		$this->mockClass( 'WikiaSearchResultSet', $resultSet2 );
		$this->mockApp();
		
		$method = new ReflectionMethod( 'WikiaSearchResultSet', 'setResultGroupings' );
		$method->setAccessible( true );
		
		$this->assertEquals(
				$this->resultSet,
				$method->invoke( $this->resultSet ),
				'WikiaSearchResultSet::setResultGrouping should provide a fluent interface'
		);
		
		$results = new ReflectionProperty( 'WikiaSearchResultSet', 'results' );
		$results->setAccessible( true );
		
		$this->assertArrayHasKey(
				$url,
				$results->getValue( $this->resultSet ),
				'WikiaSearchResultSet::setResultGroupings should set instances of WikiaSearchResultSet as values keyed by their URL in the parent\'s $result attribute'
		);
	}*/
}