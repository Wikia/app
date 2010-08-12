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

class UserAjaxCreateTemplate extends QuickTemplate {
	function addInputItem( $name, $value, $type, $msg ) {
		$this->data['extraInput'][] = array(
			'name' => $name,
			'value' => $value,
			'type' => $type,
			'msg' => $msg,
		);
	}

	function execute() {

		global $wgOut, $wgStylePath, $wgStyleVersion, $wgBlankImgUrl;
		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'. $wgStylePath . '/wikia/common/NewUserRegister.css?' . $wgStyleVersion . "\" />\n");

		if (!array_key_exists('message', $this->data)) {
			$this->data['message'] = "";
		}
		if (!array_key_exists('ajax', $this->data)) {
			$this->data['ajax'] = "";
		}
		
		// This didn't work right off the bat in the new signup forms, so the decision was made to just cut the functionality for now.
		
if(( $this->data['messagetype'] == 'error' ) && (strlen($this->data['message'] ) > 0)): ?>
	<div id="userloginErrorBox3" style="display: block;">
		<div id="wpError">
			<?php echo $this->html('message'); ?>
		</div>
	</div>
<?php endif;?>

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
<form id="userajaxregisterform" method="post" action="<?php $this->text('actioncreate') ?>" onsubmit="return UserRegistration.checkForm()">
<table id="userloginSpecial" width="100%">
<tr>
<td width="55%" style="border:none; vertical-align: top;">

<div id="userRegisterAjax">
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
	<table class="wpAjaxRegisterTable" >
		<colgroup>
			<col width="350" />
			<col width="330" />
		</colgroup>
		<tr>
			<td class="wpAjaxLoginInput" id="wpNameTD">
				<label tabindex="0" for='wpName2'><?php $this->msg('yourname') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
				<input type='text'  name="wpName" id="wpName2"	value="<?php $this->text('name') ?>" size='20' tabindex="1" />
			</td>
			<td class="wpAjaxLoginInput" id="wpPasswordTD">
				<label tabindex="0" for='wpPassword2'><?php $this->msg('yourpassword') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
				<input type='password'  name="wpPassword" id="wpPassword2" value="" size='20' tabindex="3" />
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine" >
			<td class="wpAjaxLoginInput" id="wpEmailTD">
				<?php if( $this->data['useemail'] ) { ?>
					<label tabindex="0" for='wpEmail'><?php $this->msg('signup-mail') ?></label>
					<span><a id="wpEmailInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
					<input type='text'  name="wpEmail" id="wpEmail" value="<?php $this->text('email') ?>" size='20' tabindex="2"  />
				<?php } ?>
			</td>
			<td class="wpAjaxLoginInput" id="wpRetypeTD">
				<label for='wpRetype' tabindex="0"><?php $this->msg('yourpasswordagain') ?></label><span>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
				<input type='password' name="wpRetype" id="wpRetype" tabindex="4" value="" size='20' />
			</td>
		</tr>

		<tr class="wpAjaxLoginLine">
			<td class="wpAjaxLoginInput">
				<label for='uselang'><?php $this->msg('yourlanguage') ?></label><span>&nbsp;</span>
	<select style="height:22px;" name="uselang" id="uselang" tabindex="5" >
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
			<td rowspan="2" class="wpAjaxLoginInput">
				<?php if($this->haveData('captcha')) { ?> 
					<label for='wpUserCaptchaInfo'><?php $this->msg( 'usercaptcha' ) ?></label>
					<span><a id="wpUserCaptchaInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>

					<?php
					   /**
					    * small hack on captcha to add tabindex;
					    * oldcode
					    * $this->html('captcha');
					    */

					   $hackedCaptcha = str_replace('id="wpCaptchaWord"','id="wpCaptchaWord" tabindex="9"',$this->data['captcha']);
					   echo $hackedCaptcha;

					} ?>
			</td>
		</tr>
		<tr class="wpAjaxLoginPreLine">
		<?php if ( !empty( $this->data['coppa'] ) ) { ?>
			<td class="wpAjaxLoginInput wpAjaxLoginData" id="wpBirthDateTD">
				<label for='wpBirthYear'><?php $this->msg('yourbirthdate') ?></label>
				<span><a id="wpBirthDateInfo" href="#"><?php $this->msg( 'signup-moreinfo' ) ?></a>&nbsp;<img alt="status" src="<?php print $wgBlankImgUrl; ?>"/></span>
				<select name="wpBirthYear" id="wpBirthYear" tabindex="6">
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
				<select name="wpBirthMonth" id="wpBirthMonth" tabindex="7">
					<option value="-1"><?php $this->msg('userlogin-choose-month') ?></option>
					<?php
					$setMonth = $this->data['birthmonth'];
					for($month=1; $month<=12; $month++) {
						$selected = $setMonth == $month ? ' selected="selected"' : '';
						echo "\t\t\t\t\t<option value=\"$month\"$selected>$month</option>";
					}
					?>
				</select>
				<select name="wpBirthDay" id="wpBirthDay" tabindex="8">
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
		<?php } ?>
		</tr>
		<tr class="wpAjaxLoginLine" >
	<?php if( $this->data['canremember'] ) { ?>
			<td class="mw-input" style="vertical-align: top;" >
				<input type='checkbox' name="wpRemember" value="1" id="wpRemember" <?php if( $this->data['remember'] ) { ?>checked="checked"<?php } ?> tabindex="10"/>
				<label for="wpRemember" class="plain"><?php $this->msg('remembermypassword') ?></label>
			</td>
	<?php }  ?>

	<?php if( $this->data['useemail'] ) { ?>
		<td class="mw-input" rowspan="3">
			<div id="termsOfUse" style="height:45px;width:240px;">
				<?php $this->msgWiki('prefs-help-terms'); ?>
			</div>
		</td>
	<?php } ?>	
		<tr>
	<?php   
		$tabIndex = 12;
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
		</tr>
<?php				
				
			}
		}
?>	

	</table>
	<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
</div>
</td>
</tr>
</table>
<div id="signupWhyProvide"></div>
<div id="signupend" style="clear: both;height: 12px;"><?php $this->msgWiki( 'signupend' ); ?></div>

<div class="modalToolbar neutral">

	<input name="wpCreateaccount" type="submit" id="wpCreateaccountXSteer" onclick="UserRegistration.submitForm2( 'normal' ); return false;" value="<?php print wfMsg("createaccount") ?>" tabindex ="<?php echo $tabIndex; $tabIndex++; ?>" />
<?php if($this->data['createemail']) { ?>
	<input name="wpCreateaccountMail" type="submit" id="wpCreateaccountX" href="#" onclick="$('#wpCreateaccountXSteer').value = false; $('#wpCreateaccountYSteer').value = true; UserRegistration.submitForm2( 'mail' ); return false;" value="<?php print wfMsg("createaccountmail") ?>"  tabindex ="<?php echo $tabIndex; $tabIndex++; ?>"  />
<?php } ?>
	<input type="submit" name="wpCreateaccountClose" id="wpCreateaccountClose" class="secondary" onclick="AjaxLogin.close(); return false;" value="<?php print wfMsg("Cancel") ?>"  tabindex ="<?php echo $tabIndex; $tabIndex++; ?>"  />
</div>
</form>
<?php

	}

}
?>
