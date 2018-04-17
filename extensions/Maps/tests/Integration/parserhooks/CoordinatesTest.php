<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use ParamProcessor\ParamDefinition;

/**
 * @covers MapsCoordinates
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CoordinatesTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::parametersProvider
	 */
	public function parametersProvider() {
		$paramLists = [];

		$paramLists[] = [
			[
				'location' => '4,2',
				'format' => 'dms',
				'directional' => 'no',
			],
			'4° 0\' 0.00", 2° 0\' 0.00"'
		];

		$paramLists[] = [
			[
				'location' => '55 S, 37.6176330 W',
				'format' => 'dms',
				'directional' => 'no',
			],
			'-55° 0\' 0.00", -37° 37\' 3.48"'
		];

		$paramLists[] = [
			[
				'location' => '4,2',
				'format' => 'float',
				'directional' => 'no',
			],
			'4, 2'
		];

		$paramLists[] = [
			[
				'location' => '-4,-2',
				'format' => 'float',
				'directional' => 'yes',
			],
			'4 S, 2 W'
		];

		$paramLists[] = [
			[
				'location' => '55 S, 37.6176330 W',
				'directional' => 'yes',
			],
			'55° 0\' 0.00" S, 37° 37\' 3.48" W'
		];

		return $paramLists;
	}

	/**
	 * @see ParserHookTest::processingProvider
	 */
	public function processingProvider() {
		$definitions = ParamDefinition::getCleanDefinitions( $this->getInstance()->getParamDefinitions() );
		$argLists = [];

		$values = [
			'location' => '4,2',
		];

		$expected = [
			'location' => new LatLongValue( 4, 2 ),
		];

		$argLists[] = [ $values, $expected ];

		$values = [
			'location' => '4,2',
			'directional' => $definitions['directional']->getDefault() ? 'no' : 'yes',
			'format' => 'dd',
		];

		$expected = [
			'location' => new LatLongValue( 4, 2 ),
			'directional' => !$definitions['directional']->getDefault(),
			'format' => Maps_COORDS_DD,
		];

		$argLists[] = [ $values, $expected ];

		$values = [
			'location' => '4,2',
			'directional' => $definitions['directional']->getDefault() ? 'NO' : 'YES',
			'format' => ' DD ',
		];

		$expected = [
			'location' => new LatLongValue( 4, 2 ),
			'directional' => !$definitions['directional']->getDefault(),
			'format' => Maps_COORDS_DD,
		];

		$argLists[] = [ $values, $expected ];

		return $argLists;
	}

	/**
	 * @see ParserHookTest::getInstance
	 */
	protected function getInstance() {
		return new \MapsCoordinates();
	}

}