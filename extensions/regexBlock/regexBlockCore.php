<?php
/**
 * Extension used for blocking users names and IP addresses with regular
 * expressions. Contains both the blocking mechanism and a special page to
 * add/manage blocks
 *
 * @file
 * @ingroup Extensions
 */

class RegexBlock {

	/**
	 * Prepare data by getting blockers
	 * @param $current_user User: current user
	 */
	public static function check( $current_user ) {
		wfProfileIn( __METHOD__ );

		$ip_to_check = wfGetIP();

		/* First check cache */
		$blocked = self::isBlockedCheck( $current_user, $ip_to_check );
		if ( $blocked ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		$blockers_array = self::getBlockers();
		$block_data = self::blockedData( $current_user, $blockers_array );

		/* check user for each blocker */
		foreach( $blockers_array as $blocker ) {
			$blocker_block_data = isset( $block_data[$blocker] ) ? $block_data[$blocker] : null;
			self::blocked( $blocker, $blocker_block_data, $current_user, $ip_to_check );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get a database object
	 */
	public static function getDB( $db ){
		global $wgRegexBlockDatabase;
		return wfGetDB( $db, array(), $wgRegexBlockDatabase );
	}

	/**
	 * Get a memcached key
	 * @return string
	 */
	public static function memcKey( /* ... */ ) {
		global $wgRegexBlockDatabase;
		$args = func_get_args();
		if( $wgRegexBlockDatabase === false ) {
			return call_user_func_array( 'wfMemcKey', $args );
		} else {
			$newArgs = array_merge( wfSplitWikiID( $wgRegexBlockDatabase ), $args );
			return call_user_func_array( 'wfForeignMemcKey', $newArgs );
		}
	}

	/**
	 * Get blockers
	 */
	public static function getBlockers( $master = false ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$key = self::memcKey( REGEXBLOCK_BLOCKERS_KEY );
		$cached = $wgMemc->get( $key );
		$blockers_array = array();

		if ( !is_array( $cached ) ) {
			/* get from database */
			$dbr = self::getDB( $master ? DB_MASTER : DB_SLAVE );
			$res = $dbr->select( REGEXBLOCK_TABLE,
				array( 'blckby_blocker' ),
				array( "blckby_blocker <> ''" ),
				__METHOD__,
				array( 'GROUP BY' => 'blckby_blocker' )
			);
			while( $row = $res->fetchObject() ) {
				$blockers_array[] = $row->blckby_blocker;
			}
			$res->free();
			$wgMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
		} else {
			/* get from cache */
			$blockers_array = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $blockers_array;
	}

	/**
	 * Check if user is blocked
	 *
	 * @param $user User
	 * @param $ip
	 * @return Array: an array of arrays to run a regex match against
	 */
	public static function isBlockedCheck( $user, $ip ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$result = false;

		$key = self::memcKey( REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $user->getName() ) );
		$cached = $wgMemc->get( $key );

		if ( is_object( $cached ) ) {
			$ret = self::expireNameCheck( $cached );
			if ( ( $ret !== false ) && ( is_array( $ret ) ) ) {
				$ret['match'] = $user->getName();
				$ret['ip'] = 0;
				$result = self::setUserData( $user, $ip, $ret['blocker'], $ret );
			}
		}

		if ( ( $result === false ) && ( $ip != $user->getName() ) ) {
			$key = self::memcKey( REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $ip ) );
			$cached = $wgMemc->get( $key );
			if ( is_object( $cached ) ) {
				$ret = self::expireNameCheck( $cached );
				if ( ( $ret !== false ) && ( is_array( $ret ) ) ) {
					$ret['match'] = $ip;
					$ret['ip'] = 1;
					$result = self::setUserData( $user, $ip, $ret['blocker'], $ret );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	public static function buildExpression( $lines, $exact = 0, $batchSize = 4096 ) {
		wfProfileIn( __METHOD__ );

		/* Make regex */
		$regexes = array();
		$regexStart = ( $exact ) ? '/^(' : '/(';
		$regexEnd = '';
		if ( !empty( $exact ) ) {
			$regexEnd = ')$/';
		} elseif ( $batchSize > 0 ) {
			$regexEnd = ')/Si';
		} else {
			$regexEnd = ')/i';
		}
		$build = false;
		foreach( $lines as $line ) {
			if( $build == '' ) {
				$build = $line;
			} elseif( strlen( $build ) + strlen( $line ) > $batchSize ) {
				$regexes[] = /*$regexStart . */str_replace( '/', '\/', preg_replace( '|\\\*/|', '/', $build ) ) /*. $regexEnd*/;
				$build = $line;
			} else {
				$build .= '|';
				$build .= $line;
			}
		}

		if( $build !== false ) {
			$regexes[] = /*$regexStart . */str_replace( '/', '\/', preg_replace( '|\\\*/|', '/', $build ) ) /*. $regexEnd*/;
		}

		wfProfileOut( __METHOD__ );
		return $regexes;
	}

	public static function isCorrectCacheValue( $cached ) {
		$result = false;
		if ( empty( $cached ) ) {
			$result = true;
		} else {
			$loop = 0;
			$names = array('ips' => '', 'exact' => '', 'regex' => '');
			foreach( $names as $key => $value ) {
				if ( array_key_exists($key, $cached) && ( !empty( $cached[$key] ) ) ) {
					$loop++;
				}
			}
			if ( $loop == 0 ) {
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Fetch usernames or IP addresses to run a match against
	 *
	 * @param $user User: current user
	 * @param $blockers Array: list of admins who blocked
	 * @return Array: an array of arrays to run a regex match against
	 */
	public static function blockedData( $user, $blockers, $master = false ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$blockData = array();

		/**
		 * First, check if regex strings are already stored in memcached
		 * we will store entire array of regex strings here
		 */
		if ( !( $user instanceof User ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$memkey = self::memcKey( REGEXBLOCK_BLOCKERS_KEY, "All-In-One" );
		$cached = $wgMemc->get( $memkey );

		if ( empty( $cached ) ) {
			/* Fetch data from DB, concatenate into one string, then fill cache */
			$dbr = self::getDB( $master ? DB_MASTER : DB_SLAVE );

			foreach( $blockers as $blocker ) {
				$res = $dbr->select(
					REGEXBLOCK_TABLE,
					array( 'blckby_id', 'blckby_name', 'blckby_exact' ),
					array( "blckby_blocker = {$dbr->addQuotes($blocker)}" ),
					__METHOD__
				);

				$loop = 0;
				$names = array( 'ips' => '', 'exact' => '', 'regex' => '' );
				while ( $row = $res->fetchObject() ) {
					$key = 'regex';
					if ( $user->isIP($row->blckby_name) != 0 ) {
						$key = 'ips';
					} elseif ( $row->blckby_exact != 0 ) {
						$key = 'exact';
					}
					$names[$key][] = $row->blckby_name;
					$loop++;
				}
				$res->free();

				if ( $loop > 0 ) {
					$blockData[$blocker] = $names;
				}
			}
			$wgMemc->set( $memkey, $blockData, REGEXBLOCK_EXPIRE );
		} else {
			/* take it from cache */
			$blockData = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $blockData;
	}

	/**
	 * Perform a match against all given values
	 *
	 * @param $matching Array: array of strings containing list of values
	 * @param $value String: a given value to run a match against
	 * @param $exact Boolean: whether or not perform an exact match
	 * @return Array of matched values or false
	 */
	public static function performMatch( $matching, $value ) {
		wfProfileIn( __METHOD__ );
		$matched = array();

		if ( !is_array( $matching ) ) {
			/* empty? begone! */
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* normalise for regex */
		$loop = 0;
		$match = array();
		foreach( $matching as $one ) {
			/* the real deal */
			$found = preg_match('/'.$one.'/i', $value, $match);
			if ( $found ) {
				if ( is_array( $match ) && ( !empty( $match[0] ) ) ) {
					$matched[] = $one;
					break;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $matched;
	}

	/**
	 * Check if the block expired or not (AFTER we found an existing block)
	 *
	 * @param $user User: current user object
	 * @param $array_match Boolean
	 * @param $names Array: matched names
	 * @param $ips Array: matched ips
	 * @return Array or false
	 */
	public static function expireCheck( $user, $array_match = null, $ips = 0, $iregex = 0 ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		/* I will use memcached, with the key being particular block */
		if ( empty( $array_match ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$ret = array();
		/**
		 * For EACH match check whether timestamp expired until found VALID timestamp
		 * but: only for a BLOCKED user, and it will be memcached
		  * moreover, expired blocks will be consequently deleted
		 */
		$blocked = '';
		foreach( $array_match as $single ) {
			$key = self::memcKey( REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $single ) );
			$blocked = null;
			$cached = $wgMemc->get( $key );
			if ( empty( $cached ) || ( !is_object( $cached ) ) ) {
				/* get from database */
				$dbr = self::getDB( DB_MASTER );
				$where = array( "blckby_name LIKE '%{$single}%'" );
				if ( !empty( $iregex ) ) {
					$where = array( "blckby_name = " . $dbr->addQuotes( $single ) );
				}
				$res = $dbr->select( REGEXBLOCK_TABLE,
					array( 'blckby_id', 'blckby_timestamp', 'blckby_expire', 'blckby_blocker', 'blckby_create', 'blckby_exact', 'blckby_reason' ),
					$where,
					__METHOD__
				);
				if ( $row = $res->fetchObject() ) {
					/* if still valid or infinite, ok to block user */
					$blocked = $row;
				}
				$res->free();
			} else {
				/* get from cache */
				$blocked = $cached;
			}

			/* check conditions */
			if ( is_object( $blocked ) ) {
				$ret = self::expireNameCheck( $blocked );
				if ( $ret !== false ) {
					$ret['match'] = $single;
					$ret['ip'] = $ips;
					$wgMemc->set( $key, $blocked );
					wfProfileOut( __METHOD__ );
					return $ret;
				} else {
					/* clean up an obsolete block */
					self::clearExpired( $single, $blocked->blckby_blocker );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	/**
	 * Check if the USER block expired or not (AFTER we found an existing block)
	 *
	 * @param $blocked: block object
	 * @return Array or false
	 */
	public static function expireNameCheck( $blocked ) {
		$ret = false;
		wfProfileIn( __METHOD__ );
		if( is_object( $blocked ) ) {
			if ( ( wfTimestampNow () <= $blocked->blckby_expire ) || ( 'infinite' == $blocked->blckby_expire ) ) {
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

	/**
	 * Clean up an existing expired block
	 *
	 * @param $username String: name of the user
	 * @param $blocker String: name of the blocker
	 */
	function clearExpired( $username, $blocker ) {
		wfProfileIn( __METHOD__ );
		$result = false;

		$dbw = self::getDB( DB_MASTER );

		$dbw->delete( REGEXBLOCK_TABLE,
			array("blckby_name = {$dbw->addQuotes($username)}"),
			__METHOD__
		);

		if ( $dbw->affectedRows() ) {
			/* success, remember to delete cache key  */
			self::unsetKeys( $username );
			$result = true;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Put the stats about block into database
	 *
	 * @param $username String
	 * @param $user_ip String: IP of the current user
	 * @param $blocker String
	 * @param $match
	 * @param $blckid
	 */
	public static function updateStats( $user, $user_ip, $blocker, $match, $blckid ) {
		global $wgDBname;

		$result = false;
		wfProfileIn( __METHOD__ );

		$dbw = self::getDB( DB_MASTER );
		$dbw->insert( REGEXBLOCK_STATS_TABLE,
			array(
				'stats_id' => 'null',
				'stats_blckby_id' => $blckid,
				'stats_user' => $user->getName(),
				'stats_ip' => $user_ip,
				'stats_blocker' => $blocker,
				'stats_timestamp' => wfTimestampNow(),
				'stats_match' => $match,
				'stats_dbname' => $wgDBname
			),
			__METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$result = true;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * The actual blocking goes here, for each blocker
	 *
	 * @param $blocker String
	 * @param $blocker_block_data
	 * @param $user User
	 * @param $user_ip String
	 */
	function blocked( $blocker, $blocker_block_data, $user, $user_ip ) {
		wfProfileIn( __METHOD__ );

		if( $blocker_block_data == null ) {
			// no data for given blocker, aborting...
			wfProfileOut( __METHOD__ );
			return false;
		}

		$ips = isset( $blocker_block_data['ips'] ) ? $blocker_block_data['ips'] : null;
		$names = isset( $blocker_block_data['regex'] ) ? $blocker_block_data['regex'] : null;
		$exact = isset( $blocker_block_data['exact'] ) ? $blocker_block_data['exact'] : null;
		// backward compatibility ;)
		$result = $blocker_block_data;

		/* check IPs */
		if ( ( !empty( $ips ) ) && ( in_array( $user_ip, $ips ) ) ) {
			$result['ips']['matches'] = array( $user_ip );
			wfDebugLog( 'RegexBlock', "Found some IPs to block: ". implode( ",", $result['ips']['matches'] ). "\n" );
		}

		/* check regexes */
		if ( ( !empty( $result['regex'] ) ) && ( is_array( $result['regex'] ) ) ) {
			$result['regex']['matches'] = self::performMatch( $result['regex'], $user->getName() );
			if( !empty( $result['regex']['matches'] ) ) {
				wfDebugLog( 'RegexBlock', "Found some regexes to block: ". implode( ",", $result['regex']['matches'] ). "\n" );
			}
		}

		/* check names of user */
		$exact = ( is_array( $exact ) ) ? $exact : array( $exact );
		if ( ( !empty( $exact ) ) && ( in_array( $user->getName(), $exact ) ) ) {
			$key = array_search( $user->getName(), $exact );
			$result['exact']['matches'] = array($exact[$key]);
			wfDebugLog( 'RegexBlock', "Found some users to block: ". implode( ",", $result['exact']['matches'] ). "\n" );
		}

		unset( $ips );
		unset( $names );
		unset( $exact );

		/**
		 * Run expire checks for all matched values
		 * this is only for determining validity of this block, so
		 * a first successful match means the block is applied
		 */
		$valid = false;
		foreach( $result as $key => $value ) {
			$is_ip = ("ips" == $key) ? 1 : 0;
			$is_regex = ("regex" == $key) ? 1 : 0;
			/* check if this block hasn't expired already  */
			if ( !empty( $result[$key]['matches'] ) ) {
				$valid = self::expireCheck( $user, $result[$key]['matches'], $is_ip, $is_regex );
				if ( is_array( $valid ) ) {
					break;
				}
			}
		}

		if ( is_array( $valid ) ) {
			self::setUserData( $user, $user_ip, $blocker, $valid );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Update user structure
	 *
	 * @param $user User
	 * @param $user_ip String
	 * @param $blocker String
	 * @param $valid: blocked info
	 */
	public static function setUserData( &$user, $user_ip, $blocker, $valid ) {
		global $wgContactLink;
		wfProfileIn( __METHOD__ );
		$result = false;

		if ( !( $user instanceof User ) ) {
			wfProfileOut( __METHOD__ );
			return $result;
		}

		wfLoadExtensionMessages( 'RegexBlock' );

		if ( is_array( $valid ) ) {
			$user->mBlockedby = User::idFromName( $blocker );
			if ( $valid['reason'] != '' ) {
				/* a reason was given, display it */
				$user->mBlockreason = $valid['reason'];
			} else {
				/**
				 * Display generic reasons
				 * By default we blocked by regex match
				 */
				$user->mBlockreason = wfMsg( 'regexblock-reason-regex', $wgContactLink );
				if ( $valid['ip'] == 1 ) {
					/* we blocked by IP */
					$user->mBlockreason = wfMsg( 'regexblock-reason-ip', $wgContactLink );
				} else if( $valid['exact'] == 1 ) {
					/* we blocked by username exact match */
					$user->mBlockreason = wfMsg( 'regexblock-reason-name', $wgContactLink );
				}
			}
			/* account creation check goes through the same hook... */
			if ( $valid['create'] == 1 ) {
				if ( $user->mBlock ) {
					$user->mBlock->mCreateAccount = 1;
				}
			}
			/* set expiry information */
			if ( $user->mBlock ) {
				$user->mBlock->mId = $valid['blckid'];
				$user->mBlock->mExpiry = $valid['expire'];
				$user->mBlock->mTimestamp = $valid['timestamp'];
				$user->mBlock->mAddress = ($valid['ip'] == 1) ? wfGetIP() : $user->getName();
			}

			$result = self::updateStats( $user, $user_ip, $blocker, $valid['match'], $valid['blckid'] );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Clean the memcached keys
	 *
	 * @param $username name of username
	 */
	public static function unsetKeys( $username ) {
		global $wgMemc, $wgUser;
		wfProfileIn( __METHOD__ );

		$readMaster = 1;
		$key = self::memcKey( REGEXBLOCK_SPECIAL_KEY, REGEXBLOCK_SPECIAL_NUM_RECORD );
		$wgMemc->delete( $key );
		/* main cache of user-block data */
		$key = self::memcKey( REGEXBLOCK_USER_KEY, str_replace( ' ', '_', $username ) );
		$wgMemc->delete( $key );
		/* blockers */
		$key = self::memcKey( REGEXBLOCK_BLOCKERS_KEY );
		$wgMemc->delete( $key );
		$blockers_array = self::getBlockers( $readMaster );
		/* blocker's matches */
		$key = self::memcKey( REGEXBLOCK_BLOCKERS_KEY, "All-In-One" );
		$wgMemc->delete( $key );
		self::blockedData( $wgUser, $blockers_array, $readMaster );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Add a link to Special:RegexBlock on Special:Contributions/USERNAME
	 * pages if the user has 'regexblock' permission
	 * @return true
	 */
	public static function loadContribsLink( $id, $nt, &$links ){
		global $wgUser;
		if( $wgUser->isAllowed( 'regexblock' ) ) {
			wfLoadExtensionMessages( 'RegexBlock' );
			$links[] = $wgUser->getSkin()->makeKnownLinkObj(
				SpecialPage::getTitleFor( 'RegexBlock' ),
				wfMsgHtml( 'regexblock-link' ),
				'&ip=' . urlencode( $nt->getText() )
			);
		}
		return true;
	}

}