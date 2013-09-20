<?php
/**
 * Class definition for \Wikia\Search\Test\IndexService\AbstractWikiServiceTest
 * @author relwell
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\IndexService\AbstractWikiService, Wikia\Search\MediaWikiService, \ReflectionProperty, \ReflectionMethod, Wikia\Search\Test\BaseTest;
/**
 * Tests the methods found in \Wikia\Search\IndexService\AbstractWikiService
 * @author relwell
 */
class AbstractWikiServiceTest extends BaseTest
{
	public function setUp() {
		parent::setUp();
		$this->service = $this->getMockBuilder( '\Wikia\Search\IndexService\AbstractWikiService' );
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractWikiService::getStubbedWikiResponse 
	 */
	public function testGetStubbedWikiResponseHatesPageIds() {
		$service = $this->service->getMockForAbstractClass();
		$service->setPageId( 123 );
		
		try {
			$service->getStubbedWikiResponse();
		} catch ( \Exception $e ) {}
		
		$this->assertInstanceOf(
				'\Exception',
				$e
		);
	}
	
    /**
	 * @covers \Wikia\Search\IndexService\AbstractWikiService::getStubbedWikiResponse 
	 */
	public function testGetStubbedWikiResponseSuccess() {
		$service = $this->service
		                ->setMethods( array( 'getJsonDocumentFromResponse', 'execute' ) )
		                ->getMockForAbstractClass();
		
		$execute = array( 'foo' => 'bar' );
		$jsonResponse = array( 'id' => 'whatev', 'foo' => array( 'set' => 'bar' ) );
        $service
            ->expects( $this->at( 0 ) )
            ->method ( 'execute' )
            ->will   ( $this->returnValue( $execute ) )
        ;
        $service
            ->expects( $this->at( 1 ) )
            ->method ( 'getJsonDocumentFromResponse' )
            ->with   ( $execute )
            ->will   ( $this->returnValue( $jsonResponse ) )
        ;
        $this->assertEquals(
        		array( 'contents' => array( 'foo' => array( 'set' => 'bar' ) ), 'wid' => (new MediaWikiService)->getWikiId() ),
        		$service->getStubbedWikiResponse()
		);
	}
	
	/**
	 * @covers \Wikia\Search\IndexService\AbstractWikiService::getCurrentDocumentId 
	 */
	public function testGetCurrentDocumentId() {
		$service = new MediaWikiService;
		$this->assertEquals(
				sprintf( '%s_%s', $service->getWikiId(), \Wikia\Search\IndexService\AbstractWikiService::PAGEID_PLACEHOLDER ),
				$this->service->getMockForAbstractClass()->getCurrentDocumentId()
		);
		$this->assertEquals(
				sprintf( '%s_%s', $service->getWikiId(), 123 ),
				$this->service->getMockForAbstractClass()->setPageId( 123 )->getCurrentDocumentId()
		);
	}
}