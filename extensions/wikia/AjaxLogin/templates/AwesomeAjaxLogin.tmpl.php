<?php
global $wgAuth, $wgUser, $wgEnableEmail,$wgStylePath, $wgBlankImgUrl;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('login') ?>">
	<div id="userloginErrorBox3" style="display: none;">
		<table>
		<tbody>
		<tr>
			<td style="vertical-align: top;">
					<span style="position: relative; top: -1px;"><img src="<?php print $wgBlankImgUrl ?>" alt="status"/></span>
			</td>
			<td>
				<div id="wpError"></div>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<form action="" method="post" name="userajaxloginform">
		<div style="margin: 10px;" >	
			<label for="wpName1" style="display: block; font-weight: bold;"><?= wfMsg("yourname") ?></label> 
			<table>
			<tr>
				<td id="ajaxlogin_username_cell">
					
				</td>
				<td><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>" style="font-size: 9pt;"><?= wfMsg('nologinlink') ?></a></td>
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
				<label for="wpRemember2Ajax" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
			</div>
		</div>
		<div class="modalToolbar neutral">
			<input type="submit" value="<?= wfMsg("login") ?>" id="wpLoginattemptAjax" />
		</div>
	</form>
</div>
