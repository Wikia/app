<?php

use Maps\Elements\BaseElement;

/**
 * @since 2.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 */
class MapsBaseStrokableElement extends BaseElement {

	protected $strokeColor;
	protected $strokeOpacity;
	protected $strokeWeight;

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$parentArray = parent::getJSONObject( $defText, $defTitle );
		$array = [
			'strokeColor' => $this->hasStrokeColor() ? $this->getStrokeColor() : '#FF0000',
			'strokeOpacity' => $this->hasStrokeOpacity() ? $this->getStrokeOpacity() : '1',
			'strokeWeight' => $this->hasStrokeWeight() ? $this->getStrokeWeight() : '2'
		];
		return array_merge( $parentArray, $array );
	}

	public function hasStrokeColor() {
		return !is_null( $this->strokeColor ) && $this->strokeColor !== '';
	}

	public function getStrokeColor() {
		return $this->strokeColor;
	}

	public function setStrokeColor( $strokeColor ) {
		$this->strokeColor = trim( $strokeColor );
	}

	public function hasStrokeOpacity() {
		return !is_null( $this->strokeOpacity ) && $this->strokeOpacity !== '';
	}

	public function getStrokeOpacity() {
		return $this->strokeOpacity;
	}

	public function setStrokeOpacity( $strokeOpacity ) {
		$this->strokeOpacity = trim( $strokeOpacity );
	}

	public function hasStrokeWeight() {
		return !is_null( $this->strokeWeight ) && $this->strokeWeight !== '';
	}

	public function getStrokeWeight() {
		return $this->strokeWeight;
	}

	public function setStrokeWeight( $strokeWeight ) {
		$this->strokeWeight = trim( $strokeWeight );
	}

}
