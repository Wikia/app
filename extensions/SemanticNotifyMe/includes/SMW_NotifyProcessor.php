<?php
/**
 * This file contains a static class for accessing functions to generate and execute
 * notify me semantic queries and to serialise their results.
 *
 * @author ning
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

global $smwgIP, $smwgNMIP ;
require_once( $smwgIP . '/includes/storage/SMW_Store.php' );
require_once( $smwgNMIP . '/includes/SMW_NMStorage.php' );

/**
 * Static class for accessing functions to generate and execute semantic queries
 * and to serialise their results.
 */
class SMWNotifyProcessor {

	static public function getNotifications() {
		$sStore = NMStorage::getDatabase();
		global $wgUser;
		$user_id = $wgUser->getId();

		$notifications = $sStore->getNotifications( $user_id );

		return $notifications;
	}

	/**
	 * Enable a NotifyMe with specified id and querystring
	 *
	 * used for inline query only
	 */
	static public function enableNotify( $notify_id, $querystring, &$msg = NULL ) {
		wfProfileIn( 'SMWNotifyProcessor::enableNotify (SMW)' );

		$sStore = NMStorage::getDatabase();
		global $smwgQDefaultNamespaces;

		SMWQueryProcessor::processFunctionParams( SMWNotifyProcessor::getQueryRawParams( $querystring ), $querystring, $params, $printouts );
		$relatedArticles = array();
		foreach ( $printouts as $po ) {
			$printoutArticles[] = array(
				'namespace' => SMW_NS_PROPERTY,
				'title' => Title::makeTitle( SMW_NS_PROPERTY, $po->getText( SMW_OUTPUT_WIKI ) )->getDBkey() );
		}

		$qp = new SMWNotifyParser( $notify_id, $printoutArticles );
		$qp->setDefaultNamespaces( $smwgQDefaultNamespaces );
		$desc = $qp->getQueryDescription( $querystring );

		if ( !$qp->m_result ) {
			$qp->m_errors[] = wfMsg( 'smw_nm_proc_pagenotexist' );
		}

		if ( isset( $msg ) && $qp->hasSubquery() ) {
			$msg .= "\n" . wfMsg( 'smw_nm_proc_subqueryhint' );
		}

		$query = new SMWQuery( $desc, true, false );
		$query->setQueryString( $querystring );
		$query->addErrors( $qp->getErrors() ); // keep parsing errors for later output

		$res = $sStore->getNMQueryResult( $query );

		if ( count( $query->getErrors() ) > 0 ) {
			if ( isset( $msg ) ) {
				$msg .= "\n\n" . implode( '\n', $query->getErrors() ) . "\n\n" . wfMsg( 'smw_nm_proc_enablehint' );
			}
			$sStore->disableNotifyState( $notify_id );
			wfProfileOut( 'SMWNotifyProcessor::enableNotify (SMW)' );
			return false;
		}

		$sStore->updateNMSql( $notify_id, $res['sql'], $res['tmp_hierarchy'] );
		if ( count( $res['page_ids'] ) > 0 ) {
			$add_monitor = array();
			foreach ( $res['page_ids'] as $page_id ) {
				$add_monitor[] = array( 'notify_id' => $notify_id, 'page_id' => $page_id );
			}
			$sStore->addNotifyMonitor( $add_monitor );
		}
		$sStore->updateNotifyState( $notify_id, 1 );
		wfProfileOut( 'SMWNotifyProcessor::enableNotify (SMW)' );

		return true;
	}

	static public function getQueryRawParams( $querystring ) {
		// read query with printouts and (possibly) other parameters like sort, order, limit, etc...
		$pos = strpos( $querystring, "|?" );
		if ( $pos > 0 ) {
			$rawparams[] = trim( substr( $querystring, 0, $pos ) );
			$ps = explode( "|?", trim( substr( $querystring, $pos + 2 ) ) );
			foreach ( $ps as $param ) {
				$rawparams[] = "?" . trim( $param );
			}
		} else {
			$ps = preg_split( '/[^\|]{1}\|{1}(?!\|)/s', $querystring );
			if ( count( $ps ) > 1 ) {
				// last char of query condition is missing (matched with [^\|]{1}) therefore copy from original
				$rawparams[] = trim( substr( $querystring, 0, strlen( $ps[0] ) + 1 ) );
				array_shift( $ps ); // remove the query condition
				// add other params for formating etc.
				foreach ( $ps as $param )
				$rawparams[] = trim( $param );
			} // no single pipe found, no params specified in query
			else $rawparams[] = trim( $querystring );
		}
		$rawparams[] = "format=table";
		$rawparams[] = "link=all";
		return $rawparams;
	}

	static public function addNotify( $rawquery, $name, $rep_all, $show_all, $delegate ) {
		global $wgTitle;
		// Take care at least of some templates -- for better template support use #ask
		$parser = new Parser();
		$parserOptions = new ParserOptions();
		$rawquery = $parser->transformMsg( $rawquery, $parserOptions, $wgTitle );

		wfProfileIn( 'SMWNotifyProcessor::createNotify (SMW)' );
		$sStore = NMStorage::getDatabase();
		global $wgUser;
		$user_id = $wgUser->getId();
		if ( $user_id == 0 ) {
			wfProfileOut( 'SMWNotifyProcessor::createNotify (SMW)' );
			return wfMsg( 'smw_nm_proc_notlogin' );
		}

		// check notify query first, use QueryParser from SMW
		SMWQueryProcessor::processFunctionParams( SMWNotifyProcessor::getQueryRawParams( $rawquery ), $querystring, $params, $printouts );

		$qp = new SMWQueryParser();
		$qp->setDefaultNamespaces( $smwgQDefaultNamespaces );
		$desc = $qp->getQueryDescription( $querystring );

		if ( count( $qp->getErrors() ) > 0 ) {
			wfProfileOut( 'SMWNotifyProcessor::createNotify (SMW)' );
			return wfMsg( 'smw_nm_proc_createfail', implode( "\n", $qp->getErrors() ) );
		}

		$notify_id = $sStore->addNotifyQuery( $user_id, $rawquery, $name, $rep_all, $show_all, $delegate );
		if ( $notify_id == 0 ) {
			wfProfileOut( 'SMWNotifyProcessor::createNotify (SMW)' );
			return wfMsg( 'smw_nm_proc_savefail' );
		}
		wfProfileOut( 'SMWNotifyProcessor::createNotify (SMW)' );

		wfProfileIn( 'SMWNotifyProcessor::enableNotify (SMW)' );
		$msg = '';
		$result  = SMWNotifyProcessor::enableNotify( $notify_id, $rawquery, $msg );
		wfProfileOut( 'SMWNotifyProcessor::enableNotify (SMW)' );
		return "1" . ( $result ? "1":"0" ) . "$notify_id,$msg";
	}

	static public function updateStates( $notify_ids ) {
		wfProfileIn( 'SMWNotifyProcessor::updateStates (SMW)' );

		$notifications = SMWNotifyProcessor::getNotifications();
		if ( $notifications == null || !is_array( $notifications ) ) {
			wfProfileOut( 'SMWNotifyProcessor::updateStates (SMW)' );
			return wfMsg( 'smw_nm_proc_nonoti' );
		}
		$result = true;
		$idx = 0;
		$count = count( $notify_ids ) - 1;
		$msg = '';
		$errs = '';
		$sStore = NMStorage::getDatabase();
		foreach ( $notifications as $row ) {
			if ( ( $idx < $count ) && ( $notify_ids[$idx] == $row['notify_id'] ) ) {
				if ( $row['enable'] == 0 ) {
					$m = '';
					$r = SMWNotifyProcessor::enableNotify( $row['notify_id'], $row['query'], $m );
					if ( !$r ) {
						$msg .= "NotifyMe : '" . $row['name'] . "'$m\n\n";
						$errs .= $row['notify_id'] . ",";
						$result = false;
					}
				}
				$idx ++;
			} else {
				if ( $row['enable'] == 1 ) {
					$result = $sStore->disableNotifyState( $row['notify_id'] );
				}
			}
		}

		wfProfileOut( 'SMWNotifyProcessor::updateStates (SMW)' );
		return $result ? wfMsg( 'smw_nm_proc_statesucc' ) : "0$errs|\n\n$msg";
	}

	static public function updateDelegates( $delegates ) {
		wfProfileIn( 'SMWNotifyProcessor::updateDelegates (SMW)' );

		$notifications = SMWNotifyProcessor::getNotifications();
		if ( $notifications == null || !is_array( $notifications ) ) {
			wfProfileOut( 'SMWNotifyProcessor::updateDelegates (SMW)' );
			return wfMsg( 'smw_nm_proc_nonoti' );
		}
		$result = true;
		$idx = 0;
		$s = explode( ':', $delegates[$idx], 2 );
		$count = count( $delegates ) - 1;
		$sStore = NMStorage::getDatabase();
		foreach ( $notifications as $row ) {
			if ( ( $idx < $count ) && ( $s[0] == $row['notify_id'] ) ) {
				$result = $sStore->updateDelegate( $row['notify_id'], $s[1] );
				$idx ++;
				$s = explode( ':', $delegates[$idx], 2 );
			} else {
				$result = $sStore->updateDelegate( $row['notify_id'], '' );
			}
			if ( !$result ) break;
		}

		wfProfileOut( 'SMWNotifyProcessor::updateDelegates (SMW)' );
		return $result ? wfMsg( 'smw_nm_proc_delegatesucc' ) : wfMsg( 'smw_nm_proc_delegateerr' );
	}

