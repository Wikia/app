<?php

class FogbugzServiceTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var FogbugzService
	 */
	protected $object;

	protected function setUp() {
		global $wgHTTPProxy;
		$this->object = new FogbugzService( 'https://wikia.fogbugz.com/api.asp', 'adi@wikia.com', 'w1k14l4bs', $wgHTTPProxy);
	}

	public function testLogon() {
		$areas = $this->object->logon()->getAreas( 18 );

		var_dump( $areas );
	}
}