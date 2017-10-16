<?php
/**
 * Ajax Functions used by Wikia extensions
 */

/**
 * Given a username, returns one of several codes to indicate whether it is valid to be a NEW username or not.
 *
 * Codes:
 * - OK: A user with this username may be created.
 * - INVALID: This is not a valid username.  This may mean that it is too long or has characters that aren't permitted, etc.
 * - EXISTS: A user with this name, so you cannot create one with this name.
 *
 * TODO: Is this a duplicate of user::isCreatableName()? It is important to note that wgWikiaMaxNameChars may be less than wgMaxNameChars which
 * is intentional because there are some long usernames that were created when only wgMaxNameChars limited to 255 characters and we still want
 * those usernames to be valid (so that they can still login), but we just don't want NEW accounts to be created above the length of wgWikiaMaxNameChars.
 *
 * @param string $uName The user name to check
 *
 * @return bool|string Return errors as an i18n key or true if the name is valid
 */
function wfValidateUserName( $uName ) {

	if ( !User::isNotMaxNameChars( $uName ) ) {
		return 'userlogin-bad-username-length';

	}

	$userTitle = Title::newFromText( $uName );
	if ( is_null( $userTitle ) ) {
		return 'userlogin-bad-username-character';
	}

	$uName = $userTitle->getText();
	if ( !User::isCreatableName( $uName ) ) {
		return 'userlogin-bad-username-character';
	}

	$dbr = wfGetDB( DB_SLAVE );
	$uName = $dbr->strencode( $uName );
	if ( $uName == '' ) {
		return 'userlogin-bad-username-character';
	}

	if ( class_exists( 'SpoofUser' ) ) {
		$spoof = new SpoofUser( $uName );
		if ( $spoof->isLegal() ) {
			$conflicts = $spoof->getConflicts();
			if ( !empty( $conflicts ) ) {
				return 'userlogin-bad-username-taken';
			}
		}
	}

	if ( in_array( $uName, F::app()->wg->ReservedUsernames ) ) {
		// if we returned 'invalid', that would be confusing once a user
		// checked and found that the name already met the naming requirements.
		return 'userlogin-bad-username-taken';
	}

	// This username is valid
	return true;
}
