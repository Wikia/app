<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetDependenciesTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers Wikia\Search\ResultSet\Factory::get
	 */
	public function testFactoryGet() {
		$factory = $this->getMockBuilder( 'Wikia\Search\ResultSet\Factory' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		
		$mockDc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'getConfig', 'getParent', 'getMetaposition', 'getResult', 'getWikiMatch' ) )
		               ->getMock();
		
		$mockEmptyResult = $this->getMockBuilder( 'Solarium_Result_Select_Empty' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getGroupResults' ) );
		
		$setMockStrings = array( 'Base', 'Grouping', 'GroupingSet', 'EmptySet', 'MatchGrouping' );
		$setMocks = array();
		foreach ( $setMockStrings as $name ) {
			$fullName = 'Wikia\Search\ResultSet\\'.$name;
			$setMocks[$name] = $this->getMockBuilder( $fullName )
			                        ->disableOriginalConstructor()
			                        ->getMock();
			$this->proxyClass( $fullName, $setMocks[$name] );
		}
		$this->mockApp();
		
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( null ) )
		;
		try {
			$factory->get( $mockDc );
		} catch ( Exception $e ) {}
		$this->assertInstanceOf(
				'Exception',
				$e
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockEmptyResult ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertEquals(
				get_class( $setMocks['EmptySet'] ),
				$factory->get( $mockDc )->_mockClassName
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertEquals(
				get_class( $setMocks['EmptySet'] ),
				$factory->get( $mockDc )->_mockClassName
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGroupResults' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertEquals(
				get_class( $setMocks['GroupingSet'] ),
				$factory->get( $mockDc )->_mockClassName
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( $setMocks['GroupingSet'] ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( 2 ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertEquals(
				get_class( $setMocks['Grouping'] ),
				$factory->get( $mockDc )->_mockClassName
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( $setMocks['GroupingSet'] ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				get_class( $setMocks['MatchGrouping'] ),
				$factory->get( $mockDc )->_mockClassName
		);
		$mockDc
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockDc
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getParent' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getMetaposition' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockDc
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockDc
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGroupResults' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				get_class( $setMocks['Base'] ),
				$factory->get( $mockDc )->_mockClassName
		);
	}
	
	//@todo if i wanted full code coverage i would do the dependency container but meh
	
}