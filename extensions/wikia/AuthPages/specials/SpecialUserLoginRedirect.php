<?php

/**
 * Redirects users from the old MW login and password reset pages to their new Mercury equivalents
 */
class SpecialUserLoginRedirect extends AbstractAuthPageRedirect {

	public function __construct( string $name = 'UserLogin' ) {
		parent::__construct( $name );
	}

	function execute( $par = '' ) {
		$type = $this->getRequest()->getVal( 'type' );

		if ( strcasecmp( $type, 'forgotpassword' ) === 0 ) {
			$this->redirect( '/forgot-password' );
		} elseif ( strcasecmp( $type, 'signup' ) === 0 ) {
			$this->redirect( '/signup' );
		} else {
			$this->redirect( '/signin' );
		}
	}
}
