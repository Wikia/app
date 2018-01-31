<?php

namespace Maps\Tests\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Circle;

/**
 * @covers Maps\Elements\Circle
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CircleTest extends BaseElementTest {

	/**
	 * @see BaseElementTest::getClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getClass() {
		return Circle::class;
	}

	public function validConstructorProvider() {
		$argLists = [];

		$argLists[] = [ new LatLongValue( 4, 2 ), 42 ];
		$argLists[] = [ new LatLongValue( 42, 2.2 ), 9000.1 ];
		$argLists[] = [ new LatLongValue( 4, 2 ), 1 ];
		$argLists[] = [ new LatLongValue( 4, 2 ), 0.1 ];

		return $argLists;
	}

	public function invalidConstructorProvider() {
		$argLists = [];

		$argLists[] = [ new LatLongValue( 4, 2 ), 'foo' ];

		$argLists[] = [ new LatLongValue( 4, 2 ), 0 ];
		$argLists[] = [ new LatLongValue( 4, 2 ), -42 ];

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @param Circle $circle
	 * @param array $arguments
	 */
	public function testGetCircleCentre( Circle $circle, array $arguments ) {
		$this->assertTrue( $circle->getCircleCentre()->equals( $arguments[0] ) );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @param Circle $circle
	 * @param array $arguments
	 */
	public function testGetCircleRadius( Circle $circle, array $arguments ) {
		$this->assertEquals( $arguments[1], $circle->getCircleRadius() );
	}

}



