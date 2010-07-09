<?php
/**
 * @defgroup Templates Templates
 * @file
 * @ingroup Templates
 */
if( !defined( 'MEDIAWIKI' ) ) die( -1 );
/**
 * HTML template for Special:Userlogin form
 * @ingroup Templates
 */
class UserloginTemplate extends QuickTemplate {
	function execute() {
		if( $this->data['message'] ) {
?>
	<div class="<?php $this->text('messagetype') ?>box">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?></h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php } ?>

<div id="userloginForm">
<form name="userlogin" method="post" action="<?php $this->text('actionlogin') ?>">
	<h2><?php $this->msg('login') ?></h2>
	<p id="userloginlink"><?php $this->html('link') ?></p>
	<?php $this->html('header'); /* pre-table point for form plugins... */ ?>
	<div id="userloginprompt"><?php  $this->msgWiki('loginprompt') ?></div>
	<?php
	global $wgDisplayLanguageSelectorOnLogin;
	if( !empty($wgDisplayLanguageSelectorOnLogin) && @$this->haveData( 'languages' ) ) {
		?><div id="languagelinks"><p><?php $this->html( 'languages' ); ?></p></div>
	<?php } ?>
	<table>
		<tr>
			<td class="mw-label"><label for='wpName1'><?php $this->msg('yourname') ?></label></td>
			<td class="mw-input">
				<input type='text' class='loginText' name="wpName" id="wpName1" value="<?php $this->text('name') ?>" size='20' />
			</td>
		</tr>
		<tr>
			<td class="mw-label"><label for='wpPassword1'><?php $this->msg('yourpassword') ?></label></td>
			<td class="mw-input">
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword1" value="" size='20' />
			</td>
		</tr>
	<?php if( $this->data['usedomain'] ) {
		$doms = "";
		foreach( $this->data['domainnames'] as $dom ) {
			$doms .= "<option>" . htmlspecialchars( $dom ) . "</option>";
		}
	?>
		<tr id="mw-user-domain-section">
			<td class="mw-label"><?php $this->msg( 'yourdomainname' ) ?></td>
			<td class="mw-input">
				<select name="wpDomain" value="<?php $this->text( 'domain' ) ?>"
					<?php echo $doms ?>
				</select>
			</td>
		</tr>
	<?php }
	if( $this->data['canremember'] ) { ?>
		<tr>
			<td></td>
			<td class="mw-input">
				<input type='checkbox' name="wpRemember"
					value="1" id="wpRemember"
					<?php if( $this->data['remember'] ) { ?>checked="checked"<?php } ?>
					/> <label for="wpRemember"><?php $this->msg('remembermypassword') ?></label>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td>
			<?php if( $this->haveData( 'loginToken' ) ): ?> 
				<input type="hidden" name="wpLoginToken" value="<?php $this->text( 'loginToken' ); ?>" />
			<?php elseif($this->haveData( 'token' )): ?>  
				<input type="hidden" name="wpLoginToken" value="<?php $this->text( 'token' ); ?>" />
			<?php endif; ?>
			</td>
			<td class="mw-submit">
				<input type='submit' name="wpLoginattempt" id="wpLoginattempt" value="<?php $this->msg('login') ?>" />&nbsp;<?php if( $this->data['useemail'] && $this->data['canreset']) { ?><input type='submit' name="wpMailmypassword" id="wpMailmypassword" value="<?php $this->msg('mailmypassword') ?>" />
				<?php } ?>
			</td>
		</tr>
	</table>
<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
</form>
</div>
<div id="loginend"  style="clear: both;"><?php $this->msgWiki( 'loginend' ); ?></div>
<?php

	}
}

/**
 * @ingroup Templates
 */
class UsercreateTemplate extends QuickTemplate {
	function addInputItem( $name, $value, $type, $msg ) {
		$this->data['extraInput'][] = array(
			'name' => $name,
			'value' => $value,
			'type' => $type,
			'msg' => $msg,
		);
	}

