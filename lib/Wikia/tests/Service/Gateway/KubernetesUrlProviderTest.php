<?php
namespace Wikia\Service\Gateway;

use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class KubernetesUrlProviderTest extends TestCase {

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
		$kubernetesUrlProvider->setLogger( new NullLogger() );

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
	 * @dataProvider provideExoticEnvironmentDatacenter
	 *
	 * @param string $env
	 * @param string $dc
	 */
	public function testThrowsExceptionForExoticEnvironments( string $env, string $dc ) {
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( "Invalid environment $env" );

		new KubernetesUrlProvider( $env, $dc );
	}

	public function provideExoticEnvironmentDatacenter(): Generator {
		yield [ WIKIA_ENV_SANDBOX, WIKIA_DC_SJC ];
		yield [ WIKIA_ENV_SANDBOX, WIKIA_DC_SJC ];
		yield [ WIKIA_ENV_VERIFY, WIKIA_DC_SJC ];
		yield [ WIKIA_ENV_VERIFY, WIKIA_DC_SJC ];
		yield [ WIKIA_ENV_PREVIEW, WIKIA_DC_SJC ];
		yield [ WIKIA_ENV_PREVIEW, WIKIA_DC_SJC ];
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
		$kubernetesUrlProvider->setLogger( new NullLogger() );

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
}
