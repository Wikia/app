<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilterViewExamine extends AbuseFilterView {
	function show() {
		global $wgOut, $wgUser;

		$wgOut->setPageTitle( wfMsg( 'abusefilter-examine' ) );
		$wgOut->addWikiMsg( 'abusefilter-examine-intro' );

		$this->loadParameters();

		// Check if we've got a subpage
		if ( count( $this->mParams ) > 1 && is_numeric( $this->mParams[1] ) ) {
			$this->showExaminerForRC( $this->mParams[1] );
		} elseif ( count( $this->mParams ) > 2
			&& $this->mParams[1] == 'log'
			&& is_numeric( $this->mParams[2] ) )
		{
			$this->showExaminerForLogEntry( $this->mParams[2] );
		} else {
			$this->showSearch();
		}
	}

	function showSearch() {
		global $wgUser, $wgOut;

		// Add selector
		$selector = '';

		$selectFields = array(); # # Same fields as in Test
		$selectFields['abusefilter-test-user'] = Xml::input( 'wpSearchUser', 45, $this->mSearchUser );
		$selectFields['abusefilter-test-period-start'] =
			Xml::input( 'wpSearchPeriodStart', 45, $this->mSearchPeriodStart );
		$selectFields['abusefilter-test-period-end'] =
			Xml::input( 'wpSearchPeriodEnd', 45, $this->mSearchPeriodEnd );

		$selector .= Xml::buildForm( $selectFields, 'abusefilter-examine-submit' );
		$selector .= Xml::hidden( 'submit', 1 );
		$selector .= Xml::hidden( 'title', $this->getTitle( 'examine' )->getPrefixedText() );
		$selector = Xml::tags( 'form',
			array(
				'action' => $this->getTitle( 'examine' )->getLocalURL(),
				'method' => 'GET'
			),
			$selector
		);
		$selector = Xml::fieldset(
			wfMsg( 'abusefilter-examine-legend' ),
			$selector
		);
		$wgOut->addHTML( $selector );

		if ( $this->mSubmit ) {
			$this->showResults();
		}
	}

	function showResults() {
		global $wgUser, $wgOut;

		$changesList = new AbuseFilterChangesList( $wgUser->getSkin() );
		$output = $changesList->beginRecentChangesList();
		$this->mCounter = 1;

		$pager = new AbuseFilterExaminePager( $this, $changesList );

		$output .= $pager->getNavigationBar() .
					$pager->getBody() .
					$pager->getNavigationBar();

		$output .= $changesList->endRecentChangesList();

		$wgOut->addHTML( $output );
	}

	function showExaminerForRC( $rcid ) {
		global $wgOut;

		// Get data
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'recentchanges', '*', array( 'rc_id' => $rcid ), __METHOD__ );

		if ( !$row ) {
			$wgOut->addWikiMsg( 'abusefilter-examine-notfound' );
			return;
		}

		$vars = AbuseFilter::getVarsFromRCRow( $row );

		$this->showExaminer( $vars );
	}

	function showExaminerForLogEntry( $logid ) {
		global $wgOut;

		// Get data
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'abuse_filter_log', '*', array( 'afl_id' => $logid ), __METHOD__ );

		if ( !$row ) {
			$wgOut->addWikiMsg( 'abusefilter-examine-notfound' );
			return;
		}

		$vars = AbuseFilter::loadVarDump( $row->afl_var_dump );

		$this->showExaminer( $vars );
	}

	function showExaminer( $vars ) {
		global $wgOut, $wgUser;

		if ( !$vars ) {
			$wgOut->addWikiMsg( 'abusefilter-examine-incompatible' );
			return;
		}

		if ( $vars instanceof AbuseFilterVariableHolder )
			$vars = $vars->exportAllVars();

		$output = '';

		// Send armoured as JSON -- I totally give up on trying to send it as a proper object.
		$wgOut->addInlineScript( "var wgExamineVars = " .
			Xml::encodeJsVar( json_encode( $vars ) ) . ";" );
		$wgOut->addInlineScript( file_get_contents( dirname( __FILE__ ) . '/examine.js' ) );

		// Add messages
		$msg = array();
		$msg['match'] = wfMsg( 'abusefilter-examine-match' );
		$msg['nomatch'] = wfMsg( 'abusefilter-examine-nomatch' );
		$msg['syntaxerror'] = wfMsg( 'abusefilter-examine-syntaxerror' );
		$wgOut->addInlineScript(
			"var wgMessageMatch = " . Xml::encodeJsVar( $msg['match'] ) . ";\n" .
			"var wgMessageNomatch = " . Xml::encodeJsVar( $msg['nomatch'] ) . ";\n" .
			"var wgMessageError = " . Xml::encodeJsVar( $msg['syntaxerror'] ) . ";\n"
		);

		// Add test bit
		if ( $wgUser->isAllowed( 'abusefilter-modify' ) ) {
			$tester = Xml::tags( 'h2', null, wfMsgExt( 'abusefilter-examine-test', 'parseinline' ) );
			$tester .= AbuseFilter::buildEditBox( $this->mTestFilter, 'wpTestFilter', false );
			$tester .=
				"\n" .
				Xml::inputLabel(
					wfMsg( 'abusefilter-test-load-filter' ),
					'wpInsertFilter',
					'mw-abusefilter-load-filter',
					10,
					''
				) .
				'&nbsp;' .
				Xml::element(
					'input',
					array(
						'type' => 'button',
						'value' => wfMsg( 'abusefilter-test-load' ),
						'id' => 'mw-abusefilter-load'
					)
				);
			$output .= Xml::tags( 'div', array( 'id' => 'mw-abusefilter-examine-editor' ), $tester );
			$output .= Xml::tags( 'p',
				null,
				Xml::element( 'input',
					array(
						'type' => 'button',
						'value' => wfMsg( 'abusefilter-examine-test-button' ),
						'id' => 'mw-abusefilter-examine-test'
					)
				) .
				Xml::element( 'div',
					array(
						'id' => 'mw-abusefilter-syntaxresult',
						'style' => 'display: none;'
					), '&nbsp;'
				)
			);
		}

		// Variable dump
		$output .= Xml::tags( 'h2', null, wfMsgExt( 'abusefilter-examine-vars', 'parseinline' ) );
		$output .= AbuseFilter::buildVarDumpTable( $vars );

		$wgOut->addHTML( $output );
	}

	function loadParameters() {
		global $wgRequest;
		$searchUsername = $wgRequest->getText( 'wpSearchUser' );
		$this->mSearchPeriodStart = $wgRequest->getText( 'wpSearchPeriodStart' );
		$this->mSearchPeriodEnd = $wgRequest->getText( 'wpSearchPeriodEnd' );
		$this->mSubmit = $wgRequest->getCheck( 'submit' );
		$this->mTestFilter = $wgRequest->getText( 'testfilter' );

		// Normalise username
		$userTitle = Title::newFromText( $searchUsername );

		if ( $userTitle && $userTitle->getNamespace() == NS_USER )
			$this->mSearchUser = $userTitle->getText(); // Allow User:Blah syntax.
		elseif ( $userTitle )
			// Not sure of the value of prefixedText over text, but no need to munge unnecessarily.
			$this->mSearchUser = $userTitle->getPrefixedText();
		else
			$this->mSearchUser = '';
	}
}

