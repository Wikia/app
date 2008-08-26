<?php
/**#@+
*      Extension used for blocking users names and IP addresses with regular expressions. Contains both the blocking mechanism and a special page to add/manage blocks
*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author Bartek
* @author Piotr Molski <moli@wikia.com>
* @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

/*
CREATE TABLE `blockedby_stats` (
  `stats_id` int(8) NOT NULL auto_increment,
  `stats_blckby_id` int(8) NOT NULL,
  `stats_user` varchar(255) NOT NULL,
  `stats_blocker` varchar(255) NOT NULL,
  `stats_timestamp` char(14) NOT NULL,
  `stats_ip` char(15) NOT NULL,
  `stats_match` varchar(255) NOT NULL default '',
  `stats_dbname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`stats_id`),
  KEY `stats_blckby_id_key` (`stats_blckby_id`),
  KEY `stats_timestamp` (`stats_timestamp`)
) ENGINE=InnoDB 
*/

/* 
    check data for every blocker
    @param $current_user User: current user
*/
function wfRegexBlockCheck ($current_user) {
	wfProfileIn( __METHOD__ );
	$ip_to_check = wfGetIP();
	
	/* First check cache */
	$blocked = wfRegexBlockIsBlockedCheck($current_user, $ip_to_check);
	if ($blocked) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	$blockers_array = wfRegexBlockGetBlockers();
	$block_data = wfGetRegexBlockedData($current_user, $blockers_array);
	
	/* check user for each blocker */
	foreach ($blockers_array as $blocker) {
		$blocker_block_data = isset($block_data[$blocker]) ? $block_data[$blocker] : null; 
		wfGetRegexBlocked( $blocker, $blocker_block_data, $current_user, $ip_to_check );
	}        
    
	wfProfileOut( __METHOD__ );
	return true;
}

/* 
    get blockers 
    @param 
*/
function wfRegexBlockGetBlockers() {
    global $wgSharedDB;
    $oMemc =& wfGetCache(CACHE_MEMCACHED);
	wfProfileIn( __METHOD__ );

    $key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities" , "", REGEXBLOCK_BLOCKERS_KEY );
    $cached = $oMemc->get($key);
    $blockers_array = array();

    if (!is_array($cached)) {
        /* get from database */
        $dbr =& wfGetDB (DB_MASTER);
        $oRes = $dbr->select(
            wfSharedTable(REGEXBLOCK_TABLE),
            array("blckby_blocker"),
            array("blckby_blocker <> ''"),
            __METHOD__,
            array("GROUP BY" => "blckby_blocker")
        );
        while ($oRow = $dbr->fetchObject($oRes)) {
            $blockers_array[] = $oRow->blckby_blocker;
        }
        $dbr->freeResult($oRes);
        $oMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
    } else {
        /* get from cache */
        $blockers_array = $cached;
    }

    wfProfileOut( __METHOD__ );
    return $blockers_array;
}

/* 
    check is user blocked
    @param $user User
    @param $ip 
    @return Array: an array of arrays to run a regex match against
*/
function wfRegexBlockIsBlockedCheck($user, $ip) {
    global $wgSharedDB;
	$oMemc =& wfGetCache(CACHE_MEMCACHED);

    wfProfileIn( __METHOD__ );
    $result = false;
    
    $key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $user->getName() ) );
    $cached = $oMemc->get ($key);
    
    if (is_object($cached)) {
        $ret = wfRegexBlockExpireNameCheck($cached);
        if ( ($ret !== false) && (is_array($ret)) ) {
            $ret['match'] = $user->getName(); $ret['ip'] = 0;
            $result = wfRegexBlockSetUserData($user, $ip, $ret['blocker'], $ret);
        }
    }
    
    if ( ($result === false) && ($ip != $user->getName()) ) {
        $key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $ip ) );
        $cached = $oMemc->get ($key);
        if (is_object($cached)) {
            $ret = wfRegexBlockExpireNameCheck($cached);
            if ( ($ret !== false) && (is_array($ret)) ) {
                $ret['match'] = $ip; $ret['ip'] = 1;
                $result = wfRegexBlockSetUserData($user, $ip, $ret['blocker'], $ret);
            }
        }
    }

    wfProfileOut( __METHOD__ );
    return $result;
}

