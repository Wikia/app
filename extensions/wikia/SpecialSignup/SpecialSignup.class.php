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
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfSpecialUserloginSetupVars';
		$form = new LoginForm( $wgRequest, 'signup' );
		$form->execute();
	}	
}


