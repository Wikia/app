<?php

# TODO: Make this an abstract class, and make the EC2 API a subclass
class OpenStackNovaInstanceType {

	var $instanceType;

	/**
	 * @param  $apiInstanceResponse
	 */
	function __construct( $apiInstanceResponse ) {
		$this->instanceType = $apiInstanceResponse;
	}

	/**
	 * Return the amount of RAM this instance type will use
	 *
	 * @return string
	 */
	function getMemorySize() {
		return (string)$this->instanceType->memoryMb;
	}

	/**
	 * Return the number of CPUs this instance will have
	 *
	 * @return string
	 */
	function getNumberOfCPUs() {
		return (string)$this->instanceType->vcpus;
	}

	/**
	 * Return the name of this instanceType
	 *
	 * @return string
	 */
	function getInstanceTypeName() {
		return (string)$this->instanceType->name;
	}

	/**
	 * Return the amount of storage this instance will use
	 *
	 * @return string
	 */
	function getStorageSize() {
		return (string)$this->instanceType->diskGb;
	}

	/**
	 * Return the id of this instanceType
	 *
	 * @return int
	 */
	function getInstanceTypeId() {
		return (int)$this->instanceType->flavorId;
	}

	/**
	 * @static
	 * @param OpenStackNovaInstanceType $a
	 * @param OpenStackNovaInstanceType $b
	 * @return bool
	 */
	public static function sorter( $a, $b ) {
		return $a->getInstanceTypeId() > $b->getInstanceTypeId();
	}

	public static function sort( &$collection ) {
		usort( $collection, array( __CLASS__, 'sorter' ) );
	}

}
