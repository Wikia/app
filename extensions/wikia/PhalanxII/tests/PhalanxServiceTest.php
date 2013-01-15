<?php

class PhalanxServiceTest extends WikiaBaseTest {

	/**
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		parent::setUp();
		$this->isPhalanxAlive();
	}

	public function isPhalanxAlive( ) {
		$service = $this->getMockBuilder( 'PhalanxService' )
			->disableOriginalConstructor()
			->setMethods( array( 'check' ) )
			->getMock();
		print $service->status();
	}
}
