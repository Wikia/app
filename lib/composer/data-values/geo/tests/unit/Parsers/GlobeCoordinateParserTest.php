<?php

namespace Tests\DataValues\Geo\Parsers;

use DataValues\Geo\Parsers\GlobeCoordinateParser;
use DataValues\Geo\Values\GlobeCoordinateValue;
use DataValues\Geo\Values\LatLongValue;
use ValueParsers\ParserOptions;
use ValueParsers\Test\StringValueParserTest;

/**
 * @covers DataValues\Geo\Parsers\GlobeCoordinateParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 * @group GeoCoordinateParserTest
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Mättig
 */
class GlobeCoordinateParserTest extends StringValueParserTest {

	/**
	 * @deprecated since DataValues Common 0.3, just use getInstance.
	 */
	protected function getParserClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueParserTestBase::getInstance
	 *
	 * @return GlobeCoordinateParser
	 */
	protected function getInstance() {
		return new GlobeCoordinateParser();
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array(
			// Whitespace
			"1N 1E\n" => array( 1, 1, 1 ),
			' 1N 1E ' => array( 1, 1, 1 ),

			// Float
			'55.7557860 N, 37.6176330 W' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860N,37.6176330W' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860, -37.6176330' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860, -37.6176330    ' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55 S, 37.6176330 W' => array( -55, -37.6176330, 0.000001 ),
			'55 S,37.6176330W' => array( -55, -37.6176330, 0.000001 ),
			'-55, -37.6176330' => array( -55, -37.6176330, 0.000001 ),
			'5.5S,37W ' => array( -5.5, -37, 0.1 ),
			'-5.5,-37 ' => array( -5.5, -37, 0.1 ),
			'-5.5 -37 ' => array( -5.5, -37, 0.1 ),
			'4,2' => array( 4, 2, 1 ),
			'5.5S 37W ' => array( -5.5, -37, 0.1 ),
			'5.5 S 37 W ' => array( -5.5, -37, 0.1 ),
			'4 2' => array( 4, 2, 1 ),
			'S5.5 W37 ' => array( -5.5, -37, 0.1 ),

			// DD
			'55.7557860° N, 37.6176330° W' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860°, -37.6176330°' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860°,-37.6176330°' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55.7557860°,-37.6176330°  ' => array( 55.7557860, -37.6176330, 0.000001 ),
			'55° S, 37.6176330 ° W' => array( -55, -37.6176330, 0.000001 ),
			'-55°, -37.6176330 °' => array( -55, -37.6176330, 0.000001 ),
			'5.5°S,37°W ' => array( -5.5, -37, 0.1 ),
			'5.5° S,37° W ' => array( -5.5, -37, 0.1 ),
			'-5.5°,-37° ' => array( -5.5, -37, 0.1 ),
			'-55° -37.6176330 °' => array( -55, -37.6176330, 0.000001 ),
			'5.5°S 37°W ' => array( -5.5, -37, 0.1 ),
			'-5.5 ° -37 ° ' => array( -5.5, -37, 0.1 ),
			'S5.5° W37°' => array( -5.5, -37, 0.1 ),
			' S 5.5° W 37°' => array( -5.5, -37, 0.1 ),

			// DMS
			'55° 45\' 20.8296", 37° 37\' 3.4788"' => array( 55.755786, 37.617633, 1 / 36000000 ),
			'55° 45\' 20.8296", -37° 37\' 3.4788"' => array( 55.755786, -37.617633, 1 / 36000000 ),
			'-55° 45\' 20.8296", -37° 37\' 3.4788"' => array( -55.755786, -37.617633, 1 / 36000000 ),
			'-55° 45\' 20.8296", 37° 37\' 3.4788"' => array( -55.755786, 37.617633, 1 / 36000000 ),
			'-55° 45\' 20.8296", 37° 37\' 3.4788"  ' => array( -55.755786, 37.617633, 1 / 36000000 ),
			'55° 0\' 0", 37° 0\' 0"' => array( 55, 37, 1 / 3600 ),
			'55° 30\' 0", 37° 30\' 0"' => array( 55.5, 37.5, 1 / 3600 ),
			'55° 0\' 18", 37° 0\' 18"' => array( 55.005, 37.005, 1 / 3600 ),
			'  55° 0\' 18", 37° 0\' 18"' => array( 55.005, 37.005, 1 / 3600 ),
			'0° 0\' 0", 0° 0\' 0"' => array( 0, 0, 1 / 3600 ),
			'0° 0\' 18" N, 0° 0\' 18" E' => array( 0.005, 0.005, 1 / 3600 ),
			' 0° 0\' 18" S  , 0°  0\' 18"  W ' => array( -0.005, -0.005, 1 / 3600 ),
			'0° 0′ 18″ N, 0° 0′ 18″ E' => array( 0.005, 0.005, 1 / 3600 ),
			'0° 0\' 18" N  0° 0\' 18" E' => array( 0.005, 0.005, 1 / 3600 ),
			' 0 ° 0 \' 18 " S   0 °  0 \' 18 "  W ' => array( -0.005, -0.005, 1 / 3600 ),
			'0° 0′ 18″ N 0° 0′ 18″ E' => array( 0.005, 0.005, 1 / 3600 ),
			'N 0° 0\' 18" E 0° 0\' 18"' => array( 0.005, 0.005, 1 / 3600 ),
			'N0°0\'18"E0°0\'18"' => array( 0.005, 0.005, 1 / 3600 ),
			'N0°0\'18" E0°0\'18"' => array( 0.005, 0.005, 1 / 3600 ),

			// DM
			'55° 0\', 37° 0\'' => array( 55, 37, 1 / 60 ),
			'55° 30\', 37° 30\'' => array( 55.5, 37.5, 1 / 60 ),
			'0° 0\', 0° 0\'' => array( 0, 0, 1 / 60 ),
			'   0° 0\', 0° 0\'' => array( 0, 0, 1 / 60 ),
			'   0° 0\', 0° 0\'  ' => array( 0, 0, 1 / 60 ),
			'-55° 30\', -37° 30\'' => array( -55.5, -37.5, 1 / 60 ),
			'0° 0.3\' S, 0° 0.3\' W' => array( -0.005, -0.005, 1 / 3600 ),
			'-55° 30′, -37° 30′' => array( -55.5, -37.5, 1 / 60 ),
			'-55 ° 30 \' -37 ° 30 \'' => array( -55.5, -37.5, 1 / 60 ),
			'0° 0.3\' S 0° 0.3\' W' => array( -0.005, -0.005, 1 / 3600 ),
			'-55° 30′ -37° 30′' => array( -55.5, -37.5, 1 / 60 ),
			'S 0° 0.3\' W 0° 0.3\'' => array( -0.005, -0.005, 1 / 3600 ),
			'S0°0.3\'W0°0.3\'' => array( -0.005, -0.005, 1 / 3600 ),
			'S0°0.3\' W0°0.3\'' => array( -0.005, -0.005, 1 / 3600 ),
		);

		foreach ( $valid as $value => $expected ) {
			$expected = new GlobeCoordinateValue( new LatLongValue( $expected[0], $expected[1] ), $expected[2] );
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

	/**
	 * @dataProvider withGlobeOptionProvider
	 */
	public function testWithGlobeOption( $expected, $value, $options = null ) {
		$parser = new GlobeCoordinateParser();

		if ( $options ) {
			$parserOptions = new ParserOptions( json_decode( $options, true ) );
			$parser->setOptions( $parserOptions );
		}

		$value = $parser->parse( $value );

		$this->assertEquals( $expected, $value );
	}

	public function withGlobeOptionProvider() {
		$data = array();

		$data[] = array(
			new GlobeCoordinateValue(
				new LatLongValue( 55.7557860, -37.6176330 ),
				0.000001,
				'http://www.wikidata.org/entity/Q2'
			),
			'55.7557860° N, 37.6176330° W',
			'{"globe":"http://www.wikidata.org/entity/Q2"}'
		);

		$data[] = array(
			new GlobeCoordinateValue(
				new LatLongValue( 60.5, 260 ),
				0.1,
				'http://www.wikidata.org/entity/Q111'
			),
			'60.5, 260',
			'{"globe":"http://www.wikidata.org/entity/Q111"}'
		);

		$data[] = array(
			new GlobeCoordinateValue(
				new LatLongValue( 40.2, 22.5 ),
				0.1,
				'http://www.wikidata.org/entity/Q2'
			),
			'40.2, 22.5',
		);

		return $data;
	}

	/**
	 * @dataProvider precisionDetectionProvider
	 */
	public function testPrecisionDetection( $value, $expected ) {
		$parser = new GlobeCoordinateParser();
		$globeCoordinateValue = $parser->parse( $value );

		$this->assertSame( $expected, $globeCoordinateValue->getPrecision() );
	}

	public function precisionDetectionProvider() {
		return array(
			// Float
			array( '10 20', 1 ),
			array( '1 2', 1 ),
			array( '1.3 2.4', 0.1 ),
			array( '1.3 20', 0.1 ),
			array( '10 2.4', 0.1 ),
			array( '1.35 2.46', 0.01 ),
			array( '1.357 2.468', 0.001 ),
			array( '1.3579 2.468', 0.0001 ),
			array( '1.00001 2.00001', 0.00001 ),
			array( '1.000001 2.000001', 0.000001 ),
			array( '1.0000001 2.0000001', 0.0000001 ),
			array( '1.00000001 2.00000001', 0.00000001 ),
			array( '1.000000001 2.000000001', 1 ),
			array( '1.555555555 2.555555555', 0.00000001 ),

			// Dd
			array( '10° 20°', 1 ),
			array( '1° 2°', 1 ),
			array( '1.3° 2.4°', 0.1 ),
			array( '1.3° 20°', 0.1 ),
			array( '10° 2.4°', 0.1 ),
			array( '1.35° 2.46°', 0.01 ),
			array( '1.357° 2.468°', 0.001 ),
			array( '1.3579° 2.468°', 0.0001 ),
			array( '1.00001° 2.00001°', 0.00001 ),
			array( '1.000001° 2.000001°', 0.000001 ),
			array( '1.0000001° 2.0000001°', 0.0000001 ),
			array( '1.00000001° 2.00000001°', 0.00000001 ),
			array( '1.000000001° 2.000000001°', 1 ),
			array( '1.555555555° 2.555555555°', 0.00000001 ),

			// Dm
			array( '1°3\' 2°4\'', 1 / 60 ),
			array( '1°3\' 2°0\'', 1 / 60 ),
			array( '1°0\' 2°4\'', 1 / 60 ),
			array( '1°3.5\' 2°4.6\'', 1 / 3600 ),
			array( '1°3.57\' 2°4.68\'', 1 / 36000 ),
			array( '1°3.579\' 2°4.68\'', 1 / 360000 ),
			array( '1°3.0001\' 2°4.0001\'', 1 / 3600000 ),
			array( '1°3.00001\' 2°4.00001\'', 1 / 36000000 ),
			array( '1°3.000001\' 2°4.000001\'', 1 / 36000000 ),
			array( '1°3.0000001\' 2°4.0000001\'', 1 / 60 ),
			array( '1°3.5555555\' 2°4.5555555\'', 1 / 36000000 ),

			// Dms
			array( '1°3\'5" 2°4\'6"', 1 / 3600 ),
			array( '1°3\'5" 2°0\'0"', 1 / 3600 ),
			array( '1°0\'0" 2°4\'6"', 1 / 3600 ),
			array( '1°3\'0" 2°4\'0"', 1 / 3600 ),
			array( '1°3\'5.7" 2°4\'6.8"', 1 / 36000 ),
			array( '1°3\'5.79" 2°4\'6.8"', 1 / 360000 ),
			array( '1°3\'5.001" 2°4\'6.001"', 1 / 3600000 ),
			array( '1°3\'5.0001" 2°4\'6.0001"', 1 / 36000000 ),
			array( '1°3\'5.00001" 2°4\'6.00001"', 1 / 3600 ),
			array( '1°3\'5.55555" 2°4\'6.55555"', 1 / 36000000 ),

			/**
			 * @fixme What do the users expect in this case, 1/3600 or 1/360000?
			 * @see https://bugzilla.wikimedia.org/show_bug.cgi?id=64820
			 */
			array( '47°42\'0.00"N, 15°27\'0.00"E', 1 / 3600 ),
		);
	}

}
