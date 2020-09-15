<?php

class SailthruHooks {
	/**
	 * When a new user is registered, send their info to Sailthru
	 *
	 * @param User $user
	 * @param bool $byEmail
	 */
	public static function onAddNewAccount( User $user, $byEmail ) {
		SailthruGateway::getInstance()->saveUser( $user );
	}

	/**
	 * When user settings are updated, update their info on Sailthru
	 *
	 * @param \User $user
	 */
	public static function onUserSaveSettings( User $user ) {
		SailthruGateway::getInstance()->saveUser( $user );
	}

	/**
	 * When a user needs to be forgotten, remove them from Sailthru
	 *
	 * @param \User $user
	 */
	public static function onRtbfGlobalDataRemovalStart( \User $user ) {
		SailthruGateway::getInstance()->removeUser( $user );
	}
}
