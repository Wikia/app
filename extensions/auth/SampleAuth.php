<?php

/**
 * Quickie sample auth plugin. Allows you to login only as the user
 * "OnlyUser", with the password "password". The account will be
 * created automatically when you try to log in the first time.
 */

class SampleAuth extends AuthPlugin {
	function userExists( $username ) {
		return ($username == "OnlyUser");
	}
	
	function authenticate( $username, $password ) {
		return $this->userExists( $username ) &&
		       ($password == "password");
	}
	
	function autoCreate() {
		return true;
	}
	
	function strict() {
		return true;
	}
	
	function initUser( &$user ) {
		$user->setEmail( 'onlyuser@example.com' );
		$user->setRealName( 'Sample Auth User' );
	}
}

