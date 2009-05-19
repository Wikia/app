<?php
global $wgAuth, $wgUser, $wgEnableEmail;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLogin" title="<?= wfMsg('login') ?>">
	<form action="" method="post" style="margin:5px">
		<div id="wpError"></div>
		<label for="wpNameAjaxLogin"><?= wfMsg("yourname") ?></label><br/>
		<input type="text" class="loginText" name="wpName" id="wpNameAjaxLogin" tabindex="101" size="20" /><br/>
		<label for="wpPasswordAjaxLogin"><?= wfMsg("yourpassword") ?></label><br/>
		<input type="password" class="loginPassword" name="wpPassword" id="wpPasswordAjaxLogin" tabindex="102" size="20" /><br/>
		<div style="padding-bottom:3px">
			<input type="checkbox" name="wpRemember" tabindex="104" value="1" id="wpRememberAjaxLogin" <?php if( $wgUser->getOption( 'rememberpassword' ) ) { ?>checked="checked"<?php } ?> />
			<label for="wpRememberAjaxLogin"><?= wfMsg('remembermypassword') ?></label><br/>
		</div>
		<input style="margin:0;padding:0 .25em;width:auto;overflow:visible;" type="submit" name="wpLoginattempt" id="wpLoginattempt" tabindex="105" value="<?= wfMsg("login") ?>" onclick="AjaxLogin.action='login'" />
<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
		<br /><input style="margin:3px 0;padding:0 .25em;width:auto;overflow:visible;font-size:0.9em" type="submit" name="wpMailmypassword" id="wpMailmypassword" tabindex="106" value="<?= wfMsg('mailmypassword') ?>" onclick="AjaxLogin.action='password'" />
<?php } ?>
	<br/><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>"><?= wfMsg('nologinlink') ?></a>
	</form>
</div>
<script type="text/javascript">
	$.getScript(wgExtensionsPath + '/wikia/AjaxLogin/AwesomeAjaxLogin.js?' + wgStyleVersion, function() {
		AjaxLogin.init( $('#AjaxLogin form') );
		$('#AjaxLogin').makeModal({width: 275});
		$('#wpNameAjaxLogin').focus();
	});
</script>
