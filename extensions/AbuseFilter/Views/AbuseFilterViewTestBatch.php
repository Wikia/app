<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilterViewTestBatch extends AbuseFilterView {
	// Hard-coded for now.
	static $mChangeLimit = 100;

	function show() {
		global $wgOut, $wgUser, $wgRequest;

		AbuseFilter::disableConditionLimit();

		if ( !$wgUser->isAllowed( 'abusefilter-modify' ) ) {
			$wgOut->addWikiMsg( 'abusefilter-mustbeeditor' );
			return;
		}

		$this->loadParameters();

		$wgOut->setPageTitle( wfMsg( 'abusefilter-test' ) );
		$wgOut->addWikiMsg( 'abusefilter-test-intro', self::$mChangeLimit );

		$output = '';
		$output .= AbuseFilter::buildEditBox( $this->mFilter, 'wpTestFilter' ) . "\n";
		$output .=
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
		$output = Xml::tags( 'div', array( 'id' => 'mw-abusefilter-test-editor' ), $output );

 		$output .= Xml::tags( 'p', null, Xml::checkLabel( wfMsg( 'abusefilter-test-shownegative' ), 'wpShowNegative', 'wpShowNegative', $this->mShowNegative ) );

		// Selectory stuff
		$selectFields = array();
		$selectFields['abusefilter-test-user'] = Xml::input( 'wpTestUser', 45, $this->mTestUser );
		$selectFields['abusefilter-test-period-start'] =
			Xml::input( 'wpTestPeriodStart', 45, $this->mTestPeriodStart );
		$selectFields['abusefilter-test-period-end'] =
			Xml::input( 'wpTestPeriodEnd', 45, $this->mTestPeriodEnd );
		$selectFields['abusefilter-test-page'] =
			Xml::input( 'wpTestPage', 45, $this->mTestPage );

		$output .= Xml::buildForm( $selectFields, 'abusefilter-test-submit' );

		$output .= Xml::hidden( 'title', $this->getTitle( 'test' )->getPrefixedText() );
		$output = Xml::tags( 'form',
			array(
				'action' => $this->getTitle( 'test' )->getLocalURL(),
				'method' => 'POST'
			),
			$output
		);

		$output = Xml::fieldset( wfMsg( 'abusefilter-test-legend' ), $output );

		$wgOut->addHTML( $output );

		if ( $wgRequest->wasPosted() ) {
			$this->doTest();
		}
	}

	function doTest() {
		// Quick syntax check.
		global $wgUser, $wgOut;
		if ( ( $result = AbuseFilter::checkSyntax( $this->mFilter ) ) !== true ) {
			$wgOut->addWikiMsg( 'abusefilter-test-syntaxerr' );
			return;
		}
		$dbr = wfGetDB( DB_SLAVE );

		$conds = array( 'rc_user_text' => $this->mTestUser );

		if ( $this->mTestPeriodStart ) {
			$conds[] = 'rc_timestamp >= ' .
				$dbr->addQuotes( $dbr->timestamp( strtotime( $this->mTestPeriodStart ) ) );
		}
		if ( $this->mTestPeriodEnd ) {
			$conds[] = 'rc_timestamp <= ' .
				$dbr->addQuotes( $dbr->timestamp( strtotime( $this->mTestPeriodEnd ) ) );
		}
		if ( $this->mTestPage ) {
			$title = Title::newFromText( $this->mTestPage );
			$conds['rc_namespace'] = $title->getNamespace();
			$conds['rc_title'] = $title->getDBkey();
		}

		// Get our ChangesList
		$changesList = new AbuseFilterChangesList( $wgUser->getSkin() );
		$output = $changesList->beginRecentChangesList();

		$res = $dbr->select(
			'recentchanges',
			'*',
			array_filter( $conds ),
			__METHOD__,
			array( 'LIMIT' => self::$mChangeLimit, 'ORDER BY' => 'rc_timestamp desc' )
		);

		$counter = 1;

		while ( $row = $dbr->fetchObject( $res ) ) {
			$vars = AbuseFilter::getVarsFromRCRow( $row );

			if ( !$vars )
				continue;

			$result = AbuseFilter::checkConditions( $this->mFilter, $vars );

			if ( $result || $this->mShowNegative ) {
				// Stash result in RC item
				$rc = RecentChange::newFromRow( $row );
				$rc->examineParams['testfilter'] = $this->mFilter;
				$rc->filterResult = $result;
				$rc->counter = $counter++;
				$output .= $changesList->recentChangesLine( $rc, false );
			}
		}

		$output .= $changesList->endRecentChangesList();

		$wgOut->addHTML( $output );
	}

	function loadParameters() {
		global $wgRequest;

		$this->mFilter = $wgRequest->getText( 'wpTestFilter' );
		$this->mShowNegative = $wgRequest->getBool( 'wpShowNegative' );
		$testUsername = $wgRequest->getText( 'wpTestUser' );
		$this->mTestPeriodEnd = $wgRequest->getText( 'wpTestPeriodEnd' );
		$this->mTestPeriodStart = $wgRequest->getText( 'wpTestPeriodStart' );
		$this->mTestPage = $wgRequest->getText( 'wpTestPage' );

		if ( !$this->mFilter
			&& count( $this->mParams ) > 1
			&& is_numeric( $this->mParams[1] ) )
		{
			$dbr = wfGetDB( DB_SLAVE );
			$this->mFilter = $dbr->selectField( 'abuse_filter',
				'af_pattern',
				array( 'af_id' => $this->mParams[1] ),
				__METHOD__
			);
		}

		// Normalise username
		$userTitle = Title::newFromText( $testUsername );

		if ( $userTitle && $userTitle->getNamespace() == NS_USER )
			$this->mTestUser = $userTitle->getText(); // Allow User:Blah syntax.
		elseif ( $userTitle )
			// Not sure of the value of prefixedText over text, but no need to munge unnecessarily.
			$this->mTestUser = $userTitle->getPrefixedText();
		else
			$this->mTestUser = null; // No user specified.
	}
}