	static public function refreshNotifyMe() {
		wfProfileIn( 'SMWNotifyProcessor::refreshNotifyMe (SMW)' );
		NMStorage::getDatabase()->cleanUp();
		$notifications = NMStorage::getDatabase()->getAllNotifications();
		foreach ( $notifications as $row ) {
			if ( $row['enable'] ) {
				$result = SMWNotifyProcessor::enableNotify( $row['notify_id'], $row['query'] );
			}
		}
		wfProfileOut( 'SMWNotifyProcessor::refreshNotifyMe (SMW)' );
	}

	static public function updateReportAll( $notify_ids ) {
		wfProfileIn( 'SMWNotifyProcessor::updateReportAlls (SMW)' );

		$notifications = SMWNotifyProcessor::getNotifications();
		if ( $notifications == null || !is_array( $notifications ) ) {
			wfProfileOut( 'SMWNotifyProcessor::updateReportAlls (SMW)' );
			return wfMsg( 'smw_nm_proc_nonoti' );
		}
		$result = true;
		$idx = 0;
		$count = count( $notify_ids ) - 1;
		$sStore = NMStorage::getDatabase();
		foreach ( $notifications as $row ) {
			if ( ( $idx < $count ) && ( $notify_ids[$idx] == $row['notify_id'] ) ) {
				if ( $row['rep_all'] == 0 ) {
					$result = $sStore->updateNotifyReportAll( $row['notify_id'], 1 );
				}
				$idx ++;
			} else {
				if ( $row['rep_all'] == 1 ) {
					$result = $sStore->updateNotifyReportAll( $row['notify_id'], 0 );
				}
			}
			if ( !$result ) break;
		}

		wfProfileOut( 'SMWNotifyProcessor::updateReportAlls (SMW)' );
		return $result ? wfMsg( 'smw_nm_proc_reportsucc' ) : wfMsg( 'smw_nm_proc_reporterr' );
	}

	static public function updateShowAll( $notify_ids ) {
		wfProfileIn( 'SMWNotifyProcessor::updateShowAlls (SMW)' );

		$notifications = SMWNotifyProcessor::getNotifications();
		if ( $notifications == null || !is_array( $notifications ) ) {
			wfProfileOut( 'SMWNotifyProcessor::updateShowAlls (SMW)' );
			return wfMsg( 'smw_nm_proc_nonoti' );
		}
		$result = true;
		$idx = 0;
		$count = count( $notify_ids ) - 1;
		$sStore = NMStorage::getDatabase();
		foreach ( $notifications as $row ) {
			if ( ( $idx < $count ) && ( $notify_ids[$idx] == $row['notify_id'] ) ) {
				if ( $row['show_all'] == 0 ) {
					$result = $sStore->updateNotifyShowAll( $row['notify_id'], 1 );
				}
				$idx ++;
			} else {
				if ( $row['show_all'] == 1 ) {
					$result = $sStore->updateNotifyShowAll( $row['notify_id'], 0 );
				}
			}
			if ( !$result ) break;
		}

		wfProfileOut( 'SMWNotifyProcessor::updateShowAlls (SMW)' );
		return $result ? wfMsg( 'smw_nm_proc_showsucc' ) : wfMsg( 'smw_nm_proc_showerr' );
	}

	static public function delNotify( $notify_ids ) {
		wfProfileIn( 'SMWNotifyProcessor::delNotify (SMW)' );
		$sStore = NMStorage::getDatabase();
		$result = $sStore->removeNotifyQuery( $notify_ids );
		wfProfileOut( 'SMWNotifyProcessor::delNotify (SMW)' );
		return $result ? wfMsg( 'smw_nm_proc_delsucc' ) : wfMsg( 'smw_nm_proc_delerr' );
	}

	static protected $notifyJobs = array();
	static public function prepareArticleSave( $title ) {
		$page_id = $title->getArticleID();
		if ( $page_id == 0 ) {
			return;
		}
		$updates = SMWNotifyProcessor::$notifyJobs[$page_id];
		if ( empty( $updates ) ) {
			SMWNotifyProcessor::$notifyJobs[$page_id] = new SMWNotifyUpdate( $title );
		}
	}
	static public function articleSavedComplete( $title ) {
		$page_id = $title->getArticleID();
		if ( $page_id == 0 ) {
			return;
		}
		$updates = SMWNotifyProcessor::$notifyJobs[$page_id];
		if ( empty( $updates ) ) {
			SMWNotifyProcessor::$notifyJobs[$page_id] = new SMWNotifyUpdate( $title );
			$updates = SMWNotifyProcessor::$notifyJobs[$page_id];
		} else {
			$updates->executeNotifyUpdate();
		}
		$updates->updateNotifyMonitor();
		$updates->notifyUsers();
		unset( SMWNotifyProcessor::$notifyJobs[$page_id] );
	}
	static public function articleDelete( $title, $reason ) {
		$page_id = $title->getArticleID();
		if ( $page_id == 0 ) {
			return;
		}
		$updates = new SMWNotifyUpdate( $title );
		$updates->executeNotifyDelete( $reason );
	}
	static public function toInfoId( $type, $subquery, $attr_id ) {
		return base_convert( strval( ( $subquery << 8 ) | $type ), 10, 9 ) . '9' . $attr_id;
	}
	static public function getInfoFromId( $id ) {
		$idx = strpos( $id, '9' );
		$t = intval( base_convert( substr( $id, 0, $idx ), 9, 10 ) );
		return array(
			'type' => $t&0xFF,
			'subquery' => $t >> 8,
			'attr_id' => intval( substr( $id, $idx + 1 ) )
		);
	}

}

// based on SMW_QueryProcessor.php (v 1.4.2)
/**
 * Objects of this class are in charge of parsing a query string in order
 * to create an SMWDescription. The class and methods are not static in order
 * to more cleanly store the intermediate state and progress of the parser.
 */
class SMWNotifyParser {

	protected $m_sepstack; // list of open blocks ("parentheses") that need closing at current step
	protected $m_curstring; // remaining string to be parsed (parsing eats query string from the front)
	var $m_errors; // empty array if all went right, array of strings otherwise
	protected $m_label; // label of the main query result
	protected $m_defaultns; // description of the default namespace restriction, or NULL if not used

	protected $m_categoryprefix; // cache label of category namespace . ':'
	protected $m_conceptprefix; // cache label of concept namespace . ':'
	protected $m_queryfeatures; // query features to be supported, format similar to $smwgQFeatures

	// added by ning
	protected $m_notify_id;
	protected $m_subquery;
	protected $m_printoutArticles;
	public $m_result;

	// modified by ning
	public function SMWNotifyParser( $notify_id, $printoutArticles, $queryfeatures = false ) {
		$this->m_notify_id = $notify_id;
		$this->m_printoutArticles = $printoutArticles;
		$this->m_result = true;

		global $wgContLang, $smwgQFeatures;
		$this->m_categoryprefix = $wgContLang->getNsText( NS_CATEGORY ) . ':';
		$this->m_conceptprefix = $wgContLang->getNsText( SMW_NS_CONCEPT ) . ':';
		$this->m_defaultns = NULL;
		$this->m_queryfeatures = $queryfeatures === false ? $smwgQFeatures:$queryfeatures;
	}

	// added by ning
	public function hasSubquery() {
		return $this->m_subquery > 1;
	}

	/**
	 * Provide an array of namespace constants that are used as default restrictions.
	 * If NULL is given, no such default restrictions will be added (faster).
	 */
	public function setDefaultNamespaces( $nsarray ) {
		$this->m_defaultns = NULL;
		if ( $nsarray !== NULL ) {
			foreach ( $nsarray as $ns ) {
				$this->m_defaultns = $this->addDescription( $this->m_defaultns, new SMWNamespaceDescription( $ns ), false );
			}
		}
	}

	/**
	 * Compute an SMWDescription from a query string. Returns whatever descriptions could be
	 * wrestled from the given string (the most general result being SMWThingDescription if
	 * no meaningful condition was extracted).
	 */
	public function getQueryDescription( $querystring ) {
		wfProfileIn( 'SMWNotifyParser::getQueryDescription (SMW)' );
		$this->m_errors = array();
		$this->m_label = '';
		$this->m_curstring = $querystring;
		$this->m_sepstack = array();
		$setNS = false;

		// added by ning
		$this->m_subquery = 0;

		$result = $this->getSubqueryDescription( $setNS, $this->m_label );
		if ( !$setNS ) { // add default namespaces if applicable
			$result = $this->addDescription( $this->m_defaultns, $result );
		}
		if ( $result === NULL ) { // parsing went wrong, no default namespaces
			$result = new SMWThingDescription();
		}
		wfProfileOut( 'SMWNotifyParser::getQueryDescription (SMW)' );
		return $result;
	}

	/**
	 * Return array of error messages (possibly empty).
	 */
	public function getErrors() {
		return $this->m_errors;
	}

	/**
	 * Return error message or empty string if no error occurred.
	 */
	public function getErrorString() {
		return smwfEncodeMessages( $this->m_errors );
	}

	/**
	 * Return label for the results of this query (which
	 * might be empty if no such information was passed).
	 */
	public function getLabel() {
		return $this->m_label;
	}


