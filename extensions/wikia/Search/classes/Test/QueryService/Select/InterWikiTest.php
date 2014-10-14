<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\InterWikiTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia, ReflectionMethod, ReflectionProperty;
/**
 * Tests interwiki search functionality
 */
class InterWikiTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::extractMatch
	 */
	public function testExtractMatch() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getService', 'extractWikiMatch' ] )
		                   ->getMock();

		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'extractWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$method = new ReflectionMethod( $mockSelect, 'extractMatch' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockMatch,
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::registerComponents
	 *
	public function testRegisterComponents() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'registerQueryParams', 'registerFilterQueries', 'registerGrouping', 'configureQueryFields' ) )
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'configureQueryFields' )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerQueryParams' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerFilterQueries' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerGrouping' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	} */
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::registerGrouping
	 */
	public function testRegisterGrouping() {
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getGrouping' ) )
		                  ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getStart' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Query_Select_Component_Grouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'setLimit', 'setOffset', 'setFields', 'setNumberOfGroups' ) )
		                     ->getMock();
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getGrouping' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setLimit' )
		    ->with   ( Wikia\Search\QueryService\Select\InterWiki::GROUP_RESULTS_GROUPING_ROW_LIMIT )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setOffset' )
		    ->with   ( 0 )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setNumberOfGroups' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setFields' )
		    ->with   ( array( Wikia\Search\QueryService\Select\InterWiki::GROUP_RESULTS_GROUPING_FIELD ) )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'registerGrouping' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$method->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::registerFilterQueryForMatch
	 */
	public function testRegisterFilterQueryForMatch() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasWikiMatch', 'getWikiMatch', 'setFilterQuery' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getId' ) )
		                  ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setFilterQuery' )
		    ->with   ( '-(wid:123)', 'wikiptt' )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWIki', 'registerFilterQueryForMatch' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::prepareRequest
	 */
	public function testPrepareRequest() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
                           ->disableOriginalConstructor()
                           ->setMethods( array( 'getPage', 'setStart', 'getLength', 'setLength', 'setIsInterWiki' ) )
                           ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->any() )
		    ->method ( 'getPage' )
		    ->will   ( $this->returnValue( 2 ) )
		;
		$mockConfig
		    ->expects( $this->any() )
		    ->method ( 'getLength' )
		    ->will   ( $this->returnValue( 10 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setStart' )
		    ->with   ( 10 )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setStart' )
		    ->with   ( 10 )
		;
		$reflPrep = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'prepareRequest' );
		$reflPrep->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$reflPrep->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::configureQueryFields
	 */
	public function testConfigureQueryFields() {
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'setQueryField' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setQueryField' )
		    ->with   ( 'wikititle', 200 )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setQueryField' )
		    ->with   ( 'wiki_description_txt', 150 )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'configureQueryFields' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::getFilterQueryString
	 */
	public function testGetFilterQueryString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getHub' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) ); 
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getHub' )
		    ->will   ( $this->returnValue( 'Entertainment' ) )
		;
		
		$queries = array(
				Wikia\Search\Utilities::valueForField( 'iscontent', 'true' ),
				'-wikiarticles:[0 TO 50]',
				Wikia\Search\Utilities::valueForField( 'hub', 'Entertainment' )
				);
		
		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'getFilterQueryString' );
		$reflspell->setAccessible( true );
		$this->assertEquals(
				implode( ' AND ', $queries ),
				$reflspell->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getHub' ) );
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getGlobalWithDefault', 'getLanguageCode', 'getWikiId' ) )
		                      ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'service' => $mockService ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getHub' )
		    ->will   ( $this->returnValue( 'Entertainment' ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'CrossWikiaSearchExcludedWikis' )
		    ->will   ( $this->returnValue( array( 123, 321 ) ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'getQueryClausesString' );
		$method->setAccessible( true );
		$this->assertEquals(
				'(-(wid:123) AND -(wid:321) AND -(wid:456) AND (lang:en) AND (iscontent:true) AND (hub:Entertainment))',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\InterWiki::getQueryFieldsString 
	 */
	public function testGetQueryFieldsString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryFieldsToBoosts' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\InterWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( array( 'foo' => 5, 'bar' => 10 ) ) )
		;
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\InterWiki', 'getQueryFieldsString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'foo^5 bar^10',
				$get->invoke( $mockSelect )
		);
	}
}