class AbuseFilterExaminePager extends ReverseChronologicalPager {
	function __construct( $page, $changesList ) {
		parent::__construct();
		$this->mChangesList = $changesList;
		$this->mPage = $page;
	}

	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );
		$conds = array( 'rc_user_text' => $this->mPage->mSearchUser );
		if ( $startTS = strtotime( $this->mPage->mSearchPeriodStart ) ) {
			$conds[] = 'rc_timestamp>=' . $dbr->addQuotes( $dbr->timestamp( $startTS ) );
		}
		if ( $endTS = strtotime( $this->mPage->mSearchPeriodEnd ) ) {
			$conds[] = 'rc_timestamp<=' . $dbr->addQuotes( $dbr->timestamp( $endTS ) );
		}

		// If one of these is true, we're abusefilter compatible.
		$compatConds = array(
			'rc_this_oldid != 0',
			'rc_log_action' => array( 'move', 'create' ),
		);

		$conds[] = $dbr->makeList( $compatConds, LIST_OR );

		$info = array(
			'tables' => 'recentchanges',
			'fields' => '*',
			'conds' => array_filter( $conds ),
			'options' => array( 'ORDER BY' => 'rc_timestamp DESC' ),
		);

		return $info;
	}

	function formatRow( $row ) {
		# Incompatible stuff.
		$rc = RecentChange::newFromRow( $row );
		$rc->counter = $this->mPage->mCounter++;
		return $this->mChangesList->recentChangesLine( $rc, false );
	}

	function getIndexField() {
		return 'rc_id';
	}

	function getTitle() {
		return $this->mPage->getTitle( 'examine' );
	}

	function getEmptyBody() {
		return wfMsgExt( 'abusefilter-examine-noresults', 'parse' );
	}
}
