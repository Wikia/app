<?php

namespace Maps\Tests\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Circle;

/**
 * @covers Maps\Elements\Circle
 *
 * @since 3.0
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
		return 'Maps\Elements\Circle';
	}

	public function validConstructorProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4, 2 ), 42 );
		$argLists[] = array( new LatLongValue( 42, 2.2 ), 9000.1 );
		$argLists[] = array( new LatLongValue( 4, 2 ), 1 );
		$argLists[] = array( new LatLongValue( 4, 2 ), 0.1 );

		return $argLists;
	}

	public function invalidConstructorProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4, 2 ), 'foo' );

		$argLists[] = array( new LatLongValue( 4, 2 ), 0 );
		$argLists[] = array( new LatLongValue( 4, 2 ), -42 );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Circle $circle
	 * @param array $arguments
	 */
	public function testGetCircleCentre( Circle $circle, array $arguments ) {
		$this->assertTrue( $circle->getCircleCentre()->equals( $arguments[0] ) );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Circle $circle
	 * @param array $arguments
	 */
	public function testGetCircleRadius( Circle $circle, array $arguments ) {
		$this->assertEquals( $arguments[1], $circle->getCircleRadius() );
	}

}



