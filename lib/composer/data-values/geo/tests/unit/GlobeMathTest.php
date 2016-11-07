<?php

namespace Tests\DataValues\Geo;

use DataValues\Geo\GlobeMath;
use DataValues\Geo\Values\GlobeCoordinateValue;
use DataValues\Geo\Values\LatLongValue;

/**
 * @covers DataValues\Geo\GlobeMath
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Thiemo Mättig
 */
class GlobeMathTest extends \PHPUnit_Framework_TestCase {

	const EPSILON = 0.0000000000001;

	/**
	 * @var GlobeMath
	 */
	private $math;

	protected function setUp() {
		$this->math = new GlobeMath();
	}

	public function globeProvider() {
		return array(
			array( 'http://www.wikidata.org/entity/Q2', null ),
			array( 'http://www.wikidata.org/entity/Q2', false ),
			array( 'http://www.wikidata.org/entity/Q2', '' ),
			array( 'Vulcan', 'Vulcan' ),
		);
	}

	/**
	 * @dataProvider globeProvider
	 */
	public function testNormalizeGlobe( $expected, $globe ) {
		$normalized = $this->math->normalizeGlobe( $globe );

		$this->assertEquals( $expected, $normalized );
	}

	public function latLongProvider() {
		// Reminder: On Earth, latitude increases from south to north, longitude increases from
		// west to east. For other globes see http://planetarynames.wr.usgs.gov/TargetCoordinates
		return array(
			// Yes, there really are nine ways to describe the same point
			array( 0, 0,    0,    0 ),
			array( 0, 0,    0,  360 ),
			array( 0, 0,    0, -360 ),
			array( 0, 0,  360,    0 ),
			array( 0, 0, -360,    0 ),
			array( 0, 0,  180,  180 ),
			array( 0, 0,  180, -180 ),
			array( 0, 0, -180,  180 ),
			array( 0, 0, -180, -180 ),

			// Earth (default) vs. other globes
			array( 0, -10, 0, -10 ),
			array( 0, 350, 0, -10, 'Vulcan' ),
			array( 0, -10, 0, 350 ),
			array( 0, 350, 0, 350, 'Vulcan' ),

			// Make sure the methods do not simply return true
			array( 0, 0,   0,  180, null, false ),
			array( 0, 0,   0, -180, null, false ),
			array( 0, 0, 180,    0, null, false ),
			array( 0, 0, 180,  360, null, false ),

			// Dark side of the Moon, erm Earth
			array( 0, -180,    0,  180 ),
			array( 0, -180,    0, -180 ),
			array( 0, -180,  180,    0 ),
			array( 0, -180, -180,    0 ),
			array( 0, -180, -360, -180 ),

			// Half way to the north pole
			array( 45, 0,  45, -360 ),
			array( 45, 0, 135,  180 ),
			array( 45, 0, 135, -180 ),

			// North pole is a special case, drop longitude
			array(  90,  0,   90, -123 ),
			array(  90,  0, -270,    0 ),
			array(  90,  0, -270,  180 ),
			array(  90,  0,  -90,    0, null, false ),
			// Same for south pole
			array( -90,  0,  -90,  123 ),
			array( -90,  0,  270,    0 ),
			array( -90,  0,  270, -180 ),

			// Make sure we cover all cases in the code
			array(  10, 10,   10,   10 ),
			array(  10, 10,   10, -350 ),
			array(  10, 10,  -10,  -10, null, false ),
			array( -10,  0,  190,  180 ),
			array(  10,  0, -190,  180 ),
			array( -80,  0, -100,  180 ),
			array(  80,  0,  100,  180 ),

			// Make sure nobody casts to integer
			array( 1.234, -9.3, 178.766, -189.3 ),

			// Avoid messing with precision if not necessary
			array( 0.3, 0.3, 0.3, 0.3 ),

			// IEEE 754
			array( -0.3, -0.3,  359.7,  359.7 ),
			array(  0.3,  0.3, -359.7, -359.7 ),
			array(  0.3, -0.3,  179.7,  179.7 ),
			array( -0.3,  0.3, -179.7, -179.7 ),
		);
	}

	/**
	 * @dataProvider latLongProvider
	 */
	public function testNormalizeGlobeCoordinate(
		$expectedLat, $expectedLon,
		$lat, $lon,
		$globe = null,
		$expectedEquality = true
	) {
		$expectedLatLong = new LatLongValue( $expectedLat, $expectedLon );
		$latLong = new LatLongValue( $lat, $lon );
		if ( $globe === null ) {
			$globe = GlobeCoordinateValue::GLOBE_EARTH;
		}
		$coordinate = new GlobeCoordinateValue( $latLong, null, $globe );

		$normalized = $this->math->normalizeGlobeCoordinate( $coordinate );

		$equality = $this->equals( $expectedLatLong, $normalized->getLatLong() );
		$this->assertEquals( $expectedEquality, $equality );
	}

	/**
	 * @dataProvider latLongProvider
	 */
	public function testNormalizeGlobeLatLong(
		$expectedLat, $expectedLon,
		$lat, $lon,
		$globe = null,
		$expectedEquality = true
	) {
		$expectedLatLong = new LatLongValue( $expectedLat, $expectedLon );
		$latLong = new LatLongValue( $lat, $lon );

		$normalized = $this->math->normalizeGlobeLatLong( $latLong, $globe );

		$equality = $this->equals( $expectedLatLong, $normalized );
		$this->assertEquals( $expectedEquality, $equality );
	}

	/**
	 * @dataProvider latLongProvider
	 */
	public function testNormalizeLatLong(
		$expectedLat, $expectedLon,
		$lat, $lon,
		$globe = null,
		$expectedEquality = true
	) {
		$expectedLatLong = new LatLongValue( $expectedLat, $expectedLon );
		$latLong = new LatLongValue( $lat, $lon );
		$minimumLongitude = $globe === null ? -180 : 0;

		$normalized = $this->math->normalizeLatLong( $latLong, $minimumLongitude );

		$equality = $this->equals( $expectedLatLong, $normalized );
		$this->assertEquals( $expectedEquality, $equality );
	}

	private function equals( LatLongValue $a, LatLongValue $b ) {
		return abs( $a->getLatitude()  - $b->getLatitude()  ) < self::EPSILON
			&& abs( $a->getLongitude() - $b->getLongitude() ) < self::EPSILON;
	}

}
