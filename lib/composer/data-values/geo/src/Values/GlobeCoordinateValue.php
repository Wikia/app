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
 * @author Thiemo Mättig
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

	/**
	 * Wikidata concept URI for the Earth. Used as default value when no other globe was specified.
	 */
	const GLOBE_EARTH = 'http://www.wikidata.org/entity/Q2';

	/**
	 * @param LatLongValue $latLong
	 * @param float|int|null $precision in degrees, e.g. 0.01.
	 * @param string|null $globe IRI, defaults to 'http://www.wikidata.org/entity/Q2'.
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( LatLongValue $latLong, $precision = null, $globe = null ) {
		$this->assertIsPrecision( $precision );

		if ( $globe === null ) {
			$globe = self::GLOBE_EARTH;
		} elseif ( !is_string( $globe ) || $globe === '' ) {
			throw new IllegalValueException( '$globe must be a non-empty string or null' );
		}

		$this->latLong = $latLong;
		$this->precision = $precision;
		$this->globe = $globe;
	}

	/**
	 * @see LatLongValue::assertIsLatitude
	 * @see LatLongValue::assertIsLongitude
	 *
	 * @param float|int|null $precision
	 *
	 * @throws IllegalValueException
	 */
	private function assertIsPrecision( $precision ) {
		if ( $precision !== null ) {
			if ( !is_float( $precision ) && !is_int( $precision ) ) {
				throw new IllegalValueException( '$precision must be a number or null' );
			} elseif ( $precision < -360 || $precision > 360 ) {
				throw new IllegalValueException( '$precision needs to be between -360 and 360' );
			}
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
	 * @return float
	 */
	public function getLatitude() {
		return $this->latLong->getLatitude();
	}

	/**
	 * @return float
	 */
	public function getLongitude() {
		return $this->latLong->getLongitude();
	}

	/**
	 * @see DataValue::getValue
	 *
	 * @return self
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * @return LatLongValue
	 */
	public function getLatLong() {
		return $this->latLong;
	}

	/**
	 * Returns the precision of the coordinate in degrees, e.g. 0.01.
	 *
	 * @return float|int|null
	 */
	public function getPrecision() {
		return $this->precision;
	}

	/**
	 * Returns the IRI of the globe on which the location resides.
	 *
	 * @return string
	 */
	public function getGlobe() {
		return $this->globe;
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public function getHash() {
		return md5( $this->latLong->getLatitude() . '|'
			. $this->latLong->getLongitude() . '|'
			. $this->precision . '|'
			. $this->globe );
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return array
	 */
	public function getArrayValue() {
		return [
			'latitude' => $this->latLong->getLatitude(),
			'longitude' => $this->latLong->getLongitude(),

			// The altitude field is no longer used in this class.
			// It is kept here for compatibility reasons.
			'altitude' => null,

			'precision' => $this->precision,
			'globe' => $this->globe,
		];
	}

	/**
	 * Constructs a new instance from the provided data. Required for @see DataValueDeserializer.
	 * This is expected to round-trip with @see getArrayValue.
	 *
	 * @deprecated since 2.0.1. Static DataValue::newFromArray constructors like this are
	 *  underspecified (not in the DataValue interface), and misleadingly named (should be named
	 *  newFromArrayValue). Instead, use DataValue builder callbacks in @see DataValueDeserializer.
	 *
	 * @param mixed $data Warning! Even if this is expected to be a value as returned by
	 *  @see getArrayValue, callers of this specific newFromArray implementation can not guarantee
	 *  this. This is not even guaranteed to be an array!
	 *
	 * @throws IllegalValueException if $data is not in the expected format. Subclasses of
	 *  InvalidArgumentException are expected and properly handled by @see DataValueDeserializer.
	 * @return self
	 */
	public static function newFromArray( $data ) {
		self::requireArrayFields( $data, [ 'latitude', 'longitude' ] );

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
