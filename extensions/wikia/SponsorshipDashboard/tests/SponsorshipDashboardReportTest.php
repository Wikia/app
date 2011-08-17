<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

/**
 * @group Infrastructure
 */
class SponsorshipDashboardReportTest extends WikiaBaseTest {

	protected function setUp() {
		parent::setUp();
		global $wgTitle;
		$wgTitle = Title::newMainPage();
	}

	protected function tearDown() {
		WF::reset( 'EasyTemplate' );
		parent::tearDown();
	}

	public function useSubpage() {
		return array(
		    array( '/ViewInfo' ),
		    array( '/EditReport' ),
		    array( '/EditReport/0' ),
		    array( '/EditGroup' ),
		    array( '/EditGroup/0' )
		);
	}

	public function testStatsSourceReportChartPath() {

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;

		$oReport->newSource( SponsorshipDashboardReport::SD_SOURCE_STATS );
		$oReport->tmpSource->setCityId( 177 );
		$oReport->tmpSource->setSeries( array( 'A', 'B', 'C', 'D', 'E' ) );
		$oReport->tmpSource->setSeriesName( 'A', 'something' );
		$oReport->tmpSource->setNamespaces( array( 500, 501 ) );
		$oReport->acceptSource();

		$oReport->newSource( SponsorshipDashboardReport::SD_SOURCE_STATS );
		$oReport->tmpSource->setSeries( array( 'A' ) );
		$oReport->acceptSource( array( 177 ) );

		$oReport->setId( 0 );
		$oReport->lockSources();

		// mock returnFunctions

		$returnChart = $oReport->returnChartData();

		$this->assertInternalType( 'array', $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_TICKS, $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS, $returnChart );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_SERIE, $returnChart );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_TICKS ] );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS ] );
		$this->assertNotEmpty( $returnChart[ SponsorshipDashboardReport::SD_RETURNPARAM_SERIE ] );

		$returnArray = $oReport->getReportParams();

		$this->assertInternalType( 'array', $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_ID, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardSource::SD_PARAMS_FREQUENCY, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_NAME, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_PARAMS_DESCRIPTION, $returnArray );
		$this->assertArrayHasKey( SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE, $returnArray );

		$returnHtml = $oReport->getMenuItemsHTML();

		$this->assertInternalType( 'array', $returnHtml );

		$returnParams = $oReport->getTableFromParams();

		$this->assertInternalType( 'array', $returnParams );
	}

	public function testFillReportFromSerializedData() {

		$aInput = array();
		$aInput[0] = "mainId=67&mainTitle=Testa'rama&mainDescription=scrap+report'yo&mainFrequency=1&lastDateUnits=30";
		$aInput[1] = "sourceType=Stats&seriesA=on&sourceSerieName-A=1&seriesB=on&sourceSerieName-B=1&seriesC=on&sourceSerieName-C=2&seriesD=on&sourceSerieName-D=3&seriesE=on&sourceSerieName-E=4&seriesF=on&sourceSerieName-F=5&seriesG=on&sourceSerieName-G=6&seriesH=on&sourceSerieName-H=7&seriesI=on&sourceSerieName-I=8&seriesJ=on&sourceSerieName-J=9&seriesK=on&sourceSerieName-K=0&namespaces=&repCityId=&repeatSourceType=1&repCompTopX=&repCompCityId=&repCompHubId=";
		
		$app = $this->getMock( 'WikiaApp' );

		$oReport = new SponsorshipDashboardReport();
		$oReport->fillFromSerializedData( serialize( $aInput ) );
		$oReport->lockSources();

		$dataFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$this->assertNotEmpty( $dataFormatter->getHTML() );
	}

	public function testEmptyReport() {

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 0 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;
		$oReport->lockSources();

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();
		$this->assertEmpty( $return );

		$oFormatter = SponsorshipDashboardOutputTable::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertEmpty( $return );

		$mockedFormatter = $this->getMock('SponsorshipDashboardOutputCSV', array('beforePrint'));
		$mockedFormatter->expects($this->any())
		                ->method('beforePrint')
		                ->will($this->returnValue(null));
		$this->mockClass('SponsorshipDashboardOutputCSV', $mockedFormatter);
		$oFormatter = SponsorshipDashboardOutputCSV::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertEmpty( $return );
	}

	public function testReportWithAllEmptySeries() {

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

		$oReport->lockSources();

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();

		$this->assertEmpty( $return );

		$oFormatter = SponsorshipDashboardOutputTable::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertNotEmpty( $return );

		$mockedFormatter = $this->getMock('SponsorshipDashboardOutputCSV', array('beforePrint'));
		$mockedFormatter->expects($this->once())
		                ->method('beforePrint')
		                ->will($this->returnValue(null));
		$this->mockClass('SponsorshipDashboardOutputCSV', $mockedFormatter);
		$oFormatter = SponsorshipDashboardOutputCSV::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertNotEmpty( $return );
	}

	public function testGapiSource() {

		// prepare GoogleApi mock

		$gapi = $this->getMock( 'gapi' , array(), array( 'email', 'pass', 'token' ));
		$gapi   ->expects( $this->any() )
			->method( 'requestReportData' )
			->will( $this->returnValue( false ) );

		$oFakeGapiResponse = new FakeGapiResult;
		$aFakeGapiResponse = array();
		for ( $i =0; $i < 10; $i++ ){
			$aFakeGapiResponse[] = $oFakeGapiResponse;
		}
		
		// fake broken connection
		
		$gapi   ->expects( $this->any() )
			->method( 'getResults' )
			->will(
				$this->onConsecutiveCalls(
					$this->throwException( new Exception('falseTestException') ),
					$this->throwException( new Exception('falseTestException') ),
					$this->throwException( new Exception('falseTestException') ),
					$aFakeGapiResponse
				)
			);
		WF::setInstance( 'gapi', $gapi );

		// prepare source

		$SDSGapi = $this->getMock( 'SponsorshipDashboardSourceGapi', array( 'getFromCache' ) );
		$SDSGapi->expects( $this->any() )
			->method( 'loadDataFromCache' )
			->will( $this->returnValue( false ) );

		$SDSGapi->setMetrics( array( 'pageviews' ,'asdasdaaweaweaeadsafsdfsfsdfsfaesfasfa' ) );
		$SDSGapi->setFrequency( SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY );
		$SDSGapi->setMetricName( SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY, 'smething' );
		$SDSGapi->setMetricName( SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY, 'smething' );
		$SDSGapi->getCacheKey();
		$SDSGapi->setOnEmpty( 'asdasda' );
		
		// premare report

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'testReport';
		$oReport->setLastDateUnits( 7 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;
		$oReport->tmpSource = $SDSGapi;
		$oReport->acceptSource();

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();

		$this->assertNotEmpty( $return );

		$oFormatter = SponsorshipDashboardOutputTable::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertNotEmpty( $return );

		$mockedFormatter = $this->getMock('SponsorshipDashboardOutputCSV', array('beforePrint'));
		$mockedFormatter->expects($this->once())
		                ->method('beforePrint')
		                ->will($this->returnValue(null));
		$this->mockClass('SponsorshipDashboardOutputCSV', $mockedFormatter);
		$oFormatter = SponsorshipDashboardOutputCSV::newFromReport( $oReport );
		$return = $oFormatter->getHTML();
		$this->assertNotEmpty( $return );
	}
}

class FakeGapiResult {

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
