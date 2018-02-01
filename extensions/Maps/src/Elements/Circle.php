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
class Circle extends \MapsBaseFillableElement {

	/**
	 * @var LatLongValue
	 */
	private $circleCentre;

	/**
	 * @var integer|float
	 */
	private $circleRadius;

	/**
	 * @param LatLongValue $circleCentre
	 * @param integer|float $circleRadius
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( LatLongValue $circleCentre, $circleRadius ) {
		if ( !is_float( $circleRadius ) && !is_int( $circleRadius ) ) {
			throw new InvalidArgumentException( '$circleRadius must be a float or int' );
		}

		if ( $circleRadius <= 0 ) {
			throw new InvalidArgumentException( '$circleRadius must be greater than zero' );
		}

		parent::__construct();

		$this->setCircleCentre( $circleCentre );
		$this->setCircleRadius( $circleRadius );
	}

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$parentArray = parent::getJSONObject( $defText, $defTitle );

		$array = [
			'centre' => [
				'lon' => $this->getCircleCentre()->getLongitude(),
				'lat' => $this->getCircleCentre()->getLatitude()
			],
			'radius' => intval( $this->getCircleRadius() ),
		];

		return array_merge( $parentArray, $array );
	}

	public function getCircleCentre(): LatLongValue {
		return $this->circleCentre;
	}

	public function setCircleCentre( LatLongValue $circleCentre ) {
		$this->circleCentre = $circleCentre;
	}

	public function getCircleRadius(): float {
		return $this->circleRadius;
	}

	public function setCircleRadius( float $circleRadius ) {
		$this->circleRadius = $circleRadius;
	}

}
