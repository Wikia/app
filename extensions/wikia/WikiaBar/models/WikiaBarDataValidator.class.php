<?php

interface WikiaBarDataValidator {
	public function isNotEmpty($value);
	public function validateLine($line);
	public function isArrayASuperArrayOf($array1, $array2);
	public function clearErrors();
	public function getErrors();
	public function getErrorCount();
}

