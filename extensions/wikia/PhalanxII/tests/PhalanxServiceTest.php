<?php

class PhalanxServiceTest extends WikiaBaseTest {

	public $service;
	/**
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		error_log( __CLASS__ . '::' . __FUNCTION__ . ' '  .$this->setupFile );

		parent::setUp();

		$this->mockGlobalVariable( "wgPhalanxServiceUrl", "http://dev-eloy:8080" );
		$this->mockApp();
	}

	public function isPhalanxAlive( ) {
		error_log( __CLASS__ . '::' . __FUNCTION__ );

		global $wgDebugLogFile;
	//	$wgDebugLogFile = "php://stdout";

		$this->service = new PhalanxService();
		return $this->service->status();
	}

	public function testPhalanxServiceCheck() {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		if( $this->isPhalanxAlive() ) {
///			$this->assertEquals(1, $status );
			$ret = $this->service->check( "content", "hello world" );
			$this->assertEquals( 1, $ret );

			$ret = $this->service->check( "doesn not matter", "hello world" );
			$this->assertEquals( false, $ret );

			$ret = $this->service->check( "content", "pornhub.com" );
			$this->assertEquals( 0, $ret );
		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}
}
