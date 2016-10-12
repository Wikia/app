<?php
/**
 * Class that holds metadata on lines made up by locations on map.
 *
 * @since 0.7.2
 *
 * @file Maps_Line.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 */
class MapsLine extends MapsBaseStrokableElement {

	/**
	 * @var
	 */
	protected $lineCoords;

	/**
	 *
	 */
	function __construct( $coords ) {
		$this->setLineCoords( $coords );
	}


	protected function setLineCoords( $lineCoords ) {
		foreach ( $lineCoords as $lineCoord ) {
			$this->lineCoords[] = new MapsLocation( $lineCoord );
		}
	}

	protected function getLineCoords() {
		return $this->lineCoords;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$posArray = array();
		foreach ( $this->lineCoords as $mapLocation ) {
			$posArray[] = array(
				'lat' => $mapLocation->getLatitude() ,
				'lon' => $mapLocation->getLongitude()
			);
		}
		$posArray = array( 'pos' => $posArray );

		return array_merge( $parentArray , $posArray );
	}
}
