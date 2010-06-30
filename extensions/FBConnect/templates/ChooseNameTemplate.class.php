<?php

class ChooseNameTemplate extends QuickTemplate {

	function addInputItem( $name, $value, $type, $msg ) {
		$this->data['extraInput'][] = array(
			'name' => $name,
			'value' => $value,
			'type' => $type,
			'msg' => $msg,
		);
	}

	function execute($modal = false){
		global $wgOut, $wgStylePath, $wgStyleVersion, $wgBlankImgUrl;

		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'. $wgStylePath . '/wikia/common/NewUserRegister.css?' . $wgStyleVersion . "\" />\n");

		if (!array_key_exists('message', $this->data)) {
			$this->data['message'] = "";
		}
		if (!array_key_exists('ajax', $this->data)) {
			$this->data['ajax'] = "";
		}
?>
<div id="fbConnectModal" title="<?php $this->msg('fbconnect-modal-title') ?>" >
<?php if( $this->data['message'] && !$this->data['ajax'] ) { ?>
	<div class="<?php $this->text('messagetype') ?>box">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?></h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
<?php } ?>
<div class="visualClear"></div>
<div id="userloginErrorBox" style="margin-bottom:0;" >
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
<form id="fb_userajaxregisterform" method="post" action="<?php $this->text('actioncreate') ?>" onsubmit="return false;">
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
	<table class="wpAjaxRegisterTable" style="width: 573px;" >
		<colgroup>
			<col width="275" />
			<col width="330" />
		</colgroup>
		<tr class="wpAjaxLoginPreLine" >
			<td class="wpAjaxLoginInput" id="wpFBNameTD">
				<label for='wpName2'><?php $this->msg('yourname') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
				<input type='text'  name="wpName2" id="wpFBName"	value="<?php $this->text('name') ?>" size='20' />
			</td>
			<td rowspan="3" id="wpFBLoginInfo" >
				<div>
					<?php echo wfMsg('fbconnect-msg-for-existing-users', array( "$1" => Title::makeTitle( NS_SPECIAL  , "Signup"  )->getFullUrl(array( "showLoginAndConnect" => "true")) ) ) ?>
				</div>
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine" >
			<td class="wpAjaxLoginInput" id="wplangTD">
			<?php
				global $wgLanguageCode;
			
				$aLanguages = wfGetFixedLanguageNames();
			
				// If we have a language setting from facebook, just hide that in the form, otherwise show
				// the normal dropdown.
				$allLanguageCodes = array_keys($aLanguages);
			
				// We get a language code from facebook, so we have to see if it is one we can use.
				$uselang = false; //(isset($this->data['uselang'])?$this->data['uselang']:"");
				if($uselang && (in_array($uselang, $allLanguageCodes))){
					print "<input type='hidden' name='uselang' id='uselang' value='$uselang'/>\n";	
				} else {
					// If we didn't get an acceptable language from facebook, display the form.
					?><label for='uselang'><?php $this->msg('yourlanguage') ?></label> <br>
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

<?php /*
			<td class="mw-input" rowspan="2" style='vertical-align:top;'>
				<div id="msgToExistingUsers" style="width:240px;">
					<?php
					// The login button should open the ajax login dialog and select the login-and-connect form.
					$jsHref = "openLoginAndConnect();return false;";
					print wfMsg('fbconnect-msg-for-existing-users', $jsHref);
					?>
				</div>
*/ ?>
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine" >
			<td class="wpAjaxLoginInput" id="wpFBEmailTD">
				<?php if( $this->data['useemail'] ) { ?>
					<label for='wpEmail'><?php $this->msg('signup-mail') ?></label><a style='float:left' id="wpEmailInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
					<input type='text'  name="wpEmail" id="wpFBEmail" value="<?php $this->text('email') ?>" size='20' />
				<?php } ?>
		</tr>
		<tr class="wpAjaxLoginPreLine"  >	
			<td class="mw-input" style="padding-top:5px;" colspan="2" > 
				<?php
				$tabIndex = 8;
				if ( isset( $this->data['extraInput'] ) && is_array( $this->data['extraInput'] ) ) {
					foreach ( $this->data['extraInput'] as $inputItem ) { ?>
					<?php 
						if ( !empty( $inputItem['msg'] ) && $inputItem['type'] != 'checkbox' ) {
							?><label for="<?php 
							echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
							$this->msgWiki( $inputItem['msg'] ) ?></label><?php } ?>
						<input style="float:left;" type="<?php echo htmlspecialchars( $inputItem['type'] ) ?>" name="<?php
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
							<span class="fbConnectCblable" ><?php $this->msgHtml( $inputItem['msg'] ) ?></span><?php
							}
						?>
	
					<?php
						// The checkboxes for which fields to auto-update on every future facebook connection for this user.
						print $this->html('updateOptions');
					?>
				<?php				
						
					}
				} ?>
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine" >
			<td class="mw-input"  colspan="2">
				<div id="termsOfUse">
					<?php $this->msgWiki('prefs-help-terms'); ?>
				</div>
			</td>
		</tr>

<?php global $fbEnablePushToFacebook; if(!empty($fbEnablePushToFacebook)){ ?>
		<tr id='fbConnectPushEventBar'>
			<td colspan='2' class="fbConnectPushEventBar" >
				<?php print wfMsg( 'fbconnect-prefsheader' ); ?>
			</td>
		</tr>
		<tr>
			<td colspan='2' id="fbConnectPushEventBarButton" class="fbConnectPushEventBarlink" >
				<a id='fbConnectPushEventBar_show' href='#'><?php echo wfMsg("fbconnect-prefs-show"); ?></a>
				<a id='fbConnectPushEventBar_hide' href='#' style='display:none'><?php echo wfMsg("fbconnect-prefs-hide"); ?></a>
			</td>
		</tr>
		<tr>
			<td class="fbConnectPushEventToggles" style='display:none' >
				<?php echo wfMsg('fbconnect-prefs-post'); ?>
				<br/><br/>
			</td>
		</tr>
			<?php $prefs = FBConnectPushEvent::getPreferencesToggles(true); ?>
			<?php foreach( $prefs as $key => $value ): ?>
			<?php if( ($key % 2) == 0  ):?>
				<tr class='wpAjaxLoginPreLine fbConnectPushEventToggles' style='display:none'>
				<?php endif;?>
					<td <?php if( !empty( $value['fullLine'] )):?> colspan=2 <?php endif;?>>	
						<input <?php if( !empty( $value['checked'] )):?>  checked="checked" <?php endif;?> type='checkbox' value='1' id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>"/> 
						<label for="<?php echo $value['id']; ?>"><?php echo $value['shortText']; ?></label> 
					</td>	
			<?php if( ($key % 2) == 1 || ( (count($prefs) - 1) ==  $key )):?> 
				</tr>
			<?php endif;?>
			
			<?php endforeach; ?> 
		
<?php } ?>
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

</div>

<script type='text/javascript'>
	var prefs_help_mailmesg = "<?php echo str_replace("\n", " ", wfMsg('prefs-help-mailmesg')) ?>";
	var prefs_help_email = "<?php echo str_replace("\n", " ", wfMsg('prefs-help-email')) ?>";
	$(document).ready(function(){
		//override submitForm
		UserRegistration = {};
		$('#wpEmailInfo').bind('click', function(){
			$.showModal(prefs_help_mailmesg, prefs_help_email, 
				{	'id': 'wpEmailInfoModal', 
					'onClose': function() {
						WET.byStr( 'FBconnect/ChooseName/moreinfo/email/close' );
				}});
		 	WET.byStr( 'FBconnect/ChooseName/moreinfo/email/open' ); 
		 });
		UserRegistration.errorMessages = {
				main: '<?= addslashes(wfMsg('userlogin-form-error')) ?>',
				username: '<?= addslashes(wfMsg('noname')) ?>',
				email: '<?= addslashes(wfMsg('userlogin-bad-email')) ?>'
			};
		
		UserRegistration.checkEmail = function() {
			var email = $('#wpFBEmail').val();

			if (email == '' || (!email.match(/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/mi)) ) {
				UserRegistration.toggleError('wpFBEmailTD', 'err');
				return false;
			}
			UserRegistration.toggleError('wpFBEmailTD', 'ok')
			return true;
		}

		
		UserRegistration.checkUsername = function(callback) {
			if(( typeof UserRegistration.checkUsername.statusAjax != 'undefined' ) && UserRegistration.checkUsername.statusAjax)
			{
				return false;
			}
			UserRegistration.checkUsername.statusAjax = true;
			UserRegistration.toggleError('wpFBNameTD', 'progress');
			$.getJSON(wgScript + '?action=ajax&rs=cxValidateUserName', {uName: $('#wpFBName').val()}, function(json){
				UserRegistration.checkUsername.statusAjax = false;
				if (json.result == 'OK') {
					UserRegistration.toggleError('wpFBNameTD', 'ok');
					$("#wpFBNameError").hide();
					callback(true);
				} else {
					UserRegistration.toggleError('wpFBNameTD', 'err');
					WET.byStr( 'FBconnect/ChooseName/exists' );
					$("#wpFBNameError").show();
					callback(false);
				}
			});
		}

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
		
		UserRegistration.submitForm_fb = function() {
			var errors = [];
			var errorsHTML = '';
			WET.byStr( 'FBconnect/ChooseName/Create_account');
			UserRegistration.checkUsername(
			function(username_status) {
				if( username_status && UserRegistration.checkEmail() ) {
					$("#fb_userajaxregisterform").submit();
					return true;
				} else {
					var errors = [];
					var errorsHTML = '';
					if ( !username_status )
						errors.push(UserRegistration.errorMessages['username']);
					if ( !UserRegistration.checkEmail() )
						errors.push(UserRegistration.errorMessages['email']);
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
				WET.byStr( 'FBconnect/ChooseName/createaccount/failure');
			}
			); 
		}
		UserRegistration.checkUsername(function() {});
		$('#wpFBName').change( function() { UserRegistration.checkUsername(function() {}); } );
		$('#wpFBEmail').change( UserRegistration.checkEmail );
		
		// Control show/hide of push-event preferences.
		$('#fbConnectPushEventBar_show').click(function(){
			$('#fbConnectPushEventBar_show').hide();
			$('.fbConnectPushEventToggles').show();
			$('#fbConnectPushEventBar_hide').show();
			WET.byStr( 'FBconnect/ChooseName/show_prefs' );
			return false;
		});
		$('#fbConnectPushEventBar_hide').click(function(){
			$('#fbConnectPushEventBar_hide').hide();
			$('.fbConnectPushEventToggles').hide();
			$('#fbConnectPushEventBar_show').show();
			WET.byStr( 'FBconnect/ChooseName/hide_prefs' );
			return false;
		});
		
		$('#fbGoLogin').click(function(){
			WET.byStr( 'FBconnect/ChooseName/login_first' );
		});

		$('#fbconnect-push-allow-never').click(function(){
			WET.byStr( 'FBconnect/ChooseName/nofeed' );
		});
	});
</script>
<?php

	} // end execute()
} // end ChooseNameTemplate

