<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialAbuseFilter extends SpecialPage {

	var $mSkin;
	
	static $history_mappings = array( 'af_pattern' => 'afh_pattern', 'af_user' => 'afh_user', 'af_user_text' => 'afh_user_text', 'af_timestamp' => 'afh_timestamp', 'af_comments' => 'afh_comments', 'af_public_comments' => 'afh_public_comments', 'af_deleted' => 'afh_deleted', 'af_id' => 'afh_filter' );

	function __construct() {
		wfLoadExtensionMessages('AbuseFilter');
		parent::__construct( 'AbuseFilter', 'abusefilter-view' );
	}
	
	function execute( $subpage ) {
		global $wgUser,$wgOut,$wgRequest;

		$this->setHeaders();

		$this->loadParameters( $subpage );
		$wgOut->setPageTitle( wfMsg( 'abusefilter-management' ) );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );
		
		// Are we allowed?
		if ( !$wgUser->isAllowed( 'abusefilter-view' ) ) {
			// Go away.
			$this->displayRestrictionError();
			return;
		}
		
		$this->mSkin = $wgUser->getSkin();
		
		$params = array_filter( explode( '/', $subpage ) );
		
		if ($subpage == 'tools') {
			// Some useful tools
			$this->doTools();
			return;
		}
		
		if (!empty($params[0]) && $params[0] == 'history') {
			if (count($params) == 1) {
				// ... useless?
			} elseif (count($params) == 2) {
				## Second param is a filter ID
				$this->showHistory($params[1]);
				return;
			} elseif (count($params) == 4 && $params[2] == 'item') {
				$wgOut->addWikiMsg( 'abusefilter-edit-oldwarning', $params[3], $params[1] );
				$out = $this->buildFilterEditor( null, $params[1], $params[3] );
				$wgOut->addHTML( $out );
				$wgOut->addWikiMsg( 'abusefilter-edit-oldwarning', $params[3], $params[1] );
				return;
			}
		}
		
		if ($output = $this->doEdit()) {
			$wgOut->addHTML( $output );
			return;
		}
		
		// Show list of filters.
		$this->showStatus();
		
		// Quick links
		$wgOut->addWikiMsg( 'abusefilter-links' );
		$lists = array( 'tools' );
		if ($this->canEdit())
			$lists[] = 'new';
		$links = '';
		$sk = $wgUser->getSkin();
		foreach( $lists as $list ) {
			$title = $this->getTitle( $list );
			
			$link = $sk->link( $title, wfMsg( "abusefilter-$list" ) );
			$links .= Xml::tags( 'li', null, $link ) . "\n";
		}
		$links .= Xml::tags( 'li', null, $sk->link( SpecialPage::getTitleFor( 'AbuseLog' ), wfMsg( 'abusefilter-loglink' ) ) );
		$links = Xml::tags( 'ul', null, $links );
		$wgOut->addHTML( $links );
		
		// Options.
		$conds = array();
		$deleted = $wgRequest->getVal( 'deletedfilters' );
		$hidedisabled = $wgRequest->getBool( 'hidedisabled' );
		if ($deleted == 'show') {
			## Nothing
		} elseif ($deleted == 'only') {
			$conds['af_deleted'] = 1;
		} else { ## hide, or anything else.
			$conds['af_deleted'] = 0;
			$deleted = 'hide';
		}
		if ($hidedisabled) {
			$conds['af_deleted'] = 0;
			$conds['af_enabled'] = 1;
		}
		
		$this->showList( $conds, compact( 'deleted', 'hidedisabled' ) );
	}
	
	function showDeleted() {
		$this->showList( array( 'af_deleted' => 1 ) );
	}
	
	function showActive() {
		$this->showList( array( 'af_deleted' => 0, 'af_enabled' => 1 ) );
	}
	
	function showHistory( $filter ) {
		global $wgRequest,$wgOut;
		
		global $wgUser;
		$sk = $wgUser->getSkin();
		$wgOut->setPageTitle( wfMsg( 'abusefilter-history', $filter ) );
		$backToFilter_label = wfMsgExt( 'abusefilter-history-backedit', array('parseinline') );
		$backToList_label = wfMsgExt( 'abusefilter-history-backlist', array('parseinline') );
		$backlinks = $sk->makeKnownLinkObj( $this->getTitle( $filter ), $backToFilter_label ) . '&nbsp;&bull;&nbsp;' .
				$sk->makeKnownLinkObj( $this->getTitle( ), $backToList_label );
		$wgOut->addHTML( Xml::tags( 'p', null, $backlinks ) );
		
		$pager = new AbuseFilterHistoryPager( $filter, $this );
		$table = $pager->getBody();
		
		$wgOut->addHTML( $pager->getNavigationBar() . $table . $pager->getNavigationBar() );
		
		return true;
	}
	
	function doTools() {
		global $wgRequest,$wgOut;
		
		// Header
		$wgOut->setSubTitle( wfMsg( 'abusefilter-tools-subtitle' ) );
		$wgOut->addWikiMsg( 'abusefilter-tools-text' );

		// Expression evaluator
		$eval = '';
		$eval .= Xml::textarea( 'wpTestExpr', "" );
		$eval .= Xml::tags( 'p', null, Xml::element( 'input', array( 'type' => 'button', 'id' => 'mw-abusefilter-submitexpr', 'onclick' => 'doExprSubmit();', 'value' => wfMsg( 'abusefilter-tools-submitexpr' ) ) ) );
		$eval .= Xml::element( 'p', array( 'id' => 'mw-abusefilter-expr-result' ), ' ' );
		$eval = Xml::fieldset( wfMsg( 'abusefilter-tools-expr' ), $eval );
		$wgOut->addHTML( $eval );
		
		// Associated script
		$exprScript = "function doExprSubmit()
		{
			var expr = document.getElementById('wpTestExpr').value;
			injectSpinner( document.getElementById( 'mw-abusefilter-submitexpr' ), 'abusefilter-expr' );
			sajax_do_call( 'AbuseFilter::ajaxEvaluateExpression', [expr], processExprResult );
		}
		function processExprResult( request ) {
			var response = request.responseText;
			
			removeSpinner( 'abusefilter-expr' );
			
			var el = document.getElementById( 'mw-abusefilter-expr-result' );
			changeText( el, response );
		}
		function doReautoSubmit()
		{
			var name = document.getElementById('reautoconfirm-user').value;
			injectSpinner( document.getElementById( 'mw-abusefilter-reautoconfirmsubmit' ), 'abusefilter-reautoconfirm' );
			sajax_do_call( 'AbuseFilter::ajaxReAutoconfirm', [name], processReautoconfirm );
		}
		function processReautoconfirm( request ) {
			var response = request.responseText;
			
			if (strlen(response)) {
				jsMsg( response );
			}
			
			removeSpinner( 'abusefilter-reautoconfirm' );
		}
		";
		
		$wgOut->addInlineScript( $exprScript );
		
		global $wgUser;
		
		if ($wgUser->isAllowed( 'abusefilter-modify' )) {
			// Hacky little box to re-enable autoconfirmed if it got disabled
			$rac = '';
			$rac .= Xml::inputLabel( wfMsg( 'abusefilter-tools-reautoconfirm-user' ), 'wpReAutoconfirmUser', 'reautoconfirm-user', 45 );
			$rac .= Xml::element( 'input', array( 'type' => 'button', 'id' => 'mw-abusefilter-reautoconfirmsubmit', 'onclick' => 'doReautoSubmit();', 'value' => wfMsg( 'abusefilter-tools-reautoconfirm-submit' ) ) );
			$rac = Xml::fieldset( wfMsg( 'abusefilter-tools-reautoconfirm' ), $rac );
			$wgOut->addHTML( $rac );
		}
	}
	
	function showStatus() {
		global $wgMemc,$wgAbuseFilterConditionLimit,$wgOut, $wgLang;
		
		$overflow_count = (int)$wgMemc->get( AbuseFilter::filterLimitReachedKey() );
		$match_count = (int) $wgMemc->get( AbuseFilter::filterMatchesKey() );
		$total_count = (int)$wgMemc->get( AbuseFilter::filterUsedKey() );
		
		if ($total_count>0) {
			$overflow_percent = sprintf( "%.2f", 100 * $overflow_count / $total_count );
			$match_percent = sprintf( "%.2f", 100 * $match_count / $total_count );

			$status = wfMsgExt( 'abusefilter-status', array( 'parsemag', 'escape' ),
				$wgLang->formatNum($total_count),
				$wgLang->formatNum($overflow_count),
				$wgLang->formatNum($overflow_percent),
				$wgLang->formatNum($wgAbuseFilterConditionLimit),
				$wgLang->formatNum($match_count),
				$wgLang->formatNum($match_percent)
			);
			
			$status = Xml::tags( 'div', array( 'class' => 'mw-abusefilter-status' ), $status );
			$wgOut->addHTML( $status );
		}
	}
	
	function doEdit( $history_id = null ) {
		global $wgRequest, $wgUser;
		
		$filter = $this->mFilter;
		
		$editToken = $wgRequest->getVal( 'wpEditToken' );
		$didEdit = $this->canEdit() && $wgUser->matchEditToken( $editToken, array( 'abusefilter', $filter ) );
		
		if ($didEdit) {
			// Check syntax
			$syntaxerr = AbuseFilter::checkSyntax( $wgRequest->getVal( 'wpFilterRules' ) );
			if ($syntaxerr !== true ) {
				return $this->buildFilterEditor( wfMsgExt( 'abusefilter-edit-badsyntax', array( 'parseinline' ), array( $syntaxerr ) ), $filter, $history_id );
			}
		
			$dbw = wfGetDB( DB_MASTER );
			
			list ($newRow, $actions) = $this->loadRequest($filter);
			
			$newRow = get_object_vars($newRow); // Convert from object to array
			
			// Set last modifier.
			$newRow['af_timestamp'] = $dbw->timestamp( wfTimestampNow() );
			$newRow['af_user'] = $wgUser->getId();
			$newRow['af_user_text'] = $wgUser->getName();
			
			$dbw->begin();
			
			if ($filter == 'new') {
				$new_id = $dbw->nextSequenceValue( 'abuse_filter_af_id_seq' );
				$is_new = true;
			} else {
				$new_id = $this->mFilter;
				$is_new = false;
			}
			
			$newRow['af_id'] = $new_id;
			
			$dbw->replace( 'abuse_filter', array( 'af_id' ), $newRow, __METHOD__ );
			
			if ($is_new) {
				$new_id = $dbw->insertId();
			}
			
			// Actions
			global $wgAbuseFilterAvailableActions;
			$deadActions = array();
			$actionsRows = array();
			foreach( $wgAbuseFilterAvailableActions as $action ) {
				// Check if it's set
				$enabled = isset($actions[$action]) && (bool)$actions[$action];
				
				if ($enabled) {
					$parameters = $actions[$action]['parameters'];
					
					$thisRow = array( 'afa_filter' => $new_id, 'afa_consequence' => $action, 'afa_parameters' => implode( "\n", $parameters ) );
					$actionsRows[] = $thisRow;
				} else {
					$deadActions[] = $action;
				}
			}
			
			// Create a history row			
			$afh_row = array();
			
			foreach( self::$history_mappings as $af_col => $afh_col ) {
				$afh_row[$afh_col] = $newRow[$af_col];
			}
			
			// Actions
			$displayActions = array();
			foreach( $actions as $action ) {
				$displayActions[$action['action']] = $action['parameters'];
			}
			$afh_row['afh_actions'] = serialize($displayActions);
			
			// Flags
			$flags = array();
			if ($newRow['af_hidden'])
				$flags[] = 'hidden';
			if ($newRow['af_enabled'])
				$flags[] = 'enabled';
			if ($newRow['af_deleted'])
				$flags[] = 'deleted';
				
			$afh_row['afh_flags'] = implode( ",", $flags );
				
			$afh_row['afh_filter'] = $new_id;
			
			// Do the update			
			$dbw->insert( 'abuse_filter_history', $afh_row, __METHOD__ );
			$dbw->delete( 'abuse_filter_action', array( 'afa_filter' => $filter, 'afa_consequence' => $deadActions ), __METHOD__ );
			$dbw->replace( 'abuse_filter_action', array( array( 'afa_filter', 'afa_consequence' ) ), $actionsRows, __METHOD__ );
			
			$dbw->commit();
			
			global $wgOut;
			
			$wgOut->setSubtitle( wfMsg('abusefilter-edit-done-subtitle' ) );
			return wfMsgExt( 'abusefilter-edit-done', array( 'parse' ) );
		} else {
			return $this->buildFilterEditor( null, $filter, $history_id );
		}
	}
	
	function buildFilterEditor( $error = '', $filter, $history_id=null ) {
		if( $filter === null ) {
			return false;
		}
		
		// Build the edit form
		global $wgOut,$wgLang,$wgUser;
		$sk = $this->mSkin;
		
		list ($row, $actions) = $this->loadRequest($filter, $history_id);

		if( !$row ) {
			return false;
		}
		
		$wgOut->setSubtitle( wfMsg( 'abusefilter-edit-subtitle', $filter, $history_id ) );

		if (isset($row->af_hidden) && $row->af_hidden && !$this->canEdit()) {
			return wfMsg( 'abusefilter-edit-denied' );
		}
		
		$output = '';
		if ($error) {
			$wgOut->addHTML( "<span class=\"error\">$error</span>" );
		}
		
		$wgOut->addHTML( $sk->link( $this->getTitle(), wfMsg( 'abusefilter-history-backlist' ) ) );
		
		$fields = array();
		
		$fields['abusefilter-edit-id'] = $this->mFilter == 'new' ? wfMsg( 'abusefilter-edit-new' ) : $filter;
		$fields['abusefilter-edit-description'] = Xml::input( 'wpFilterDescription', 45, isset( $row->af_public_comments ) ? $row->af_public_comments : '' );

		// Hit count display
		if( !empty($row->af_hit_count) ){
			$count = (int)$row->af_hit_count;
			$count_display = wfMsgExt( 'abusefilter-hitcount', array( 'parseinline' ),
				$wgLang->formatNum( $count )
			);
			$hitCount = $sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'AbuseLog' ), $count_display, 'wpSearchFilter='.$row->af_id );
		
			$fields['abusefilter-edit-hitcount'] = $hitCount;
		}
		
		if ($filter !== 'new') {
			// Statistics
			global $wgMemc, $wgLang;
			$matches_count = $wgMemc->get( AbuseFilter::filterMatchesKey( $filter ) );
			$total = $wgMemc->get( AbuseFilter::filterUsedKey() );
			
			if ($total > 0) {
				$matches_percent = sprintf( '%.2f', 100 * $matches_count / $total );
				$fields['abusefilter-edit-status-label'] =
					wfMsgExt( 'abusefilter-edit-status', array( 'parsemag', 'escape' ),
						$wgLang->formatNum($total),
						$wgLang->formatNum($matches_count),
						$wgLang->formatNum($matches_percent)
					);
			}
		}

		$fields['abusefilter-edit-rules'] = $this->buildEditBox($row);
		$fields['abusefilter-edit-notes'] = Xml::textarea( 'wpFilterNotes', ( isset( $row->af_comments ) ? $row->af_comments."\n" : "\n" ) );
		
		// Build checkboxen
		$checkboxes = array( 'hidden', 'enabled', 'deleted' );
		$flags = '';
		
		if (isset($row->af_throttled) && $row->af_throttled) {
			global $wgAbuseFilterEmergencyDisableThreshold;
			$threshold_percent = sprintf( '%.2f', $wgAbuseFilterEmergencyDisableThreshold * 100 );
			$flags .= $wgOut->parse( wfMsg( 'abusefilter-edit-throttled', $wgLang->formatNum( $threshold_percent ) ) );
		}
		
		foreach( $checkboxes as $checkboxId ) {
			$message = "abusefilter-edit-$checkboxId";
			$dbField = "af_$checkboxId";
			$postVar = "wpFilter".ucfirst($checkboxId);
			
			$checkbox = Xml::checkLabel( wfMsg( $message ), $postVar, $postVar, isset( $row->$dbField ) ? $row->$dbField : false );
			$checkbox = Xml::tags( 'p', null, $checkbox );
			$flags .= $checkbox;
		}
		$fields['abusefilter-edit-flags'] = $flags;
		
		if ($filter != 'new') {
			// Last modification details
			$user = $sk->userLink( $row->af_user, $row->af_user_text ) . $sk->userToolLinks( $row->af_user, $row->af_user_text );
			$fields['abusefilter-edit-lastmod'] = wfMsgExt( 'abusefilter-edit-lastmod-text', array( 'parseinline', 'replaceafter' ), array( $wgLang->timeanddate( $row->af_timestamp ), $user ) );
			$history_display = wfMsgExt( 'abusefilter-edit-viewhistory', array( 'parseinline' ) );
			$fields['abusefilter-edit-history'] = $sk->makeKnownLinkObj( $this->getTitle( 'history/'.$filter ), $history_display );
		}
		
		$form = Xml::buildForm( $fields );
		$form = Xml::fieldset( wfMsg( 'abusefilter-edit-main' ), $form );
		$form .= Xml::fieldset( wfMsg( 'abusefilter-edit-consequences' ), $this->buildConsequenceEditor( $row, $actions ) );
		
		if ($this->canEdit()) {
			$form .= Xml::submitButton( wfMsg( 'abusefilter-edit-save' ) );
			$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken( array( 'abusefilter', $filter )) );
		}
		
		$form = Xml::tags( 'form', array( 'action' => $this->getTitle( $filter )->getFullURL(), 'method' => 'POST' ), $form );
		
		$output .= $form;
		
		return $output;
	}
	
	function buildEditBox( $row ) {
		global $wgOut;
		
		$rules = Xml::textarea( 'wpFilterRules', ( isset( $row->af_pattern ) ? $row->af_pattern."\n" : "\n" ) );
		
		$dropDown = array(
			'op-arithmetic' => array('+' => 'addition', '-' => 'subtraction', '*' => 'multiplication', '/' => 'divide', '%' => 'modulo', '**' => 'pow'),
			'op-comparison' => array('==' => 'equal', '!=' => 'notequal', '<' => 'lt', '>' => 'gt', '<=' => 'lte', '>=' => 'gte'),
			'op-bool' => array( '!' => 'not', '&' => 'and', '|' => 'or', '^' => 'xor' ),
			'misc' => array( 'val1 ? iftrue : iffalse' => 'ternary', 'in' => 'in', 'like' => 'like', '""' => 'stringlit', ),
			'funcs' => array( 'length(string)' => 'length', 'lcase(string)' => 'lcase', 'ccnorm(string)' => 'ccnorm', 'rmdoubles(string)' => 'rmdoubles', 'specialratio(string)' => 'specialratio', 'norm(string)' => 'norm', 'count(needle,haystack)' => 'count' ),
			'vars' => array( 'ACCOUNTNAME' => 'accountname', 'ACTION' => 'action', 'ADDED_LINES' => 'addedlines', 'EDIT_DELTA' => 'delta', 'EDIT_DIFF' => 'diff', 'NEW_SIZE' => 'newsize', 'OLD_SIZE' => 'oldsize', 'REMOVED_LINES' => 'removedlines', 'SUMMARY' => 'summary', 'ARTICLE_ARTICLEID' => 'article-id', 'ARTICLE_NAMESPACE' => 'article-ns', 'ARTICLE_TEXT' => 'article-text', 'ARTICLE_PREFIXEDTEXT' => 'article-prefixedtext', 'MOVED_FROM_ARTICLEID' => 'movedfrom-id', 'MOVED_FROM_NAMESPACE' => 'movedfrom-ns', 'MOVED_FROM_TEXT' => 'movedfrom-text', 'MOVED_FROM_PREFIXEDTEXT' => 'movedfrom-prefixedtext', 'MOVED_TO_ARTICLEID' => 'movedto-id', 'MOVED_TO_NAMESPACE' => 'movedto-ns', 'MOVED_TO_TEXT' => 'movedto-text', 'MOVED_TO_PREFIXEDTEXT' => 'movedto-prefixedtext', 'USER_EDITCOUNT' =>  'user-editcount', 'USER_AGE' => 'user-age', 'USER_NAME' => 'user-name', 'USER_GROUPS' => 'user-groups', 'USER_EMAILCONFIRM' => 'user-emailconfirm'),
		);
		
		// Generate builder drop-down
		$builder = '';
		
		$builder .= Xml::option( wfMsg( "abusefilter-edit-builder-select") );
		
		foreach( $dropDown as $group => $values ) {
			$builder .= Xml::openElement( 'optgroup', array( 'label' => wfMsg( "abusefilter-edit-builder-group-$group" ) ) ) . "\n";
			
			foreach( $values as $content => $name ) {
				$builder .= Xml::option( wfMsg( "abusefilter-edit-builder-$group-$name" ), $content ) . "\n";
			}
			
			$builder .= Xml::closeElement( 'optgroup' ) . "\n";
		}
		
		$rules .= Xml::tags( 'select', array( 'id' => 'wpFilterBuilder', 'onchange' => 'addText();' ), $builder );
		
		// Add syntax checking
		$rules .= Xml::element( 'input', array( 'type' => 'button', 'onclick' => 'doSyntaxCheck()', 'value' => wfMsg( 'abusefilter-edit-check' ), 'id' => 'mw-abusefilter-syntaxcheck' ) );
		
		// Add script
		$scScript = file_get_contents(dirname(__FILE__)."/edit.js");
		
		$wgOut->addInlineScript( $scScript );
		
		return $rules;
	}
	
	function buildConsequenceEditor( $row, $actions ) {
		global $wgAbuseFilterAvailableActions;
		$setActions = array();
		foreach( $wgAbuseFilterAvailableActions as $action ) {
			$setActions[$action] = array_key_exists( $action, $actions );
		}
		
		$output = '';
		
		// Special case: flagging - always on.
		$checkbox = Xml::checkLabel( wfMsg( 'abusefilter-edit-action-flag' ), 'wpFilterActionFlag', 'wpFilterActionFlag', true, array( 'disabled' => '1' ) );
		$output .= Xml::tags( 'p', null, $checkbox );
		
		// Special case: throttling
		$throttleSettings = Xml::checkLabel( wfMsg( 'abusefilter-edit-action-throttle' ), 'wpFilterActionThrottle', 'wpFilterActionThrottle', $setActions['throttle'] );
		$throttleFields = array();
		
		if ($setActions['throttle']) {
			array_shift( $actions['throttle']['parameters'] );
			$throttleRate = explode(',',$actions['throttle']['parameters'][0]);
			$throttleCount = $throttleRate[0];
			$throttlePeriod = $throttleRate[1];
			
			$throttleGroups = implode("\n", array_slice($actions['throttle']['parameters'], 1 ) );
		} else {
			$throttleCount = 3;
			$throttlePeriod = 60;
			
			$throttleGroups = "user\n";
		}
		
		$throttleFields['abusefilter-edit-throttle-count'] = Xml::input( 'wpFilterThrottleCount', 20, $throttleCount );
		$throttleFields['abusefilter-edit-throttle-period'] = wfMsgExt( 'abusefilter-edit-throttle-seconds', array( 'parseinline', 'replaceafter' ), array(Xml::input( 'wpFilterThrottlePeriod', 20, $throttlePeriod )  ) );
		$throttleFields['abusefilter-edit-throttle-groups'] = Xml::textarea( 'wpFilterThrottleGroups', $throttleGroups."\n" );
		$throttleSettings .= Xml::buildForm( $throttleFields );
		$output .= Xml::tags( 'p', null, $throttleSettings );
		
		// Special case: Warning
		$checkbox = Xml::checkLabel( wfMsg( 'abusefilter-edit-action-warn' ), 'wpFilterActionWarn', 'wpFilterActionWarn', $setActions['warn'] );
		$output .= Xml::tags( 'p', null, $checkbox );
		
		$warnMsg = empty($setActions['warn']) ? 'abusefilter-warning' : $actions['warn']['parameters'][0];
		$warnFields['abusefilter-edit-warn-message'] = Xml::input( 'wpFilterWarnMessage', 45, $warnMsg );
		$output .= Xml::tags( 'p', null, Xml::buildForm( $warnFields ) );
		
		// The remainder are just toggles
		$remainingActions = array_diff( $wgAbuseFilterAvailableActions, array( 'flag', 'throttle', 'warn' ) );
		
		foreach( $remainingActions as $action ) {
			$message = 'abusefilter-edit-action-'.$action;
			$form_field = 'wpFilterAction' . ucfirst($action);
			$status = $setActions[$action];
			
			$thisAction = Xml::checkLabel( wfMsg( $message ), $form_field, $form_field, $status );
			$thisAction = Xml::tags( 'p', null, $thisAction );
			
			$output .= $thisAction;
		}
		
		return $output;
	}
	
	function loadFilterData( $id ) {
	
		if ($id == 'new') {
			return array( new StdClass, array() );
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		
		// Load the main row
		$row = $dbr->selectRow( 'abuse_filter', '*', array( 'af_id' => $id ), __METHOD__ );
		
		if (!isset($row) || !isset($row->af_id) || !$row->af_id)
			return null;
		
		// Load the actions
		$actions = array();
		$res = $dbr->select( 'abuse_filter_action', '*', array( 'afa_filter' => $id), __METHOD__ );
		while ( $actionRow = $dbr->fetchObject( $res ) ) {
			$thisAction = array();
			$thisAction['action'] = $actionRow->afa_consequence;
			$thisAction['parameters'] = explode( "\n", $actionRow->afa_parameters );
			
			$actions[$actionRow->afa_consequence] = $thisAction;
		}
		
		return array( $row, $actions );
	}
	
	function loadHistoryItem( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		// Load the row.
		$row = $dbr->selectRow( 'abuse_filter_history', '*', array( 'afh_id' => $id ), __METHOD__ );
		
		## Translate into an abuse_filter row with some black magic. This is ever so slightly evil!
		$af_row = new StdClass;
		
		foreach (self::$history_mappings as $af_col => $afh_col ) {
			$af_row->$af_col = $row->$afh_col;
		}
		
		## Process flags
		
		$af_row->af_deleted = 0;
		$af_row->af_hidden = 0;
		$af_row->af_enabled = 0;
		
		$flags = explode(',', $row->afh_flags );
		foreach( $flags as $flag ) {
			$col_name = "af_$flag";
			$af_row->$col_name = 1;
		}
		
		## Process actions
		$actions_raw = unserialize($row->afh_actions);
		$actions_output = array();
		
		foreach( $actions_raw as $action => $parameters ) {
			$actions_output[$action] = array( 'action' => $action, 'parameters' => $parameters );
		}
		
		
		return array( $af_row, $actions_output );
	}
	
	function loadParameters( $subpage ) {
		global $wgRequest;
		
		$filter = $subpage;
		
		if (!is_numeric($filter) && $filter != 'new') {
			$filter = $wgRequest->getIntOrNull( 'wpFilter' );
		}
		$this->mFilter = $filter;
	}
	
	function loadRequest( $filter, $history_id = null ) {
		static $row = null;
		static $actions = null;
		global $wgRequest;
		
		if (!is_null($actions) && !is_null($row)) {
			return array($row,$actions);
		} elseif ($wgRequest->wasPosted()) {
			## Nothing, we do it all later
		} elseif ( $history_id ) {
			return $this->loadHistoryItem( $history_id );
		} else {
			return $this->loadFilterData( $filter );
		}
		
		// We need some details like last editor
		list($row) = $this->loadFilterData( $filter );
		
		$textLoads = array( 'af_public_comments' => 'wpFilterDescription', 'af_pattern' => 'wpFilterRules', 'af_comments' => 'wpFilterNotes' );
		
		foreach( $textLoads as $col => $field ) {
			$row->$col = trim($wgRequest->getVal( $field ));
		}
		
		$row->af_deleted = $wgRequest->getBool( 'wpFilterDeleted' );
		$row->af_enabled = $wgRequest->getBool( 'wpFilterEnabled' ) && !$row->af_deleted;
		$row->af_hidden = $wgRequest->getBool( 'wpFilterHidden' );
		
		// Actions
		global $wgAbuseFilterAvailableActions;
		$actions = array();
		foreach( $wgAbuseFilterAvailableActions as $action ) {
			// Check if it's set
			$enabled = $wgRequest->getBool( 'wpFilterAction'.ucfirst($action) );
			
			if ($enabled) {
				$parameters = array();
				
				if ($action == 'throttle') {
					// Grumble grumble.
					// We need to load the parameters
					$throttleCount = $wgRequest->getIntOrNull( 'wpFilterThrottleCount' );
					$throttlePeriod = $wgRequest->getIntOrNull( 'wpFilterThrottlePeriod' );
					$throttleGroups = explode("\n", trim( $wgRequest->getText( 'wpFilterThrottleGroups' ) ) );
					
					$parameters[0] = $this->mFilter; // For now, anyway
					$parameters[1] = "$throttleCount,$throttlePeriod";
					$parameters = array_merge( $parameters, $throttleGroups );
				} elseif ($action == 'warn') {
					$parameters[0] = $wgRequest->getVal( 'wpFilterWarnMessage' );
				}
				
				$thisAction = array( 'action' => $action, 'parameters' => $parameters );
				$actions[$action] = $thisAction;
			}
		}
		
		return array( $row, $actions );
	}
	
	function canEdit() {
		global $wgUser;
		static $canEdit = 'unset';
		
		if ($canEdit == 'unset') {
			$canEdit = $wgUser->isAllowed( 'abusefilter-modify' );
		}
		
		return $canEdit;
	}
	
	function showList( $conds = array( 'af_deleted' => 0 ), $optarray = array() ) {
		global $wgOut,$wgUser;
		
		$sk = $this->mSkin = $wgUser->getSkin();
		
		$output = '';
		$output .= Xml::element( 'h2', null, wfMsgExt( 'abusefilter-list', array( 'parseinline' ) ) );
		
		$pager = new AbuseFilterPager( $this, $conds );
		
		extract($optarray);
		
		## Options form
		$options = '';
		$fields = array();
		$fields['abusefilter-list-options-deleted'] = Xml::radioLabel( wfMsg( 'abusefilter-list-options-deleted-show' ), 'deletedfilters', 'show', 'mw-abusefilter-deletedfilters-show', $deleted == 'show' );
		$fields['abusefilter-list-options-deleted'] .= Xml::radioLabel( wfMsg( 'abusefilter-list-options-deleted-hide' ), 'deletedfilters', 'hide', 'mw-abusefilter-deletedfilters-hide', $deleted == 'hide' );
		$fields['abusefilter-list-options-deleted'] .= Xml::radioLabel( wfMsg( 'abusefilter-list-options-deleted-only' ), 'deletedfilters', 'only', 'mw-abusefilter-deletedfilters-only', $deleted == 'only' );
		$fields['abusefilter-list-options-disabled'] = Xml::checkLabel( wfMsg( 'abusefilter-list-options-hidedisabled' ), 'hidedisabled', 'mw-abusefilter-disabledfilters-hide', $hidedisabled );
		$fields['abusefilter-list-limit'] = $pager->getLimitSelect();
		
		$options = Xml::buildForm( $fields, 'abusefilter-list-options-submit' );
		$options .= Xml::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$options = Xml::tags( 'form', array( 'method' => 'get', 'action' => $this->getTitle()->getFullURL() ), $options );
		$options = Xml::fieldset( wfMsg( 'abusefilter-list-options' ), $options );
		
		$output .= $options;
		
		$output .=
			$pager->getNavigationBar() .
			$pager->getBody() . 
			$pager->getNavigationBar();
		
		$wgOut->addHTML( $output );
	}
}

