<?php

class SpecialWikiaConfirmEmailRedirect extends AbstractAuthPageRedirect {
	public function __construct( string $name = 'WikiaConfirmEmail' ) {
		parent::__construct( $name );
	}

	function execute( $tokenFromPar = '' ) {
		$token = $this->getRequest()->getVal( 'code', $tokenFromPar );

		$this->redirect( "/confirm-email?token=$token" );
	}
}
