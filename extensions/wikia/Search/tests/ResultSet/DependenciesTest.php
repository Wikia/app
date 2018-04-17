<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet\DependenciesTest
 */
namespace Wikia\Search\Test\ResultSet;

use Wikia;

/**
 * Tests Factory and DependencyContainer in Wikia\Search\ResultSet
 */
class DependenciesTest extends Wikia\Search\Test\BaseTest {
	/**
	 * @group Slow
	 * @slowExecutionTime 0.11284 ms
	 * @covers Wikia\Search\ResultSet\Factory::get
	 */
	public function testFactoryGet() {
		$factory = new Wikia\Search\ResultSet\Factory();
		
		$mockEmptyResult = $this->createMock( \Solarium_Result_Select_Empty::class );
		$mockResult = $this->createMock( \Solarium_Result_Select::class );

		$mockResult->expects( $this->any() )
			->method( 'getDocuments' )
			->willReturn( [] );
		
		$config = new Wikia\Search\Config();

		$dependencyContainer = new Wikia\Search\ResultSet\DependencyContainer();
		$dependencyContainer->setConfig( $config );

		$this->assertInstanceOf(
			Wikia\Search\ResultSet\EmptySet::class,
			$factory->get( $dependencyContainer )
		);

		$dependencyContainer->setResult( $mockEmptyResult );

		$this->assertInstanceOf(
				Wikia\Search\ResultSet\EmptySet::class,
				$factory->get( $dependencyContainer )
		);

		$dependencyContainer->setResult( $mockResult );
		$config->setInterWiki( true );

		$this->assertInstanceOf(
				Wikia\Search\ResultSet\Base::class,
				$factory->get( $dependencyContainer )
		);

		$config->setCombinedMediaSearch( true );

		$this->assertInstanceOf(
			Wikia\Search\ResultSet\CombinedMediaResultSet::class,
			$factory->get( $dependencyContainer )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.11218 ms
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
