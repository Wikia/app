<?php

class WikiaValidatorUsersUrl extends WikiaValidatorRestrictiveUrl {

	protected function configMsgs( array $msgs = array() ) {
		parent::configMsgs($msgs);
		$this->setMsg( 'wrong-users-url', 'wikia-validator-wrong-users-url' );
	}

	public function isValidInternal($value = null) {
		$isCorrectUrl = parent::isValidInternal($value);

		if( $isCorrectUrl ) {
			$userName = $this->getUserNameFromUrl($value);
			
			if ($userName !== false) {
				return true;
			} else {
				$this->createError( 'wrong-users-url' );
			}
		}
		return false;
	}

	protected function getUserNameFromUrl($url) {
		return UserService::getNameFromUrl($url);
	}
}

