<?php
/**
 * Class definition for Wikia\Search\Test\QueryServiceTest
 */
namespace Wikia\Search\Test\QueryService;
use ReflectionProperty, ReflectionMethod, Wikia\Search;
/**
 * Responsible for testing DependencyContainer and Factory
 */
class QueryServiceTest extends Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\DependencyContainer::__construct
	 * @covers Wikia\Search\QueryService\DependencyContainer::getService
	 * @covers Wikia\Search\QueryService\DependencyContainer::setService
	 * @covers Wikia\Search\QueryService\DependencyContainer::getConfig
	 * @covers Wikia\Search\QueryService\DependencyContainer::setConfig
	 * @covers Wikia\Search\QueryService\DependencyContainer::getClient
	 * @covers Wikia\Search\QueryService\DependencyContainer::setClient
	 */
	public function testDependencyContainer() {
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$config = new Search\Config();
		$service = new Search\MediaWikiService;
		$factory = new Search\ResultSet\Factory;
		$dc = new Search\QueryService\DependencyContainer( array() );
		$dc->setService( $service )
		   ->setConfig( $config )
		   ->setClient( $mockClient );
		$this->assertEquals(
				$mockClient,
				$dc->getClient()
		);
		$this->assertEquals(
				$config,
				$dc->getConfig()
		);
		$this->assertEquals(
				$service,
				$dc->getService()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Factory::get
	 */
	public function testFactoryGet() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getQueryService' ) )
		                   ->getMock();
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\QueryService\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'validateClient' ) )
		                    ->getMock();
		
		$dc = new Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		
		$mockFactory
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'validateClient' )
		    ->with   ( $dc )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryService' )
		    ->will   ( $this->returnValue( '\\Wikia\\Search\\QueryService\\Select\\Dismax\\OnWiki' ) )
		;
		$this->assertInstanceOf(
				'Wikia\Search\QueryService\Select\Dismax\OnWiki',
				$mockFactory->get( $dc )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Factory::getFromConfig
	 */
	public function testFactoryGetFromConfig() {
		$config = new Search\Config();
		$this->assertInstanceOf(
				'Wikia\Search\QueryService\Select\AbstractSelect',
				(new Search\QueryService\Factory)->getFromConfig( $config )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Factory::validateClient
	 */
	public function testFactoryValidateClient() {
		$dc = new Search\QueryService\DependencyContainer( array() );
		$factory = new Search\QueryService\Factory;
		$reflValidate = new ReflectionMethod( 'Wikia\Search\QueryService\Factory' ,'validateClient' );
		$reflValidate->setAccessible( true );
		$reflValidate->invoke( $factory, $dc );
		$this->assertInstanceOf(
				'\Solarium_Client',
				$dc->getClient()
		);
	}
	
}
