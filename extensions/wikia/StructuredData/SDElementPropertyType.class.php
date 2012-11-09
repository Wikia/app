<?php
/**
 * @author ADi
 */
class SDElementPropertyType {
	protected $name;
	protected $range;

	public function __construct($name = '@set', $range = null) {
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

	public function hasRange() {
		return ( !empty($this->range) ? true : false );
	}

}
