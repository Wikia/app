<?php
global $wgAuth, $wgUser, $wgEnableEmail;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('login') ?>">
	<form action="" method="post" style="margin:5px; font-size: 0.95em" name="userajaxloginform">
		<div id="wpError"></div>
		<label for="wpName1" style="display: block; font-weight: bold"><?= wfMsg("yourname") ?></label>
		<label for="wpPassword1" style="display: block; font-weight: bold"><?= wfMsg("yourpassword") ?></label>
		<div style="padding: 3px">
			<label for="wpRemember1" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
		</div>
		<input style="margin:0;padding:0 .25em;width:auto;overflow:visible;" type="submit" name="wpLoginattempt" id="wpLoginattempt" tabindex="105" value="<?= wfMsg("login") ?>" onclick="AjaxLogin.action='login'" />
<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
		<br /><input style="margin:3px 0;padding:0 .25em;width:auto;overflow:visible;font-size:0.9em" type="submit" name="wpMailmypassword" id="wpMailmypassword" tabindex="106" value="<?= wfMsg('mailmypassword') ?>" onclick="AjaxLogin.action='password'" />
<?php } ?>
	<br/><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>"><?= wfMsg('nologinlink') ?></a>
	</form>
</div>
