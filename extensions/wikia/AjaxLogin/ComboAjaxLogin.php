<?php
/*
 * @author: Tomasz Odrobny, Sean Colombo
 *
 * Extension for a combination of signup/login forms which can be shown
 * as an ajax dialog box or as a page.
 *
 * The templates for the various forms are in the following locations:
 * - Reigstration form: 	/includes/templates/wikia/UserAjaxCreateTemplate (UserAjaxCreate.php)
 * - Login form: 			./templates/AjaxLoginComponent.tmpl.php
 * - Ajax combo of both:	./templates/ComboAjaxLogin.tmpl.php
 * - Page combo of both:	./templates/ComboPage.tmpl.php (for Special:Signup)
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ComboAjaxLogin',
	'description' => 'Dynamic box which allow users to login and remind password and register users',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'comboajaxlogin-desc',
);

$wgAjaxExportList[] = 'GetComboAjaxLogin';
$wgHooks['MakeGlobalVariablesScript'][] = 'comboAjaxLoginVars';
$wgHooks['GetHTMLAfterBody'][] = 'renderHiddenForm';
$wgHooks['BeforePageDisplay'][] = 'ajaxLoginAdditionalScripts';

$wgExtensionMessagesFiles['ComboAjaxLogin'] = dirname(__FILE__) . '/ComboAjaxLogin.i18n.php';


/**
 * Hooked to BeforePageDisplay to allow adding of required JS scripts.
 */
 function ajaxLoginAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;

	// Bind the buttons on the skin to call the ComboAjaxLogin.  This needs to be on every page when this extension is enabled.
	// Moved to StaticChute.
	//	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/AjaxLogin/AjaxLoginBindings.js?$wgStyleVersion'></script>\n");

	return true;
 } // end ajaxLoginAdditionalScripts()

/**
 * Adds a hidden form to the page so user agents may prefill with client-stored information. The pre-filled information is later copied to the Ajax Login modal window.
*/
function renderHiddenForm($skin, &$html) {
	global $wgUser;
	$checked = ($wgUser->getOption('rememberpassword')) ? ' checked="checked" ' : '';
	if ($wgUser->isAnon()) {
		$html .= '<form action="" method="post" name="userajaxloginform" id="userajaxloginformhide" style="display: none">
			<input type="text" name="wpName" id="wpName1Ajax" tabindex="101" size="20" />
			<input type="password" name="wpPassword" id="wpPassword1Ajax" tabindex="102" size="20" />
			<input type="checkbox" name="wpRemember" id="wpRemember1Ajax" tabindex="104" value="1"'. $checked .' />
		</form>'."\n";
	}
	return true;
}

/**
 * Returns an AjaxResponse containing the combo ajax login/register code.
 */
function GetComboAjaxLogin() {
	wfLoadExtensionMessages('ComboAjaxLogin');
	$response = new AjaxResponse();
	$tmpl = AjaxLoginForm::getTemplateForCombinedForms();
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
	$response->addText( AjaxLoginForm::getRegisterJS() );
	$response->addText( file_get_contents(dirname( __FILE__ ) . '/AjaxLogin.js')."\n\n" );

	$vars = array(
		'prefs_help_birthmesg' => wfMsg('prefs-help-birthmesg'),
		'prefs_help_birthinfo' => wfMsg('prefs-help-birthinfo'),
		'prefs_help_mailmesg' => wfMsg('prefs-help-mailmesg'),
		'prefs_help_email' => wfMsg('prefs-help-email'),
		'prefs_help_blurmesg' => wfMsg('prefs-help-blurmesg'),
		'prefs_help_blurinfo' => wfMsgExt( 'captchahelp-text', array( 'parse' ) )

	);

	foreach ($vars as $key => $value) {
		$response->addText( "var ".$key." = ".Xml::encodeJsVar($value).";\n" );
	}

	header("X-Pass-Cache-Control: s-maxage=315360000, max-age=315360000");
	$response->setCacheDuration( 3600 * 24 * 365);
	return $response;
}

function comboAjaxLoginVars($vars) {
	global $wgUser,$wgWikiaEnableConfirmEditExt, $wgRequest, $wgEnableAPI, $wgHideAPI;
	if ($wgWikiaEnableConfirmEditExt){
		wfLoadExtensionMessages('ConfirmEdit');
	}

	$vars['wgReturnTo'] = $wgRequest->getVal('returnto', '');
	$vars['wgReturnToQuery'] = $wgRequest->getVal('returntoquery', '');

	$titleObj = Title::newFromText( $vars['wgReturnTo'] );

	if (  ( !$titleObj instanceof Title ) || ( $titleObj->isSpecial("Userlogout") ) || ( $titleObj->isSpecial("Signup") )   ) {
		$titleObj = Title::newMainPage();
		$vars['wgReturnTo'] = $titleObj->getText( );
	}

	if ( (empty($wgEnableAPI)) || (!$wgUser->isAllowed('read')) || (!empty($wgHideAPI)) ) {
		$vars['wgEnableLoginAPI'] = false;
	} else {
		$vars['wgEnableLoginAPI'] = true;
	}

	$query = $wgRequest->getValues();
	if (isset($query['title'])) {
		unset($query['title']);
	}

	$vars['wgPageQuery'] = wfUrlencode( wfArrayToCGI( $query ) );

	$vars['wgComboAjaxLogin'] = true;
	$vars['wgIsLogin'] = $wgUser->isLoggedIn();

	return true;
};

