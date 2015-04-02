<?php
namespace Wikia\Util\Consul;

class ConsulConfig {

	protected $urlSchema = "{tag}.{service}.service.{dataCenter}.consul";

	protected $dataCenter;
	protected $serviceTag;
	protected $serviceName;

	public function __construct( $dataCenter, $serviceName, $serviceTag ) {
		$this->dataCenter = $dataCenter;
		$this->serviceName = $serviceName;
		$this->serviceTag = $serviceTag;
	}

	/**
	 * @return string
	 */
	public function getUrlSchema() {
		return $this->urlSchema;
	}

	/**
	 * @param string $urlSchema
	 */
	public function setUrlSchema( $urlSchema ) {
		$this->urlSchema = $urlSchema;
	}

	/**
	 * @return string
	 */
	public function getDataCenter() {
		return $this->dataCenter;
	}

	/**
	 * @param string $dataCenter
	 */
	public function setDataCenter( $dataCenter ) {
		$this->dataCenter = $dataCenter;
	}

	/**
	 * @return string
	 */
	public function getServiceTag() {
		return $this->serviceTag;
	}

	/**
	 * @param string $serviceTag
	 */
	public function setServiceTag( $serviceTag ) {
		$this->serviceTag = $serviceTag;
	}

	/**
	 * @return string
	 */
	public function getServiceName() {
		return $this->serviceName;
	}

	/**
	 * @param string $serviceName
	 */
	public function setServiceName( $serviceName ) {
		$this->serviceName = $serviceName;
	}

	/**
	 * Build consul service host name <{tag}.{service}.service.{dataCenter}.consul>
	 * @return string
	 */
	public function getConsulServiceName() {
		$name = strtr( $this->getUrlSchema(), array(
			'{tag}' => $this->getServiceTag(),
			'{service}' => $this->getServiceName(),
			'{dataCenter}' => $this->getDataCenter() ) );
		return $name;
	}
}