	/**
	 * Compute an SMWDescription for current part of a query, which should
	 * be a standalone query (the main query or a subquery enclosed within
	 * "\<q\>...\</q\>". Recursively calls similar methods and returns NULL upon error.
	 *
	 * The call-by-ref parameter $setNS is a boolean. Its input specifies whether
	 * the query should set the current default namespace if no namespace restrictions
	 * were given. If false, the calling super-query is happy to set the required
	 * NS-restrictions by itself if needed. Otherwise the subquery has to impose the defaults.
	 * This is so, since outermost queries and subqueries of disjunctions will have to set
	 * their own default restrictions.
	 *
	 * The return value of $setNS specifies whether or not the subquery has a namespace
	 * specification in place. This might happen automatically if the query string imposes
	 * such restrictions. The return value is important for those callers that otherwise
	 * set up their own restrictions.
	 *
	 * Note that $setNS is no means to switch on or off default namespaces in general,
	 * but just controls query generation. For general effect, the default namespaces
	 * should be set to NULL.
	 *
	 * The call-by-ref parameter $label is used to append any label strings found.
	 */
	protected function getSubqueryDescription( &$setNS, &$label ) {
		global $smwgQPrintoutLimit;
		wfLoadExtensionMessages( 'SemanticMediaWiki' );
		$conjunction = NULL;	  // used for the current inner conjunction
		$disjuncts = array();	 // (disjunctive) array of subquery conjunctions
		$printrequests = array(); // the printrequests found for this query level
		$hasNamespaces = false;   // does the current $conjnuction have its own namespace restrictions?
		$mustSetNS = $setNS;	  // must ns restrictions be set? (may become true even if $setNS is false)

		// added by ning
		$subquery = $this->m_subquery;
		if ( $subquery == 0 ) {
			$relatedArticles = $this->m_printoutArticles;
		} else {
			$relatedArticles = array();
		}
		$this->m_subquery ++;

		$continue = ( $chunk = $this->readChunk() ) != ''; // skip empty subquery completely, thorwing an error
		while ( $continue ) {
			$setsubNS = false;
			switch ( $chunk ) {
				case '[[': // start new link block
					// modified by ning
					$ld = $this->getLinkDescription( $setsubNS, $label, $relatedArticles );

					if ( $ld instanceof SMWPrintRequest ) {
						$printrequests[] = $ld;
					} elseif ( $ld instanceof SMWDescription ) {
						$conjunction = $this->addDescription( $conjunction, $ld );
					}
					break;
				case '<q>': // enter new subquery, currently irrelevant but possible
					$this->pushDelimiter( '</q>' );
					$conjunction = $this->addDescription( $conjunction, $this->getSubqueryDescription( $setsubNS, $label ) );
					// / TODO: print requests from subqueries currently are ignored, should be moved down
					break;
				case 'OR': case '||': case '': case '</q>': // finish disjunction and maybe subquery
					if ( $this->m_defaultns !== NULL ) { // possibly add namespace restrictions
						if ( $hasNamespaces && !$mustSetNS ) {
							// add ns restrictions to all earlier conjunctions (all of which did not have them yet)
							$mustSetNS = true; // enforce NS restrictions from now on
							$newdisjuncts = array();
							foreach ( $disjuncts as $conj ) {
								$newdisjuncts[] = $this->addDescription( $conj, $this->m_defaultns );
							}
							$disjuncts = $newdisjuncts;
						} elseif ( !$hasNamespaces && $mustSetNS ) {
							// add ns restriction to current result
							$conjunction = $this->addDescription( $conjunction, $this->m_defaultns );
						}
					}
					$disjuncts[] = $conjunction;
					// start anew
					$conjunction = NULL;
					$hasNamespaces = false;
					// finish subquery?
					if ( $chunk == '</q>' ) {
						if ( $this->popDelimiter( '</q>' ) ) {
							$continue = false; // leave the loop
						} else {
							$this->m_errors[] = wfMsgForContent( 'smw_toomanyclosing', $chunk );
							return NULL;
						}
					} elseif ( $chunk == '' ) {
						$continue = false;
					}
					break;
				case '+': // "... AND true" (ignore)
					break;
				default: // error: unexpected $chunk
					$this->m_errors[] = wfMsgForContent( 'smw_unexpectedpart', $chunk );
					// return NULL; // Try to go on, it can only get better ...
			}
			if ( $setsubNS ) { // namespace restrictions encountered in current conjunct
				$hasNamespaces = true;
			}
			if ( $continue ) { // read on only if $continue remained true
				$chunk = $this->readChunk();
			}
		}

		if ( count( $disjuncts ) > 0 ) { // make disjunctive result
			$result = NULL;
			foreach ( $disjuncts as $d ) {
				if ( $d === NULL ) {
					$this->m_errors[] = wfMsgForContent( 'smw_emptysubquery' );
					$setNS = false;
					return NULL;
				} else {
					$result = $this->addDescription( $result, $d, false );
				}
			}
		} else {
			$this->m_errors[] = wfMsgForContent( 'smw_emptysubquery' );
			$setNS = false;
			return NULL;
		}
		$setNS = $mustSetNS; // NOTE: also false if namespaces were given but no default NS descs are available

		$prcount = 0;
		foreach ( $printrequests as $pr ) { // add printrequests
			if ( $prcount < $smwgQPrintoutLimit ) {
				$result->addPrintRequest( $pr );
				$prcount++;
			} else {
				$this->m_errors[] = wfMsgForContent( 'smw_overprintoutlimit' );
				break;
			}
		}

		// added by ning
		if ( $this->m_result ) {
			$sStore = NMStorage::getDatabase();
			$this->m_result = $sStore->addNotifyRelations( $this->m_notify_id, $relatedArticles, $subquery );
		}

		return $result;
	}

	/**
	 * Compute an SMWDescription for current part of a query, which should
	 * be the content of "[[ ... ]]". Alternatively, if the current syntax
	 * specifies a print request, return the print request object.
	 * Returns NULL upon error.
	 *
	 * Parameters $setNS and $label have the same use as in getSubqueryDescription().
	 */
	// modified by ning, add $relatedArticles
	protected function getLinkDescription( &$setNS, &$label, &$relatedArticles ) {
		// This method is called when we encountered an opening '[['. The following
		// block could be a Category-statement, fixed object, property statements,
		// or according print statements.
		$chunk = $this->readChunk( '', true, false ); // NOTE: untrimmed, initial " " escapes prop. chains
		if ( ( smwfNormalTitleText( $chunk ) == $this->m_categoryprefix ) ||  // category statement or
		( smwfNormalTitleText( $chunk ) == $this->m_conceptprefix ) ) {  // concept statement
			return $this->getClassDescription( $setNS, $label, $relatedArticles,
			( smwfNormalTitleText( $chunk ) == $this->m_categoryprefix ) );
		} else { // fixed subject, namespace restriction, property query, or subquery
			$sep = $this->readChunk( '', false ); // do not consume hit, "look ahead"
			if ( ( $sep == '::' ) || ( $sep == ':=' ) ) {
				if ( $chunk { 0 } != ':' ) { // property statement
					return $this->getPropertyDescription( $chunk, $setNS, $label, $relatedArticles );
				} else { // escaped article description, read part after :: to get full contents
					$chunk .= $this->readChunk( '\[\[|\]\]|\|\||\|' );
					return $this->getArticleDescription( trim( $chunk ), $setNS, $label, $relatedArticles );
				}
			} else { // Fixed article/namespace restriction. $sep should be ]] or ||
				return $this->getArticleDescription( trim( $chunk ), $setNS, $label, $relatedArticles );
			}
		}
	}

	/**
	 * Parse a category description (the part of an inline query that
	 * is in between "[[Category:" and the closing "]]" and create a
	 * suitable description.
	 */
	// modified by ning ,add $relatedArticles
	protected function getClassDescription( &$setNS, &$label, &$relatedArticles, $category = true ) {
		global $smwgSMWBetaCompatible; // * printouts only for this old version
		// note: no subqueries allowed here, inline disjunction allowed, wildcards allowed
		$result = NULL;
		$continue = true;
		while ( $continue ) {
			$chunk = $this->readChunk();
			if ( $chunk == '+' ) {
				// wildcard, ignore for categories (semantically meaningless, everything is in some class)
			} elseif ( ( $chunk == '+' ) && $category && $smwgSMWBetaCompatible ) { // print statement
				$chunk = $this->readChunk( '\]\]|\|' );
				if ( $chunk == '|' ) {
					$printlabel = $this->readChunk( '\]\]' );
					if ( $printlabel != ']]' ) {
						$chunk = $this->readChunk( '\]\]' );
					} else {
						$printlabel = '';
						$chunk = ']]';
					}
				} else {
					global $wgContLang;
					$printlabel = $wgContLang->getNSText( NS_CATEGORY );
				}
				if ( $chunk == ']]' ) {
					return new SMWPrintRequest( SMWPrintRequest::PRINT_CATS, $printlabel );
				} else {
					$this->m_errors[] = wfMsgForContent( 'smw_badprintout' );
					return NULL;
				}
			} else { // assume category/concept title
				// / NOTE: use m_c...prefix to prevent problems with, e.g., [[Category:Template:Test]]
				$class = Title::newFromText( ( $category ? $this->m_categoryprefix:$this->m_conceptprefix ) . $chunk );
				if ( $class !== NULL ) {
					$desc = $category ? new SMWClassDescription( $class ):new SMWConceptDescription( $class );
					$result = $this->addDescription( $result, $desc, false );
				}

				// added by ning
				if ( $category ) {
					$relatedArticles[] = array(
						'namespace' => NS_CATEGORY,
						'title' => $class->getDBkey() );
				}

			}
			$chunk = $this->readChunk();
			$continue = ( $chunk == '||' ) && $category; // disjunctions only for cateories
		}

		return $this->finishLinkDescription( $chunk, false, $result, $setNS, $label );
	}

