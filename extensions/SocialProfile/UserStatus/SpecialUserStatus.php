<?php

class SpecialUserStatus extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'UserStatus', 'delete-status-update' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the special page or null
	 */
	public function execute( $params ) {
		global $wgOut, $wgScriptPath, $wgUser;

		// Make sure that the user is allowed to access this special page
		if( !$wgUser->isAllowed( 'delete-status-update' ) ) {
			$wgOut->permissionRequired( 'delete-status-update' );
			return false;
		}

		// Blocked through Special:Block? No access for you either!
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Is the database locked or not?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Set the page title and robot policies
		$this->setHeaders();

		// Add required JS file
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SocialProfile/UserStatus/UserStatus.js' );

		// Build and output the form for deleting users' status updates
		$output = wfMsg( 'userstatus-enter-username' ) .
			' <input type="text" id="us-name-input" /> ';
		$output .= '<input type="button" value="' .
			wfMsg( 'userstatus-find' ) . '" onclick="javascript:UserStatus.specialGetHistory();" />';
		$output .= '<div id="us-special"> </div>';
		$wgOut->addHTML( $output );
	}

}
