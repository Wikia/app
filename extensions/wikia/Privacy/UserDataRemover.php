<?php

use Wikia\Logger\Loggable;

class UserDataRemover {
	use Loggable;

	public function removeGlobalData( int $userId ) {
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

			// commit early so that cache is properly invalidated
			$dbMaster->commit();
			wfWaitForSlaves( $dbMaster->getDBname() );

			$this->info( "Removed user's global data", ['user_id' => $userId] );
			return true;
		} catch ( Exception $error ) {
			$this->error( "Couldn't remove global user data", ['exception' => $error, 'user_id' => $userId] );
			return false;
		}
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return ['right_to_be_forgotten' => 1];
	}

}