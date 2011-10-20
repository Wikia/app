<?php
class PlaceModel {
	private $align = 'right';
	private $width = 200;
	private $height = 200;
	private $lat = 0.00;
	private $lon = 0.00;
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
		$float = (double) $float;
		if ( !empty( $float ) ){
			$this->lat = $float;
		}
	}

	public function setLon( $float ){
		$float = (double) $float;
		if ( !empty( $float ) ){
			$this->lon = $float;
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

	public function getHaight(){
		return $this->height;
	}

	public function getLat(){
		return $this->lat;
	}

	public function getLon(){
		return $this->lon;
	}
	
	public function getAddress(){
		return $this->address;
	}

	public function getZoom(){
		return $this->zoom;
	}

	// Logic

	public function getApiString(){

		$aParams = array();
		$aParams['center'] = $this->getLat.','.$this->getLon;
		$aParams['size'] = $this->getWidth.'x'.$this->getHeight;
		$aParams['zoom'] = $this->getZoom;
		$aParams['maptype'] = 'roadmap';
		$sParams = http_build_query( $aParams );
		return 'http://maps.googleapis.com/maps/api/staticmap?'.$sParams;
	}
}