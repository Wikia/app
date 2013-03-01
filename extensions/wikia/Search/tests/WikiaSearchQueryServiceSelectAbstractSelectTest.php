<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchQueryServiceSelectAbstractSelectTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::__construct
	 */
	public function test__construct() {
		$config = new Wikia\Search\Config();
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $config, 'client' => $mockClient ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->getMockForAbstractClass();
		
		$this->assertAttributeInstanceOf(
				'Wikia\Search\Config',
				'config',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'\Solarium_Client',
				'client',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\ResultSet\Factory',
				'resultSetFactory',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiInterface',
				'interface',
				$mockSelect
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::search
	 */
	public function testSearch() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getResults' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getMatch', 'prepareRequest', 'prepareResponse', 'sendSearchRequestToClient' ) )
		                   ->getMockForAbstractClass();
		
		$mockResponse = $this->getMockBuilder( 'Solarium_Result_Select' )
		                     ->disableOriginalConstructor()
		                     ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMatch' )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'prepareRequest' )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->at( 2 ) )
		    ->method ( 'sendSearchRequestToClient' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockSelect
		    ->expects( $this->at( 3 ) )
		    ->method ( 'prepareResponse' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getResults' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$this->assertEquals(
				$mockResultSet,
				$mockSelect->search()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getMatch
	 */
	public function testGetMatch() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'hasMatch', 'getMatch' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'extractMatch' ) )
		                   ->getMockForAbstractClass();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->getMatch()
		);
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'extractMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->getMatch()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::extractMatch
	 */
	public function testExtractMatch() {
		// using the assurance above to avoid using a reflection method
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'hasMatch', 'getMatch' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertNull(
				$mockSelect->getMatch()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getSelectQuery
	 */
	public function testGetSelectQuery() {
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'createSelect' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'client' => $mockClient ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'registerComponents', 'getFormulatedQuery' ) )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'setDocumentClass', 'setQuery' ) )
		                  ->getMock();
		$mockClient
		    ->expects( $this->once() )
		    ->method ( 'createSelect' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setDocumentClass' )
		    ->with   ( '\Wikia\Search\Result' )
		;
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'registerComponents' )
		    ->with   ( $mockQuery )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFormulatedQuery' )
		    ->will   ( $this->returnValue( 'foo:bar' ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( 'foo:bar' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$getSelect = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getSelectQuery' );
		$getSelect->setAccessible( true );
		$this->assertEquals(
				$mockQuery,
				$getSelect->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getBoostQueryString 
	 */
	public function testGetBoostQueryString() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getBoostQueryString' );
		$get->setAccessible( true );
		$this->assertEmpty(
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::testRegisterComponents 
	 */
	public function testRegisterComponents() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
}