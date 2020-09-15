<?php

use Wikia\Logger\Loggable;
use Wikia\Tasks\Queues\Queue;

class UserDataRemover {
	use Loggable;

	private $logContext = [];

	/**
	 * Start the MW data removal process for RTBF requests.
	 *
	 * @param $userId
	 * @return int audit log id
	 */
	public function startRemovalProcess( $userId ) {
		$user = User::newFromId( $userId );
		Hooks::run( 'RtbfGlobalDataRemovalStart', [ $user ] );
		if( $user->isAnon() ) {
			$message = "Can't remove data for anon";
			$this->warning( $message );

			throw new WikiaException( $message );
		}

		$auditLogId = RemovalAuditLog::createLog( $userId );

		$this->logContext = [
			'right_to_be_forgotten' => 1,
			'rtbf_log_id' => $auditLogId,
			'user_id' => $userId
		];

		$renameUserId = $this->getRenameUserId( $user->getName() );

		// remove local data on all wikis edited by the user
		$userWikis = $this->getUserWikis( $userId );
		$userWikisNum = count( $userWikis );

		RemovalAuditLog::setNumberOfWikis( $auditLogId, $userWikisNum );

		if( $userWikisNum == 0 ) {
			$this->removeAllGlobalUserData( $userId, $renameUserId );
			RemovalAuditLog::markGlobalDataRemoved( $auditLogId );
			$this->info( "All data removed for $userId" );
		} else {
			$task = new RemoveUserDataOnWikiTask();
			$task->call( 'removeUserDataOnCurrentWiki', $auditLogId, $userId, $renameUserId );
			$task->setQueue( Queue::RTBF_QUEUE_NAME )->wikiId( $userWikis )->queue();

			$this->info( "Wiki data removal queued for user $userId" );
		}

		// return removal log id
		return $auditLogId;
	}

	/**
	 * Removes user data from global tables/dbs (i. e. not wiki specific talbes/dbs).
	 *
	 * TODO: this method performs redundant operations, e. g. removes data from user-attribute
	 *
	 * @param $userId
	 * @param $renameUserId - id of a stub user row that keeps the user's old username
	 * @throws Exception
	 */
	public function removeAllGlobalUserData( $userId, $renameUserId = null ) {
		if( !empty( $renameUserId ) ) {
			$this->removeGlobalUserData( User::newFromId( $renameUserId ) );
			$this->connectUserToRenameRecord( $userId, $renameUserId );
			$this->info( "Removed data connected to old username",
				['rename_user_id' => $renameUserId] );
		}

		$this->removeGlobalUserData( User::newFromId( $userId ) );
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

	private function removeGlobalUserData( User $user ) {
		try {
			global $wgExternalSharedDB;

			$this->mergeLoggerContext([
				'user_id' => $user->getId()
			]);

			$this->info( "Removing user's global data" );

			$userId = $user->getId();
			$newUserName = uniqid( 'Anonymous ' );

			$this->info( 'Anonimizing antispoof record' );
			// anonimize antispoof record
			$spoofRecord = new SpoofUser( $user->getName() );
			$spoofRecord->makeRecordPrivate();

			$this->info( 'Clearing Masthead contents' );
			$userIdentityBox = new UserIdentityBox( $user );
			$userIdentityBox->clearMastheadContents();
			$this->info( "Invalidating user" );
			Wikia::invalidateUser( $user, true, false );

			$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

			$this->info( 'Commiting changes' );
			// commit changes performed by Wikia::invalidateUser
			$dbMaster->commit( __METHOD__ );
			wfWaitForSlaves( $dbMaster->getDBname() );

			$this->info( 'Anonymizing user' );
			$dbMaster->update( 'user', [
				'user_name' => $newUserName,
				'user_birthdate' => null,
			], ['user_id' => $userId], __METHOD__ );

			$dbMaster->delete( 'user_email_log', ['user_id' => $userId] );
			$this->info( 'Deleting user properties' );
			$dbMaster->delete( 'user_properties', ['up_user' => $userId] );
			$dbMaster->insert( 'user_properties', [
				[
					'up_user' => $userId,
					'up_property' => 'disabled',
					'up_value' => '1',
				],
			] );
			$this->info( 'Anonymizing city founder data' );
			$dbMaster->update(
				'city_list',
				[
					'city_founding_email' => null,
					'city_founding_ip_bin' => null,
				],
				[
					'city_founding_user' => $userId,
				],
				__METHOD__
			);

			$this->info( "Adding a row in replication queue" );
			$dbMaster->insert(
				'user_replicate_queue',
				[ 'user_id' => $userId ],
				__METHOD__,
				[ 'IGNORE' ]
			);

			$this->info( 'Commiting changes' );
			// commit early so that cache is properly invalidated
			$dbMaster->commit( __METHOD__ );
			wfWaitForSlaves( $dbMaster->getDBname() );

			$user->deleteCache();
			$this->info( 'Removing from staff log' );
			$this->removeUserDataFromStaffLog( $userId );

			$this->info( "Removed user's global data", ['new_user_name' => $newUserName] );

		} catch( Exception $error ) {
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
	private function getRenameUserId( $username ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		return $dbr->selectField( 'user_properties', 'up_user', [
			'up_property' => 'renameData',
			'up_value' => "renamed_to=$username",
		], __METHOD__ );
	}

	private function getUserWikis( int $userId ) {
		global $wgSpecialsDB;
		$specialsDbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		return $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id',
			['user_id' => $userId], __METHOD__, ['DISTINCT'] );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}
}
