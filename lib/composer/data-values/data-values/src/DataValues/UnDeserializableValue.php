<?php

namespace DataValues;

use InvalidArgumentException;

/**
 * Class representing a value that could not be unserialized for some reason.
 * It contains the raw native data structure representing the value,
 * as well as the originally intended value type and an error message.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class UnDeserializableValue extends DataValueObject {

	/**
	 * @var mixed
	 */
	private $data;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $error;

	/**
	 * @since 0.1
	 *
	 * @param string $type The originally intended type
	 * @param mixed $data The raw data structure
	 * @param string $error The error that occurred when processing the original data structure.
	 *
	 * @throws InvalidArgumentException
	 * @internal param mixed $value
	 */
	public function __construct( $data, $type, $error ) {
		if ( !is_null( $type ) && !is_string( $type ) ) {
			throw new InvalidArgumentException( '$type must be string or null' );
		}

		if ( is_object( $data ) ) {
			throw new InvalidArgumentException( '$data must not be an object' );
		}

		if ( !is_string( $error ) ) {
			throw new InvalidArgumentException( '$error must be a string' );
		}

		$this->data = $data;
		$this->type = $type;
		$this->error = $error;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @note: The serialization includes the intended type and the error message
	 *        along with the original data.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( array( $this->type, $this->data, $this->error ) );
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
		list( $type, $data, $error ) = unserialize( $value );
		$this->__construct( $data, $type, $error );
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @note: this returns the original raw data structure.
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getArrayValue() {
		return $this->data;
	}

	/**
	 * @see DataValue::toArray
	 *
	 * @note: This uses the originally intended type. This way, the native representation
	 *        does not model a UnDeserializableValue, but the originally intended type of value.
	 *        This allows for round trip compatibility with unknown types of data.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function toArray() {
		return array(
			'value' => $this->getArrayValue(),
			'type' => $this->getTargetType(),
			'error' => $this->getReason(),
		);
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		return 'bad';
	}

	/**
	 * Returns the value type that was intended for the bad data structure.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getTargetType() {
		return $this->type;
	}

	/**
	 * Returns a string describing the issue that caused the failure
	 * represented by this UnDeserializableValue object.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getReason() {
		return $this->error;
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return int Always 0 in this implementation.
	 */
	public function getSortKey() {
		return 0;
	}

	/**
	 * Returns the raw data structure.
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->data;
	}

	/**
	 * @see Comparable::equals
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function equals( $value ) {
		if ( $value === $this ) {
			return true;
		}

		if ( !( $value instanceof self ) ) {
			return false;
		}

		return $value->data === $this->data
			&& $value->type === $this->type
			&& $value->error === $this->error;
	}

}
