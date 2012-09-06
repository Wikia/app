<?php

interface WikiaBarDataValidator {
	public function isNotEmpty($value);
	public function validateLine($line);
}

