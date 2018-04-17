<?php

namespace Maps\Test;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Parsers\LatLongParser;
use Maps\Elements\Location;

/**
 * @covers MapsFinddestination
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FinddestinationTest extends ParserHookTest {

	/**
	 * @var string[]
	 */
	private $locations = [
		'4,2',
		'4.2,-42',
	];

	private $bearings = [
		1,
		42,
		-42,
		0,
		4.2,
	];

	private $distances = [
		'42' => 42,
		'0' => 0,
		'42 m' => 42,
		'42 km' => 42000,
		'4.2 km' => 4200,
	];

	/**
	 * @see ParserHookTest::parametersProvider
	 */
	public function parametersProvider() {
		$paramLists = [];

		$paramLists[] = [
			'location' => '4,2',
			'bearing' => '1',
			'distance' => '42 km'
		];

		return $this->arrayWrap( $paramLists );
	}

	/**
	 * @see ParserHookTest::processingProvider
	 */
	public function processingProvider() {
		$argLists = [];

		$coordinateParser = new LatLongParser();

		foreach ( $this->distances as $distance => $expectedDistance ) {
			foreach ( $this->bearings as $bearing ) {
				foreach ( $this->locations as $locationString ) {
					$values = [
						'distance' => (string)$distance,
						'bearing' => (string)$bearing,
						'location' => (string)$locationString,
					];

					$expected = [
						'distance' => $expectedDistance,
						'bearing' => (float)$bearing,
						'location' => new Location( $coordinateParser->parse( $locationString )->getValue() ),
					];

					$argLists[] = [ $values, $expected ];
				}
			}
		}

		return $argLists;
	}

	/**
	 * @see ParserHookTest::getInstance
	 */
	protected function getInstance() {
		return new \MapsFinddestination();
	}

}