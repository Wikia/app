<?php

namespace Onoi\HttpRequest;

use InvalidArgumentException;

/**
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class RequestResponse {

	/**
	 * @var array
	 */
	private $fields = array();

	/**
	 * @since 1.1
	 */
	public function __construct( array $fields = array() ) {
		$this->fields = $fields;
	}

	/**
	 * @since 1.1
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->fields[$key] = $value;
	}

	/**
	 * @since 1.1
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has( $key ) {
		return isset( $this->fields[$key] ) || array_key_exists( $key, $this->fields );
	}

	/**
	 * @since 1.1
	 *
	 * @param string $key
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function get( $key ) {

		if ( $this->has( $key ) ) {
			return $this->fields[$key];
		}

		throw new InvalidArgumentException( "{$key} is an unregistered option" );
	}

	/**
	 * @since 1.1
	 *
	 * @return array
	 */
	public function getList() {
		return $this->fields;
	}

}
