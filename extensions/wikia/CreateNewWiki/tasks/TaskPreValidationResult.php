<?php

//TODO figure out with frontend what should we return to allow for a reasonable message to the user and potential
//continuation of the process
class TaskPreValidationResult {

	private $isValid = false;

	public function __construct( $isValid ) {
		$this->isValid = $isValid;
	}

	public function isValid() {
		return $this->isValid;
	}
}