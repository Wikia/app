<?php

/**
 * @group GeoData
 */
class MiscGeoDataTest extends MediaWikiTestCase {
	/**
	 * @dataProvider getIntRangeData
	 */
	public function testIntRange( $min, $max, $expected ) {
		$this->assertEquals( $expected, ApiQueryGeoSearch::intRange( $min, $max ) );
	}

	public function getIntRangeData() {
		return array(
			array( 37.697, 37.877, array( 377, 378, 379 ) ),
			array( 9.99, 10.01, array( 100 ) ),
			array( 179.9, -179.9, array( -1800, -1799, 1799, 1800 ) )
		);
	}
}
