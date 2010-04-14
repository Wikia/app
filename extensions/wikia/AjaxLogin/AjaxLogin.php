<?php
/**
 * @author: Inez Korczynski
 *
 * Extension to allow users to log in using an ajax'ed popup box rather than being redirected to another page.
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'AjaxLogin',
	'description' => 'Dynamic box which allow users to login and remind password',
	'author' => 'Inez Korczyński'
);

$wgAjaxExportList[] = 'GetAjaxLogin';
function GetAjaxLogin() {
	
	if ( session_id() == '' ) {
		wfSetupSession();
	}
			
	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	$response = new AjaxResponse();
	
	if ( !LoginForm::getLoginToken() ) {
		LoginForm::setLoginToken();
	}
	$tmpl->set_vars(array(
		"token" => LoginForm::getLoginToken()
	));
	
	$response->addText( $tmpl->execute('AjaxLogin') );


	return $response;
}
