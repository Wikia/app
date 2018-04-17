<?php

/**
 * Redirects users from old MW signup page to new Mercury registration flow
 */
class SpecialUserSignupRedirect extends AbstractAuthPageRedirect {
	public function __construct( string $name = 'UserSignup' ) {
		parent::__construct( $name );
	}

	function execute( $par = '' ) {
		$this->redirect( '/register' );
	}
}
