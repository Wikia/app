<?php

namespace Deserializers;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StrategicDeserializer extends TypedObjectDeserializer {

	protected $deserializationStrategy;
	protected $subTypeKey;

	/**
	 * @param TypedDeserializationStrategy $deserializationStrategy
	 * @param string $objectType The objectType that is supported. For instance "description" or "selectionRequest".
	 * @param string $subTypeKey The name of the key used for the specific type of object. For instance "descriptionType" or "sortExpressionType".
	 */
	public function __construct( TypedDeserializationStrategy $deserializationStrategy, $objectType, $subTypeKey ) {
		$this->deserializationStrategy = $deserializationStrategy;
		$this->subTypeKey = $subTypeKey;

		parent::__construct( $objectType );
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserialization( $serialization );
	}

	protected function getDeserialization( array $serialization ) {
		$this->requireAttribute( $serialization, $this->subTypeKey );
		$this->requireAttributes( $serialization, 'value' );
		$this->assertAttributeIsArray( $serialization, 'value' );

		$specificType = $serialization[$this->subTypeKey];
		$valueSerialization = $serialization['value'];

		return $this->deserializationStrategy->getDeserializedValue( $specificType, $valueSerialization );
	}

}
