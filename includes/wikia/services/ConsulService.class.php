<?php
class ConsulService extends Service {

	const DATA_CENTER_SJC = "sjc";
	const DATA_CENTER_POZ = "poz";
	const DATA_CENTER_RES = "res";

	const TAG_PRODUCTION = "production";
	const TAG_TESTING = "testing";

	const SERVICE_NAME_SCHEMA = "{tag}.{service}.service.{dataCenter}.consul";

	protected $dataCenter = self::DATA_CENTER_SJC;

	protected $serviceTag;
	protected $serviceName;

	public function __construct( $serviceName, $serviceTag=null ) {

		$this->serviceName = $serviceName;

		if ( $serviceTag === null ) {
			$serviceTag = $this->isDevelopmentEnv() ? self::TAG_TESTING : self::TAG_PRODUCTION;
		}

		$this->serviceTag = $serviceTag;
		return $this;
	}

	/**
	 * @return bool
	 */
	protected function isDevelopmentEnv() {
		return F::app()->wg->DevelEnvironment === true;
	}

	/**
	 * @return string
	 */
	public function getServiceName()	{
		return $this->serviceName;
	}


	/**
	 * @param $serviceName
	 * @return $this
	 */
	public function setServiceName( $serviceName )	{
		$this->serviceName = $serviceName;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getServiceTag()	{
		return $this->serviceTag;
	}

	/**
	 * @param $serviceTag
	 * @return $this
	 */
	public function setServiceTag( $serviceTag )	{
		$this->serviceTag = $serviceTag;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getDataCenter()	{
		return $this->dataCenter;
	}


	/**
	 * @param $dataCenter
	 * @return $this
	 */
	public function setDataCenter( $dataCenter ) {
		$this->dataCenter = $dataCenter;
		return $this;
	}

	/**
	 * Build consul service host name <{tag}.{service}.service.{dataCenter}.consul>
	 * @return string
	 */
	public function getConsulServiceName() {
		$name = strtr(self::SERVICE_NAME_SCHEMA, array(
			'{tag}' => $this->getServiceTag(),
			'{service}' => $this->getServiceName(),
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
	 * @return array ['host'=>, 'port'=>],
	 */
	public function resolve() {
		$consulServiceHost = $this->getConsulServiceName();
		$records = $this->getResolvedRecords( $consulServiceHost );
		if ( !empty( $records ) ) {
			//always first, consul is rotating the set
			return $records[0];
		}
		return false;
	}

}