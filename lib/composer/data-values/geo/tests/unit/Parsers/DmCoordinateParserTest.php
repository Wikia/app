<?php

namespace Tests\DataValues\Geo\Parsers;

use DataValues\Geo\Parsers\DmCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use ValueParsers\Test\StringValueParserTest;

/**
 * @covers DataValues\Geo\Parsers\DmCoordinateParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 * @group GeoCoordinateParserTest
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DmCoordinateParserTest extends StringValueParserTest {

	/**
	 * @deprecated since DataValues Common 0.3, just use getInstance.
	 */
	protected function getParserClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return DmCoordinateParser
	 */
	protected function getInstance() {
		return new DmCoordinateParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		// TODO: test with different parser options

		$valid = array(
			// Whitespace
			"1°0'N 1°0'E\n" => array( 1, 1 ),
			" 1°0'N 1°0'E " => array( 1, 1 ),

			"55° 0', 37° 0'" => array( 55, 37 ),
			"55° 30', 37° 30'" => array( 55.5, 37.5 ),
			"0° 0', 0° 0'" => array( 0, 0 ),
			"-55° 30', -37° 30'" => array( -55.5, -37.5 ),
			"0° 0.3' S, 0° 0.3' W" => array( -0.005, -0.005 ),
			"55° 30′, 37° 30′" => array( 55.5, 37.5 ),

			// Coordinate strings without separator:
			"55° 0' 37° 0'" => array( 55, 37 ),
			"55 ° 30 ' 37 ° 30 '" => array( 55.5, 37.5 ),
			"0° 0' 0° 0'" => array( 0, 0 ),
			"-55° 30 ' -37 ° 30'" => array( -55.5, -37.5 ),
			"0° 0.3' S 0° 0.3' W" => array( -0.005, -0.005 ),
			"55° 30′ 37° 30′" => array( 55.5, 37.5 ),

			// Coordinate string starting with direction character:
			"S 0° 0.3', W 0° 0.3'" => array( -0.005, -0.005 ),
			"N 0° 0.3' E 0° 0.3'" => array( 0.005, 0.005 ),
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
