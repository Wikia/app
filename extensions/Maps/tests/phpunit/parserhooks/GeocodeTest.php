<?php

namespace Maps\Test;

use Maps\Elements\Location;

/**
 * @covers MapsGeocode
 *
 * @group Maps
 * @group ParserHook
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeocodeTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::getInstance
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected function getInstance() {
		return new \MapsGeocode();
	}

	/**
	 * @see ParserHookTest::parametersProvider
	 * @since 2.0
	 * @return array
	 */
	public function parametersProvider() {
		$paramLists = array();

		$paramLists[] = array( 'location' => 'new york city' );

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
			'location' => '4,2',
			'allowcoordinates' => 'yes',
		);

		$expected = array(
			'location' => new Location( new \DataValues\LatLongValue( 4, 2 ) ),
			'allowcoordinates' => true,
		);

		$argLists[] = array( $values, $expected );

		return $argLists;
	}

}