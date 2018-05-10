<?php

use Wikia\Tasks\Tasks\BaseTask;

class RemoveGlobalUserDataTask extends BaseTask {

	public function removeData( int $userId ) {
		$user = User::newFromId( $userId );
		if ( $user->isAnon() ) {
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
			[ 'user_id' => $userId ],
			__METHOD__
		);

		$dbMaster->delete( 'user_email_log', [ 'user_id' => $userId ] );
		$dbMaster->delete( 'user_properties', [ 'up_user' => $userId ] );

		return true;
	}
	
}
