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
		    array( '/EditReport/0' ),
		    array( '/EditGroup' ),
		    array( '/EditGroup/0' ),
		    array( '/EditUser' ),
		    array( '/EditUser/0' ),
		    array( '/ViewReports' )
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
		
		
		$aMockedClasses = array(
			'SponsorshipDashboardReports',
			'SponsorshipDashboardGroups',
			'SponsorshipDashboardUsers'
		);
		
		foreach( $aMockedClasses as $mockedClassName ){

			$obj = $this->getMock( $mockedClassName, array('getData') );
			$obj->expects( $this->any() )
				->method( 'getData' )
				->will( $this->returnValue( $this->commonORMReturn() ) );

			F::setInstance( $mockedClassName, $obj );
		}

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
	
	public function commonORMReturn(){
		
		$reportData = array();
		$tmpArray = array( 'id' => 1, 'name' => 'something', 'description' => 'asdasda ads asdadasd' , 'status' => 'asdasda ads asdadasd' , 'type' => 0 , 'userId' => 123123 );
		
		for ($i =0; $i < 10; $i++ ){
			$reportData[] = $tmpArray;
		}

		return $reportData;
		
	}

	public function testStaticPage() {

		$oPage = new SponsorshipDashboard;
		$this->assertFalse(
			$oPage->HTMLerror()
		);	
	}

}