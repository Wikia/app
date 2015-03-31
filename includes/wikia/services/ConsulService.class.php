<?php
class ConsulService extends Service {

	const DATA_CENTER_SJC = "sjc";
	const DATA_CENTER_POZ = "poz";
	const DATA_CENTER_RES = "res";

	const TAG_PRODUCTION = "production";
	const TAG_TESTING = "testing";

	const SERVICE_NAME_SCHEMA = "{tag}.{service}.service.{dataCenter}.consul";

	protected $dataCenter = self::DATA_CENTER_SJC;

	/**
	 * @return string
	 */
	public function getDataCenter()	{
		return $this->dataCenter;
	}

	/**
	 * @param string $dataCenter
	 */
	public function setDataCenter( $dataCenter ) {
		$this->dataCenter = $dataCenter;
	}

	/**
	 * Build consul service host name <{tag}.{service}.service.{dataCenter}.consul>
	 * @param $serviceName
	 * @param string $serviceTag
	 * @return string
	 */
	public function getConsulServiceName( $serviceName, $serviceTag = "") {
		$name = strtr(self::SERVICE_NAME_SCHEMA, array(
			'{tag}' => $serviceTag,
			'{service}' => $serviceName,
			'{dataCenter}' => $this->getDataCenter()
		));
		if ( empty( $serviceTag ) ) {
			$name = ltrim( $name, '.' );
		}
		return $name;
	}


	/**
	 * Get all host/port for the service.
	 * @param $consulServiceHost
	 * @return array
	 */
	public function getResolvedRecords( $consulServiceHost ) {
		$records = dns_get_record( $consulServiceHost, DNS_SRV );
		$resolved = [];
		foreach ( $records as $record ) {
			$resolved[] = [ 'host' => $record['target'], 'port' => $record['port'] ];
		}
		return $resolved;
	}

	/**
	 * Get single host/port for the service.
	 * @param $serviceName
	 * @param $serviceTag
	 * @return array ['host'=>, 'port'=>],
	 */
	public function resolve( $serviceName, $serviceTag ) {
		$consulServiceHost = $this->getConsulServiceName( $serviceName, $serviceTag );
		$records = $this->getResolvedRecords( $consulServiceHost );
		if ( !empty( $records ) ) {
			//always first, consul is rotating the set
			return $records[0];
		}
		return false;
	}

}