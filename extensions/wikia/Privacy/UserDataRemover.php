<?php

use Wikia\Logger\Loggable;
use Wikia\Tasks\Queues\Queue;

class UserDataRemover {
	use Loggable;

	private $logContext = [];

	/**
	 * Permanently removes or anonimizes all personal data of the given user.
	 *
	 * @param $userId
	 * @return removal data
	 */
	public function removeAllPersonalUserData( $userId ) {
		$user = User::newFromId( $userId );
		if ( $user->isAnon() ) {
			$this->warning( "Can't remove data for anon" );
			return;
		}

		$auditLogId = RemovalAuditLog::createLog( $userId );

		$this->logContext = [
			'right_to_be_forgotten' => 1,
			'rtbf_log_id' => $auditLogId,
			'user_id' => $userId
		];

		$username = $user->getName();
		$fakeUserId = $this->getFakeUserId( $username );
		$oldUsername = null;
		if ( !empty( $fakeUserId ) ) {
			$fakeUser = User::newFromId( $fakeUserId );
			$oldUsername = $fakeUser->getName();
			$this->removeUserData( $fakeUser );
			$this->connectUserToRenameRecord( $userId, $fakeUserId );

			$this->info( "Removed data connected to old username", ['rename_user_id' => $fakeUserId] );
		}

		$this->removeUserData( $user );

		// remove local data on all wikis edited by the user
		$userWikis = $this->getUserWikis( $userId );

		RemovalAuditLog::setNumberOfWikis( $auditLogId, count( $userWikis ) );

		$task = new RemoveUserDataOnWikiTask();
		$task->call( 'removeUserDataOnCurrentWiki', $auditLogId, $userId, $username, $oldUsername );
		$task->setQueue( Queue::RTBF_QUEUE_NAME )->wikiId( $userWikis )->queue();

		$this->info( "Wiki data removal queued for user $userId" );

		// return removal log id
		return $auditLogId;
	}

	private function removeUserData( User $user ) {
		try {
			global $wgExternalSharedDB;

			$userId = $user->getId();
			$newUserName = uniqid( 'Anonymous ' );

			// anonimize antispoof record
			$spoofRecord = new SpoofUser( $user->getName() );
			$spoofRecord->makeRecordPrivate();

			$userIdentityBox = new UserIdentityBox( $user );
			$userIdentityBox->clearMastheadContents();
			Wikia::invalidateUser( $user, true, false );

			$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

			// commit changes performed by Wikia::invalidateUser
			$dbMaster->commit( __METHOD__ );
			wfWaitForSlaves( $dbMaster->getDBname() );

			$dbMaster->update( 'user', [
					'user_name' => $newUserName,
					'user_birthdate' => null,
				], [ 'user_id' => $userId ], __METHOD__ );

			$dbMaster->delete( 'user_email_log', [ 'user_id' => $userId ] );
			$dbMaster->delete( 'user_properties', [ 'up_user' => $userId ] );
			$dbMaster->insert( 'user_properties', [
				[
					'up_user' => $userId,
					'up_property' => 'disabled',
					'up_value' => '1',
				],
			] );

			// commit early so that cache is properly invalidated
			$dbMaster->commit( __METHOD__ );
			wfWaitForSlaves( $dbMaster->getDBname() );

			$user->deleteCache();
			$this->removeUserDataFromStaffLog( $userId );

			$this->info( "Removed user's global data", ['new_user_name' => $newUserName ] );

		} catch ( Exception $error ) {
			// just log and rethrow
			$this->error( "Couldn't remove global user data", ['exception' => $error] );
			throw $error;
		}
	}

	private function removeUserDataFromStaffLog( int $userId ) {
		global $wgExternalDatawareDB;

		$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );

		$dbMaster->delete( 'wikiastaff_log', [
			'slog_user' => $userId,
		] );

		$dbMaster->delete( 'wikiastaff_log', [
			'slog_userdst' => $userId,
		] );
	}

	/**
	 * Returns the user id created during the rename user process
	 */
	private function getFakeUserId( $username ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		return $dbr->selectField( 'user_properties', 'up_user', [
			'up_property' => 'renameData',
			'up_value' => "renamed_to=$username",
		], __METHOD__ );
	}

	private function connectUserToRenameRecord( int $userId, int $fakeUserId ) {
		global $wgExternalSharedDB;
		$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$dbMaster->insert( 'user_properties', [
			[
				'up_user' => $fakeUserId,
				'up_property' => 'removedRenamedUser',
				'up_value' => $userId,
			],
		] );
	}

	private function getUserWikis( int $userId ) {
		global $wgSpecialsDB;
		$specialsDbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		return $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id', ['user_id' => $userId], __METHOD__, ['DISTINCT'] );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}

}
