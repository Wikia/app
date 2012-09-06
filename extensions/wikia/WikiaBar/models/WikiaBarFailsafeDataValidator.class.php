<?php




class WikiaBarFailsafeDataValidator implements WikiaBarDataValidator {
	public function isNotEmpty($value) {
		return true;
	}

	public function validateLine($line) {
		return true;
	}
}