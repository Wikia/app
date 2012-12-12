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

	public function hasClasses() {
		return isset( $this->data->id ) ? true : false;
	}

	public function getClasses() {
		$classes = array();
		if($this->hasClasses()) {
			if(isset($this->data->unionOf)) {
				foreach($this->data->unionOf as $unionOf) {
					$classes[] = $unionOf->id;
				}
			}
			else {
				$classes[] = $this->data->id;
			}
		}
		return $classes;
	}

	public function getAcceptedValues() {
		$values = array();

		if($this->isEnum()) {
			$values['enum'] = $this->data->oneOf;
		}
		else {
			$values['classes'] = $this->getClasses();
		}

		return $values;
	}

}