class AbuseFilterPager extends TablePager {

	function __construct( $page, $conds ) {
		$this->mPage = $page;
		$this->mConds = $conds;
		parent::__construct();
	}
	
	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );
		#$this->mConds[] = 'afa_filter=af_id';
		$abuse_filter = $dbr->tableName( 'abuse_filter' );
		return array( 'tables' => array('abuse_filter', 'abuse_filter_action'),
			'fields' => array( 'af_id', '(af_enabled | af_deleted << 1) AS status', 'af_public_comments', 'af_hidden', 'af_hit_count', 'af_timestamp', 'af_user_text', 'af_user', 'group_concat(afa_consequence) AS consequences' ),
			'conds' => $this->mConds,
			'options' => array( 'GROUP BY' => 'af_id' ),
			'join_conds' => array( 'abuse_filter_action' => array( 'LEFT JOIN', 'afa_filter=af_id' ) ) );
	}
	
	function getIndexField() {
		return 'af_id';
	}
	
	function getFieldNames() {
		static $headers = null;
		
		if (!empty($headers)) {
			return $headers;
		}
	
		$headers = array( 'af_id' => 'abusefilter-list-id', 'af_public_comments' => 'abusefilter-list-public', 'consequences' => 'abusefilter-list-consequences', 'status' => 'abusefilter-list-status', 'af_timestamp' => 'abusefilter-list-lastmodified', 'af_hidden' => 'abusefilter-list-visibility', 'af_hit_count' => 'abusefilter-list-hitcount' );
		
		$headers = array_map( 'wfMsg', $headers );
		
		return $headers;
	}
	
	function formatValue( $name, $value ) {
		global $wgOut,$wgLang;
		
		static $sk=null;
		
		if (empty($sk)) {
			global $wgUser;
			$sk = $wgUser->getSkin();
		}
		
		$row = $this->mCurrentRow;
		
		switch($name) {
			case 'af_id':
				return $sk->link( SpecialPage::getTitleFor( 'AbuseFilter', intval($value) ), intval($value) );
			case 'af_public_comments':
				return $wgOut->parse( $value );
			case 'consequences':
				return htmlspecialchars($value);
			case 'status':
				if ($value & 2)
					return wfMsgExt( 'abusefilter-deleted', 'parseinline' );
				elseif ($value & 1)
					return wfMsgExt( 'abusefilter-enabled', 'parseinline' );
				else
					return wfMsgExt( 'abusefilter-disabled', 'parseinline' );
			case 'af_hidden':
				$msg = $value ? 'abusefilter-hidden' : 'abusefilter-unhidden';
				return wfMsgExt( $msg, 'parseinline' );
			case 'af_hit_count':
				$count_display = wfMsgExt( 'abusefilter-hitcount', array( 'parseinline' ), $wgLang->formatNum( $value ) );
				$link = $sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'AbuseLog' ), $count_display, 'wpSearchFilter='.$row->af_id );
				return $link;
			case 'af_timestamp':
				$userLink = $sk->userLink( $row->af_user, $row->af_user_text ) . $sk->userToolLinks( $row->af_user, $row->af_user_text );
				return wfMsgExt( 'abusefilter-edit-lastmod-text', array( 'replaceafter', 'parseinline' ), array( $wgLang->timeanddate($value), $userLink ) );
			default:
				throw new MWException( "Unknown row type $name!" );
		}
	}
	
	function getDefaultSort() {
		return 'af_id';
	}
	
	function isFieldSortable($name) {
		$sortable_fields = array( 'af_id', 'status', 'af_hit_count', 'af_throttled', 'af_user_text', 'af_timestamp' );
		return in_array( $name, $sortable_fields );
	}
}

