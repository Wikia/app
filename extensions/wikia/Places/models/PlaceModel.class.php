<?php
class PlaceModel {
	private $align = 'right';
	private $width = 200;
	private $height = 200;
	private $lan = 0;
	private $lon = 0;
	private $address = '';

	public static function newFromAttributes( $array ){
		$oModel = F::build( 'PlaceModel' );
		foreach ( $array as $key => $val ){
			$setter = 'set'.ucfirst( strtolower( $key ) );
			if ( method_exists( 'PlaceModel', $setter ) ){
				$oModel->$setter( $val );
			}
		}
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
	
	public function setLan( $float ){
		$float = (double) $float;
		if ( !empty( $float ) ){
			$this->lan = $float;
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

	public function getAlign(){
		return $this->align;
	}

	public function getWidth(){
		return $this->width;
	}

	public function getHaight(){
		return $this->height;
	}

	public function getLan(){
		return $this->lan;
	}

	public function getLon(){
		return $this->lon;
	}
	
	public function getAddress(){
		return $this->address;
	}
}