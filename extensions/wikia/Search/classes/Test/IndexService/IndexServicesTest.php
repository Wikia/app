<?php
/**
 * Class definition for \Wikia\Search\Test\IndexService\IndexServicesTest
 * @author relwell
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\IndexService, Wikia\Search\MediaWikiService, \ReflectionProperty, \ReflectionMethod, Wikia\Search\Test\BaseTest;
/**
 * Tests the methods found in concrete classes within the \Wikia\Search\IndexService namespace
 * @author relwell
 */
class IndexServicesTest extends BaseTest
{
	public function setUp() {
		parent::setUp();
		$this->service = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                        ->disableOriginalConstructor();
		$this->pageId = 123;
	}
	
	protected function injectInterface( $service, $service ) {
		$refl = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'interface' );
		$refl->setAccessible( true );
		$refl->setValue( $service, $service );
	}
	
	/**
	 * @covers Wikia\Search\IndexService\BacklinkCount::execute
	 */
	public function testBacklinkCountExecute() {
		$service = $this->service->setMethods( array( 'getBacklinksCountFromPageId' ) )->getMock();
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getBacklinksCountFromPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( 20 ) )
		;
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\BacklinkCount' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		
		$service->setPageId( $this->pageId );
		
		$this->injectInterface( $service, $service );
		
		$this->assertEquals(
				array( 'backlinks' => 20 ),
				$service->execute()
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
	public function testMetadataExecuteInternal() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$service = $this->service->setMethods( array( 'getGlobal' ) )->getMock();
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->injectInterface( $service, $service );
		$this->assertEmpty(
				$service->execute()
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
    public function testMetadataExecuteInternalNoPageId() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$service = $this->service->setMethods( array( 'getGlobal' ) )->getMock();
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->injectInterface( $service, $service );
		try {
			$service->execute();
		} catch ( \Exception $e ) { }
		
		$this->assertInstanceOf(
				'\Exception',
				$e
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
    public function testMetadataExecuteInternalSuccess() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$service = $this->service->setMethods( array( 'getGlobal', 'getApiStatsForPageId' ) )->getMock();
		
		$pageData = array( 'views' => 123, 'revcount' => 234, 'created' => 'yesterday', 'touched' => 'today' );
		$apiResult = array(
				'query' => array( 'pages' => array( $this->pageId => $pageData ) ,
						          'category' => array( 'catname' => 'stuff' ) ) 
				);
		
		$service
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getApiStatsForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $apiResult ) )
		;
		$service->setPageId( $this->pageId );
		$this->injectInterface( $service, $service );
		$expected = array_merge( $pageData, array( 'hub' => 'stuff' ) );
		$this->assertEquals(
				$expected,
				$service->execute()
		);
    }
    
    /**
     * @covers \Wikia\Search\IndexService\Redirects::execute
     */
    public function testRedirectsService() {
    	$service = $this->service->setMethods( array( 'getGlobal', 'getRedirectTitlesForPageId' ) )->getMock();
    	$service
    	    ->expects( $this->at( 0 ) )
    	    ->method ( 'getGlobal' )
    	    ->with   ( 'AppStripsHtml' )
    	    ->will   ( $this->returnValue( true ) )
    	;
    	$service
    	    ->expects( $this->at( 1 ) )
    	    ->method ( 'getRedirectTitlesForPageId' )
    	    ->with   ( $this->pageId )
    	    ->will   ( $this->returnValue( array( 'foo', 'bar' ) ) )
    	;
    	$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Redirects' )
    	                ->disableOriginalConstructor()
    	                ->setMethods( null )
    	                ->getMock();
    	$this->injectInterface( $service, $service );
    	$service->setPageId( $this->pageId );
    	$this->assertEquals(
    			array( \Wikia\Search\Utilities::field( 'redirect_titles' ) => array( 'foo', 'bar' ) ),
    			$service->execute()
		);
    }
}