<?php

namespace ValueFormatters;

use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;

/**
 * Object holding options for a formatter.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class FormatterOptions {

	/**
	 * @since 0.1
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * @since 0.1
	 *
	 * @param array $options
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $options = [] ) {
		foreach ( array_keys( $options ) as $option ) {
			if ( !is_string( $option ) ) {
				throw new InvalidArgumentException( 'Option names need to be strings' );
			}
		}

		$this->options = $options;
	}

	/**
	 * Sets the value of the specified option.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 * @param mixed $value
	 *
	 * @throws InvalidArgumentException
	 */
	public function setOption( $option, $value ) {
		if ( !is_string( $option ) ) {
			throw new InvalidArgumentException( 'Option name needs to be a string' );
		}

		$this->options[$option] = $value;
	}

	/**
	 * Returns the value of the specified option. If the option is not set,
	 * an InvalidArgumentException is thrown.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 *
	 * @throws OutOfBoundsException
	 * @return mixed
	 */
	public function getOption( $option ) {
		if ( !array_key_exists( $option, $this->options ) ) {
			throw new OutOfBoundsException( "Option '$option' has not been set so cannot be obtained" );
		}

		return $this->options[$option];
	}

	/**
	 * Returns if the specified option is set or not.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 *
	 * @return bool
	 */
	public function hasOption( $option ) {
		return array_key_exists( $option, $this->options );
	}

	/**
	 * Sets the value of an option to the provided default in case the option is not set yet.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 * @param mixed $default
	 */
	public function defaultOption( $option, $default ) {
		if ( !$this->hasOption( $option ) ) {
			$this->setOption( $option, $default );
		}
	}

	/**
	 * Requires an option to be set.
	 * If it's not set, a RuntimeException is thrown.
	 *
	 * @since 0.1
	 *
	 * @param string $option
	 *
	 * @throws RuntimeException
	 */
	public function requireOption( $option ) {
		if ( !$this->hasOption( $option ) ) {
			throw new RuntimeException( 'Required option"' . $option . '" is not set' );
		}
	}

}
