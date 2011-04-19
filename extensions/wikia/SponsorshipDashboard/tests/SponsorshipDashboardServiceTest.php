<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

/**
 * @group Infrastructure
 */
class SponsorshipDashboardReportTest extends PHPUnit_Framework_TestCase {

	private $app;

	const SDS_SERVICE_TEST_SERVER_ID = 673;
	const SDS_SERVICE_TEST_SERVER_URL = 'http://simpsons.wikia.com';

	protected function setUp() {

		global $wgTitle;
		$this->app = WF::build( 'App' );
		$wgTitle = Title::newMainPage();
	}

	protected function tearDown() {

		WF::setInstance( 'App', $this->app );
		WF::reset( 'gapi' );
	}

	/**
	 * @dataProvider useMethod
	 */
	public function testLoadDataWithoutCache( $method ){

		$app = $this->getMock( 'WikiaApp' );
		$app	->expects( $this->any() )
			->method( 'getGlobal' )
			->will( $this->returnCallback( array( $this, 'getGlobalsForLoadData' )));

		WF::setInstance( 'App', $app );

		$SDS = $this->getMock('SponsorshipDashboardService', array( 'getFromCache' ));
		$SDS	->expects($this->any())
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

	public function testGADailyDataEmpty(){

		$app = $this->getMock( 'WikiaApp' );

		WF::setInstance( 'App', $app );

		$SDS = $this->getMock( 'SponsorshipDashboardService', array( 'getFromCache' ) );

		$gapi = $this->getMock( 'gapi' , array(), array( 'email', 'pass', 'token' ));
		$gapi	->expects( $this->any() )
			->method( 'requestReportData' )
			->will( $this->returnValue( false ) );

		$gapi	->expects( $this->any() )
			->method( 'getResults' )
			->will( $this->returnValue( false ) );

		WF::setInstance( 'gapi', $gapi );

		$SDS->expects( $this->any() )
			->method( 'getFromCache' )
			->will( $this->returnValue( false ) );

		$return = $SDS->getDailyCityPageviewsFromGA( self::SDS_SERVICE_TEST_SERVER_URL, self::SDS_SERVICE_TEST_SERVER_ID, 'c', 0, true );
		$this->assertEmpty( $return );

	}

	public function testGADailyDataPositiveAfterRetries(){

		$app = $this->getMock( 'WikiaApp' );

		WF::setInstance( 'App', $app );

		$SDS = $this->getMock( 'SponsorshipDashboardService', array( 'getFromCache' ) );

		$fakeGapiResponse = array();
		$fakeGapiObject = new fakeGapiResult;
		$fakeGapiResponse[] = $fakeGapiObject;
		$fakeGapiResponse[] = $fakeGapiObject;
		$fakeGapiResponse[] = $fakeGapiObject;
		$fakeGapiResponse[] = $fakeGapiObject;

		$gapi = $this->getMock( 'gapi' , array(), array( 'email', 'pass', 'token' ));
		$gapi	->expects( $this->any() )
			->method( 'requestReportData' )
			->will( $this->returnValue( false ) );

		$gapi	->expects( $this->any() )
			->method( 'getResults' )
			->will( $this->onConsecutiveCalls(
				$this->throwException( new Exception('falseTestException') ),
				$this->throwException( new Exception('falseTestException') ),
				$this->throwException( new Exception('falseTestException') ),
				$fakeGapiResponse ) );

		WF::setInstance( 'gapi', $gapi );

		$SDS->expects( $this->any() )
			->method( 'getFromCache' )
			->will( $this->returnValue( false ) );

		$return = $SDS->getDailyCityPageviewsFromGA( self::SDS_SERVICE_TEST_SERVER_URL, self::SDS_SERVICE_TEST_SERVER_ID, 'c', 0, true );
		$this->assertNotEmpty( $return );

	}

	public function testGADailyDataException(){

		$app = $this->getMock( 'WikiaApp' );

		WF::setInstance( 'App', $app );

		$SDS = $this->getMock( 'SponsorshipDashboardService', array( 'getFromCache' ) );

		$gapi = $this->getMock( 'gapi' , array(), array( 'email', 'pass', 'token' ));
		$gapi	->expects( $this->any() )
			->method( 'requestReportData' )
			->will( $this->returnValue( false ) );

		$gapi	->expects( $this->any() )
			->method( 'getResults' )
			->will( $this->throwException( new Exception('falseTestException') ) );

		WF::setInstance( 'gapi', $gapi );

		$SDS->expects( $this->any() )
			->method( 'getFromCache' )
			->will( $this->returnValue( false ) );

		$return = $SDS->getDailyCityPageviewsFromGA( self::SDS_SERVICE_TEST_SERVER_URL, self::SDS_SERVICE_TEST_SERVER_ID, 'c', 0, true );
		$this->assertEmpty( $return );

	}
}

class fakeGapiResult {

	public function getMonth(){
		return rand( 1, 12 );
	}
	public function getYear(){
		return rand( 1999, date('Y') );
	}
	public function getDay(){
		return rand( 1, 29 );
	}
	public function getPageviews(){
		return rand( 0, 999999 );
	}

}
