<?php

use Wikia\Tasks\Tasks\BaseTask;

/**
 * Class RemoveUserDataOnWikiTask
 *
 * Removes or anonimizes all PII for a specific user on the current community
 *
 * TODO: how to report the final result?
 */
class RemoveUserDataOnWikiTask extends BaseTask {
	
	/**
	 * Deletes all CheckUser records associated with the given user
	 *
	 * @param int $userId
	 * @throws DBUnexpectedError
	 */
	public function removeCheckUserData( int $userId ) {
		$db = wfGetDB( DB_MASTER );
		// remove check user data
		$db->delete( 'cu_changes', ['cuc_user' => $userId], __METHOD__ );
		$db->delete( 'cu_log', ['cul_target_id' => $userId], __METHOD__ );
	}

	/**
	 * Removes the IP address from all RecentChanges records associated with the given user
	 *
	 * @param int $userId
	 */
	public function removeIpFromRecentChanges( int $userId ) {
		$db = wfGetDB( DB_MASTER );
		// TODO: consider removing last octet / 80 bits
		$db->update( 'recentchanges', ['rc_ip_bin' => ''], ['rc_user' => $userId], __METHOD__ );
	}

	/**
	 * Removes abuse filter logs associated with the given user
	 *
	 * @param int $userId
	 */
	public function removeAbuseFilterData( int $userId ) {
		global $wgEnableAbuseFilterExtension;
		$db = wfGetDB( DB_MASTER );
		if( $wgEnableAbuseFilterExtension ) {
			$db->update( 'abuse_filter', ['af_user_text' => ''], ['af_user' => $userId], __METHOD__ );
			$db->update( 'abuse_filter_history', ['afh_user_text' => ''], ['afh_user' => $userId], __METHOD__ );
			// TODO: consider removing last octet / 80 bits or removing
			$db->delete( 'abuse_filter_log', ['afl_user' => $userId], __METHOD__ );
		}
	}

}