<?php

namespace Deserializers\Tests\Phpunit\Deserializers;

use Deserializers\TypedObjectDeserializer;

/**
 * @covers Deserializers\TypedObjectDeserializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TypedObjectDeserializerTest extends \PHPUnit_Framework_TestCase {

	const DEFAULT_TYPE_KEY = 'objectType';
	const DUMMY_TYPE_VALUE = 'someType';

	public function testGivenDefaultObjectKey_isDeserializerForReturnsTrue() {
		$serialization = $this->newStubSerializationWithTypeKey( self::DEFAULT_TYPE_KEY );
		$this->assertTrue( $this->newMockDeserializer()->isDeserializerFor( $serialization ) );
	}

	/**
	 * @param string $typeKey
	 * @return TypedObjectDeserializer
	 */
	protected function newMockDeserializer( $typeKey = self::DEFAULT_TYPE_KEY ) {
		return $this->getMockForAbstractClass(
			'Deserializers\TypedObjectDeserializer',
			array(
				self::DUMMY_TYPE_VALUE,
				$typeKey
			)
		);
	}

	protected function newStubSerializationWithTypeKey( $typeKey, $typeValue = self::DUMMY_TYPE_VALUE ) {
		return array(
			$typeKey => $typeValue
		);
	}

	public function testGivenUnknownObjectKey_isDeserializerForReturnsFalse() {
		$serialization = $this->newStubSerializationWithTypeKey( 'someNonsenseTypeKey' );
		$this->assertFalse( $this->newMockDeserializer()->isDeserializerFor( $serialization ) );
	}

	public function testGivenSpecifiedObjectKey_isDeserializerForReturnsTrue() {
		$specifiedTypeKey = 'myAwesomeTypeKey';

		$serialization = $this->newStubSerializationWithTypeKey( $specifiedTypeKey );
		$this->assertTrue( $this->newMockDeserializer( $specifiedTypeKey )->isDeserializerFor( $serialization ) );
	}

}
