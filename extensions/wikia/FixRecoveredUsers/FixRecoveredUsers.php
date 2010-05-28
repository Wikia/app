<?php
/**
 * @author Sean Colombo
 * @date 20100528
 *
 * This extension is built to help fix a problem with lost data.
 *
 * A 16-hour old backup was loaded into production and users created during that period
 * were initially lost and their original ids were assigned to new users.  The data for those
 * users was recovered, but now their IDs are different.  Since password hashes are salted with
 * the original user id, these restored users won't be able to log in normally.
 *
 * This extension will detect all failed logins and then update their password hashes to use the
 * new ids.  The login attempts will be logged so that we can determine when this conversion is
 * complete and the extension is no longer needed.
 */
 
 $wgHooks['UserComparePasswords'][] = 'wfFixRecoveredUsers';
 
 /**
 * Will check the password, upon failure, will check to see if the user is in the list of recovered users,
 * then will check the password using their old user id for the salt, then will log the outcome.  If they
 * log in successfully, their new password will be computed and stored.
 */
 function wfFixRecoveredUsers( &$hash, &$password, &$userId, &$result ){
	$RECOVERED_DB_NAME = "wikicities_201005271634";
	$RECOVERED_TABLE_NAME = "user_migrated";

	// Check password using the normal method
	$allowDefault = true;
	$type = substr( $hash, 0, 3 );
	$result = false;
	if ( $type == ':A:' ) {
		# Unsalted
		$result = md5( $password ) === substr( $hash, 3 );
	} elseif ( $type == ':B:' ) {
		# Salted
		list( $salt, $realHash ) = explode( ':', substr( $hash, 3 ), 2 );
		$result = md5( $salt.'-'.md5( $password ) ) == $realHash;
	} else {
		# Old-style
		// This should be the only method Wikia is using, but if it isn't then the other methods
		// would be fine anyway without the fixes... so all fixes are done herein.
		$result = self::oldCrypt( $password, $userId ) === $hash;

		// If password check failed, check to see if user id is in list of recovered users.
		if(!$result){
			$dbr = wfGetDB(DB_SLAVE, array(), $RECOVERED_DB_NAME);

			// See if this user is one of the recovered/migrated users.
			$id = $dbr->selectField( $RECOVERED_TABLE_NAME, 'new_user_id', array('user_id' => $userId) );
			if( $id !== false ) {
				// Re-check password w/old id as salt
				$result = self::oldCrypt( $password, $userId ) === $hash;

				$dbw = wfGetDB(DB_MASTER, array(), $RECOVERED_DB_NAME);
				if($result){
					// Reset the password (this time it will be generated with the new user_id).
					$oUser = new User();
					$oUser->setID($userId):
					$oUser->loadFromId($userId);
					$oUser->setPassword($password);
					$allowDefault = false;

					// Log the successful fix in user_migrated.
					$dbw->set($RECOVERED_TABLE_NAME, 'loggedInSuccessfully', "NOW()", 'user_id = ' . $userId);
				} else {
					// Log that the user tried to login but still failed.
					$dbw->set($RECOVERED_TABLE_NAME, 'lastLoginFailed', "NOW()", 'user_id = ' . $userId);
				}
			}
		}
	}
	return $allowDefault;
 }
