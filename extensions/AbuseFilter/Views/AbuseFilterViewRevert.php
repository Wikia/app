<?php

if (!defined( 'MEDIAWIKI' ))
	die();

class AbuseFilterViewRevert extends AbuseFilterView {
	function show( ) {
		$filter = $this->mPage->mFilter;

		global $wgUser, $wgRequest, $wgOut;
		$sk = $wgUser->getSkin();

		if ( !$wgUser->isAllowed( 'abusefilter-revert' ) ) {
			$wgOut->permissionRequired( 'abusefilter-revert' );
			return;
		}

		$this->loadParameters();

		if ($this->attemptRevert())
			return;

		$wgOut->addWikiMsg( 'abusefilter-revert-intro', $filter );
		$wgOut->setPageTitle( wfMsg('abusefilter-revert-title', $filter) );

		// First, the search form.
		$searchFields = array();
		$searchFields['abusefilter-revert-filter'] = 
			Xml::element( 'strong', null, $filter );
		$searchFields['abusefilter-revert-periodstart'] = 
			Xml::input( 'wpPeriodStart', 45, $this->origPeriodStart );
		$searchFields['abusefilter-revert-periodend'] = 
			Xml::input( 'wpPeriodEnd', 45, $this->origPeriodEnd );
		$searchForm = Xml::buildForm( $searchFields, 'abusefilter-revert-search' );
		$searchForm .= "\n" . Xml::hidden( 'submit', 1 );
		$searchForm = 
			Xml::tags( 
				'form', 
				array( 
					'action' => $this->getTitle( "revert/$filter" )->getLocalURL(), 
					'method' => 'POST' 
				), 
				$searchForm 
			);
		$searchForm = 
			Xml::fieldset( wfMsg( 'abusefilter-revert-search-legend' ), $searchForm );

		$wgOut->addHTML( $searchForm );

		if ($this->mSubmit) {
			// Add a summary of everything that will be reversed.
			$wgOut->addWikiMsg( 'abusefilter-revert-preview-intro' );

			// Look up all of them.
			$results = $this->doLookup();
			$list = array();
			
			foreach( $results as $result ) {
				$displayActions = array();

				global $wgLang;
				$displayActions = array_map( 
					array( 'AbuseFilter', 'getActionDisplay' ), 
					$result['actions'] );
				
				$msg = wfMsgExt( 
					'abusefilter-revert-preview-item', 
					array( 'parseinline', 'replaceafter' ),
					array( 
						$wgLang->timeanddate( $result['timestamp'], true ), 
						$sk->userLink( $result['userid'], $result['user'] ), 
						$result['action'], 
						$sk->link( $result['title'] ), 
						implode( ', ', $displayActions ),
						$sk->link( 
							SpecialPage::getTitleFor( 'AbuseLog' ), 
							wfMsgNoTrans( 'abusefilter-log-detailslink' ), 
							array(), 
							array('details' =>$result['id']) 
						) 
					)
				);
				$list[] = Xml::tags( 'li', null, $msg );
			}

			$wgOut->addHTML( Xml::tags( 'ul', null, implode("\n", $list) ) );

			// Add a button down the bottom.
			$confirmForm = 
				Xml::hidden( 'editToken', $wgUser->editToken( "abusefilter-revert-$filter" ) ) .
				Xml::hidden( 'title', $this->getTitle("revert/$filter")->getPrefixedText() ) .
				Xml::hidden( 'wpPeriodStart', $this->origPeriodStart ) .
				Xml::hidden( 'wpPeriodEnd', $this->origPeriodEnd ) .
				Xml::inputLabel( 
					wfMsg( 'abusefilter-revert-reasonfield' ), 
					'wpReason', 'wpReason', 45 
				) . 
				"\n" .
				Xml::submitButton( wfMsg( 'abusefilter-revert-confirm' ) );
			$confirmForm = Xml::tags( 
				'form', 
				array( 
					'action' => $this->getTitle("revert/$filter")->getLocalURL(), 
					'method' => 'post' 
				), 
				$confirmForm 
			);
			$wgOut->addHTML( $confirmForm );
		}
	}

