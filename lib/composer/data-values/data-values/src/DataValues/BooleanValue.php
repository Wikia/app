<?php

namespace DataValues;

/**
 * Class representing a boolean value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BooleanValue extends DataValueObject {

	private $value;

	/**
	 * @since 0.1
	 *
	 * @param bool $value
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $value ) {
		if ( !is_bool( $value ) ) {
			throw new IllegalValueException( 'Can only construct BooleanValue from booleans' );
		}

		$this->value = $value;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string '0' for false, '1' for true.
	 */
	public function serialize() {
		return $this->value ? '1' : '0';
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @since 0.1
	 *
	 * @param string $value '0' for false, '1' for true.
	 *
	 * @return BooleanValue
	 */
	public function unserialize( $value ) {
		$this->value = $value === '1';
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'boolean';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @return int 0 for false, 1 for true.
	 */
	public function getSortKey() {
		return $this->value ? 1 : 0;
	}

	/**
	 * Returns the boolean.
	 * @see DataValue::getValue
	 *
	 * @return bool
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
	 * @param bool $data
	 *
	 * @return BooleanValue
	 */
	public static function newFromArray( $data ) {
		return new static( $data );
	}

}
