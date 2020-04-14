<?php

use Wikia\Logger\Loggable;
use Wikia\Tasks\Tasks\BaseTask;

/**
 * Class LegacyRemoveUserDataOnWikiTask
 *
 * Removes or anonimizes all PII for a specific user on the current community
 *
 */
class LegacyRemoveUserDataOnWikiTask extends BaseTask {
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

		$localDataRemover = new LocalUserDataRemover();
		$dataWasRemoved = $localDataRemover->removeLocalUserDataOnThisWiki( $auditLogId, $userId, $renameUserId );

		RemovalAuditLog::markTaskAsFinished( $auditLogId, $wgCityId, $dataWasRemoved );

		User::newFromId( $userId )->deleteCache();

		$this->info( "User's local data was removed", $this->getLoggerContext() );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}
}
