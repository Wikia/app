<?php
/**#@+
 * Extension used for blocking users names and IP addresses with regular expressions. Contains both the blocking mechanism and a special page to add/manage blocks
 *
 * @addtogroup SpecialPage
 *
 * @author Bartek Łapiński
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

/* add hook */
global $wgHooks;
$wgHooks['GetBlockedStatus'][] = 'wfRegexBlockCheck';

/* 
	prepare data by getting blockers 
	@param $current_user User: current user  
*/
function wfRegexBlockCheck ($current_user) {
	global $wgMemc, $wgSharedDB;
	if (!wfSimplifiedRegexCheckSharedDB())
		return;
	$ip_to_check = wfGetIP();
	$key = "$wgSharedDB:regexBlockCore:blockers";
	$cached = $wgMemc->get($key);
	if (!is_array($cached)) {
		/* get from database */
		$blockers_array = array();
		$dbr =& wfGetDB (DB_SLAVE);	
		$query = "SELECT blckby_blocker FROM ".wfRegexBlockGetTable()." GROUP BY blckby_blocker";
		$res = $dbr->query($query);
		while ( $row = $dbr->fetchObject( $res ) ) {
			wfGetRegexBlocked ($row->blckby_blocker, $current_user, $ip_to_check);
			array_push ($blockers_array, $row->blckby_blocker);
		}
		$dbr->freeResult($res);
		$wgMemc->set($key, $blockers_array, REGEXBLOCK_EXPIRE);
	} else {
		/* get from cache */
		foreach ($cached as $blocker) {
			wfGetRegexBlocked ($blocker, $current_user, $ip_to_check);
		}		
	}
	return true;
}

/* 
	fetch usernames or IP addresses to run a match against
	@param $blocker String: the admin who blocked
	@param $user User: current user
	@param $mode integer: REGEXBLOCK_MODE_IPS or REGEXBLOCK_MODE_NAMES
	@return String: string to run a regex match against
*/
function wfGetRegexBlockedData ($blocker, $user, $mode) {
	global $wgMemc, $wgUser, $wgSharedDB;
	$names = "";
	$first = true;

	/* first, check if regex string is already stored in memcache */
	$key = str_replace( " ", "_", "$wgSharedDB:regexBlockCore:$mode:blocker:$blocker" );
	$cached = $wgMemc->get($key);
	if ( "" == $cached ) {
		/* fetch data from db, concatenate into one string, then fill cache */
		$dbr =& wfGetDB( DB_SLAVE );
		$query = "SELECT blckby_name, blckby_exact FROM ".wfRegexBlockGetTable()." WHERE blckby_blocker = {$dbr->addQuotes($blocker)}";
		$res = $dbr->query($query);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$concat = "";
			$is_ip = $user->isIP($row->blckby_name);
			/* IPs are checked in exact mode, marked as exact also */
			$simplified = $row->blckby_name;
			if (( (REGEXBLOCK_MODE_IPS == $mode) && ($is_ip != 0) ) || $row->blckby_exact) {
				$concat = "^{$simplified}$";
			} else if ((REGEXBLOCK_MODE_NAMES == $mode)) {
				$concat = $simplified;	
			}
			if ($concat != "") {
				if (!$first) {
					$names .= "|".$concat;	
				} else {
					$names .= $concat;
					$first = false;
				}
			}
		}
		$wgMemc->set($key, $names, REGEXBLOCK_EXPIRE); 
		$dbr->freeResult($res);
	} else {
		/* take from cache */
		$names = $cached;
	}	
	return $names;
}

