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

		$fakeUserId = $this->getFakeUserId( $user->getName() );

		// remove local data on all wikis edited by the user
		$userWikis = $this->getUserWikis( $userId );

		RemovalAuditLog::setNumberOfWikis( $auditLogId, count( $userWikis ) );

		$task = new RemoveUserDataOnWikiTask();
		$task->call( 'removeUserDataOnCurrentWiki', $auditLogId, $userId, $fakeUserId );
		$task->setQueue( Queue::RTBF_QUEUE_NAME )->wikiId( $userWikis )->queue();

		$this->info( "Wiki data removal queued for user $userId" );

		// return removal log id
		return $auditLogId;
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

	private function getUserWikis( int $userId ) {
		global $wgSpecialsDB;
		$specialsDbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		return $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id',
			[ 'user_id' => $userId ], __METHOD__, [ 'DISTINCT' ] );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}
}
