<?php
/**
 * A special page to redirect the user to a randomly-chosen poll.
 * @file
 * @ingroup Extensions
 */
class RandomPoll extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'RandomPoll' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser;

		$p = new Poll();

		$pollPage = $p->getRandomPollURL( $wgUser->getName() );
		if( $pollPage == 'error' ) {
			$wgOut->setPageTitle( wfMsg( 'poll-no-more-title' ) );
			$wgOut->addWikiMsg( 'poll-no-more-message' );
		} else {
			$pollTitle = Title::newFromText( $pollPage );
			$wgOut->redirect( $pollTitle->getFullURL() );
		}

		return $pollPage;
	}
}