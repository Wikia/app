<?php
/**
 * Class definition for \Wikia\Search\Test\AbstractServiceTest
 * @author relwell
 */
namespace Wikia\Search\Test;
use Wikia\Search\IndexService\AbstractService;
use Wikia\Search\MediaWikiInterface;
use \ReflectionProperty;
use \ReflectionMethod;
require_once( 'WikiaSearchBaseTest.php' );
/**
 * Tests the methods found in \Wikia\Search\IndexService\AbstractService
 * @author relwell
 */
class AbstractServiceTest extends \WikiaSearchBasetest
{
	public function setUp() {
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
		$service->setPageId( 123 );
		$this->assertEquals(
				sprintf( '%s_%s', MediaWikiInterface::getInstance()->getWikiId(), MediaWikiInterface::getInstance()->getCanonicalPageIdFromPageId( 123 ) ),
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
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'execute', 'getCurrentDocumentId' ) )
		                ->getMock();
		
		$interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiInterface' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_234', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 234 ) );
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 234 )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'execute' )
		    ->will   ( $this->returnValue( $executeResponse ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'getJsonDocumentFromResponse' )
		    ->with   ( $executeResponse )
		    ->will   ( $this->returnValue( $jsonResponse ) )
		;
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'interface' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $interface );
		
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
	public function testGetResponseForPageIdsError() {
		$service = $this->service
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'execute', 'getCurrentDocumentId' ) )
		                ->getMock();
		
		$interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiInterface' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		$exception = $this->getMockBuilder( '\WikiaException' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_123', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 123 ) );
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdExists' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->any() )
		    ->method ( 'execute' )
		    ->will   ( $this->throwException( $exception ) )
		;
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'interface' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $interface );
		
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
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'execute', 'getCurrentDocumentId' ) )
		                ->getMock();
		
		$interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiInterface' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'pageIdExists' ) )
		                  ->getMock();
		
		$executeResponse = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => '321_123', 'foo' => array( 'set' => 'bar' ) );
		$service->setPageIds( array( 123 ) );
		$interface
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
		$reflIf = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'interface' );
		$reflIf->setAccessible( true );
		$reflIf->setValue( $service, $interface );
		
		$expectedResponse = array( 'contents' => array( array( 'delete' => array( 'id' => '321_123' ) ) ), 'errors' => array() );
		$this->assertEquals(
				$expectedResponse,
				$service->getResponseForPageIds()
		);
	}
}