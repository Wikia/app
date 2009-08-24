<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class QualityOversight extends SpecialPage
{
    public function __construct() {
        SpecialPage::SpecialPage( 'QualityOversight' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
		wfLoadExtensionMessages( 'QualityOversight' );
    }

    public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest, $wgFlaggedRevsNamespaces, $wgFlaggedRevsOversightAge;
		
		$this->setHeaders();
		$wgOut->addHTML( wfMsgExt('qualityoversight-list', array('parse') ) );
		
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->level = $wgRequest->getIntOrNull( 'level' );
		$this->status = $wgRequest->getIntOrNull( 'status' );
		$this->automatic = $wgRequest->getIntOrNull( 'automatic' );
		$this->user = $wgRequest->getVal( 'user' );
		# Check if the user exists
		$usertitle = Title::makeTitleSafe( NS_USER, $this->user );
		$u = $usertitle ? User::idFromName( $this->user ) : false;
		
		# Show options
		$this->showForm();
		
		$actions = $this->getActions();
		if( empty($actions) ) {
			$wgOut->addWikiMsg( 'logempty' );
			return;
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		# Get extra query conds
		$conds = array( 'log_namespace' => $this->namespace, 'log_action' => $actions );
		# Get cutoff time (mainly for performance)
		if( !$u ) {
			$cutoff_unixtime = time() - $wgFlaggedRevsOversightAge;
			$cutoff = $dbr->addQuotes( $dbr->timestamp( $cutoff_unixtime ) );
			$conds[] = "log_timestamp >= $cutoff";
		}
		# Create a LogPager item to get the results and a LogEventsList item to format them...
		$loglist = new LogEventsList( $wgUser->getSkin(), $wgOut, 0 );
		$pager = new LogPager( $loglist, 'review', $this->user, '', '', $conds );
		# Insert list
		$logBody = $pager->getBody();
		if( $logBody ) {
			$wgOut->addHTML(
				$pager->getNavigationBar() .
				$loglist->beginLogEventsList() .
				$logBody .
				$loglist->endLogEventsList() .
				$pager->getNavigationBar()
			);
		} else {
			$wgOut->addWikiMsg( 'logempty' );
		}
	}
	
	private function showForm() {
		global $wgOut, $wgTitle, $wgScript;
		$wgOut->addHTML( 
			Xml::openElement( 'form', array('name' => 'qualityoversight','action' => $wgScript,'method' => 'get') ) .
			'<fieldset><legend>' . wfMsgHtml('qualityoversight-legend') . '</legend><p>' .
			Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() ) .
			FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&nbsp;' .
			FlaggedRevsXML::getLevelMenu( $this->level, 'revreview-filter-all', 1 ) . '&nbsp;' .
			Xml::inputLabel( wfMsg( 'specialloguserlabel' ), 'user', 'user', 20, $this->user ) . '<br/>' .
			FlaggedRevsXML::getStatusFilterMenu( $this->status ) . '&nbsp;' .
			FlaggedRevsXML::getAutoFilterMenu( $this->automatic ) . '&nbsp;' .
			Xml::submitButton( wfMsg( 'go' ) ) .
			'</p></fieldset>' . Xml::closeElement( 'form' )
		);
	}
	
	/*
	* Get actions for IN clause
	* @returns array
	*/
	private function getActions() {
		$actions = array( 'approve' => 1,'approve2' => 1,'approve-a' => 1,'approve-i' => 1,
			'approve-ia' => 1,'approve2-i' => 1,'unapprove' => 1,'unapprove2' => 1 );
		if( $this->level === 0 ) { // sighted revisions
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove2'] = 0;
		} else if( $this->level === 1 ) { // quality revisions
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['unapprove'] = 0;
		}
		if( $this->status === 1 ) { // approved first time
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve2'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		} else if( $this->status === 2 ) { // re-approved
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		} else if( $this->status === 3 ) { // depreciated
			$actions['approve'] = 0;
			$actions['approve-a'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve-ia'] = 0;
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
		}
		if( $this->automatic === 0 ) { // manual review
			$actions['approve-a'] = 0;
			$actions['approve-ia'] = 0;
		} else if( $this->automatic === 1 ) { // auto-reviewed
			$actions['approve'] = 0;
			$actions['approve-i'] = 0;
			$actions['approve2'] = 0;
			$actions['approve2-i'] = 0;
			$actions['unapprove'] = 0;
			$actions['unapprove2'] = 0;
		}
		$showActions = array();
		foreach( $actions as $action => $show ) {
			if( $show )
				$showActions[] = $action;
		}
		return $showActions;
	}
}
