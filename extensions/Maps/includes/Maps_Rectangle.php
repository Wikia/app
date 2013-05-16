<?php
/**
 * Class that holds metadata on rectangles made up by locations on map.
 *
 * @since 2.0
 *
 * @file Maps_Rectangle.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsRectangle extends MapsBaseFillableElement {

	/**
	 * @since 2.0
	 * @var MapsLocation
	 */
	protected $rectangleNorthEast;

	/**
	 * @since 2.0
	 * @var MapsLocation
	 */
	protected $rectangleSouthWest;

	/**
	 * @since 2.0
	 *
	 * @param $rectangleNorthEast
	 * @param $rectangleSouthWest
	 */
	public function __construct( $rectangleNorthEast , $rectangleSouthWest ) {
		$this->setRectangleNorthEast( $rectangleNorthEast );
		$this->setRectangleSouthWest( $rectangleSouthWest );
	}

	/**
	 * @since 2.0
	 *
	 * @return MapsLocation
	 */
	public function getRectangleNorthEast() {
		return $this->rectangleNorthEast;
	}

	/**
	 * @since 2.0
	 *
	 * @return MapsLocation
	 */
	public function getRectangleSouthWest() {
		return $this->rectangleSouthWest;
	}

	/**
	 * @since 2.0
	 *
	 * @param $rectangleSouthWest
	 */
	public function setRectangleSouthWest( $rectangleSouthWest ) {
		$this->rectangleSouthWest = new MapsLocation( $rectangleSouthWest );
	}

	/**
	 * @since 2.0
	 *
	 * @param $rectangleNorthEast
	 */
	public function setRectangleNorthEast( $rectangleNorthEast ) {
		$this->rectangleNorthEast = new MapsLocation( $rectangleNorthEast );
	}

	/**
	 * @since 2.0
	 *
	 * @param string $defText
	 * @param string $defTitle
	 *
	 * @return array
	 */
	public function getJSONObject( $defText = '' , $defTitle = '' ) {

		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$array = array(
			'ne' => array(
				'lon' => $this->getRectangleNorthEast()->getLongitude() ,
				'lat' => $this->getRectangleNorthEast()->getLatitude()
			) ,
			'sw' => array(
				'lon' => $this->getRectangleSouthWest()->getLongitude() ,
				'lat' => $this->getRectangleSouthWest()->getLatitude()
			) ,
		);

		return array_merge( $parentArray , $array );
	}

	/**
	 * Returns if the rectangle is valid.
	 *
	 * @since 2.0
	 *
	 * @return boolean
	 */
	public function isValid() {
		return $this->rectangleSouthWest->isValid() && $this->rectangleNorthEast->isValid();
	}

}
