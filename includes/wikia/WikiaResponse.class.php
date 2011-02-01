<?php

class WikiaResponse {

	private $printer = null;
	protected $data = array();
	protected $exception = null;

	public function setException(Exception $exception) {
		$this->exception = $exception;
	}

	public function getPrinter() {
		if (null === $this->printer) {
			$this->printer = WF::build('WikiaResponsePrinter');
		}

		return $this->printer;
	}

	public function getData() {
		return $this->data;
	}

	public function getException() {
		return $this->exception;
	}

	public function toString() {
		return $this->getPrinter()->render( $this );
	}

	public function __toString() {
		return $this->toString();
	}

}
