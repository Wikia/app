<?php

class SailthruHooks {
	protected static function getUsersBirthdayFromMaster( $userId ) {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		$res = $dbr->select(
			[ 'user' ],
			[ 'user_birthdate' ],
			[ 'user_id' => $userId ],
			__METHOD__
		);

		if ( !empty( $res->numRows() ) ) {
			$updatedUserObject = $res->fetchObject();
			$birthdate = $updatedUserObject->user_birthdate;
		}

		return $birthdate ?? null;
	}

	/**
	 * When a new user is registered, send their info to Sailthru
	 *
	 * @param User $user
	 * @param bool $byEmail
	 */
	public static function onAddNewAccount( User $user, $byEmail ) {
		SailthruGateway::getInstance()->createUser( $user, self::getUsersBirthdayFromMaster( $user->getId() ) );
	}

	/**
	 * When user settings are updated, update their info on Sailthru
	 *
	 * @param User $user
	 */
	public static function onUserSaveSettings( User $user ) {
		SailthruGateway::getInstance()->updateUser( $user );
	}

	/**
	 * When a user needs to be forgotten, remove them from Sailthru
	 *
	 * @param User $user
	 */
	public static function onRtbfGlobalDataRemovalStart( User $user ) {
		SailthruGateway::getInstance()->deleteUser( $user );
	}

	/**
	 * When a user account is closed
	 *
	 * @param User $user
	 */
	public static function onCloseAccount( User $user ) {
		SailthruGateway::getInstance()->updateUser( $user, [ 'status' => 'disabled' ] );
	}

	/**
	 * When a user account is reactivated
	 *
	 * @param User $user
	 */
	public static function onReactivateAccount( User $user ) {
		SailthruGateway::getInstance()->updateUser( $user, [ 'status' => 'active' ] );
	}

	/**
	 * When a username is changed
	 *
	 * @param \User $user
	 */
	public static function onUserRenamed( User $user, $oldName, $newName ) {
		SailthruGateway::getInstance()->renameUser( $user );
	}
}