class AbuseFilterHistoryPager extends TablePager {

	function __construct( $filter, $page ) {
		$this->mFilter = $filter;
		$this->mPage = $page;
		$this->mDefaultDirection = true;
		parent::__construct();
	}
	
	function getFieldNames() {
		static $headers = null;
		
		if (!empty($headers)) {
			return $headers;
		}
	
		$headers = array( 'afh_timestamp' => 'abusefilter-history-timestamp', 'afh_user_text' => 'abusefilter-history-user', 'afh_public_comments' => 'abusefilter-history-public',
					'afh_flags' => 'abusefilter-history-flags', 'afh_pattern' => 'abusefilter-history-filter', 'afh_comments' => 'abusefilter-history-comments', 'afh_actions' => 'abusefilter-history-actions' );
		
		$headers = array_map( 'wfMsg', $headers );
		
		return $headers;
	}
	
	function formatValue( $name, $value ) {
		global $wgOut,$wgLang;
		
		static $sk=null;
		
		if (empty($sk)) {
			global $wgUser;
			$sk = $wgUser->getSkin();
		}
		
		$row = $this->mCurrentRow;
		
		switch($name) {
			case 'afh_timestamp':
				$title = SpecialPage::getTitleFor( 'AbuseFilter', 'history/'.$this->mFilter.'/item/'.$row->afh_id );
				return $sk->link( $title, $wgLang->timeanddate( $row->afh_timestamp ) );
			case 'afh_user_text':
				return $sk->userLink( $row->afh_user, $row->afh_user_text ) . ' ' . $sk->userToolLinks( $row->afh_user, $row->afh_user_text );
			case 'afh_public_comments':
				return $wgOut->parse( $value );
			case 'afh_flags':
				$flags = array_filter( explode( ',', $value ) );
				$flags_display = array();
				foreach( $flags as $flag ) {
					$flags_display[] = wfMsg( "abusefilter-history-$flag" );
				}
				return implode( ', ', $flags_display );
			case 'afh_pattern':
				return htmlspecialchars( $wgLang->truncate( $value, 200, '...' ) );
			case 'afh_comments':
				return htmlspecialchars( $wgLang->truncate( $value, 200, '...' ) );
			case 'afh_actions':
				$actions = unserialize( $value );
				
				$display_actions = '';
				
				foreach( $actions as $action => $parameters ) {
					$display_actions .= Xml::tags( 'li', null, wfMsgExt( 'abusefilter-history-action', array( 'parseinline' ), array($action, implode(';', $parameters)) ) );
				}
				$display_actions = Xml::tags( 'ul', null, $display_actions );
				
				return $display_actions;
		}
		
		return "Unable to format name $name\n";
	}
	
	function getQueryInfo() {
		return array(
			'tables' => 'abuse_filter_history',
			'fields' => array( 'afh_timestamp', 'afh_user_text', 'afh_public_comments', 'afh_flags', 'afh_pattern', 'afh_comments', 'afh_actions', 'afh_id', 'afh_user' ),
			'conds' => array( 'afh_filter' => $this->mFilter ),
		);
	}
	
	function getIndexField() {
		return 'afh_timestamp';
	}
	
	function getDefaultSort() {
		return 'afh_timestamp';
	}
	
	function isFieldSortable($name) {
		$sortable_fields = array( 'afh_timestamp', 'afh_user_text' );
		return in_array( $name, $sortable_fields );
	}
	
	/**
	 * Title used for self-links. Override this if you want to be able to
	 * use a title other than $wgTitle
	 */
	function getTitle() {
		return $this->mPage->getTitle( "history/".$this->mFilter );
	}
}