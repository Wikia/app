<?php
global $wgAuth, $wgUser, $wgEnableEmail;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('login') ?>">
	<form action="" method="post" style="margin: 10px;" name="userajaxloginform">
<div id="wpError"></div>
		<label for="wpName1" style="display: block; font-weight: bold;"><?= wfMsg("yourname") ?></label> <a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>" style="font-size: 9pt;"><?= wfMsg('nologinlink') ?></a>
		<label for="wpPassword1" style="display: block; font-weight: bold; margin-top: 8px"><?= wfMsg("yourpassword") ?></label>
		<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
		<a id="wpMailmypassword" href="#" style="font-size: 9pt;" onclick="AjaxLogin.action='password'; AjaxLogin.form.submit();"><?= wfMsg('mailmypassword') ?></a>
		<?php } ?>
		<div style="margin: 15px 0;">
			<label for="wpRemember1" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
		</div>
	</form>
	<div class="modalToolbar neutral">
		<a id="wpLoginattempt" class="wikia_button" href="#" onclick="AjaxLogin.action='login'; AjaxLogin.form.submit();" ><span><?= wfMsg("login") ?></span></a>
	</div>
</div>
