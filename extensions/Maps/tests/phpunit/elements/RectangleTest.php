<?php

namespace Maps\Tests\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Rectangle;

/**
 * @covers Maps\Elements\Rectangle
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class RectangleTest extends BaseElementTest {

	/**
	 * @see BaseElementTest::getClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getClass() {
		return 'Maps\Elements\Rectangle';
	}

	public function validConstructorProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4, 2 ), new LatLongValue( -4, -2 ) );
		$argLists[] = array( new LatLongValue( -42, -42 ), new LatLongValue( -4, -2 ) );

		return $argLists;
	}

	public function invalidConstructorProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4, 2 ), new LatLongValue( 4, 2 ) );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Rectangle $rectangle
	 * @param array $arguments
	 */
	public function testGetCorners( Rectangle $rectangle, array $arguments ) {
		$this->assertTrue( $rectangle->getRectangleNorthEast()->equals( $arguments[0] ) );
		$this->assertTrue( $rectangle->getRectangleSouthWest()->equals( $arguments[1] ) );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Rectangle $rectangle
	 * @param array $arguments
	 */
	public function testSetCorners( Rectangle $rectangle, array $arguments ) {
		$coordinates = array(
			new LatLongValue( 42, 42 ),
			new LatLongValue( 0, 0 )
		);

		foreach ( $coordinates as $coordinate ) {
			$rectangle->setRectangleNorthEast( $coordinate );
			$this->assertTrue( $rectangle->getRectangleNorthEast()->equals( $coordinate ) );

			$rectangle->setRectangleSouthWest( $coordinate );
			$this->assertTrue( $rectangle->getRectangleSouthWest()->equals( $coordinate ) );
		}
	}

}



