<?php
	// Template for the login compontent of the ComboAjaxLogin form(s).
	global $wgBlankImgUrl, $wgEnableEmail, $wgAuth, $wgExtensionsPath, $wgStyleVersion, $wgStylePath;
	
	$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
	$link = $titleObj->getLocalUrl('type=signup');
?>

<link rel="stylesheet" type="text/css" href="<?=$wgStylePath?>/common/wikia_ui/tabs.css?<?=$wgStyleVersion?>" />
<link rel="stylesheet" type="text/css" href="<?=$wgExtensionsPath?>/wikia/AjaxLogin/AjaxLogin.css?<?=$wgStyleVersion?>" />
<div id="userloginErrorBox3" <?php if(strlen($loginerror) > 0): ?> style="display: block;" <?php endif;?>>
	<div id="wpError">
		<?php echo $loginerror; ?>
	</div>
</div>

<div id="AjaxLoginSlider" class="clearfix">
	<div> 
        	<form action="<? echo $loginaction ?>" method="post" name="userajaxloginform" id="userajaxloginform">
	            <label for="wpName2Ajax" style="display: block; font-weight: bold;"><?php print wfMsg("yourname") ?></label> 
	            <table>
	            <tr style="width:350px" >
	                <td id="ajaxlogin_username_cell">
	                	<input type="text" size="20" tabindex="201" id="wpName2Ajax" name="wpName"> </input> 
	                </td>
	                <td><a id="wpAjaxRegister" href="<?php print htmlspecialchars($link) ?>" style="font-size: 9pt;display:none;"><?php print wfMsg('nologinlink') ?></a></td>
	            </tr>
	            </table>
	            <label for="wpPassword2Ajax" style="display: block; font-weight: bold; margin-top: 8px"><?php print wfMsg("yourpassword") ?></label>
	            <table>
	            <tr>
	                <td id="ajaxlogin_password_cell">
	                    <input type="password" size="20" tabindex="202" id="wpPassword2Ajax" name="wpPassword"> </input>
	                </td>
	            <?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
						<td>
							<a href="#" id="wpMailmypassword" onclick="AjaxLogin.mailNewPassword(this);" ><?php print wfMsg('mailmypassword') ?></a>
						</td>
	            <?php } ?>
	            </tr>
	            </table>
	            <div style="margin: 15px 0;">
	            	<input type="checkbox" value="1" tabindex="204" id="wpRemember2Ajax" name="wpRemember" > </input>
	                <label id="labelFor_wpRemember2Ajax" for="wpRemember2Ajax" style="padding-left: 5px"><?php print wfMsg('remembermypassword') ?></label>
	            </div>
	        	<input type="submit" id="wpLoginattempt" value="<?php print wfMsg("login") ?>" />
	        <input type="hidden" name="wpLoginToken" value="<?php echo $token; ?>" />
        	</form>

	</div><?php
	// FIXME: Try to gracefully de-couple this interweaving w/FBConnect extension.  Just use hooks instead.
	global $wgEnableFacebookConnectExt;
	if(!empty($wgEnableFacebookConnectExt)){
		$style = "";
	} else {
		$style = " style='display:none'";
	}
	?>
	<div id="AjaxLoginConnectMarketing"<?php print $style; ?>>
		<div class="neutral clearfix">
			<? echo wfMsg("comboajaxlogin-connectmarketing") ?>
			<a href="#" class="back"><? echo wfMsg("comboajaxlogin-connectmarketing-back") ?></a>
			<a href="#" class="forward"><? echo wfMsg("comboajaxlogin-connectmarketing-forward") ?></a>
		</div>
	</div>
	<div id='fbLoginAndConnect' style='display:none'>
		<? echo wfMsgExt( 'comboajaxlogin-connectdirections', 'parse' ) ?>

		<form action="" method="post" name="userajaxconnectform" id="userajaxconnectform">
			<label for="wpName3Ajax" style="display: block; font-weight: bold;"><?php print wfMsg("yourname") ?></label> 
			<table>
			<tr style="width:350px" >
				<td id="ajaxlogin_username_cell2">
					
				</td>
			</tr>
			</table>
			<label for="wpPassword3Ajax" style="display: block; font-weight: bold; margin-top: 8px"><?php print wfMsg("yourpassword") ?></label>
			<table>
			<tr>
				<td id="ajaxlogin_password_cell2">
					
				</td>
			</tr>
			</table>
		<input type="hidden" name="wpLoginToken" value="<?php echo $token; ?>"/>
		<input type="submit" id="wpLoginAndConnectCombo" value="<?php print wfMsg("login") ?>" onclick="loginAndConnectExistingUser();" />
		</form>
	</div>
</div><!--AjaxLoginSlider-->