	/**
	 * Parse a property description (the part of an inline query that
	 * is in between "[[Some property::" and the closing "]]" and create a
	 * suitable description. The "::" is the first chunk on the current
	 * string.
	 */
	// modified by ning ,add $relatedArticles
	protected function getPropertyDescription( $propertyname, &$setNS, &$label, &$relatedArticles ) {
		global $smwgSMWBetaCompatible; // support for old * printouts of beta
		wfLoadExtensionMessages( 'SemanticMediaWiki' );
		$this->readChunk(); // consume separator ":=" or "::"
		// first process property chain syntax (e.g. "property1.property2::value"):
		if ( $propertyname { 0 } == ' ' ) { // escape
			$propertynames = array( $propertyname );
		} else {
			$propertynames = explode( '.', $propertyname );
		}
		$properties = array();
		$typeid = '_wpg';
		foreach ( $propertynames as $name ) {
			if ( $typeid != '_wpg' ) { // non-final property in chain was no wikipage: not allowed
				$this->m_errors[] = wfMsgForContent( 'smw_valuesubquery', $prevname );
				return NULL; // /TODO: read some more chunks and try to finish [[ ]]
			}
			$property = SMWPropertyValue::makeUserProperty( $name );
			if ( !$property->isValid() ) { // illegal property identifier
				$this->m_errors = array_merge( $this->m_errors, $property->getErrors() );
				return NULL; // /TODO: read some more chunks and try to finish [[ ]]
			}
			$typeid = $property->getTypeID();
			$prevname = $name;
			$properties[] = $property;

			// added by ning
			$relatedArticles[] = array(
				'namespace' => SMW_NS_PROPERTY,
				'title' => $property->getDBkey() );

		} // /NOTE: after iteration, $property and $typeid correspond to last value

		$innerdesc = NULL;
		$continue = true;
		while ( $continue ) {
			$chunk = $this->readChunk();
			switch ( $chunk ) {
				case '+': // wildcard, add namespaces for page-type properties
					if ( ( $this->m_defaultns !== NULL ) && ( $typeid == '_wpg' ) ) {
						$innerdesc = $this->addDescription( $innerdesc, $this->m_defaultns, false );
					} else {
						$innerdesc = $this->addDescription( $innerdesc, new SMWThingDescription(), false );
					}
					$chunk = $this->readChunk();
					break;
				case '<q>': // subquery, set default namespaces
					if ( $typeid == '_wpg' ) {
						$this->pushDelimiter( '</q>' );
						$setsubNS = true;
						$sublabel = '';
						$innerdesc = $this->addDescription( $innerdesc, $this->getSubqueryDescription( $setsubNS, $sublabel ), false );
					} else { // no subqueries allowed for non-pages
						$this->m_errors[] = wfMsgForContent( 'smw_valuesubquery', end( $propertynames ) );
						$innerdesc = $this->addDescription( $innerdesc, new SMWThingDescription(), false );
					}
					$chunk = $this->readChunk();
					break;
				default: // normal object value or print statement
					// read value(s), possibly with inner [[...]]
					$open = 1;
					$value = $chunk;
					$continue2 = true;
					// read value with inner [[, ]], ||
					while ( ( $open > 0 ) && ( $continue2 ) ) {
						$chunk = $this->readChunk( '\[\[|\]\]|\|\||\|' );
						switch ( $chunk ) {
							case '[[': // open new [[ ]]
								$open++;
								break;
							case ']]': // close [[ ]]
								$open--;
								break;
							case '|': case '||': // terminates only outermost [[ ]]
								if ( $open == 1 ) {
									$open = 0;
								}
								break;
							case '': // /TODO: report error; this is not good right now
							$continue2 = false;
							break;
						}
						if ( $open != 0 ) {
							$value .= $chunk;
						}
					} // /NOTE: at this point, we normally already read one more chunk behind the value

					if ( $typeid == '__nry' ) { // nary value
						$dv = SMWDataValueFactory::newPropertyObjectValue( $property );
						$dv->acceptQuerySyntax();
						$dv->setUserValue( $value );
						$vl = $dv->getValueList();
						$pm = $dv->getPrintModifier();
						if ( $vl !== NULL ) { // prefer conditions over print statements (only one possible right now)
							$innerdesc = $this->addDescription( $innerdesc, $vl, false );
						} elseif ( $pm !== false ) {
							if ( $chunk == '|' ) {
								$printlabel = $this->readChunk( '\]\]' );
								if ( $printlabel != ']]' ) {
									$chunk = $this->readChunk( '\]\]' );
								} else {
									$printlabel = '';
									$chunk = ']]';
								}
							} else {
								$printlabel = $property->getWikiValue();
							}
							if ( $chunk == ']]' ) {
								return new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $printlabel, $property, $pm );
							} else {
								$this->m_errors[] = wfMsgForContent( 'smw_badprintout' );
								return NULL;
							}
						}
					} else { // unary value
						$comparator = SMW_CMP_EQ;
						$printmodifier = '';
						SMWNotifyParser::prepareValue( $value, $comparator, $printmodifier );
						if ( ( $value == '*' ) && $smwgSMWBetaCompatible ) {
							if ( $chunk == '|' ) {
								$printlabel = $this->readChunk( '\]\]' );
								if ( $printlabel != ']]' ) {
									$chunk = $this->readChunk( '\]\]' );
								} else {
									$printlabel = '';
									$chunk = ']]';
								}
							} else {
								$printlabel = $property->getWikiValue();
							}
							if ( $chunk == ']]' ) {
								return new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $printlabel, $property, $printmodifier );
							} else {
								$this->m_errors[] = wfMsgForContent( 'smw_badprintout' );
								return NULL;
							}
						} else {
							$dv = SMWDataValueFactory::newPropertyObjectValue( $property, $value );
							if ( !$dv->isValid() ) {
								$this->m_errors = $this->m_errors + $dv->getErrors();
								$vd = new SMWThingDescription();
							} else {
								$vd = new SMWValueDescription( $dv, $comparator );
							}
							$innerdesc = $this->addDescription( $innerdesc, $vd, false );
						}
					}
			}
			$continue = ( $chunk == '||' );
		}

		if ( $innerdesc === NULL ) { // make a wildcard search
			if ( ( $this->m_defaultns !== NULL ) && ( $typeid == '_wpg' ) ) {
				$innerdesc = $this->addDescription( $innerdesc, $this->m_defaultns, false );
			} else {
				$innerdesc = $this->addDescription( $innerdesc, new SMWThingDescription(), false );
			}
			$this->m_errors[] = wfMsgForContent( 'smw_propvalueproblem', $property->getWikiValue() );
		}
		$properties = array_reverse( $properties );
		foreach ( $properties as $property ) {
			$innerdesc = new SMWSomeProperty( $property, $innerdesc );
		}
		$result = $innerdesc;
		return $this->finishLinkDescription( $chunk, false, $result, $setNS, $label );
	}


	/**
	 * Prepare a single value string, possibly extracting comparators and
	 * printmodifier. $value is changed to consist only of the remaining
	 * effective value string, or of "*" for print statements.
	 */
	static public function prepareValue( &$value, &$comparator, &$printmodifier ) {
		global $smwgQComparators, $smwgSMWBetaCompatible; // support for old * printouts of beta
		// get print modifier behind *
		if ( $smwgSMWBetaCompatible ) {
			$list = preg_split( '/^\*/', $value, 2 );
			if ( count( $list ) == 2 ) { // hit
				$value = '*';
				$printmodifier = $list[1];
			} else {
				$printmodifier = '';
			}
			if ( $value == '*' ) { // printout statement
				return;
			}
		}
		$list = preg_split( '/^(' . $smwgQComparators . ')/u', $value, 2, PREG_SPLIT_DELIM_CAPTURE );
		$comparator = SMW_CMP_EQ;
		if ( count( $list ) == 3 ) { // initial comparator found ($list[1] should be empty)
			switch ( $list[1] ) {
				case '<':
					$comparator = SMW_CMP_LEQ;
					$value = $list[2];
					break;
				case '>':
					$comparator = SMW_CMP_GEQ;
					$value = $list[2];
					break;
				case '!':
					$comparator = SMW_CMP_NEQ;
					$value = $list[2];
					break;
				case '~':
					$comparator = SMW_CMP_LIKE;
					$value = $list[2];
					break;
					// default: not possible
			}
		}
	}

	/**
	 * Parse an article description (the part of an inline query that
	 * is in between "[[" and the closing "]]" assuming it is not specifying
	 * a category or property) and create a suitable description.
	 * The first chunk behind the "[[" has already been read and is
	 * passed as a parameter.
	 */
	// modified by ning ,add $relatedArticles
	protected function getArticleDescription( $firstchunk, &$setNS, &$label, &$relatedArticles ) {
		wfLoadExtensionMessages( 'SemanticMediaWiki' );
		$chunk = $firstchunk;
		$result = NULL;
		$continue = true;
		// $innerdesc = NULL;
		while ( $continue ) {
			if ( $chunk == '<q>' ) { // no subqueries of the form [[<q>...</q>]] (not needed)
				$this->m_errors[] = wfMsgForContent( 'smw_misplacedsubquery' );
				return NULL;
			}
			$list = preg_split( '/:/', $chunk, 3 ); // ":Category:Foo" "User:bar"  ":baz" ":+"
			if ( ( $list[0] == '' ) && ( count( $list ) == 3 ) ) {
				$list = array_slice( $list, 1 );
			}
			if ( ( count( $list ) == 2 ) && ( $list[1] == '+' ) ) { // try namespace restriction
				global $wgContLang;
				$idx = $wgContLang->getNsIndex( $list[0] );
				if ( $idx !== false ) {
					$result = $this->addDescription( $result, new SMWNamespaceDescription( $idx ), false );
				}
			} else {
				$value = SMWDataValueFactory::newTypeIDValue( '_wpg', $chunk );
				if ( $value->isValid() ) {
					$result = $this->addDescription( $result, new SMWValueDescription( $value ), false );
					// added by ning
					$relatedArticles[] = array(
						'namespace' => NS_MAIN,
						'title' => Title::makeTitle( NS_MAIN, $chunk )->getDBkey() );
				}
			}

			$chunk = $this->readChunk( '\[\[|\]\]|\|\||\|' );
			if ( $chunk == '||' ) {
				$chunk = $this->readChunk( '\[\[|\]\]|\|\||\|' );
				$continue = true;
			} else {
				$continue = false;
			}
		}

		return $this->finishLinkDescription( $chunk, true, $result, $setNS, $label );
	}

	protected function finishLinkDescription( $chunk, $hasNamespaces, $result, &$setNS, &$label ) {
		wfLoadExtensionMessages( 'SemanticMediaWiki' );
		if ( $result === NULL ) { // no useful information or concrete error found
			$this->m_errors[] = wfMsgForContent( 'smw_badqueryatom' );
		} elseif ( !$hasNamespaces && $setNS && ( $this->m_defaultns !== NULL ) ) {
			$result = $this->addDescription( $result, $this->m_defaultns );
			$hasNamespaces = true;
		}
		$setNS = $hasNamespaces;

		// terminate link (assuming that next chunk was read already)
		if ( $chunk == '|' ) {
			$chunk = $this->readChunk( '\]\]' );
			if ( $chunk != ']]' ) {
				$label .= $chunk;
				$chunk = $this->readChunk( '\]\]' );
			} else { // empty label does not add to overall label
				$chunk = ']]';
			}
		}
		if ( $chunk != ']]' ) {
			// What happended? We found some chunk that could not be processed as
			// link content (as in [[Category:Test<q>]]) and there was no label to
			// eat it. Or the closing ]] are just missing entirely.
			if ( $chunk != '' ) {
				$this->m_errors[] = wfMsgForContent( 'smw_misplacedsymbol', htmlspecialchars( $chunk ) );
				// try to find a later closing ]] to finish this misshaped subpart
				$chunk = $this->readChunk( '\]\]' );
				if ( $chunk != ']]' ) {
					$chunk = $this->readChunk( '\]\]' );
				}
			}
			if ( $chunk == '' ) {
				$this->m_errors[] = wfMsgForContent( 'smw_noclosingbrackets' );
			}
		}
		return $result;
	}

	/**
	 * Get the next unstructured string chunk from the query string.
	 * Chunks are delimited by any of the special strings used in inline queries
	 * (such as [[, ]], <q>, ...). If the string starts with such a delimiter,
	 * this delimiter is returned. Otherwise the first string in front of such a
	 * delimiter is returned.
	 * Trailing and initial spaces are ignored if $trim is true, and chunks
	 * consisting only of spaces are not returned.
	 * If there is no more qurey string left to process, the empty string is
	 * returned (and in no other case).
	 *
	 * The stoppattern can be used to customise the matching, especially in order to
	 * overread certain special symbols.
	 *
	 * $consume specifies whether the returned chunk should be removed from the
	 * query string.
	 */
	protected function readChunk( $stoppattern = '', $consume = true, $trim = true ) {
		if ( $stoppattern == '' ) {
			$stoppattern = '\[\[|\]\]|::|:=|<q>|<\/q>|^' . $this->m_categoryprefix .
						   '|^' . $this->m_conceptprefix . '|\|\||\|';
		}
		$chunks = preg_split( '/[\s]*(' . $stoppattern . ')/u', $this->m_curstring, 2, PREG_SPLIT_DELIM_CAPTURE );
		if ( count( $chunks ) == 1 ) { // no matches anymore, strip spaces and finish
			if ( $consume ) {
				$this->m_curstring = '';
			}
			return $trim ? trim( $chunks[0] ):$chunks[0];
		} elseif ( count( $chunks ) == 3 ) { // this should generally happen if count is not 1
			if ( $chunks[0] == '' ) { // string started with delimiter
				if ( $consume ) {
					$this->m_curstring = $chunks[2];
				}
				return $trim ? trim( $chunks[1] ):$chunks[1];
			} else {
				if ( $consume ) {
					$this->m_curstring = $chunks[1] . $chunks[2];
				}
				return $trim ? trim( $chunks[0] ):$chunks[0];
			}
		} else { return false; }  // should never happen
	}

	/**
	 * Enter a new subblock in the query, which must at some time be terminated by the
	 * given $endstring delimiter calling popDelimiter();
	 */
	protected function pushDelimiter( $endstring ) {
		array_push( $this->m_sepstack, $endstring );
	}

	/**
	 * Exit a subblock in the query ending with the given delimiter.
	 * If the delimiter does not match the top-most open block, false
	 * will be returned. Otherwise return true.
	 */
	protected function popDelimiter( $endstring ) {
		$topdelim = array_pop( $this->m_sepstack );
		return ( $topdelim == $endstring );
	}

	/**
	 * Extend a given description by a new one, either by adding the new description
	 * (if the old one is a container description) or by creating a new container.
	 * The parameter $conjunction determines whether the combination of both descriptions
	 * should be a disjunction or conjunction.
	 *
	 * In the special case that the current description is NULL, the new one will just
	 * replace the current one.
	 *
	 * The return value is the expected combined description. The object $curdesc will
	 * also be changed (if it was non-NULL).
	 */
	protected function addDescription( $curdesc, $newdesc, $conjunction = true ) {
		wfLoadExtensionMessages( 'SemanticMediaWiki' );
		$notallowedmessage = 'smw_noqueryfeature';
		if ( $newdesc instanceof SMWSomeProperty ) {
			$allowed = $this->m_queryfeatures & SMW_PROPERTY_QUERY;
		} elseif ( $newdesc instanceof SMWClassDescription ) {
			$allowed = $this->m_queryfeatures & SMW_CATEGORY_QUERY;
		} elseif ( $newdesc instanceof SMWConceptDescription ) {
			$allowed = $this->m_queryfeatures & SMW_CONCEPT_QUERY;
		} elseif ( $newdesc instanceof SMWConjunction ) {
			$allowed = $this->m_queryfeatures & SMW_CONJUNCTION_QUERY;
			$notallowedmessage = 'smw_noconjunctions';
		} elseif ( $newdesc instanceof SMWDisjunction ) {
			$allowed = $this->m_queryfeatures & SMW_DISJUNCTION_QUERY;
			$notallowedmessage = 'smw_nodisjunctions';
		} else {
			$allowed = true;
		}
		if ( !$allowed ) {
			$this->m_errors[] = wfMsgForContent( $notallowedmessage, str_replace( '[', '&#x005B;', $newdesc->getQueryString() ) );
			return $curdesc;
		}
		if ( $newdesc === NULL ) {
			return $curdesc;
		} elseif ( $curdesc === NULL ) {
			return $newdesc;
		} else { // we already found descriptions
			if ( ( ( $conjunction )  && ( $curdesc instanceof SMWConjunction ) ) ||
			( ( !$conjunction ) && ( $curdesc instanceof SMWDisjunction ) ) ) { // use existing container
				$curdesc->addDescription( $newdesc );
				return $curdesc;
			} elseif ( $conjunction ) { // make new conjunction
				if ( $this->m_queryfeatures & SMW_CONJUNCTION_QUERY ) {
					return new SMWConjunction( array( $curdesc, $newdesc ) );
				} else {
					$this->m_errors[] = wfMsgForContent( 'smw_noconjunctions', str_replace( '[', '&#x005B;', $newdesc->getQueryString() ) );
					return $curdesc;
				}
			} else { // make new disjunction
				if ( $this->m_queryfeatures & SMW_DISJUNCTION_QUERY ) {
					return new SMWDisjunction( array( $curdesc, $newdesc ) );
				} else {
					$this->m_errors[] = wfMsgForContent( 'smw_nodisjunctions', str_replace( '[', '&#x005B;', $newdesc->getQueryString() ) );
					return $curdesc;
				}
			}
		}
	}
}

