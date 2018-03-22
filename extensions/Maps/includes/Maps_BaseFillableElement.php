<?php

/**
 * @since 2.0
 */
class MapsBaseFillableElement extends MapsBaseStrokableElement {

	protected $fillColor;
	protected $fillOpacity;

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$parentArray = parent::getJSONObject( $defText, $defTitle );
		$array = [
			'fillColor' => $this->hasFillColor() ? $this->getFillColor() : '#FF0000',
			'fillOpacity' => $this->hasFillOpacity() ? $this->getFillOpacity() : '0.5',
		];
		return array_merge( $parentArray, $array );
	}

	public function hasFillColor() {
		return !is_null( $this->fillColor ) && $this->fillColor !== '';
	}

	public function getFillColor() {
		return $this->fillColor;
	}

	public function setFillColor( $fillColor ) {
		$this->fillColor = trim( $fillColor );
	}

	public function hasFillOpacity() {
		return !is_null( $this->fillOpacity ) && $this->fillOpacity !== '';
	}

	public function getFillOpacity() {
		return $this->fillOpacity;
	}

	public function setFillOpacity( $fillOpacity ) {
		$this->fillOpacity = trim( $fillOpacity );
	}
}
