<?php
class TrustedProxyServiceTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../services/TrustedProxyService.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider ipDataProvider
	 */
	public function testIPMatch( $ip, $expected, $message ) {
		$ranges = [ "199.27.72.0/21", "208.174.57.186" ];

		$this->mockGlobalVariable( "wgSquidServersNoPurge", $ranges );

		$trusted = false;
		$value = TrustedProxyService::onIsTrustedProxy( $ip, $trusted );
		$this->assertEquals( $trusted, $expected, $message );
		$this->assertEquals( $value, true, "Hook should return true" );
	}

	public function ipDataProvider() {
		return [
			[ "199.27.76.22", true, "Test should match given range" ],
			[ "199.27.76.23", true, "Test should match given range" ],
			[ "192.168.2.3", false, "Test should not match given range" ]
		];
	}
}
