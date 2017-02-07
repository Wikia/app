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
	protected $circleCentre;

	/**
	 * @var integer|float
	 */
	protected $circleRadius;

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

	/**
	 * @return LatLongValue
	 */
	public function getCircleCentre() {
		return $this->circleCentre;
	}

	/**
	 * @param LatLongValue $circleCentre
	 */
	public function setCircleCentre( LatLongValue $circleCentre ) {
		$this->circleCentre = $circleCentre;
	}

	/**
	 * @return integer|float
	 */
	public function getCircleRadius() {
		return $this->circleRadius;
	}

	/**
	 * @param integer|float $circleRadius
	 */
	public function setCircleRadius( $circleRadius ) {
		$this->circleRadius = $circleRadius;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );

		$array = array(
			'centre' => array(
				'lon' => $this->getCircleCentre()->getLongitude(),
				'lat' => $this->getCircleCentre()->getLatitude()
			) ,
			'radius' => intval( $this->getCircleRadius() ),
		);

		return array_merge( $parentArray, $array );
	}

}
