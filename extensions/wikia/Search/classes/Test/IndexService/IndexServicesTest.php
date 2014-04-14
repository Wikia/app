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
	
	protected function injectService( $service, $mwservice ) {
		$refl = new ReflectionProperty( '\Wikia\Search\IndexService\AbstractService', 'service' );
		$refl->setAccessible( true );
		$refl->setValue( $service, $mwservice );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0832 ms
	 * @covers Wikia\Search\IndexService\BacklinkCount::execute
	 */
	public function testBacklinkCountExecute() {
		$mwservice = $this->service->setMethods( array( 'getBacklinksCountFromPageId' ) )->getMock();
		$mwservice
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
		
		$this->injectService( $service, $mwservice );
		
		$this->assertEquals(
				array( 'backlinks' => 20 ),
				$service->execute()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08319 ms
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
	public function testMetadataExecuteInternal() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$mwservice = $this->service->setMethods( array( 'getGlobal' ) )->getMock();
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->injectService( $service, $mwservice );
		$this->assertEmpty(
				$service->execute()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08172 ms
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
	public function testMetadataExecuteInternalNoPageId() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$mwservice = $this->service->setMethods( array( 'getGlobal' ) )->getMock();
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->injectService( $service, $mwservice );
		try {
			$service->execute();
		} catch ( \Exception $e ) { }
		
		$this->assertInstanceOf(
				'\Exception',
				$e
		);
	}
	
	/**
	  * @group Slow
	  * @slowExecutionTime 0.08487 ms
	 * @covers Wikia\Search\IndexService\Metadata::execute
	 */
	 public function testMetadataExecuteInternalSuccess() {
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Metadata' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$mwservice = $this->service->setMethods( array( 'getGlobal', 'getApiStatsForPageId' ) )->getMock();
		
		$pageData = array( 'views' => 123, 'revcount' => 234, 'created' => 'yesterday', 'touched' => 'today' );
		$apiResult = array(
				'query' => array( 'pages' => array( $this->pageId => $pageData ) ,
						          'category' => array( 'catname' => 'stuff' ) ) 
				);
		
		$mwservice
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'ExternalSharedDB' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwservice
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getApiStatsForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( $apiResult ) )
		;
		$service->setPageId( $this->pageId );
		$this->injectService( $service, $mwservice );
		$expected = array_merge( $pageData, array( 'hub' => 'stuff' ) );
		$this->assertEquals(
				$expected,
				$service->execute()
		);
	}
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08515 ms
	 * @covers \Wikia\Search\IndexService\Redirects::execute
	 */
	public function testRedirectsService() {
		$mwservice = $this->service->setMethods( array( 'getGlobal', 'getRedirectTitlesForPageId' ) )->getMock();
		$mwservice
		    ->expects( $this->at( 0 ) )
		        ->method ( 'getGlobal' )
		        ->with   ( 'AppStripsHtml' )
		        ->will   ( $this->returnValue( true ) )
		;
		$mwservice
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getRedirectTitlesForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( array( 'foo', 'bar' ) ) )
		;
		$service = $this->getMockBuilder( '\Wikia\Search\IndexService\Redirects' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$this->injectService( $service, $mwservice );
		$service->setPageId( $this->pageId );
		$this->assertEquals(
				array( \Wikia\Search\Utilities::field( 'redirect_titles' ) => array( 'foo', 'bar' ),
					'redirect_titles_mv_em' => array( 'foo', 'bar' ) ),
				$service->execute()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08454 ms
	 * @covers Wikia\Search\IndexService\VideoViews::execute
	 */
	public function testVideoViewsService() {
		$mwService = $this->service->setMethods( array( 'pageIdIsVideoFile', 'getVideoViewsForPageId' ) )->getMock();
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\VideoViews' )
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		$service
		    ->expects( $this->any() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdIsVideoFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getVideoViewsForPageId' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( 1234 ) )
		;
		$service->setPageId( $this->pageId );
		$this->assertEquals(
				[ 'views' => 1234 ],
				$service->execute()
		);
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'pageIdIsVideoFile' )
		    ->with   ( $this->pageId )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEmpty(
				$service->execute()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08742 ms
	 * @covers Wikia\Search\IndexService\WikiPromoData::execute
	 */
	public function testWikiPromoData() {
		$mwService = $this->service->setMethods( [ 'isOnDbCluster', 'getVisualizationInfoForWikiId', 'getWikiId' ] )->getMock();
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\WikiPromoData' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$desc = "This is my description";
		$vizInfo = [ 'desc' => $desc, 'flags' => [ 'new' => 1, 'hot' => 0 ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( "getService" )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'isOnDbCluster' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getVisualizationInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $vizInfo ) )
		;
		$expected = [ 'wiki_description_txt' => $desc, 'wiki_new_b' => 'true', 'wiki_hot_b' => 'false', 'wiki_official_b' => 'false', 'wiki_promoted_b' => 'false' ];
		$this->assertEquals(
				$expected,
				$service->execute()
		);
		$this->assertAttributeEquals(
				$expected,
				'result',
				$service
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.08654 ms
	 * @covers Wikia\Search\IndexService\WikiStats::execute
	 */
	public function testWikiStatsExecute() {
		$mwService = $this->service->setMethods( [ 'isOnDbCluster', 'getApiStatsForWiki' ] )->getMock();
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\WikiStats' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$statsInfo = [ 'query' => [ 'statistics' => [ 'pages' => 123, 'articles' => 456, 'activeusers' => 234, 'images' => 567 ] ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( "getService" )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'isOnDbCluster' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getApiStatsForWiki' )
		    ->will   ( $this->returnValue( $statsInfo ) )
		;
		$expected = [ 'wikipages' => 123, 'wikiarticles' => 456, 'activeusers' => 234, 'wiki_images' => 567 ];
		$this->assertEquals(
				$expected,
				$service->execute()
		);
		$this->assertAttributeEquals(
				$expected,
				'result',
				$service
		);
	}
	
}