function wfRegexBuildExpression( $lines, $exact = 0, $batchSize = 4096 ) {
    global $useSpamRegexNoHttp;

	wfProfileIn( __METHOD__ );
    /* Make regex */
    $regexes = array();
    $regexStart = ($exact) ? '/^(' : '/(';
    $regexEnd = "";
    if (!empty($exact)) { 
        $regexEnd = ')$/';
    } elseif ($batchSize > 0 ) {
        $regexEnd = ')/Si';
    } else {
        $regexEnd = ')/i';
    }
    $build = false;
    foreach( $lines as $line ) {
        if( $build == "" ) {
            $build = $line;
        } elseif( strlen( $build ) + strlen( $line ) > $batchSize ) {
            $regexes[] = /*$regexStart . */str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) /*. $regexEnd*/;
            $build = $line;
        } else {
            $build .= '|';
            $build .= $line;
        }
    }
    
    if( $build !== false ) {
        $regexes[] = /*$regexStart . */str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) /*. $regexEnd*/;
    }

	wfProfileOut( __METHOD__ );
	return $regexes;
}

function wfRegexIsCorrectCacheValue($cached) {
	$result = false;
	if (empty($cached)) {
		$result = true;
	} else {
		$loop = 0;
		$names = array ("ips" => "", "exact" => "", "regex" => "");
		foreach ($names as $key => $value) {
			if ( array_key_exists($key, $cached) && (!empty($cached[$key])) ) {
				$loop++;
	        }
		}
		if ($loop == 0) {
			$result = true;
		}
	}
	return $result;
}

/*
    get regex block data for all blockers
    @param $user User: current user
    @return Array: an array of arrays to run a regex match against
*/
function wfGetRegexBlockedData($user, $blockers) {
	global $wgSharedDB;
	$oMemc =& wfGetCache(CACHE_MEMCACHED);

	wfProfileIn( __METHOD__ );
	$blockData = array();

	/* first, check if regex strings are already stored in memcache */
	/* we will store entire array of regex strings here */
	if (!($user instanceof User)) {
		wfProfileOut( __METHOD__ );
		return false;
	}

 $memkey = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_BLOCKERS_KEY, "All-In-One" );
 $cached = $oMemc->get ($memkey);

 if ( empty($cached) ) {
		/* fetch data from db, concatenate into one string, then fill cache */
		$dbr =& wfGetDB( DB_MASTER );

  foreach($blockers as $blocker) {
			$oRes = $dbr->select(
				wfSharedTable(REGEXBLOCK_TABLE),
				array("blckby_id", "blckby_name", "blckby_exact"),
				array("blckby_blocker = {$dbr->addQuotes($blocker)}"),
				__METHOD__
			);

			$loop = 0;
			$names = array ("ips" => "", "exact" => "", "regex" => "");
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$key = "regex";
				if ($user->isIP($oRow->blckby_name) != 0) {
					$key = "ips";
				}
				elseif ($oRow->blckby_exact != 0) {
					$key = "exact";
				}
				$names[$key][] = $oRow->blckby_name;
				$loop++;
			}
			$dbr->freeResult($oRes);

			if ($loop > 0) {
				$blockData[$blocker] = $names;
			}
  }
		
		$oMemc->set( $memkey, $blockData, REGEXBLOCK_EXPIRE );
 }
 else {
		/* take it from cache */
		$blockData = $cached;
 }
 return $blockData;
}


