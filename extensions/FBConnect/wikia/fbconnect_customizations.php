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
	wfLoadExtensionMessages( 'FBConnect_wikia' );
} // end wikia_fbconnect_init()

 /**
  * Adds a user-to-facebookId mapping.  This is needed because wgSharedDB is not necessarily
  * the master (even though it's writable).  We have to use wgWikiaCentralAuth instead.
  */
function wikia_fbconnect_addFacebookID($user, $fbid){
	global $wgSharedPrefix;
	wfProfileIn(__METHOD__);

	$dbw = WikiaCentralAuthUser::getCentralDB();
	$dbw->insert(
		"`{$wgSharedPrefix}user_fbconnect`", // grave accents to prevent re-writing of table name
		array(
			'user_id' => $user->getId(),
			'user_fbid' => $fbid
		),
		__METHOD__
	);

	wfProfileOut(__METHOD__);
	return false; // prevent the default saving of the mapping.
} // end wikia_fbconnect_addFacebookID

/**
 * When a new account is created, make sure the Facebook Connect mapping is added to the local db.
 */
function wikia_fbconnect_onAddNewAccount( User $oUser, $addByEmail = false ) {
	wfProfileIn(__METHOD__);

	// Copy over Facebook Connect info if it exists.
	$fb_id = FBConnectDB::getFacebookIDsFromDB($oUser, WikiaCentralAuthUser::getCentralDB());
	if (count($fb_id) > 0){
		foreach($fb_id as $currFbId){
			$localDbw = WikiaCentralAuthUser::getLocalDB();
			global $wgSharedPrefix;
			$localDbw->insert(
				"{$wgSharedPrefix}user_fbconnect", // do not use grave-accents, DB.php has to prepend this with the appropriate wikicities db
				array(
					'user_id' => $oUser->getId(),
					'user_fbid' => $currFbId
				),
				__METHOD__,
				array("IGNORE")
			);
		}
	}

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_onAddNewAccount

/**
 * When the user has been auto-created locally from the global session,
 * copy over their facebook data too.
 */
function wikia_fbconnect_onAuthPluginAutoCreate( $oUser ){
	wfProfileIn(__METHOD__);

	// Copy over Facebook Connect info if it exists.
	$fb_id = FBConnectDB::getFacebookIDsFromDB($oUser, WikiaCentralAuthUser::getCentralDB());
	if (count($fb_id) > 0){
		foreach($fb_id as $currFbId){
			$localDbw = WikiaCentralAuthUser::getLocalDB();
			global $wgSharedPrefix;
			$localDbw->insert(
				"{$wgSharedPrefix}user_fbconnect", // do not use grave-accents, DB.php has to prepend this with the appropriate wikicities db
				array(
					'user_id' => $oUser->getId(),
					'user_fbid' => $currFbId
				),
				__METHOD__,
				array("IGNORE")
			);
		}
	}

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_onAuthPluginAutoCreate

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

		// TODO: If they're already logged in, just connect them.
		if($wgUser->isLoggedIn()){

			// TODO: Perform the connection at the beginning since users might think they are done since these are just options that they can change at any time.

			// TODO: Show them a form with the user-preferences checkboxes.
		}

		wfLoadExtensionMessages( 'FBConnect_wikia' );

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
	if(($email == "") || (0 == preg_match("/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}\$/mi", $email))) {
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

	$wgUser->saveSettings();

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_postProcessForm()




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
		global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration;

		$this->msg = $msg;
		$this->msgtype = $msgtype;

		$tmpl = new ChooseNameTemplate();
		$tmpl->addInputItem( 'wpMarketingOptIn', 1, 'checkbox', 'tog-marketingallowed');

		$tmpl->set( 'actioncreate', $specialConnect->getTitle('ChooseName')->getLocalUrl() );
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
		$updateChoices = count($updateOptions) > 0 ? "<br />\n" . wfMsgHtml('fbconnect-updateuserinfo') . "\n<ul>\n" . implode("\n", $updateOptions) . "\n</ul>\n" : '';
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



class ChooseNameTemplate extends QuickTemplate {

	function addInputItem( $name, $value, $type, $msg ) {
		$this->data['extraInput'][] = array(
			'name' => $name,
			'value' => $value,
			'type' => $type,
			'msg' => $msg,
		);
	}

	function execute(){
		global $wgOut, $wgStylePath, $wgStyleVersion, $wgBlankImgUrl;

		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'. $wgStylePath . '/wikia/common/NewUserRegister.css?' . $wgStyleVersion . "\" />\n");

		if (!array_key_exists('message', $this->data)) {
			$this->data['message'] = "";
		}
		if (!array_key_exists('ajax', $this->data)) {
			$this->data['ajax'] = "";
		}
		if( $this->data['message'] && !$this->data['ajax'] ) {
?>
	<div class="<?php $this->text('messagetype') ?>box">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?></h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php	} ?>
<br/>
<div id="userloginErrorBox">
	<table>
	<tr>
		<td style="vertical-align:top;">
			<span style="position: relative; top: -1px;"><img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
		</td>
	<td>
		<div id="userloginInnerErrorBox"></div>
	</td>
	</table>
</div>
<table id="userloginSpecial" style='margin-top:0px;cell-spacing:0px' width="100%">
<tr>
<td width="55%" style="border:none; vertical-align: top;">
<div id="userRegisterAjax">
<form id="userajaxregisterform" method="post" action="<?php $this->text('actioncreate') ?>" onsubmit="return UserRegistration.checkForm()">
	<input type='hidden' name='wpNameChoice' value='manual' />
<?php		if( $this->data['message'] && $this->data['ajax'] ) { ?>
	<div class="<?php $this->text('messagetype') ?>box" style="margin:0px">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?>:</h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php } ?>
	<?php $this->html('header'); /* pre-table point for form plugins... */ ?>
	<?php /* LoginLanguageSelector used to be here, moved downward and modified as part of rt#16889 */ ?>
	<table class="wpAjaxRegisterTable" >
		<colgroup>
			<col width="350" />
			<col width="330" />
		</colgroup>
		<tr class="wpAjaxLoginPreLine">
			<td class="wpAjaxLoginInput" id="wpNameTD">
				<label for='wpName2'><?php $this->msg('yourname') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<input type='text'  name="wpName2" id="wpName2"	value="<?php $this->text('name') ?>" size='20' />
			</td>
			<td class="mw-input" rowspan="2" style='vertical-align:top;'>
				<div id="msgToExistingUsers" style="width:240px;">
					<?php $this->msgHtml('fbconnect-msg-for-existing-users'); ?>
				</div>
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine" >
			<td class="wpAjaxLoginInput" id="wpEmailTD">
				<?php if( $this->data['useemail'] ) { ?>
					<label for='wpEmail'><?php $this->msg('signup-mail') ?></label><a id="wpEmailInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
					<input type='text'  name="wpEmail" id="wpEmail" value="<?php $this->text('email') ?>" size='20' />
				<?php } ?>
			</td>
		</tr>

		<tr class="wpAjaxLoginLine">
			<td class="wpAjaxLoginInput" colspan="2">
<?php
	global $wgLanguageCode;

	$aLanguages = wfGetFixedLanguageNames();

	// If we have a language setting from facebook, just hide that in the form, otherwise show
	// the normal dropdown.
	$allLanguageCodes = array_keys($aLanguages);

	// We get a language code from facebook, so we have to see if it is one we can use.
	$uselang = (isset($this->data['uselang'])?$this->data['uselang']:"");
	if($uselang && (in_array($uselang, $allLanguageCodes))){
		print "<input type='hidden' name='uselang' id='uselang' value='$uselang'/>\n";	
	} else {
		// If we didn't get an acceptable language from facebook, display the form.
		?><label for='uselang'><?php $this->msg('yourlanguage') ?></label><br/>
		<select style="height:22px;" name="uselang" id="uselang"><?php
		$isSelected = false;

		$aTopLanguages = explode(',', wfMsg('wikia-language-top-list'));
		asort( $aLanguages );
			if (!empty($aTopLanguages) && is_array($aTopLanguages)) :
	?>
									<optgroup label="<?= wfMsg('wikia-language-top', count($aTopLanguages)) ?>">
	<?php foreach ($aTopLanguages as $sLang) :
					$selected = '';
					if ( !$isSelected && ( $wgLanguageCode == $sLang ) ) :
							$isSelected = true;
							$selected = ' selected="selected"';
					endif;
	?>
									<option value="<?=$sLang?>" <?=$selected?>><?=$aLanguages[$sLang]?></option>
	<?php endforeach ?>
									</optgroup>
	<?php endif ?>
									<optgroup label="<?= wfMsg('wikia-language-all') ?>">
	<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
	<?php
			foreach ($aLanguages as $sLang => $sLangName) :
					if ( empty($isSelected) && ( $wgLanguageCode == $sLang ) ) :
							$isSelected = true;
							$selected = ' selected="selected"';
					endif;
	?>
									<option value="<?=$sLang?>" <?=$selected?>><?=$sLangName?></option>
	<?php endforeach ?>
									</optgroup>
	<?php endif ?>
									</select>
<?php
	}
?>
			</td>
		</tr>
		<tr class="wpAjaxLoginLine" >
	<?php
		$tabIndex = 8;
		if ( isset( $this->data['extraInput'] ) && is_array( $this->data['extraInput'] ) ) {
			foreach ( $this->data['extraInput'] as $inputItem ) { ?>
		<tr>
			<td class="mw-input" >
			<?php 
				if ( !empty( $inputItem['msg'] ) && $inputItem['type'] != 'checkbox' ) {
					?><label for="<?php 
					echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
					$this->msgWiki( $inputItem['msg'] ) ?></label><?php } ?>
				<input type="<?php echo htmlspecialchars( $inputItem['type'] ) ?>" name="<?php
				echo htmlspecialchars( $inputItem['name'] ); ?>"
					tabindex="<?php echo $tabIndex++; ?>"
					value="<?php 
				if ( $inputItem['type'] != 'checkbox' ) {
					echo htmlspecialchars( $inputItem['value'] );
				} else {
					echo '1';
				}					
					?>" id="<?php echo htmlspecialchars( $inputItem['name'] ); ?>"
					<?php 
				if ( $inputItem['type'] == 'checkbox' && !empty( $inputItem['value'] ) )
					echo 'checked="checked"'; 
					?> /> <?php 
					if ( $inputItem['type'] == 'checkbox' && !empty( $inputItem['msg'] ) ) {
						?>
				<label for="<?php echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
					$this->msgHtml( $inputItem['msg'] ) ?></label><?php
					}
				?>
			</td>
			<td class="mw-input">
				<div id="termsOfUse" style="width:240px;">
					<?php $this->msgWiki('prefs-help-terms'); ?>
				</div>
			</td>
			<?php
				// The checkboxes for which fields to auto-update on every future facebook connection for this user.
				print $this->html('updateOptions');
			?>
		</tr>
<?php				
				
			}
		}

		// Allow initial setting of Facebook Push Event preferences if those are enabled.
		global $fbEnablePushToFacebook;
		if(!empty($fbEnablePushToFacebook)){
			print "<tr id='fbConnectPushEventBar' class='wpAjaxLoginLine' style=''>\n<td colspan='2'>\n";
			print wfMsg( 'fbconnect-prefsheader' );
			print "<br/><em>\n";
			print wfMsg( 'fbconnect-prefs-can-be-updated', wfMsg('fbconnect-prefstext'));
			print "</em></td></tr>";

			print "<tr id='fbConnectPushEventToggles' class='wpAjaxLoginPreLine' style='display:none;width:100%'><td colspan='2'>\n";
			$FIRST_TIME = true; // this is the first time we're using the form, so default all to checked rather than looking up the user-option.
			print FBConnectPushEvent::createPreferencesToggles($FIRST_TIME);
			print "</td></tr>\n";
		}
?>
	</table>

	<input type="submit" value="Register" style="position: absolute; left: -10000px; width: 0" />
<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>

	<input type="hidden" id="wpCreateaccountXSteer" name="wpCreateaccount" value="true" >

</div>
</td>
</tr>
</table>
<div id="signupWhyProvide"></div>
<div id="signupend" style="clear: both;height: 12px;"><?php $this->msgWiki( 'signupend' ); ?></div>

<div class="modalToolbar neutral">
	<input type="submit" id="wpCreateaccountXSteer" name="wpCreateaccountMail" onclick="return UserRegistration.submitForm_fb();" value="<?php print wfMsg("createaccount") ?>" />	
	<!-- <input type="button" id="wpCreateaccountClose" class="secondary" onclick="AjaxLogin.close(); return false;" value="<?php print wfMsg("Cancel") ?>" /> -->
</div>
</form>


<script type='text/javascript'>
	$(document).ready(function(){
		$.getScript(window.wgScript + '?action=ajax&rs=getRegisterJS&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function(){
			//override submitForm
			if (typeof UserRegistration != 'undefined')
			{
				UserRegistration.submitForm_fb = function() {
					if( typeof UserRegistration.submitForm.statusAjax == 'undefined' ) { // java script static var
						UserRegistration.submitForm.statusAjax = false;
					}

					if(UserRegistration.submitForm.statusAjax)
					{
						return false;
					}
					UserRegistration.submitForm.statusAjax = true;
					if (UserRegistration.checkForm()) {
						$("#userloginErrorBox").hide();
						return true;
						<?php
						// TODO: This may be a useful reference when we convert this page to be an ajax form instead of just a special page.
						/*
						$.ajax({
							   type: "POST",
							   dataType: "json",
							   url: window.wgScriptPath  + "/index.php",
							   data: $("#userajaxregisterform").serialize() + "&action=ajax&rs=createUserLogin",
							   beforeSend: function(){
									$("#userRegisterAjax").find("input,select").attr("disabled",true);
							   },
							   success: function(msg){
									$("#userRegisterAjax").find("input,select").removeAttr("disabled");
									$("#wpCaptchaWord").val("");
									// post data to normal form if age < 13
									if (msg.type === "redirectQuery") {
										WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
										$('#userajaxregisterform').submit();
										return ;
									}

									if( msg.status == "OK" ) {
										$('#AjaxLoginBoxWrapper').closeModal();
										WET.byStr(UserRegistration.WET_str + '/createaccount/success');
										AjaxLogin.doSuccess();
										return ;
									}

									WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
									$('#userloginInnerErrorBox').empty().append(msg.msg);
									$("#userloginErrorBox").show();
									$(".captcha img").attr("src",msg.captchaUrl);
									$("#wpCaptchaId").val(msg.captcha);
									UserRegistration.submitForm.statusAjax = false;

							   }
						});
						*/
						?>
					} else {
						$("#userloginErrorBox").show();
						WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
						UserRegistration.submitForm.statusAjax = false;
					}
				}
				
				UserRegistration.checkUsername(); // since we'll auto-fill it, show the user that it's already okay
			}
		});
		
		// Control show/hide of push-event preferences.
		$('#fbConnectPushEventBar_show').click(function(){
			$('#fbConnectPushEventBar_show').hide();
			$('#fbConnectPushEventToggles').show();
			$('#fbConnectPushEventBar_hide').show();
			return false;
		});
		$('#fbConnectPushEventBar_hide').click(function(){
			$('#fbConnectPushEventBar_hide').hide();
			$('#fbConnectPushEventToggles').hide();
			$('#fbConnectPushEventBar_show').show();
			return false;
		});
	});
</script>
<?php

	} // end execute()
} // end ChooseNameTemplate