	function execute() {

		global $wgOut, $wgStylePath, $wgStyleVersion;

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
<?php } ?>
<br/>
<table id="userloginSpecial" width="100%">
<tr>
<td width="55%" style="border-right: 1px solid #AAA; vertical-align: top;">
<div class="loginHeader dark_text_1"><?php $this->msg('create-account-new') ?></div>
<div id="userloginErrorBox">
	<table>
	<tr>
	<td style="vertical-align:top;">
	<span style="position: relative; top: -1px;"><img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
	</td>
	<td>
	<div id="userloginInnerErrorBox">
	</td>
	</table>
	</div>
</div>
<div id="userlogin<?php if ($this->data['ajax']) { ?>Ajax<?php } ?>">
<form name="userlogin2" id="userlogin2" method="post" action="<?php $this->text('actioncreate') ?>" onsubmit="return UserRegistration.checkForm()">
<?php if( @$this->haveData( 'createToken' ) ) { ?><input type="hidden" name="wpCreateaccountToken" value="<?php $this->text( 'createToken' ); ?>" /><?php } ?>
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
	<table width="100%">
		<colgroup>
			<col width="*" />
		</colgroup>
		<tr>
			<td class="mw-input" id="wpNameTD">
				<label for='wpName2'><?php $this->msg('yourname') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<input type='text' class='loginText' name="wpName" id="wpName2"	value="<?php $this->text('name') ?>" size='20' />
			</td>
		</tr>
		<tr>
			<?php if( $this->data['useemail'] ) { ?>
			<td class="mw-input" id="wpEmailTD">
				<label for='wpEmail'><?php $this->msg('signup-mail') ?></label><a id="wpEmailInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<input type='text' class='loginText' name="wpEmail" id="wpEmail" value="<?php $this->text('email') ?>" size='20' />
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td class="mw-input" id="wpPasswordTD">
				<label for='wpPassword2'><?php $this->msg('yourpassword') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword2" value="" size='20' />
			</td>
		</tr>
	<?php if( $this->data['usedomain'] ) {
		$doms = "";
		foreach( $this->data['domainnames'] as $dom ) {
			$doms .= "<option>" . htmlspecialchars( $dom ) . "</option>";
		}
	?>
		<tr>
			<td class="mw-input">
				<?php $this->msg( 'yourdomainname' ) ?><br/>
				<select name="wpDomain" value="<?php $this->text( 'domain' ) ?>">
					<?php echo $doms ?>
				</select>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td class="mw-input" id="wpRetypeTD">
				<label for='wpRetype'><?php $this->msg('yourpasswordagain') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<input type='password' class='loginPassword' name="wpRetype" id="wpRetype" value="" size='20' />
			</td>
		</tr>
		<tr>
			<td class="mw-input">
				<label for='uselang'><?php $this->msg('yourlanguage') ?></label><br/>

                                <select name="uselang" id="uselang">
<?php
	global $wgLanguageCode;

        $isSelected = false;

	$aTopLanguages = explode(',', wfMsg('wikia-language-top-list'));
	$aLanguages = wfGetFixedLanguageNames();
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
			</td>
		</tr>
		<tr>
			<td class="mw-input" id="wpBirthDateTD">
				<label for='wpBirthYear'><?php $this->msg('yourbirthdate') ?></label><a id="wpBirthDateInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span><br/>
				<select name="wpBirthYear" id="wpBirthYear">
					<option value="-1"><?php $this->msg('userlogin-choose-year') ?></option>
					<?php
					$setYear = $this->data['birthyear'];
					$maxYear = date('Y');
					for($year=$maxYear; $year>=1900; $year--) {
						$selected = $setYear == $year ? ' selected="selected"' : '';
						echo "\t\t\t\t\t<option value=\"$year\"$selected>$year</option>";
					}
					?>
				</select>
				<select name="wpBirthMonth" id="wpBirthMonth">
					<option value="-1"><?php $this->msg('userlogin-choose-month') ?></option>
					<?php
					$setMonth = $this->data['birthmonth'];
					for($month=1; $month<=12; $month++) {
						$selected = $setMonth == $month ? ' selected="selected"' : '';
						echo "\t\t\t\t\t<option value=\"$month\"$selected>$month</option>";
					}
					?>
				</select>
				<select name="wpBirthDay" id="wpBirthDay">
					<option value="-1"><?php $this->msg('userlogin-choose-day') ?></option>
					<?php
					$setDay = $this->data['birthday'];
					for($day=1; $day<=31; $day++) {
						$selected = $setDay == $day ? ' selected="selected"' : '';
						echo "\t\t\t\t\t<option value=\"$day\"$selected>$day</option>";
					}
					?>
				</select>
			</td>
		</tr>
	<?php if($this->haveData('captcha')) { ?>
		<tr>
			<td>
				<div id="blurryword"><span class="pseudolabel"><?php $this->msg( 'usercaptcha' ) ?></span><a id="wpUserCaptchaInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span></div>
			</td>

		</tr>
		<tr>
			<td class="mw-input">
				<?php $this->html('captcha'); ?>
			</td>
		</tr>
	<?php }
	if( $this->data['canremember'] ) { ?>
		<tr>
			<td class="mw-input">
				<input type='checkbox' name="wpRemember" value="1" id="wpRemember" <?php if( $this->data['remember'] ) { ?>checked="checked"<?php } ?>/>
				<label for="wpRemember" class="plain"><?php $this->msg('remembermypassword') ?></label>
			</td>
		</tr>
	<?php }
		$tabIndex = 8;
		if ( isset( $this->data['extraInput'] ) && is_array( $this->data['extraInput'] ) ) {
			foreach ( $this->data['extraInput'] as $inputItem ) { ?>
		<tr>
			<td class="mw-input">
			<?php
				if ( !empty( $inputItem['msg'] ) && $inputItem['type'] != 'checkbox' ) {
					?><label for="<?php
					echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
					$this->msgWiki( $inputItem['msg'] ) ?></label><?php
				}
			?>
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
				<label for="<?php echo htmlspecialchars( $inputItem['name'] ); ?>" class="plain"><?php
					$this->msg( $inputItem['msg'] ) ?></label><?php
					}
				?>
			</td>
		</tr>
<?php

			}
		}
?>
		<?php if( $this->data['useemail'] ) { ?>
		<tr>
			<td class="mw-input" >
				<div id="termsOfUse">
					<?php $this->msgWiki('prefs-help-terms'); ?>
				</div>
			</td>
		</tr>
		<?php } ?>

		<tr>
			<td class="mw-submit">
				<div class="modalToolbar">
					<a id="wpCreateaccountX" class="wikia_button" href="#" onclick="UserRegistration.submitForm();" ><span><?= wfMsg("createaccount") ?></span></a>
				<?php if( $this->data['createemail'] ) { ?>
					<a id="wpCreateaccountX" class="wikia_button" href="#" onclick="$('#wpCreateaccountXSteer').value = false; $('#wpCreateaccountYSteer').value = true; UserRegistration.submitForm();" ><span><?= wfMsg("createaccountmail") ?></span></a>
				</div>					
					<input type="hidden" id="wpCreateaccountYSteer" name="wpCreateaccountMail" value="false" >							
				<?php } else { ?>
				</div>
					<input type="hidden" id="wpCreateaccountXSteer" name="wpCreateaccount" value="true" >
				<?php } ?>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		// Ajax Login functionality, added here
		var AjaxLogin2 = {};

		AjaxLogin2.formSubmitHandler = function(ev) {
			WET.byStr('loginActions2/' + AjaxLogin2.action);

			AjaxLogin2.form.log('AjaxLogin2: selected action = '+ AjaxLogin2.action);

			// tracking
			WET.byStr('loginActions2/' + AjaxLogin2.action);

			var controlbox = document.getElementById('ControlBox');
			var newButton = document.createElement('input');

			if(AjaxLogin2.action == 'password') {
				newButton.name = 'wpMailmypassword';
				newButton.value = '1';
				newButton.type = 'hidden';
                                controlbox.appendChild(newButton);
			} else {
				newButton.name = 'wpLoginattempt';
				newButton.value = '1';
				newButton.type = 'hidden';
                                controlbox.appendChild(newButton);
			}
		}

		AjaxLogin2.handleFailure = function () {
			AjaxLogin2.form.log('AjaxLogin2: handleFailure was called');
		}

		AjaxLogin2.displayReason = function (reason) {
			$('#userloginInnerErrorBox2').css('display', '').html(reason);
			$('#userloginErrorBox2').show();			
		}

		AjaxLogin2.blockLoginForm = function (block) {
			AjaxLogin2.form.find('input').attr('disabled', (block ? true : false));
		}

		AjaxLogin2.ajaxRegisterConfirm = function (ev) {
			AjaxLogin2.form.log('AjaxLogin2: ajaxRegisterConfirm()');

			if($('#wpPreview').length && $('#wpLogin').length) {
				// todo ??? check
				if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
					ev.preventDefault();
				}
			}
		}
	<?php $this->executeRegisterJS(); ?>
	$(UserRegistration.init);
	</script>
	<input type="submit" value="Register" style="position: absolute; left: -10000px; width: 0" />
<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
</form>
</div>
</td>
<td width="45%" style="vertical-align: top;">
	<div class="loginHeader rightSideElem dark_text_1"><?php $this->msg('log-in-new') ?></div>
	<form action="<?php $this->text('actionlogin') ?>" method="post" style="margin: 10px;" name="userajaxloginform2" id="userajaxloginform2">
	<div id="userloginErrorBox2">
	<table>
	<tr>
	<td style="vertical-align:top;">
	<span style="position: relative; top: -1px;"><img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
	</td>
	<td>
	<div id="userloginInnerErrorBox2">
	</td>
	</table>
	</div>
	<label for="wpName2Ajax" style="display: block; font-weight: bold;"><?= wfMsg("yourname") ?></label>
	<table>
	<tr>
	<td id="ajaxlogin_username_cell2">
		<input type="text" name="wpName" id="wpName2Ajax" tabindex="101" size="20" class="loginText" />
	</td>
	<td></td>
	</tr>
	</table>
	<div style="display: block; margin-top: 8px">
		<label for="wpPassword2Ajax" style="font-weight: bold;"><?= wfMsg("signup-password") ?></label>
		<a id="wpMailmypassword" href="#" style="font-size: 9pt;" onclick="AjaxLogin2.action='password'; AjaxLogin2.form.submit();"><?= wfMsg('mailmypassword') ?></a>
	</div>
	<table>
	<tr>
	<td id="ajaxlogin_password_cell2">
		<input type="password" name="wpPassword" id="wpPassword2Ajax" tabindex="102" size="20" class="loginPassword" />
	</td>
	<?php 	global $wgEnableEmail, $wgAuth;
		if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
	</td>
	<?php } ?>
	</tr>
	</table>
	<div style="margin: 10px 0;">
	<input type="checkbox" name="wpRemember" id="wpRemember1Ajax" tabindex="104" value="1"  />
	<div id="ControlBox" style="display:none"></div>
	<label for="wpRemember1" class="plain"><?= wfMsg('remembermypassword') ?></label>
	</div>
	<input type="submit" value="Login" style="position: absolute; left: -10000px; width: 0" />
	</form>
        <div class="modalToolbar">
                <a id="wpLoginattempt" class="wikia_button rightSideElem" href="#" onclick="AjaxLogin2.action='login'; AjaxLogin2.form.submit();" ><span><?= wfMsg("login") ?></span></a>
        </div>
	<div id="loginIntro" class="accent rightSideElem">
		<div class="announcementHeader dark_text_2">
			<?php $this->msg( 'registerintro-title' ) ?>
		</div>
		<div class="announcementText">
			<table>
			<tr><td>
			<?php $this->msg( 'registerintro-text' ) ?>
			</td>
			<td>
			<?php global $wgExtensionsPath; ?>
			<img src="<?=$wgExtensionsPath?>/wikia/SpecialSignup/images/signup_login_accent_graphic.png" alt="<?php $this->msg( 'registerintro-title' ) ?>"/>
			</td>
			</tr>
			</table>
		</div>
	</div>
</td>
</tr>
</table>
<div id="signupWhyProvide"></div>
<div id="signupend" style="clear: both;"><?php $this->msgWiki( 'signupend' ); ?></div>
<?php
	}
	function executeRegisterJS()
	{ ?>
		var UserRegistration = {};
		UserRegistration.WET_str = 'signupActions/signup';

		UserRegistration.errorNick = false;	//nick checking can be disabled
		UserRegistration.errorEmail = UserRegistration.errorPass = UserRegistration.errorRetype = UserRegistration.errorDate = true;
		UserRegistration.dateAccessed = 0;
		UserRegistration.errorMessages = {
			main: '<?= addslashes(wfMsg('userlogin-form-error')) ?>',
			username: '<?= addslashes(wfMsg('noname')) ?>',
			email: '<?= addslashes(wfMsg('userlogin-bad-email')) ?>',
			password: '<?= addslashes(wfMsg('userlogin-bad-password')) ?>',
			repassword: '<?= addslashes(wfMsg('userlogin-bad-repassword')) ?>',
			birthday: '<?= addslashes(wfMsg('userlogin-bad-birthday')) ?>'
		};

		UserRegistration.fillErrors = function() {
			var errors = [];
			var errorsHTML = '';
			if (UserRegistration.errorNick)
				errors.push(UserRegistration.errorMessages['username']);
			if (UserRegistration.errorEmail)
				errors.push(UserRegistration.errorMessages['email']);
			if (UserRegistration.errorPass)
				errors.push(UserRegistration.errorMessages['password']);
			if (UserRegistration.errorRetype)
				errors.push(UserRegistration.errorMessages['repassword']);
			if (UserRegistration.errorDate)
				errors.push(UserRegistration.errorMessages['birthday']);

			if (errors.length == 0) {
				//hide
				$('#userloginErrorBox').hide();
			} else if (errors.length == 1) {
				//one
				errorsHTML = errors[0];
				$('#userloginInnerErrorBox').html(errorsHTML);
				$('#userloginErrorBox').show();
			} else {
				//more
				errorsHTML = '<strong>' + UserRegistration.errorMessages['main'] + '</strong><ul>';
				for (err in errors) errorsHTML += '<li>' + errors[err] + '</li>';
				errorsHTML += '</ul>';
				$('#userloginInnerErrorBox').html(errorsHTML);
				$('#userloginErrorBox').show();
			}
		}

		UserRegistration.checkForm = function() {
			UserRegistration.dateAccessed = 2;	//check date on submit
			UserRegistration.checkDate();
			UserRegistration.checkEmail();
			UserRegistration.checkPass();
			UserRegistration.checkRetype();
			UserRegistration.checkUsername(UserRegistration.fillErrors);
			return !(UserRegistration.errorNick || UserRegistration.errorEmail || UserRegistration.errorPass || UserRegistration.errorRetype || UserRegistration.errorDate);
		}

		UserRegistration.checkFormForMail = function() {
			UserRegistration.errorPass = false;
			UserRegistration.toggleError('wpPasswordTD', 'clear');
			UserRegistration.dateAccessed = 2;	//check date on submit
			UserRegistration.checkDate();
			UserRegistration.checkEmail();
			UserRegistration.checkRetype();
			UserRegistration.checkUsername(UserRegistration.fillErrors);
			return !(UserRegistration.errorNick || UserRegistration.errorEmail || UserRegistration.errorRetype || UserRegistration.errorDate);
		}
		
		UserRegistration.update_day_field = function() {
			var year = $('#wpBirthYear').attr('value');
			var month = $('#wpBirthMonth').attr('value');
			var day = $('#wpBirthDay').get(0);
			var day_length = day.length;
			var max_days = (year == -1 || month == -1) ? 31 : new Date(year, month, 0).getDate();
			var day_diff = max_days - (day_length - 1);
			if (day_diff > 0) {
				for(n=0; n<day_diff; n++) {
					var newOption = document.createElement('option');
					newOption.value = newOption.innerHTML = day_length + n;
					day.appendChild(newOption);
				}
			} else if (day_diff < 0) {
				for(n=0; n<-day_diff; n++) {
					day.remove(day.length - 1);
				}
			}
		}

		UserRegistration.init = function() {
			AjaxLogin2.form = $('#userajaxloginform2');
			AjaxLogin2.form.submit(AjaxLogin2.formSubmitHandler).log('AjaxLogin2: init()');

			// initial check, if not empty...
			if ($('#wpEmail').attr('value') != '') {
				UserRegistration.checkEmail();
			}
		}

		UserRegistration.checkUsername = function(success) {
			$.getJSON(wgScript + '?action=ajax&rs=cxValidateUserName', {uName: $('#wpName2').attr('value')}, function(json){
				if (json.result == 'OK') {
					UserRegistration.toggleError('wpNameTD', 'ok');
					UserRegistration.errorNick = false;
				} else {
					UserRegistration.toggleError('wpNameTD', 'err');
					UserRegistration.errorMessages['username'] = json.msg;
					UserRegistration.errorNick = true;
				}

				if (typeof success == 'function') {
					success();
				}
			});
		}

		$('#wpEmailInfo').bind('click', function(){$.showModal(prefs_help_mailmesg, prefs_help_email, {'id': 'wpEmailInfoModal', 'onClose': function() {WET.byStr(UserRegistration.WET_str + '/moreinfo/email/close');} }); WET.byStr(UserRegistration.WET_str + '/moreinfo/email/open'); });
		$('#wpBirthDateInfo').bind('click', function(){$.showModal(prefs_help_birthmesg, prefs_help_birthinfo, {'id': 'wpBirthDateInfoModal', 'onClose': function() {WET.byStr(UserRegistration.WET_str + '/moreinfo/birthdate/close'); } });  WET.byStr(UserRegistration.WET_str + '/moreinfo/birthdate/open'); });
		$('#wpUserCaptchaInfo').bind('click', function(){$.showModal(prefs_help_blurmesg, prefs_help_blurinfo, {'id': 'wpUserCaptchaInfoModal', 'onClose' : function() {WET.byStr(UserRegistration.WET_str + '/moreinfo/captcha/close'); } });  WET.byStr(UserRegistration.WET_str + '/moreinfo/captcha/open'); });
		$('#termsOfUse').bind('click', function(){ WET.byStr(UserRegistration.WET_str + '/termsofuse'); } );

		UserRegistration.toggleError = function(id, show) {
			if (show == 'ok') {
				$('#' + id + ' img:first').removeClass().addClass('sprite ok');
			} else if (show == 'clear') {
				$('#' + id + ' img:first').removeClass();
			} else if (show == 'progress') {
				$('#' + id + ' img:first').removeClass().addClass('sprite progress');
			} else {
				$('#' + id + ' img:first').removeClass().addClass('sprite error');
			}
		}

		UserRegistration.checkEmail = function() {
			var email_elem = document.getElementById('wpEmail') ;
			if (email_elem) {
				var email = email_elem.value;
				if (email == '') {
					UserRegistration.toggleError('wpEmailTD', 'clear');
					UserRegistration.errorEmail = false;
				} else if (email.match(/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/mi)) {
					UserRegistration.toggleError('wpEmailTD', 'ok');
					UserRegistration.errorEmail = false;
				} else {
					UserRegistration.toggleError('wpEmailTD');
					UserRegistration.errorEmail = true;
				}
			} else {
				UserRegistration.errorEmail = false ;
			}
		}
		UserRegistration.checkPass = function() {
			UserRegistration.errorPass = false;
			if(document.getElementById('wpPassword2')){
				var pass = $('#wpPassword2').attr('value');
				var name = $('#wpName2').attr('value');
				if (pass == name) {
					UserRegistration.toggleError('wpPasswordTD');
					UserRegistration.errorPass = true;
				} else {
					var passLen = $('#wpPassword2').attr('value').length;
					if (passLen >= <?php global $wgMinimalPasswordLength; echo $wgMinimalPasswordLength; ?>) {
						UserRegistration.toggleError('wpPasswordTD', 'ok');
						UserRegistration.errorPass = false;
					} else {
						UserRegistration.toggleError('wpPasswordTD');
						UserRegistration.errorPass = true;
					}
				}
			}
		}
		UserRegistration.checkRetype = function() {
			UserRegistration.errorRetype = false;
			if(document.getElementById('wpRetype')){
				var pass = $('#wpPassword2').attr('value');
				var pass2= $('#wpRetype').attr('value');
				if (pass == pass2) {
					if ('' == pass2) {
						UserRegistration.toggleError('wpRetypeTD', 'clear');
						UserRegistration.errorRetype = false;
					} else {
						UserRegistration.toggleError('wpRetypeTD', 'ok');
						UserRegistration.errorRetype = false;
					}

				} else {
					UserRegistration.toggleError('wpRetypeTD');
					UserRegistration.errorRetype = true;
				}
			}
		}
		UserRegistration.checkDate = function() {
			UserRegistration.errorDate = false;
			if(document.getElementById('wpBirthYear')){ // some forms may not have a birthdate field (such as fbconnect)
				UserRegistration.update_day_field();	//add/remove days according to the year & month
				var year = $('#wpBirthYear').attr('value');
				var month = $('#wpBirthMonth').attr('value');
				var day = $('#wpBirthDay').attr('value');
				if (UserRegistration.dateAccessed == 1) {
					UserRegistration.toggleError('wpBirthDateTD', 'clear');
				} else if (UserRegistration.dateAccessed == 2 && year != -1 && month != -1 && day != -1) {
					UserRegistration.toggleError('wpBirthDateTD', 'ok');
					UserRegistration.errorDate = false;
				} else if(UserRegistration.dateAccessed == 2) {
					UserRegistration.toggleError('wpBirthDateTD', 'err');
					UserRegistration.errorDate = true;
				}
			}
		}
		UserRegistration.submitForm = function() {
			if (UserRegistration.checkForm()) {
				$('#userlogin2').submit();
			} else {
				WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
			}
		}

		$('#wpBirthYear').bind('focus', function(){UserRegistration.dateAccessed = 1;});
		$('#wpBirthMonth').bind('focus', function(){UserRegistration.dateAccessed = 1;});
		$('#wpBirthDay').bind('focus', function(){UserRegistration.dateAccessed = 1;});

		$('#wpName2').bind('focus', function(){if (UserRegistration.dateAccessed == 1) {UserRegistration.dateAccessed = 2; UserRegistration.checkDate();}});
		$('#wpName2').bind('blur', function(){
			UserRegistration.toggleError('wpNameTD', 'progress');
			UserRegistration.checkUsername();
			UserRegistration.checkPass(); // need to re-check since the pw can't be equal to the username
		});

		if (document.getElementById('wpEmail')) {
			$('#wpEmail').bind('focus', function(){if (UserRegistration.dateAccessed == 1) {UserRegistration.dateAccessed = 2; UserRegistration.checkDate();}});
			$('#wpEmail').bind('blur', UserRegistration.checkEmail);
		}
		$('#wpPassword2').bind('focus', function(){if (UserRegistration.dateAccessed == 1) {UserRegistration.dateAccessed = 2; UserRegistration.checkDate();}});
		$('#wpRetype').bind('focus', function(){if (UserRegistration.dateAccessed == 1) {UserRegistration.dateAccessed = 2; UserRegistration.checkDate();}});
		$('#wpRealName').bind('focus', function(){if (UserRegistration.dateAccessed == 1) {UserRegistration.dateAccessed = 2; UserRegistration.checkDate();}});

		$('#wpName2').bind('keyup', function(){
			UserRegistration.toggleError('wpNameTD', 'clear');
		});

		$('#wpBirthYear').bind('change', UserRegistration.checkDate);
		$('#wpBirthMonth').bind('change', UserRegistration.checkDate);
		$('#wpBirthDay').bind('change', UserRegistration.checkDate);
		$('#wpPassword2').bind('blur', function(){UserRegistration.checkPass(); UserRegistration.checkRetype();});
		$('#wpRetype').bind('blur', UserRegistration.checkRetype);
	<?php  }
	
}


