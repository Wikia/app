<?php
global $wgAuth, $wgUser, $wgEnableEmail,$wgStylePath,$wgBlankImgUrl;
?>
<div id="AjaxLoginBox" title="<?php print wfMsg('comboajaxlogin-createlog') ?>">
	<?php
		global $wgEnableFacebookConnectExt;
		if(!empty($wgEnableFacebookConnectExt)){
			?><h1><?php print wfMsg("fbconnect-wikia-login-w-facebook") ?></h1>
			<div id="AjaxLoginFBStart">
				<?php print wfMsg("fbconnect-wikia-login-bullets") ?>
				<?php print '<fb:login-button size="large" length="short"'.FBConnect::getPermissionsAttribute().FBConnect::getOnLoginAttribute().'></fb:login-button>'; ?>
			</div>
			<div class="segmented-rule">
				<span>OR</span>
			</div>
			<?php
		}

	if (!$isReadOnly ) { ?>
	
	<div class="wikia-tabs" id="AjaxLoginButtons">
		<ul>
			<li class="accent <?php echo ($showLogin ? 'selected':''); ?> " id="wpGoLogin" onclick="AjaxLogin.showLogin(this); return false;"><a href="<? echo $loginaction ?>" ><?php print wfMsg("login") ?></a></li>
			<li class="accent <?php echo ($showRegister ? 'selected':''); ?> " style="<?php echo ($isReadOnly ? '':'style="display:none"'); ?>"  id="wpGoRegister" onclick="AjaxLogin.showRegister(this); return false;"><a href="<? echo $signupaction ?>"><?php print wfMsg("nologinlink") ?></a></li>
		</ul>
	</div>
    <?php }
	// TODO: Is there some class that could be applied to the actionmsg to give it a standard 'notice' feeling without all of this inlining? ?>
	<div id="comboajaxlogin-actionmsg" style="margin-left:10px;margin-top:10px;margin-bottom:10px;display:none;background-color:#ff8;padding:5px"><?php print wfMsg('comboajaxlogin-actionmsg') ?></div>
    <div id="AjaxLoginLoginForm" <?php echo ($showLogin ? '':'style="display:none"'); ?> title="<?php print wfMsg('login') ?>">
		<?php echo $ajaxLoginComponent; ?>
    </div>
    <div id="AjaxLoginRegisterForm" <?php echo ($showRegister ? '':'style="display:none"'); ?> title="<?php print wfMsg('login') ?>">
        <?php if (!$isReadOnly){ echo $registerAjax; } ?>
    </div>
</div>
