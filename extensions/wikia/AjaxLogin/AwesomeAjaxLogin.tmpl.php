<?php
global $wgAuth, $wgUser, $wgEnableEmail;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('login') ?>">
	<form action="" method="post" style="margin:5px; font-size: 0.95em" name="userajaxloginform">
		<div id="wpError"></div>
		<label for="wpName1" style="display: block; font-weight: bold"><?= wfMsg("yourname") ?></label><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>" style="margin: 3px;"><?= wfMsg('nologinlink') ?></a>
		<label for="wpPassword1" style="display: block; font-weight: bold"><?= wfMsg("yourpassword") ?></label>
		<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
		<a id="wpMailmypassword" href="#" onclick="AjaxLogin.action='password'; AjaxLogin.form.submit();" style="margin: 3px;"><?= wfMsg('mailmypassword') ?></a>
		<?php } ?>
		<div style="padding: 3px">
			<label for="wpRemember1" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
		</div>
	</form>
	<hr/>
	<a id="wpLoginattempt" class="wikia_button" href="#" onclick="AjaxLogin.action='login'; AjaxLogin.form.submit();" ><span><?= wfMsg("login") ?></span></a><br/>
</div>
