<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

class SponsorshipDashboardBodyTest extends PHPUnit_Framework_TestCase {

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

	public function testUserPermissionGranted(){

		$user  = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'wikimetrics' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->once() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$SDBody = WF::build ( 'SponsorshipDashboard' );
		$this->assertTrue( $SDBody->isAllowed() );
	}

	public function testUserPermissionDenied(){

		$user  = $this->getMock( 'User' );
		$user->expects( $this->once() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'test', '' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->once() )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgUser' ) )
		    ->will( $this->returnValue( $user ) );

		WF::setInstance( 'App', $app );

		$SDBody = WF::build ( 'SponsorshipDashboard' );
		$this->assertFalse( $SDBody->isAllowed() );
	}

	public function testProperReportExecution() {

		$user  = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'getRights' )
		     ->will( $this->returnValue( array( 'wikimetrics' ) ) );

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app->expects( $this->once() )
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
		$app->expects( $this->once() )
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
		$app->expects( $this->once() )
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
		$app->expects( $this->once() )
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
		$page	->expects( $this->atLeastOnce() )
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
}