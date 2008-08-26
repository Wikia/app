<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilter {

	public static $condCount = 0;
	public static $condCheckCount = array();
	public static $condMatchCount = array();
	public static $statsStoragePeriod = 86400;
	public static $modifierWords = array( 'norm', 'supernorm', 'lcase', 'length', 'specialratio', 'htmldecode', 'htmlencode', 'urlencode', 'urldecode', 'htmlfullencode' );
	public static $operatorWords = array( 'eq', 'neq', 'gt', 'lt', 'regex', 'contains' );
	public static $validJoinConditions = array( '!', '|', '&' );
	public static $condLimitEnabled = true;
	public static $tokenCache = array();
	public static $modifyCache = array();

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

	public static function disableConditionLimit() {
		// For use in batch scripts and the like
		self::$condLimitEnabled = false;
	}
	
	public static function generateTitleVars( $title, $prefix ) {
		$vars = array();
		
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
		
		return $vars;
	}

	public static function checkConditions( $conds, $vars ) {
		$fname = __METHOD__;
		
		global $wgAbuseFilterConditionLimit;
		if (self::$condCount > $wgAbuseFilterConditionLimit && self::$condLimitEnabled) {
			return false;
		}
	
		// Remove leading/trailing spaces
		$conds = trim($conds);
		
		self::$condCount++;
		self::$condCheckCount[$conds]++;
		
		// Is it a set?
		if (substr( $conds, 0, 1 ) == '(' && substr( $conds, -1, 1 ) == ')' ) {
			// We should have a set here.
			$setInternal = substr($conds,1,-1);
			
			// Get the join condition ( &, | or ! )
			list($setJoinCondition,$conditionList) = explode(':', $setInternal, 2 );
			$setJoinCondition = trim($setJoinCondition);
			
			if (!in_array( $setJoinCondition, self::$validJoinConditions )) {
				// Bad join condition
				return false;
			}
			
			// Tokenise.
			$allConditions = self::tokeniseList( $conditionList );
			
			foreach( $allConditions as $thisCond ) {
			
				if (trim($thisCond)=='') {
					// Ignore it
					continue;
				} else {
					$result = self::checkConditions( $thisCond, $vars );
				}
				
				// We've hit the limit.
				if (self::$condCount > $wgAbuseFilterConditionLimit && self::$condLimitEnabled) {
					return false;
				}
				
				// Need we short-circuit?
				if ($setJoinCondition == '|' && $result) {
					// Definite yes.
// 					print "Short-circuit YES for condition $conds, as $thisCond is TRUE\n";
					self::$condMatchCount[$conds]++;
					return true;
				} elseif ($setJoinCondition == '&' && !$result) {
// 					print "Short-circuit NO for condition $conds, as $thisCond is FALSE\n";
					// Definite no.
					return false;
				} elseif ($setJoinCondition == '!' && $result) {
// 					print "Short-circuit NO for condition $conds, as $thisCond is TRUE\n";
					// Definite no.
					return false;
				}
			}
			if ($setJoinCondition != '|')
				self::$condMatchCount[$conds]++;
			// Return the default result.
			return ($setJoinCondition != '|'); // Only OR returns false after checking all conditions.
		}
		
		wfProfileIn( "$fname-evaluate" );
	
		// Grab the first word.
		list ($thisWord) = explode( ' ', $conds );
		$wordNum = 0;
		
		// Check for modifiers
		$modifier = '';
		if (in_array( $thisWord, self::$modifierWords ) ) {
			$modifier = $thisWord;
			$wordNum++;
			$thisWord = explode( ' ', $conds );
			$thisWord = $thisWord[$wordNum];
		}
		
		if ( in_array( $thisWord, array_keys($vars) ) ) {
		
			$value = $vars[$thisWord];
			if ($modifier) {
				$value = self::modifyValue( $modifier, $value );
			}
			
			// We have a variable. Now read the next word to see what we're doing with it.
			$wordNum++;
			$thisWord = explode( ' ', $conds );
			$thisWord = $thisWord[$wordNum];
			
			if ( in_array( $thisWord, self::$operatorWords ) ) {
				// Get the rest of the string after the operator.
				$parameters = explode( ' ', $conds, $wordNum+2);
				$parameters = trim($parameters[$wordNum+1]);

				list($firstWord,$rest) = explode( ' ', $parameters, 2 );
				if (in_array( $firstWord, self::$modifierWords ) && in_array( $rest, array_keys($vars))) {
					// Allow the compare target to be modified, too.
					$parameters = self::modifyValue( $firstWord, $vars[$rest] );					
				} elseif (in_array( $parameters, array_keys( $vars ) )) {
					$parameters = $vars[$parameters];
				}
				
				wfProfileOut( "$fname-evaluate");
				
				$result = self::checkOperator( $thisWord, $value, $parameters );
				
				if ($result)
					self::$condMatchCount[$conds]++;
				
				return $result;
			}
		} else {
// 			print "Unknown var $thisWord\n";
		}
		wfProfileOut( "$fname-evaluate");
	}
	
	public static function tokeniseList( $list ) {
		if (isset(self::$tokenCache[$list])) {
			return self::$tokenCache[$list];
		}
		
		wfProfileIn( __METHOD__ );

		// Parse it, character by character.
		$escapeNext = false;
		$listLevel = 0;
		$thisToken = '';
		$allTokens = array();
		for( $i=0;$i<strlen($list);$i++ ) {
			$char = substr( $list, $i, 1 );
			
			$suppressAdd = false;
			
			// We don't care about semicolons and so on unless it's 
			if ($listLevel == 0) {
				if ($char == "\\") {
					if ($escapeNext) { // Escaped backslash
						$escapeNext = false;
					} else {
						$escapeNext = true;
						$suppressAdd = true;
					}
				} elseif ($char == ';') {
					if ($escapeNext) {
						$escapeNext = false; // Escaped semicolon
					} else { // Next token, plz
						$escapeNext = false;
						$allTokens[] = $thisToken;
						$thisToken = '';
						$suppressAdd = true;
					}
				} elseif ($escapeNext) {
					$escapeNext = false;
					$thisToken .= "\\"; // The backslash wasn't intended to escape.
				}
			}
			
			if ($char == '(' && $lastChar == ';') {
				// A list!
				$listLevel++;
			} elseif ($char == ')' && ($lastChar == ';' || $lastChar == ')' || $lastChar = '') ) {
				$listLevel--; // End of a list.
			}
			
			if (!$suppressAdd) {
				$thisToken .= $char;
			}
			
			// Ignore whitespace.
			if ($char != ' ' && $char != "\n" && $char != "\t") {
				$lastChar = $char;
			}
		}
		
		// Put any leftovers in
		$allTokens[] = $thisToken;

		// Don't let it fill up.
		if (count(self::$tokenCache)<=1000) {
			self::$tokenCache[$list] = $allTokens;
		}
		
		wfProfileOut( __METHOD__ );
		
		return $allTokens;
	}
	
	public static function modifyValue( $modifier, $value ) {
		if (isset(self::$modifyCache[$modifier][$value]))
			return self::$modifyCache[$modifier][$value];

		wfProfileIn( __METHOD__ );
		wfProfileIn( __METHOD__.'-'.$modifier );

		if ($modifier == 'norm') {
			$val = self::normalise( $value );
		} elseif ($modifier == 'supernorm') {
			$val = self::superNormalise( $value );
		} elseif ($modifier == 'lcase') {
			$val = strtolower($value);
		} elseif ($modifier == 'length') {
			$val = strlen($value);
		} elseif ($modifier == 'specialratio') {
			$specialsonly = preg_replace('/\w/', '', $value );
			$val = (strlen($specialsonly) / strlen($value));
		} elseif ($modifier == 'htmlencode') {
			$val = htmlspecialchars($value);
		} elseif ($modifier == 'htmldecode') {
			$val = htmlspecialchars_decode($value);
		} elseif ($modifier == 'urlencode') {
			$val = urlencode($value);
		} elseif ($modifier == 'urldecode') {
			$val = urldecode($value);
		} elseif ($modifier == 'htmlfullencode') {
			$val = htmlentities( $value );
		} elseif ($modifier == 'simplenorm') {
			$val = preg_replace( '/[\d\W]+/', '', $value );
			$val = strtolower( $value );
		}

		if (count(self::$modifyCache[$modifier][$value]) > 1000) {
			self::$modifyCache = array();
		}
		
		wfProfileOut( __METHOD__.'-'.$modifier );
		wfProfileOut( __METHOD__ );

		return self::$modifyCache[$modifier][$value] = $val;
	}
	
	public static function checkOperator( $operator, $value, $parameters ) {		
		wfProfileIn( __METHOD__ );
		wfProfileIn( __METHOD__.'-'.$operator );
		
		if ($operator == 'eq') {
			$val = $value == $parameters;
		} elseif ($operator == 'neq') {
			$val = $value != $parameters;
		} elseif ($operator == 'gt') {
			$val = $value > $parameters;
		} elseif ($operator == 'lt') {
			$val = $value < $parameters;
		} elseif ($operator == 'regex') {
			$val = preg_match( $parameters, $value );
		} elseif ($operator == 'contains') {
			$val = strpos(  $value, $parameters ) !== false;
		} else {
			$val = false;
		}
		
		wfProfileOut( __METHOD__.'-'.$operator );
		wfProfileOut( __METHOD__ );
		
		return $val;
	}
	
	public static function superNormalise( $text ) {
		wfProfileIn( __METHOD__ );
		$text = self::normalise( $text );
		$text = AntiSpoof::stringToList($text); // Split to a char array.
		sort($text);
		$text = array_unique( $text ); // Remove duplicate characters.
		$text = AntiSpoof::listToString( $text );
		wfProfileOut( __METHOD__ );
		
		return $text;
	}
	
	public static function normalise( $text ) {
		wfProfileIn( __METHOD__ );
		$old_text = $text;
		$text = strtolower($text);
		$text = AntiSpoof::stringToList( $text );
		$text = AntiSpoof::equivString( $text ); // Normalise
		
		// Remove repeated characters, but not all duplicates.
		$oldText = $text;
		$text = array($oldText[0]);
		for ($i=1;$i<count($oldText);$i++) {
			if ($oldText[$i] != $oldText[$i-1]) {
				$text[] = $oldText[$i];
			}
		}
		
		$text = AntiSpoof::listToString( $text ); // Sort in alphabetical order, put back as it was.

		$text = preg_replace( '/\W/', '', $text ); // Remove any special characters.
		
		wfProfileOut( __METHOD__ );
		
		return $text;
	}
	
	public static function tokenCacheKey() {
		return wfMemcKey( 'abusefilter', 'tokencache' );
	}
	
	public static function filterAction( $vars, $title ) {
		global $wgUser,$wgMemc;
		
		// Pick up cached data
		if (!count(self::$tokenCache)) {
			self::$tokenCache = $wgMemc->get( self::tokenCacheKey() );
		}
		
		$tokenCacheCount_orig = count( self::$tokenCache );
		
		// Fetch from the database.
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'abuse_filter', '*', array( 'af_enabled' => 1 ) );
		
		$blocking_filters = array();
		$log_entries = array();
		$log_template = array( 'afl_user' => $wgUser->getId(), 'afl_user_text' => $wgUser->getName(),
					'afl_var_dump' => serialize( $vars ), 'afl_timestamp' => $dbr->timestamp(wfTimestampNow()),
					'afl_namespace' => $title->getNamespace(), 'afl_title' => $title->getDbKey(), 'afl_ip' => wfGetIp() );
		$doneActionsByFilter = array();
		$filter_matched = array();
		
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( self::checkConditions( $row->af_pattern, $vars ) ) {
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
	
		// Don't store stats if the cond limit is disabled.
		// It's probably a batch process or similar.
		if (!self::$condLimitEnabled)
			self::recordStats( $filter_matched );
			
		// Store the token list in memcached for future use.
		
		if (count(self::$tokenCache) > $tokenCacheCount_orig) {
			if (count(self::$tokenCache) > 750) {
				// slice the first quarter off.
				// This way, out-of-date stuff eventually goes away.
				self::$tokenCache = array_slice( self::$tokenCache, 250, 500, true /* preserve keys */ );
			}
		
			$wgMemc->set( self::tokenCacheKey(), self::$tokenCache, 86400 );
		}
		
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
				$result = self::takeConsequenceAction( $row->afa_consequence, $parameters, $title, $vars, &$display, &$continue, $blocking_filters[$row->afa_filter]->af_public_comments );
				
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
			$log_entries[$index]['afl_actions'] = implode( ',', $doneActionsByFilter[$entry['afl_filter']] );
			
			// Increment the hit counter
			$dbw->update( 'abuse_filter', array( 'af_hit_count=af_hit_count+1' ), array( 'af_id' => $entry['afl_filter'] ), __METHOD__ );
		}
		
		$dbw->insert( 'abuse_filter_log', $log_entries, __METHOD__ );
		
		return $display;
	}
	
	public static function takeConsequenceAction( $action, $parameters, $title, $vars, &$display, &$continue, $rule_desc ) {
		switch ($action) {
			case 'warn':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				if (!$_SESSION['abusefilter-warned']) {
					$_SESSION['abusefilter-warned'] = true;
					
					// Threaten them a little bit
					if (strlen($parameters[0])) {
						$display .= call_user_func_array( 'wfMsgNoTrans', $parameters ) . "\n";
					} else {
						// Generic message.
						$display .= wfMsgNoTrans( 'abusefilter-warning', $rule_desc ) ."<br />\n";
					}
					
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
					$display .= call_user_func_array( 'wfMsgNoTrans', $parameters ) . "\n";
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
				$block->mBy = User::idFromName( wfMsgForContent( 'abusefilter-blocker' ) ); // Let's say the site owner blocked them
				$block->mByName = wfMsgForContent( 'abusefilter-blocker' );
				$block->mReason = wfMsgForContent( 'abusefilter-blockreason', $rule_desc );
				$block->mTimestamp = wfTimestampNow();
				$block->mEnableAutoblock = 1;
				$block->mAngryAutoblock = 1; // Block lots of IPs
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
				
				break;
			case 'blockautopromote':
				wfLoadExtensionMessages( 'AbuseFilter' );
				
				global $wgUser, $wgMemc;
				
				$blockPeriod = (int)mt_rand( 3*86400, 7*86400 ); // Block for 3-7 days.
				$wgMemc->set( self::autoPromoteBlockKey( $wgUser ), true, $blockPeriod );
				
				$display .= wfMsgNoTrans( 'abusefilter-autopromote-blocked', $rule_desc ) ."<br />\n";
				
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
				//die( "Hit rate limiter: $count actions, against limit of $rateCount actions in $ratePeriod seconds (key is $key).\n" );
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
		
		global $wgAbuseFilterEmergencyDisableThreshold, $wgAbuseFilterEmergencyDisableCount;
		
		foreach( $filters as $filter => $matched ) {
			if ($matched) {
				$anyMatch = true;
				$match_count = $wgMemc->get( self::filterMatchesKey( $filter ) );
				
				if ($match_count > 0) {
					$wgMemc->incr( self::filterMatchesKey( $filter ) );
				} else {
					$wgMemc->set( self::filterMatchesKey( $filter ), 1, self::$statsStoragePeriod );
				}
				
				if ($match_count > $wgAbuseFilterEmergencyDisableCount && ($match_count / $total) > $wgAbuseFilterEmergencyDisableThreshold) {
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