class SMWNotifyUpdate {
	protected $m_info;
	protected $m_title; // current title of the update
	protected $m_userMsgs; // user_id => plain text message
	protected $m_userHtmlPropMsgs; // user_id => html message, prop change detail
	protected $m_userHtmlNMMsgs; // user_id => html message, all notify hint
	protected $m_userNMs; // user_id => notify_id
	protected $m_notifyHtmlPropMsgs; // notify_id => html message, prop change detail
	protected $m_notifyHtmlMsgs; // notify_id => html message, all notify hint
	protected $m_newMonitor; // notify newly matches the page, array( notify id, page id )
	protected $m_removeMonitored; // notify no longer matches the page, array( notify id, page id )
	protected $m_subQueryNotify; // subquery, will go through all pages, attention!!!

	protected $m_linker;

	protected function getSemanticInfo( $title ) {
		$result = array();
		$sStore = NMStorage::getDatabase();
		$semdata = smwfGetStore()->getSemanticData( $title );
		foreach ( $semdata->getProperties() as $property ) {
			if ( !$property->isShown() && $property->getWikiValue() != '' ) { // showing this is not desired, hide
				continue;
			} elseif ( $property->isUserDefined() ) { // user defined property
				$property->setCaption( preg_replace( '/[ ]/u', '&#160;', $property->getWikiValue(), 2 ) );
			}

			$propvalues = $semdata->getPropertyValues( $property );
			if ( $property->getWikiValue() != '' ) {
				foreach ( $propvalues as $propvalue ) {
					if ( $propvalue->getXSDValue() != '' ) {
						$result[SMWNotifyProcessor::toInfoId( 2, 0, $sStore->lookupSmwId( SMW_NS_PROPERTY, $property->getXSDValue() ) )][] = array( 'name' => $property, 'value' => $propvalue );
					}
				}
			} else {
				foreach ( $propvalues as $propvalue ) {
					if ( ( $propvalue instanceof SMWWikiPageValue ) && ( $propvalue->getNamespace() == NS_CATEGORY ) ) {
						$result[SMWNotifyProcessor::toInfoId( 0, 0, $sStore->lookupSmwId( NS_CATEGORY, $propvalue->getXSDValue() ) )][] = array( 'name' => $propvalue, 'value' => null );
					}
				}
			}
		}
		return $result;
	}

