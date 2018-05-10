<?php

use Wikia\Logger\WikiaLogger;

class UserDataRemover {

	public static function removeGlobalData( int $userId ) {
		try {
			$user = User::newFromId( $userId );
			if( $user->isAnon() ) {
				return false;
			}

			$userIdentityBox = new UserIdentityBox( $user );
			$userIdentityBox->clearMastheadContents();
			Wikia::invalidateUser( $user, true, false );

			$dbMaster = wfGetDB( DB_MASTER, [], 'wikicities' );

			$dbMaster->update(
				'user',
				[
					'user_name' => uniqid( 'Anonymous ' ),
					'user_birthdate' => null,
				],
				['user_id' => $userId],
				__METHOD__
			);

			$dbMaster->delete( 'user_email_log', ['user_id' => $userId] );
			$dbMaster->delete( 'user_properties', ['up_user' => $userId] );

			WikiaLogger::instance()->info( "Removed user's global data", ['user_id' => $userId] );
			return true;
		} catch ( Exception $error ) {
			WikiaLogger::instance()->error( "Couldn't remove global user data", ['exception' => $error, 'user_id' => $userId] );
			return false;
		}
	}

}