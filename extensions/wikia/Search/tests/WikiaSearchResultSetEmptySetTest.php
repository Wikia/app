<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetEmptySetTest extends WikiaSearchBaseTest {
	
	/**
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