/*    
    perform a match against all given values 
    @param $matching Array: array of strings containing list of values
    @param $value String: a given value to run a match against
    @param $exact Boolean: whether or not perform an exact match
    @return Array of matched values or false
*/
function wfRegexBlockPerformMatch ($matching, $value) {
	wfProfileIn( __METHOD__ );
	$matched = array () ;
	if (!is_array($matching)) { 
		/* empty? begone! */
		wfProfileOut( __METHOD__ );
		return false ;
	}
	
	/* normalise for regex */
	$loop = 0;
	$match = array();
	foreach ($matching as $one) {
		/* the real deal */
		$found = preg_match('/'.$one.'/i', $value, $match);
		if ($found) {
			if ( is_array($match) && (!empty($match[0])) ) {
				$matched[] = $one;
				break;
			}
		}
	}
	
	wfProfileOut( __METHOD__ );
	return $matched ;
}

/*
    check if the block expired or not (AFTER we found an existing block)
    @param $user User: current user object
    @param $names Array: matched names
    @param $ips Array: matched ips
    @return Array or false
*/
function wfRegexBlockExpireCheck ($user, $array_match = null, $ips = 0, $iregex = 0) {    
    global $wgSharedDB ;

    $oMemc =& wfGetCache(CACHE_MEMCACHED);
	wfProfileIn( __METHOD__ );
    /* I will use memcache, with the key being particular block
    */
    if (empty($array_match)) {
		wfProfileOut( __METHOD__ );
        return false ;
    }

    $ret = array() ;
    /* for EACH match check whether timestamp expired until found VALID timestamp
           but: only for a BLOCKED user, and it will be memcached 
       moreover, expired blocks will be consequently deleted
    */
    $blocked = "";
    foreach ($array_match as $single) {
        $key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $single ) );
        $blocked = null;
        $cached = $oMemc->get ($key) ;
        if ( empty($cached) || (!is_object ($cached)) ) {
            /* get from database */
            $dbr =& wfGetDB( DB_MASTER );
            $where = array("blckby_name like '%". $dbr->escapeLike( $single )  ."%'");
            if ( !empty($iregex) ) {
            	$where = array("blckby_name = " . $dbr->addQuotes($single));
	    }
            $oRes = $dbr->select(
                wfSharedTable(REGEXBLOCK_TABLE), 
                array("blckby_id", "blckby_timestamp", "blckby_expire", "blckby_blocker", "blckby_create", "blckby_exact", "blckby_reason"),
                $where, 
                __METHOD__
            );
            if ( $oRow = $dbr->fetchObject( $oRes ) ) {
                /* if still valid or infinite, ok to block user */
                $blocked = $oRow;
            }
            $dbr->freeResult ($oRes);
        } else {
            /* get from cache */
            $blocked = $cached;
        }
        
        /* check conditions */
        if ( is_object($blocked) )
        {
            $ret = wfRegexBlockExpireNameCheck($blocked);
            if ($ret !== false) {
                $ret['match'] = $single;
                $ret['ip'] = $ips;
                $oMemc->set ($key, $blocked) ;
	            wfProfileOut( __METHOD__ );
                return $ret;
            } else {  
                /* clean up an obsolete block */
                wfRegexBlockClearExpired ($single, $blocked->blckby_blocker);
            }
        }
    }
    
    wfProfileOut( __METHOD__ );
    return false ;
}

/*
    check if the USER block expired or not (AFTER we found an existing block)
    @param $username: user name to check
    @param $blocked: block object
    @return Array or false
*/

function wfRegexBlockExpireNameCheck($blocked) {
    $ret = false;
    wfProfileIn( __METHOD__ );
    if (is_object($blocked)) {
        if ((wfTimestampNow () <= $blocked->blckby_expire) || ('infinite' == $blocked->blckby_expire)) {
            $ret = array(
            'blckid' => $blocked->blckby_id,
            'create' => $blocked->blckby_create,
            'exact'  => $blocked->blckby_exact,
            'reason' => $blocked->blckby_reason,
            'expire' => $blocked->blckby_expire,
            'blocker'=> $blocked->blckby_blocker,
            'timestamp' => $blocked->blckby_timestamp
            );
        } 
    }
    wfProfileOut( __METHOD__ );
    return $ret;
}


