<?php
namespace Wikia\Service\Gateway;

use PHPUnit\Framework\TestCase;

class InternalIngressUrlProviderTest extends TestCase {

	/**
	 * @dataProvider provideEnvService
	 *
	 * @param string $envName
	 * @param string $serviceName
	 */
	public function testGetUrl( string $envName, string $serviceName ) {
		$provider = new InternalIngressUrlProvider( $envName );

		$this->assertEquals( "$serviceName.$envName", $provider->getUrl( $serviceName ) );
	}

	public function provideEnvService() {
		yield [ "dev", "helios" ];
		yield [ "prod", "phalanx" ];
	}
}
