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
		// $this->mockApp(); // not required anymore?
		$this->checkPhalanxAlive();
	}

	public function checkPhalanxAlive( ) {
		error_log( __CLASS__ . '::' . __FUNCTION__ );

		$this->service = new PhalanxService();
		if (!$this->service->status()) {
			throw new Exception("Can't connect to phalanx service");
		}
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
		$ret = $this->service->check( "content", "hello world" );
		$this->assertEquals( $ret, 1 );

		$ret = $this->service->check( "invalid type", "hello world" );
		$this->assertEquals( $ret, false );

		$ret = $this->service->check( "content", "pornhub.com" );
		$this->assertEquals( $ret, 0 );
	}


	public function testPhalanxServiceReload() {
		$this->markTestSkipped("Forced reload disabled until we have separate phalanx service for tests.\n");
		return;

		$ret = $this->service->reload();
		$this->assertEquals( 1, $ret );

		$ret = $this->service->reload( array( 1, 2, 3 ) );
		$this->assertEquals( 1, $ret );

	}

	public function testPhalanxServiceMatch() {
		$ret = $this->service->match( "content", "hello" );
		$this->assertEquals( 0, $ret );


		$ret = $this->service->match( "content", "pornhub.com" );
		$val = is_integer( $ret->id ) && $ret->id > 1;
		$this->assertEquals( true, $val, "pornhub.com should be matched as spam content" );
	}

	public function testPhalanxServiceValidate() {

		$ret = $this->service->validate( '^alamakota$' );
		$this->assertEquals( 1, $ret, "Valid regex" );

		$ret = $this->service->validate( '^alama(((kota$' );
		$this->assertEquals( 0, $ret, "Invalid regex" );

	}

	public function testPhalanxServiceStats() {
		$ret = $this->service->stats( );
		// check for known strings
		$this->assertRegexp( "/email|wiki_creation|summary/", $ret );
	}

}
