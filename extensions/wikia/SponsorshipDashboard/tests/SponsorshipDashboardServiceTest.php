<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

/**
 * @group Infrastructure
 */
class SponsorshipDashboardServiceTest extends PHPUnit_Framework_TestCase {

	private $app;

	const SDS_SERVICE_TEST_SERVER_ID = 177;
	const SDS_SERVICE_TEST_SERVER_URL = 'http://community.wikia.com';

	protected function setUp() {
		
		global $wgTitle;
		$this->app = WF::build( 'App' );
		$wgTitle = Title::newMainPage();
	}

	protected function tearDown() {

		WF::setInstance( 'App', $this->app );
	}

	/**
	 * @dataProvider useMethod
	 */
	public function testLoadDataWithoutCache( $method ){

		$app = $this->getMock( 'WikiaApp' );
		$app->expects( $this->any() )
		    ->method( 'getGlobal' )
		    ->will( $this->returnCallback( array( $this, 'getGlobalsForLoadData' )));

		WF::setInstance( 'App', $app );

		$SDS = $this->getMock('SponsorshipDashboardService', array( 'getFromCache' ));
		$SDS->expects($this->any())
		     ->method( 'getFromCache' )
		     ->will( $this->returnValue( false ) );

		$return = $SDS->$method();

		$this->assertInternalType( 'array', $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_SERIE, $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_TICKS, $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_FULL_TICKS, $return );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_SERIE ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_TICKS ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_FULL_TICKS ] );
	}

	/**
	 * @dataProvider useMethod
	 */
	public function testLoadDataWithCache( $method ){

		$app = $this->getMock( 'WikiaApp' );
		$app->expects( $this->any() )
		    ->method( 'getGlobal' )
		    ->will( $this->returnCallback( array( $this, 'getGlobalsForLoadData' )));

		WF::setInstance( 'App', $app );

		$SDS = new SponsorshipDashboardService();
		$SDS->$method();

		// double request just to be sure the cache is working;
		$return = $SDS->$method();

		$this->assertInternalType( 'array', $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_SERIE, $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_TICKS, $return );
		$this->assertArrayHasKey( SponsorshipDashboardService::SD_RETURNPARAM_FULL_TICKS, $return );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_SERIE ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_TICKS ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardService::SD_RETURNPARAM_FULL_TICKS ] );
	}

	public function getGlobalsForLoadData( $globalVar ){

		switch ( $globalVar ){
			case 'wgServer':
				return self::SDS_SERVICE_TEST_SERVER_URL;
			break;
			case 'wgCityId': 
				return self::SDS_SERVICE_TEST_SERVER_ID;
			break;
			default: $GLOBALS[$globalVar];
		}
	}

	public function useMethod(){
		return array(
		    array( 'loadInterestsData' ),
		    array( 'loadCompetitorsData' ),
		    array( 'loadKeywordsData'),
		    array( 'loadSourceData' ),
		    array( 'loadActivityData' ),
		    array( 'loadEngagementData'),
		    array( 'loadParticipationData' ),
		    array( 'loadVisitorsData' ),
		    array( 'loadKeywordsData'),
		    array( 'loadTrafficData' ),
		    array( 'loadContentData' )
		);
	}
}