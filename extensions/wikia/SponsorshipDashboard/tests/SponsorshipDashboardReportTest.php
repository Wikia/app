<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

class SponsorshipDashboardServiceTest extends PHPUnit_Framework_TestCase {

	private $app;

	protected function setUp() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();
		$this->app = WF::build( 'App' );
	}

	protected function tearDown() {
		WF::setInstance( 'App', $this->app );
		WF::reset( 'EasyTemplate' );
	}

	public function testStatsSourceReportChartPath(){

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;

		$oReport->newSource( SponsorshipDashboardReport::SD_SOURCE_STATS );
		$oReport->tmpSource->setCityId( 177 );
		$oReport->tmpSource->setSeries( array( 'A', 'B', 'C', 'D' ) );
		$oReport->acceptSource();
		$oReport->lockSources();
		
		$returnChart	= $oReport->returnChartData();

		$this->assertInternalType( 'array', $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_TICKS, $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS, $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_SERIE, $returnChart );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_TICKS ] );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS ] );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_SERIE ] );

		$returnArray	= $oReport->getReportParams();

		$this->assertInternalType( 'array', $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_ID, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardSource::SD_PARAMS_FREQUENCY, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_NAME, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_DESCRIPTION, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE, $returnArray );

		$returnHtml	= $oReport->getMenuItemsHTML();

		$this->assertInternalType( 'array', $returnHtml );
	}

	public function testEmptyReport(){

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();

		$this->assertEmpty( $return );
	}

	public function testReportWithAllEmptySeries(){

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;

		$return = true;

		$oSource = new SponsorshipDashboardSourceStats();
		$oReport->addSource( $oSource );
		$oReport->acceptSource();

		$oSource = new SponsorshipDashboardSourceOneDot();
		$oReport->addSource( $oSource );
		$oReport->acceptSource();

		$oSource = new SponsorshipDashboardSourceGapiCu();
		$oReport->addSource( $oSource );
		$oReport->acceptSource();

		$oSource = new SponsorshipDashboardSourceGapi();
		$oReport->addSource( $oSource );
		$oReport->acceptSource();

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();

		$this->assertEmpty( $return );
	}
}

