<?php
/**
 * Class definition for Wikia\Search\Test\Controller\SearchApiControllerTest
 */
namespace Wikia\Search\Test\Controller;
use Wikia\Search\Test\BaseTest;
/**
 * Tests SearchApiController functionality
 */
class SearchApiControllerTest extends BaseTest
{
	/**
	 * @covers SearchApiController::getList
	 */
	public function testGetListWithTerms() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery' ] )
		                   ->getMock();
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'setResponseFromConfig', 'getConfigFromRequest' ] )
		                       ->getMock();
		
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'getConfigFromRequest' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'setResponseFromConfig' )
		    ->with   ( $mockConfig )
		;
		$mockController->getList();
	}
	
	/**
	 * @covers SearchApiController::getConfigFromRequest
	 */
	public function testGetConfigFromRequest() {
		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getVal', 'getInt' ] )
		                    ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setQuery', 'setLimit', 'setPage', 'setRank', 'setVideoSearch' ] )
		                   ->getMock();
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest', 'validateNamespacesForConfig' ] )
		                       ->getMock();
		
		$this->mockClass( 'Wikia\Search\Config', $mockConfig );

		$requestIncr = 0;
		$configIncr = 0;
		
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'getRequest' )
		    ->will   ( $this->returnValue( $mockRequest ) )
		;
		$mockRequest
		    ->expects( $this->at( $requestIncr++ ) )
		    ->method ( 'getVal' )
		    ->with   ( 'query', null )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockConfig
		    ->expects( $this->at( $configIncr++ ) )
		    ->method ( 'setQuery' )
		    ->with   ( 'foo' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
		    ->expects( $this->at( $requestIncr++ ) )
		    ->method ( 'getInt' )
		    ->with   ( 'limit', \SearchApiController::ITEMS_PER_BATCH )
		    ->will   ( $this->returnValue( 20 ) )
		;
		$mockConfig
		    ->expects( $this->at( $configIncr++ ) )
		    ->method ( 'setLimit' )
		    ->with   ( 20 )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
		    ->expects( $this->at( $requestIncr++ ) )
		    ->method ( 'getVal' )
		    ->with   ( 'batch', 1 )
		    ->will   ( $this->returnValue( 1 ) )
		;
		$mockConfig
		    ->expects( $this->at( $configIncr++ ) )
		    ->method ( 'setPage' )
		    ->with   ( 1 )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
		    ->expects( $this->at( $requestIncr++ ) )
		    ->method ( 'getVal' )
		    ->with   ( 'rank', 'default' )
		    ->will   ( $this->returnValue( 'default' ) )
		;
		$mockConfig
		    ->expects( $this->at( $configIncr++ ) )
		    ->method ( 'setRank' )
		    ->with   ( 'default' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockRequest
		    ->expects( $this->at( $requestIncr++ ) )
		    ->method ( 'getVal' )
		    ->with   ( 'type', 'articles' )
		    ->will   ( $this->returnValue( 'articles' ) )
		;
		$mockConfig
		    ->expects( $this->at( $configIncr++ ) )
		    ->method ( 'setVideoSearch' )
		    ->with   ( false )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'validateNamespacesForConfig' )
		    //->with   ( $mockConfig )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$get = new \ReflectionMethod( 'SearchApiController', 'getConfigFromRequest' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockConfig,
				$get->invoke( $mockController )
		);
	}
	
	/**
	 * @covers SearchApiController::validateNamespacesForConfig
	 */
	public function testValidateNamespacesForConfigNoNamespaces() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setNamespaces' ] )
		                   ->getMock();
		
		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getArray' ] )
		                    ->getMock();
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest' ] )
		                       ->getMock();
		
		$mockController
		    ->expects( $this->any() )
		    ->method ( 'getRequest' )
		    ->will   ( $this->returnValue( $mockRequest ) )
		;
		$mockRequest
		    ->expects( $this->once() )
		    ->method ( 'getArray' )
		    ->with   ( 'namespaces', [] )
		    ->will   ( $this->returnValue( [] ) )
		;
		$mockConfig
		    ->expects( $this->never() )
		    ->method ( 'setNamespaces' )
		;
		$validate = new \ReflectionMethod( 'SearchApiController', 'validateNamespacesForConfig' );
		$validate->setAccessible( true );
		$this->assertEquals(
				$mockConfig,
				$validate->invoke( $mockController, $mockConfig )
		);
	}
	
	/**
	 * @covers SearchApiController::validateNamespacesForConfig
	 */
	public function testValidateNamespacesForConfigWithNamespaces() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setNamespaces' ] )
		                   ->getMock();
		
		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getArray' ] )
		                    ->getMock();
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest' ] )
		                       ->getMock();
		
		$mockController
		    ->expects( $this->any() )
		    ->method ( 'getRequest' )
		    ->will   ( $this->returnValue( $mockRequest ) )
		;
		$mockRequest
		    ->expects( $this->once() )
		    ->method ( 'getArray' )
		    ->with   ( 'namespaces', [] )
		    ->will   ( $this->returnValue( [ NS_MAIN ] ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setNamespaces' )
		    ->with   ( [ NS_MAIN ] )
		;
		$validate = new \ReflectionMethod( 'SearchApiController', 'validateNamespacesForConfig' );
		$validate->setAccessible( true );
		$this->assertEquals(
				$mockConfig,
				$validate->invoke( $mockController, $mockConfig )
		);
	}
	
	/**
	 * @covers SearchApiController::validateNamespacesForConfig
	 */
	public function testValidateNamespacesForConfigBadNamespaces() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setNamespaces' ] )
		                   ->getMock();
		
		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getArray' ] )
		                    ->getMock();
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest' ] )
		                       ->getMock();
		
		$mockController
		    ->expects( $this->any() )
		    ->method ( 'getRequest' )
		    ->will   ( $this->returnValue( $mockRequest ) )
		;
		$mockRequest
		    ->expects( $this->once() )
		    ->method ( 'getArray' )
		    ->with   ( 'namespaces', [] )
		    ->will   ( $this->returnValue( [ NS_MAIN, 'crap' ] ) )
		;
		
		$validate = new \ReflectionMethod( 'SearchApiController', 'validateNamespacesForConfig' );
		$validate->setAccessible( true );
		try {
			$validate->invoke( $mockController, $mockConfig );
		} catch ( \InvalidParameterApiException $e ) { }
		$this->assertInstanceOf(
				'InvalidParameterApiException',
				$e
		);
	}
	
	/**
	 * @covers SearchApiController::setResponseFromConfig
	 */
	public function testSetResponseFromConfigNoTerms() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'hasTerms' ], [ 'foo' ] );
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest' ] )
		                       ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery' ] )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( false ) )
		;
		
		$set = new \ReflectionMethod( 'SearchApiController', 'setResponseFromConfig' );
		$set->setAccessible( true );
		try {
			$set->invoke( $mockController, $mockConfig );
		} catch ( \InvalidParameterApiException $e ) { }
		
		$this->assertInstanceOf(
				'InvalidParameterApiException',
				$e
		);
	}
	
	/**
	 * @covers SearchApiController::setResponseFromConfig
	 */
	public function testSetResponseFromConfigWithTerms() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'hasTerms' ], [ 'foo' ] );
		
		$mockController = $this->getMockBuilder( 'SearchApiController' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( [ 'getRequest', 'getResponse' ] )
		                       ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery', 'getLimit', 'getResultsFound', 'getNumPages', 'getPage' ] )
		                   ->getMock();
		
		$mockFactory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'searchAsApi' ] )
		                    ->getMock();
		
		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( [ 'setValues', 'setCacheValidity' ] )
		                     ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( [ 'toArray' ] )
		                      ->getMock();
		
		$resultArray = [ [ 'id' => 123, 'title' => 'foo', 'url' => 'http://www.wikia.com/wiki/Foo', 'ns' => 0 ] ];
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'hasTerms' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->with   ( $mockConfig )
		    ->will   ( $this->returnValue( $mockService ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'searchAsApi' )
		    ->will   ( $this->returnValue( [ 'items' => $resultArray, 'next' => 20, 'total' => 100, 'batches' => 5, 'currentBatch' => 1 ] ) )
		;
		$mockController
		    ->expects( $this->once() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockResponse
		    ->expects( $this->once() )
		    ->method ( 'setValues' )
		    ->with   ( [ 'items' => $resultArray, 'next' => 20, 'total' => 100, 'batches' => 5, 'currentBatch' => 1 ] )
		;
		$mockResponse
		    ->expects( $this->once() )
		    ->method ( 'setCacheValidity' )
		    ->with   ( 86400, 86400, [ \WikiaResponse::CACHE_TARGET_BROWSER, \WikiaResponse::CACHE_TARGET_VARNISH ] )
		;
		
		$this->mockClass( 'Wikia\Search\QueryService\Factory', $mockFactory );

		$set = new \ReflectionMethod( 'SearchApiController', 'setResponseFromConfig' );
		$set->setAccessible( true );
		$set->invoke( $mockController, $mockConfig );
		
	}
}