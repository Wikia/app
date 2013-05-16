<?php
/**
 * Class that holds metadata on an image overlay.
 *
 * @since 2.0
 *
 * @file Maps_Rectangle.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 */
class MapsImageOverlay extends MapsBaseElement {


	/**
	 * @var
	 */
	protected $boundsNorthEast;

	/**
	 * @var
	 */
	protected $boundsSouthWest;

	/**
	 * @var
	 */
	protected $image;

	/**
	 *
	 */
	function __construct( $boundsNorthEast , $boundsSouthWest, $image ) {
		$this->setBoundsNorthEast( $boundsNorthEast );
		$this->setBoundsSouthWest( $boundsSouthWest );
		$this->setImage($image);
	}

	/**
	 * @return
	 */
	public function getBoundsNorthEast() {
		return $this->boundsNorthEast;
	}

	/**
	 * @param  $boundsNorthEast
	 */
	public function setBoundsNorthEast( $boundsNorthEast ) {
		$this->boundsNorthEast = new MapsLocation( $boundsNorthEast );
	}

	/**
	 * @return
	 */
	public function getBoundsSouthWest() {
		return $this->boundsSouthWest;
	}

	/**
	 * @param  $boundsSouthWest
	 */
	public function setBoundsSouthWest( $boundsSouthWest ) {
		$this->boundsSouthWest = new MapsLocation( $boundsSouthWest );
	}

	/**
	 * @param  $image
	 */
	public function setImage( $image ) {
		$this->image = $image;
	}

	/**
	 * @return
	 */
	public function getImage() {
		return $this->image;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {

		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$array = array(
			'ne' => array(
				'lon' => $this->getBoundsNorthEast()->getLongitude() ,
				'lat' => $this->getBoundsNorthEast()->getLatitude()
			) ,
			'sw' => array(
				'lon' => $this->getBoundsSouthWest()->getLongitude() ,
				'lat' => $this->getBoundsSouthWest()->getLatitude()
			),
			'image' => $this->getImage()
		);

		return array_merge( $parentArray , $array );
	}
}