$wgAjaxExportList[] = 'createUserLogin';
function createUserLogin(){
	global $wgRequest,$wgUser,$wgExternalSharedDB,$wgWikiaEnableConfirmEditExt, $wgEnableCOPPA, $wgDefaultSkin;
	// Init session if necessary
	if ( session_id() == '' ) {
		wfSetupSession();
	}

	$response = new AjaxResponse();
	$response->setCacheDuration( 3600 * 24 * 365);

	if (!(($wgRequest->getCheck("wpCreateaccountMail") || $wgRequest->getCheck("wpCreateaccount") )&& ($wgRequest->wasPosted()))) {
		$response->addText(json_encode(
			array(
					'status' => "ERROR",
					'msg' => wfMsgExt('comboajaxlogin-post-not-understood', array('parseinline')),
					'type' => 'error')));
		return $response;
	}

	$form = new AjaxLoginForm($wgRequest,'signup');

	if ( $wgEnableCOPPA && !$form->checkDate() ) {
		// If the users is too young to legally register.
		$response->addText(json_encode(
			array(
					'status' => "ERROR",
					'msg' => wfMsg( 'userlogin-unable-info' ),
					'type' => 'error')));
		return $response;
	}

	$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
	$dbl = wfGetDB( DB_MASTER );

	$dbw->begin();
	$dbl->begin();

	$form->execute();

	$dbw->commit();
	$dbl->commit();

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

	# temporary.  remove after oasis public beta
	if(isset($wgDefaultSkin) && $wgDefaultSkin == 'oasis') {
		$wgUser->setOption("skin", "oasis");
		$wgUser->saveSettings();
	}
	# end temp

	$response->addText(json_encode(array('status' => "OK")));
	return $response;
}


class AjaxLoginForm extends LoginForm {
	var $mActionType;
	var $ajaxTemplate;
	var $msg;
	var $msgtype;
	var $lastmsg = "";
	var $authenticateStatus = null;
	var $successfulCreation = false;
	function LoginForm( &$request, $par = '' ) {
		parent::LoginForm( $request, $par);

		if($request->getText( 'wpName2Ajax', '' ) != '') {
			$this->mName =	$request->getText( 'wpName2Ajax', '' );
		}

		if($request->getText( 'wpPassword2Ajax', '' ) != '') {
			$this->mPassword = $request->getText( 'wpPassword2Ajax' );
		}

		if($request->getText( 'wpRemember2Ajax', '' ) != '') {
			$this->mRemember = $request->getCheck( 'wpRemember2Ajax' );
		}

		$this->mReturnTo = $request->getVal( 'returnto' );
	}


	public function getAjaxTemplate(){
		return $this->ajaxTemplate;
	}

