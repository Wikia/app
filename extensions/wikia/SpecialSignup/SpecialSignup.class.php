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
		
		if($wgRequest->wasPosted()) {
			if($form->processLogin()) {

			}			
		}
		
		$form->executeAsPage(false,"");
	}

	static function TrackingOnSuccess (&$out) {
		if( isset( $_SESSION['Signup_AccountLoggedIn'] ) || !empty($_GET['loggedinok']) ) {
			$out->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/login/success\');</script>');
			unset( $_SESSION['Signup_AccountLoggedIn'] );
		}
		return true;
	}
}