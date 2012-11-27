<?php
/**
 * @author ADi
 */
class SDParserTagProperty {

	private $name = null;
	private $elementProperty = null;
	private $valueIndex = null;

	public function __construct( $name, SDElementProperty $elementProperty = null, $valueIndex = null ) {
		$this->name = $name;
		$this->elementProperty = $elementProperty;
		$this->valueIndex = $valueIndex;
	}

	public function getName() {
		return $this->name;
	}

	public function hasValueIndex() {
		return !is_null( $this->valueIndex );
	}

	public function getValueIndex() {
		return !is_null( $this->valueIndex ) ? $this->valueIndex : 0;
	}

	public function isSDElement() {
		return ($this->elementProperty instanceof SDElement);
	}

	public function isSDElementProperty() {
		return ($this->elementProperty instanceof SDElementProperty);
	}

	public function get() {
		return $this->elementProperty;
	}
}
