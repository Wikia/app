<?php

namespace Maps;

use MWException;

/**
 * Interface for elements that can be placed upon a map.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Element {

	/**
	 * Returns the value in array form.
	 *
	 * @since 3.0
	 *
	 * @return mixed
	 */
	public function getArrayValue();

	/**
	 * Returns the elements options.
	 * Modification of the elements options by mutating the obtained object is allowed.
	 *
	 * @since 3.0
	 *
	 * @return ElementOptions
	 */
	public function getOptions(): ElementOptions;

	/**
	 * Sets the elements options.
	 *
	 * @since 3.0
	 *
	 * @param ElementOptions $options
	 */
	public function setOptions( ElementOptions $options );

}

class ElementOptions {

	private $options = [];

	/**
	 * @since 3.0
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setOption( $name, $value ) {
		if ( !is_string( $name ) ) {
			throw new \InvalidArgumentException( 'Option name should be a string' );
		}

		$this->options[$name] = $value;
	}

	/**
	 * @since 3.0
	 *
	 * @param string $name
	 *
	 * @throws \InvalidArgumentException
	 * @throws \OutOfBoundsException
	 */
	public function getOption( $name ) {
		if ( !is_string( $name ) ) {
			throw new \InvalidArgumentException( 'Option name should be a string' );
		}

		if ( !array_key_exists( $name, $this->options ) ) {
			throw new \OutOfBoundsException( 'Tried to obtain option "' . $name . '" while it has not been set' );
		}

		return $this->options[$name];
	}

	/**
	 * @since 3.0
	 *
	 * @param string $name
	 *
	 * @return boolean
	 * @throws \InvalidArgumentException
	 */
	public function hasOption( $name ) {
		if ( !is_string( $name ) ) {
			throw new \InvalidArgumentException( 'Option name should be a string' );
		}

		return array_key_exists( $name, $this->options );
	}

}