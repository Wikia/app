<?php
global $wgAuth, $wgUser, $wgEnableEmail;
$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<!--[if lt IE 9]><style type="text/css">#userloginRound {width: 350px !important}</style><![endif]-->
<div id="userloginRound" class="wikiaDialog roundedDiv" style="display:none; background:none; border:none" >
	<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
	<div class="r_boxContent">
		<div class="boxHeader color1"><?= wfMsg('login') ?></div>
		<form action="" method="post" name="userajaxloginform" id="userajaxloginform" style="margin:5px">
			<div id="wpError" style="width: 250px; line-height: 1.4em"></div>
			<label for="wpName1"><?= wfMsg("yourname") ?></label><br/>
			<input type="text" class="loginText" name="wpName" id="wpName1" tabindex="101" size="20" /><br/>
			<label for="wpPassword1"><?= wfMsg("yourpassword") ?></label><br/>
			<input type="password" class="loginPassword" name="wpPassword" id="wpPassword1" tabindex="102" size="20" /><br/>
			<div style="padding-bottom:3px">
				<input type="checkbox" name="wpRemember" tabindex="104" value="1" id="wpRemember1" <?php if( $wgUser->getOption( 'rememberpassword' ) ) { ?>checked="checked"<?php } ?> />
				<label for="wpRemember1"><?= wfMsg('remembermypassword') ?></label><br/>
			</div>
			<input style="margin:0;padding:0 .25em;width:auto;overflow:visible;" type="submit" name="wpLoginattempt" id="wpLoginattempt" tabindex="105" value="<?= wfMsg("login") ?>" />
<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
			<br /><input style="margin:3px 0;padding:0 .25em;width:auto;overflow:visible;font-size:0.9em" type="submit" name="wpMailmypassword" id="wpMailmypassword" tabindex="106" value="<?= wfMsg('mailmypassword') ?>" />
<?php } ?>

		<br/><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>"><?= wfMsg('nologinlink') ?></a>
		</form>

	</div>
	<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
</div>
