<?php

use Wikia\Logger\Loggable;
use Wikia\Tasks\Tasks\BaseTask;

/**
 * Class RemoveUserDataOnWikiTask
 *
 * Removes or anonimizes all PII for a specific user on the current community
 *
 */
class RemoveUserDataOnWikiTask extends BaseTask {
	use Loggable;

	private $logContext = [];

	public function removeUserDataOnCurrentWiki( $auditLogId, $userId, $renameUserId = null ) {
		global $wgUser, $wgCityId;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$this->logContext = [
			'right_to_be_forgotten' => 1,
			'rtbf_log_id' => $auditLogId,
			'user_id' => $userId,
			'rename_user_id' => $renameUserId,
		];

		RemovalAuditLog::addWikiTask( $auditLogId, $wgCityId, $this->taskId );

		$localDataRemover = new LocalUserDataRemover();
		$dataWasRemoved = $localDataRemover->removeLocalUserDataOnThisWiki(
			$auditLogId,
			array_filter( [ $userId, $renameUserId ] )
		);

		RemovalAuditLog::markTaskAsFinished( $auditLogId, $wgCityId, $dataWasRemoved );

		$this->info( "Removed user data from wiki" );

		try {
			// after removing data from a wiki, we must check if all the user's wikis (all wikis that the user edited) were cleared of their data
			// only after all wiki-specific data is removed, we can proceed with removing the user's global data
			if( RemovalAuditLog::allWikiDataWasRemoved( $auditLogId, DB_MASTER ) ) {
				$globalDataRemover = new UserDataRemover();
				$globalDataRemover->removeAllGlobalUserData( $userId, $renameUserId );
				RemovalAuditLog::markGlobalDataRemoved( $auditLogId );
				$this->info( "All data removed for $userId" );
			}
		} catch( \Exception $e ) {
			$this->error( "Couldn't remove global user data", [
				'reason' => $e->getMessage()
			] );
		}
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}
}
