<?php

namespace Maps\Tests\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;

/**
 * @covers Maps\Elements\Location
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LocationTest extends \PHPUnit_Framework_TestCase {

	public function latLongValueProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 0, 0 ) );
		$argLists[] = array( new LatLongValue( 4, 2 ) );
		$argLists[] = array( new LatLongValue( 42, 42 ) );
		$argLists[] = array( new LatLongValue( -4.2, -42 ) );

		return $argLists;
	}

	/**
	 * @dataProvider latLongValueProvider
	 */
	public function testGivenLatLongInConstructor_getCoordinatesReturnsIt( LatLongValue $latLong ) {
		$location = new Location( $latLong );
		$this->assertTrue( $latLong->equals( $location->getCoordinates() ) );
	}

}
