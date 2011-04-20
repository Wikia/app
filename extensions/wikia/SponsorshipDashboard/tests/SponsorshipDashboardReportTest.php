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
		$oReport->tmpSource->setSeriesName( 'A', 'something' );
		$oReport->tmpSource->setNamespaces( array( 500, 501 ) );
		$oReport->acceptSource();

		$oReport->newSource( SponsorshipDashboardReport::SD_SOURCE_STATS );
		$oReport->tmpSource->setSeries( array( 'A' ) );
		$oReport->acceptSource( array( 177 ) );

		$oReport->setId( 0 );
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

		$returnParams	= $oReport->getTableFromParams();
		
		$this->assertInternalType( 'array', $returnParams );

	}

	public function testFillReportFromSerializedData(){

		$aInput = array();
		$aInput[0] = "mainId=67&mainTitle=Testa'rama&mainDescription=scrap+report'yo&mainFrequency=1&lastDateUnits=30";
		$aInput[1] = "sourceType=Stats&seriesA=on&sourceSerieName-A=1&seriesB=on&sourceSerieName-B=1&seriesC=on&sourceSerieName-C=2&seriesD=on&sourceSerieName-D=3&seriesE=on&sourceSerieName-E=4&seriesF=on&sourceSerieName-F=5&seriesG=on&sourceSerieName-G=6&seriesH=on&sourceSerieName-H=7&seriesI=on&sourceSerieName-I=8&seriesJ=on&sourceSerieName-J=9&seriesK=on&sourceSerieName-K=0&namespaces=&repCityId=&repeatSourceType=1&repCompTopX=2&repCompCityId=177&repCompHubId=9";

		$report = new SponsorshipDashboardReport();
		$report->fillFromSerializedData( serialize( $aInput ) );
		$report->lockSources();
		
		$dataFormatter = SponsorshipDashboardOutputChart::newFromReport( $report );
		$this->assertNotEmpty( $dataFormatter->getHTML() );
		
	}

	public function testEmptyReport(){

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 0 );
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

		$oReport->newSource( 'somethingthatwilltotallynotmatch' );

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

