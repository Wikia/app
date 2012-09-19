<?php




class WikiaBarFailsafeDataValidator implements WikiaBarDataValidator {
	public function isNotEmpty($value) {
		return true;
	}

	public function validateLine($line) {
		return true;
	}

	public function isArrayASuperArrayOf($array1, $array2) {
		return true;
	}

	public function clearErrors() {
	}

	public function getErrors() {
		return array();
	}

	public function getErrorCount() {
		return 0;
	}

}