<?php
/*
 * Author: Inez Korczynski
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'AjaxLogin',
	'description' => 'Dynamic box which allow users to login and remind password',
	'author' => 'Inez Korczyński'
);

$wgHooks['GetHTMLAfterBody'][] = 'GetAjaxLoginForm';

function GetAjaxLoginForm($skin) {
	global $wgTitle, $wgUser;

	// different approach for Lean Monaco
	global $wgUseMonaco2;
	if (!empty($wgUseMonaco2)) {
		return true;
	}

	if ($wgUser->isAnon() && $wgTitle->getNamespace() != 8 && $wgTitle->getDBkey() != 'Userlogin') {
		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		echo $tmpl->execute('AjaxLogin');
	}
	return true;
}

$wgAjaxExportList[] = 'GetAjaxLogin';
function GetAjaxLogin() {
	
	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	$response = new AjaxResponse();
	
	if ( !LoginForm::getLoginToken() ) {
		LoginForm::setLoginToken();
	}
	$tmpl->set_vars(array(
		"token" => LoginForm::getLoginToken()
	));
	
	$response->addText( $tmpl->execute('AwesomeAjaxLogin') );


	return $response;
}

