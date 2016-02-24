<?php

namespace Wikia\ExactTarget;

class UserAdapter {

	var $userId,
		$userName,
		$userRealName,
		$userEmail,
		$userEmailAuthenticated,
		$userRegistration,
		$userEditcount,
		$userTouched;

	public function __construct( $result ) {
		if ( $result->Properties instanceof \stdClass ) {
			$this->extractUser( $result->Properties->Property );
		}
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	public function getUserData() {
		return [
			'user_id' => $this->userId,
			'user_name' => $this->userName,
			'user_real_name' => $this->userRealName,
			'user_email' => $this->userEmail,
			'user_email_authenticated' => $this->userEmailAuthenticated,
			'user_registration' => $this->userRegistration,
			'user_editcount' => $this->userEditcount,
			'user_touched' => $this->userTouched
		];
	}

	private function extractUser( array $property ) {
		foreach ( $property as $value ) {
			switch ( $value->Name ) {
				case 'user_id':
					$this->userId = $value->Value;
					break;
				case 'user_name':
					$this->userName = $value->Value;
					break;
				case 'user_real_name':
					$this->userRealName = $value->Value;
					break;
				case 'user_email':
					$this->userEmail = $value->Value;
					break;
				case 'user_email_authenticated':
					$this->userEmailAuthenticated = $value->Value;
					break;
				case 'user_registration':
					$this->userRegistration = $value->Value;
					break;
				case 'user_editcount':
					$this->userEditcount = $value->Value;
					break;
				case 'user_touched':
					$this->userTouched = $value->Value;
					break;
			}
		}
	}
}
