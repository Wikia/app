<?php

namespace Deserializers;

use Deserializers\Exceptions\DeserializationException;
use InvalidArgumentException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingDeserializer implements DispatchableDeserializer {

	/**
	 * @var DispatchableDeserializer[]
	 */
	protected $deserializers;

	/**
	 * @param DispatchableDeserializer[] $deserializers
	 */
	public function __construct( array $deserializers = array() ) {
		$this->assertAreDeserializers( $deserializers );
		$this->deserializers = $deserializers;
	}

	protected function assertAreDeserializers( array $deserializers ) {
		foreach ( $deserializers as $deserializer ) {
			if ( !is_object( $deserializer ) || !( $deserializer instanceof DispatchableDeserializer ) ) {
				throw new InvalidArgumentException(
					'All $deserializers need to implement the DispatchableDeserializer interface'
				);
			}
		}
	}

	public function deserialize( $serialization ) {
		foreach ( $this->deserializers as $deserializer ) {
			if ( $deserializer->isDeserializerFor( $serialization ) ) {
				return $deserializer->deserialize( $serialization );
			}
		}

		throw new DeserializationException(
			'None of the deserializers can deserialize the provided serialization'
		);
	}

	public function isDeserializerFor( $serialization ) {
		foreach ( $this->deserializers as $deserializer ) {
			if ( $deserializer->isDeserializerFor( $serialization ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @since 3.0
	 *
	 * @param DispatchableDeserializer $serializer
	 */
	public function addDeserializer( DispatchableDeserializer $serializer ) {
		$this->deserializers[] = $serializer;
	}

}
