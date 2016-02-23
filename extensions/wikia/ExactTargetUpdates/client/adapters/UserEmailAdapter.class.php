<?php

namespace Wikia\ExactTarget;

class UserEmailAdapter {

	var $userEmail = '';

	public function __construct( $result ) {
		if ( $result instanceof \stdClass ) {
			$this->userEmail = $result->Properties->Property->Value;
		}
	}

	public function getEmail() {
		return $this->userEmail;
	}
}
