<?php

/**
 * Special:SecurePoll subpage for exporting encrypted election records.
 */
class SecurePoll_DumpPage extends SecurePoll_Page {
	var $headersSent;

	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut, $wgUser;

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
		$this->initLanguage( $wgUser, $this->election );

		$wgOut->setPageTitle( wfMsg( 'securepoll-dump-title', 
			$this->election->getMessage( 'title' ) ) );

		if ( !$this->election->getCrypt() ) {
			$wgOut->addWikiMsg( 'securepoll-dump-no-crypt' );
			return;
		}
		
		if ( !$this->election->isFinished() ) {
			global $wgLang;
			$wgOut->addWikiMsg( 'securepoll-dump-not-finished', 
				$wgLang->date( $this->election->getEndDate() ),
				$wgLang->time( $this->election->getEndDate() ) );
			return;
		}

		$this->headersSent = false;
		$status = $this->election->dumpVotesToCallback( array( $this, 'dumpVote' ) );
		if ( !$status->isOK() && !$this->headersSent ) {
			$wgOut->addWikiText( $status->getWikiText() );
			return;
		}
		if ( !$this->headersSent ) {
			$this->sendHeaders();
		}
		echo "</election>\n</SecurePoll>\n";
	}

	function dumpVote( $election, $row ) {
		if ( !$this->headersSent ) {
			$this->sendHeaders();
		}
		echo "<vote>" . $row->vote_record . "</vote>\n";
	}

	function sendHeaders() {
		global $wgOut;

		$this->headersSent = true;
		$wgOut->disable();
		header( 'Content-Type: application/vnd.mediawiki.securepoll' );
		$electionId = $this->election->getId();
		$filename = urlencode( "$electionId-" . wfTimestampNow() . '.securepoll' );
		header( "Content-Disposition: attachment; filename=$filename" );
		echo "<SecurePoll>\n<election>\n" .
			$this->election->getConfXml();
		$this->context->setLanguages( array( $this->election->getLanguage() ) );
	}
}
