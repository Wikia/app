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
			$db->delete( 'cu_changes', ['cuc_user' => $userId], __METHOD__ );
			$db->delete( 'cu_log', ['cul_target_id' => $userId], __METHOD__ );
			$this->info( "Removed CheckUser data" );
			return true;
		} catch( DBError $error ) {
			$this->error( "Couldn't remove CheckUser data", ['exception' => $error] );
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
			$db->update( 'recentchanges', ['rc_ip_bin' => ''], ['rc_user' => $userId], __METHOD__ );
			$this->info( "Removed IPs from recent changes", ['user_id' => $userId] );
			return true;
		} catch( DBError $error ) {
			$this->error( "Couldn't remove IP from recent changes", ['exception' => $error, 'user_id' => $userId] );
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
		if( $wgEnableAbuseFilterExtension ) {
			try {
				$db = wfGetDB( DB_MASTER );
				$db->update( 'abuse_filter', ['af_user_text' => ''], ['af_user' => $userId], __METHOD__ );
				$db->update( 'abuse_filter_history', ['afh_user_text' => ''], ['afh_user' => $userId], __METHOD__ );
				$db->delete( 'abuse_filter_log', ['afl_user' => $userId], __METHOD__ );
				$this->info( "Removed abuse filter data" );
				return true;
			} catch ( DBError $error) {
				$this->error( "Couldn't remove abuse filter data", ['exception' => $error] );
				return false;
			}
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
			$userPages = $dbr->select(
				'page',
				['page_id', 'page_namespace', 'page_title'],
				['page_namespace' => self::USER_NAMESPACES, 'page_title' . $dbr->buildLike( $userDbKey, $dbr->anyString() )],
				__METHOD__ );
			foreach( $userPages as $page ) {
				$title = Title::newFromRow( $page );
				PermanentArticleDelete::deletePage( $title );
			}
			$this->info( "Removed user pages", ['user_db_key' => $userDbKey] );
			return true;
		} catch ( Exception $error ) {
			$this->error( "Couldn't remove user pages", ['exception' => $error, 'user_db_key' => $userDbKey] );
			return false;
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
				['rc_namespace' => self::USER_NAMESPACES, 'rc_title' . $db->buildLike( $userDbKey, $db->anyString() )],
				__METHOD__ );
			$this->info( "Removed recent changes on user pages", ["user_db_key" => $userDbKey] );
			return true;
		} catch ( DBError $error) {
			$this->error( "Couldn't remove user page history form recent changes", ['exception' => $error, 'user_db_key' => $userDbKey] );
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
				['log_namespace' => self::USER_NAMESPACES, 'log_title' . $db->buildLike( $userDbKey, $db->anyString() )] );
			$this->info( 'Removed action logs on user pages', ['user_db_key' => $userDbKey] );
			return true;
		} catch ( DBError $error ) {
			$this->error( "Couldn't remove action logs", ['exception' => $error, 'user_db_key' => $userDbKey] );
			return false;
		}
	}

	public function removeUserDataOnCurrentWiki( $auditLogId, $userId, $username, $oldUsername = null ) {
		global $wgUser, $wgCityId;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$this->logContext = [
			'right_to_be_forgotten' => 1,
			'rtbf_log_id' => $auditLogId,
			'user_id' => $userId,
			'username' => $username,
			'old_username' => $oldUsername
		];

		RemovalAuditLog::addWikiTask( $auditLogId, $wgCityId, $this->taskId );

		// gather results of all removal operations
		// if something fails, we still want to continue the process
		$results = [];

		$results[] = $this->removeCheckUserData( $userId );
		$results[] = $this->removeAbuseFilterData( $userId );
		$results[] = $this->removeIpFromRecentChanges( $userId );

		$userDbKey = Title::newFromText( $username )->getDBkey();
		$results[] = $this->removeUserPages( $userDbKey );
		$results[] = $this->removeUserPagesFromRecentChanges( $userDbKey );
		$results[] = $this->removeActionLogs( $userDbKey );
		if ( !empty( $oldUsername ) ) {
			$oldUserDbKey = Title::newFromText( $oldUsername )->getDBkey();
			$results[] = $this->removeUserPages( $oldUserDbKey );
		}

		RemovalAuditLog::markTaskAsFinished(
			$auditLogId,
			$wgCityId,
			array_reduce( $results, function( $acc, $res ) { return $acc && $res; } ) );

		$this->info( "Removed user data from wiki" );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return $this->logContext;
	}

}