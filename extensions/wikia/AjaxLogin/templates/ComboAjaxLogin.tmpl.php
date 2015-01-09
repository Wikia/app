<?php
global $wgAuth, $wgUser, $wgEnableEmail,$wgStylePath,$wgBlankImgUrl;
$isOasis = F::app()->checkSkin( ['oasis', 'venus'] );
?>
<div id="AjaxLoginBox" title="<?php print wfMsg('comboajaxlogin-createlog') ?>">
	<div class="<?= ( $isOasis ) ? 'modal-tabs' : 'wikia-tabs' ?>" id="AjaxLoginButtons">
		<ul<?= ( $isOasis ) ? ' class="tabs"' : '' ?>>
			<li class="accent <?php echo ($showLogin ? 'selected':''); ?> " id="wpGoLogin" onclick="AjaxLogin.showLogin(this); return false;"><a href="<? echo htmlspecialchars($loginaction); ?>" ><?php print wfMsg("login") ?></a><img class="chevron" src="<?= $wgBlankImgUrl; ?>"></li>
			<?php
				if($wgUser->isAllowed('createaccount')){
					?><li class="accent <?php echo ($showRegister ? 'selected':''); ?> " style="<?php echo ($isReadOnly ? '':'style="display:none"'); ?>"  id="wpGoRegister" onclick="AjaxLogin.showRegister(this); return false;"><a href="<? echo htmlspecialchars($signupaction); ?>"><?php print wfMsg("nologinlink") ?></a><img class="chevron" src="<?= $wgBlankImgUrl; ?>"></li><?php
				}
			?>
		</ul>
	</div>
    <?php
	// TODO: Is there some class that could be applied to the actionmsg to give it a standard 'notice' feeling without all of this inlining? ?>
	<div id="comboajaxlogin-actionmsg" style="margin-left:10px;margin-top:10px;margin-bottom:10px;display:none;background-color:#ff8;padding:5px"><?php print wfMsg('comboajaxlogin-actionmsg') ?></div>
	<div id="comboajaxlogin-actionmsg-protected" style="margin-left:10px;margin-top:10px;margin-bottom:10px;display:none;background-color:#ff8;padding:5px"><?php print wfMsg('comboajaxlogin-actionmsg-protected') ?></div>
    <div id="AjaxLoginLoginForm" <?php echo ($showLogin ? '':'style="display:none"'); ?> title="<?php print wfMsg('login') ?>">
		<?php echo $ajaxLoginComponent; ?>
    </div>
	<?php
		if($wgUser->isAllowed('createaccount')){
			?><div id="AjaxLoginRegisterForm" <?php echo ($showRegister ? '':'style="display:none"'); ?> title="<?php print wfMsg('login') ?>">
				<?php if (!$isReadOnly){
					echo $registerAjax;
				}
				else {
					// RT #85688
				?>
					<div id="AjaxLoginReadOnlyMessage"><?= wfMsg('comboajaxlogin-readonlytext', wfReadOnlyReason()) ?></div>
				<?php
				}
				?>
			</div><?php
		}
	?>
</div>
