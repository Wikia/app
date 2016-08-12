<?php

namespace DataValues;

/**
 * Base for objects that represent a single data value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DataValueObject implements DataValue {

	/**
	 * @see Hashable::getHash
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getHash() {
		return md5( serialize( $this ) );
	}

	/**
	 * @see Comparable::equals
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 *
	 * @return boolean
	 */
	public function equals( $value ) {
		return $value === $this ||
			( is_object( $value ) && get_class( $value ) == get_called_class() && serialize( $value ) === serialize( $this ) );
	}

	/**
	 * @see Copyable::getCopy
	 *
	 * @since 0.1
	 *
	 * @return DataValue
	 */
	public function getCopy() {
		return unserialize( serialize( $this ) );
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getArrayValue() {
		return $this->getValue();
	}

	/**
	 * @see DataValue::toArray
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function toArray() {
		return array(
			'value' => $this->getArrayValue(),
			'type' => $this->getType(),
		);
	}

	/**
	 * Checks that $data is an array and contains the given fields.
	 *
	 * @param mixed $data
	 * @param array $fields
	 *
	 * @todo: this should be removed once we got rid of all the static newFromArray() methods.
	 *
	 * @throws IllegalValueException
	 */
	protected static function requireArrayFields( $data, array $fields ) {
		if ( !is_array( $data ) ) {
			throw new IllegalValueException( "array expected" );
		}

		foreach ( $fields as $field ) {
			if ( !array_key_exists( $field, $data ) ) {
				throw new IllegalValueException( "$field field required" );
			}
		}
	}

}