	public function SMWNotifyUpdate( $title ) {
		$this->m_title = $title;
		$this->m_userMsgs = array();
		$this->m_userHtmlPropMsgs = array();
		$this->m_userHtmlNMMsgs = array();
		$this->m_userNMs = array();
		$this->m_notifyHtmlPropMsgs = array();
		$this->m_notifyHtmlMsgs = array();
		$this->m_newMonitor = array();
		$this->m_removeMonitored = array();
		$this->m_subQueryNotify = array();
		$this->m_linker = new Linker();

		$page_id = $title->getArticleID();
		if ( ( $page_id == 0 ) || ( $this->m_title->getNamespace() != NS_MAIN ) ) {
			return;
		}
		$this->m_info = $this->getSemanticInfo( $this->m_title );
	}
	public function executeNotifyDelete( $reason ) {
		$page_id = $this->m_title->getArticleID();
		if ( ( $page_id == 0 ) || ( $this->m_title->getNamespace() != NS_MAIN ) ) {
			return;
		}
		$page_name = $this->m_title->getText() . ' (' . $this->m_title->getFullUrl() . ')';
		$page_html_name = '<a href="' . $this->m_title->getFullUrl() . '">' . htmlspecialchars( $this->m_title->getText() ) . '</a>';

		$msg .= wfMsg( 'smw_nm_hint_delete', $page_name, $reason );
		$sStore = NMStorage::getDatabase();
		$notifications = $sStore->getMonitoredNotifications( $page_id );

		$notifyMsgAdded = array();
		foreach ( $notifications as $user_id => $notifies ) {
			$this->m_userMsgs[$user_id] .= $msg . '\r\n( NM: ';
			$hint = wfMsg( 'smw_nm_hint_delete_html', $page_html_name, htmlspecialchars( $reason ) );
			$this->m_userHtmlNMMsgs[$user_id] .= $hint;
			$htmlMsg = '';
			$first = true;
			foreach ( $notifies as $notify_id => $notify_detail ) {
				if ( !$first ) {
					$this->m_userMsgs[$user_id] .= ', ';
					$htmlMsg .= ', ';
				} else {
					$first = false;
				}
				if ( !isset( $notifyMsgAdded[$notify_id] ) ) {
					$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
					$notifyMsgAdded[$notify_id] = true;
				}

				$this->m_userMsgs[$user_id] .= $notify_detail['name'];
				$htmlMsg .= '<b>' . htmlspecialchars( $notify_detail['name'] ) . '</b>';
				$this->m_removeMonitored[] = array( 'notify_id' => $notify_id, 'page_id' => $page_id );

				$this->m_userNMs[$user_id][] = $notify_id;
			}

			$this->m_userMsgs[$user_id] .= " ).";
			$this->m_userHtmlNMMsgs[$user_id] .= wfMsg( 'smw_nm_hint_notmatch_html', $htmlMsg );
		}

		$this->notifyUsers();
		$sStore->removeNotifyMonitor( $this->m_removeMonitored );
	}
	function isEqual( $v1, $v2 ) {
		return ( strval( $v1[value]->getXSDValue() ) == strval( $v2[value]->getXSDValue() ) );
	}
	function getNotifyPlain( $info, $key ) {
		$i = SMWNotifyProcessor::getInfoFromId( $key );
		if ( $i[type] == 0 ) {
			return "\r\n'" . $info[name]->getWikiValue() . "' has been " . ( $info[sem_act] == 0 ? "deleted":"added" ) . ".";
		} else {
			$tmp = "\r\nProperty '" . $info[name]->getWikiValue() . "' has been " . ( $info[sem_act] == 0 ? "deleted.":( $info[sem_act] == 1 ? "modified":"added" ) ) . ".";
			$first = true;
			foreach ( $info[del_vals] as $val ) {
				if ( $first ) {
					$tmp .= "\r\nValue '";
					$first = false;
				} else {
					$tmp .= "', '";
				}
				$tmp .= $val[plain];
			}
			if ( !$first ) {
				$tmp .= "' deleted.";
			}
			$first = true;
			foreach ( $info[new_vals] as $val ) {
				if ( $first ) {
					$tmp .= "\r\nValue '";
					$first = false;
				} else {
					$tmp .= "', '";
				}
				$tmp .= $val[plain];
			}
			if ( !$first ) {
				$tmp .= "' added.";
			}
			return $tmp . "\r\n";
		}
	}
	function getNotifyHtml( $info, $key ) {
		$i = SMWNotifyProcessor::getInfoFromId( $key );
		if ( $i[type] == 0 ) {
			return "<td>Category</td>
			<td>" . $this->getFullLink( $info[name] ) . "</td>
			<td>" . ( $info[sem_act] == 0 ? "<font color='green'>remove</font>":"<font color='red'>cite</font>" ) . "</td>
			<td colspan='2'>N/A</td>";
		} else {
			$rows = max( count( $info[del_vals] ), count( $info[new_vals] ) );
			$tmp = "<tr><td rowspan='$rows'>Property</td>
			<td rowspan='$rows'>" . $this->getFullLink( $info[name] ) . "</td>
			<td rowspan='$rows'>" . ( $info[sem_act] == 0 ? "<font color='green'>remove</font>":( $info[sem_act] == 1 ? "<font color='blue'>modify</font>":"<font color='red'>cite</font>" ) ) . "</td>";
			for ( $idx = 0; $idx < $rows; ++$idx ) {
				if ( $idx > 0 ) {
					$tmp .= "<tr>";
				}
				$tmp .= "<td>" . ( isset( $info[del_vals][$idx] ) ? $info[del_vals][$idx][html]:"&#160;" ) . "</td>
				<td>" . ( isset( $info[new_vals][$idx] ) ? $info[new_vals][$idx][html]:"&#160;" ) . "</td>
				</tr>";
			}
			return $tmp;
		}
	}
	public function executeNotifyUpdate() {
		$page_id = $this->m_title->getArticleID();
		if ( ( $page_id == 0 ) || ( $this->m_title->getNamespace() != NS_MAIN ) ) {
			return;
		}
		$sStore = NMStorage::getDatabase();

		$info = $this->getSemanticInfo( $this->m_title );
		// get different
		$tmp_info = array(); // type : category 0, property 2; name; sem action : del 0, modify 1, add 2; val action : del 0, add 1
		foreach ( $this->m_info as $key => $value ) {
			$i = SMWNotifyProcessor::getInfoFromId( $key );
			$updated = false;
			if ( !isset( $info[$key] ) ) {
				if ( $i[type] == 0 ) {
					$tmp_info[$key] = array( 'sem_act' => 0, 'name' => $value[0][name] );
				} else {
					$tmp_info[$key] = array( 'sem_act' => 0, 'name' => $value[0][name], 'del_vals' => array(), 'new_vals' => array() );
					foreach ( $value as $v ) {
						$tmp_info[$key][del_vals][] = array( 'plain' => $v[value]->getWikiValue(), 'html' => $this->getFullLink( $v[value] ) );
					}
				}
			} elseif ( $i[type] == 2 ) {
				$mvalue = $info[$key];
				foreach ( $value as $v1 ) {
					$found = false;
					foreach ( $mvalue as $v2 ) {
						if ( $this->isEqual( $v1, $v2 ) ) {
							$found = true;
							break;
						}
					}
					if ( !$found ) {
						if ( !$updated ) {
							$updated = true;
							$tmp_info[$key] = array( 'sem_act' => 1, 'name' => $value[0][name], 'del_vals' => array(), 'new_vals' => array() );
						}
						$tmp_info[$key][del_vals][] = array( 'plain' => $v1[value]->getWikiValue(), 'html' => $this->getFullLink( $v1[value] ) );
					}
				}
				foreach ( $mvalue as $v1 ) {
					$found = false;
					foreach ( $value as $v2 ) {
						if ( $this->isEqual( $v1, $v2 ) ) {
							$found = true;
							break;
						}
					}
					if ( !$found ) {
						if ( !$updated ) {
							$updated = true;
							$tmp_info[$key] = array( 'sem_act' => 1, 'name' => $value[0][name], 'del_vals' => array(), 'new_vals' => array() );
						}
						$tmp_info[$key][new_vals][] = array( 'plain' => $v1[value]->getWikiValue(), 'html' => $this->getFullLink( $v1[value] ) );
					}
				}
			}
		}
		foreach ( $info as $key => $value ) {
			$i = SMWNotifyProcessor::getInfoFromId( $key );
			if ( !isset( $this->m_info[$key] ) ) {
				if ( $i[type] == 0 ) {
					$tmp_info[$key] = array( 'sem_act' => 2, 'name' => $value[0][name] );
				} else {
					$tmp_info[$key] = array( 'sem_act' => 2, 'name' => $value[0][name], 'del_vals' => array(), 'new_vals' => array() );
					foreach ( $value as $v ) {
						$tmp_info[$key][new_vals][] = array( 'plain' => $v[value]->getWikiValue(), 'html' => $this->getFullLink( $v[value] ) );
					}
				}
			}
		}

		$notifications = $sStore->getMonitoredNotificationsDetail( $page_id );
		// add semantic info to report all NM
		foreach ( $notifications as $user_id => $notifies ) {
			foreach ( $notifies['rep_all'] as $notify_id => $notify_name ) {
				foreach ( array_keys( $tmp_info ) as $key ) {
					$notifications[$user_id]['semantic'][$key][$notify_id] = $notify_name;
				}
			}
		}
		$page_name = $this->m_title->getText() . ' (' . $this->m_title->getFullUrl() . ')';

		$notifyMsgAdded = array();
		foreach ( $notifications as $user_id => $notifies ) {
			if ( !isset( $notifies['semantic'] ) ) continue;
			foreach ( $notifies['semantic'] as $key => $notify ) {
				if ( isset( $tmp_info[$key] ) ) {
					$hint = "";
					if ( !isset( $this->m_userMsgs[$user_id] ) ) {
						$this->m_userMsgs[$user_id] = wfMsg( 'smw_nm_hint_change', $page_name );
						$hint = wfMsg( 'smw_nm_hint_change_html', $this->m_title->getFullUrl(), htmlspecialchars( $this->m_title->getText() ) );
						$this->m_userHtmlNMMsgs[$user_id] .= $hint;
					}

					$this->m_userMsgs[$user_id] .= $this->getNotifyPlain( $tmp_info[$key], $key ) . ' ( NM: ';
					$propHint = $this->getNotifyHtml( $tmp_info[$key], $key );
					$this->m_userHtmlPropMsgs[$user_id] .= $propHint . "<tr><td colspan='5'>" . wfMsg( 'smw_notifyme' ) . ": ";
					$first = true;
					foreach ( $notify as $notify_id => $notify_name ) {
						if ( !$first ) {
							$this->m_userMsgs[$user_id] .= ', ';
							$this->m_userHtmlPropMsgs[$user_id] .= ', ';
						} else {
							$first = false;
						}
						$this->m_userMsgs[$user_id] .= $notify_name;
						$this->m_userHtmlPropMsgs[$user_id] .= '<b>' . htmlspecialchars( $notify_name ) . '</b>';

						if ( !isset( $notifyMsgAdded[$notify_id] ) ) {
							$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
						}
						if ( !isset( $notifyMsgAdded[$notify_id][$key] ) ) {
							$this->m_notifyHtmlPropMsgs[$notify_id] .= $propHint;
							$notifyMsgAdded[$notify_id][$key] = true;
						}

						$this->m_userNMs[$user_id][] = $notify_id;
					}
					$this->m_userMsgs[$user_id] .= ' ).';
					$this->m_userHtmlPropMsgs[$user_id] .= "</td></tr>";
				}
			}
		}
		// get possible subquery
		$this->m_subQueryNotify = array();
		$queries = $sStore->getPossibleQuery( $this->m_info );
		if ( is_array( $queries ) ) {
			foreach ( $queries[1] as $notify_id => $notify ) {
				$this->m_subQueryNotify[$notify_id] = $notify;
			}
		}

		$this->m_info = $info;
	}

