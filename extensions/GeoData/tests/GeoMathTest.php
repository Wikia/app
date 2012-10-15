<?php

/**
 * @group GeoData
 */
class GeoMathTest extends MediaWikiTestCase {
	/**
	 * @dataProvider getDistanceData
	 */
	public function testDistance( $lat1, $lon1, $lat2, $lon2, $dist, $name ) {
		$this->assertEquals( $dist, GeoMath::distance( $lat1, $lon1, $lat2, $lon2 ), "testDistance():  $name", $dist / 1000 );
	}

	public function getDistanceData() {
		// just run against a few values from teh internets...
		return array(
			array( 55.75, 37.6167, 59.95, 30.3167, 635000, 'Moscow to St. Bumtown' ),
			array( 51.5, -0.1167, 52.35, 4.9167, 357520, 'London to Amsterdam' ),
			array( 40.7142, -74.0064, 37.775, -122.418, 4125910, 'New York to San Francisco' ),
		);
	}

	public function testRectAround() {
		for ( $i = 0; $i < 90; $i += 5 ) {
			$r = GeoMath::rectAround( $i, $i, 5000 );
			$this->assertEquals( 10000, GeoMath::distance( $i, $r['minLon'], $i, $r['maxLon'] ), 'rectAround(): test longitude', 1 );
			$this->assertEquals( 10000, GeoMath::distance( $r['minLat'], $i, $r['maxLat'], $i ), 'rectAround(): test latitude', 1 );
		}
	}

	/**
	 * @dataProvider getRectData
	 */
	public function testRectWrapAround( $lon ) {
		$r = GeoMath::rectAround( 20, $lon, 10000 );
		$this->assertGreaterThan( $r['maxLon'], $r['minLon'] );
		$this->assertGreaterThanOrEqual( -180, $r['minLon'] );
		$this->assertLessThanOrEqual( 180, $r['maxLon'] );
	}

	public function getRectData() {
		return array(
			array( 180 ),
			array( -180 ),
			array( 179.95 ),
			array( -17995 ),
		);
	}
}
