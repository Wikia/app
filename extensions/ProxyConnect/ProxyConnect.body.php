<?php

class ProxyConnect extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ProxyConnect' );
	}

	/**
	 * Show the new special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut;
		$wgOut->disable();
		header( 'Content-type: text/plain;' );
		if ( $wgUser->getID() == 0 ) {
			return;
		}
		$result = '';
		$result .= "UniqueID={$wgUser->getID()}\n";
		$result .= "Name={$wgUser->getName()}\n";
		$result .= "Email={$wgUser->getEmail()}\n";
		wfDebug( "ProxyConnect: returning $result\n" );
		echo $result;
		return;
	}
}
