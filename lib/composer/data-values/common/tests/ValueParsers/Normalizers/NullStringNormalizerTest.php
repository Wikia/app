<?php

namespace ValueParsers\Normalizers\Test;

use DataValues\DataValue;
use DataValues\StringValue;
use PHPUnit_Framework_TestCase;
use ValueParsers\Normalizers\NullStringNormalizer;

/**
 * @covers ValueParsers\Normalizers\NullStringNormalizer
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Thiemo Mättig
 */
class NullStringNormalizerTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider stringProvider
	 */
	public function testNormalize( $value ) {
		$normalizer = new NullStringNormalizer();
		$this->assertSame( $value, $normalizer->normalize( $value ) );
	}

	public function stringProvider() {
		return array(
			array( '' ),
			array( 'a' ),
			array( ' a ' ),
		);
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	public function testNormalizeException( $value ) {
		$normalizer = new NullStringNormalizer();
		$this->setExpectedException( 'InvalidArgumentException' );
		$normalizer->normalize( $value );
	}

	public function invalidValueProvider() {
		return array(
			array( null ),
			array( true ),
			array( 1 ),
			array( new StringValue( '' ) ),
		);
	}

}
