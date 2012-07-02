<?php

/**
 * Redirect the submission request of the createpage parser hook to the actual page.
 *
 * @since 0.1
 *
 * @file SpecialCreatePage.php
 * @ingroup CreatePage
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialCreatePage extends UnlistedSpecialPage {
	
	public function __construct() {
		parent::__construct( 'CreatePage' );
	}
	
	public function execute( $subPage ) {
		$req = $this->getRequest();
		
		if ( $req->wasPosted() && $req->getCheck( 'pagename' ) ) {
			$parts = array( $req->getText( 'pagename' ) );
			
			if ( $req->getCheck( 'pagens' ) ) {
				array_unshift( $parts, $req->getText( 'pagens' ) );
			}
			
			$target = Title::newFromText( implode( ':', $parts ) )->getLocalUrl( array(
				'action' => 'edit',
				'redlink' => '1'
			) );
		}
		else {
			$target = Title::newMainPage()->getLocalURL();
		}
		
		$this->getOutput()->redirect( $target );
	}
	
}