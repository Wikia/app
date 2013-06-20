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
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getInterWiki' ) );
		$pcf = $this->getMock( 'Wikia\Search\ProfiledClassFactory', [ 'get' ] );
		$setMockStrings = array( 'Base', 'Grouping', 'GroupingSet', 'EmptySet', 'MatchGrouping' );
		$setMocks = array();
		foreach ( $setMockStrings as $name ) {
			$fullName = 'Wikia\Search\ResultSet\\'.$name;
			$setMocks[$name] = $this->getMockBuilder( $fullName )
			                        ->disableOriginalConstructor()
			                        ->getMock();
			$this->mockClass( $fullName, $setMocks[$name] );
		}
		$this->mockClass( 'Wikia\Search\ProfiledClassFactory', $pcf );

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
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\EmptySet', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['EmptySet'] ) )
		;
		$this->assertEquals(
				$setMocks['EmptySet'],
				$factory->get( $mockDc )
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
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\EmptySet', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['EmptySet'] ) )
		;
		$this->assertEquals(
				$setMocks['EmptySet'],
				$factory->get( $mockDc )
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
		    ->method ( 'getInterWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\GroupingSet', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['GroupingSet'] ) )
		;
		$this->assertEquals(
				$setMocks['GroupingSet'],
				$factory->get( $mockDc )
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
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\Grouping', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['Grouping'] ) )
		;
		$this->assertEquals(
				$setMocks['Grouping'],
				$factory->get( $mockDc )
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
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\MatchGrouping', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['MatchGrouping'] ) )
		;
		$this->assertEquals(
				$setMocks['MatchGrouping'],
				$factory->get( $mockDc )
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
		$pcf
		    ->expects( $this->at( 0 ) )
		    ->method ( 'get' )
		    ->with   ( 'Wikia\Search\ResultSet\Base', [ $mockDc ] )
		    ->will   ( $this->returnValue( $setMocks['Base'] ) )
		;
		$this->assertEquals(
				$setMocks['Base'],
				$factory->get( $mockDc )
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