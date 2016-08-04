<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;

/**
 * @covers MapsGeodistance
 *
 * @group Maps
 * @group ParserHook
 * @group GeodistanceTest
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeodistanceTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::getInstance
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected function getInstance() {
		return new \MapsGeodistance();
	}

	/**
	 * @see ParserHookTest::parametersProvider
	 * @since 2.0
	 * @return array
	 */
	public function parametersProvider() {
		$paramLists = array();

		$paramLists[] = array(
			'location1' => '4,2',
			'location2' => '42,0',
		);

		$paramLists[] = array(
			'4,2',
			'42,0',
		);

		return $this->arrayWrap( $paramLists );
	}

	/**
	 * @see ParserHookTest::processingProvider
	 * @since 3.0
	 * @return array
	 */
	public function processingProvider() {
		$argLists = array();

		$values = array(
			'location1' => '4,2',
			'location2' => '42,0',
		);

		$expected = array(
			'location1' => new Location( new LatLongValue( 4, 2 ) ),
			'location2' => new Location( new LatLongValue( 42, 0 ) ),
		);

		$argLists[] = array( $values, $expected );

		$values = array(
			'location1' => '4,2',
			'location2' => '42,0',
			'unit' => '~=[,,_,,]:3',
			'decimals' => '1',
		);

		$expected = array(
			'location1' => new Location( new LatLongValue( 4, 2 ) ),
			'location2' => new Location( new LatLongValue( 42, 0 ) ),
			'decimals' => 1,
		);

		$argLists[] = array( $values, $expected );

		return $argLists;
	}

}