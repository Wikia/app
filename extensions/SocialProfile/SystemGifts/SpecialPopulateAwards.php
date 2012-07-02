<?php
/**
 * Special:PopulateAwards -- basically just a special page that calls
 * SystemGifts' update_system_gifts() function and does nothing else
 *
 * @file
 * @ingroup Extensions
 */

class PopulateAwards extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'PopulateAwards'/*class*/, 'awardsmanage' /*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $gift_category Mixed: parameter passed to the page or null
	 */
	public function execute( $gift_category ) {
		global $wgUser, $wgOut, $wgUserLevels;

		// If the user doesn't have the required 'awardsmanage' permission, display an error
		if ( !$wgUser->isAllowed( 'awardsmanage' ) ) {
			$wgOut->permissionRequired( 'awardsmanage' );
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$wgUserLevels = '';

		$g = new SystemGifts();
		$g->update_system_gifts();
	}
}