	function doLookup() {
		$periodStart = $this->mPeriodStart;
		$periodEnd = $this->mPeriodEnd;
		$filter = $this->mPage->mFilter;

		$conds = array( 'afl_filter' => $filter );

		$dbr = wfGetDB( DB_SLAVE );

		if ($periodStart)
			$conds[] = 'afl_timestamp>'.$dbr->addQuotes( $dbr->timestamp( $periodStart ) );
		if ($periodEnd)
			$conds[] = 'afl_timestamp<'.$dbr->addQuotes( $dbr->timestamp( $periodEnd ) );

		// Database query.
		$res = $dbr->select( 'abuse_filter_log', '*', $conds, __METHOD__ );

		$results = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			if (!$row->afl_actions)
				continue;

			$actions = explode(',', $row->afl_actions);
			$reversibleActions = array( 'block', 'blockautopromote', 'degroup' );
			$currentReversibleActions = array_intersect( $actions, $reversibleActions );
			if ( count( $currentReversibleActions ) ) {
				$results[] = array( 
					'id' => $row->afl_id, 
					'actions' => $currentReversibleActions, 
					'user' => $row->afl_user_text, 
					'userid' => $row->afl_user, 
					'vars' => AbuseFilter::loadVarDump( $row->afl_var_dump ), 
					'title' => Title::makeTitle( $row->afl_namespace, $row->afl_title ), 
					'action' => $row->afl_action, 
					'timestamp' => $row->afl_timestamp 
				);
			}
		}

		return $results;
	}

	function loadParameters() {
		global $wgRequest;

		$this->origPeriodStart = $wgRequest->getText( 'wpPeriodStart' );
		$this->mPeriodStart = strtotime( $this->origPeriodStart );
		$this->origPeriodEnd = $wgRequest->getText( 'wpPeriodEnd' );
		$this->mPeriodEnd = strtotime( $this->origPeriodEnd );
		$this->mSubmit = $wgRequest->getVal( 'submit' );
		$this->mReason = $wgRequest->getVal( 'wpReason' );
	}

	function attemptRevert() {
		global $wgUser, $wgRequest, $wgOut;

		$filter = $this->mPage->mFilter;
		$token = $wgRequest->getVal( 'editToken' );
		if ( !$wgUser->matchEditToken( $token, "abusefilter-revert-$filter" ) )
			return false;

		$results = $this->doLookup();
		foreach( $results as $result ) {
			$actions = $result['actions'];
			foreach( $actions as $action ) {
				$this->revertAction( $action, $result );
			}
		}
		$wgOut->addWikiMsg( 'abusefilter-revert-success', $filter );
		
		return true;
	}

	function revertAction( $action, $result ) {
		switch( $action ) {
			case 'block':
				$block = Block::newFromDB( '', $result['userid'], false );
				if (!$block || $block->getBy() != AbuseFilter::getFilterUser()->getId())
					return false; // Not blocked by abuse filter.

				$block->delete();
				$log = new LogPage( 'block' );
				$log->addEntry( 
					'unblock', 
					Title::makeTitle( NS_USER, $result['user'] ), 
					wfMsgForContent( 
						'abusefilter-revert-reason', $this->mPage->mFilter, $this->mReason 
					) 
				);
				break;
			case 'blockautopromote':
				global $wgMemc;
				$wgMemc->delete( AbuseFilter::autopromoteBlockKey( 
					User::newFromId( $result['userid'] ) ) );
				break;
			case 'degroup':
				// Pull the user's groups from the vars.
				$oldGroups = $result['vars']['USER_GROUPS'];
				$oldGroups = explode(',', $oldGroups);
				$oldGroups = array_diff( 
					$oldGroups, 
					array_intersect( $oldGroups, User::getImplicitGroups() ) 
				);

				$rows = array();
				foreach( $oldGroups as $group ) {
					$rows[] = array( 'ug_user' => $result['userid'], 'ug_group' => $group );
				}

				// Cheat a little bit. User::addGroup repeatedly is too slow.
				$user = User::newFromId( $result['userid'] );
				$currentGroups = $user->getGroups();
				$newGroups = array_merge( $oldGroups, $currentGroups );

				// Don't do anything if there are no groups to add.
				if ( !count( array_diff( $newGroups, $currentGroups ) ) )
					return;
					
				$dbw = wfGetDB( DB_MASTER );
				$dbw->insert( 'user_groups', $rows, __METHOD__, array('IGNORE') );
				$user->invalidateCache();

				$log = new LogPage( 'rights' );
				$log->addEntry( 'rights', $user->getUserPage(), 
					wfMsgForContent( 
						'abusefilter-revert-reason', 
						$this->mPage->mFilter, 
						$this->mReason 
					),
					array( implode(',', $currentGroups), implode(',', $newGroups) ) 
				);
		}
	}
}
