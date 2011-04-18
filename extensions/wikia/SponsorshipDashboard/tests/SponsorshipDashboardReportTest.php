<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

class SponsorshipDashboardReportTest extends PHPUnit_Framework_TestCase {

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

		$oSource = new SponsorshipDashboardSourceStats();
		$oSource->setCityId( 177 );
		$oSource->setSeries( array( 'A', 'B', 'C', 'D' ) );

		$oReport->addSource( $oSource );
		$oReport->acceptSource();
		$oReport->lockSources();

		$oFormatter = SponsorshipDashboardOutputChart::newFromReport( $oReport );
		$return = $oFormatter->getChartData();

		$this->assertInternalType( 'array', $return );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_TICKS, $return );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS, $return );
		$this->assertArrayHasKey( SponsorshipDashboardReport::SD_RETURNPARAM_SERIE, $return );
		$this->assertNotEmpty( $return[ SponsorshipDashboardReport::SD_RETURNPARAM_TICKS ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardReport::SD_RETURNPARAM_FULL_TICKS ] );
		$this->assertNotEmpty( $return[ SponsorshipDashboardReport::SD_RETURNPARAM_SERIE ] );
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

/*
	public function testProperReportExecution() {

		$user  = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'wikimetrics' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->atLeastOnce() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$page = $this->getMock('SponsorshipDashboard', array('displayChart'));
		$page->expects($this->atLeastOnce())
		     ->method('displayChart')
		     ->with( $this->equalTo('competitors'));

		$page->execute('competitors');
	}

	public function testUnproperReportExecution() {

		$user  = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'FALSE' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->atLeastOnce() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$page = $this->getMock('SponsorshipDashboard', array('HTMLerror'));
		$page->expects($this->atLeastOnce())
		     ->method('HTMLerror');

		$page->execute('test');
	}

	public function testDisplayEmptyDataArray() {

		$user = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'wikimetrics' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->atLeastOnce() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$tmpl = $this->getMock( 'EasyTemplate', array(), array('foobar') );
		$tmpl->expects( $this->once() )
		     ->method( 'execute' )
		     ->with( $this->equalTo( SponsorshipDashboard::TEMPLATE_EMPTY_CHART ) );

		WF::setInstance( 'EasyTemplate', $tmpl );

		$page = $this->getMock('SponsorshipDashboard', array('getChartData'));
		$page->expects($this->atLeastOnce())
		     ->method('getChartData')->will( $this->returnValue( array() ) );
		$page->execute();

	}

	public function testDisplayData() {

		$user = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'wikimetrics' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->atLeastOnce() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$tmpl = $this->getMock(
			'EasyTemplate',
			array(),
			array('foo')
		);

		$tmpl->expects( $this->once() )
		     ->method( 'execute' )
		     ->with( $this->equalTo( SponsorshipDashboard::TEMPLATE_CHART ) );

		WF::setInstance( 'EasyTemplate', $tmpl );

		$page = $this->getMock('SponsorshipDashboard', array('getChartData'));
		$page->expects( $this->atLeastOnce() )
			->method('getChartData')
			->will(
				$this->returnValue(
					array(
						'serie' => array( 'fooSerie' ),
						'ticks' => array( 'fooTick' ),
						'fullTicks' => array( 'fooFullTicks' )
					)
				)
			);
		$page->execute();
	}
*/
}