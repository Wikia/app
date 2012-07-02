<?php

class WURFL_Storage_Mwmemcache extends WURFL_Storage_Base {

	private $expiration;
	private $namespace;

	private $defaultParams = array(
		"namespace" => "wurfl",
		"expiration" => 0
	);

	/**
	 * @param $params array
	 */
	public function __construct( $params = array() ) {
		$currentParams = is_array( $params )
				? array_merge( $this->defaultParams, $params )
				: $this->defaultParams;
		$this->toFields( $currentParams );
	}

	/**
	 * @param $params array
	 */
	private function toFields( $params ) {
		foreach( $params as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 * Saves the object.
	 *
	 * @param $objectId string
	 * @param $object mixed
	 * @return mixed
	 */
	public function save( $objectId, $object ) {
		global $wgMemc;
		return $wgMemc->set( $this->encode( $this->namespace, $objectId ), $object, $this->expiration );
	}

	/**
	 * Load the object.
	 *
	 * @param $objectId string
	 * @return mixed
	 */
	public function load( $objectId ) {
		global $wgMemc;
		$value = $wgMemc->get( $this->encode( $this->namespace, $objectId ) );
		return ( $value !== false ) ? $value : null; // WURFL expects null on cache miss
	}

	public function clear() {
	}
}