	// this will cost time, think we can update monitor in a single thread, like Job
	public function updateNotifyMonitor() {
		$page_id = $this->m_title->getArticleID();
		if ( ( $page_id == 0 ) || ( $this->m_title->getNamespace() != NS_MAIN ) ) {
			return;
		}
		$sStore = NMStorage::getDatabase();
		$queries = $sStore->getPossibleQuery( $this->m_info );
		if ( !is_array( $queries ) ) {
			return;
		}
		// get monitored query
		$main_queries = $sStore->getMonitoredQuery( $page_id );
		foreach ( $queries[0] as $notify_id => $notify ) {
			$main_queries[$notify_id] = $notify;
		}

		// begin notify query on main query
		$page_name = $this->m_title->getText() . ' (' . $this->m_title->getFullUrl() . ')';
		$page_html_name = '<a href="' . $this->m_title->getFullUrl() . '">' . htmlspecialchars( $this->m_title->getText() ) . '</a>';

		foreach ( $main_queries as $notify_id => $notify ) {
			$sStore->getNotifyInMainQuery( $page_id, $notify_id, $notify['sql'], $notify['hierarchy'], $match, $monitoring );
			if ( ( !$monitoring ) && $match ) {
				$hint = wfMsg( 'smw_nm_hint_match_html', $page_html_name, htmlspecialchars( $notify[name] ) );
				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userMsgs[$uid] .= wfMsg( 'smw_nm_hint_match', $page_name, $notify[name] );
					$this->m_userHtmlNMMsgs[$uid] .= $hint;
				}
				$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
				$this->m_newMonitor[] = array( 'notify_id' => $notify_id, 'page_id' => $page_id );
			} elseif ( ( !$match ) && $monitoring ) {
				$hint = wfMsg( 'smw_nm_hint_nomatch_html', $page_html_name, htmlspecialchars( $notify[name] ) );
				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userMsgs[$uid] .= wfMsg( 'smw_nm_hint_nomatch', $page_name, $notify[name] );
					$this->m_userHtmlNMMsgs[$uid] .= $hint;
				}
				$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
				$this->m_removeMonitored[] = array( 'notify_id' => $notify_id, 'page_id' => $page_id );
			}
			foreach ( $notify['user_ids'] as $uid ) {
				$this->m_userNMs[$uid][] = $notify_id;
			}
		}
		// begin notify query on sub query, should go through all pages
		foreach ( $queries[1] as $notify_id => $notify ) {
			$this->m_subQueryNotify[$notify_id] = $notify;
		}
		foreach ( $this->m_subQueryNotify as $notify_id => $notify ) {
			$res = $sStore->getNotifyInSubquery( $notify_id, $notify['sql'], $notify['hierarchy'] );

			$no_matches = array_diff( $res['monitoring'], $res['match'] );
			$matches = array_diff( $res['match'], $res['monitoring'] );
			foreach ( $matches as $pid ) {
				$pt = $sStore->getPageTitle( $pid );
				if ( !$pt ) {
					continue;
				}
				$t = Title::makeTitle( NS_MAIN, $pt->page_title );
				$p_name = $t->getText() . ' (' . $t->getFullUrl() . ')';
				$p_html_name = '<a href="' . $t->getFullUrl() . '">' . htmlspecialchars( $t->getText() ) . '</a>';

				$hint = wfMsg( 'smw_nm_hint_submatch_html', $page_html_name, $p_html_name, htmlspecialchars( $notify[name] ) );
				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userMsgs[$uid] .= wfMsg( 'smw_nm_hint_submatch', $page_name, $p_name, $notify[name] );
					$this->m_userHtmlNMMsgs[$uid] .= $hint;
				}
				$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
				$this->m_newMonitor[] = array( 'notify_id' => $notify_id, 'page_id' => $pid );

				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userNMs[$uid][] = $notify_id;
				}
			}
			foreach ( $no_matches as $pid ) {
				$pt = $sStore->getPageTitle( $pid );
				if ( !$pt ) {
					continue;
				}
				$t = Title::makeTitle( NS_MAIN, $pt->page_title );
				$p_name = $t->getText() . ' (' . $t->getFullUrl() . ')';
				$p_html_name = '<a href="' . $t->getFullUrl() . '">' . htmlspecialchars( $t->getText() ) . '</a>';

				$hint = wfMsg( 'smw_nm_hint_subnomatch_html', $page_html_name, $p_html_name, htmlspecialchars( $notify[name] ) );
				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userMsgs[$uid] .= wfMsg( 'smw_nm_hint_subnomatch', $page_name, $p_name, $notify[name] );
					$this->m_userHtmlNMMsgs[$uid] .= $hint;
				}
				$this->m_notifyHtmlMsgs[$notify_id] .= $hint;
				$this->m_removeMonitored[] = array( 'notify_id' => $notify_id, 'page_id' => $pid );

				foreach ( $notify['user_ids'] as $uid ) {
					$this->m_userNMs[$uid][] = $notify_id;
				}
			}
		}

		$sStore->removeNotifyMonitor( $this->m_removeMonitored );
		$sStore->addNotifyMonitor( $this->m_newMonitor );
	}
	private function getFullLink( $val ) {
		if ( $val instanceof SMWWikiPageValue ) {
			return '<a href="' . $val->getTitle()->getFullUrl() . '">' . htmlspecialchars( $val->getTitle()->getText() ) . '</a>';
		} elseif ( $val instanceof SMWPropertyValue ) {
			$val = $val->getWikiPageValue();
			return '<a href="' . $val->getTitle()->getFullUrl() . '">' . htmlspecialchars( $val->getTitle()->getText() ) . '</a>';
		} else {
			return $val->getShortHTMLText( $this->m_linker );
		}
	}
	private function applyStyle( $html ) {
		$html = str_replace( "class=\"smwtable\"", "style=\"background-color: #EEEEFF;\"", $html );
		$html = str_replace( "<th", "<th style=\"background-color: #EEEEFF;text-align: left;\"", $html );
		$html = str_replace( "<td", "<td style=\"background-color: #FFFFFF;padding: 1px;padding-left: 5px;padding-right: 5px;text-align: left;vertical-align: top;\"", $html );
		return $html;
	}
	public function notifyUsers() {
		global $wgSitename, $wgSMTP, $wgEmergencyContact, $wgEnotifyMeJob;
		$sStore = NMStorage::getDatabase();

		$nm_send_jobs = array();
		$id = 0;

		if ( count( $this->m_notifyHtmlMsgs ) > 0 ) {
			$notifications = $sStore->getNotifyMe( array_keys( $this->m_notifyHtmlMsgs ) );
		}
		$html_style = '';
		// <style>
		// table.smwtable{background-color: #EEEEFF;}
		// table.smwtable th{background-color: #EEEEFF;text-align: left;}
		// table.smwtable td{background-color: #FFFFFF;padding: 1px;padding-left: 5px;padding-right: 5px;text-align: left;vertical-align: top;}
		// table.smwtable tr.smwfooter td{font-size: 90%;line-height: 1;background-color: #EEEEFF;padding: 0px;padding-left: 5px;padding-right: 5px;text-align: right;vertical-align: top;}
		// </style>';
		$html_showall = array();
		foreach ( $this->m_notifyHtmlMsgs as $notify_id => $msg ) {
			$html_msg = $html_style;
			$showing_all = false;
			if ( isset( $notifications[$notify_id] ) && $notifications[$notify_id]['show_all'] ) {
				SMWQueryProcessor::processFunctionParams( SMWNotifyProcessor::getQueryRawParams( $notifications[$notify_id]['query'] ), $querystring, $params, $printouts );

				$format = 'auto';
				if ( array_key_exists( 'format', $params ) ) {
					$format = strtolower( trim( $params['format'] ) );
					global $smwgResultFormats;
					if ( !array_key_exists( $format, $smwgResultFormats ) ) {
						$format = 'auto';
					}
				}
				$query  = SMWQueryProcessor::createQuery( $querystring, $params, SMWQueryProcessor::INLINE_QUERY, $format, $printouts );
				$res = smwfGetStore()->getQueryResult( $query );
				$printer = SMWQueryProcessor::getResultPrinter( $format, SMWQueryProcessor::INLINE_QUERY, $res );
				$result = $printer->getResult( $res, $params, SMW_OUTPUT_HTML );
				$html_msg .= $result . '<br/>';
				$html_showall[$notify_id] = array ( 'name' => $notifications[$notify_id]['name'], 'html' => $result );

				$showing_all = true;
				$link = $res->getQueryLink()->getURL();
			}
			global $smwgNMHideDiffWhenShowAll;
			if ( !( $smwgNMHideDiffWhenShowAll && $showing_all ) ) {
				$html_msg .= wfMsg( 'smw_nm_hint_notification_html', $this->m_notifyHtmlMsgs[$notify_id] );
				if ( isset( $this->m_notifyHtmlPropMsgs[$notify_id] ) ) {
					$html_msg .= wfMsg( 'smw_nm_hint_nmtable_html', $this->m_notifyHtmlPropMsgs[$notify_id] );
				}
			}
			if ( $showing_all ) {
				$id = $sStore->addNotifyRSS( 'nid', $notify_id, "All current items, " . date( 'Y-m-d H:i:s', time() ), $this->applyStyle( $html_msg ), $link );
			} else {
				$id = $sStore->addNotifyRSS( 'nid', $notify_id, $this->m_title->getText(), $this->applyStyle( $html_msg ) );
			}
		}
		foreach ( $this->m_userMsgs as $user_id => $msg ) {
			// generate RSS items
			$html_msg = $html_style;
			foreach ( array_unique( $this->m_userNMs[$user_id] ) as $showall_nid ) {
				if ( isset( $html_showall[$showall_nid] ) ) {
					$html_msg .= wfMsg( 'smw_nm_hint_item_html', $html_showall[$showall_nid]['name'], $html_showall[$showall_nid]['html'] );
				}
			}

			$html_msg .= wfMsg( 'smw_nm_hint_notification_html', $this->m_userHtmlNMMsgs[$user_id] );
			if ( isset( $this->m_userHtmlPropMsgs[$user_id] ) ) {
				$html_msg .= wfMsg( 'smw_nm_hint_nmtable_html', $this->m_userHtmlPropMsgs[$user_id] );
			}

			global $wgNMReportModifier, $wgUser;
			if ( $wgNMReportModifier ) {
				$userText = $wgUser->getName();
				if ( $wgUser->getId() == 0 ) {
					$page = SpecialPage::getTitleFor( 'Contributions', $userText );
				} else {
					$page = Title::makeTitle( NS_USER, $userText );
				}
				$l = '<a href="' . $page->getFullUrl() . '">' . htmlspecialchars( $userText ) . '</a>';
				$html_msg .= wfMsg( 'smw_nm_hint_modifier_html', $l );
				$msg .= wfMsg( 'smw_nm_hint_modifier', $wgUser->getName() );
			}

			$id = $sStore->addNotifyRSS( 'uid', $user_id, $this->m_title->getText(), $this->applyStyle( $html_msg ) );

			if ( $wgEnotifyMeJob ) {
				// send notifications by mail
				$user_info = $sStore->getUserInfo( $user_id );
				$user = User::newFromRow( $user_info );
				if ( ( $user_info->user_email != '' ) && $user->getGlobalPreference( 'enotifyme' ) ) {
					$name = ( ( $user_info->user_real_name == '' ) ? $user_info->user_name:$user_info->user_real_name );

					$params = array( 'to' => new MailAddress( $user_info->user_email, $name ),
						'from' => new MailAddress( $wgEmergencyContact, 'Admin' ),
						'subj' => wfMsg( 'smw_nm_hint_mail_title', $this->m_title->getText(), $wgSitename ),
						'body' => wfMsg( 'smw_nm_hint_mail_body', $name, $msg ),
						'replyto' => new MailAddress( $wgEmergencyContact, 'Admin' ) );

					// wikia change start - jobqueue migration
					$task = new \Wikia\Tasks\Tasks\JobWrapperTask();
					$task->call( 'SMW_NMSendMailJob', $this->m_title, $params );
					$nm_send_jobs[] = $task;
					// wikia change end
				}
			}
		}

		if ( $wgEnotifyMeJob ) {
			if ( count( $nm_send_jobs ) ) {
				// wikia change start - jobqueue migration
				\Wikia\Tasks\Tasks\BaseTask::batch( $nm_send_jobs );
				// wikia change end
			}
		} else {
			global $phpInterpreter;
			if ( !isset( $phpInterpreter ) ) {
				// if $phpInterpreter is not set, assume it is in search path
				// if not, starting of bot will FAIL!
				$phpInterpreter = "php";
			}
			// copy from SMW_GardeningBot.php
			ob_start();
			phpinfo();
			$info = ob_get_contents();
			ob_end_clean();
			// Get Systemstring
			preg_match( '!\nSystem(.*?)\n!is', strip_tags( $info ), $ma );
			// Check if it consists 'windows' as string
			preg_match( '/[Ww]indows/', $ma[1], $os );
			global $smwgNMIP ;
			if ( $os[0] == '' && $os[0] == null ) {

				// FIXME: $runCommand must allow whitespaces in paths too
				$runCommand = "$phpInterpreter -q $smwgNMIP/specials/SMWNotifyMe/SMW_NMSendMailAsync.php";
				// TODO: test async code for linux.
				// low prio
				$nullResult = `$runCommand > /dev/null &`;
			}
			else // windowze
			{
				$runCommand = "\"\"$phpInterpreter\" -q \"$smwgNMIP/specials/SMWNotifyMe/SMW_NMSendMailAsync.php\"\"";
				$wshShell = new COM( "WScript.Shell" );
				$runCommand = "cmd /C " . $runCommand;

				$oExec = $wshShell->Run( $runCommand, 7, false );
			}
		}
	}
}
