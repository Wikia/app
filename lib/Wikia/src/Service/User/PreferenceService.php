<?php

namespace Wikia\Service\User;

class PreferenceService implements PreferenceServiceInterface {

	private $gateway;

	function __construct( PreferenceGatewayInterface $gateway ) {
		$this->gateway = $gateway;
	}

	public function setPreferences( $userId, $preferences ) {
		return false;
	}

	public function getPreferences( $userId ) {

	}
}
