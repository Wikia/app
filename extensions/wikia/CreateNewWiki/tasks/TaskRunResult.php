<?php

//TODO figure out with frontend what should we return to allow for a reasonable message to the user and potential
//continuation of the process
class TaskRunResult {

	private $isOk = false;

	public function __construct( $isOk ) {
		$this->isOk = $isOk;
	}

	public function isOk() {
		return $this->isOk;
	}
}