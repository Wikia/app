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

function GetComboAjaxLogin() {
	global $wgRequest;

	if ($wgRequest->getCheck( 'wpCreateaccount' )) {
		return "error";
	}

	$form =new AjaxLoginForm($wgRequest,'signup');
	$form->execute();

	$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	$response = new AjaxResponse();

	$tmpl->set("registerAjax",$form->ajaxRender());
	$response->addText( $tmpl->execute('ComboAjaxLogin') );
	$tmpl->execute("register",$form->ajaxRender() );

	$response->setCacheDuration( 3600 * 24 * 365);
	header("X-Pass-Cache-Control: s-maxage=315360000, max-age=315360000");
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
	//	$response->setCacheDuration( 3600 * 24 * 365);
	return $response;
}

function comboAjaxLoginVars($vars) {
	global $wgUser;
	$vars['wgComboAjaxLogin'] = true;
	$vars['wgIsLogin'] = $wgUser->isLoggedIn();
	return true;
};

$wgAjaxExportList[] = 'createUserLogin';
function createUserLogin()
{
	global $wgRequest;
	$response = new AjaxResponse();
	if (!($wgRequest->getCheck("wpCreateaccount") && ($wgRequest->wasPosted()))) {
		//TODO: dopisać nazwe errora
		$response->addText(json_encode(
			array(	'msg' => '',
					'type' => 'error')));
		return $response;
	}

	$form =new AjaxLoginForm($wgRequest,'signup');		
	if ( !$form->checkDate() ) {
		$response->addText(json_encode(
			array(	'msg' => '',
					'type' => 'redirectQuery')));
		return $response;
	}
	$form->execute();

	if( $form->msgtype == "error" ) {
		$captchaObj = new FancyCaptcha();
		$captcha = $captchaObj->pickImage();
		$captchaIndex = $captchaObj->storeCaptcha( $captcha );
		$titleObj = SpecialPage::getTitleFor( 'Captcha/image' );
		$captchaUrl = $titleObj->getLocalUrl( 'wpCaptchaId=' . urlencode( $captchaIndex ) );
	}

	$response->addText(json_encode(
		array(	'msg' => $form->msg ,
				'type' => $form->msgtype,
				'captchaUrl' =>	$captchaUrl,
				'captcha' => $captchaIndex)));

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

		if ( $this->mType == 'signup' ) {
			// Block signup here if in readonly. Keeps user from
			// going through the process (filling out data, etc)
			// and being informed later.
			if ( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			} elseif ( $wgUser->isBlockedFromCreateAccount() ) {
				$this->userBlockedMessage();
				return;
			} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
				$wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
				return;
			}
		}

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

		$template->set( 'actioncreate', $titleObj->getLocalUrl( $q ) );
		$template->set( 'actionlogin', $titleObj->getLocalUrl( $q2 ) );

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