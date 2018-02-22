<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet\EmptySetTest
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionProperty, ReflectionMethod;
/** 
 * Tests empty result functionality 
 */
class WikiaSearchResultSetEmptySetTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09951 ms
	 * @covers Wikia\Search\ResultSet\EmptySet::configure
	 */
	public function testConfigure() {
		$config = new Wikia\Search\Config();
		$dc = new Wikia\Search\ResultSet\DependencyContainer( array( 'config' => $config ) );
		$mockSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\EmptySet' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		
		$this->assertAttributeEquals(
				null,
				'searchConfig',
				$mockSet
		);
		$configure = new ReflectionMethod( 'Wikia\Search\ResultSet\EmptySet', 'configure' );
		$configure->setAccessible( true );
		$configure->invoke( $mockSet, $dc );
		$this->assertAttributeEquals(
				$config,
				'searchConfig',
				$mockSet
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09859 ms
	 * @covers Wikia\Search\ResultSet\EmptySet::getResultsStart
	 */
	public function testGetResultsStart() {
		$mockSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\EmptySet' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		
		$this->assertEquals(
				0,
				$mockSet->getResultsStart()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09842 ms
	 * @covers Wikia\Search\ResultSet\EmptySet::getQueryTime
	 */
	public function testGetQueryTime() {
		$mockSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\EmptySet' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		
		$this->assertEquals(
				0,
				$mockSet->getQueryTime()
		);
	}
}
