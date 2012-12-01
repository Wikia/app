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
		$reflConfig->setValue( $this->resultSet, $this->config );
	}
	
	/**
	 * @covers WikiaSearchResultSet::__construct
	 */
	public function testConstructor() {
		$this->prepareMocks();
		
		$metapos = 2;
		
		$set = $this->getMockBuilder( 'WikiaSearchResultSet' )
					->setMethods( array( 'configure' ) )
					->setConstructorArgs( array( $this->searchResult, $this->config, $this->resultSet, $metapos ) )
					->getMock();
		
		$expectedMemberVars = array(
				'searchResultObject'	=>	$this->searchResult,
				'searchConfig'			=>	$this->config,
				'parent'				=>	$this->resultSet,
				'metaposition'			=>	$metapos
				);
		
		foreach ( $expectedMemberVars as $name => $val ) {
			$refl = new ReflectionProperty( 'WikiaSearchResultSet', $name );
			$refl->setAccessible( true );
			$this->assertEquals(
					$val,
					$refl->getValue( $set ),
					"WikiaSearchResultSet->{$name} should be set during __construct"
			);
		}
	
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
	
	/**
	 * @covers WikiaSearchResultSet::configureGroupedSetAsRootNode
	 */
	public function testConfigureGroupedSetAsRootNodeSatisfied() {
		$resultSetMethods = array(
				'setResultGroupings',
				'setResultsFound',
				'getHostGrouping'
				);
		$configMethods = array( 'getGroupResults' );
		$this->prepareMocks( $resultSetMethods, $configMethods );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Result_Select_Grouping' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getMatches' ) )
							->getMock();
		
		$matchesCount = 2000;
		
		$this->config
			->expects	( $this->at( 0 ) )
			->method	( 'getGroupResults' )
			->will		( $this->returnValue ( $mockGrouping ) )
		;
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'setResultGroupings' )
		;
		$this->resultSet
			->expects	( $this->at( 1 ) )
			->method	( 'getHostGrouping' )
			->will		( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
			->expects	( $this->at( 0 ) )
			->method	( 'getMatches' )
			->will		( $this->returnValue( $matchesCount ) )
		;
		$this->resultSet
			->expects	( $this->at( 2 ) )
			->method	( 'setResultsFound' )
			->with		( $matchesCount )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configureGroupedSetAsRootNode' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configureGroupedSetAsRootNode should return true if the constructed result set satisfies its necessary criteria' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configureGroupedSetAsRootNode
	 */
	public function testConfigureGroupedSetAsRootNodeUnsatisfied() {
		$resultSetMethods = array(
				);
		$configMethods = array( 'getGroupResults' );
		$this->prepareMocks( $resultSetMethods );
		
		$this->config
			->expects	( $this->at( 0 ) )
			->method	( 'getGroupResults' )
			->will		( $this->returnValue ( false ) )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configureGroupedSetAsRootNode' );
		$configureRefl->setAccessible( true );
		
		$this->assertFalse(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configureGroupedSetAsRootNode should return true if the constructed result set satisfies its necessary criteria' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configureGroupedSetAsLeafNode
	 */
	public function testConfigureGroupedSetAsLeafNodeUnsatisfied() {
		$this->prepareMocks();
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configureGroupedSetAsLeafNode' );
		$configureRefl->setAccessible( true );
		
		// this works because the parent and metaposition values need to be set to satisfy
		
		$this->assertFalse(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configureGroupedSetAsLeafNode should return false if the constructed result set doesn\'t satisfy its necessary criteria' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configureGroupedSetAsLeafNode
	 */
	public function testConfigureGroupedSetAsLeafNodeSatisfied() {
		$resultSetMethods = array(
				'setHeader',
				'gethostGrouping',
				'setResults',
				'setResultsFound'
				);
		
		$this->prepareMocks( $resultSetMethods );
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getValueGroups' ) )
							->getMock();
		
		$mockValueGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_ValueGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getNumFound', 'getValue', 'getDocuments' ) )
							->getMock();
		/* @todo figure out why wikifactory isn't behaving with staticexpects
		$mockWikiFactory = $this->getMockBuilder( 'WikiFactory' )
							->disableOriginalConstructor()
							->setMethods( array( 'getVarValueByName' ) )
							->getMock();
							*/
		
		$wid = 123;
		$wikiarticles = 12345;
		$cityTitle = "This Wiki";
		
		$mockDocument = $this->getMockBuilder( 'Solarium_Document_ReadOnly' )
							->disableOriginalConstructor()
							->setMethods( array( 'getCityId', 'offsetGet' ) )
							->getMock(); 
		
		$parentRefl = new ReflectionProperty( 'WikiaSearchResultSet', 'parent' );
		$parentRefl->setAccessible( true );
		$parentRefl->setValue( $this->resultSet, $this->resultSet ); // doesn't matter what it is, so long as valuated
		
		$metaposRefl = new ReflectionProperty( 'WikiaSearchResultSet', 'metaposition' );
		$metaposRefl->setAccessible( true );
		$metaposRefl->setValue( $this->resultSet, 0 );
		
		$host = 'foo.wikia.com';
		$cityUrl = "http://{$host}";
		
		$mockDocs = array( $mockDocument );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getHostGrouping' )
			->will		( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
			->expects	( $this->at( 0 ) )
			->method	( 'getValueGroups' )
			->will		( $this->returnValue( array( $mockValueGroup ) ) )
		;
		$mockValueGroup
			->expects	( $this->at( 0 ) )
			->method	( 'getValue' )
			->will		( $this->returnValue( $host ) )
		;
		$mockValueGroup
			->expects	( $this->at( 1 ) )
			->method	( 'getDocuments' )
			->will		( $this->returnValue( $mockDocs ) )
		;
		$this->resultSet
			->expects	( $this->at( 1 ) )
			->method	( 'setResults' )
			->with		( $mockDocs )
			->will		( $this->returnValue( $this->resultSet ) )
		;
		$mockValueGroup
			->expects	( $this->at( 2 ) )
			->method	( 'getNumFound' )
			->will		( $this->returnValue( 1 ) )
		;
		$this->resultSet
			->expects	( $this->at( 2 ) )
			->method	( 'setResultsFound' )
			->with		( 1 )
		;
		$mockDocument
			->expects	( $this->at( 0 ) )
			->method	( 'getCityId' )
			->will		( $this->returnValue( $wid ) )
		;
		$this->resultSet
			->expects	( $this->at( 3 ) )
			->method	( 'setHeader' )
			->with		( 'cityId', $wid )
		;/*
		$mockWikiFactory
			->staticExpects	( $this->at( 0 ) )
			->method		( 'getVarValueByName' )
			->with			( 'wgSitename', $wid )
			->will			( $this->returnValue( $cityTitle ) );
		;*/
		$this->resultSet
			->expects	( $this->at( 4 ) )
			->method	( 'setHeader' )
			//->with		( 'cityTitle', $cityTitle )
		;/*
		$mockWikiFactory
			->staticExpects	( $this->at( 1 ) )
			->method		( 'getVarValueByName' )
			->with			( 'wgServer', $wid )
			->will			( $this->returnValue( $cityUrl ) );
		;*/
		$this->resultSet
			->expects	( $this->at( 5 ) )
			->method	( 'setHeader' )
			//->with		( 'cityUrl', $cityUrl )
		;
		$mockDocument
			->expects	( $this->at( 1 ) )
			->method	( 'offsetGet' )
			->with		( 'wikiarticles' )
			->will		( $this->returnValue( $wikiarticles ) )
		;
		$this->resultSet
			->expects	( $this->at( 6 ) )
			->method	( 'setHeader' )
			->with		( 'cityArticlesNum', $wikiarticles )
		;
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configureGroupedSetAsLeafNode' );
		$configureRefl->setAccessible( true );
		
		//$this->mockClass( 'WikiFactory', $mockWikiFactory );
		$this->mockApp();
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configureGroupedSetAsLeafNode should return true if the constructed result set satisfies its necessary criteria' 
		);
		
		$hostRefl = new ReflectionProperty( 'WikiaSearchResultSet', 'host' );
		$hostRefl->setAccessible( true );
		$this->assertEquals( 
				$host,
				$hostRefl->getValue( $this->resultSet ),
				'WikiaSearchResultSet::configureGroupedSetAsLeafNode should set its host variable'
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::configureUngroupedSet
	 */
	public function testConfigureUngroupedSet() {
		$this->prepareMocks( array( 'prependArticleMatchIfExists', 'setResults', 'setResultsFound' ), array(), array( 'getDocuments', 'getNumFound' ) );
		
		$documents = array( 'foo' ); // doesn't really matter
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'prependArticleMatchIfExists' )
			->will		( $this->returnValue( $this->resultSet ) )
		;
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getDocuments' )
			->will		( $this->returnValue( $documents ) )
		;
		$this->resultSet
			->expects	( $this->at( 1 ) )
			->method	( 'setResults' )
			->with		( $documents )
			->will		( $this->returnValue( $this->resultSet ) )
		;
		$this->searchResult
			->expects	( $this->at( 1 ) )
			->method	( 'getNumFound' )
			->will		( $this->returnValue( 1 ) )
		;
		$this->resultSet
			->expects	( $this->at( 2 ) )
			->method	( 'setResultsFound' )
			->with		( 2 )
		;
		
		// this mocks an article match, which will increment this property
		$resRefl = new ReflectionProperty( 'WikiaSearchResultSet', 'resultsFound' );
		$resRefl->setAccessible( true );
		$resRefl->setValue( $this->resultSet, 1 );
		
		$configureRefl = new ReflectionMethod( 'WikiaSearchResultSet', 'configureUngroupedSet' );
		$configureRefl->setAccessible( true );
		
		$this->assertTrue(
				$configureRefl->invoke( $this->resultSet ),
				'WikiaSearchResultSet::configureUngroupedSet should always return true' 
		);
	}
	
	/**
	 * @covers WikiaSearchResultSet::getHostGrouping
	 */
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
	 */
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
		
	}
}