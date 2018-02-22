<?php
/**
 * Class definition for Wikia\Search\Test\IndexService\CrossWikiCoreTest
 * @author relwell
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\Test\BaseTest, ReflectionMethod, Wikia\Search\Utilities;
/**
 * Tests functionality of CrossWikiCore query service.
 * @author relwell
 */
class CrossWikiCoreTest extends BaseTest
{
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09122 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::execute
	 */
	public function testExecute() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getWikiBasics', 'getWikiStats', 'getWikiViews', 'getWam', 'getCategories', 'getVisualizationInfo', 'getTopArticles' , 'getLicenseInformation'] )
		                ->getMock();



		$basics = [ 'foo' => 'bar' ];
		$stats = [ 'baz' => 'qux' ];
		$views = [ 'blah' => 'buh' ];
		$wam = [ 'wam' => 'bam' ];
		$cats = [ 'cat' => 'meow' ];
		$viz = [ 'viz' => 'graph' ];
		$articles = [ 'art' => 'vandelay' ];
		$licence  = ['commercial_use_allowed_b'=>true];

		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiBasics' )
		    ->will   ( $this->returnValue( $basics ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiStats' )
		    ->will   ( $this->returnValue( $stats ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiViews' )
		    ->will   ( $this->returnValue( $views ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWam' )
		    ->will   ( $this->returnValue( $wam ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getCategories' )
		    ->will   ( $this->returnValue( $cats ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getVisualizationInfo' )
		    ->will   ( $this->returnValue( $viz ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getTopArticles' )
		    ->will   ( $this->returnValue( $articles ) )
		;

		$service
			->expects( $this->once() )
			->method ( 'getLicenseInformation' )
			->will   ( $this->returnValue( $licence ) )
		;

		$this->assertEquals(
				array_merge( $basics, $stats, $views, $wam, $cats, $viz, $articles, $licence),
				$service->execute()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.12268 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getWikiBasics
	 */
	public function testGetWikiBasics() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();

		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiId', 'getGlobal', 'getLanguageCode', 'getHubForWikiId', 'getHostName', 'getDomainsForWikiId' ] );

		$mockMessage = $this->getMockBuilder( 'Message' )
							->disableOriginalConstructor()
							->setMethods( [ 'text' ] )
							->getMock();

		$mockWiki = (object) [
				'city_created' => '11:11:11 2013-01-01',
				'city_last_timestamp' => '11:11:11 2013-01-01',
				'city_url' => 'http://foo.wikia.com/',
				'city_dbname' => 'foo'
				];

		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( "getWikiId" )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( 'foo wiki' ) )
		;
		$mwService
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$mwService
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getHubForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'Gaming' ) )
		;
		$mwService
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getHostName' )
		    ->will   ( $this->returnValue( 'hostname' ) )
		;
		$mwService
		    ->expects( $this->at( 5 ) )
		    ->method ( 'getDomainsForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( [ 'bar.wikia.com', 'baz.wikia.com', 'foo.wikia.com' ] ) )
		;
		$mockMessage
			->expects( $this->once() )
			->method ( 'text' )
			->will   ( $this->returnValue( '$1 - Foo Wiki - Bar, Baz and More!' ) )
		;
		$expected = [
				'id' => 123, 'sitename_txt' => 'foo wiki', 'lang_s' => 'en', 'hub_s' => 'Gaming',
				'created_dt' => '11:11:11T2013-01-01Z', 'touched_dt' => '11:11:11T2013-01-01Z', 'url' => 'http://foo.wikia.com/', 'dbname_s' => 'foo',
				'hostname_s' => 'hostname', 'hostname_txt' => 'hostname', 'all_domains_mv_wd' => [ 'bar.wikia.com', 'baz.wikia.com', 'foo.wikia.com' ], 'domains_txt' => [ 'bar.wikia.com', 'baz.wikia.com', 'foo.wikia.com' ],
				'wiki_pagetitle_txt' => 'Foo Wiki - Bar, Baz and More!',
				];
		$this->mockClass( 'WikiFactory', $mockWiki, 'getWikiById' );
		$this->mockGlobalFunction( 'wfMessage', $mockMessage );
		$ref = new ReflectionMethod( $service, 'getWikiBasics' );
		$ref->setAccessible( true );
		$this->assertEquals(
				$expected,
				$ref->invoke( $service )
		);
		$this->assertAttributeEquals(
				123,
				'wikiId',
				$service
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08143 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getWikiViews
	 */
	public function testGetWikiViews() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		$wv = $this->getMockBuilder( 'Wikia\Search\IndexService\WikiViews' )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getStubbedWikiResponse' ] )
		           ->getMock();

		$response = [ 'contents' => [ 'wikiviews_weekly' => [ 'set' => 123 ], 'wikiviews_monthly' => [ 'set' => 456 ] ] ];
		$wv
		    ->expects( $this->once() )
		    ->method ( 'getStubbedWikiResponse' )
		    ->will   ( $this->returnValue( $response ) )
		;
		$expected = [ 'views_weekly_i' => 123, 'views_monthly_i' => '456' ];
		$this->mockClass( 'Wikia\Search\IndexService\WikiViews', $wv );
		$get = new ReflectionMethod( $service, 'getWikiViews' );
		$get->setAccessible( true );
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08105 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getWam
	 */
	public function testGetWam() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		$wv = $this->getMockBuilder( 'Wikia\Search\IndexService\Wam' )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getStubbedWikiResponse' ] )
		           ->getMock();

		$response = [ 'contents' => [ 'wam' => [ 'set' => 100 ] ] ];
		$wv
		    ->expects( $this->once() )
		    ->method ( 'getStubbedWikiResponse' )
		    ->will   ( $this->returnValue( $response ) )
		;
		$expected = [ 'wam_i' => 100 ];
		$this->mockClass( 'Wikia\Search\IndexService\Wam', $wv );
		$get = new ReflectionMethod( $service, 'getWam' );
		$get->setAccessible( true );
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08427 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getWikiStats
	 */
	public function testGetWikiStats() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService', 'getWikiId' ] )
		                ->getMock();

		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getApiStatsForWiki' ] );

		$wikiService = $this->getMock( 'WikiService', [ 'getTotalVideos' ] );

		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getApiStatsForWiki' )
		    ->will   ( $this->returnValue( [ 'query' => [ 'statistics' => [ 'articles' => 100, 'images' => 20 ] ] ] ) )
		;
		$wikiService
		    ->expects( $this->once() )
		    ->method ( 'getTotalVideos' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 50 ) )
		;
		$this->mockClass( 'WikiService', $wikiService );

		$get = new ReflectionMethod( $service, 'getWikiStats' );
		$get->setAccessible( true );
		$this->assertEquals(
				[ 'articles_i' => 100, 'images_i' => 20, 'videos_i' => 50 ],
				$get->invoke( $service )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08302 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getVisualizationInfo
	 */
	public function testGetVisualizationInfo() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService', 'getWikiId' ] )
		                ->getMock();

		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getVisualizationInfoForWikiId' ] );
		$desc = 'this is my description';
		$headline = 'this is my headline';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getVisualizationInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( [ 'image' => 'foo.jpg', 'desc' => $desc, 'flags' => [ 'hot' => 0 ], 'headline' => $headline ] ) )
		;
		$get = new ReflectionMethod( $service, 'getVisualizationInfo' );
		$get->setAccessible( true );
		$expected = [ 'image_s' => 'foo.jpg', 'description_txt' => $desc, Utilities::field( 'description' ) => $desc, 'hot_b' => 'false', 'headline_txt' => $headline ];
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.08589 ms
	 * @covers Wikia\Search\IndexService\CrossWikiCore::getVisualizationInfo
	 */
	public function testGetVisualizationInfoNoDesc() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService', 'getWikiId' ] )
		                ->getMock();

		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getVisualizationInfoForWikiId', 'getSimpleMessage', 'getGlobal' ] );
		$desc = 'this is my description';
		$headline = 'this is my headline';
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getVisualizationInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( [ 'image' => 'foo.jpg', 'flags' => [ 'hot' => 0 ], 'headline' => $headline ] ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( 'sitename' ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getSimpleMessage' )
		    ->with   ( 'wikiasearch2-crosswiki-description', [ 'sitename' ] )
		    ->will   ( $this->returnValue( $desc ) )
		;
		$get = new ReflectionMethod( $service, 'getVisualizationInfo' );
		$get->setAccessible( true );
		$expected = [ 'image_s' => 'foo.jpg', 'description_txt' => $desc, Utilities::field( 'description' ) => $desc, 'hot_b' => 'false', 'headline_txt' => $headline ];
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}


	/**
	 * @group Slow
	 * @slowExecutionTime 0.08167 ms
	 * @covers  Wikia\Search\IndexService\CrossWikiCore::getLicenseInformation
	 */
	public function testGetLicensedWikisService(){

		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
			->disableOriginalConstructor()
			->getMock();
		$get = new ReflectionMethod( $service, 'getLicensedWikisService' );
		$get->setAccessible( true );
		$this->assertInstanceOf( 'LicensedWikisService', $get->invoke($service) );
	}



	/**
	 * @group Slow
	 * @slowExecutionTime 0.08324 ms
     * @covers  Wikia\Search\IndexService\CrossWikiCore::getLicenseInformation
	 */
	public function testGetLicenseInformation(){

		$lwService =  $this->getMockBuilder('\LicensedWikisService')
			->disableOriginalConstructor()
			->setMethods(['isCommercialUseAllowedById'])
			->getMock();


		$lwService->expects($this->any())
			->method('isCommercialUseAllowedById')
			->will ( $this->returnValueMap([  [ 123 , true ],
											  [ 321 , false ] ] ) );


		//var_dump($lwService->isCommercialUseAllowedById(123));

		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\CrossWikiCore' )
				->disableOriginalConstructor()
				->setMethods( ['getWikiId','getLicensedWikisService'] )
				->getMock();



		$service->expects($this->at(1))
				->method('getWikiId')
				->will($this->returnValue(123));

		$service->expects($this->at(2))
			->method('getWikiId')
			->will($this->returnValue(321));

		$service->expects($this->any())
			->method('getLicensedWikisService')
			->will($this->returnValue($lwService));


		$get = new ReflectionMethod( $service, 'getLicenseInformation' );
		$get->setAccessible( true );
		$res = $get->invoke( $service);

		$this->assertTrue(is_array($res));
		$this->assertTrue($res['commercial_use_allowed_b']);

		$res = $get->invoke( $service);

		$this->assertTrue(is_array($res));
		$this->assertFalse($res['commercial_use_allowed_b']);

	}

}
