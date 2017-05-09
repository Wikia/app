<?php
namespace Wikia\Consul;

use PHPUnit\Framework\TestCase;
use Wikia\DependencyInjection\Injector;

/**
 * @group Integration
 */
class ConfigurationServiceIntegrationTest extends TestCase {
	/** @var ConfigurationService $service */
	private $service;

	/** @var string $entry */
	private $entry;

	protected function setUp() {
		global $wgWikiaEnvironment;
		parent::setUp();

		$this->service = Injector::getInjector()->get( ConfigurationService::class );
		$this->entry = "config/base/$wgWikiaEnvironment/DATACENTER";
	}

	/**
	 * @covers ConfigurationServiceImpl::getConfigurationEntry()
	 */
	public function testReturnsConsulConfigurationValue() {
		$value = $this->service->getConfigurationEntry( $this->entry );

		$this->assertNotEmpty( $value );
	}
}
