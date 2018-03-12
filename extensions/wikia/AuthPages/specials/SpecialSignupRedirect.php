<?php

class SpecialSignupRedirect extends RedirectSpecialPage {
	function __construct( string $name = 'Signup' ) {
		parent::__construct( $name );
	}

	public function getRedirect( $par = '' ) {
		$type = $this->getRequest()->getVal( 'type' );

		if ( $type === 'signup' ) {
			return SpecialPage::getTitleFor( 'UserSignup' );
		}

		return SpecialPage::getTitleFor( 'UserLogin' );
	}
}
