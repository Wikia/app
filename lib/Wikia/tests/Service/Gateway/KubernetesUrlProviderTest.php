<?php
namespace Wikia\Service\Gateway;

use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class KubernetesUrlProviderTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		$this->markTestSkipped();
	}

	/**
	 * @dataProvider provideEnvironmentDatacenterAndServiceName
	 *
	 * @param string $env
	 * @param string $dc
	 * @param string $serviceName
	 */
	public function testConstructsCorrectKubernetesUrlForCommonEnvironments(
		string $env, string $dc, string $serviceName
	) {
		$kubernetesUrlProvider = new KubernetesUrlProvider( $env, $dc );

		$this->assertEquals(
			"$env.$dc.k8s.wikia.net/$serviceName",
			$kubernetesUrlProvider->getUrl( $serviceName )
		);
	}

	public function provideEnvironmentDatacenterAndServiceName(): Generator {
		yield [ WIKIA_ENV_PROD, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_PROD, WIKIA_DC_SJC, 'foobar' ];
		yield [ WIKIA_ENV_PROD, WIKIA_DC_RES, 'example' ];
		yield [ WIKIA_ENV_PROD, WIKIA_DC_RES, 'foobar' ];
		yield [ WIKIA_ENV_STAGING, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_STAGING, WIKIA_DC_SJC, 'foobar' ];
	}

	/**
	 * @dataProvider provideExoticEnvironmentDatacenterAndServiceName
	 *
	 * @param string $env
	 * @param string $dc
	 * @param string $serviceName
	 */
	public function testFallsBackToProductionForExoticEnvironments(
		string $env, string $dc, string $serviceName
	) {
		$prodEnv = WIKIA_ENV_PROD;
		$kubernetesUrlProvider = new KubernetesUrlProvider( $env, $dc );

		$this->assertEquals(
			"$prodEnv.$dc.k8s.wikia.net/$serviceName",
			$kubernetesUrlProvider->getUrl( $serviceName )
		);
	}

	public function provideExoticEnvironmentDatacenterAndServiceName(): Generator {
		yield [ WIKIA_ENV_SANDBOX, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_SANDBOX, WIKIA_DC_SJC, 'foobar' ];
		yield [ WIKIA_ENV_VERIFY, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_VERIFY, WIKIA_DC_SJC, 'foobar' ];
		yield [ WIKIA_ENV_PREVIEW, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_PREVIEW, WIKIA_DC_SJC, 'foobar' ];
	}

	/**
	 * @dataProvider provideDevEnvironmentDatacenterAndServiceName
	 *
	 * @param string $env
	 * @param string $dc
	 * @param string $serviceName
	 */
	public function testGeneratesCorrectUrlForDevEnvironments(
		string $env, string $dc, string $serviceName
	) {
		$kubernetesUrlProvider = new KubernetesUrlProvider( $env, $dc );

		$this->assertEquals(
			"$env.$dc-dev.k8s.wikia.net/$serviceName",
			$kubernetesUrlProvider->getUrl( $serviceName )
		);
	}
	
	public function provideDevEnvironmentDatacenterAndServiceName(): Generator {
		yield [ WIKIA_ENV_DEV, WIKIA_DC_SJC, 'example' ];
		yield [ WIKIA_ENV_DEV, WIKIA_DC_SJC, 'foobar' ];
		yield [ WIKIA_ENV_DEV, WIKIA_DC_POZ, 'example' ];
		yield [ WIKIA_ENV_DEV, WIKIA_DC_POZ, 'foobar' ];
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testThrowsExceptionForInvalidEnvironment() {
		return new KubernetesUrlProvider( 'blabla', WIKIA_DC_SJC );
	}
}
