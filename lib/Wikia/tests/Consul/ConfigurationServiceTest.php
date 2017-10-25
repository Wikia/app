<?php
namespace Wikia\Consul;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\KV;
use GuzzleHttp\Message\Response;

class ConfigurationServiceTest extends TestCase {
	/** @var ConfigurationService $service */
	private $service;

	/** @var Response|PHPUnit_Framework_MockObject_MockObject $clientMock */
	private $consulResponseMock;

	/** @var string $testConfig */
	private $testConfig;

	protected function setUp() {
		parent::setUp();

		$this->testConfig = 'config/foo/test';
		$this->consulResponseMock = $this->createMock( Response::class );

		$clientMock = $this->createMock( KV::class );
		$clientMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->testConfig )
			->willReturn( $this->consulResponseMock );

		/** @var ServiceFactory|PHPUnit_Framework_MockObject_MockObject $serviceFactoryMock */
		$serviceFactoryMock = $this->createMock( ServiceFactory::class );
		$serviceFactoryMock->expects( $this->once() )
			->method( 'get' )
			->with( 'kv' )
			->willReturn( $clientMock );

		$this->service = new ConfigurationServiceImpl( $serviceFactoryMock );
	}

	/**
	 * @covers ConfigurationServiceImpl::getConfigurationEntry()
	 * @dataProvider provideConsulResponses
	 *
	 * @param array $consulResponse
	 * @param string $expectedServiceOutput
	 */
	public function testParsesConsulResponseAndDecodesValue(
		array $consulResponse, string $expectedServiceOutput
	) {
		$this->consulResponseMock->expects( $this->once() )
			->method( 'json' )
			->willReturn( $consulResponse );

		$actualServiceOutput = $this->service->getConfigurationEntry( $this->testConfig );

		$this->assertEquals( $expectedServiceOutput, $actualServiceOutput );
	}

	public function provideConsulResponses(): array {
		$json = file_get_contents( __DIR__ . '/fixtures/sample_consul_responses.json' );
		$data = [];

		foreach ( json_decode( $json, true ) as $response ) {
			$data[] = [
				$response,
			    base64_decode( $response[0]['Value'] )
			];
		}

		return $data;
	}
}
