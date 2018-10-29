<?php

namespace Wikia\CircuitBreaker;

class Ratio {
	private $numerator, $denominator;

	public function __construct( $numerator, $denominator ) {
		$this->numerator = $numerator;
		$this->denominator = $denominator;
	}

	public function getNumerator() {
		return $this->numerator;
	}

	public function getDenominator() {
		return $this->denominator;
	}
}
