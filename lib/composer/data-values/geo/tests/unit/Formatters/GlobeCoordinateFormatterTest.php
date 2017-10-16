<?php

namespace Tests\DataValues\Geo\Formatters;

use DataValues\Geo\Formatters\GeoCoordinateFormatter;
use DataValues\Geo\Formatters\GlobeCoordinateFormatter;
use DataValues\Geo\Parsers\GlobeCoordinateParser;
use DataValues\Geo\Values\GlobeCoordinateValue;
use DataValues\Geo\Values\LatLongValue;
use ValueFormatters\FormatterOptions;
use ValueFormatters\Test\ValueFormatterTestBase;
use ValueParsers\ParserOptions;

/**
 * @covers DataValues\Geo\Formatters\GlobeCoordinateFormatter
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GlobeCoordinateFormatterTest extends ValueFormatterTestBase {

	/**
	 * @deprecated since DataValues Interfaces 0.2, just use getInstance.
	 */
	protected function getFormatterClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueFormatterTestBase::getInstance
	 *
	 * @param FormatterOptions|null $options
	 *
	 * @return GlobeCoordinateFormatter
	 */
	protected function getInstance( FormatterOptions $options = null ) {
		return new GlobeCoordinateFormatter( $options );
	}

	/**
	 * @see ValueFormatterTestBase::validProvider
	 */
	public function validProvider() {
		$floats = array(
			'55.755786, -37.617633' => array( 55.755786, -37.617633, 0.000001 ),
			'-55.7558, 37.6176' => array( -55.755786, 37.617633, 0.0001 ),
			'-55, -38' => array( -55, -37.617633, 1 ),
			'5.5, 37' => array( 5.5, 37, 0.1 ),
			'0, 0' => array( 0, 0, 1 ),
		);

		$decimalDegrees = array(
			'55.755786°, 37.617633°' => array( 55.755786, 37.617633, 0.000001 ),
			'55.7558°, -37.6176°' => array( 55.755786, -37.617633, 0.0001 ),
			'-55°, -38°' => array( -55, -37.617633, 1 ),
			'-5.5°, -37.0°' => array( -5.5, -37, 0.1 ),
			'0°, 0°' => array( 0, 0, 1 ),
		);

		$dmsCoordinates = array(
			'55° 45\' 20.830", 37° 37\' 3.479"' => array( 55.755786, 37.617633, 0.000001 ),
			'55° 45\' 20.830", -37° 37\' 3.479"' => array( 55.755786, -37.617633, 0.000001 ),
			'-55° 45\' 20.9", -37° 37\' 3.4"' => array( -55.755786, -37.617633, 0.0001 ),
			'-55° 45\' 20.9", 37° 37\' 3.4"' => array( -55.755786, 37.617633, 0.0001 ),

			'55°, 37°' => array( 55, 37, 1 ),
			'55° 30\' 0", 37° 30\' 0"' => array( 55.5, 37.5, 0.01 ),
			'55° 0\' 18", 37° 0\' 18"' => array( 55.005, 37.005, 0.001 ),
			'0° 0\' 0", 0° 0\' 0"' => array( 0, 0, 0.001 ),
			'0° 0\' 18", 0° 0\' 18"' => array( 0.005, 0.005, 0.001 ),
			'-0° 0\' 18", -0° 0\' 18"' => array( -0.005, -0.005, 0.001 ),
		);

		$dmCoordinates = array(
			'55°, 37°' => array( 55, 37, 1 ),
			'0°, 0°' => array( 0, 0, 1 ),
			'55° 31\', 37° 31\'' => array( 55.5, 37.5, 0.04 ),
			'-55° 31\', -37° 31\'' => array( -55.5, -37.5, 0.04 ),
			'-0° 0.3\', -0° 0.3\'' => array( -0.005, -0.005, 0.005 ),
		);

		$argLists = array();

		$tests = array(
			GeoCoordinateFormatter::TYPE_FLOAT => $floats,
			GeoCoordinateFormatter::TYPE_DD => $decimalDegrees,
			GeoCoordinateFormatter::TYPE_DMS => $dmsCoordinates,
			GeoCoordinateFormatter::TYPE_DM => $dmCoordinates,
		);

		$i = 0;
		foreach ( $tests as $format => $coords ) {
			foreach ( $coords as $expectedOutput => $arguments ) {
				$options = new FormatterOptions();
				$options->setOption( GeoCoordinateFormatter::OPT_FORMAT, $format );

				$input = new GlobeCoordinateValue(
					new LatLongValue( $arguments[0], $arguments[1] ),
					$arguments[2]
				);

				$key = "[$i] $format: $expectedOutput";
				$argLists[$key] = array( $input, $expectedOutput, $options );

				$i++;
			}
		}

		return $argLists;
	}

	public function testFormatWithInvalidPrecision_fallsBackToDefaultPrecision() {
		$options = new FormatterOptions();
		$options->setOption( GeoCoordinateFormatter::OPT_PRECISION, 0 );
		$formatter = new GlobeCoordinateFormatter( $options );

		$formatted = $formatter->format( new GlobeCoordinateValue( new LatLongValue( 1.2, 3.4 ), null ) );
		$this->assertEquals( '1.2, 3.4', $formatted );
	}

	/**
	 * @dataProvider validProvider
	 */
	public function testFormatterRoundTrip( GlobeCoordinateValue $coord, $expectedValue, FormatterOptions $options )  {
		$formatter = new GlobeCoordinateFormatter( $options );

		$parser = new GlobeCoordinateParser(
			new ParserOptions( array( 'precision' => $coord->getPrecision() ) )
		);

		$formatted = $formatter->format( $coord );
		$parsed = $parser->parse( $formatted );

		// NOTE: $parsed may be != $coord, because of rounding, so we can't compare directly.
		$formattedParsed = $formatter->format( $parsed );

		$this->assertEquals( $formatted, $formattedParsed );
	}

}
