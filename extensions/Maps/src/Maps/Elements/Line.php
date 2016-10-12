<?php

namespace Maps\Elements;

use DataValues\Geo\Values\LatLongValue;
use InvalidArgumentException;

/**
 * Class representing a collection of LatLongValue objects forming a line.
 *
 * @since 3.0
 *
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Line extends \MapsBaseStrokableElement {

	/**
	 * @since 3.0
	 *
	 * @var LatLongValue[]
	 */
	protected $coordinates;

	/**
	 * @since 3.0
	 *
	 * @param LatLongValue[] $coordinates
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $coordinates = array() ) {
		foreach ( $coordinates as $coordinate ) {
			if ( !( $coordinate instanceof LatLongValue ) ) {
				throw new InvalidArgumentException( 'Can only construct Line with LatLongValue objects' );
			}
		}

		$this->coordinates = $coordinates;

		parent::__construct();
	}

	/**
	 * @since 3.0
	 *
	 * @return LatLongValue[]
	 */
	public function getLineCoordinates() {
		return $this->coordinates;
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
		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$posArray = array();

		foreach ( $this->coordinates as $mapLocation ) {
			$posArray[] = array(
				'lat' => $mapLocation->getLatitude() ,
				'lon' => $mapLocation->getLongitude()
			);
		}

		$posArray = array( 'pos' => $posArray );

		return array_merge( $parentArray , $posArray );
	}

}
