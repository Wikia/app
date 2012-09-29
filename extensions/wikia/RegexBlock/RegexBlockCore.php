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
	global $wgRequest;
	wfProfileIn( __METHOD__ );

	$userGroups = $current_user->getGroups();
	if (empty($userGroups)) {
		$userGroups = array();
	}

	if( in_array('staff', $userGroups) ) {
		// Staff users should not be blocked in any case
		wfProfileOut( __METHOD__ );
		return true;
	}

	$ip_to_check = $wgRequest->getIP();

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
function wfRegexBlockGetBlockers($master = 0) {
	global $wgExternalSharedDB, $wgMemc;
	wfProfileIn( __METHOD__ );

    $key = RegexBlockData::getMemcKey("blockers");
    $cached = ($master === 1) ? false : $wgMemc->get($key);
    $blockers_array = array();

    if ( !is_array($cached) ) {
        /* get from database */
        $dbr = wfGetDB( (empty($master)) ? DB_SLAVE : DB_MASTER, array(), $wgExternalSharedDB );
        $oRes = $dbr->select(
            REGEXBLOCK_TABLE,
            array("blckby_blocker"),
            array("blckby_blocker <> ''"),
            __METHOD__,
            array("GROUP BY" => "blckby_blocker")
        );
        while ($oRow = $dbr->fetchObject($oRes)) {
            $blockers_array[] = $oRow->blckby_blocker;
        }
        $dbr->freeResult($oRes);
        $wgMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
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
    global $wgMemc;

    wfProfileIn( __METHOD__ );
    $result = false;

	$key = RegexBlockData::getMemcKey("block_user", $user->getName());
    $cached = $wgMemc->get ($key);

    if (is_object($cached)) {
        $ret = wfRegexBlockExpireNameCheck($cached);
        if ( ($ret !== false) && (is_array($ret)) ) {
            $ret['match'] = $user->getName(); $ret['ip'] = 0;
            $result = wfRegexBlockSetUserData($user, $ip, $ret['blocker'], $ret);
        }
    }

    if ( ($result === false) && ($ip != $user->getName()) ) {
		$key = RegexBlockData::getMemcKey("block_user", $ip);
        $cached = $wgMemc->get ($key);
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
function wfGetRegexBlockedData($user, $blockers, $master = 0) {
	global $wgExternalSharedDB, $wgMemc;

	wfProfileIn( __METHOD__ );
	$blockData = array();

	/* first, check if regex strings are already stored in memcache */
	/* we will store entire array of regex strings here */
	if (!($user instanceof User)) {
		wfProfileOut( __METHOD__ );
		return false;
	}

	$cached = false;
	$memkey = RegexBlockData::getMemcKey("all_blockers");
	if ( empty($master) ) {
		$cached = $wgMemc->get ($memkey);
	}

	if ( empty($cached) ) {
		/* fetch data from db, concatenate into one string, then fill cache */
		$dbr = wfGetDB( (empty($master)) ? DB_SLAVE : DB_MASTER, array(), $wgExternalSharedDB );

		foreach($blockers as $blocker) {
			$oRes = $dbr->select(
				REGEXBLOCK_TABLE,
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

		$wgMemc->set( $memkey, $blockData, REGEXBLOCK_EXPIRE );
	}
	else {
		/* take it from cache */
		$blockData = $cached;
	}
	wfProfileOut( __METHOD__ );
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
	global $wgMemc;

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
		$key = RegexBlockData::getMemcKey("block_user", $single);
		$blocked = null;
		$cached = $wgMemc->get ($key) ;
		if ( empty($cached) || (!is_object ($cached)) ) {
			/* get from database */
			$blocked = RegexBlockData::getRegexBlockByName($single, $iregex);
		} else {
			/* get from cache */
			$blocked = $cached;
		}

		/* check conditions */
		if ( is_object($blocked) ) {
			$ret = wfRegexBlockExpireNameCheck($blocked);
			if ($ret !== false) {
				$ret['match'] = $single;
				$ret['ip'] = $ips;
				$wgMemc->set ($key, $blocked) ;
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
	global $wgExternalSharedDB;
	wfProfileIn( __METHOD__ );
	$result = false;

	/* delete cache key */
	wfRegexBlockUnsetKeys( $username );

	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
	$dbw->delete(
		REGEXBLOCK_TABLE,
		array("blckby_name = {$dbw->addQuotes($username)}"),
		__METHOD__
	);

	$result = true ;
	wfProfileOut( __METHOD__ );
	return $result;
}

/* put the stats about block into database
   @param $username String
   @param $user_ip String: IP of the current user
   @param $blocker String
*/
function wfRegexBlockUpdateStats ($user, $user_ip, $blocker, $match, $blckid) {
    global $wgExternalSharedDB, $wgDBname;
    $result = false;
	wfProfileIn( __METHOD__ );

    $dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
    $dbw->insert(
        WIKIA_REGEXBLOCK_STATS_TABLE,
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
    global $wgContactLink, $wgRequest;
	wfProfileIn( __METHOD__ );
    $result = false;

    if (!($user instanceof User)) {
		wfProfileOut( __METHOD__ );
        return $result;
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
                $user->mBlock->setCreateAccount(1);
            }
        }
        /* set expiry information */
        if ($user->mBlock) {
        	$user->mBlock->setId($valid['blckid']);
	    	# correct inifinity keyword on the fly, see rt#25419
            $user->mBlock->mExpiry = ($valid['expire'] == 'infinite') ? 'infinity' : $valid['expire'];
            $user->mBlock->mTimestamp = $valid['timestamp'];
            $user->mBlock->setTarget( ($valid['ip'] == 1) ? $wgRequest->getIP() : $user->getName() );
        }

		if ( wfReadOnly() ) {
			$result = true;
		} else {
			$result = wfRegexBlockUpdateStats ( $user, $user_ip, $blocker, $valid['match'], $valid['blckid'] );
		}
    }

	wfProfileOut( __METHOD__ );
	return $result;
}

/*
   clean the memcached keys
   @param $username name of username
*/
function wfRegexBlockUpdateMemcKeys ($username) {
	global $wgMemc;
	wfProfileIn( __METHOD__ );

	$data = RegexBlockData::getRegexBlockByName($username, 1, 1);
	if ( empty($data) ) {
		wfProfileOut( __METHOD__ );
		return false;
	}

	/* nbr of blockers */
	$key = RegexBlockData::getMemcKey("num_rec");
	$memcData = $wgMemc->get($key);
	if ( !is_null($memcData) ) {
		$memcData++;
		$wgMemc->set ($key, $memcData, REGEXBLOCK_EXPIRE) ;
	}

	/* main cache of user-block data */
	$key = RegexBlockData::getMemcKey("block_user", $username);
	$memcData = $wgMemc->get($key);
	if ( !is_null($memcData) ) {
		$wgMemc->set ($key, $data) ;
	}

	/* blockers */
	$key = RegexBlockData::getMemcKey("blockers");
	$blockers_array = $wgMemc->get($key);
	if ( is_array($blockers_array) && !in_array($data->blckby_blocker, $blockers_array) ) {
		$blockers_array[] = $data->blckby_blocker;
		$wgMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
	}

	/* blocker's matches */
	$memkey = RegexBlockData::getMemcKey("all_blockers");
	$blockData = $wgMemc->get($memkey);
	if ( !is_null($blockData) ) {
		$key = "regex";
		if (User::isIP($data->blckby_name) != 0) {
			$key = "ips";
		} elseif ($data->blckby_exact != 0) {
			$key = "exact";
		}
		if ( !isset($blockData[$data->blckby_blocker]) ) {
			$blockData[$data->blckby_blocker] = array();
		}
		$blockData[$data->blckby_blocker][$key][] = $data->blckby_name;
		$wgMemc->set( $memkey, $blockData, REGEXBLOCK_EXPIRE );
	}

	/* clear user object in memc */
	$userId = User::idFromName($username);
	if( $userId ) {
		$wgMemc->delete( wfMemcKey( 'user', 'id', $userId ) );
		$_key = wfSharedMemcKey( 'user_touched', $userId );
		$wgMemc->delete( $_key );
	}

	wfProfileOut( __METHOD__ );
	return true;
}

function wfRegexBlockUnsetKeys($username) {
	global $wgMemc;
	wfProfileIn( __METHOD__ );

	$data = RegexBlockData::getRegexBlockByName($username, 1, 1);
	if ( empty($data) ) {
		wfProfileOut( __METHOD__ );
		return false;
	}

	/* nbr of blockers */
	$key = RegexBlockData::getMemcKey("num_rec");
	$memcData = $wgMemc->get($key);
	if ( !is_null($memcData) ) {
		if ( $memcData > 0 ) $memcData--;
		$wgMemc->set ($key, $memcData, REGEXBLOCK_EXPIRE) ;
	}

	/* main cache of user-block data */
	$key = RegexBlockData::getMemcKey("block_user", $username);
	$wgMemc->delete($key);

	/* blockers */
	$key = RegexBlockData::getMemcKey("blockers");
	$blockers_array = $wgMemc->get($key);
	if ( !is_null($blockers_array) ) {
		$blockers_array = array_diff($blockers_array, array($data->blckby_blocker));
		$wgMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
	}

	/* blocker's matches */
	$memkey = RegexBlockData::getMemcKey("all_blockers");
	$blockData = $wgMemc->get($memkey);
	if ( !is_null($blockData) ) {
		$key = "regex";
		if (User::isIP($data->blckby_name) != 0) {
			$key = "ips";
		} elseif ($data->blckby_exact != 0) {
			$key = "exact";
		}

		if (
			isset($blockData[$data->blckby_blocker]) &&
			isset($blockData[$data->blckby_blocker][$key])
		) {
			$blockData[$data->blckby_blocker][$key] =
				array_diff(
					$blockData[$data->blckby_blocker][$key],
					array($data->blckby_name)
			);
			$wgMemc->set( $memkey, $blockData, REGEXBLOCK_EXPIRE );
		}
	}

	/* clear user object in memc */
	$userId = User::idFromName($username);
	if( $userId ) {
		$wgMemc->delete( wfMemcKey( 'user', 'id', $userId ) );
		$_key = wfSharedMemcKey( 'user_touched', $userId );
		$wgMemc->delete( $_key );
	}

	wfProfileOut( __METHOD__ );
	return true;
}

function wfLoadRegexBlockLink( $id, $nt, &$links ) {
    global $wgUser;
        if( $wgUser->isAllowed( 'regexblock' ) ) {
		$links[] = RequestContext::getMain()->getSkin()->makeKnownLinkObj(
			            SpecialPage::getTitleFor( 'RegexBlock' ),
				                wfMsg( 'regexblock' ),
				                'ip=' . urlencode( $nt->getText() ) );
	}
	return true;
}

