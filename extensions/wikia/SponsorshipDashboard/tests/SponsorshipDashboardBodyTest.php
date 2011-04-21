<?php
require_once dirname(__FILE__) . '/../SponsorshipDashboard_setup.php';
wfLoadAllExtensions();

class SponsorshipDashboardBodyTest extends PHPUnit_Framework_TestCase {

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

	
	public function useSubpage(){
		return array(
		    array( '/ViewInfo' ),
		    array( '/EditReport' ),
		    array( '/EditReport/0' )
		);
	}

	/**
	 * @dataProvider useSubpage
	 */

	public function testBodyAdmin( $subpage ) {

		$app = $this->getMock( 'WikiaApp', array('getGlobal') );
		$app	->expects( $this->any() )
			->method( 'getGlobal' )
			->will( $this->returnCallback( array( $this, 'appBodyCallback') ) );
		
		F::setInstance( 'App', $app );

		$oPage = new SponsorshipDashboard;
		$bSuccess = $oPage->execute( SponsorshipDashboard::ADMIN.$subpage );
		$this->assertTrue( $bSuccess );	
	}

	public function appBodyCallback( $sGlobal ){
		
		switch ( $sGlobal ) {

			// return mocked object
			case 'wgUser' :
				$user  = $this->getMock( 'User' );
				$user	->expects( $this->any() )
					->method( 'isAllowed' )
					->with( $this->equalTo( 'wikimetrics' ) )
					->will( $this->returnValue( true ) );

				$return = $user;
				break;
			
			// return orginal object
			default: $return = $this->app->getGlobal( $sGlobal );
		}
		return $return;
	}
}