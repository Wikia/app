<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests grouping set functionality
 */
class GroupingSetTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\ResultSet\GroupingSet::configure
	 */
	public function testConfigure() {
		$dcMethods = array( 'getResult', 'getConfig', 'getService' );
		$dc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		           ->disableOriginalConstructor()
		           ->setMethods( $dcMethods )
		           ->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\GroupingSet' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'prependWikiMatchIfExists', 'setResultGroupings', 'getHostGrouping' ) )
		                     ->getMock();
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( array( 'getMatches', 'getNumberOfGroups' ) )
		                       ->getMock();
		
		foreach ( $dcMethods as $method ) {
			$dc
			    ->expects( $this->once() )
			    ->method ( $method )
			;
		}
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'getHostGrouping' )
		    ->will   ( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
		    ->expects( $this->once() )
		    ->method ( 'getNumberOfGroups' )
		    ->will   ( $this->returnValue( 100 ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'prependWikiMatchIfExists' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setResultGroupings' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$configure = new ReflectionMethod( 'Wikia\Search\ResultSet\GroupingSet', 'configure' );
		$configure->setAccessible( true );
		$configure->invoke( $mockGrouping, $dc );
		
		$found = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'resultsFound' );
		$found->setAccessible( true );
		$this->assertEquals(
				100,
				$found->getValue( $mockGrouping )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\GroupingSet::setResultGroupings
	 */
	public function testSetResultGroupings() {
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( array( 'getValueGroups' ) )
		                       ->getMock();
		
		$mockValueGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_ValueGroup' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( array( 'getValueGroups' ) )
		                       ->getMock();
		
		$mockGroupingSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\GroupingSet' )
		                        ->disableOriginalConstructor()
		                        ->setMethods( array( 'getHostGrouping' ) )
		                        ->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\Grouping' )
		                        ->disableOriginalConstructor()
		                        ->setMethods( array( 'getHeader' ) )
		                        ->getMock();
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\ResultSet\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'get' ) )
		                    ->getMock();
		
		$mockDc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		               ->disableOriginalConstructor()
		               ->getMock();
		
		$mockGroupingSet
		    ->expects( $this->once() )
		    ->method ( 'getHostGrouping' )
		    ->will   ( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
		    ->expects( $this->once() )
		    ->method ( 'getValueGroups' )
		    ->will   ( $this->returnValue( array( $mockValueGroup, $mockValueGroup ) ) )
	    ;
		$mockFactory
		    ->expects( $this->any() )
		    ->method ( 'get' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->any() )
		    ->method ( 'getHeader' )
		    ->with   ( 'url' )
		    ->will   ( $this->returnValue( 'foo.wikia.com' ) )
		;
		$this->proxyClass( 'Wikia\Search\ResultSet\DependencyContainer', $mockDc );
		$this->mockApp();
		$fac = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'factory' );
		$fac->setAccessible( true );
		$fac->setValue( $mockGroupingSet, $mockFactory );
		$set = new ReflectionMethod( 'Wikia\Search\ResultSet\GroupingSet', 'setResultGroupings' );
		$set->setAccessible( true );
		$this->assertEquals(
				$mockGroupingSet,
				$set->invoke( $mockGroupingSet )
		);
		$this->assertAttributeContains(
				$mockGrouping,
				'results',
				$mockGroupingSet
		);
	}
	
	/**
	 * @covers  Wikia\Search\ResultSet\GroupingSet::prependWikiMatchIfExists
	 */
	public function testPrependWikiMatchIfExists() {
		$mockGroupingSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\GroupingSet' )
		                        ->disableOriginalConstructor()
		                        ->setMethods( null )
		                        ->getMock();
		
		$mockMatchGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\MatchGrouping' )
		                          ->disableOriginalConstructor()
		                          ->setMethods( array( 'getHeader' ) )
		                          ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasWikiMatch', 'getStart', 'getWikiMatch' ) );
		
		$confRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'searchConfig' );
		$confRefl->setAccessible( true );
		$confRefl->setValue( $mockGroupingSet, $mockConfig );
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\ResultSet\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'get' ) )
		                    ->getMock();
		
		$mockDc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		               ->disableOriginalConstructor()
		               ->getMock();
		
		$rfRefl = new ReflectionProperty( $mockGroupingSet, 'resultsFound' );
		$rfRefl->setAccessible( true );
		$prevResultsFound = $rfRefl->getValue( $mockGroupingSet ); 
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getStart' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'get' )
		    ->will   ( $this->returnValue( $mockMatchGrouping ) )
		;
		$mockMatchGrouping
		    ->expects( $this->once() )
		    ->method ( 'getHeader' )
		    ->with   ( 'url' )
		    ->will   ( $this->returnValue( 'foo.wikia.co' ) )
		;
		$fac = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'factory' );
		$fac->setAccessible( true );
		$fac->setValue( $mockGroupingSet, $mockFactory );
		$this->proxyClass( 'Wikia\Search\ResultSet\DependencyContainer', $mockDc );
		$this->mockApp();
		$set = new ReflectionMethod( 'Wikia\Search\ResultSet\GroupingSet', 'prependWikiMatchIfExists' );;
		$set->setAccessible( true );
		$this->assertEquals(
				$mockGroupingSet,
				$set->invoke( $mockGroupingSet )
		);
		$this->assertAttributeContains(
				$mockMatchGrouping,
				'results',
				$mockGroupingSet
		);
		$this->assertAttributeEquals(
				$prevResultsFound + 1,
				'resultsFound',
				$mockGroupingSet,
				"We should increment the number of results found by one if we have a match."
		);
	}
	
	/**
	 * @covers  Wikia\Search\ResultSet\GroupingSet::prependWikiMatchIfExists
	 */
	public function testPrependWikiMatchIfExistsWithoutStartAt0() {
		$mockGroupingSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\GroupingSet' )
		                        ->disableOriginalConstructor()
		                        ->setMethods( null )
		                        ->getMock();
		
		$mockMatchGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\MatchGrouping' )
		                          ->disableOriginalConstructor()
		                          ->setMethods( array( 'getHeader' ) )
		                          ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasWikiMatch', 'getStart', 'getWikiMatch' ) );
		
		$confRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'searchConfig' );
		$confRefl->setAccessible( true );
		$confRefl->setValue( $mockGroupingSet, $mockConfig );
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\ResultSet\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'get' ) )
		                    ->getMock();
		
		$mockDc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		               ->disableOriginalConstructor()
		               ->getMock();
		
		$rfRefl = new ReflectionProperty( $mockGroupingSet, 'resultsFound' );
		$rfRefl->setAccessible( true );
		$prevResultsFound = $rfRefl->getValue( $mockGroupingSet ); 
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getStart' )
		    ->will   ( $this->returnValue( 1 ) )
		;
		$mockConfig
		    ->expects( $this->never() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$fac = new ReflectionProperty( 'Wikia\Search\ResultSet\GroupingSet', 'factory' );
		$fac->setAccessible( true );
		$fac->setValue( $mockGroupingSet, $mockFactory );
		$this->proxyClass( 'Wikia\Search\ResultSet\DependencyContainer', $mockDc );
		$this->mockApp();
		$set = new ReflectionMethod( 'Wikia\Search\ResultSet\GroupingSet', 'prependWikiMatchIfExists' );;
		$set->setAccessible( true );
		$this->assertEquals(
				$mockGroupingSet,
				$set->invoke( $mockGroupingSet )
		);
		$this->assertAttributeNotContains(
				$mockMatchGrouping,
				'results',
				$mockGroupingSet
		);
		$this->assertAttributeEquals(
				$prevResultsFound + 1,
				'resultsFound',
				$mockGroupingSet,
				"We should increment the number of results found by one if we have a match."
		);
	}
	
}