/*
	check if the block expired or not (AFTER we found an existing block)
	@param $user User: current user object
	@param $names Array: matched names
	@param $ips Array: matched ips
	@return Array or false
*/
function wfRegexBlockExpireCheck ($user, $names = null, $ips = null) {	
	global $wgMemc, $wgSharedDB;
	/* I will use memcache, with the key being particular block */
	if ( is_array ($ips) ) {
		$array_match = $ips;
		$username = wfGetIP();
	} else {
		$array_match = $names;
		$username = $user->getName();
	}
	$ret = array();
	$dbr =& wfGetDB (DB_SLAVE);
	/* for EACH match check whether timestamp expired until found VALID timestamp
	   but: only for a BLOCKED user, and it will be memcached 
	   moreover, expired blocks will be consequently deleted
	*/
	foreach ($array_match as $single) {
		$key = str_replace( " ", "_", "$wgSharedDB:regexBlockCore:blocked:$single" );
		$cached = $wgMemc->get($key);
		if ( !is_object ($cached) ) {
			/* get from database */
			$query = "SELECT blckby_timestamp, blckby_expire, blckby_blocker, blckby_create, blckby_exact, blckby_reason 
				  FROM ".wfRegexBlockGetTable()." 
				  WHERE blckby_name like {$dbr->addQuotes('%'.$single.'%')}";

			$res = $dbr->query($query);
			if ($row = $dbr->fetchObject ($res) ) {
				/* if still valid or infinite, ok to block user */
				if ((wfTimestampNow () <= $row->blckby_expire) || ('infinite' == $row->blckby_expire)) {
					$ret['create'] = $row->blckby_create;
					$ret['exact'] = $row->blckby_exact;
					$ret['reason'] = $row->blckby_reason; 
					$wgMemc->set($key, $row);
					$dbr->freeResult($res);
					return $ret;
				} else {  /* clean up an obsolete block */
					wfRegexBlockClearExpired ($single, $row->blckby_blocker);
				}
			}
			$dbr->freeResult($res);
		} else {
			/* get from cache */
 			if ((wfTimestampNow () <= $cached->blckby_expire) || ('infinite' == $cached->blckby_expire)) {
				$ret['create'] = $cached->blckby_create;
				$ret['exact'] = $cached->blckby_exact;
				$ret['reason'] = $cached->blckby_reason;
				return $ret;
			} else {  /* clean up an obsolete block */
				wfRegexBlockClearExpired ($single, $cached->blckby_blocker);
			}
		}
	}
	return false;
}

/* clean up an existing expired block 
   @param $username String: name of the user
   @param $blocker String: name of the blocker 

*/
function wfRegexBlockClearExpired ($username, $blocker) {
	$dbw =& wfGetDB( DB_MASTER );
	$query = "DELETE FROM ".wfRegexBlockGetTable()." WHERE blckby_name = ".$dbw->addQuotes($username);
	$dbw->query($query);
	if ( $dbw->affectedRows() ) {
		/* success, remember to delete cache key  */
		wfRegexBlockUnsetKeys ($blocker, $username);
		return true;
	}
	return false;
}

/* put the stats about block into database 
   @param $username String
   @param $user_ip String: IP of the current user
   @param $blocker String
*/
function wfRegexBlockUpdateStats ($username, $user_ip, $blocker) {
	global $wgSharedDB;
	$dbw =& wfGetDB( DB_MASTER );
	$now = wfTimestampNow();
	$query = "INSERT INTO ".wfRegexBlockGetStatsTable()." 
		  (stats_id, stats_user, stats_ip, stats_blocker, stats_timestamp) 
		   values (null, {$dbw->addQuotes($username)}, '{$user_ip}',{$dbw->addQuotes($blocker)},'{$now}')";
	$res = $dbw->query($query);
	if ( $dbw->affectedRows()  ) {
		return true;
	}
	return false;
}

/* 	
  the actual blocking goes here, for each blocker
  @param $blocker String
  @param $user User
  @param $user_ip String
*/
function wfGetRegexBlocked ($blocker, $user, $user_ip) {
	global $wgContactLink;
	$names = wfGetRegexBlockedData ($blocker, $user, REGEXBLOCK_MODE_NAMES);
	$ips = wfGetRegexBlockedData ($blocker, $user, REGEXBLOCK_MODE_IPS);
	$username = $user->getName();
	$matched_name = preg_match ('/'.$names.'/i', $user->getName(), $matches);
	$matched_ip = preg_match ('/'.$ips.'/i', $user_ip, $ip_matches );

	if ( ( $matched_name && ($names != "") ) || ( $matched_ip  && ($ips != "") ) ) {
		/* check if this block hasn't expired already  */
		if ($matched_ip && ($ips != "")) {	
			$valid = wfRegexBlockExpireCheck ($user, null, $ip_matches);
		} else {
			$valid = wfRegexBlockExpireCheck ($user, $matches, null);
		}
		if ( is_array ($valid) ) {
			$user->mBlockedby = $blocker ;
			if ($valid['reason'] != "") { /* a reason was given, display it */
				$user->mBlockreason = $valid['reason'];
			} else { /* display generic reasons */
				if ($matched_ip && ($ips != "") ) { /* we blocked by IP */
					$user->mBlockreason = wfMsgHtml('regexblock-reason-ip', $wgContactLink);
				} else if ($valid['exact'] == 1) { /* we blocked by username exact match */
					$user->mBlockreason =  wfMsgHtml('regexblock-reason-name', $wgContactLink);
				} else { /* we blocked by regex match */
					$user->mBlockreason =  wfMsgHtml('regexblock-reason-regex', $wgContactLink);
				}
			}
			/* account creation check goes through the same hook... */			
			if ($valid['create'] == 1) $user->mBlock->mCreateAccount = 1;

			wfRegexBlockUpdateStats ($username, $user_ip, $blocker);
		}
	}
}