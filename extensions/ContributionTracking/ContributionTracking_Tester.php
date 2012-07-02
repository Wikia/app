<?php

/**
 * This is a page that exists solely for the purpose of manually testing all 
 * aspects of the ContributionTracking API: Both send (querystring) and receive
 * (jquery processing and reposting). Could also be used for browser-based
 * regression testing of these components.
 * The form is built with all the fields the API will let through the filter.
 * Required are marked with "***".
 * This page is only visible to sysops.
 */
class ContributionTrackingTester extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'ContributionTrackingTester', 'ViewContributionTrackingTester' );
	}

	function execute( $language ) {
		global $wgUser;
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		global $wgRequest, $wgOut, $wgContributionTrackingReturnToURLDefault;

		$wgOut->addModules( 'jquery.contributionTracking' );

		if ( !preg_match( '/^[a-z-]+$/', $language ) ) {
			$language = 'en';
		}
		$this->lang = Language::factory( $language );

		$this->setHeaders();

		$apiObj = new ApiContributionTracking( null, null );
		$formfields = $apiObj->getFinalParams();

		//$wgOut->addWikiText(print_r($formfields, true));
		$wgOut->addHTML( '<form id="landingpage_submit"><table>' );

		foreach ( $formfields as $name => $attribs ) {
			if ( array_key_exists( 8, $attribs ) ) {
				$required = "***";
			} else {
				$required = "";
			}
			$wgOut->addHTML( '<tr><td>' . $required . $name . '</td><td>' );
			if ( $attribs[2] == 'string' ) {
				$wgOut->addHTML( '<input type="text" id="' . $name . '" name="' . $name . '">' );
			}
			if ( $attribs[2] == 'boolean' ) {
				$wgOut->addHTML( '<input type="checkbox" id="' . $name . '" name="' . $name . '">' );
			}

			$wgOut->addHTML( '</td></tr>' );
		}

		$wgOut->addHTML( '<tr><td colspan=2 align=center><button id="ajax_contribution" class="ajax_me">Fire away!</button></td></tr>' );
		$wgOut->addHTML( '</table></form>' );
	}

	function msgWiki( $key ) {
		return wfMsgExt( $key, array( 'parse', 'language' => $this->lang ) );
	}

}
