<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

/**
 * @group Infrastructure
 */
class SponsorshipDashboardServiceTest extends PHPUnit_Framework_TestCase {

	private $app;

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
	public function testLoadData( $method ){

		$app = $this->getMock( 'WikiaApp' );
		$app->expects( $this->any() )
		    ->method( 'getGlobal' )
		    ->will( $this->returnCallback( array( $this, 'getGlobalsForLoadData' )));

		WF::setInstance( 'App', $app );

		$SDS = new SponsorshipDashboardService();
		$return = $SDS->$method();

		$this->assertInternalType( 'array', $return );
		$this->assertArrayHasKey( 'serie', $return );
		$this->assertArrayHasKey( 'ticks', $return );
		$this->assertArrayHasKey( 'fullTicks', $return );
		$this->assertNotEmpty( $return['serie'] );
		$this->assertNotEmpty( $return['ticks'] );
		$this->assertNotEmpty( $return['fullTicks'] );

	}

	public function getGlobalsForLoadData( $globalVar ){

		switch ( $globalVar ){
			case 'wgServer':
				return 'http://community.wikia.com'; 
			break;
			case 'wgCityId': 
				return 177;
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