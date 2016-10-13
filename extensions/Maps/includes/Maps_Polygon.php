<?php
/**
 * Class that holds metadata on polygons made up by locations on map.
 *
 * @since 0.7.2
 *
 * @file Maps_Polygon.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 */
class MapsPolygon extends MapsBaseFillableElement implements iHoverableMapElement {

	/**
	 * @var
	 */
	protected $polygonCoords;

	/**
	 * @var
	 */
	protected $onlyVisibleOnHover = false;

	/**
	 *
	 */
	function __construct( $coords ) {
		$this->setPolygonCoords( $coords );
	}

	protected function setPolygonCoords( $polygonCoords ) {
		foreach ( $polygonCoords as $polygonCoord ) {
			$this->polygonCoords[] = new MapsLocation( $polygonCoord );
		}
	}

	protected function getPolygonCoords() {
		return $this->polygonCoords;
	}

	/**
	 * @param $visible
	 */
	public function setOnlyVisibleOnHover( $visible ) {
		$this->onlyVisibleOnHover = $visible;
	}

	/**
	 * @return mixed
	 */
	public function isOnlyVisibleOnHover() {
		return $this->onlyVisibleOnHover;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {

		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$posArray = array();

		foreach ( $this->polygonCoords as $mapLocation ) {
			$posArray[] = array(
				'lat' => $mapLocation->getLatitude() ,
				'lon' => $mapLocation->getLongitude()
			);
		}

		$array = array(
			'pos' => $posArray ,
			'onlyVisibleOnHover' => $this->isOnlyVisibleOnHover() ,
		);

		return array_merge( $parentArray , $array );
	}
}