	/**
	 * Generates a template with the login form and registration form already filled into
	 * it and other settings populated as well.  This template can then be executed with
	 * different EasyTemplates to give different results such as one view for ajax dialogs
	 * and one view for standalone pages (such as Special:Signup).
	 */
	static public function getTemplateForCombinedForms($static = false, $lastmsg = "", &$ajaxLoginForm = ""){
		global $wgRequest;

		// Setup the data for the templates, similar to GetComboAjaxLogin.
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		wfLoadExtensionMessages('ComboAjaxLogin');
		// TODO: Invstigate why this was here.
		//if ($wgRequest->getCheck( 'wpCreateaccount' )) {
		//	return "error";
		//}

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$response = new AjaxResponse();

		if (!wfReadOnly()){
			if(empty($ajaxLoginForm)){
				$ajaxLoginForm = new AjaxLoginForm($wgRequest,'signup');
			}
			$ajaxLoginForm->execute();
			$type = $wgRequest->getVal('type', '');

			if (!empty($ajaxLoginForm->ajaxTemplate)) {
				$lastmsg = $ajaxLoginForm->ajaxTemplate->data['message'];
				$tmpl->set('message', $ajaxLoginForm->ajaxTemplate->data['message']);
				$tmpl->set('messagetype', $ajaxLoginForm->ajaxTemplate->data['messagetype']);
			}
			$tmpl->set("registerAjax", $ajaxLoginForm->ajaxRender());
		}

		$isReadOnly =  wfReadOnly() ? 1:0;
		$tmpl->set("isReadOnly", $isReadOnly);

		if ( !LoginForm::getLoginToken() ) {
			LoginForm::setLoginToken();
		}
		$tmpl->set( "loginToken", LoginForm::getLoginToken() );

		if ( !LoginForm::getCreateaccountToken() ) {
			LoginForm::setCreateaccountToken();
		}
		$tmpl->set( "createToken", LoginForm::getCreateaccountToken() );

		// Use the existing settings to generate the login portion of the form, which will then
		// be fed back into the bigger template in this case (it is not always fed into ComboAjaxLogin template).

		$returnto = $wgRequest->getVal( 'returnto', '');

		if( !($returnto == '') ){
			$returnto = "&returnto=".$returnto;
		}

		$returntoquery = $wgRequest->getVal( 'returntoquery', '');

		if( !($returntoquery == '') ){
			$returntoquery = "&returntoquery=" . wfUrlencode( $returntoquery );
		}

		$loginaction = Skin::makeSpecialUrl( 'Signup', "type=login&action=submitlogin".$returnto.$returntoquery );
		$signupaction = Skin::makeSpecialUrl( 'Signup', "type=signup".$returnto.$returntoquery );

		$tmpl->set("loginaction", $loginaction);
		$tmpl->set("signupaction", $signupaction);
		$tmpl->set("loginerror", $lastmsg);
		$tmpl->set("actiontype", $type);
		$tmpl->set("showRegister", false );
		$tmpl->set("showLogin", false );

		if( $static ) {
			if( strtolower( $type ) == "login" ) {
				$tmpl->set("showLogin", true );
			} else {
				if( !$isReadOnly ) {
					$tmpl->set("showRegister", true );
				}
			}
		}

		$tmpl->set("ajaxLoginComponent", $tmpl->execute('AjaxLoginComponent'));

		return $tmpl;
	}

	/**
	 * Used to create the body of Special:Signup in a way that reuses the same form code as the
	 * modal dialog versions of the same login/signup functionality.
	 */
	public function executeAsPage(){
		global $wgOut ;

		$wgOut->setPageTitle( wfMsg( 'userlogin' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->disallowUserJs();  // just in case...

		// Output the HTML which combines the two forms (which are already in the template) in a way that looks right for a standalone page.
		wfLoadExtensionMessages('ComboAjaxLogin');

		$tmpl = self::getTemplateForCombinedForms( true, $this->lastmsg, $this );
		if( $this->authenticateStatus == self::RESET_PASS ) {
			return ;
		}
		$wgOut->addHTML( $tmpl->execute( 'ComboAjaxLogin' ) );
		$wgOut->addHTML( $tmpl->execute( 'ComboPageFooter' ) );
	}

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
		if(isset($this->ajaxTemplate)){
			$this->ajaxTemplate->execute();
		}
		$out = ob_get_clean();
		return $out;
	}

	function processLogin() {
		$this->mActionType = 'login';
		return  parent::processLogin();
	}

	function authenticateUserData() {
		$this->authenticateStatus = parent::authenticateUserData();
		return $this->authenticateStatus;
	}

	/* check date before execute because of redirect */
	function  checkDate(){
		if ($this->wpBirthYear == -1 || $this->wpBirthMonth == -1 || $this->wpBirthDay == -1) {
			$this->mainLoginForm( wfMsg( 'userlogin-bad-birthday' ) );
			return null;
		}

		$userBirthDay = strtotime($this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay);
		if($userBirthDay > strtotime('-13 years')) {
			$this->mainLoginForm( wfMsg( 'userlogin-unable-info' ) );
			return false;
		} else {
			return true;
		}
	}


	function mainLoginForm( $msg, $msgtype = 'error' ) {
		global $wgUser, $wgOut, $wgAllowRealName, $wgEnableEmail;
		global $wgCookiePrefix, $wgLoginLanguageSelector;
		global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration, $wgEnableCOPPA;

		$titleObj = SpecialPage::getTitleFor( 'Userlogin' );

		$this->saveMessage($msg);
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

		$titleObj = SpecialPage::getTitleFor( 'Signup' );
		$q = 'action=submitlogin&type=signup';
		$q2 = 'action=submitlogin&type=login';
		$template->set( 'actioncreate', $titleObj->getLocalUrl( $q ) );
		$template->set( 'actionlogin', $titleObj->getLocalUrl( $q2 ) );

		$template->set( 'coppa', $wgEnableCOPPA );

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

		if ( !self::getLoginToken() ) {
			self::setLoginToken();
		}
		$template->set( 'loginToken', self::getLoginToken() );

		if ( !self::getCreateaccountToken() ) {
			self::setCreateaccountToken();
		}
		$template->set( 'createToken', self::getCreateaccountToken() );

		// Give authentication and captcha plugins a chance to modify the form
		$wgAuth->modifyUITemplate( $template );

		wfRunHooks( 'UserCreateForm', array( &$template ) );

		$this->ajaxTemplate = $template;
	}

	function saveMessage($msg) {
		$this->lastmsg = $msg;
	}
}
