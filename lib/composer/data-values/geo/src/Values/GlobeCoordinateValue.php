<?php

namespace DataValues\Geo\Values;

use DataValues\DataValueObject;
use DataValues\IllegalValueException;

/**
 * Class representing a geographical coordinate value.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GlobeCoordinateValue extends DataValueObject {

	/**
	 * @var LatLongValue
	 */
	private $latLong;

	/**
	 * The precision of the coordinate in degrees, e.g. 0.01.
	 *
	 * @var float|int|null
	 */
	private $precision;

	/**
	 * IRI of the globe on which the location resides.
	 *
	 * @var string
	 */
	private $globe;

	const GLOBE_EARTH = 'http://www.wikidata.org/entity/Q2';

	/**
	 * @param LatLongValue $latLong
	 * @param float|int|null $precision in degrees, e.g. 0.01.
	 * @param string|null $globe IRI, defaults to 'http://www.wikidata.org/entity/Q2'.
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( LatLongValue $latLong, $precision, $globe = null ) {
		if ( $globe === null ) {
			$globe = self::GLOBE_EARTH;
		}

		$this->assertIsPrecision( $precision );
		$this->assertIsGlobe( $globe );

		$this->latLong = $latLong;
		$this->precision = $precision;
		$this->globe = $globe;
	}

	protected function assertIsPrecision( $precision ) {
		if ( !is_null( $precision ) && !is_float( $precision ) && !is_int( $precision ) ) {
			throw new IllegalValueException( 'Can only construct GlobeCoordinateValue with a numeric precision or null' );
		}
	}

	protected function assertIsGlobe( $globe ) {
		if ( !is_string( $globe ) ) {
			throw new IllegalValueException( 'Can only construct GlobeCoordinateValue with a string globe parameter' );
		}
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return json_encode( array_values( $this->getArrayValue() ) );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 *
	 * @throws IllegalValueException
	 */
	public function unserialize( $value ) {
		list( $latitude, $longitude, $altitude, $precision, $globe ) = json_decode( $value );
		$this->__construct( new LatLongValue( $latitude, $longitude ), $precision, $globe );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'globecoordinate';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @return float
	 */
	public function getSortKey() {
		return $this->getLatitude();
	}

	/**
	 * Returns the latitude.
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getLatitude() {
		return $this->latLong->getLatitude();
	}

	/**
	 * Returns the longitude.
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getLongitude() {
		return $this->latLong->getLongitude();
	}

	/**
	 * Returns the text.
	 * @see DataValue::getValue
	 *
	 * @return self
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * @since 0.1
	 *
	 * @return LatLongValue
	 */
	public function getLatLong() {
		return $this->latLong;
	}

	/**
	 * Returns the precision of the coordinate in degrees, e.g. 0.01.
	 *
	 * @since 0.1
	 *
	 * @return float|int|null
	 */
	public function getPrecision() {
		return $this->precision;
	}

	/**
	 * Returns the IRI of the globe on which the location resides.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getGlobe() {
		return $this->globe;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return array
	 */
	public function getArrayValue() {
		return array(
			'latitude' => $this->latLong->getLatitude(),
			'longitude' => $this->latLong->getLongitude(),

			// The altitude field is no longer used in this class.
			// It is kept here for compatibility reasons.
			'altitude' => null,

			'precision' => $this->precision,
			'globe' => $this->globe,
		);
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 *
	 * @return self
	 * @throws IllegalValueException
	 */
	public static function newFromArray( array $data ) {
		self::requireArrayFields( $data, array( 'latitude', 'longitude' ) );

		return new static(
			new LatLongValue(
				$data['latitude'],
				$data['longitude']
			),
			( isset( $data['precision'] ) ) ? $data['precision'] : null,
			( isset( $data['globe'] ) ) ? $data['globe'] : null
		);
	}

}