/* clean up an existing expired block 
   @param $username String: name of the user
   @param $blocker String: name of the blocker 
*/
function wfRegexBlockClearExpired ($username, $blocker) {
	wfProfileIn( __METHOD__ );
    $result = false;
	
    $dbw =& wfGetDB( DB_MASTER );
    
    $dbw->delete(
        wfSharedTable(REGEXBLOCK_TABLE), 
        array("blckby_name = {$dbw->addQuotes($username)}"),
        __METHOD__
    );
    
    if ( $dbw->affectedRows() ) {
        /* success, remember to delete cache key  */
        wfRegexBlockUnsetKeys( $username );
        $result = true ;
    }
    
	wfProfileOut( __METHOD__ );
    return $result;
}

/* put the stats about block into database 
   @param $username String
   @param $user_ip String: IP of the current user
   @param $blocker String
*/
function wfRegexBlockUpdateStats ($user, $user_ip, $blocker, $match, $blckid) {
    global $wgSharedDB, $wgDBname;
    
    $result = false;
	wfProfileIn( __METHOD__ );

    $dbw =& wfGetDB( DB_MASTER );
    $dbw->insert( 
        wfSharedTable(REGEXBLOCK_STATS_TABLE), 
        array(
            'stats_id'          => 'null',
            'stats_blckby_id'   => $blckid,
            'stats_user'        => $user->getName(),
            'stats_ip'          => $user_ip,
            'stats_blocker'     => $blocker,
            'stats_timestamp'   => wfTimestampNow(),
            'stats_match'       => $match,
            'stats_dbname'      => $wgDBname
        ), 
        __METHOD__
    );

    if ( $dbw->affectedRows()  ) {
        $result = true ;
    }
    
	wfProfileOut( __METHOD__ );
    return $result ;
}

/*     
  the actual blocking goes here, for each blocker
  @param $blocker String
  @param $blocker_block_data Array
  @param $user User
  @param $user_ip String
*/
function wfGetRegexBlocked ($blocker, $blocker_block_data, $user, $user_ip) {
	wfProfileIn( __METHOD__ );

	if($blocker_block_data == null) {
		// no data for given blocker, aborting.. 
		wfProfileOut( __METHOD__ );
		return false;		
	}
    
	$ips = isset($blocker_block_data["ips"]) ? $blocker_block_data["ips"] : null;
	$names = isset($blocker_block_data["regex"]) ? $blocker_block_data["regex"] : null;
	$exact = isset($blocker_block_data["exact"]) ? $blocker_block_data["exact"] : null;
 // backward compatibility ;)
 $result = $blocker_block_data;
 
	/* check ips */
	if ( (!empty($ips)) && (in_array($user_ip, $ips)) ) {
		$result["ips"]['matches'] = array($user_ip);
		wfDebugLog('RegexBlock', "Found some ips to block: ". implode(",", $result["ips"]['matches']). "\n");
	}
	
	/* check regexes */
	if ( (!empty($result["regex"])) && (is_array($result["regex"])) ) {
		$result["regex"]['matches'] = wfRegexBlockPerformMatch($result["regex"], $user->getName());
		if (!empty($result["regex"]['matches'])) {
			wfDebugLog('RegexBlock', "Found some regexes to block: ". implode(",", $result["regex"]['matches']). "\n");
		}
	}
	
	/* check names of user */
	$exact = (is_array($exact)) ? $exact : array($exact);
	if ( (!empty($exact)) && (in_array($user->getName(), $exact)) ) {
		$key = array_search($user->getName(), $exact);
		$result["exact"]['matches'] = array($exact[$key]);
		wfDebugLog('RegexBlock', "Found some users to block: ". implode(",", $result["exact"]['matches']). "\n");
	}

	unset($ips); 
	unset($names);
	unset($exact);
   
	/* run expire checks for all matched values
	   this is only for determining validity of this block, so
	   a first successful match means the block is applied
	*/
	$valid = false;
	foreach ($result as $key => $value) {
		$is_ip = ("ips" == $key) ? 1 : 0;
		$is_regex = ("regex" == $key) ? 1 : 0;
		/* check if this block hasn't expired already  */
		if ( !empty($result[$key]['matches']) ) {
			$valid = wfRegexBlockExpireCheck( $user, $result[$key]['matches'], $is_ip, $is_regex );
			if ( is_array($valid) ) {
				break;
			}
		}
	}
	
	if ( is_array ($valid) ) {
		wfRegexBlockSetUserData($user, $user_ip, $blocker, $valid);
	}

	wfProfileOut( __METHOD__ );
	return true;
}

