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
		               ->setMethods( array( 'getConfig', 'getResult', 'getService' ) )
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
		$setMockStrings = array( 'Base', 'EmptySet' );
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
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockEmptyResult ) )
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
		    ->method ( 'getResult' )
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
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
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
	 */
	public function testDependencyContainer() {
		$namesToClasses = array(
				'config' => 'Wikia\Search\Config',
				'result' => '\Solarium_Result_Select',
				'service' => 'Wikia\Search\MediaWikiService',
				);
		$namesToMocks = [];
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