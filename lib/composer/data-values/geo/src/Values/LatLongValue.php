<?php

namespace DataValues\Geo\Values;

use DataValues\DataValueObject;
use InvalidArgumentException;
use OutOfRangeException;

/**
 * Object representing a geographic point.
 *
 * Latitude is specified in degrees within the range [-360, 360].
 * Longitude is specified in degrees within the range [-360, 360].
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LatLongValue extends DataValueObject {

	/**
	 * The locations latitude.
	 *
	 * @since 0.1
	 *
	 * @var float
	 */
	protected $latitude;

	/**
	 * The locations longitude.
	 *
	 * @since 0.1
	 *
	 * @var float
	 */
	protected $longitude;

	/**
	 * @since 0.1
	 *
	 * @param float|int $latitude
	 * @param float|int $longitude
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $latitude, $longitude ) {
		if ( is_int( $latitude ) ) {
			$latitude = (float)$latitude;
		}

		if ( is_int( $longitude ) ) {
			$longitude = (float)$longitude;
		}

		$this->assertIsLatitude( $latitude );
		$this->assertIsLongitude( $longitude );

		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	protected function assertIsLatitude( $latitude ) {
		if ( !is_float( $latitude ) ) {
			throw new InvalidArgumentException( 'Can only construct LatLongValue with a numeric latitude' );
		}

		if ( $latitude < -360 || $latitude > 360 ) {
			throw new OutOfRangeException( 'Latitude needs to be between -360 and 360' );
		}
	}

	protected function assertIsLongitude( $longitude ) {
		if ( !is_float( $longitude ) ) {
			throw new InvalidArgumentException( 'Can only construct LatLongValue with a numeric longitude' );
		}

		if ( $longitude < -360 || $longitude > 360 ) {
			throw new OutOfRangeException( 'Longitude needs to be between -360 and 360' );
		}
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		$data = array(
			$this->latitude,
			$this->longitude
		);

		return implode( '|', $data );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @throws InvalidArgumentException
	 */
	public function unserialize( $value ) {
		$data = explode( '|', $value, 2 );

		if ( count( $data ) < 2 ) {
			throw new InvalidArgumentException( 'Invalid serialization provided in ' . __METHOD__ );
		}

		$this->__construct( (float)$data[0], (float)$data[1] );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		// TODO: This really should be 'latlong' but serializations may explode if we rename it.
		return 'geocoordinate';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getSortKey() {
		return $this->latitude;
	}

	/**
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return self
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * Returns the latitude.
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Returns the longitude.
	 *
	 * @since 0.1
	 *
	 * @return float
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @since 0.1
	 *
	 * @return float[]
	 */
	public function getArrayValue() {
		return array(
			'latitude' => $this->latitude,
			'longitude' => $this->longitude
		);
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param float[] $data
	 *
	 * @return self
	 */
	public static function newFromArray( array $data ) {
		return new static( $data['latitude'], $data['longitude'] );
	}

}
