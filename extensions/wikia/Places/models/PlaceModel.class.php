<?php
class PlaceModel {
	private $align = 'right';
	private $width = 200;
	private $height = 200;
	private $lat = false;
	private $lon = false;
	private $address = '';
	private $zoom = 14;

	public static function newFromAttributes( $array = null ){
		$oModel = F::build( 'PlaceModel' );
		if ( is_array( $array ) ){
			foreach ( $array as $key => $val ){
				$setter = 'set'.ucfirst( strtolower( $key ) );
				if ( method_exists( 'PlaceModel', $setter ) ){
					$oModel->$setter( $val );
				}
			}
		}

		return $oModel;
	}

	public function setAlign( $text ){
		if ( in_array( $text, array( 'right', 'left' ) ) ) {
			$this->align = $text;
		}
	}

	public function setWidth( $int ){
		$int = (int) $int;
		if ( $int > 0 ){
			$this->width = $int;
		}
	}

	public function setHeight( $int ){
		$int = (int) $int;
		if ( $int > 0 ){
			$this->height = $int;
		}
	}

	public function setLat( $float ){
		if (is_numeric($float)) {
			$this->lat = (double) $float;
		}
	}

	public function setLon( $float ){
		if (is_numeric($float)) {
			$this->lon = (double) $float;
		}
	}

	public function setAddress( $text ){
		if ( !empty( $text ) ){
			$this->address = $text;
		}
	}

	public function setZoom( $int ){
		$int = (int) $int;
		if ( ( $int > 0 ) && ( $int < 21 ) ){
			$this->zoom = $int;
		}
	}

	public function getAlign(){
		return $this->align;
	}

	public function getWidth(){
		return $this->width;
	}

	public function getHeight(){
		return $this->height;
	}

	public function getLat(){
		return $this->lat;
	}

	public function getLon(){
		return $this->lon;
	}

	public function getLatLon() {
		return array(
			'lat' => $this->getLat(),
			'lon' => $this->getLon(),
		);
	}

	public function isEmpty() {
		return ($this->getLat() === false) || ($this->getLon() === false);
	}

	public function getAddress(){
		return $this->address;
	}

	public function getZoom(){
		return $this->zoom;
	}

	// Logic
	public function getStaticMapUrl(){
		$latLon = implode(',', $this->getLatLon());

		// use SASS button color for marker
		$colors = SassUtil::getOasisSettings();
		$markerColor = '0x' . ltrim($colors['color-buttons'], '#');

		$aParams = array(
			'center' => $latLon,
			'markers' => "color:{$markerColor}|{$latLon}",
			'size' => $this->getWidth().'x'.$this->getHeight(),
			'zoom' => $this->getZoom(),
			'maptype' => 'roadmap',
			'sensor' => 'false',
		);
		$sParams = http_build_query( $aParams );
		return 'http://maps.googleapis.com/maps/api/staticmap?'.$sParams;
	}

	public function getDistanceTo(PlaceModel $place) {

	}
}