<?php
namespace Wikia\Util\Consul;

class ConsulService {

	protected $config;

	public function __construct( ConsulConfig $config ) {
		$this->config = $config;
		return $this;
	}

	/**
	 * @return ConsulConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param ConsulConfig $config
	 */
	public function setConfig( ConsulConfig $config ) {
		$this->config = $config;
	}


	/**
	 * Get all host/port for the service.
	 * @param $consulServiceHost
	 * @return array
	 */
	public function getResolvedRecords( $consulServiceHost ) {
		$records = $this->doResolve( $consulServiceHost );
		$resolved = [ ];
		if ( is_array( $records ) && !empty( $records ) ) {
			foreach ( $records as $record ) {
				$resolved[ ] = [ 'host' => $record[ 'target' ], 'port' => $record[ 'port' ] ];
			}
		}
		return $resolved;
	}

	protected function doResolve( $consulServiceHost ) {
		return dns_get_record( $consulServiceHost, DNS_SRV );
	}

	/**
	 * Get single host/port for the service.
	 * @return array ['host'=>, 'port'=>],
	 */
	public function resolve() {
		$consulServiceHost = $this->config->getConsulServiceName();
		$records = $this->getResolvedRecords( $consulServiceHost );
		if ( !empty( $records ) ) {
			// always first, consul is rotating the set
			return $records[ 0 ];
		}
		return false;
	}

}
