<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoders\InMemoryGeocoder;

/**
 * @covers MapsGeocode
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeocodeTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::parametersProvider
	 */
	public function parametersProvider() {
		$paramLists = [];

		$paramLists[] = [ 'location' => 'New York', '4, 2' ];
		$paramLists[] = [ 'location' => 'Brussels', '2, 3' ];
		$paramLists[] = [ 'location' => 'I am a tomato', 'Geocoding failed' ];

		return $this->arrayWrap( $paramLists );
	}

	/**
	 * @see ParserHookTest::processingProvider
	 */
	public function processingProvider() {
		$argLists = [];

		$argLists[] = [
			[
				'location' => '4,2',
				'directional' => 'yes',
			],
			[
				'location' => '4,2',
				'directional' => true,
			]
		];

		return $argLists;
	}

	/**
	 * @see ParserHookTest::getInstance
	 */
	protected function getInstance() {
		return new \MapsGeocode(
			new InMemoryGeocoder(
				[
					'New York' => new LatLongValue( 4, 2 ),
					'Brussels' => new LatLongValue( 2, 3 ),
				]
			)
		);
	}

}