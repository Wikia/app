<?php
class PhalanxServiceTest extends WikiaBaseTest {

	/* @var PhalanxService */
	public $service;

	/**
	 * setup tests
	 */
	public function setUp() {

		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		wfDebug( __METHOD__ . ': '  .$this->setupFile );
		parent::setUp();

		$this->mockGlobalVariable( "wgPhalanxServiceUrl", "http://localhost:8080" );
		$this->mockApp();
	}

	public function isPhalanxAlive( ) {
		error_log( __CLASS__ . '::' . __FUNCTION__ );


		$this->service = new PhalanxService();
		return $this->service->status();
	}

	/**
	 * check for defined methods in service
	 */
	public function testPhalanxServiceMethod() {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		$this->service = new PhalanxService();
		foreach( array( "check", "match", "status", "reload", "validate", "stats" ) as $method ) {
			$this->assertEquals( true, method_exists( $this->service, $method ), "Method '$method' doesnt exist in PhalanxService" );
		}
	}

	public function testPhalanxServiceCheck() {
		error_log( __CLASS__ . '::' . __FUNCTION__ );
		if( $this->isPhalanxAlive() ) {
			$ret = $this->service->check( "content", "hello world" );
			$this->assertEquals( $ret, 1 );

			$ret = $this->service->check( "invalid type", "hello world" );
			$this->assertEquals( $ret, false );

			$ret = $this->service->check( "content", "pornhub.com" );
			$this->assertEquals( $ret, 0 );
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

			$ret = $this->service->limit( 1 )->match( "content", "hello" );
			$this->assertEquals( 0, $ret );


			$ret = $this->service->limit( 1 )->match( "content", "pornhub.com" );
			$val = is_integer( $ret->id ) && $ret->id > 1;
			$this->assertEquals( true, $val, "pornhub.com should be matched as spam content" );
		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}

	public function testPhalanxServiceValidate() {
		global $wgDebugLogFile;
	//	$wgDebugLogFile = "php://stdout";

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

	public function testPhalanxServiceStats() {
		global $wgDebugLogFile;
	//	$wgDebugLogFile = "php://stdout";

		if( $this->isPhalanxAlive() ) {
			$ret = $this->service->stats( );
			// check for known strings
			$this->assertRegexp( "/email|wiki_creation|summary/", $ret );
		}
		else {
			$this->markTestSkipped( sprintf( "Can't contact with phalanx service on %s.\n", F::app()->wg->PhalanxServiceUrl ) );
		}
	}

}
