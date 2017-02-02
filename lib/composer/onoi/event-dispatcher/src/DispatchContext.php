<?php

namespace Onoi\EventDispatcher;

use InvalidArgumentException;

/**
 * Generic context that can be added during the dispatch process to be
 * accessible to each invoked listener
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DispatchContext {

	/**
	 * @var array
	 */
	private $container = array();

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has( $key ) {
		return isset( $this->container[strtolower( $key )] );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->container[strtolower( $key )] = $value;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	public function get( $key ) {

		if ( $this->has( $key ) ) {
			return $this->container[strtolower( $key )];
		}

		throw new InvalidArgumentException( "{$key} is unknown" );
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isPropagationStopped() {
		return $this->has( 'propagationstop' ) ? $this->get( 'propagationstop' ) : false;
	}

}
