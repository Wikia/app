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


	public function removeCheckUserData() {
		
	}

	public function removeData( int $userId ) {
		$db = wfGetDB( DB_MASTER );
		// remove check user data
		$db->delete( 'cu_changes', ['cuc_user' => $userId], __METHOD__ );
		$db->delete( 'cu_log', ['cul_target_id' => $userId], __METHOD__ );
		// anonimize IP in recent changes
		// TODO: consider removing last octet / 80 bits
		$db->update( 'recentchanges', ['rc_ip_bin' => ''], ['rc_user' => $userId], __METHOD__ );
		// anonimize AbuseFilter
		global $wgEnableAbuseFilterExtension;
		if( $wgEnableAbuseFilterExtension ) {
			// TODO: consider removing last octet / 80 bits or removing
			$db->delete( 'abuse_filter_log', ['afl_user' => $userId], __METHOD__ );
		}
	}

}