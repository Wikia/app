<?php

namespace DataValues;

/**
 * Class representing a string value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StringValue extends DataValueObject {

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @param string $value
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $value ) {
		if ( !is_string( $value ) ) {
			throw new IllegalValueException( 'Can only construct StringValue from strings' );
		}

		$this->value = $value;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		return $this->value;
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @return StringValue
	 */
	public function unserialize( $value ) {
		$this->__construct( $value );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		return 'string';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getSortKey() {
		return $this->value;
	}

	/**
	 * Returns the string.
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param string $data
	 *
	 * @return StringValue
	 */
	public static function newFromArray( $data ) {
		return new static( $data );
	}

}
