<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetTest extends WikiaSearchBaseTest
{
	protected $config;
	protected $resultSet;
	protected $searchResult;
	
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
		
		$this->resultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
									->disableOriginalConstructor()
									->setMethods( $resultSetMethods )
									->getMock();
		
		$reflResult = new ReflectionProperty( 'WikiaSearchResultSet', 'searchResultObject' );
		$reflResult->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->searchResult );
		
		$reflConfig = new ReflectionProperty( 'WikiaSearchResultSet', 'searchConfig' );
		$reflConfig->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->config );
	}
	
	/**
	 * @covers WikiaSearchResultSet::configure
	 */
	public function testResultSetWithEmpty() {
		$this->prepareMocks();
		
		$this->searchResult = $this->getMock( 'Solarium_Result_Select_Empty' );
		
		$reflResult = new ReflectionProperty( 'WikiaSearchResultSet', 'searchResultObject' );
		$reflResult->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->searchResult );
		
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureGroupedSetAsRootNode' )
		;
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureGroupedSetAsLeafNode' )
		;
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureUngroupedSet' )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configure' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configure should always return true' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configure
	 */
	public function testResultSetUngrouped() {
		$resultSetMethods = array(
				'configureGroupedSetAsRootNode',
				'configureGroupedSetAsLeafNode',
				'configureUngroupedSet'
				);
		$configMethods = array(
				);
		$resultMethods = array(
				);
		
		$this->prepareMocks( $resultSetMethods, $configMethods, $resultMethods );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'configureGroupedSetAsRootNode' )
			->will		( $this->returnValue( false ) )
		;
		$this->resultSet
			->expects	( $this->at( 1 ) )
			->method	( 'configureGroupedSetAsLeafNode' )
			->will		( $this->returnValue( false ) )
		;
		$this->resultSet
			->expects	( $this->at( 2 ) )
			->method	( 'configureUngroupedSet' )
			->will		( $this->returnValue( true ) );
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configure' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configure should always return true' 
		);
		
	}
	

	/**
	 * @covers WikiaSearchResultSet::configure
	 */
	public function testResultSetGroupedLeaf() {
		$resultSetMethods = array(
				'configureGroupedSetAsRootNode',
				'configureGroupedSetAsLeafNode',
				'configureUngroupedSet'
				);
		$configMethods = array(
				);
		$resultMethods = array(
				);
		
		$this->prepareMocks( $resultSetMethods, $configMethods, $resultMethods );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'configureGroupedSetAsRootNode' )
			->will		( $this->returnValue( false ) )
		;
		$this->resultSet
			->expects	( $this->at( 1 ) )
			->method	( 'configureGroupedSetAsLeafNode' )
			->will		( $this->returnValue( true ) )
		;
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureUngroupedSet' )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configure' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configure should always return true' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configure
	 */
	public function testResultSetGroupedRoot() {
		$resultSetMethods = array(
				'configureGroupedSetAsRootNode',
				'configureGroupedSetAsLeafNode',
				'configureUngroupedSet'
				);
		$configMethods = array(
				);
		$resultMethods = array(
				);
		
		$this->prepareMocks( $resultSetMethods, $configMethods, $resultMethods );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'configureGroupedSetAsRootNode' )
			->will		( $this->returnValue( true ) )
		;
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureGroupedSetAsLeafNode' )
		;
		$this->resultSet
			->expects	( $this->never() )
			->method	( 'configureUngroupedSet' )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configure' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configure should always return true' 
		);
	}
}