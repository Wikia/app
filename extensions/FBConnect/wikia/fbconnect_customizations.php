<?php
/**
 * @author Sean Colombo
 *
 * This file contains wikia-specific customizations to the FBConnect extension that are
 * not core to the extension itself.
 *
 * Among other things, this includes the form for finishing registration after an anonymous
 * user connects through facebook.
 *
 * This script depends on /extensions/wikia/AjaxFunctions.php for wfValidateUsername().
 *
 * NOTE: This script doesn't take into account $fbConnectOnly since it works off of the assumption
 * that Wikia has its own accounts and currently has no reason to expect that it won't in the
 * forseeable future.
 */

/**
 * Extra initialization for Facebook Connect which is Wikia-specific.
 */
function wikia_fbconnect_init(){
	// This is used on the login box, so initialize it all the time.
	wfLoadExtensionMessages('FBConnect');
} // end wikia_fbconnect_init()

/**
 * Overrides the default chooseNameForm for FBConnect extension so that
 * we can use a custom one for Wikia.
 */
function wikia_fbconnect_chooseNameForm(&$specialConnect, &$messageKey){
	global $wgOut, $wgUser, $wgRequest;
	wfProfileIn(__METHOD__);

	if (!$wgUser->isAllowed( 'createaccount' )) {
		// TODO: Some sort of error/warning message.  Can probably re-use an existing message.
	} else {
		wfLoadExtensionMessages('FBConnect');

		// If it is not the default message, highlight it because it probably indicates an error.
		$style = ($messageKey=="fbconnect-chooseinstructions"?"":" style='background-color:#faa;padding:5px'");

		$wgOut->addHTML("<strong$style>" . wfMsg($messageKey) . "</strong>");

		$form = new ChooseNameForm($wgRequest,'signup');
		$form->mainLoginForm( $specialConnect, '' );
		$tmpl = $form->getAjaxTemplate();

		ob_start();
		$tmpl->execute();
		$html = ob_get_clean();
		$wgOut->addHTML( $html );
	}
	wfProfileOut(__METHOD__);
	return false; // prevent default form from showing.
} // end wikia_fbconnect_chooseNameForm()

/**
 * Validate that the CUSTOM input of the ChooseName form is acceptable
 * and display an error page if it is not.
 */
function wikia_fbconnect_validateChooseNameForm( &$specialConnect ){
	wfProfileIn(__METHOD__);

	$allowDefault = true;
	global $wgRequest;
	$email = $wgRequest->getVal('wpEmail');
	if( ($email == "") || (!User::isValidEmailAddr( $email )) ) {
		$specialConnect->sendPage('chooseNameForm', 'fbconnect-invalid-email');
		$allowDefault = false;
	}

	wfProfileOut(__METHOD__);
	return $allowDefault;
} // end wikia_fbconnect_validateChooseNameForm()

/**
 * Custom processing that is done after the rest of the chooseName form completes
 * successfully.  We assume that all input is valid since wikia_fbconnect_validateChooseNameForm
 * already had a chance to verify custom input and SpecialConnect::createUser got a chance
 * to verify the default requirements.
 *
 * In this specific case, we just save the email address and the marketing-opt-in preference.
 */
