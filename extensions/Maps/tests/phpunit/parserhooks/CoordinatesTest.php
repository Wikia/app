<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use ParamProcessor\ParamDefinition;

/**
 * @covers MapsCoordinates
 *
 * @group Maps
 * @group ParserHook
 * @group CoordinatesTest
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CoordinatesTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::getInstance
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected function getInstance() {
		return new \MapsCoordinates();
	}

	/**
	 * @see ParserHookTest::parametersProvider
	 * @since 2.0
	 * @return array
	 */
	public function parametersProvider() {
		$paramLists = array();

		$paramLists[] = array(
			array(
				'location' => '4,2',
				'format' => 'dms',
				'directional' => 'no',
			),
			'4° 0\' 0.00", 2° 0\' 0.00"'
		);

		$paramLists[] = array(
			array(
				'location' => '55 S, 37.6176330 W',
				'format' => 'dms',
				'directional' => 'no',
			),
			'-55° 0\' 0.00", -37° 37\' 3.48"'
		);

		$paramLists[] = array(
			array(
				'location' => '4,2',
				'format' => 'float',
				'directional' => 'no',
			),
			'4, 2'
		);

		$paramLists[] = array(
			array(
				'location' => '-4,-2',
				'format' => 'float',
				'directional' => 'yes',
			),
			'4 S, 2 W'
		);

		$paramLists[] = array(
			array(
				'location' => '55 S, 37.6176330 W',
				'directional' => 'yes',
			),
			'55° 0\' 0.00" S, 37° 37\' 3.48" W'
		);

		return $paramLists;
	}

	/**
	 * @see ParserHookTest::processingProvider
	 * @since 3.0
	 * @return array
	 */
	public function processingProvider() {
		$definitions = ParamDefinition::getCleanDefinitions( $this->getInstance()->getParamDefinitions() );
		$argLists = array();

		$values = array(
			'location' => '4,2',
		);

		$expected = array(
			'location' => new LatLongValue( 4, 2 ),
		);

		$argLists[] = array( $values, $expected );

		$values = array(
			'location' => '4,2',
			'directional' => $definitions['directional']->getDefault() ? 'no' : 'yes',
			'format' => 'dd',
		);

		$expected = array(
			'location' => new LatLongValue( 4, 2 ),
			'directional' => !$definitions['directional']->getDefault(),
			'format' => Maps_COORDS_DD,
		);

		$argLists[] = array( $values, $expected );

		$values = array(
			'location' => '4,2',
			'directional' => $definitions['directional']->getDefault() ? 'NO' : 'YES',
			'format' => ' DD ',
		);

		$expected = array(
			'location' => new LatLongValue( 4, 2 ),
			'directional' => !$definitions['directional']->getDefault(),
			'format' => Maps_COORDS_DD,
		);

		$argLists[] = array( $values, $expected );

		return $argLists;
	}

}