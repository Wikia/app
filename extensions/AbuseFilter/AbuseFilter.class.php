<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilter {

	public static $statsStoragePeriod = 86400;
	public static $tokenCache = array();
	public static $modifyCache = array();
	public static $condLimitEnabled = true;
	public static $condCount = 0;
	public static $filters = array();

	public static function generateUserVars( $user ) {
		$vars = array();
		
		// Load all the data we want.
		$user->load();
		
		$vars['USER_EDITCOUNT'] = $user->getEditCount();
		$vars['USER_AGE'] = time() - wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		$vars['USER_NAME'] = $user->getName();
		$vars['USER_GROUPS'] = implode(',', $user->getEffectiveGroups() );
		$vars['USER_EMAILCONFIRM'] = $user->getEmailAuthenticationTimestamp();
		
		// More to come
		
		return $vars;
	}
	
	public static function ajaxCheckSyntax( $filter ) {
		$result = self::checkSyntax( $filter );
		
		$ok = ($result === true);
		
		if ($ok) {
			return "OK";
		} else {
			return "ERR: $result";
		}
	}

	public static function disableConditionLimit() {
		// For use in batch scripts and the like
		self::$condLimitEnabled = false;
	}
	
	public static function generateTitleVars( $title, $prefix ) {
		$vars = array();
		
		$vars[$prefix."_ARTICLEID"] = $title->getArticleId();
		$vars[$prefix."_NAMESPACE"] = $title->getNamespace();
		$vars[$prefix."_TEXT"] = $title->getText();
		$vars[$prefix."_PREFIXEDTEXT"] = $title->getPrefixedText();
		
		if ($title->mRestrictionsLoaded) {
			// Don't bother if they're unloaded
			foreach( $title->mRestrictions as $action => $rights ) {
				$rights = count($rights) ? $rights : array();
				$vars[$prefix."_RESTRICTIONS_".$action] = implode(',', $rights );
			}
		}
		
		// Find last 5 authors
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'revision', 'distinct rev_user_text', array('rev_page' => $title->getArticleId() ), __METHOD__, array( 'order by' => 'rev_timestamp desc', 'limit' => 10 ) );
		$users = array();
		while ($user = $dbr->fetchRow($res)) {
			$users[] = $user[0];
		}
		$vars[$prefix."_RECENT_CONTRIBUTORS"] = implode(',', $users);
		
		return $vars;
	}
	
	public static function checkSyntax( $filter ) {
		global $wgAbuseFilterParserClass;
		
		$parser = new $wgAbuseFilterParserClass;
		
		return $parser->checkSyntax( $filter );
	}
	
	public static function evaluateExpression( $expr, $vars = array() ) {
		global $wgAbuseFilterParserClass;
		
		$parser = new $wgAbuseFilterParserClass;
		
		$parser->setVars( $vars );
		
		return $parser->evaluateExpression( $expr );
	}
	
	public static function ajaxReAutoconfirm( $username ) {
	
		if (!$wgUser->isAllowed('abusefilter-modify')) {
			// Don't allow it.
			return wfMsg( 'abusefilter-reautoconfirm-notallowed' );
		}
	
		$u = User::newFromName( $username );
		
		global $wgMemc;
		$k = AbuseFilter::autoPromoteBlockKey($u);
		
		if (!$wgMemc->get( $k ) ) {
			return wfMsg( 'abusefilter-reautoconfirm-none' );
		}
		
		$wgMemc->delete( $k );
	}
	
	public static function ajaxEvaluateExpression( $expr ) {
		return self::evaluateExpression( $expr );
	}

	public static function checkConditions( $conds, $vars ) {
		global $wgAbuseFilterParserClass;
		
		wfProfileIn( __METHOD__ );
		
		try {
			$parser = new $wgAbuseFilterParserClass;
			
			$parser->setVars( $vars );
			$result = $parser->parse( $conds, self::$condCount );
		} catch (Exception $excep) {
			// Sigh.
			$result = false;
		}
		
		wfProfileOut( __METHOD__ );
		
		return $result;
	}
	
	public static function filterAction( $vars, $title ) {
		global $wgUser,$wgMemc;
		
		// Fetch from the database.
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'abuse_filter', '*', array( 'af_enabled' => 1, 'af_deleted' => 0 ) );
		
		$blocking_filters = array();
		$log_entries = array();
		$log_template = array( 'afl_user' => $wgUser->getId(), 'afl_user_text' => $wgUser->getName(),
					'afl_var_dump' => serialize( $vars ), 'afl_timestamp' => $dbr->timestamp(wfTimestampNow()),
					'afl_namespace' => $title->getNamespace(), 'afl_title' => $title->getDBKey(), 'afl_ip' => wfGetIp() );
		$doneActionsByFilter = array();
		$filter_matched = array();
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			self::$filters[$row->af_id] = $row;
			$pattern = trim($row->af_pattern);
			if ( self::checkConditions( $pattern, $vars ) ) {
				$blocking_filters[$row->af_id] = $row;
				
				$newLog = $log_template;
				$newLog['afl_filter'] = $row->af_id;
				$newLog['afl_action'] = $vars['ACTION'];
				$log_entries[] = $newLog;
				
				$doneActionsByFilter[$row->af_id] = array();
				$filter_matched[$row->af_id] = true;
			} else {
				$filter_matched[$row->af_id] = false;
			}
		}
		
		//// Clean up from checking all the filters
	
		self::recordStats( $filter_matched );
		
		if (count($blocking_filters) == 0 ) {
			// No problems.
			return true;
		}
		
		// Retrieve the consequences.
		$res = $dbr->select( 'abuse_filter_action', '*', array( 'afa_filter' => array_keys( $blocking_filters ) ), __METHOD__, array( "ORDER BY" => " (afa_consequence in ('throttle','warn'))-(afa_consequence in ('disallow')) desc" ) );
		// We want throttles, warnings first, as they have a bit of a special treatment. We want disallow last.
		
		$actions_done = array();
		$throttled_filters = array();
		
		$display = '';
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			// Don't do the same action-parameters twice
			$action_key = md5( $row->afa_consequence . $row->afa_parameters );
			
			// Skip if we've already done this action-parameter, or a passive action has sufficed.
			$skipAction = ( in_array( $action_key, $actions_done ) || in_array( $row->afa_filter, $throttled_filters ) );
			
			// Don't disallow if we've already done something active. It produces two messages, where one would suffice.
			if ($row->afa_consequence == 'disallow' && !$skipAction) {
				$doneActiveActions = array_diff( $doneActionsByFilter[$row->afa_filter], array( 'throttle', 'warn' /* passive actions */ ) );
				$skipAction = (bool)count($doneActiveActions);
			}
			
			if ( !$skipAction ) {
				// Unpack parameters
				$parameters = explode( "\n", $row->afa_parameters );
				
				// Take the action.
				$result = self::takeConsequenceAction( $row->afa_consequence, $parameters, $title, $vars, $display, $continue, $blocking_filters[$row->afa_filter]->af_public_comments );
				
				// Don't do it twice.
				$doneActionsByFilter[$row->afa_filter][] = $row->afa_consequence;
				$actions_done[] = $action_key;
				
				// Only execute other actions for a filter if that filter's rate limiter has been tripped.
				if (!$result) {
					$throttled_filters[] = $row->afa_filter;
				}
			} else {
				// Ignore it, until we hit the rate limit.
			}
		}
		
		$dbw = wfGetDB( DB_MASTER );
		
		// Log it
		foreach( $log_entries as $index => $entry ) {
			$actions = $log_entries[$index]['afl_actions'] = implode( ',', $doneActionsByFilter[$entry['afl_filter']] );
			
			if ($actions == 'throttle') {
				// Just a throttle, don't record it.
				unset($log_entries[$index]);
			}
			
			// Increment the hit counter
			$dbw->update( 'abuse_filter', array( 'af_hit_count=af_hit_count+1' ), array( 'af_id' => $entry['afl_filter'] ), __METHOD__ );
		}
		
		if (!count($log_entries)) {
			return;
		}
		
		$dbw->insert( 'abuse_filter_log', $log_entries, __METHOD__ );
		
		return $display;
	}
	
	public static function takeConsequenceAction( $action, $parameters, $title, $vars, &$display, &$continue, $rule_desc ) {
		switch ($action) {
			case 'warn':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				if (!isset($_SESSION['abusefilter-warned']) || !$_SESSION['abusefilter-warned']) {
					$_SESSION['abusefilter-warned'] = true;
					
					// Threaten them a little bit
					$msg = ( !empty($parameters[0]) && strlen($parameters[0]) ) ? $parameters[0] : 'abusefilter-warning';
					$display .= wfMsgNoTrans( $msg, $rule_desc ) . "<br />\n";
					
					return false; // Don't apply the other stuff yet.
				} else {
					// We already warned them
					$_SESSION['abusefilter-warned'] = false;
				}
				break;
				
			case 'disallow':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				// Don't let them do it
				if (strlen($parameters[0])) {
					$display .= wfMsgNoTrans( $parameters[0], $rule_desc ) . "\n";
				} else {
					// Generic message.
					$display .= wfMsgNoTrans( 'abusefilter-disallowed', $rule_desc ) ."<br />\n";
				}
				break;
				
			case 'block':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				global $wgUser;
				$filterUser = AbuseFilter::getFilterUser();

				// Create a block.
				$block = new Block;
				$block->mAddress = $wgUser->getName();
				$block->mUser = $wgUser->getId();
				$block->mBy = $filterUser->getId();
				$block->mByName = $filterUser->getName();
				$block->mReason = wfMsgForContent( 'abusefilter-blockreason', $rule_desc );
				$block->mTimestamp = wfTimestampNow();
				$block->mAnonOnly = 1;
				$block->mCreateAccount = 1;
				$block->mExpiry = 'infinity';

				$block->insert();
				
				// Log it
				# Prepare log parameters
				$logParams = array();
				$logParams[] = 'indefinite';
				$logParams[] = 'nocreate, angry-autoblock';
	
				$log = new LogPage( 'block' );
				$log->addEntry( 'block', Title::makeTitle( NS_USER, $wgUser->getName() ),
					wfMsgForContent( 'abusefilter-blockreason', $rule_desc ), $logParams, self::getFilterUser() );
				
				$display .= wfMsgNoTrans( 'abusefilter-blocked-display', $rule_desc ) ."<br />\n";
				break;
			case 'rangeblock':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				global $wgUser;
				$filterUser = AbuseFilter::getFilterUser();
				
				$range = IP::toHex( wfGetIP() );
				$range = substr( $range, 0, 4 ) . '0000';
				$range = long2ip( hexdec( $range ) );
				$range .= "/16";
				$range = Block::normaliseRange( $range );

				// Create a block.
				$block = new Block;
				$block->mAddress = $range;
				$block->mUser = 0;
				$block->mBy = $filterUser->getId();
				$block->mByName = $filterUser->getName();
				$block->mReason = wfMsgForContent( 'abusefilter-blockreason', $rule_desc );
				$block->mTimestamp = wfTimestampNow();
				$block->mAnonOnly = 0;
				$block->mCreateAccount = 1;
				$block->mExpiry = Block::parseExpiryInput( '1 week' );

				$block->insert();
				
				// Log it
				# Prepare log parameters
				$logParams = array();
				$logParams[] = 'indefinite';
				$logParams[] = 'nocreate, angry-autoblock';
	
				$log = new LogPage( 'block' );
				$log->addEntry( 'block', Title::makeTitle( NS_USER, $range ),
					wfMsgForContent( 'abusefilter-blockreason', $rule_desc ), $logParams, self::getFilterUser() );
				
				$display .= wfMsgNoTrans( 'abusefilter-blocked-display', $rule_desc ) ."<br />\n";
				break;
			
			case 'throttle':
				$throttleId = array_shift( $parameters );
				list( $rateCount, $ratePeriod ) = explode( ',', array_shift( $parameters ) );
				
				$hitThrottle = false;
				
				// The rest are throttle-types.
				foreach( $parameters as $throttleType ) {
					$hitThrottle = $hitThrottle || self::isThrottled( $throttleId, $throttleType, $title, $rateCount, $ratePeriod );
				}
				
				return $hitThrottle;
				break;
			case 'degroup':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				global $wgUser;
				if (!$wgUser->isAnon()) {
					// Remove all groups from the user. Ouch.
					$groups = $wgUser->getGroups();
					
					foreach( $groups as $group ) {
						$wgUser->removeGroup( $group );
					}
					
					$display .= wfMsgNoTrans( 'abusefilter-degrouped', $rule_desc ) ."<br />\n";
					
					// Log it.
					$log = new LogPage( 'rights' );
			
					$log->addEntry( 'rights',
						$wgUser->getUserPage(),
						wfMsgForContent( 'abusefilter-degroupreason', $rule_desc ),
						array(
							implode( ', ', $groups ),
							wfMsgForContent( 'rightsnone' )
						)
					, self::getFilterUser() );
				}
				
				break;
			case 'blockautopromote':
				global $wgUser, $wgMemc;
				if (!$wgUser->isAnon()) {
					wfLoadExtensionMessages( 'AbuseFilter' );
					
					$blockPeriod = (int)mt_rand( 3*86400, 7*86400 ); // Block for 3-7 days.
					$wgMemc->set( self::autoPromoteBlockKey( $wgUser ), true, $blockPeriod );
					
					$display .= wfMsgNoTrans( 'abusefilter-autopromote-blocked', $rule_desc ) ."<br />\n";
				}
				break;

			case 'flag':
				// Do nothing. Here for completeness.
				break;
		}
		
		return true;
	}
	
	public static function isThrottled( $throttleId, $types, $title, $rateCount, $ratePeriod ) {
		global $wgMemc;
		
		$key = self::throttleKey( $throttleId, $types, $title );
		$count = $wgMemc->get( $key );
		
		if ($count > 0) {
			$wgMemc->incr( $key );
			if ($count > $rateCount) {
				$wgMemc->delete( $key );
				return true; // THROTTLED
			}
		} else {
			$wgMemc->add( $key, 1, $ratePeriod );
		}
		
		return false; // NOT THROTTLED
	}
	
	public static function throttleIdentifier( $type, $title ) {
		global $wgUser;
		
		switch ($type) {
			case 'ip':
				$identifier = wfGetIp();
				break;
			case 'user':
				$identifier = $wgUser->getId();
				break;
			case 'range':
				$identifier = substr(IP::toHex(wfGetIp()),0,4);
				break;
			case 'creationdate':
				$reg = $wgUser->getRegistration();
				$identifier = $reg - ($reg % 86400);
				break;
			case 'editcount':
				// Hack for detecting different single-purpose accounts.
				$identifier = $wgUser->getEditCount();
				break;
			case 'site':
				return 1;
				break;
			case 'page':
				return $title->getPrefixedText();
				break;
		}
		
		return $identifier;
	}
	
	public static function throttleKey( $throttleId, $type, $title ) {
		$identifier = '';

		$types = explode(',', $type);
		
		$identifiers = array();
		
		foreach( $types as $subtype ) {
			$identifiers[] = self::throttleIdentifier( $subtype, $title );
		}
		
		$identifier = implode( ':', $identifiers );
	
		return wfMemcKey( 'abusefilter', 'throttle', $throttleId, $type, $identifier );
	}
	
	public static function autoPromoteBlockKey( $user ) {
		return wfMemcKey( 'abusefilter', 'block-autopromote', $user->getId() );
	}
	
	public static function recordStats( $filters ) {
		global $wgAbuseFilterConditionLimit,$wgMemc;
		
		$blocking_filters = array_keys( array_filter( $filters ) );
		
		$overflow_triggered = (self::$condCount > $wgAbuseFilterConditionLimit);
		$filter_triggered = count($blocking_filters);
		
		$overflow_key = self::filterLimitReachedKey();
		
		$total_key = self::filterUsedKey();
		$total = $wgMemc->get( $total_key );

		$storage_period = self::$statsStoragePeriod; // One day.
		
		if (!$total || $total > 1000) {
			$wgMemc->set( $total_key, 1, $storage_period );
			
			if ($overflow_triggered) {
				$wgMemc->set( $overflow_key, 1, $storage_period );
			} else {
				$wgMemc->set( $overflow_key, 0, $storage_period );
			}
			
			$anyMatch = false;
			
			foreach( $filters as $filter => $matched ) {
				$filter_key = self::filterMatchesKey( $filter );
				if ($matched) {
					$anyMatch = true;
					$wgMemc->set( $filter_key, 1, $storage_period );
				} else {
					$wgMemc->set( $filter_key, 0, $storage_period );
				}
			}
			
			if ($anyMatch) {
				$wgMemc->set( self::filterMatchesKey(), 1, $storage_period );
			} else {
				$wgMemc->set( self::filterMatchesKey(), 0, $storage_period );
			}
			
			return;
		}
		
		$wgMemc->incr( $total_key );
		
		if ($overflow_triggered) {
			$wgMemc->incr( $overflow_key );
		}
		
		$anyMatch = false;
		
		global $wgAbuseFilterEmergencyDisableThreshold, $wgAbuseFilterEmergencyDisableCount, $wgAbuseFilterEmergencyDisableAge;
		
		foreach( $filters as $filter => $matched ) {
			if ($matched) {
				$anyMatch = true;
				$match_count = $wgMemc->get( self::filterMatchesKey( $filter ) );
				
				if ($match_count > 0) {
					$wgMemc->incr( self::filterMatchesKey( $filter ) );
				} else {
					$wgMemc->set( self::filterMatchesKey( $filter ), 1, self::$statsStoragePeriod );
				}
				
				$filter_age = wfTimestamp( TS_UNIX, self::$filters[$filter]->af_timestamp );
				$throttle_exempt_time = $filter_age + $wgAbuseFilterEmergencyDisableAge;
				
				if ($throttle_exempt_time > time() && $match_count > $wgAbuseFilterEmergencyDisableCount && ($match_count / $total) > $wgAbuseFilterEmergencyDisableThreshold) {
					// More than X matches, constituting more than Y% of last Z edits. Disable it.
					$dbw = wfGetDB( DB_MASTER );
					$dbw->update( 'abuse_filter', array( 'af_enabled' => 0, 'af_throttled' => 1 ), array( 'af_id' => $filter ), __METHOD__ );
				}
			}
		}
		
		if ($anyMatch) {
			$wgMemc->incr( self::filterMatchesKey() );
		}
	}
	
	public static function filterLimitReachedKey() {
		return wfMemcKey( 'abusefilter', 'stats', 'overflow' );
	}
	
	public static function filterUsedKey() {
		return wfMemcKey( 'abusefilter', 'stats', 'total' );
	}
	
	public static function filterMatchesKey( $filter = null ) {
		return wfMemcKey( 'abusefilter', 'stats', 'matches', $filter );
	}
	
	public static function getFilterUser() {
		wfLoadExtensionMessages( 'AbuseFilter' );
		
		$user = User::newFromName( wfMsgForContent( 'abusefilter-blocker' ) );
		$user->load();
		if ($user->getId() && $user->mPassword == '') {
			// Already set up.
			return $user;
		}
		
		// Not set up. Create it.
		
		if (!$user->getId()) {
			$user->addToDatabase();
			$user->saveSettings();
		} else {
			// Take over the account
			$user->setPassword( null );
			$user->setEmail( null );
			$user->saveSettings();
		}
		
		# Promote user so it doesn't look too crazy.
		$user->addGroup( 'sysop' );
		
		# Increment site_stats.ss_users
		$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssu->doUpdate();
		
		return $user;
	}
}
