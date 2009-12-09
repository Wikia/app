<?php
global $wgAuth, $wgUser, $wgEnableEmail,$wgStylePath;

$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('comboajaxlogin-createlog') ?>">
	<div style="margin-left:10px;margin-top:10px;margin-bottom:10px;"><?= wfMsg('comboajaxlogin-actionmsg') ?></div>
	<div id="AjaxLoginButtons" title="<?= wfMsg('login') ?>">
			<a id="wpGoLogina" style="padding-right:5px;" class="wikia_button ajaxregister_button" href="" onclick="AjaxLogin.showLogin(this); return false;" >
				<span><?= wfMsg("login") ?></span>
			</a><a id="wpGoRegister" class="wikia_button ajaxregister_button" href="" onclick="AjaxLogin.showRegister(this); return false;" >
				<span><?= wfMsg("nologinlink") ?></span>
			</a>
	</div>
	<div id="AjaxLoginLoginForm" style="display:none" title="<?= wfMsg('login') ?>">
	<div id="userloginErrorBox3" style="display: none;">
		<table>
		<tbody>
		<tr>
			<td style="vertical-align: top;">
					<span style="position: relative; top: -1px;"><img src="<?= $wgStylePath ?>/monobook/blank.gif" class="sprite" alt="status"/></span>
			</td>
			<td>
				<div id="wpError"></div>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
		<form action="" method="post" style="margin: 10px;" name="userajaxloginform">
			<div id="wpError"></div>
			<label for="wpName1" style="display: block; font-weight: bold;"><?= wfMsg("yourname") ?></label> 
			<table>
			<tr style="width:350px" >
				<td id="ajaxlogin_username_cell">
					
				</td>
				<td><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>" style="font-size: 9pt;display:none;"><?= wfMsg('nologinlink') ?></a></td>
			</tr>
			</table>
			<label for="wpPassword1" style="display: block; font-weight: bold; margin-top: 8px"><?= wfMsg("yourpassword") ?></label>
			<table>
			<tr>
				<td id="ajaxlogin_password_cell">
					
				</td>
			<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
				<td><a id="wpMailmypassword" href="#" style="font-size: 9pt;" onclick="AjaxLogin.action='password'; AjaxLogin.form.submit();"><?= wfMsg('mailmypassword') ?></a></td>
				</td>
			<?php } ?>
			</tr>
			</table>
			<div style="margin: 15px 0;">
				<label for="wpRemember1" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
			</div>
			<input type="submit" value="Login" style="position: absolute; left: -10000px; width: 0" />
		</form>
		<div class="modalToolbar neutral">
			<a id="wpLoginattempt" class="wikia_button" href="#" onclick="AjaxLogin.action='login'; AjaxLogin.form.submit(); return false;" ><span><?= wfMsg("login") ?></span></a>
			<a id="wpLoginattempt" class="wikia_button secondary" href="#" onclick="AjaxLogin.close(); return false;" ><span><?= wfMsg("Cancel") ?></span></a>
		</div>
	</div>
	<div id="AjaxLoginRegisterForm" style="display:none" title="<?= wfMsg('login') ?>">
		<?php echo $registerAjax; ?>
	</div>
	<div id="AjaxLoginEndDiv" style="height: 10px;clear: both;" >
	</div>	
</div>
