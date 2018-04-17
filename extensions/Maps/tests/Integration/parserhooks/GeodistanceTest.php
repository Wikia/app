<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;

/**
 * @covers MapsGeodistance
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeodistanceTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::parametersProvider
	 */
	public function parametersProvider() {
		$paramLists = [];

		$paramLists[] = [
			'location1' => '4,2',
			'location2' => '42,0',
		];

		$paramLists[] = [
			'4,2',
			'42,0',
		];

		return $this->arrayWrap( $paramLists );
	}

	/**
	 * @see ParserHookTest::processingProvider
	 * @since 3.0
	 * @return array
	 */
	public function processingProvider() {
		$argLists = [];

		$values = [
			'location1' => '4,2',
			'location2' => '42,0',
		];

		$expected = [
			'location1' => new Location( new LatLongValue( 4, 2 ) ),
			'location2' => new Location( new LatLongValue( 42, 0 ) ),
		];

		$argLists[] = [ $values, $expected ];

		$values = [
			'location1' => '4,2',
			'location2' => '42,0',
			'unit' => '~=[,,_,,]:3',
			'decimals' => '1',
		];

		$expected = [
			'location1' => new Location( new LatLongValue( 4, 2 ) ),
			'location2' => new Location( new LatLongValue( 42, 0 ) ),
			'decimals' => 1,
		];

		$argLists[] = [ $values, $expected ];

		return $argLists;
	}

	/**
	 * @see ParserHookTest::getInstance
	 */
	protected function getInstance() {
		return new \MapsGeodistance();
	}

}