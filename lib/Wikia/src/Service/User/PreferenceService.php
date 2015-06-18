<?php

namespace Wikia\Service\User;

class PreferenceService implements PreferenceServiceInterface {

	private $gateway;

	function __construct( PreferenceGatewayInterface $gateway ) {
		$this->gateway = $gateway;
	}

	public function setPreference( $userId, \Wikia\Domain\User\Preference $preference ) {

		return false;
	}

	public function setPreferences( $userId, $preferences ) {

	}

	public function getPreference( $userId ) {

	}
}