/*     
  update user structure
  @param $user User
  @param $user_ip String
  @param $blocker String
  @param $valid: blocked info
*/
function wfRegexBlockSetUserData(&$user, $user_ip, $blocker, $valid) {
    global $wgRegexBlockMessages, $wgMessageCache;
    global $wgContactLink;
	wfProfileIn( __METHOD__ );
    $result = false;
    
    if (!($user instanceof User)) {
		wfProfileOut( __METHOD__ );
        return $result;
    }
    
    /* read messages from language's file */
    foreach( $wgRegexBlockMessages as $key => $value ) {
        $wgMessageCache->addMessages( $wgRegexBlockMessages[$key], $key );
    }

    if ( empty($wgContactLink) ) {
        $wgContactLink = '[[Special:Contact|contact Wikia]]';
    }

    if (is_array($valid))
    {
        $user->mBlockedby = User::idFromName($blocker);
        if ($valid['reason'] != "") { 
            /* a reason was given, display it */
            $user->mBlockreason = $valid['reason'] ;
        } else { 
            /* display generic reasons */
            /* default we blocked by regex match */
            $user->mBlockreason = wfMsg('regexblock_reason_regex', array($wgContactLink));
            if ($valid['ip'] == 1) { 
                /* we blocked by IP */
                $user->mBlockreason = wfMsg('regexblock_reason_ip', array($wgContactLink));
            } else if ($valid['exact'] == 1) { 
                /* we blocked by username exact match */
                $user->mBlockreason = wfMsg('regexblock_reason_name', array($wgContactLink));
            }
        }
        /* account creation check goes through the same hook... */            
        if ($valid['create'] == 1) {
            if ($user->mBlock) {
                $user->mBlock->mCreateAccount = 1;
            }
        }
        /* set expiry information */
        if ($user->mBlock) {
        	$user->mBlock->mId = $valid['blckid'];
            $user->mBlock->mExpiry = $valid['expire']; 
            $user->mBlock->mTimestamp = $valid['timestamp'];
            $user->mBlock->mAddress = ($valid['ip'] == 1) ? wfGetIP() : $user->getName();
        }
                        
        $result = wfRegexBlockUpdateStats ( $user, $user_ip, $blocker, $valid['match'], $valid['blckid'] );
    }

	wfProfileOut( __METHOD__ );
	return $result;
}

/*
   clean the memcached keys
   @param $username name of username
*/
function wfRegexBlockUnsetKeys ($username) {
	global $wgSharedDB, $wgUser;
	wfProfileIn( __METHOD__ );

	$oMemc =& wfGetCache(CACHE_MEMCACHED);
	$key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_SPECIAL_KEY, REGEXBLOCK_SPECIAL_NUM_RECORD );
	$oMemc->delete( $key );
	/* main cache of user-block data */
	$key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $username ) );
	$oMemc->delete( $key );
	/* blockers */
	$key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_BLOCKERS_KEY );
	$oMemc->delete( $key );
	$blockers_array = wfRegexBlockGetBlockers();
	/* blocker's matches */
	$key = wfForeignMemcKey( (isset($wgSharedDB)) ? $wgSharedDB : "wikicities", "", REGEXBLOCK_BLOCKERS_KEY, "All-In-One" );
	$oMemc->delete( $key );
	wfGetRegexBlockedData ($wgUser, $blockers_array);

	wfProfileOut( __METHOD__ );
}

?>
