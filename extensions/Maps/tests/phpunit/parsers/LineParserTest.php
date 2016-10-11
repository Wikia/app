<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Line;

/**
 * @covers Maps\LineParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LineParserTest extends \ValueParsers\Test\StringValueParserTest {

	/**
	 * @see ValueParserTestBase::validInputProvider
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array();

		$valid[] = array(
			array(
				42,
				4.2
			),
		);

		$valid[] = array(
			array(
				49.83798245308486,
				2.724609375
			),
			array(
				52.05249047600102,
				8.26171875
			),
			array(
				46.37725420510031,
				6.15234375
			),
			array(
				49.83798245308486,
				2.724609375
			),
		);

		foreach ( $valid as $values ) {
			$input = array();
			$output = array();

			foreach ( $values as $value ) {
				$input[] = implode( ',', $value );
				$output[] = new LatLongValue( $value[0], $value[1] );
			}

			$input = implode( ':', $input );

			$argLists[] = array( $input, new Line( $output ) );
		}

		return $argLists;
	}

	/**
	 * @see ValueParserTestBase::getParserClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	protected function getParserClass() {
		return 'Maps\LineParser';
	}

	/**
	 * @see ValueParserTestBase::requireDataValue
	 *
	 * @since 3.0
	 *
	 * @return boolean
	 */
	protected function requireDataValue() {
		return false;
	}

}
