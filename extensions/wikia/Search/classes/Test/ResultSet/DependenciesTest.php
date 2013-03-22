<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet\DependenciesTest
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests Factory and DependencyContainer in Wikia\Search\ResultSet
 */
class DependenciesTest extends Wikia\Search\Test\BaseTest {
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
		               ->setMethods( array( 'getConfig', 'getParent', 'getMetaposition', 'getResult', 'getWikiMatch', 'getService', 'setWikiMatch' ) )
		               ->getMock();
		
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'getWikiMatchByHost' ) );
		
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
			                        ->setMethods( array( 'getResultsNum', 'getId' ) )
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
		} catch ( \Exception $e ) {}
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
		$setMocks['Grouping']
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsNum' )
		    ->will   ( $this->returnValue( 100 ) ) 
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
		$setMocks['Grouping']
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsNum' )
		    ->will   ( $this->returnValue( 0 ) ) 
		;
		$setMocks['Grouping']
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 'foo.wikia.com' ) ) 
		;
		$mockDc
		    ->expects( $this->at( 5 ) )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockService ) )
		;
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getWikiMatchByHost' )
		    ->with   ( 'foo' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockDc
		    ->expects( $this->at( 6 ) )
		    ->method ( 'setWikiMatch' )
		    ->with   ( $mockMatch )
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
	
	/**
	 * @covers Wikia\Search\ResultSet\DependencyContainer::__construct
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getConfig
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setConfig
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getResult
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setResult
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getService
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setService
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getMetaposition
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setMetaposition
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getParent
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setParent
	 * @covers Wikia\Search\ResultSet\DependencyContainer::getWikiMatch
	 * @covers Wikia\Search\ResultSet\DependencyContainer::setWikiMatch
	 */
	public function testDependencyContainer() {
		$namesToClasses = array(
				'config' => 'Wikia\Search\Config',
				'result' => '\Solarium_Result_Select',
				'service' => 'Wikia\Search\MediaWikiService',
				'parent' => 'Wikia\Search\ResultSet\GroupingSet',
				'wikiMatch' => 'Wikia\Search\Match\Wiki'
				);
		$namesToMocks = array( 'metaposition' => 1 );
		foreach ( $namesToClasses as $name => $class ) {
			$namesToMocks[$name] = $this->getMockBuilder( $class )->disableOriginalConstructor()->getMock();
		}
		$dc = new \Wikia\Search\ResultSet\DependencyContainer( $namesToMocks );
		foreach ( $namesToMocks as $name => $mock ) {
			$get = 'get'.ucfirst($name);
			$this->assertEquals(
					$mock,
					$dc->{$get}()
			);
		}
		$dc = new \Wikia\Search\ResultSet\DependencyContainer();
		foreach ( $namesToMocks as $name => $mock ) {
			$get = 'get'.ucfirst($name);
			$set = 'set'.ucfirst($name);
			if ( $name !== 'service' ) {
				$this->assertNull(
						$dc->{$get}()
				);
			}
			$this->assertEquals(
					$dc,
					$dc->{$set}( $mock )
			);
			$this->assertEquals(
					$mock,
					$dc->{$get}()
			);
		}
	}
	
}