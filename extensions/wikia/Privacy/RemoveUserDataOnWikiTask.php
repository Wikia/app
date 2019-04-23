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

	const USER_NAMESPACES = [
		2, // NS_USER,
		3, // NS_USER_TALK
		500, // NS_BLOG_ARTICLE
		1200, // NS_USER_WALL
		1201, // NS_USER_WALL_MESSAGE
		1202 // NS_USER_WALL_GREETING
	];

	private $logContext = [];

	/**
	 * Deletes all CheckUser records associated with the given user
	 *
	 * @param int $userId
	 * @return true if operation was successful
	 */
	private function removeCheckUserData( int $userId ) {
		try {
			$db = wfGetDB( DB_MASTER );
			// remove check user data
			$db->delete( 'cu_changes', [ 'cuc_user' => $userId ], __METHOD__ );
			$db->delete( 'cu_log', [ 'cul_target_id' => $userId ], __METHOD__ );
			$this->info( "Removed CheckUser data" );

			return true;
		}
		catch ( DBError $error ) {
			$this->error( "Couldn't remove CheckUser data", [ 'exception' => $error ] );

			return false;
		}
	}

	/**
	 * Removes the IP address from all RecentChanges records associated with the given user
	 *
	 * @param int $userId
	 * @return true if operation was successful
	 */
	private function removeIpFromRecentChanges( int $userId ) {
		try {
			$db = wfGetDB( DB_MASTER );
			$db->update( 'recentchanges', [ 'rc_ip_bin' => '' ], [ 'rc_user' => $userId ],
				__METHOD__ );
			$this->info( "Removed IPs from recent changes", [ 'user_id' => $userId ] );

			return true;
		}
		catch ( DBError $error ) {
			$this->error( "Couldn't remove IP from recent changes",
				[ 'exception' => $error, 'user_id' => $userId ] );

			return false;
		}
	}

	/**
	 * Removes abuse filter logs associated with the given user
	 *
	 * @param int $userId
	 * @return true if operation was successful
	 */
	private function removeAbuseFilterData( int $userId ) {
		global $wgEnableAbuseFilterExtension;
		if ( $wgEnableAbuseFilterExtension ) {
			try {
				$db = wfGetDB( DB_MASTER );
				$db->update( 'abuse_filter', [ 'af_user_text' => '' ], [ 'af_user' => $userId ],
					__METHOD__ );
				$db->update( 'abuse_filter_history', [ 'afh_user_text' => '' ],
					[ 'afh_user' => $userId ], __METHOD__ );
				$db->delete( 'abuse_filter_log', [ 'afl_user' => $userId ], __METHOD__ );
				$this->info( "Removed abuse filter data" );

				return true;
			}
			catch ( DBError $error ) {
				$this->error( "Couldn't remove abuse filter data", [ 'exception' => $error ] );

				return false;
			}
		} else {
			$this->info( "Skipping abuse filter, the extension is disabled" );

			return true;
		}
	}

	/**
	 * Permanently removes the userpage and user's talk, blog and wall pages.
	 *
	 * Since this method relies on the username, it may be impossible to retry this operation
	 * after the user's global data is removed.
	 *
	 * @param string $userDbKey
	 * @return true if operation was successful
	 */
	private function removeUserPages( string $userDbKey ) {
		try {
			$dbr = wfGetDB( DB_SLAVE );

			// We must only remove pages from user namespaces that have titles exactly like the username
			// or are prefixed with "<username>/". We can't use a single "<username>%" wildcard, since that could
			// remove pages of similarly named users (e. g. users "Jo" and "Joe").

			$exactMatches =
				$dbr->select( 'page', [ 'page_id', 'page_namespace', 'page_title' ],
					[ 'page_namespace' => self::USER_NAMESPACES, 'page_title' => $userDbKey ],
					__METHOD__ );
			$this->removePages( $exactMatches );

			$prefixedMatches =
				$dbr->select( 'page', [ 'page_id', 'page_namespace', 'page_title' ], [
					'page_namespace' => self::USER_NAMESPACES,
					'page_title' . $dbr->buildLike( $userDbKey . '/', $dbr->anyString() ),
				], __METHOD__ );
			$this->removePages( $prefixedMatches );

			$this->info( "Removed user pages", [ 'user_db_key' => $userDbKey ] );

			return true;
		}
		catch ( Exception $error ) {
			$this->error( "Couldn't remove user pages",
				[ 'exception' => $error, 'user_db_key' => $userDbKey ] );

			return false;
		}
	}

	private function removePages( $pages ) {
		foreach ( $pages as $page ) {
			$title = Title::newFromRow( $page );
			PermanentArticleDelete::deletePage( $title );
		}
	}

	/**
	 * Removes all recentchanges rows related to user pages.
	 *
	 * @param $userDbKey
	 * @return true if operation was successful
	 */
	private function removeUserPagesFromRecentChanges( $userDbKey ) {
		try {
			$db = wfGetDB( DB_MASTER );
			$db->delete( 'recentchanges',
				[ 'rc_namespace' => self::USER_NAMESPACES, 'rc_title' => $userDbKey ], __METHOD__ );
			$db->delete( 'recentchanges', [
				'rc_namespace' => self::USER_NAMESPACES,
				'rc_title' . $db->buildLike( $userDbKey . '/', $db->anyString() ),
			], __METHOD__ );
			$this->info( "Removed recent changes on user pages", [ "user_db_key" => $userDbKey ] );

			return true;
		}
		catch ( DBError $error ) {
			$this->error( "Couldn't remove user page history form recent changes",
				[ 'exception' => $error, 'user_db_key' => $userDbKey ] );

			return false;
		}
	}

	/**
	 * Remove logging records related to user pages
	 *
	 * @param $userDbKey
	 * @return true if operation was successful
	 */
	private function removeActionLogs( $userDbKey ) {
		try {
			$db = wfGetDB( DB_MASTER );
			$db->delete( 'logging',
				[ 'log_namespace' => self::USER_NAMESPACES, 'log_title' => $userDbKey ],
				__METHOD__ );
			$db->delete( 'logging', [
				'log_namespace' => self::USER_NAMESPACES,
				'log_title' . $db->buildLike( $userDbKey . '/', $db->anyString() ),
			], __METHOD__ );
			$this->info( 'Removed action logs on user pages', [ 'user_db_key' => $userDbKey ] );

			return true;
		}
		catch ( DBError $error ) {
			$this->error( "Couldn't remove action logs",
				[ 'exception' => $error, 'user_db_key' => $userDbKey ] );

			return false;
		}
	}

	/**
	 * Removes all watchlist items for the given user
	 *
	 * @param $userId
	 * @return true if operation was successful
	 */
	private function removeWatchlist( $userId ) {
		try {
			$db = wfGetDB( DB_MASTER );
			$db->delete( 'watchlist', [ 'wl_user' => $userId ], __METHOD__ );
			$this->info( "Removed user's watchlist" );

			return true;
		}
		catch ( DBError $error ) {
			$this->error( "Couldn't remove user's watchlist", [ 'exception' => $error ] );

			return false;
		}
	}

	public function removeUserDataOnCurrentWiki( $auditLogId, $userId, $oldUserId = null ) {
		global $wgUser, $wgCityId;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$this->logContext = [
			'right_to_be_forgotten' => 1,
			'rtbf_log_id' => $auditLogId,
			'user_id' => $userId,
			'old_user_id' => $oldUserId,
		];

		RemovalAuditLog::addWikiTask( $auditLogId, $wgCityId, $this->taskId );

		$user = User::newFromId( $userId );
		$oldUser = User::newFromId( $oldUserId );

		// gather results of all removal operations
		// if something fails, we still want to continue the process
		$results = [];

		$results[] = $this->removeCheckUserData( $userId );
		$results[] = $this->removeAbuseFilterData( $userId );
		$results[] = $this->removeIpFromRecentChanges( $userId );
		$results[] = $this->removeWatchlist( $userId );

		$userDbKey = Title::newFromText( $user->getName() )->getDBkey();
		$results[] = $this->removeUserPages( $userDbKey );
		$results[] = $this->removeUserPagesFromRecentChanges( $userDbKey );
		$results[] = $this->removeActionLogs( $userDbKey );
		if ( !empty( $oldUserId ) ) {
			$oldUserDbKey = Title::newFromText( $oldUser->getName() )->getDBkey();
			$results[] = $this->removeUserPages( $oldUserDbKey );
			$results[] = $this->removeUserPagesFromRecentChanges( $oldUserDbKey );
			$results[] = $this->removeActionLogs( $oldUserDbKey );
		}

		$removalWasSuccessful = array_reduce( $results, function ( $acc, $res ) { return $acc && $res; }, true );

		RemovalAuditLog::markTaskAsFinished( $auditLogId, $wgCityId, $removalWasSuccessful);

		throw new Exception("Removal status: $removalWasSuccessful - $auditLogId - $wgCityId");

		$this->info( "Removed user data from wiki" );

		if ( RemovalAuditLog::allWikiDataWasRemoved( $auditLogId ) ) {
			$dataRemover = new UserDataRemover();
			if ( !empty( $oldUserId ) ) {
				$dataRemover->removeGlobalUserData( $oldUser );
				$this->connectUserToRenameRecord( $userId, $oldUserId );
				$this->info( "Removed data connected to old username",
					[ 'rename_user_id' => $oldUserId ] );
			}

			$dataRemover->removeGlobalUserData( $user );
			RemovalAuditLog::markGlobalDataRemoved( $auditLogId );
			$this->info( "All data removed for $userId" );
		}
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

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}
}
