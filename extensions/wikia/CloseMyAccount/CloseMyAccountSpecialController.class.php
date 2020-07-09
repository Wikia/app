<?php

/**
 * CloseMyAccount special page
 *
 * @author Daniel Grunwell (grunny)
 */
class CloseMyAccountSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'CloseMyAccount' );
	}

	public function index() {
		$this->redirectToUcp();
	}

	public function reactivate() {
		$this->redirectToUcp();
	}

	public function reactivateRequest() {
		$this->redirectToUcp();
	}

	private function redirectToUcp() {
		global $wgCentralWikiId;
		$title = GlobalTitle::newFromText( 'CloseMyAccount', NS_SPECIAL, $wgCentralWikiId );
		$this->getOutput()->redirect( $title->getFullURL() );
	}
}
