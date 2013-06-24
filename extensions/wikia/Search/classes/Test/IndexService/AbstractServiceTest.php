<?php
/**
 * Class definition for \Wikia\Search\Test\IndexService\AbstractServiceTest
 * @author relwell
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\IndexService\AbstractService, Wikia\Search\MediaWikiService, \ReflectionProperty, \ReflectionMethod, Wikia\Search\Test\BaseTest;
/**
 * Tests the methods found in \Wikia\Search\IndexService\AbstractService
 * @author relwell
 */
class AbstractServiceTest extends BaseTest
{
	public function setUp() {
		parent::setUp();
		$this->service = $this->getMockBuilder( '\Wikia\Search\IndexService\AbstractService' );
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::__construct
	 */
	public function testConstruct() {
		$pageIds = array( 1, 2, 3 );
		$service = $this->service
		                ->setConstructorArgs( array( $pageIds ) )
		                ->getMockForAbstractClass();
		$reflPageIds = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'pageIds' );
		$reflPageIds->setAccessible( true );
		$this->assertEquals(
				$pageIds,
				$reflPageIds->getValue( $service )
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::setPageId
	 */
	public function testSetPageId() {
		$service = $this->service->getMockForAbstractClass();
		$reflPageIds = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'currentPageId' );
		$reflPageIds->setAccessible( true );
		$this->assertEquals(
				$service,
				$service->setPageId( 123 )
		);
		$this->assertEquals(
				123,
				$reflPageIds->getValue( $service )
		);
	}
	
    /**
	 * @covers \Wikia\Search\IndexService\AbstractService::setPageIds
	 */
	public function testSetPageIds() {
		$service = $this->service->getMockForAbstractClass();
		$reflPageIds = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'pageIds' );
		$reflPageIds->setAccessible( true );
		$this->assertEquals(
				$service,
				$service->setPageIds( array( 123, 321 ) )
		);
		$this->assertEquals(
				array( 123, 321 ),
				$reflPageIds->getValue( $service )
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::getCurrentDocumentId
	 */
	public function testGetCurrentDocumentId() {
		$service = $this->service->getMockForAbstractClass();
		$mwservice = new MediaWikiService;
		$service->setPageId( 123 );
		$this->assertEquals(
				sprintf( '%s_%s', $mwservice->getWikiId(), $mwservice->getCanonicalPageIdFromPageId( 123 ) ),
				$service->getCurrentDocumentId()
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::getJsonDocumentFromResponse
	 */
	public function testGetJsonDocumentFromResponse() {
		$service = $this->service->getMockForAbstractClass();
		$service->setPageId( 123 );
		$data = array( 'foo' => 'bar', 'baz' => array( 'qux', 'swag' ) );
		$expectedData = array( 'id' => $service->getCurrentDocumentId(), 'foo' => array( 'set' => 'bar' ), 'baz' => array( 'set' => array( 'qux', 'swag' ) ) );
		$this->assertEquals(
				$expectedData,
				$service->getJsonDocumentFromresponse( $data )
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::getResponseForPageIds
	 */
	public function testGetResponseForPageIdsSuccess() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'getResponse', 'getCurrentDocumentId' ) )
		                ->getMockForAbstractClass();
		
		$mwservice = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_234', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 234 ) );
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 234 )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getCurrentDocumentId' )
		    ->will   ( $this->returnValue( 234 ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->returnValue( $executeResponse ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getJsonDocumentFromResponse' )
		    ->with   ( $executeResponse )
		    ->will   ( $this->returnValue( $jsonResponse ) )
		;
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'service' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $mwservice );
		
		$actualResponse = $service->getResponseForPageIds();
		$expectedResponse = array( 'contents' => array( $jsonResponse ), 'errors' => array() );
		$this->assertEquals(
				$expectedResponse,
				$actualResponse
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::getResponseForPageIds
	 */
	public function testGetResponseForPageIdsSkipRepeats() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'getResponse', 'getCurrentDocumentId' ) )
		                ->getMockForAbstractClass();
		
		$mwservice = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		
		$service->setPageIds( array( 456 ) );
		
		$reflProcessedDocs = new ReflectionProperty( 'Wikia\Search\IndexService\AbstractService', 'processedDocIds' );
		$reflProcessedDocs->setAccessible( true );
		$reflProcessedDocs->setValue( $service, array( 456 ) );
		
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 456 )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getCurrentDocumentId' )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$service
		    ->expects( $this->never() )
		    ->method ( 'getResponse' )
		;

		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'service' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $mwservice );
		
		$actualResponse = $service->getResponseForPageIds();
		$expectedResponse = array( 'contents' => array(), 'errors' => array() );
		$this->assertEquals(
				$expectedResponse,
				$actualResponse
		);
	}
	
    /**
	 * @covers \Wikia\Search\IndexService\AbstractService::getResponseForPageIds
	 */
	public function testGetResponseForPageIdsError() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'getResponse', 'getCurrentDocumentId' ) )
		                ->getMockForAbstractClass();
		
		$mwservice = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		$exception = $this->getMockBuilder( '\WikiaException' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_123', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 123 ) );
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getResponse' )
		    ->will   ( $this->throwException( $exception ) )
		;
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'service' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $mwservice );
		
		$expectedResponse = array( 'contents' => array(), 'errors' => array( 123 ) );
		$this->assertEquals(
				$expectedResponse,
				$service->getResponseForPageIds()
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractService::getResponseForPageIds
	 */
	public function testGetResponseForPageIdsNotExists() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'getResponse', 'getCurrentDocumentId' ) )
		                ->getMockForAbstractClass();
		
		$mwservice = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_123', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 123 ) );
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( false ) )
		;
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCurrentDocumentId' )
		    ->will   ( $this->returnValue( '321_123' ) )
		;
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'service' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $mwservice );
		
		$expectedResponse = array( 'contents' => array( array( 'delete' => array( 'id' => '321_123' ) ) ), 'errors' => array() );
		$this->assertEquals(
				$expectedResponse,
				$service->getResponseForPageIds()
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\AbstractService::getService
	 */
	public function testGetService() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( null ) )
		                ->getMockForAbstractClass();
		$this->assertAttributeEmpty(
				'service',
				$service
		);
		$get = new \ReflectionMethod( 'Wikia\Search\IndexService\AbstractService', 'getService' );
		$get->setAccessible( true );
		$this->assertInstanceOf(
				'Wikia\Search\MediaWikiService',
				$get->invoke( $service )
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService',
				'service',
				$service
		);
		
	}
	
	/**
	 * @covers Wikia\Search\IndexService\AbstractService::getResponse
	 */
	public function testGetResponseWorks() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'execute', 'reinitialize' ) )
		                ->getMockForAbstractClass();
		$get = new \ReflectionMethod( $service, 'getResponse' );
		$get->setAccessible( true );
		$response = [ 1, 2, 3, 4, 5 ];
		$service
		    ->expects( $this->once() )
		    ->method ( "execute" )
		    ->will   ( $this->returnValue( $response ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'reinitialize' )
		;
		$this->assertEquals(
				$response,
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\AbstractService::getResponse
	 */
	public function testGetResponseBreaks() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'execute', 'reinitialize' ) )
		                ->getMockForAbstractClass();
		$exception = $this->getMockBuilder( 'Exception' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$get = new \ReflectionMethod( $service, 'getResponse' );
		$get->setAccessible( true );
		$response = [ 1, 2, 3, 4, 5 ];
		$service
		    ->expects( $this->once() )
		    ->method ( "execute" )
		    ->will   ( $this->throwException( $exception ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'reinitialize' )
		;
		try {
			$get->invoke( $service );
		} catch ( \Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e,
				'A failed call to execute should re-throw the exception after reinitializing'
		);
	}
}