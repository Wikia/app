<?php

class Signup extends SpecialPage {
	function __construct() {
		parent::__construct('Signup');
	}

	function execute() {
		global $wgRequest, $wgHooks, $wgOut;
		$this->setHeaders();

		if( session_id() == '' ) {
			wfSetupSession();
		}
		$form = new AjaxLoginForm( $wgRequest );

		$form->executeAsPage();
	}

	static function TrackingOnSuccess (&$out) {
		if( isset( $_SESSION['Signup_AccountLoggedIn'] ) || !empty($_GET['loggedinok']) ) {
			unset( $_SESSION['Signup_AccountLoggedIn'] );
		}
		return true;
	}
}