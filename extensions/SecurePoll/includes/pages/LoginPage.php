<?php

/**
 * A simple SecurePoll subpage which handles guest logins from a remote website, 
 * starts a session, and then redirects to the voting page.
 */
class SecurePoll_LoginPage extends SecurePoll_Page {
	function execute( $params ) {
		global $wgOut;

		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}
		
		$electionId = intval( $params[0] );
		$this->election = $this->context->getElection( $electionId );
		if ( !$this->election ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-election', $electionId );
			return;
		}

		$auth = $this->election->getAuth();
		$status = $auth->newRequestedSession( $this->election );
		if ( !$status->isOK() ) {
			$wgOut->addWikiText( $status->getWikiText() );
			return;
		}
		$votePage = SpecialPage::getTitleFor( 'SecurePoll', 'vote/' . $this->election->getId() );
		$wgOut->redirect( $votePage->getFullUrl() );
	}
}
