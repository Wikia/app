<?php

namespace Wikia\ExactTarget;

class UserEmailAdapter extends BaseAdapter {

	var $userEmail = '';

	public function getEmail() {
		return $this->userEmail;
	}

	protected function extractResult( $property ) {
		$this->userEmail = $property->Value;
	}
}
