<?php
/**
 * Class definition for \Wikia\Search\Test\IndexServicesTest
 * @author relwell
 */
namespace Wikia\Search\Test;
use Wikia\Search\IndexService;
use Wikia\Search\MediaWikiInterface;
use \ReflectionProperty;
use \ReflectionMethod;
require_once( 'WikiaSearchBaseTest.php' );
/**
 * Tests the methods found in concrete classes within the \Wikia\Search\IndexService namespace
 * @author relwell
 */
class IndexServiceTest extends \WikiaSearchBasetest
{
	public function setUp() {
		parent::setUp();
		$this->interface = $this->getMockBuilder( '\Wikia\Search\MediaWikiInterface' )
		                        ->disableOriginalConstructor();
		$this->pageId = 123;
	}
	
	protected function injectInterface( $service, $interface ) {
		$refl = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'interface' );
		$refl->setAccessible( true );
		$refl->setValue( $service, $interface );
	}
	
	/**
	 * @covers Wikia\Search\IndexService\BacklinkCount::execute
	 */
	public function testBacklinkCountExecute() {
		$interface = $this->interface->setMethods( array( 'getBacklinksCountFromPageId' ) )->getMock();
		$interface
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
		
		$this->injectInterface( $service, $interface );
		
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
		$interface = $this->interface->setMethods( array( 'getGlobal' ) )->getMock();
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->injectInterface( $service, $interface );
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
		$interface = $this->interface->setMethods( array( 'getGlobal' ) )->getMock();
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->injectInterface( $service, $interface );
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
		$interface = $this->interface->setMethods( array( 'getGlobal', 'getApiStatsForPageId' ) )->getMock();
		
		$pageData = array( 'views' => 123, 'revcount' => 234, 'created' => 'yesterday', 'touched' => 'today' );
		$apiResult = array(
				'query' => array( 'pages' => array( $this->pageId => $pageData ) ,
						          'category' => array( 'catname' => 'stuff' ) ) 
				);
		
		$interface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$interface
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getApiStatsForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $apiResult ) )
		;
		$service->setPageId( $this->pageId );
		$this->injectInterface( $service, $interface );
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
    	$interface = $this->interface->setMethods( array( 'getGlobal', 'getRedirectTitlesForPageId' ) )->getMock();
    	$interface
    	    ->expects( $this->at( 0 ) )
    	    ->method ( 'getGlobal' )
    	    ->with   ( 'AppStripsHtml' )
    	    ->will   ( $this->returnValue( true ) )
    	;
    	$interface
    	    ->expects( $this->at( 1 ) )
    	    ->method ( 'getRedirectTitlesForPageId' )
    	    ->with   ( $this->pageId )
    	    ->will   ( $this->returnValue( array( 'foo', 'bar' ) ) )
    	;
    	$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Redirects' )
    	                ->disableOriginalConstructor()
    	                ->setMethods( null )
    	                ->getMock();
    	$this->injectInterface( $service, $interface );
    	$service->setPageId( $this->pageId );
    	$this->assertEquals(
    			array( \WikiaSearch::field( 'redirect_titles' ) => array( 'foo', 'bar' ) ),
    			$service->execute()
		);
    }
}