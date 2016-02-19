<?php

namespace Wikia\ExactTarget;

class UserEmailAdapter {

	var $userEmail = '';

	public function __construct( \stdClass $result ) {
		$this->userEmail = $result->Properties->Property->Value;
	}

	public function getEmail() {
		return $this->userEmail;
	}
}
