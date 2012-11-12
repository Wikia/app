<?php
/**
 * @author ADi
 */
class SDElementPropertyTypeRange {

	private $data;

	public function __construct(array $data) {
		// @todo add support for multi element range arrays
		$this->data = $data[0];
	}

	public function isEnum() {
		return isset( $this->data->oneOf ) ? true : false;
	}

	public function hasClass() {
		return isset( $this->data->id ) ? true : false;
	}

	public function getClass() {
		return $this->hasClass() ? $this->data->id : false;
	}

	public function getAcceptedValues() {
		$values = array();

		if($this->isEnum()) {
			$values['enum'] = $this->data->oneOf;
		}
		else if($this->hasClass()) {
			$values['classes'] = array( $this->getClass() );
		}

		return $values;
	}

}
