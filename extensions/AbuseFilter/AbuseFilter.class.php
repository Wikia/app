<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class AbuseFilter {
	public static $statsStoragePeriod = 86400;
	public static $tokenCache = array();
	public static $modifyCache = array();
	public static $condLimitEnabled = true;
	public static $condCount = 0;
	public static $filters = array();
	public static $tagsToSet = array();
	public static $history_mappings = array(
		'af_pattern' => 'afh_pattern',
		'af_user' => 'afh_user',
		'af_user_text' => 'afh_user_text',
		'af_timestamp' => 'afh_timestamp',
		'af_comments' => 'afh_comments',
		'af_public_comments' => 'afh_public_comments',
		'af_deleted' => 'afh_deleted',
		'af_id' => 'afh_filter'
	);
	public static $builderValues = array(
		'op-arithmetic' => array(
			'+' => 'addition',
			'-' => 'subtraction',
			'*' => 'multiplication',
			'/' => 'divide',
			'%' => 'modulo',
			'**' => 'pow'
		),
		'op-comparison' => array(
			'==' => 'equal',
			'!=' => 'notequal',
			'<' => 'lt',
			'>' => 'gt',
			'<=' => 'lte',
			'>=' => 'gte'
		),
		'op-bool' => array(
			'!' => 'not',
			'&' => 'and',
			'|' => 'or',
			'^' => 'xor'
		),
		'misc' => array(
			'in' => 'in',
			'contains' => 'contains',
			'like' => 'like',
			'""' => 'stringlit',
			'rlike' => 'rlike',
			'irlike' => 'irlike',
			'cond ? iftrue : iffalse' => 'tern',
			'if cond then iftrue elseiffalse end' => 'cond',
		),
		'funcs' => array(
			'length(string)' => 'length',
			'lcase(string)' => 'lcase',
			'ccnorm(string)' => 'ccnorm',
			'rmdoubles(string)' => 'rmdoubles',
			'specialratio(string)' => 'specialratio',
			'norm(string)' => 'norm',
			'count(needle,haystack)' => 'count',
			'rcount(needle,haystack)' => 'rcount',
			'rmwhitespace(text)' => 'rmwhitespace',
			'rmspecials(text)' => 'rmspecials',
			'ip_in_range(ip, range)' => 'ip_in_range',
			'contains_any(haystack,needle1,needle2,needle3)' => 'contains-any',
			'substr(subject, offset, length)' => 'substr',
			'strpos(haystack, needle)' => 'strpos',
			'str_replace(subject, search, replace)' => 'str_replace',
			'rescape(string)' => 'rescape',
			'set_var(var,value)' => 'set_var',
		),
		'vars' => array(
			'timestamp' => 'timestamp',
			'accountname' => 'accountname',
			'action' => 'action',
			'added_lines' => 'addedlines',
			'edit_delta' => 'delta',
			'edit_diff' => 'diff',
			'new_size' => 'newsize',
			'old_size' => 'oldsize',
			'removed_lines' => 'removedlines',
			'summary' => 'summary',
			'article_articleid' => 'article-id',
			'article_namespace' => 'article-ns',
			'article_text' => 'article-text',
			'article_prefixedtext' => 'article-prefixedtext',
			'moved_from_articleid' => 'movedfrom-id',
			'moved_from_namespace' => 'movedfrom-ns',
			'moved_from_text' => 'movedfrom-text',
			'moved_from_prefixedtext' => 'movedfrom-prefixedtext',
			'moved_to_articleid' => 'movedto-id',
			'moved_to_namespace' => 'movedto-ns',
			'moved_to_text' => 'movedto-text',
			'moved_to_prefixedtext' => 'movedto-prefixedtext',
			'user_editcount' => 'user-editcount',
			'user_age' => 'user-age',
			'user_name' => 'user-name',
			'user_groups' => 'user-groups',
			'user_emailconfirm' => 'user-emailconfirm',
			'old_wikitext' => 'old-text',
			'new_wikitext' => 'new-text',
			'added_links' => 'added-links',
			'removed_links' => 'removed-links',
			'all_links' => 'all-links',
			'new_text' => 'new-text-stripped',
			'new_html' => 'new-html',
			'article_restrictions_edit' => 'restrictions-edit',
			'article_restrictions_move' => 'restrictions-move',
			'article_recent_contributors' => 'recent-contributors',
#			'old_text' => 'old-text-stripped', # Disabled, performance
#			'old_html' => 'old-html', # Disabled, performance
			'old_links' => 'old-links',
			'minor_edit' => 'minor-edit',
			'file_sha1' => 'file-sha1',
		),
	);
	public static $editboxName = null;

	public static function addNavigationLinks( IContextSource $context, $pageType ) {
		$linkDefs = array(
			'home' => 'Special:AbuseFilter',
			'recentchanges' => 'Special:AbuseFilter/history',
			'test' => 'Special:AbuseFilter/test',
			'examine' => 'Special:AbuseFilter/examine',
			'log' => 'Special:AbuseLog',
		);

		if ( $context->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			$linkDefs = array_merge( $linkDefs, array(
					'tools' => 'Special:AbuseFilter/tools',
					'import' => 'Special:AbuseFilter/import',
				) );
		}

		// Save some translator work
		$msgOverrides = array(
			'recentchanges' => 'abusefilter-filter-log',
		);

		$links = array();

		foreach ( $linkDefs as $name => $page ) {
			// Give grep a chance to find the usages:
			// abusefilter-topnav-home, abusefilter-topnav-test, abusefilter-topnav-examine
			// abusefilter-topnav-log, abusefilter-topnav-tools, abusefilter-topnav-import
			$msgName = "abusefilter-topnav-$name";

			if ( isset( $msgOverrides[$name] ) ) {
				$msgName = $msgOverrides[$name];
			}

			$msg = wfMsgExt( $msgName, 'parseinline' );
			$title = Title::newFromText( $page );

			if ( $name == $pageType ) {
				$links[] = Xml::tags( 'strong', null, $msg );
			} else {
				$links[] = $context->getSkin()->link( $title, $msg );
			}
		}

		$linkStr = wfMsg( 'parentheses', $context->getLanguage()->pipeList( $links ) );
		$linkStr = wfMsgExt( 'abusefilter-topnav', 'parseinline' ) . " $linkStr";

		$linkStr = Xml::tags( 'div', array( 'class' => 'mw-abusefilter-navigation' ), $linkStr );

		$context->getOutput()->setSubtitle( $linkStr );
	}

	/**
	 * @static
	 * @param  $user User
	 * @return AbuseFilterVariableHolder
	 */
	public static function generateUserVars( $user ) {
		$vars = new AbuseFilterVariableHolder;

		$vars->setLazyLoadVar( 'user_editcount', 'simple-user-accessor',
			array( 'user' => $user->getName(), 'method' => 'getEditCount' ) );
		$vars->setVar( 'user_name', $user->getName() );
		$vars->setLazyLoadVar( 'user_emailconfirm', 'simple-user-accessor',
			array( 'user' => $user->getName(), 'method' => 'getEmailAuthenticationTimestamp' ) );

		$vars->setLazyLoadVar( 'user_age', 'user-age',
			array( 'user' => $user->getName(), 'asof' => wfTimestampNow() ) );
		$vars->setLazyLoadVar( 'user_groups', 'user-groups', array( 'user' => $user->getName() ) );

		return $vars;
	}

	public static function getBuilderValues() {
		static $realValues = null;

		if ( $realValues ) {
			return $realValues;
		}

		$realValues = self::$builderValues;
		Hooks::run( 'AbuseFilter-builder', array( &$realValues ) );

		return $realValues;
	}

	public static function filterHidden( $filter ) {
		$globalIndex = self::decodeGlobalName( $filter );
		if ( $globalIndex ) {
			global $wgAbuseFilterCentralDB;
			if ( !$wgAbuseFilterCentralDB ) {
				return false;
			}
			$dbr = wfGetDB( DB_SLAVE, array(), $wgAbuseFilterCentralDB );
			$filter = $globalIndex;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
		}
		$hidden = $dbr->selectField(
			'abuse_filter',
			'af_hidden',
			array( 'af_id' => $filter ),
			__METHOD__
		);
		return $hidden ? true : false;
	}

	public static function triggerLimiter( $val = 1 ) {
		self::$condCount += $val;

		global $wgAbuseFilterConditionLimit;

		if ( self::$condCount > $wgAbuseFilterConditionLimit ) {
			throw new MWException( 'Condition limit reached.' );
		}
	}

	public static function disableConditionLimit() {
		// For use in batch scripts and the like
		self::$condLimitEnabled = false;
	}

	/**
	 * @static
	 * @param  $title Title
	 * @param  $prefix
	 * @return AbuseFilterVariableHolder
	 */
	public static function generateTitleVars( $title, $prefix ) {
		$vars = new AbuseFilterVariableHolder;

		if ( !$title ) {
			return new AbuseFilterVariableHolder;
		}

		$vars->setVar( $prefix . '_ARTICLEID', $title->getArticleId() );
		$vars->setVar( $prefix . '_NAMESPACE', $title->getNamespace() );
		$vars->setVar( $prefix . '_TEXT', $title->getText() );
		$vars->setVar( $prefix . '_PREFIXEDTEXT', $title->getPrefixedText() );

		// Use restrictions.
		global $wgRestrictionTypes;
		foreach ( $wgRestrictionTypes as $action ) {
			$vars->setLazyLoadVar( "{$prefix}_restrictions_$action", 'get-page-restrictions',
				array( 'title' => $title->getText(),
						'namespace' => $title->getNamespace(),
						'action' => $action
					)
				);
		}

		$vars->setLazyLoadVar( "{$prefix}_recent_contributors", 'load-recent-authors',
				array(
					'cutoff' => wfTimestampNow(),
					'title' => $title->getText(),
					'namespace' => $title->getNamespace()
				) );

		return $vars;
	}

	public static function checkSyntax( $filter ) {
		global $wgAbuseFilterParserClass;

		$parser = new $wgAbuseFilterParserClass;

		return $parser->checkSyntax( $filter );
	}

	public static function evaluateExpression( $expr, $vars = array() ) {
		global $wgAbuseFilterParserClass;

		if ( self::checkSyntax( $expr ) !== true ) {
			return 'BADSYNTAX';
		}

		$parser = new $wgAbuseFilterParserClass;

		$parser->setVars( $vars );

		return $parser->evaluateExpression( $expr );
	}

	public static function checkConditions( $conds, $vars, $ignoreError = true,
											$keepVars = 'resetvars' ) {
		global $wgAbuseFilterParserClass;

		static $parser;

		wfProfileIn( __METHOD__ );

		if ( is_null( $parser ) || $keepVars == 'resetvars' ) {
			$parser = new $wgAbuseFilterParserClass;

			$parser->setVars( $vars );
		}

		try {
			$result = $parser->parse( $conds, self::$condCount );
		} catch ( Exception $excep ) {
			// Sigh.
			$result = false;

			wfDebugLog( 'AbuseFilter', 'AbuseFilter parser error: ' . $excep->getMessage() . "\n" );

			if ( !$ignoreError ) {
				throw $excep;
			}
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Returns an associative array of filters which were tripped
	 *
	 * @param $vars array
	 *
	 * @return array
	 */
	public static function checkAllFilters( $vars ) {
		// Fetch from the database.
		wfProfileIn( __METHOD__ );

		$filter_matched = array();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'abuse_filter',
			'*',
			array( 'af_enabled' => 1, 'af_deleted' => 0 ),
			__METHOD__
		);

		foreach( $res as $row ) {
			$filter_matched[$row->af_id] = self::checkFilter( $row, $vars, true );
		}

		global $wgAbuseFilterCentralDB, $wgAbuseFilterIsCentral;
		if ( $wgAbuseFilterCentralDB && !$wgAbuseFilterIsCentral ) {
			// Global filters
			$fdb = wfGetDB( DB_SLAVE, array(), $wgAbuseFilterCentralDB );
			$res = $fdb->select(
				'abuse_filter',
				'*',
				array(
					'af_enabled' => 1,
					'af_deleted' => 0,
					'af_global' => 1
				),
				__METHOD__
			);

			foreach( $res as $row ) {
				$filter_matched['global-' . $row->af_id] =
					self::checkFilter( $row, $vars, true, 'global-' );
			}
		}

		// Update statistics, and disable filters which are over-blocking.
		self::recordStats( $filter_matched );

		wfProfileOut( __METHOD__ );

		return $filter_matched;
	}

	public static function checkFilter( $row, $vars, $profile = false, $prefix = '' ) {
		$filterID = $prefix . $row->af_id;

		if ( $profile ) {
			$startConds = self::$condCount;
			$startTime = microtime( true );
		}

		// Store the row somewhere convenient
		self::$filters[$filterID] = $row;

		// Check conditions...
		$pattern = trim( $row->af_pattern );
		if ( self::checkConditions( $pattern, $vars, true /* ignore errors */,
									'keepvars' ) ) {
			// Record match.
			$result = true;
		} else {
			// Record non-match.
			$result = false;
		}

		if ( $profile ) {
			$endTime = microtime( true );
			$endConds = self::$condCount;

			$timeTaken = $endTime - $startTime;
			$condsUsed = $endConds - $startConds;

			self::recordProfilingResult( $row->af_id, $timeTaken, $condsUsed );
		}

		return $result;
	}

	public static function resetFilterProfile( $filter ) {
		global $wgMemc;
		$countKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'count' );
		$totalKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'total' );

		$wgMemc->delete( $countKey );
		$wgMemc->delete( $totalKey );
	}

	public static function recordProfilingResult( $filter, $time, $conds ) {
		global $wgMemc;

		$countKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'count' );
		$totalKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'total' );
		$totalCondKey = wfMemcKey( 'abusefilter', 'profile-conds', 'total' );

		$curCount = $wgMemc->get( $countKey );
		$curTotal = $wgMemc->get( $totalKey );
		$curTotalConds = $wgMemc->get( $totalCondKey );

		if ( $curCount ) {
			$wgMemc->set( $totalCondKey, $curTotalConds + $conds, 3600 );
			$wgMemc->set( $totalKey, $curTotal + $time, 3600 );
			$wgMemc->incr( $countKey );
		} else {
			$wgMemc->set( $countKey, 1, 3600 );
			$wgMemc->set( $totalKey, $time, 3600 );
			$wgMemc->set( $totalCondKey, $conds, 3600 );
		}
	}

	public static function getFilterProfile( $filter ) {
		global $wgMemc;

		$countKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'count' );
		$totalKey = wfMemcKey( 'abusefilter', 'profile', $filter, 'total' );
		$totalCondKey = wfMemcKey( 'abusefilter', 'profile-conds', 'total' );

		$curCount = $wgMemc->get( $countKey );
		$curTotal = $wgMemc->get( $totalKey );
		$curTotalConds = $wgMemc->get( $totalCondKey );

		if ( !$curCount ) {
			return array( 0, 0 );
		}

		$timeProfile = ( $curTotal / $curCount ) * 1000; // 1000 ms in a sec
		$timeProfile = round( $timeProfile, 2 ); // Return in ms, rounded to 2dp

		$condProfile = ( $curTotalConds / $curCount );
		$condProfile = round( $condProfile, 0 );

		return array( $timeProfile, $condProfile );
	}

	/**
	 * Utility function to decode global-$index to $index. Returns false if not global
	 *
	 * @param $filter string
	 *
	 * @return string|false
	 */
	public static function decodeGlobalName( $filter ) {
		if ( strpos( $filter, 'global-' ) == 0 ) {
			return substr( $filter, strlen( 'global-' ) );
		}

		return false;
	}

	public static function getConsequencesForFilters( $filters ) {
		$globalFilters = array();
		$localFilters = array();

		foreach ( $filters as $filter ) {
			$globalIndex = self::decodeGlobalName( $filter );

			if ( $globalIndex ) {
				$globalFilters[] = $globalIndex;
			} else {
				$localFilters[] = $filter;
			}
		}

		global $wgAbuseFilterCentralDB;
		// Load local filter info
		$dbr = wfGetDB( DB_SLAVE );
		// Retrieve the consequences.
		$consequences = array();

		if ( count( $localFilters ) ) {
			$consequences = self::loadConsequencesFromDB( $dbr, $localFilters );
		}

		if ( count( $globalFilters ) ) {
			$fdb = wfGetDB( DB_SLAVE, array(), $wgAbuseFilterCentralDB );
			$consequences = array_merge(
				$consequences,
				self::loadConsequencesFromDB( $fdb, $globalFilters, 'global-' )
			);
		}

		return $consequences;
	}

	public static function loadConsequencesFromDB( $dbr, $filters, $prefix = '' ) {
		$actionsByFilter = array();
		foreach ( $filters as $filter ) {
			$actionsByFilter[$prefix . $filter] = array();
		}

		$res = $dbr->select(
			array( 'abuse_filter_action', 'abuse_filter' ),
			'*',
			array( 'af_id' => $filters ),
			__METHOD__,
			array(),
			array( 'abuse_filter_action' => array( 'LEFT JOIN', 'afa_filter=af_id' ) )
		);

		// Categorise consequences by filter.
		global $wgAbuseFilterRestrictedActions;
		foreach( $res as $row ) {
			if ( $row->af_throttled
				&& in_array( $row->afa_consequence, $wgAbuseFilterRestrictedActions ) )
			{
				# Don't do the action
			} elseif ( $row->afa_filter != $row->af_id ) {
				// We probably got a NULL, as it's a LEFT JOIN.
				// Don't add it.
			} else {
				$actionsByFilter[$prefix . $row->afa_filter][$row->afa_consequence] = array(
					'action' => $row->afa_consequence,
					'parameters' => explode( "\n", $row->afa_parameters )
				);
			}
		}

		return $actionsByFilter;
	}

	/**
	 * Returns an array [ list of actions taken by filter, error message to display, if any ]
	 *
	 * @param $filters array
	 * @param $title Title
	 * @param $vars array
	 * @return array
	 */
	public static function executeFilterActions( $filters, $title, $vars ) {
		wfProfileIn( __METHOD__ );
		static $blockingActions = array(
			'block',
			'rangeblock',
			'degroup',
			'blockautopromote'
		);

		$actionsByFilter = self::getConsequencesForFilters( $filters );
		$actionsTaken = array_fill_keys( $filters, array() );

		$messages = array();

		foreach ( $actionsByFilter as $filter => $actions ) {
			// Special-case handling for warnings.
			global $wgOut;
			$parsed_public_comments = $wgOut->parseInline(
				self::$filters[$filter]->af_public_comments );

			if ( !empty( $actions['throttle'] ) ) {
				$parameters = $actions['throttle']['parameters'];
				$throttleId = array_shift( $parameters );
				list( $rateCount, $ratePeriod ) = explode( ',', array_shift( $parameters ) );

				$hitThrottle = false;

				// The rest are throttle-types.
				foreach ( $parameters as $throttleType ) {
					$hitThrottle = $hitThrottle || self::isThrottled(
						$throttleId, $throttleType, $title, $rateCount, $ratePeriod );
				}

				unset( $actions['throttle'] );
				if ( !$hitThrottle ) {
					$actionsTaken[$filter][] = 'throttle';
					continue;
				}
			}

			if ( !empty( $actions['warn'] ) ) {
				$parameters = $actions['warn']['parameters'];
				$warnKey = 'abusefilter-warned-' . $title->getPrefixedText() . '-' . $filter;
				if ( !isset( $_SESSION[$warnKey] ) || !$_SESSION[$warnKey] ) {
					$_SESSION[$warnKey] = true;

					// Threaten them a little bit
					if ( !empty( $parameters[0] ) && strlen( $parameters[0] ) ) {
						$msg = $parameters[0];
					} else {
						$msg = 'abusefilter-warning';
					}
					$messages[] = wfMsgExt( $msg, 'parseinline',
						array( $parsed_public_comments, $filter ) ) . "<br />\n";

					$actionsTaken[$filter][] = 'warn';

					continue; // Don't do anything else.
				} else {
					// We already warned them
					$_SESSION[$warnKey] = false;
				}

				unset( $actions['warn'] );
			}

			// prevent double warnings
			if ( count( array_intersect( array_keys( $actions ), $blockingActions ) ) > 0 &&
					!empty( $actions['disallow'] ) ) {
				unset( $actions['disallow'] );
			}

			// Do the rest of the actions
			foreach ( $actions as $action => $info ) {
				$newMsg = self::takeConsequenceAction(
					$action, $info['parameters'], $title, $vars,
					self::$filters[$filter]->af_public_comments
				);

				if ( $newMsg ) {
					$messages[] = $newMsg;
				}
				$actionsTaken[$filter][] = $action;
			}
		}

		wfProfileOut( __METHOD__ );
		return array( $actionsTaken, implode( "\n", $messages ) );
	}

	public static function filterAction( $vars, $title ) {
		global $wgUser, $wgTitle;

		/* Wikia change begin: Needed to be able to bypass filters */
		if ( !Hooks::run( 'AbuseFilterShouldFilter', array( $wgUser ) ) ) {
			return true;
		}
		/* Wikia change end */

		wfProfileIn( __METHOD__ );

		if ( !$wgTitle ) {
			$wgTitle = SpecialPage::getTitleFor( 'AbuseFilter' );
		}

		// Add vars from extensions
		Hooks::run( 'AbuseFilter-filterAction', array( $vars, $title ) );

		// Set context
		$vars->setVar( 'context', 'filter' );
		$vars->setVar( 'timestamp', time() );

		$dbr = wfGetDB( DB_SLAVE );

		$filter_matched = self::checkAllFilters( $vars );

		// Short-cut any remaining code if no filters were hit.
		if ( count( array_filter( $filter_matched ) ) == 0 ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileIn( __METHOD__ . '-block' );

		list( $actions_taken, $error_msg ) = self::executeFilterActions(
			array_keys( array_filter( $filter_matched ) ), $title, $vars );

		$action = $vars->getVar( 'ACTION' )->toString();

		// Create a template
		$log_template = array(
			'afl_user' => $wgUser->getId(),
			'afl_user_text' => $wgUser->getName(),
			'afl_timestamp' => $dbr->timestamp( wfTimestampNow() ),
			'afl_namespace' => $title->getNamespace(),
			'afl_title' => $title->getDBkey(),
			'afl_ip' => wfGetIP()
		);

		// Hack to avoid revealing IPs of people creating accounts
		if ( !$wgUser->getId() && $action == 'createaccount' ) {
			$log_template['afl_user_text'] = $vars->getVar( 'accountname' )->toString();
		}

		self::addLogEntries( $actions_taken, $log_template, $action, $vars );

		$error_msg = $error_msg == '' ? true : $error_msg;

		wfProfileOut( __METHOD__ . '-block' );

		wfProfileOut( __METHOD__ );

		return $error_msg;
	}

	public static function addLogEntries( $actions_taken, $log_template, $action, $vars ) {
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );

		$central_log_template = array(
			'afl_wiki' => wfWikiID(),
		);

		$log_rows = array();
		$central_log_rows = array();
		$logged_local_filters = array();
		$logged_global_filters = array();

		foreach ( $actions_taken as $filter => $actions ) {
			$globalIndex = self::decodeGlobalName( $filter );
			$thisLog = $log_template;
			$thisLog['afl_filter'] = $filter;
			$thisLog['afl_action'] = $action;
			$thisLog['afl_actions'] = implode( ',', $actions );

			// Don't log if we were only throttling.
			if ( $thisLog['afl_actions'] != 'throttle' ) {
				$log_rows[] = $thisLog;

				if ( !$globalIndex ) {
					$logged_local_filters[] = $filter;
				}

				// Global logging
				if ( $globalIndex ) {
					$title = Title::makeTitle( $thisLog['afl_namespace'],
												$thisLog['afl_title'] );
					$centralLog = $thisLog + $central_log_template;
					$centralLog['afl_filter'] = $globalIndex;
					$centralLog['afl_title'] = $title->getPrefixedText();
					$centralLog['afl_namespace'] = 0;

					$central_log_rows[] = $centralLog;
					$logged_global_filters[] = $globalIndex;
				}
			}
		}

		if ( !count( $log_rows ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		// Only store the var dump if we're actually going to add log rows.
		$var_dump = self::storeVarDump( $vars );
		$var_dump = "stored-text:$var_dump"; // To distinguish from stuff stored directly

		foreach ( $log_rows as $index => $data ) {
			$log_rows[$index]['afl_var_dump'] = $var_dump;
		}

		wfProfileIn( __METHOD__ . '-hitstats' );

		global $wgMemc;

		// Increment trigger counter
		$wgMemc->incr( self::filterMatchesKey() );

		$dbw->insert( 'abuse_filter_log', $log_rows, __METHOD__ );

		if ( count( $logged_local_filters ) ) {
			// Update hit-counter.
			$dbw->update( 'abuse_filter',
				array( 'af_hit_count=af_hit_count+1' ),
				array( 'af_id' => $logged_local_filters ),
				__METHOD__
			);
		}

		// Global stuff
		if ( count( $logged_global_filters ) ) {
			$vars->computeDBVars();
			$global_var_dump = self::storeVarDump( $vars, 'global' );
			$global_var_dump = "stored-text:$global_var_dump";
			foreach ( $central_log_rows as $index => $data ) {
				$central_log_rows[$index]['afl_var_dump'] = $global_var_dump;
			}

			global $wgAbuseFilterCentralDB;
			$fdb = wfGetDB( DB_MASTER, array(), $wgAbuseFilterCentralDB );

			$fdb->insert( 'abuse_filter_log', $central_log_rows, __METHOD__ );

			$fdb->update( 'abuse_filter',
				array( 'af_hit_count=af_hit_count+1' ),
				array( 'af_id' => $logged_global_filters ),
				__METHOD__
			);
		}

		// Check for emergency disabling.
		$total = $wgMemc->get( AbuseFilter::filterUsedKey() );
		self::checkEmergencyDisable( $logged_local_filters, $total );

		wfProfileOut( __METHOD__ . '-hitstats' );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Store a var dump to External Storage or the text table
	 * Some of this code is stolen from Revision::insertOn and friends
	 *
	 * @param $vars array
	 * @param $global bool
	 *
	 * @return int
	 */
	public static function storeVarDump( $vars, $global = false ) {
		wfProfileIn( __METHOD__ );

		global $wgCompressRevisions;

		if ( is_array( $vars ) || is_object( $vars ) ) {
			$text = serialize( $vars );
		} else {
			$text = $vars;
		}

		$flags = array();

		if ( $wgCompressRevisions ) {
			if ( function_exists( 'gzdeflate' ) ) {
				$text = gzdeflate( $text );
				$flags[] = 'gzip';
			}
		}

		// Store to ES if applicable
		global $wgDefaultExternalStore, $wgAbuseFilterCentralDB;
		if ( $wgDefaultExternalStore ) {
			if ( $global ) {
				$text = ExternalStore::insertToForeignDefault( $text, $wgAbuseFilterCentralDB );
			} else {
				$text = ExternalStore::insertToDefault( $text );
			}
			$flags[] = 'external';

			if ( !$text ) {
				// Not mission-critical, just return nothing
				wfProfileOut( __METHOD__ );
				return null;
			}
		}

		// Store to text table
		if ( $global ) {
			$dbw = wfGetDB( DB_MASTER, array(), $wgAbuseFilterCentralDB );
		} else {
			$dbw = wfGetDB( DB_MASTER );
		}
		$old_id = $dbw->nextSequenceValue( 'text_old_id_seq' );
		$dbw->insert( 'text',
			array(
				'old_id'    => $old_id,
				'old_text'  => $text,
				'old_flags' => implode( ',', $flags ),
			), __METHOD__
		);
		$text_id = $dbw->insertId();
		wfProfileOut( __METHOD__ );

		return $text_id;
	}

	/**
	 * Retrieve a var dump from External Storage or the text table
	 * Some of this code is stolen from Revision::loadText et al
	 *
	 * @param $stored_dump
	 *
	 * @return object
	 */
	public static function loadVarDump( $stored_dump ) {
		wfProfileIn( __METHOD__ );

		// Back-compat
		if ( strpos( $stored_dump, 'stored-text:' ) === false ) {
			wfProfileOut( __METHOD__ );
			return unserialize( $stored_dump );
		}

		$text_id = substr( $stored_dump, strlen( 'stored-text:' ) );

		$dbr = wfGetDB( DB_SLAVE );

		$text_row = $dbr->selectRow(
			'text',
			array( 'old_text', 'old_flags' ),
			array( 'old_id' => $text_id ),
			__METHOD__
		);

		if ( !$text_row ) {
			wfProfileOut( __METHOD__ );
			return new AbuseFilterVariableHolder;
		}

		$flags = explode( ',', $text_row->old_flags );
		$text = $text_row->old_text;

		if ( in_array( 'external', $flags ) ) {
			$text = ExternalStore::fetchFromURL( $text );
		}

		if ( in_array( 'gzip', $flags ) ) {
			$text = gzinflate( $text );
		}

		$obj = unserialize( $text );

		wfProfileOut( __METHOD__ );
		return $obj;
	}

	public static function takeConsequenceAction( $action, $parameters, $title,
		$vars, $rule_desc )
	{
		global $wgAbuseFilterCustomActionsHandlers;

		$display = '';
		switch ( $action ) {
			case 'disallow':
				if ( strlen( $parameters[0] ) ) {
					$display .= wfMsgExt( $parameters[0], 'parseinline', array( $rule_desc ) ) . "\n";
				} else {
					// Generic message.
					$display .= wfMsgExt( 'abusefilter-disallowed', 'parseinline',
						array( $rule_desc ) ) . "<br />\n";
				}
				break;

			case 'block':
				global $wgUser, $wgAbuseFilterBlockDuration;
				$filterUser = AbuseFilter::getFilterUser();

				// Create a block.
				$block = new Block;
				$block->setTarget( $wgUser->getName() );
				$block->setBlocker( $filterUser );
				$block->mReason = wfMsgForContent( 'abusefilter-blockreason', $rule_desc );
				$block->isHardblock( false );
				$block->mExpiry = SpecialBlock::parseExpiryInput( $wgAbuseFilterBlockDuration );

				$block->insert();

				// Log it
				# Prepare log parameters
				$logParams = array();
				if ( $block->mExpiry == 'infinity' ) {
					$logParams[] = 'indefinite';
				} else {
					$logParams[] = $wgAbuseFilterBlockDuration;
				}
				$logParams[] = 'angry-autoblock';

				$log = new LogPage( 'block' );
				$log->addEntry( 'block',
					Title::makeTitle( NS_USER, $wgUser->getName() ),
					wfMsgForContent( 'abusefilter-blockreason', $rule_desc ),
					$logParams, self::getFilterUser()
				);

				$display .= wfMsgExt( 'abusefilter-blocked-display', 'parseinline',
					array( $rule_desc ) ) . "<br />\n";
				break;
			case 'rangeblock':
				$filterUser = AbuseFilter::getFilterUser();

				$range = static::getIpRangeToBlock();

				// Create a block.
				$block = new Block;
				$block->setTarget( $range );
				$block->setBlocker( $filterUser );
				$block->mReason = wfMsgForContent( 'abusefilter-blockreason', $rule_desc );
				$block->isHardblock( false );
				$block->mExpiry = SpecialBlock::parseExpiryInput( '1 week' );

				$block->insert();

				// Log it
				# Prepare log parameters
				$logParams = array();
				$logParams[] = 'indefinite';
				$logParams[] = 'angry-autoblock';

				$log = new LogPage( 'block' );
				$log->addEntry( 'block', Title::makeTitle( NS_USER, $range ),
					wfMsgForContent( 'abusefilter-blockreason', $rule_desc ),
					$logParams, self::getFilterUser()
				);

				$display .= wfMsgExt( 'abusefilter-blocked-display', 'parseinline',
					$rule_desc ) . "<br />\n";
				break;
			case 'degroup':
				global $wgUser;
				if ( !$wgUser->isAnon() ) {
					// Remove all groups from the user. Ouch.
					$groups = $wgUser->getGroups();

					foreach ( $groups as $group ) {
						$wgUser->removeGroup( $group );
					}

					$display .= wfMsgExt( 'abusefilter-degrouped', 'parseinline',
						array( $rule_desc ) ) . "<br />\n";

					// Don't log it if there aren't any groups being removed!
					if ( !count( $groups ) ) {
						break;
					}

					// Log it.
					$log = new LogPage( 'rights' );

					$log->addEntry( 'rights',
						$wgUser->getUserPage(),
						wfMsgForContent( 'abusefilter-degroupreason', $rule_desc ),
						array(
							implode( ', ', $groups ),
							''
						),
						self::getFilterUser()
					);
				}

				break;
			case 'blockautopromote':
				global $wgUser, $wgMemc;
				if ( !$wgUser->isAnon() ) {
					$blockPeriod = (int)mt_rand( 3 * 86400, 7 * 86400 ); // Block for 3-7 days.
					$wgMemc->set( self::autoPromoteBlockKey( $wgUser ), true, $blockPeriod );

					$display .= wfMsgExt( 'abusefilter-autopromote-blocked', 'parseinline',
						array( $rule_desc ) ) . "<br />\n";
				}
				break;

			case 'flag':
				// Do nothing. Here for completeness.
				break;

			case 'tag':
				// Mark with a tag on recentchanges.
				global $wgUser;

				$actionID = implode( '-', array(
						$title->getPrefixedText(), $wgUser->getName(),
							$vars->getVar( 'ACTION' )->toString()
					) );

				AbuseFilter::$tagsToSet[$actionID] = $parameters;
				break;
			default:
				if( isset( $wgAbuseFilterCustomActionsHandlers[$action] ) ) {
					$custom_function = $wgAbuseFilterCustomActionsHandlers[$action];
					if( is_callable( $custom_function ) ) {
						$msg = call_user_func( $custom_function, $action, $parameters, $title, $vars, $rule_desc );
					}
					if( isset( $msg ) ) {
						$display .= wfMsgExt( $msg, 'parseinline', array() ) . "<br />\n";
					}
				} else {
					wfDebugLog( 'AbuseFilter', "Unrecognised action $action" );
				}
		}

		return $display;
	}

	/**
	 * Wikia change
	 * Helper function to determine the IP range to block depending on configured CIDR limits.
	 * @return string
	 */
	protected static function getIpRangeToBlock(): string {
		global $wgBlockCIDRLimit;
		$ip = RequestContext::getMain()->getRequest()->getIP();

		if ( IP::isIPv6( $ip ) ) {
			return IP::sanitizeRange( "$ip/{$wgBlockCIDRLimit['IPv6']}");
		}

		return IP::sanitizeRange( "$ip/{$wgBlockCIDRLimit['IPv4']}");
	}

	public static function isThrottled( $throttleId, $types, $title, $rateCount, $ratePeriod ) {
		global $wgMemc;

		$key = self::throttleKey( $throttleId, $types, $title );
		$count = intval( $wgMemc->get( $key ) );

		wfDebugLog( 'AbuseFilter', "Got value $count for throttle key $key\n" );

		if ( $count > 0 ) {
			$wgMemc->incr( $key );
			$count++;
			wfDebugLog( 'AbuseFilter', "Incremented throttle key $key" );
		} else {
			wfDebugLog( 'AbuseFilter', "Added throttle key $key with value 1" );
			$wgMemc->add( $key, 1, $ratePeriod );
			$count = 1;
		}

		if ( $count > $rateCount ) {
			wfDebugLog( 'AbuseFilter', "Throttle $key hit value $count -- maximum is $rateCount." );
			return true; // THROTTLED
		}

		wfDebugLog( 'AbuseFilter', "Throttle $key not hit!" );

		return false; // NOT THROTTLED
	}

	public static function throttleIdentifier( $type, $title ) {
		global $wgUser;

		switch ( $type ) {
			case 'ip':
				$identifier = wfGetIP();
				break;
			case 'user':
				$identifier = $wgUser->getId();
				break;
			case 'range':
				$identifier = substr( IP::toHex( wfGetIP() ), 0, 4 );
				break;
			case 'creationdate':
				$reg = $wgUser->getRegistration();
				$identifier = $reg - ( $reg % 86400 );
				break;
			case 'editcount':
				// Hack for detecting different single-purpose accounts.
				$identifier = $wgUser->getEditCount();
				break;
			case 'site':
				return 1;
			case 'page':
				return $title->getPrefixedText();
		}

		return $identifier;
	}

	public static function throttleKey( $throttleId, $type, $title ) {
		$types = explode( ',', $type );

		$identifiers = array();

		foreach ( $types as $subtype ) {
			$identifiers[] = self::throttleIdentifier( $subtype, $title );
		}

		$identifier = implode( ':', $identifiers );

		return wfMemcKey( 'abusefilter', 'throttle', $throttleId, $type, $identifier );
	}

	public static function autoPromoteBlockKey( $user ) {
		return wfMemcKey( 'abusefilter', 'block-autopromote', $user->getId() );
	}

	public static function recordStats( $filters ) {
		global $wgAbuseFilterConditionLimit, $wgMemc;

		wfProfileIn( __METHOD__ );

		// Figure out if we've triggered overflows and blocks.
		$overflow_triggered = ( self::$condCount > $wgAbuseFilterConditionLimit );

		// Store some keys...
		$overflow_key = self::filterLimitReachedKey();
		$total_key = self::filterUsedKey();

		$total = $wgMemc->get( $total_key );

		$storage_period = self::$statsStoragePeriod;

		if ( !$total || $total > 10000 ) {
			// This is for if the total doesn't exist, or has gone past 1000.
			// Recreate all the keys at the same time, so they expire together.
			$wgMemc->set( $total_key, 0, $storage_period );
			$wgMemc->set( $overflow_key, 0, $storage_period );

			foreach ( $filters as $filter => $matched ) {
				$wgMemc->set( self::filterMatchesKey( $filter ), 0, $storage_period );
			}
			$wgMemc->set( self::filterMatchesKey(), 0, $storage_period );
		}

		// Increment total
		$wgMemc->incr( $total_key );

		// Increment overflow counter, if our condition limit overflowed
		if ( $overflow_triggered ) {
			$wgMemc->incr( $overflow_key );
		}
		wfProfileOut( __METHOD__ );
	}

	public static function checkEmergencyDisable( $filters, $total ) {
		global $wgAbuseFilterEmergencyDisableThreshold, $wgAbuseFilterEmergencyDisableCount,
			$wgAbuseFilterEmergencyDisableAge, $wgMemc;

		foreach ( $filters as $filter ) {
			// Increment counter
			$matchCount = $wgMemc->get( self::filterMatchesKey( $filter ) );

			// Handle missing keys...
			if ( !$matchCount ) {
				$wgMemc->set( self::filterMatchesKey( $filter ), 1, self::$statsStoragePeriod );
			} else {
				$wgMemc->incr( self::filterMatchesKey( $filter ) );
			}
			$matchCount++;

			// Figure out if the filter is subject to being deleted.
			$filter_age = wfTimestamp( TS_UNIX,
				self::$filters[$filter]->af_timestamp );
			$throttle_exempt_time = $filter_age + $wgAbuseFilterEmergencyDisableAge;

			if ( $total && $throttle_exempt_time > time()
				&& $matchCount > $wgAbuseFilterEmergencyDisableCount
				&& ( $matchCount / $total ) > $wgAbuseFilterEmergencyDisableThreshold )
			{
				// More than $wgAbuseFilterEmergencyDisableCount matches,
				// constituting more than $wgAbuseFilterEmergencyDisableThreshold
				// (a fraction) of last few edits. Disable it.
				$dbw = wfGetDB( DB_MASTER );
				$dbw->update( 'abuse_filter',
					array( 'af_throttled' => 1 ),
					array( 'af_id' => $filter ),
					__METHOD__
				);
			}
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
		$user = User::newFromName( wfMsgForContent( 'abusefilter-blocker' ) );
		$user->load();
		if ( $user->getId() ) {
			// Already set up.
			return $user;
		}

		// Not set up. Create it.
		if ( !$user->getId() ) {
			print 'Trying to create account -- user id is ' . $user->getId();
			$user->addToDatabase();
			$user->saveSettings();
			// Increment site_stats.ss_users
			$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
			$ssu->doUpdate();
		} else {
			// Take over the account
			$user->setPassword( null );
			$user->setEmail( null );
			$user->saveSettings();
		}

		// Promote user so it doesn't look too crazy.
		$user->addGroup( 'sysop' );

		return $user;
	}

	static function buildEditBox( $rules, $textName = 'wpFilterRules', $addResultDiv = true,
									$canEdit = true ) {
		global $wgOut;

		$readOnlyAttrib = array();
		if ( !$canEdit )
			$readOnlyAttrib['readonly'] = 'readonly';

		global $wgUser;
		$noTestAttrib = array();
		if ( !$wgUser->isAllowed( 'abusefilter-modify' ) ) {
			$noTestAttrib['disabled'] = 'disabled';
			$addResultDiv = false;
		}

		$rules = rtrim( $rules ) . "\n";
		$rules = Xml::textarea( $textName, $rules, 40, 5, $readOnlyAttrib );

		$dropDown = self::getBuilderValues();
		// Generate builder drop-down
		$builder = '';

		$builder .= Xml::option( wfMsg( 'abusefilter-edit-builder-select' ) );

		foreach ( $dropDown as $group => $values ) {
			$builder .=
				Xml::openElement(
					'optgroup',
					array( 'label' => wfMsg( "abusefilter-edit-builder-group-$group" ) )
				) . "\n";

			foreach ( $values as $content => $name ) {
				$builder .=
					Xml::option(
						wfMsg( "abusefilter-edit-builder-$group-$name" ),
						$content
					) . "\n";
			}

			$builder .= Xml::closeElement( 'optgroup' ) . "\n";
		}

		$rules .=
			Xml::tags(
				'select',
				array( 'id' => 'wpFilterBuilder', ),
				$builder
			) . ' ';

		// Add syntax checking
		$rules .= Xml::element( 'input',
			array(
				'type' => 'button',
				'value' => wfMsg( 'abusefilter-edit-check' ),
				'id' => 'mw-abusefilter-syntaxcheck'
			) + $noTestAttrib );

		if ( $addResultDiv )
			$rules .= Xml::element( 'div',
				array( 'id' => 'mw-abusefilter-syntaxresult', 'style' => 'display: none;' ),
				'&#160;' );

		// Add script
		$wgOut->addModules( 'ext.abuseFilter.edit' );
		self::$editboxName = $textName;

		return $rules;
	}

	/**
	 * Each version is expected to be an array( $row, $actions )
	 * Returns an array of fields that are different.
	 *
	 * @param $version_1
	 * @param $version_2
	 *
	 * @return array
	 */
	static function compareVersions( $version_1, $version_2 ) {
		$compareFields = array(
			'af_public_comments',
			'af_pattern',
			'af_comments',
			'af_deleted',
			'af_enabled',
			'af_hidden',
			'af_global',
		);
		$differences = array();

		list( $row1, $actions1 ) = $version_1;
		list( $row2, $actions2 ) = $version_2;

		foreach ( $compareFields as $field ) {
			if ( $row1->$field != $row2->$field ) {
				$differences[] = $field;
			}
		}

		global $wgAbuseFilterAvailableActions;
		foreach ( $wgAbuseFilterAvailableActions as $action ) {
			if ( !isset( $actions1[$action] ) && !isset( $actions2[$action] ) ) {
				// They're both unset
			} elseif ( isset( $actions1[$action] ) && isset( $actions2[$action] ) ) {
				// They're both set.
				if ( array_diff( $actions1[$action]['parameters'],
					$actions2[$action]['parameters'] ) )
				{
					// Different parameters
					$differences[] = 'actions';
				}
			} else {
				// One's unset, one's set.
				$differences[] = 'actions';
			}
		}

		return array_unique( $differences );
	}

	static function translateFromHistory( $row ) {
		# Translate into an abuse_filter row with some black magic.
		# This is ever so slightly evil!
		$af_row = new StdClass;

		foreach ( self::$history_mappings as $af_col => $afh_col ) {
			$af_row->$af_col = $row->$afh_col;
		}

		# Process flags

		$af_row->af_deleted = 0;
		$af_row->af_hidden = 0;
		$af_row->af_enabled = 0;

		$flags = explode( ',', $row->afh_flags );
		foreach ( $flags as $flag ) {
			$col_name = "af_$flag";
			$af_row->$col_name = 1;
		}

		# Process actions
		$actions_raw = unserialize( $row->afh_actions );
		$actions_output = array();

		foreach ( $actions_raw as $action => $parameters ) {
			$actions_output[$action] = array(
				'action' => $action,
				'parameters' => $parameters
			);
		}

		return array( $af_row, $actions_output );
	}

	static function getActionDisplay( $action ) {
		$display = wfMsg( "abusefilter-action-$action" );
		$display = wfEmptyMsg( "abusefilter-action-$action", $display ) ? $action : $display;
		return $display;
	}

	public static function getVarsFromRCRow( $row ) {
		if ( $row->rc_this_oldid ) {
			// It's an edit.
			$vars = self::getEditVarsFromRCRow( $row );
		} elseif ( $row->rc_log_type == 'move' ) {
			$vars = self::getMoveVarsFromRCRow( $row );
		} elseif ( $row->rc_log_type == 'newusers' ) {
			$vars = self::getCreateVarsFromRCRow( $row );
		} else {
			return null;
		}
		if ( $vars ) {
			$vars->setVar( 'context', 'generated' );
			$vars->setVar( 'timestamp', wfTimestamp( TS_UNIX, $row->rc_timestamp ) );
		}

		return $vars;
	}

	public static function getCreateVarsFromRCRow( $row ) {
		$vars = new AbuseFilterVariableHolder;

		$vars->setVar( 'ACTION', 'createaccount' );

		$name = Title::makeTitle( $row->rc_namespace, $row->rc_title )->getText();
		// Add user data if the account was created by a registered user
		if ( $row->rc_user && $name != User::whoIs( $row->rc_user ) ) {
			$user = User::newFromId( $row->rc_user ); // SUS-812
			$vars->addHolder( self::generateUserVars( $user ) );
		}

		$vars->setVar( 'accountname', $name );
		return $vars;
	}

	public static function getEditVarsFromRCRow( $row ) {
		$vars = new AbuseFilterVariableHolder;
		$title = Title::makeTitle( $row->rc_namespace, $row->rc_title );

		if ( $row->rc_user ) {
			$user = User::newFromId( $row->rc_user ); // SUS-812
		} else {
			$userIp = RecentChange::extractUserIpFromRow( $row );
			$user = User::newFromName( $userIp, false );
		}

		$vars->addHolder( self::generateUserVars( $user ) );

		$vars->addHolder( self::generateTitleVars( $title, 'ARTICLE' ) );
		$vars->setVar( 'ACTION', 'edit' );
		$vars->setVar( 'SUMMARY', $row->rc_comment );
		$vars->setVar( 'minor_edit', $row->rc_minor );

		$vars->setLazyLoadVar( 'new_wikitext', 'revision-text-by-id',
			array( 'revid' => $row->rc_this_oldid ) );

		if ( $row->rc_last_oldid ) {
			$vars->setLazyLoadVar( 'old_wikitext', 'revision-text-by-id',
				array( 'revid' => $row->rc_last_oldid ) );
		} else {
			$vars->setVar( 'old_wikitext', '' );
		}

		$vars->addHolder( self::getEditVars( $title ) );

		return $vars;
	}

	public static function getMoveVarsFromRCRow( $row ) {
		$vars = new AbuseFilterVariableHolder;

		if ( $row->rc_user ) {
			$user = User::newFromId( $row->rc_user );
		} else {
			$userIp = RecentChange::extractUserIpFromRow( $row );
			$user = User::newFromName( $userIp, false );
		}

		$params = explode( "\n", trim( $row->rc_params ) );

		$oldTitle = Title::makeTitle( $row->rc_namespace, $row->rc_title );
		$newTitle = Title::newFromText( $params[0] );

		$vars = AbuseFilterVariableHolder::merge(
			$vars,
			AbuseFilter::generateUserVars( $user ),
			AbuseFilter::generateTitleVars( $oldTitle, 'MOVED_FROM' ),
			AbuseFilter::generateTitleVars( $newTitle, 'MOVED_TO' )
		);

		$vars->setVar( 'SUMMARY', $row->rc_comment );
		$vars->setVar( 'ACTION', 'move' );

		return $vars;
	}

	/**
	 * @static
	 * @param  $title Title
	 * @return AbuseFilterVariableHolder
	 */
	public static function getEditVars( $title, $article = null ) {
		$vars = new AbuseFilterVariableHolder;

		$vars->setLazyLoadVar( 'edit_diff', 'diff',
			array( 'oldtext-var' => 'old_wikitext', 'newtext-var' => 'new_wikitext' ) );
		$vars->setLazyLoadVar( 'new_size', 'length', array( 'length-var' => 'new_wikitext' ) );
		$vars->setLazyLoadVar( 'old_size', 'length', array( 'length-var' => 'old_wikitext' ) );
		$vars->setLazyLoadVar( 'edit_delta', 'subtract',
			array( 'val1-var' => 'new_size', 'val2-var' => 'old_size' ) );

		// Some more specific/useful details about the changes.
		$vars->setLazyLoadVar( 'added_lines', 'diff-split',
			array( 'diff-var' => 'edit_diff', 'line-prefix' => '+' ) );
		$vars->setLazyLoadVar( 'removed_lines', 'diff-split',
			array( 'diff-var' => 'edit_diff', 'line-prefix' => '-' ) );

		// Links
		$vars->setLazyLoadVar( 'all_links', 'links-from-wikitext',
			array(
				'namespace' => $title->getNamespace(),
				'title' => $title->getText(),
				'text-var' => 'new_wikitext',
				'article' => $article
			) );
		$vars->setLazyLoadVar( 'old_links', 'links-from-wikitext-or-database',
			array(
				'namespace' => $title->getNamespace(),
				'title' => $title->getText(),
				'text-var' => 'old_wikitext'
			) );
		$vars->setLazyLoadVar( 'added_links', 'link-diff-added',
			array( 'oldlink-var' => 'old_links', 'newlink-var' => 'all_links' ) );
		$vars->setLazyLoadVar( 'removed_links', 'link-diff-removed',
			array( 'oldlink-var' => 'old_links', 'newlink-var' => 'all_links' ) );

		$vars->setLazyLoadVar( 'new_html', 'parse-wikitext',
			array(
				'namespace' => $title->getNamespace(),
				'title' => $title->getText(),
				'wikitext-var' => 'new_wikitext',
				'article' => $article
			) );
		$vars->setLazyLoadVar( 'new_text', 'strip-html',
			array( 'html-var' => 'new_html' ) );
		$vars->setLazyLoadVar( 'old_html', 'parse-wikitext-nonedit',
			array(
				'namespace' => $title->getNamespace(),
				'title' => $title->getText(),
				'wikitext-var' => 'old_wikitext'
			) );
		$vars->setLazyLoadVar( 'old_text', 'strip-html',
			array( 'html-var' => 'old_html' ) );

		return $vars;
	}

	public static function buildVarDumpTable( $vars ) {
		// Export all values
		if ( $vars instanceof AbuseFilterVariableHolder ) {
			$vars = $vars->exportAllVars();
		}

		$output = '';

		// I don't want to change the names of the pre-existing messages
		// describing the variables, nor do I want to rewrite them, so I'm just
		// mapping the variable names to builder messages with a pre-existing array.
		$variableMessageMappings = self::getBuilderValues();
		$variableMessageMappings = $variableMessageMappings['vars'];

		$output .=
			Xml::openElement( 'table', array( 'class' => 'mw-abuselog-details' ) ) .
			Xml::openElement( 'tbody' ) .
			"\n";

		$header =
			Xml::element( 'th', null, wfMsg( 'abusefilter-log-details-var' ) ) .
			Xml::element( 'th', null, wfMsg( 'abusefilter-log-details-val' ) );
		$output .= Xml::tags( 'tr', null, $header ) . "\n";

		// Now, build the body of the table.
		foreach ( $vars as $key => $value ) {
			$key = strtolower( $key );

			if ( !empty( $variableMessageMappings[$key] ) ) {
				$mapping = $variableMessageMappings[$key];
				$keyDisplay = wfMsgExt( "abusefilter-edit-builder-vars-$mapping", 'parseinline' ) .
				' ' . Xml::element( 'tt', null, wfMsg( 'parentheses', $key ) );
			} else {
				$keyDisplay = Xml::element( 'tt', null, $key );
			}

			if ( is_null( $value ) )
				$value = '';
			$value = Xml::element( 'div', array( 'class' => 'mw-abuselog-var-value' ), $value );

			$trow =
				Xml::tags( 'td', array( 'class' => 'mw-abuselog-var' ), $keyDisplay ) .
				Xml::tags( 'td', array( 'class' => 'mw-abuselog-var-value' ), $value );
			$output .=
				Xml::tags( 'tr',
					array( 'class' => "mw-abuselog-details-$key mw-abuselog-value" ), $trow
				) . "\n";
		}

		$output .= Xml::closeElement( 'tbody' ) . Xml::closeElement( 'table' );
		return $output;
	}

	static function modifyActionText( $page, $type, $title, $sk, $args ) {
		list( $history_id, $filter_id ) = $args;

		$filter_link = $sk ? $sk->link( $title ) : $title->getCanonicalURL();

		$details_title = SpecialPage::getTitleFor( 'AbuseFilter', "history/$filter_id/diff/prev/$history_id" );
		$details_text = wfMsgExt( 'abusefilter-log-detailslink', 'parseinline' );
		$details_link =
			$sk ? $sk->link( $details_title, $details_text ) : $details_title->getCanonicalURL();

		return wfMsgExt( 'abusefilter-log-entry-modify',
			array( 'parseinline', 'replaceafter' ), array( $filter_link, $details_link ) );
	}

	static function formatAction( $action, $parameters ) {
		global $wgLang;
		if ( count( $parameters ) == 0 ) {
			$displayAction = AbuseFilter::getActionDisplay( $action );
		} else {
			$displayAction = AbuseFilter::getActionDisplay( $action ) .
						wfMsgExt( 'colon-separator', 'escapenoentities' ) .
						$wgLang->semicolonList( $parameters );
		}
		return $displayAction;
	}

	static function formatFlags( $value ) {
		global $wgLang;
		$flags = array_filter( explode( ',', $value ) );
		$flags_display = array();
		foreach ( $flags as $flag ) {
			$flags_display[] = wfMsg( "abusefilter-history-$flag" );
		}
		return $wgLang->commaList( $flags_display );
	}

	static function sendToUDP( $data ) {
		global $wgAbuseFilterUDPPrefix, $wgAbuseFilterUDPAddress, $wgAbuseFilterUDPPort;

		RecentChange::sendToUDP(
			$data,
			$wgAbuseFilterUDPAddress,
			$wgAbuseFilterUDPPrefix,
			$wgAbuseFilterUDPPort
		);
	}

	static function getGlobalFilterDescription( $filterID ) {
		global $wgAbuseFilterCentralDB;

		if ( !$wgAbuseFilterCentralDB ) {
			return;
		}

		$fdb = wfGetDB( DB_SLAVE, array(), $wgAbuseFilterCentralDB );

		return $fdb->selectField(
			'abuse_filter',
			'af_public_comments',
			array( 'af_id' => $filterID ),
			__METHOD__
		);
	}
}
