<?php

class PhalanxServiceTest extends WikiaBaseTest {

	/**
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		error_log( __CLASS__ . '::' . __FUNCTION__ . ' '  .$this->setupFile );

		parent::setUp();

	}

	public function isPhalanxAlive( ) {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		$this->mockGlobalVariable( "wgPhalanxServiceUrl", "http://dev-eloy:8080" );
		$this->mockApp();

		$service = new PhalanxService();
		return $service->status();
	}

	public function testPhalanxServiceCheck() {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		$status = $this->isPhalanxAlive();
		$this->assertEquals(1, $status );
	}
}
