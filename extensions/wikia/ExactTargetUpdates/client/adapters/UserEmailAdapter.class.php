<?php

namespace Wikia\ExactTarget;

class UserEmailAdapter extends BaseAdapter {

	var $userEmail = '';

	public function getEmail() {
		return $this->userEmail;
	}

	protected function extractSingle( $property ) {
		$this->userEmail = $property->Value;
	}
}
