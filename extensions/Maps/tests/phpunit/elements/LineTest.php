<?php

namespace Maps\Tests\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Line;

/**
 * @covers Maps\Elements\Line
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LineTest extends BaseElementTest {

	/**
	 * @see BaseElementTest::getClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getClass() {
		return 'Maps\Elements\Line';
	}

	public function validConstructorProvider() {
		$argLists = array();

		$argLists[] = array( array() );
		$argLists[] = array( array( new LatLongValue( 4, 2 ) ) );

		$argLists[] = array(
			array(
				new LatLongValue( 4, 2 ),
				new LatLongValue( 2, 4 ),
				new LatLongValue( 42, 42 ),
			)
		);

		return $argLists;
	}

	public function invalidConstructorProvider() {
		$argLists = array();

		$argLists[] = array( array( '~=[,,_,,]:3' ) );
		$argLists[] = array( array( new LatLongValue( 4, 2 ), '~=[,,_,,]:3' ) );
		$argLists[] = array( array( '~=[,,_,,]:3', new LatLongValue( 4, 2 ) ) );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Line $line
	 * @param array $arguments
	 */
	public function testGetLineCoordinates( Line $line, array $arguments ) {
		$coordinates = $line->getLineCoordinates();

		$this->assertInternalType( 'array', $coordinates );
		$this->assertEquals( count( $arguments[0] ), count( $coordinates ) );

		foreach ( $coordinates as $geoCoordinate ) {
			$this->assertInstanceOf( 'DataValues\LatLongValue', $geoCoordinate );
		}
	}

}



