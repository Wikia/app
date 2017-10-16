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
class ImageOverlay extends Rectangle {

	/**
	 * @var string
	 */
	private $imageUrl;

	/**
	 * Constructor.
	 *
	 * @since 3.0
	 *
	 * @param LatLongValue $boundsNorthEast
	 * @param LatLongValue $boundsSouthWest
	 * @param string $image
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( LatLongValue $boundsNorthEast, LatLongValue $boundsSouthWest, $image ) {
		if ( !is_string( $image ) ) {
			throw new InvalidArgumentException( '$image must be a string' );
		}

		parent::__construct( $boundsNorthEast, $boundsSouthWest );
		$this->imageUrl = $image;
	}

	/**
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getImage() {
		return $this->imageUrl;
	}

	/**
	 * @since 3.0
	 *
	 * @param string $defText
	 * @param string $defTitle
	 *
	 * @return array
	 */
	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		$data = parent::getJSONObject( $defText , $defTitle );

		$data['image'] = $this->imageUrl;

		return $data;
	}

}
