<?php

class QualityOversight extends SpecialPage {
	public function __construct() {
		parent::__construct( 'QualityOversight' );
	}

	public function execute( $par ) {
		global $wgFlaggedRevsOversightAge;

		$out = $this->getOutput();
		$request = $this->getRequest();

		$this->setHeaders();

		$this->namespace = $request->getInt( 'namespace' );
		$this->level = $request->getIntOrNull( 'level' );
		$this->status = $request->getIntOrNull( 'status' );
		$this->automatic = $request->getIntOrNull( 'automatic' );
		$this->user = $request->getVal( 'user' );
		# Check if the user exists
		$usertitle = Title::makeTitleSafe( NS_USER, $this->user );
		$u = $usertitle ? User::idFromName( $this->user ) : false;

		# Are the dropdown params given even valid?
		$actions = $this->getActions();
		if ( empty( $actions ) ) {
			$out->addWikiMsg( 'qualityoversight-list', 0 );
			$out->addWikiMsg( 'logempty' );
			return;
		}

		# Get extra query conds
		$conds = array( 'log_namespace' => $this->namespace, 'log_action' => $actions );
		# Get cutoff time (mainly for performance)
		if ( !$u ) {
			$dbr = wfGetDB( DB_SLAVE );
			$cutoff_unixtime = time() - $wgFlaggedRevsOversightAge;
			$cutoff = $dbr->addQuotes( $dbr->timestamp( $cutoff_unixtime ) );
			$conds[] = "log_timestamp >= $cutoff";
		}

		# Create a LogPager item to get the results and a LogEventsList item to format them...
		$loglist = new LogEventsList( $this->getUser()->getSkin(), $out, 0 );
		$pager = new LogPager( $loglist, 'review', $this->user, '', '', $conds );

		# Explanatory text
		$out->addWikiMsg( 'qualityoversight-list',
			$this->getLang()->formatNum( $pager->getNumRows() ) );
		# Show form options
		$this->showForm();

		# Insert list
		$logBody = $pager->getBody();
		if ( $logBody ) {
			$out->addHTML(
				$pager->getNavigationBar() .
				$loglist->beginLogEventsList() .
				$logBody .
				$loglist->endLogEventsList() .
				$pager->getNavigationBar()
			);
		} else {
			$out->addWikiMsg( 'logempty' );
		}
	}
	
	private function showForm() {
		global $wgScript;

		$this->getOutput()->addHTML(
			Xml::openElement( 'form', array( 'name' => 'qualityoversight',
				'action' => $wgScript, 'method' => 'get' ) ) .
			'<fieldset><legend>' . wfMsgHtml( 'qualityoversight-legend' ) . '</legend><p>' .
			Html::hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) .
			FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&#160;' .
			( FlaggedRevs::qualityVersions()
				? FlaggedRevsXML::getLevelMenu( $this->level, 'revreview-filter-all', 1 ) .
					'&#160;'
				: ""
			) .
			Xml::inputLabel( wfMsg( 'specialloguserlabel' ), 'user', 'user', 20, $this->user ) .
				'<br />' .
			FlaggedRevsXML::getStatusFilterMenu( $this->status ) . '&#160;' .
			FlaggedRevsXML::getAutoFilterMenu( $this->automatic ) . '&#160;' .
			Xml::submitButton( wfMsg( 'go' ) ) .
			'</p></fieldset>' . Xml::closeElement( 'form' )
		);
	}
	
	/*
	 * Get actions for IN clause
	 * @return array
	 */
	private function getActions() {
		$actions = array(
			'approve' => 1, 'approve2' => 1, 'approve-a' => 1, 'approve-i' => 1,
			'approve-ia' => 1, 'approve2-i' => 1, 'unapprove' => 1, 'unapprove2' => 1
		);
		if ( $this->level === 0 ) { // checked revisions
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove2'] = 0;
		} elseif ( $this->level === 1 ) { // quality revisions
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['unapprove'] = 0;
		}
		if ( $this->status === 1 ) { // approved first time
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve2'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		} elseif ( $this->status === 2 ) { // re-approved
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		} elseif ( $this->status === 3 ) { // depreciated
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
		}
		if ( $this->automatic === 0 ) { // manual review
			$actions['approve-a'] = 0;
			$actions['approve-ia'] = 0;
		} elseif ( $this->automatic === 1 ) { // auto-reviewed
			$actions['approve'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		}
		$showActions = array();
		foreach ( $actions as $action => $show ) {
			if ( $show )
				$showActions[] = $action;
		}
		return $showActions;
	}
}
