<?php
namespace Wikia\Consul;
/**
 * A way to access configuration variables defined in Consul.
 *
 * @package Wikia\Consul
 */
interface ConfigurationService {
	/**
	 * Returns the specified configuration value from Consul KV storage.
	 *
	 * @param string $path Configuration path in Consul KV storage: foo/bar/test
	 * @return mixed Configuration value
	 */
	public function getConfigurationEntry( string $path );
}
