<?php

/**
 * Redirects users from the old MW email confirm page to the new Mercury email confirmation flow
 */
class SpecialWikiaConfirmEmailRedirect extends AbstractAuthPageRedirect {
	public function __construct( string $name = 'WikiaConfirmEmail' ) {
		parent::__construct( $name );
	}

	function execute( $tokenFromPar = '' ) {
		$token = $this->getRequest()->getVal( 'code', $tokenFromPar );

		$this->redirect( "/confirm-email?token=$token" );
	}
}
