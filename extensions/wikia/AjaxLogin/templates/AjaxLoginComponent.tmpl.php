<?php
	// Template for the login compontent of the ComboAjaxLogin form(s).
	global $wgBlankImgUrl, $wgEnableEmail, $wgAuth, $wgExtensionsPath, $wgStyleVersion, $wgStylePath;

	$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
	$link = $titleObj->getLocalUrl('type=signup');
?>

<link rel="stylesheet" type="text/css" href="<?php print $wgStylePath; ?>/common/wikia_ui/tabs.css?<?php print $wgStyleVersion; ?>" />
<link rel="stylesheet" type="text/css" href="<?php print $wgExtensionsPath; ?>/wikia/AjaxLogin/AjaxLogin.css?<?php print $wgStyleVersion; ?>" />
<div id="userloginErrorBox3" <?php if(strlen($loginerror) > 0): ?> style="display: block;" <?php endif;?>>
	<div id="wpError">
		<?php echo $loginerror; ?>
	</div>
</div>

<div id="AjaxLoginSlider" class="clearfix">
	<div class="ajax-login-slider-panel" id="AjaxLoginSliderNormal" >
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
	            	<input type="checkbox" value="1" tabindex="203" id="wpRemember2Ajax" name="wpRemember" > </input>
	                <label id="labelFor_wpRemember2Ajax" for="wpRemember2Ajax" style="padding-left: 5px"><?php print wfMsg('remembermypassword') ?></label>
	            </div>
	        	<input tabindex="204" type="submit" id="wpLoginattempt" value="<?php print wfMsg("login") ?>" />
	        <input  type="hidden" name="wpLoginToken" value="<?php echo $loginToken; ?>" />
        	</form>

	</div>
<?php
	$addhtml = "";
	wfRunHooks("afterAjaxLoginHTML", array(&$addhtml));
	echo $addhtml;
?>
</div><!--AjaxLoginSlider-->
