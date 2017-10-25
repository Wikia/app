<?php
namespace Wikia\Consul;

use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\KV;

/**
 * A way to access configuration variables defined in Consul.
 *
 * @package Wikia\Consul
 */
class ConfigurationServiceImpl implements ConfigurationService {
	/** @var KV $client */
	private $client;

	/**
	 * @Inject
	 * @param ServiceFactory $serviceFactory
	 */
	public function __construct( ServiceFactory $serviceFactory ) {
		$this->client = $serviceFactory->get( 'kv' );
	}

	/**
	 * Returns the specified configuration value from Consul KV storage.
	 *
	 * @param string $path Configuration path in Consul KV storage: foo/bar/test
	 * @return mixed Configuration value
	 */
	public function getConfigurationEntry( string $path ) {
		$response = $this->client->get( $path )->json();
		$value = $response[0]['Value'];

		return base64_decode( $value );
	}
}
