<?php

/**
 * A subpage for tallying votes and producing results
 */
class SecurePoll_TallyPage extends SecurePoll_Page {
	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut, $wgUser, $wgRequest;

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
		$wgOut->setPageTitle( wfMsg( 'securepoll-tally-title', $this->election->getMessage( 'title' ) ) );
		if ( !$this->election->isAdmin( $wgUser ) ) {
			$wgOut->addWikiMsg( 'securepoll-need-admin' );
			return;
		}

		if ( !$this->election->isFinished() ) {
			$wgOut->addWikiMsg( 'securepoll-tally-not-finished' );
			return;
		}

		$crypt = $this->election->getCrypt();
		if ( $crypt ) {
			if ( !$crypt->canDecrypt() ) {
				$wgOut->addWikiMsg( 'securepoll-tally-no-key' );
				return;
			}
			
			if ( $wgRequest->wasPosted() ) {
				if ( $wgRequest->getVal( 'submit_upload' ) ) {
					$this->submitUpload();
				} else {
					$this->submitLocal();
				}
			} else {
				$wgOut->addWikiMsg( 'securepoll-can-decrypt' );
				$this->showLocalForm();
				$this->showUploadForm();
			}
		} else {
			if ( $wgRequest->wasPosted() ) {
				$this->submitLocal();
			} else {
				$this->showLocalForm();
			}
		}
	}

	/**
	 * Show a form which, when submitted, shows a tally for the results in the DB
	 */
	function showLocalForm() {
		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 
				'form',
				array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl() )
			) .
			"\n" .
			Xml::fieldset(
				wfMsg( 'securepoll-tally-local-legend' ),
				'<div>' .
				Xml::submitButton( 
					wfMsg( 'securepoll-tally-local-submit' ),
					array( 'name' => 'submit_local' ) 
				) .
				'</div>'
			) .
			"</form>\n"
		);
	}

	/**
	 * Shows a form for upload of a record produced by the dump subpage.
	 */
	function showUploadForm() {
		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 
				'form',
				array( 
					'method' => 'post', 
					'action' => $this->getTitle()->getLocalUrl(),
					'enctype' => 'multipart/form-data'
				)
			) .
			"\n" .
			Xml::fieldset(
				wfMsg( 'securepoll-tally-upload-legend' ),
				'<div>' .
				Xml::element( 'input', array(
					'type' => 'file',
					'name' => 'tally_file',
					'size' => 40,
				) ) .
				"</div>\n<div>" . 
				Xml::submitButton( 
					wfMsg( 'securepoll-tally-upload-submit' ),
					array( 'name' => 'submit_upload' )
				) . 
				"</div>\n"
			) . 
			"</form>\n"
		);
	}

	/**
	 * Show a tally of the local DB
	 */
	function submitLocal() {
		global $wgOut;
		$status = $this->election->tally();
		if ( !$status->isOK() ) {
			$wgOut->addWikiText( $status->getWikiText() );
			return;
		}
		$tallier = $status->value;
		$wgOut->addHTML( $tallier->getHtmlResult() );
	}

	/**
	 * Show a tally of the results in the uploaded file
	 */
	function submitUpload() {
		global $wgOut;
		if ( !isset( $_FILES['tally_file'] )
			|| !is_uploaded_file( $_FILES['tally_file']['tmp_name'] ) 
			|| !$_FILES['tally_file']['size'] )
		{
			$wgOut->addWikiMsg( 'securepoll-no-upload' );
			return;
		}
		$context = SecurePoll_Context::newFromXmlFile( $_FILES['tally_file']['tmp_name'] );
		if ( !$context ) {
			$wgOut->addWikiMsg( 'securepoll-dump-corrupt' );
			return;
		}
		$electionIds = $context->getStore()->getAllElectionIds();
		$election = $context->getElection( reset( $electionIds ) );

		$status = $election->tally();
		if ( !$status->isOK() ) {
			$wgOut->addWikiText( $status->getWikiText( 'securepoll-tally-upload-error' ) );
			return;
		}
		$tallier = $status->value;
		$wgOut->addHTML( $tallier->getHtmlResult() );
	}

	function getTitle() {
		return $this->parent->getTitle( 'tally/' . $this->election->getId() );
	}
}