function wikia_fbconnect_postProcessForm( &$specialConnect ){
	wfProfileIn(__METHOD__);

	global $wgRequest, $wgUser;

	// Save the email address.
	$email = $wgRequest->getVal('wpEmail');
	$wgUser->setEmail( $email );

	// Save the marketing checkbox preference.
	$marketingOptIn = $wgRequest->getCheck('wpMarketingOptIn');
	$wgUser->setOption( 'marketingallowed', $marketingOptIn ? 1 : 0 );
	
	$wgUser->sendConfirmationMail();
	$wgUser->saveSettings();

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_postProcessForm()

/**
 * Called when a user was just created or attached (safe to call at any time later as well).  This
 * function will check to see if the user has a Wikia Avatar and if they don't, it will attempt to
 * use this Facebook-connected user's profile picture as their Wikia Avatar.
 *
 * FIXME: Is there a way to make this fail gracefully if we ever un-include the Masthead extension?
 */
function wikia_fbconnect_considerProfilePic( &$specialConnect ){
	wfProfileIn(__METHOD__);
	global $wgUser;

	// We need the facebook id to have any chance of getting a profile pic.
	$fb_ids = FBConnectDB::getFacebookIDs($wgUser);
	if(count($fb_ids) > 0){
		$fb_id = array_shift($fb_ids);

		// If the useralready has a masthead avatar, don't overwrite it, this function shouldn't alter anything in that case.
		$masthead = Masthead::newFromUser($wgUser);
		if( ! $masthead->hasAvatar() ){
			// Attempt to store the facebook profile pic as the Wikia avatar.
			$picUrl = FBConnectProfilePic::getImgUrlById($fb_id);
			if($picUrl != ""){
				$errorNo = $masthead->uploadByUrl($picUrl);

				// Apply this as the user's new avatar if the image-pull went okay.
				if($errorNo == UPLOAD_ERR_OK){
					$sUrl = $masthead->getLocalPath();
					if ( !empty($sUrl) ) {
						/* set user option */
						$wgUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
						$wgUser->saveSettings();
					}
				}
			}
		}
	}

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_considerProfilePic()

class ChooseNameForm extends LoginForm {
	var $mActionType;
	var $ajaxTemplate;
	var $msg;
	var $msgtype;
	
	public function getAjaxTemplate(){
		return $this->ajaxTemplate;
	}
	
	static public function userNameOK( $uName ){
		return ('OK' == wfValidateUserName($uName));
	}

	function mainLoginForm( &$specialConnect, $msg, $msgtype = 'error' ){
		global $wgUser, $wgOut, $wgAllowRealName, $wgEnableEmail;
		global $wgCookiePrefix, $wgLoginLanguageSelector;
		global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration,$wgRequest;

		$this->msg = $msg;
		$this->msgtype = $msgtype;

		$tmpl = new ChooseNameTemplate();
		$tmpl->addInputItem( 'wpMarketingOptIn', 1, 'checkbox', 'tog-marketingallowed');
		
		$returnto = "";
		if ( !empty( $this->mReturnTo ) ) {
			$returnto = '&returnto=' . wfUrlencode( $this->mReturnTo );
			if ( !empty( $this->mReturnToQuery ) )
				$returnto .= '&returntoquery=' .
					wfUrlencode( $this->mReturnToQuery );
		}

		$tmpl->set( 'actioncreate', $specialConnect->getTitle('ChooseName')->getLocalUrl($returnto) );
		$tmpl->set( 'link', '' );

		$tmpl->set( 'header', '' );
		//$tmpl->set( 'name', $this->mName ); // intelligently defaulted below
		$tmpl->set( 'password', $this->mPassword );
		$tmpl->set( 'retype', $this->mRetype );
		$tmpl->set( 'actiontype', $this->mActionType );
		$tmpl->set( 'realname', $this->mRealName );
		$tmpl->set( 'domain', $this->mDomain );

		$tmpl->set( 'message', $msg );
		$tmpl->set( 'messagetype', $msgtype );
		$tmpl->set( 'createemail', $wgEnableEmail && $wgUser->isLoggedIn() );
		$tmpl->set( 'userealname', $wgAllowRealName );
		$tmpl->set( 'useemail', $wgEnableEmail );
		$tmpl->set( 'emailrequired', $wgEmailConfirmToEdit );
		$tmpl->set( 'canreset', $wgAuth->allowPasswordChange() );
		$tmpl->set( 'canremember', ( $wgCookieExpiration > 0 ) );
		$tmpl->set( 'remember', $wgUser->getOption( 'rememberpassword' ) or $this->mRemember  );

		$tmpl->set( 'birthyear', $this->wpBirthYear );
		$tmpl->set( 'birthmonth', $this->wpBirthMonth );
		$tmpl->set( 'birthday', $this->wpBirthDay );

		# Prepare language selection links as needed
		if( $wgLoginLanguageSelector ) {
			$tmpl->set( 'languages', $this->makeLanguageSelector() );
			if( $this->mLanguage )
			$tmpl->set( 'uselang', $this->mLanguage );
		}


		// Facebook-specific customizations below.
		global $fbConnectOnly;
		// Connect to the Facebook API
		$fb = new FBConnectAPI();
		$fb_user = $fb->user();
		$userinfo = $fb->getUserInfo($fb_user);

		// If no email was set yet, then use the value from facebook (which is quite likely also empty, but probably not always).
		if(!$this->mEmail){
			$this->mEmail = FBConnectUser::getOptionFromInfo('email', $userinfo);
		}
		$tmpl->set( 'email', $this->mEmail );

		// If the langue isn't set already and there is a setting for it from facebook, apply that.
		if( !$this->mLanguage ){
			$this->mLanguage = FBConnectUser::getOptionFromInfo('language', $userinfo);
		}
		if($this->mLanguage){
			$tmpl->set( 'uselang', $this->mLanguage );
		}

		// Make this an intelligent guess at a good username (based off of their nickname, real name, etc.).
		if( !$this->mName ){
			if ( $wgUser->isLoggedIn() ) {
				$this->mName = $wgUser->getName();
			} else {
				$nickname = FBConnectUser::getOptionFromInfo('nickname', $userinfo);
				if(self::userNameOK($nickname)){
					$this->mName = $nickname;
				} else {
					$fullname = FBConnectUser::getOptionFromInfo('fullname', $userinfo);
					if(self::userNameOK($fullname)){
						$this->mName = $fullname;
					} else {
						if(($nickname == "") && isset( $_COOKIE[$wgCookiePrefix.'UserName'] )){
							$nickname = $_COOKIE[$wgCookiePrefix.'UserName'];
						}

						// Their nickname and full name were taken, so generate a username based on the nickname.
						$specialConnect->setUserNamePrefix( $nickname );
						$this->mName = $specialConnect->generateUserName();
					}
				}
			}
		}
		$tmpl->set( 'name', $this->mName );

		/*
		// NOTE: We're not using this at the moment because it seems that there is no need to show these boxes... we'll just default to updating nothing on login (to avoid confusion & to make signup quicker).
		// Create the checkboxes for the user options.
		global $wgCookiePrefix;
		$name = isset($_COOKIE[$wgCookiePrefix . 'UserName']) ?
					trim($_COOKIE[$wgCookiePrefix . 'UserName']) : '';
		// Build an array of attributes to update
		$updateOptions = array();
		foreach ($specialConnect->getAvailableUserUpdateOptions() as $option) {
			// Translate the MW parameter into a FB parameter
			$value = FBConnectUser::getOptionFromInfo($option, $userinfo);
			// If no corresponding value was received from Facebook, then continue
			if (!$value) {
				continue;
			}
			// Build the list item for the update option
			$updateOptions[] = "<li><input name=\"wpUpdateUserInfo$option\" type=\"checkbox\" " .
				"value=\"1\" id=\"wpUpdateUserInfo$option\" /><label for=\"wpUpdateUserInfo$option\">" .
				wfMsgHtml("fbconnect-$option") . wfMsgExt('colon-separator', array('escapenoentities')) .
				" <i>$value</i></label></li>";
		}
		// Implode the update options into an unordered list
		$updateChoices = count($updateOptions) > 0 ? "\n" . wfMsgHtml('fbconnect-updateuserinfo') . "\n<ul>\n" . implode("\n", $updateOptions) . "\n</ul>\n" : '';
		$html = "<tr style='display:none'><td>$updateChoices</td></tr>";
		$tmpl->set( 'updateOptions', $html);
		*/
		$tmpl->set( 'updateOptions', '');

		// Give authentication and captcha plugins a chance to modify the form
		// NOTE: We don't do this for fbconnect.
		//$wgAuth->modifyUITemplate( $template );
		//wfRunHooks( 'UserCreateForm', array( &$template ) );

		$this->ajaxTemplate = $tmpl;
	}
}
