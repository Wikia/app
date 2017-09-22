<?php

/**
 * @since 2.0
 */
class MapsBaseFillableElement extends MapsBaseStrokableElement implements iFillableMapElement {

	protected $fillColor;
	protected $fillOpacity;

	public function getFillColor() {
		return $this->fillColor;
	}

	public function setFillColor( $fillColor ) {
		$this->fillColor = trim($fillColor);
	}

	public function getFillOpacity() {
		return $this->fillOpacity;
	}

	public function setFillOpacity( $fillOpacity ) {
		$this->fillOpacity = trim($fillOpacity);
	}

	public function hasFillColor() {
		return !is_null( $this->fillColor ) && $this->fillColor !== '';
	}

	public function hasFillOpacity() {
		return !is_null( $this->fillOpacity ) && $this->fillOpacity !== '';
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$array = array(
			'fillColor' => $this->hasFillColor() ? $this->getFillColor() : '#FF0000' ,
			'fillOpacity' => $this->hasFillOpacity() ? $this->getFillOpacity() : '0.5' ,
		);
		return array_merge( $parentArray , $array );
	}
}
