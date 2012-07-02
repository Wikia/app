<?php
/**
 * Special Pages for Drafts extension
 *
 * @file
 * @ingroup Extensions
 */

class DraftsPage extends SpecialPage {

	/* Functions */

	/**
	 * Generic constructor
	 */
	public function __construct() {
		// Initialize special page
		parent::__construct( 'Drafts' );
		// Internationalization

	}

	/**
	 * Executes special page rendering and data processing
	 *
	 * @param $sub Mixed: MediaWiki supplied sub-page path
	 */
	public function execute( $sub ) {
		global $wgRequest, $wgOut, $wgUser;
		// Begin output
		$this->setHeaders();
		// Make sure the user is logged in
		if ( !$wgUser->isLoggedIn() ) {
			// If not, let them know they need to
			$wgOut->loginToUse();
			// Continue
			return true;
		}
		// Handle discarding
		$draft = Draft::newFromID( $wgRequest->getIntOrNull( 'discard' ) );
		if ( $draft->exists() ) {
			// Discard draft
			$draft->discard();
			// Redirect to the article editor or view if returnto was set
			$section = $wgRequest->getIntOrNull( 'section' );
			$urlSection = $section !== null ? "&section={$section}" : '';
			switch( $wgRequest->getText( 'returnto' ) ) {
				case 'edit':
					$title = Title::newFromDBKey( $draft->getTitle() );
					$wgOut->redirect(
						wfExpandURL( $title->getEditURL() . $urlSection )
					);
					break;
				case 'view':
					$title = Title::newFromDBKey( $draft->getTitle() );
					$wgOut->redirect(
						wfExpandURL( $title->getFullURL() . $urlSection )
					);
					break;
			}
		}
		// Show list of drafts, or a message that there are none
		if ( Drafts::display() == 0 ) {
			$wgOut->addHTML( wfMsgHTML( 'drafts-view-nonesaved' ) );
		}
	}
}
