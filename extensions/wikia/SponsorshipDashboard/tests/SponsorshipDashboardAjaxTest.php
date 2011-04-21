<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

class SponsorshipDashboardAjaxTest extends PHPUnit_Framework_TestCase {

	private $app;

	protected function setUp() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();
		$this->app = F::build( 'App' );
	}

	protected function tearDown() {
		F::setInstance( 'App', $this->app );
		F::reset( 'EasyTemplate' );
	}

	public function testGetForms() {
		$this->assertNotEmpty( SponsorshipDashboardAjax::axGetGapiForm() );
		$this->assertNotEmpty( SponsorshipDashboardAjax::axGetGapiCuForm() );
		$this->assertNotEmpty( SponsorshipDashboardAjax::axGetStatsForm() );
		$this->assertNotEmpty( SponsorshipDashboardAjax::axGetOneDotForm() );
		$this->assertNotEmpty( SponsorshipDashboardAjax::axGetMobileForm() );
				
	}
}