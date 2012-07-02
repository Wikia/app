<?php

/**
 * @group GeoData
 */
class ParseCoordTest extends MediaWikiTestCase {
	/**
	 * @dataProvider getCases
	 */
	public function testParseCoordinates( $parts, $result, $globe = 'earth' ) {
		$formatted = '"' . implode( $parts, '|' ) . '"';
		$s = GeoData::parseCoordinates( $parts, $globe );
		$val = $s->value;
		if ( $result === false ) {
			$this->assertFalse( $s->isGood(), "Parsing of $formatted was expected to fail" );
		} else {
			$msg = $s->isGood() ? '' : $s->getWikiText();
			$this->assertTrue( $s->isGood(), "Parsing of $formatted was expected to succeed, but it failed: $msg" );
			$this->assertTrue( $val->equalsTo( $result ),
				"Parsing of $formatted was expected to yield something close to"
				. " ({$result->lat}, {$result->lon}), but yielded ({$val->lat}, {$val->lon})"
			);
		}
	}

	public function getCases() {
		return array(
			// basics
			array( array( 0, 0 ), new Coord( 0, 0 ) ),
			array( array( 75, 25 ), new Coord( 75, 25 ) ),
			array( array( '20.0', '-15.5' ), new Coord( 20, -15.5 ) ),
			array( array( -20, 30, 40, 45 ), new Coord( -20.5, 40.75 ) ),
			array( array( 20, 30, 40, 40, 45, 55 ), new Coord( 20.511111111111, 40.765277777778 ) ),
			// NESW
			array( array( 20, 'N', 30, 'E' ), new Coord( 20, 30 ) ),
			array( array( 20, 'N', 30, 'W' ), new Coord( 20, -30 ) ),
			array( array( 20, 'S', 30, 'E' ), new Coord( -20, 30 ) ),
			array( array( 20, 'S', 30, 'W' ), new Coord( -20, -30 ) ),
			array( array( 20, 30, 40, 'S', 40, 45, 55, 'E' ), new Coord( -20.511111111111, 40.765277777778 ) ),
			array( array( 20, 30, 40, 'N', 40, 45, 55, 'W' ), new Coord( 20.511111111111, -40.765277777778 ) ),
			array( array( 20, 'E', 30, 'W' ), false ),
			array( array( 20, 'S', 30, 'N' ), false ),
			array( array( -20, 'S', 30, 'E' ), false ),
			array( array( 20, 'S', -30, 'W' ), false ),
			// wrong number of parameters
			array( array(), false ),
			array( array( 1 ), false ),
			array( array( 1, 2, 3 ), false ),
			array( array( 1, 2, 3, 4, 5 ), false ),
			array( array( 1, 2, 3, 4, 5, 6, 7 ), false ),
			array( array( 1, 2, 3, 4, 5, 6, 7, 8, 9 ), false ),
			array( array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ), false ),
			// unbalanced NESW
			array( array( 'N', 'E' ), false ),
			array( array( 12, 'N', 'E' ), false ),
			array( array( 'N', 15, 'E' ), false ),
			array( array( 1, 2, 3, 'N', 1, 'E' ), false ),
			array( array( 1, 2, 3, 'N', 'E' ), false ),
			array( array( 1, 2, 3, 'N', 1, 'E' ), false ),
			array( array( 1, 2, 3, 'N', 1, 2, 'E' ), false ),
			// coordinate validation (Earth)
			array( array( -90, 180 ), new Coord( -90, 180 ) ),
			array( array( 90.0000001, -180.00000001 ), false ),
			array( array( 90, 1, 180, 0 ), false ),
			array( array( 10, -1, 20, 0 ), false ),
			array( array( 25, 60, 10, 0 ), false ),
			array( array( 25, 0, 0, 10, 0, 60 ), false ),
			// @todo: only the last component of the coordinate should be non-integer
			//array( array( 10.5, 0, 20, 0 ), false ),
			//array( array( 10, 30.5, 0, 20, 0, 0 ), false ),
			// coordinate validation and normalisation (non-Earth)
			array( array( 10, 20 ), new Coord( 10, 20 ), 'mars' ),
			array( array( 110, 20 ), false, 'mars' ),
			array( array( 47, 0, 'S', 355, 3, 'W' ), new Coord( -47, 4.95 ), 'mars' ), // Asimov Crater
			array( array( 68, 'S', 357, 'E' ), new Coord( -68, 357 ), 'venus' ), // Quetzalpetlatl Corona
		);
	}
}