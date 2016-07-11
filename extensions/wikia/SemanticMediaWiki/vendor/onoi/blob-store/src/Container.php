<?php

namespace Onoi\BlobStore;

use InvalidArgumentException;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class Container {

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var array
	 */
	private $data = array();

	/**
	 * @var integer
	 */
	private $expiry = 0;

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 * @param array $data
	 */
	public function __construct( $id, array $data ) {

		if ( !is_string( $id ) ) {
			throw new InvalidArgumentException( "Expected the id to be a string" );
		}

		$this->id = $id;
		$this->data = $data;
	}

	/**
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @since 1.1
	 *
	 * @return array
	 */
	public function getExpiry() {
		return $this->expiry;
	}

	/**
	 * @since 1.1
	 *
	 * @return integer $expiry
	 */
	public function setExpiryInSeconds( $expiry ) {
		$this->expiry = (int)$expiry;
	}

	/**
	 * @since 1.1
	 *
	 * @return boolean
	 */
	public function isEmpty() {
		return $this->data === array();
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function has( $key ) {
		return isset( $this->data[$key] ) || array_key_exists( $key, $this->data );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get( $key ) {

		if ( $this->has( $key ) ) {
			 return $this->data[$key];
		}

		return false;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->data[$key] = $value;
	}

	/**
	 * Extend/append/merge the data with an existing storage item for the same
	 * key
	 *
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function append( $key, $value ) {

		if ( !$this->has( $key ) ) {
			$this->data[$key] = array();
		}

		if ( !is_array( $value ) ) {
			 $value = array( $value );
		}

		$this->data[$key] = array_merge(
			(array)$this->data[$key],
			$value
		);
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 */
	public function delete( $key ) {
		unset( $this->data[$key] );
	}

}
