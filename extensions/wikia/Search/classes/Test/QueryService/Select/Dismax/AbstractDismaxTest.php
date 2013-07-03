<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\AbstractDismaxTest
 */
namespace Wikia\Search\Test\QueryService\Select\Dismax;
use Wikia\Search\Test\BaseTest, ReflectionMethod, Wikia\Search\QueryService\DependencyContainer, ReflectionProperty;
/**
 * Tests default functionality shared by all dismax-style query services
 * @author relwell
 */
class AbstractDismaxTest extends BaseTest
{

	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQuery
	 */
	public function testGetQuery() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQuery' ] );
		
		$dc = new \Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( [ $dc ] )
		                   ->setMethods( array( 'getQueryClausesString' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSolrQuery' ], [ 'foo' ] );
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSolrQuery' )
		    ->with   ( 10 )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$method = new ReflectionMethod( $mockSelect, 'getQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'+foo AND +(bar)',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQuery
	 */
	public function testGetQueryMultipleQueryClauses() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQuery' ] );
		
		$dc = new \Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( [ $dc ] )
		                   ->setMethods( array( 'getQueryClausesString' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSolrQuery' ], [ 'foo' ] );
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->will   ( $this->returnValue( 'foo bar' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSolrQuery' )
		    ->with   ( 10 )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$method = new ReflectionMethod( $mockSelect, 'getQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'+(foo bar) AND +(bar)',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getQueryFieldsString 
	 */
	public function testGetQueryFieldsString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryFieldsToBoosts' ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getConfig' ] )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( array( 'foo' => 5, 'bar' => 10 ) ) )
		;
		$get = new ReflectionMethod( $mockSelect, 'getQueryFieldsString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'foo^5 bar^10',
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::registerComponents 
	 */
	public function testRegisterComponents() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'registerDismax', 'registerNonDismaxComponents' ) )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerDismax' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue ( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerNonDismaxComponents' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue ( $mockSelect ) )
		;
		$register = new ReflectionMethod( $mockSelect, 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::registerDismax
	 */
	public function testRegisterDismax() {
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getDismax' ) )
		                  ->getMock();

		$dismaxMethods = array( 
				'setQueryFields', 'setQueryParser', 'setPhraseFields', 'setBoostFunctions',
				'setBoostQuery', 'setMinimumMatch', 'setPhraseSlop', 'setTie' 
				);
		$mockDismax = $this->getMockBuilder( 'Solarium_Query_Select_Component_DisMax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( $dismaxMethods )
		                   ->getMock();
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'isOnDbCluster' ) )
		                      ->getMock();

		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getMinimumMatch', 'getSkipBoostFunctions', 'getQuery' ) )
		                   ->getMock();

		$deps = array( 'config' => $mockConfig, 'service' => $mockService  );
		$dc = new DependencyContainer( $deps );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getQueryFieldsString', 'getBoostQueryString' ) )
		                   ->getMockForAbstractClass();

		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsString' )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getDismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryFields' )
		    ->with   ( 'bar' )
		    ->will   ( $this->returnValue( $mockDismax ) )
	    ;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryParser' )
		    ->with   ( 'edismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'isOnDbCluster' )
		    ->will   ( $this->returnValue( true  ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseFields' )
		    ->with   ( 'bar' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getBoostQueryString' )
		    ->will   ( $this->returnValue( 'bq' ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setBoostQuery' )
		    ->with   ( 'bq' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getMinimumMatch' )
		    ->will   ( $this->returnValue( '80%' ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setMinimumMatch' )
		    ->with   ( '80%' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseSlop' )
		    ->with   ( 3 )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setTie' )
		    ->with   ( 0.01 )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getSkipBoostFunctions' )
		    ->will   ( $this->returnValue( false ) )
		;
		$bfsRefl = new ReflectionProperty( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax', 'boostFunctions' );
		$bfsRefl->setAccessible( true );
		$bfsRefl->setValue( $mockSelect, array( 'foo', 'bar' ) );
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setBoostFunctions' )
		    ->with   ( 'foo bar' )
		;
		$funcRefl = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax', 'registerDismax' );
		$funcRefl->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$funcRefl->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::registerNonDismaxComponents
	 */
	public function testRegisterNonDismaxComponents() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ null ] )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$register = new ReflectionMethod( $mockSelect, 'registerNonDismaxComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\AbstractDismax::getBoostQueryString
	 */
	public function testGetBoostQueryString() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\AbstractDismax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ null ] )
		                   ->getMockForAbstractClass();
		$get = new ReflectionMethod( $mockSelect, 'getBoostQueryString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'',
				$get->invoke( $mockSelect )
		);
	}
}