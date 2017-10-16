<?php

class WikiaValidatorAlwaysTrue extends WikiaValidator {
	function __construct(array $options = array(), array $msg = array()) {
		parent::__construct($options, $msg);
	}

	public function isValid($value = null) {
		return true;
	}
}
