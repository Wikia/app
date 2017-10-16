<?php

namespace Tests\DataValues\Geo\Parsers;

use DataValues\Geo\Parsers\DmsCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use ValueParsers\Test\StringValueParserTest;

/**
 * @covers DataValues\Geo\Parsers\DmsCoordinateParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 * @group GeoCoordinateParserTest
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DmsCoordinateParserTest extends StringValueParserTest {

	/**
	 * @deprecated since DataValues Common 0.3, just use getInstance.
	 */
	protected function getParserClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return DmsCoordinateParser
	 */
	protected function getInstance() {
		return new DmsCoordinateParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		// TODO: test with different parser options

		$valid = array(
			// Whitespace
			"1°0'0\"N 1°0'0\"E\n" => array( 1, 1 ),
			' 1°0\'0"N 1°0\'0"E ' => array( 1, 1 ),

			'55° 45\' 20.8296", 37° 37\' 3.4788"' => array( 55.755786, 37.617633 ),
			'55° 45\' 20.8296", -37° 37\' 3.4788"' => array( 55.755786, -37.617633 ),
			'-55° 45\' 20.8296", -37° 37\' 3.4788"' => array( -55.755786, -37.617633 ),
			'-55° 45\' 20.8296", 37° 37\' 3.4788"' => array( -55.755786, 37.617633 ),
			'55° 0\' 0", 37° 0\' 0"' => array( 55, 37 ),
			'55° 30\' 0", 37° 30\' 0"' => array( 55.5, 37.5 ),
			'55° 0\' 18", 37° 0\' 18"' => array( 55.005, 37.005 ),
			'0° 0\' 0", 0° 0\' 0"' => array( 0, 0 ),
			'0° 0\' 18" N, 0° 0\' 18" E' => array( 0.005, 0.005 ),
			' 0° 0\' 18" S  , 0°  0\' 18"  W ' => array( -0.005, -0.005 ),
			'55° 0′ 18″, 37° 0′ 18″' => array( 55.005, 37.005 ),

			// Coordinate strings without separator:
			'55° 45\' 20.8296" 37° 37\' 3.4788"' => array( 55.755786, 37.617633 ),
			'55 ° 45 \' 20.8296 " -37 ° 37 \' 3.4788 "' => array( 55.755786, -37.617633 ),
			'-55 ° 45 \' 20.8296 " -37° 37\' 3.4788"' => array( -55.755786, -37.617633 ),
			'55° 0′ 18″ 37° 0′ 18″' => array( 55.005, 37.005 ),

			// Coordinate string starting with direction character:
			'N 0° 0\' 18", E 0° 0\' 18"' => array( 0.005, 0.005 ),
			'S 0° 0\' 18" E 0° 0\' 18"' => array( -0.005, 0.005 ),
		);

		foreach ( $valid as $value => $expected ) {
			$expected = new LatLongValue( $expected[0], $expected[1] );
			$argLists[] = array( (string)$value, $expected );
		}

		return $argLists;
	}

	/**
	 * @see StringValueParserTest::invalidInputProvider
	 */
	public function invalidInputProvider() {
		$argLists = parent::invalidInputProvider();

		$invalid = array(
			'~=[,,_,,]:3',
			'ohi there',
		);

		foreach ( $invalid as $value ) {
			$argLists[] = array( $value );
		}

		return $argLists;
	}

}
