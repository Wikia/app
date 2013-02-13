<?php
class TrustedProxyServiceTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../services/TrustedProxyService.class.php';
		parent::setUp();
	}

	public function testIPMatch( ) {
		$ranges = [ "199.27.72.0/21" ];
		$this->mockGlobalVariable( "SquidServersNoPurge", $ranges );
		$this->mockApp();

		$class = new TrustedProxyService();

		$trusted = false;
		$ip = "199.27.76.22";
		$class->hookIsTrustedProxy( $ip, $trusted );

		$trusted = false;
		$ip = "199.27.76.23";
		$class->hookIsTrustedProxy( $ip, $trusted );
	}
}
