<?php
/*
 * Author: Tomasz Odrobny
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ComboAjaxLogin',
	'description' => 'Dynamic box which allow users to login and remind password and register users',
	'author' => 'Tomasz Odrobny'
);

$wgAjaxExportList[] = 'GetComboAjaxLogin';
$wgHooks['MakeGlobalVariablesScript'][] = 'comboAjaxLoginVars';

$wgExtensionMessagesFiles['ComboAjaxLogin'] = dirname(__FILE__) . '/ComboAjaxLogin.i18n.php';

function GetComboAjaxLogin() {
	global $wgRequest;
	
	if ( session_id() == '' ) {
		wfSetupSession();
	}
	
	wfLoadExtensionMessages('ComboAjaxLogin');
	if ($wgRequest->getCheck( 'wpCreateaccount' )) {
		return "error";
	}
    
    $tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
    $response = new AjaxResponse();
        
    if (!wfReadOnly()){
	    $form =new AjaxLoginForm($wgRequest,'signup');
	    $form->execute();
        $tmpl->set("isReadOnly", 0);
	    $tmpl->set("registerAjax", $form->ajaxRender());           
    } else {
        $tmpl->set("isReadOnly", 1);                 
    }
    
    
    if ( !LoginForm::getLoginToken() ) {
		LoginForm::setLoginToken();
	}
	$tmpl->set( "token", LoginForm::getLoginToken() );
    
    $response->addText( $tmpl->execute('ComboAjaxLogin') );
	return $response;
}

$wgAjaxExportList[] = 'GetComboAjaxLogin';

/*
 * marge js from register and ajax login
 */
$wgAjaxExportList[] = 'getRegisterJS';
function getRegisterJS(){
	$response = new AjaxResponse();
	$response->addText( AjaxLoginForm::getRegisterJS());
	$response->addText( file_get_contents(dirname( __FILE__ ) . '/AwesomeAjaxLogin.js') );
	
	header("X-Pass-Cache-Control: s-maxage=315360000, max-age=315360000");	
	$response->setCacheDuration( 3600 * 24 * 365);
	return $response;
}

function comboAjaxLoginVars($vars) {
	global $wgUser,$wgWikiaEnableConfirmEditExt;
	if ($wgWikiaEnableConfirmEditExt){
		wfLoadExtensionMessages('ConfirmEdit');
	}
	
	$vars['wgComboAjaxLogin'] = true;
	$vars['prefs_help_birthmesg'] = wfMsg('prefs-help-birthmesg');
	$vars['prefs_help_birthinfo'] = wfMsg('prefs-help-birthinfo');
	$vars['prefs_help_mailmesg'] = wfMsg('prefs-help-mailmesg');
	$vars['prefs_help_email'] = wfMsg('prefs-help-email');
	$vars['prefs_help_blurmesg'] = wfMsg('prefs-help-blurmesg');
	$vars['prefs_help_blurinfo'] = wfMsgExt( 'captchahelp-text', array( 'parse' ) );
	$vars['wgIsLogin'] = $wgUser->isLoggedIn();
	return true;
};

$wgAjaxExportList[] = 'createUserLogin';
function createUserLogin(){
	global $wgRequest,$wgUser,$wgExternalSharedDB,$wgWikiaEnableConfirmEditExt;
	// Init session if necessary
	if ( session_id() == '' ) {
		wfSetupSession();
	}
	
	$response = new AjaxResponse();
	$response->setCacheDuration( 3600 * 24 * 365);
	if (!($wgRequest->getCheck("wpCreateaccount") && ($wgRequest->wasPosted()))) {
	
		$response->addText(json_encode(
			array(	
					'status' => "ERROR",
					'msg' => '',
					'type' => 'error')));
		return $response;
	}

	$form =new AjaxLoginForm($wgRequest,'signup');	
		
	if ( !$form->checkDate() ) {
		$response->addText(json_encode(
			array(	
					'status' => "ERROR",
					'msg' => '',
					'type' => 'redirectQuery')));
		return $response;
	}

	$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
	$dbw->begin();	 
	$form->execute();
	$dbw->commit();
	
	if( $form->msgtype == "error" ) {
		if( !$wgWikiaEnableConfirmEditExt ){ 
		/*theoretically impossible because the only possible error is captcha error*/
			$response->addText(json_encode(
				array(	
						'status' => "ERROR",		
						'msg' => $form->msg ,
						'type' => $form->msgtype,
						'captchaUrl' =>	'',
						'captcha' => '')));
			return $response;			
		}
		$captchaObj = new FancyCaptcha();
		$captcha = $captchaObj->pickImage();
		$captchaIndex = $captchaObj->storeCaptcha( $captcha );
		$titleObj = SpecialPage::getTitleFor( 'Captcha/image' );
		$captchaUrl = $titleObj->getLocalUrl( 'wpCaptchaId=' . urlencode( $captchaIndex ) );
		$response->addText(json_encode(
			array(	
					'status' => "ERROR",		
					'msg' => $form->msg ,
					'type' => $form->msgtype,
					'captchaUrl' =>	$captchaUrl,
					'captcha' => $captchaIndex)));
		return $response;
	}
	
	$response->addText(json_encode(array('status' => "OK")));
	return $response;
}

		
class AjaxLoginForm extends LoginForm {
	var $mActionType;
	var $ajaxTemplate;
	var $msg;
	var $msgtype;
	
