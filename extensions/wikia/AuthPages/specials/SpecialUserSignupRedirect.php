<?php

class SpecialUserSignupRedirect extends AbstractAuthPageRedirect {
	public function __construct( string $name = 'UserSignup' ) {
		parent::__construct( $name );
	}

	function execute( $par = '' ) {
		$this->redirect( '/register' );
	}
}
