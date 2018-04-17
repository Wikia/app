<?php

namespace Maps\Elements;

use DataValues\Geo\Values\LatLongValue;
use InvalidArgumentException;

/**
 * @since 3.0
 *
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Rectangle extends \MapsBaseFillableElement {

	/**
	 * @since 3.0
	 * @var LatLongValue
	 */
	protected $rectangleNorthEast;

	/**
	 * @since 3.0
	 * @var LatLongValue
	 */
	protected $rectangleSouthWest;

	/**
	 * @since 3.0
	 *
	 * @param LatLongValue $rectangleNorthEast
	 * @param LatLongValue $rectangleSouthWest
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( LatLongValue $rectangleNorthEast, LatLongValue $rectangleSouthWest ) {
		if ( $rectangleNorthEast->equals( $rectangleSouthWest ) ) {
			throw new InvalidArgumentException( '$rectangleNorthEast cannot be equal to $rectangleSouthWest' );
		}

		parent::__construct();

		// TODO: validate bounds are correct, if not, flip
		$this->setRectangleNorthEast( $rectangleNorthEast );
		$this->setRectangleSouthWest( $rectangleSouthWest );
	}

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$parentArray = parent::getJSONObject( $defText, $defTitle );
		$array = [
			'ne' => [
				'lon' => $this->getRectangleNorthEast()->getLongitude(),
				'lat' => $this->getRectangleNorthEast()->getLatitude()
			],
			'sw' => [
				'lon' => $this->getRectangleSouthWest()->getLongitude(),
				'lat' => $this->getRectangleSouthWest()->getLatitude()
			],
		];

		return array_merge( $parentArray, $array );
	}

	public function getRectangleNorthEast(): LatLongValue {
		return $this->rectangleNorthEast;
	}

	public function setRectangleNorthEast( LatLongValue $rectangleNorthEast ) {
		$this->rectangleNorthEast = $rectangleNorthEast;
	}

	public function getRectangleSouthWest(): LatLongValue {
		return $this->rectangleSouthWest;
	}

	public function setRectangleSouthWest( LatLongValue $rectangleSouthWest ) {
		$this->rectangleSouthWest = $rectangleSouthWest;
	}

}
