<?php
/**
 * Class that holds metadata on circles made up by locations on map.
 *
 * @since 2.0
 *
 * @file Maps_Circle.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 */
class MapsCircle extends MapsBaseFillableElement {

	/**
	 * @var
	 */
	protected $circleCentre;

	/**
	 * @var
	 */
	protected $circleRadius;

	/**
	 *
	 */
	function __construct( $circleCentre , $circleRadius ) {
		$this->setCircleCentre( $circleCentre );
		$this->setCircleRadius( $circleRadius );
	}

	/**
	 * @return
	 */
	public function getCircleCentre() {
		return $this->circleCentre;
	}

	/**
	 * @param  $circleCentre
	 */
	public function setCircleCentre( $circleCentre ) {
		$this->circleCentre = new MapsLocation( $circleCentre );
	}

	/**
	 * @return
	 */
	public function getCircleRadius() {
		return $this->circleRadius;
	}

	/**
	 * @param  $circleRadius
	 */
	public function setCircleRadius( $circleRadius ) {
		$this->circleRadius = $circleRadius;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {

		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$array = array(
			'centre' => array(
				'lon' => $this->getCircleCentre()->getLongitude() ,
				'lat' => $this->getCircleCentre()->getLatitude()
			) ,
			'radius' => intval( $this->getCircleRadius() ) ,
		);
		return array_merge( $parentArray , $array );
	}
}