	public static function getRegisterJS(){
		$tpl = new UsercreateTemplate();
		ob_start();
		$tpl->executeRegisterJS();
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
	function ajaxRender(){
		ob_start();
		$this->ajaxTemplate->execute();
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}

	function processLogin() {
		$this->mActionType = 'login';
		return parent::processLogin();
	}
	
	/* check date before execute because of redirect */
	function  checkDate(){
		if ($this->wpBirthYear == -1 || $this->wpBirthMonth == -1 || $this->wpBirthDay == -1) {
			$this->mainLoginForm( wfMsg( 'userlogin-bad-birthday' ) );
			return null;
		}

		$userBirthDay = strtotime($this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay);
		if($userBirthDay > strtotime('-13 years')) {
			return false;		
		} else
		{
			return true;
		}
	}
	
	
	function mainLoginForm( $msg, $msgtype = 'error' ) {
		global $wgUser, $wgOut, $wgAllowRealName, $wgEnableEmail;
		global $wgCookiePrefix, $wgLoginLanguageSelector;
		global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration;

		$titleObj = SpecialPage::getTitleFor( 'Userlogin' );

		$this->msg = $msg;
		$this->msgtype = $msgtype;

		if ( '' == $this->mName ) {
			if ( $wgUser->isLoggedIn() ) {
				$this->mName = $wgUser->getName();
			} else {
				$this->mName = isset( $_COOKIE[$wgCookiePrefix.'UserName'] ) ? $_COOKIE[$wgCookiePrefix.'UserName'] : null;
			}
		}

		$titleObj = SpecialPage::getTitleFor( 'Userlogin' );

		$template = new UserAjaxCreateTemplate();
		
		// ADi: marketing opt-in/out checkbox added
		$template->addInputItem( 'wpMarketingOptIn', 1, 'checkbox', 'tog-marketingallowed');

		$template->set( 'link', '' );

		$template->set( 'header', '' );
		$template->set( 'name', $this->mName );
		$template->set( 'password', $this->mPassword );
		$template->set( 'retype', $this->mRetype );
		$template->set( 'actiontype', $this->mActionType );
		$template->set( 'email', $this->mEmail );
		$template->set( 'realname', $this->mRealName );
		$template->set( 'domain', $this->mDomain );

		$template->set( 'message', $msg );
		$template->set( 'messagetype', $msgtype );
		$template->set( 'createemail', $wgEnableEmail && $wgUser->isLoggedIn() );
		$template->set( 'userealname', $wgAllowRealName );
		$template->set( 'useemail', $wgEnableEmail );
		$template->set( 'emailrequired', $wgEmailConfirmToEdit );
		$template->set( 'canreset', $wgAuth->allowPasswordChange() );
		$template->set( 'canremember', ( $wgCookieExpiration > 0 ) );
		$template->set( 'remember', $wgUser->getOption( 'rememberpassword' ) or $this->mRemember  );

		$template->set( 'birthyear', $this->wpBirthYear );
		$template->set( 'birthmonth', $this->wpBirthMonth );
		$template->set( 'birthday', $this->wpBirthDay );

		# Prepare language selection links as needed
		if( $wgLoginLanguageSelector ) {
			$template->set( 'languages', $this->makeLanguageSelector() );
			if( $this->mLanguage )
			$template->set( 'uselang', $this->mLanguage );
		}
		
		// Give authentication and captcha plugins a chance to modify the form
		$wgAuth->modifyUITemplate( $template );
		wfRunHooks( 'UserCreateForm', array( &$template ) );

		$this->ajaxTemplate = $template;
	}
}
