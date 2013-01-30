<?php

class PhalanxServiceTest extends WikiaBaseTest {

	public $service;

	/**
	 * setup tests
	 */
	public function setUp() {

		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		wfDebug( __METHOD__ . ': '  .$this->setupFile );
		parent::setUp();

		$this->mockGlobalVariable( "wgPhalanxServiceUrl", "http://dev-eloy:8080" );
		$this->mockApp();
	}

	public function isPhalanxAlive( ) {
		error_log( __CLASS__ . '::' . __FUNCTION__ );


		$this->service = new PhalanxService();
		return $this->service->status();
	}

	public function testPhalanxServiceCheck() {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		if( $this->isPhalanxAlive() ) {
			$ret = $this->service->check( "content", "hello world" );
			$this->assertEquals( 1, $ret );

			$ret = $this->service->check( "invalid type", "hello world" );
			$this->assertEquals( false, $ret );

			$ret = $this->service->check( "content", "pornhub.com" );
			$this->assertEquals( 0, $ret );
		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}

	public function testPhalanxServiceReload() {
//		global $wgDebugLogFile;
//		$wgDebugLogFile = "php://stdout";

		if( $this->isPhalanxAlive() ) {
			$ret = $this->service->reload();
			$this->assertEquals( 1, $ret );

			$ret = $this->service->reload( array( 1, 2, 3 ) );
			$this->assertEquals( 1, $ret );

		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}

	public function testPhalanxServiceMatch() {
		if( $this->isPhalanxAlive() ) {
			// lang=en&type=content&content=hello
			$ret = $this->service->match( "content", "hello" );
			$this->assertEquals( 0, $ret );

			// lang=en&type=content&content=pornhub.com
			$ret = $this->service->match( "content", "pornhub.com" );
			print_r( $ret );
			$val = is_integer( $ret ) && $ret > 1;
			$this->assertEquals( true, $val, "pornhub.com should be matched as spam content" );

		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}

	public function testPhalanxServiceValidate() {
		if( $this->isPhalanxAlive() ) {
			$ret = $this->service->validate( '^alamakota$' );
			$this->assertEquals( 1, $ret, "Valid regex" );

			$ret = $this->service->validate( '^alama(((kota$' );
			$this->assertEquals( 0, $ret, "Invalid regex" );

		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}
}
