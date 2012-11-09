<?php
/**
 * @author ADi
 */
class SDElementPropertyType {
	protected $name = null;
	protected $range = null;

	public function __construct($name, $range) {
		$this->name = $name;
		$this->range = $range;
	}

	public function isCollection() {
		return in_array( $this->name, array( '@set', '@list' ) );
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setRange($range) {
		$this->range = $range;
	}

	public function getRange() {
		return $this->range;
	}

}
