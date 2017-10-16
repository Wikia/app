<?php

namespace Deserializers;

use Deserializers\Exceptions\DeserializationException;
use Deserializers\Exceptions\InvalidAttributeException;
use Deserializers\Exceptions\MissingAttributeException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class TypedDeserializationStrategy {

	/**
	 * Deserializes the value serialization into an object.
	 *
	 * @since 1.0
	 *
	 * @param string $specificType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public abstract function getDeserializedValue( $specificType, array $valueSerialization );

	protected function requireAttribute( array $array, $attributeName ) {
		if ( !array_key_exists( $attributeName, $array ) ) {
			throw new MissingAttributeException(
				$attributeName
			);
		}
	}

	protected function assertAttributeIsArray( array $array, $attributeName ) {
		if ( !is_array( $array[$attributeName] ) ) {
			throw new InvalidAttributeException(
				$attributeName,
				$array[$attributeName]
			);
		}
	}

	protected function requireAttributes( array $array ) {
		$requiredAttributes = func_get_args();
		array_shift( $requiredAttributes );

		foreach ( $requiredAttributes as $attribute ) {
			$this->requireAttribute( $array, $attribute );
		}
	}

}
