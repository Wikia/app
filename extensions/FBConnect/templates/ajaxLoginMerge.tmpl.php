<div class="ajax-login-slider-panel" id="AjaxLoginConnectMarketing">
	<div class="neutral_ajaxLogin clearfix">
		<?php
			if(Wikia::isOasis()){
				// add FB login button (RT #68846)
				echo wfMsg('comboajaxlogin-log-in-with-facebook-oasis');
				echo '<div class="ajax-login-fb-login">' . $fbButtton . '</div>';

				echo wfMsg("comboajaxlogin-connectmarketing-oasis");
			} else {
				echo wfMsg("comboajaxlogin-connectmarketing");
			}
		?>
		<a href="#" class="back"><? echo wfMsg("comboajaxlogin-connectmarketing-back") ?></a>
		<a href="#" class="forward"><? echo wfMsg("comboajaxlogin-connectmarketing-forward") ?></a>
	</div>
</div>
<div class="ajax-login-slider-panel" id='fbLoginAndConnect' style='display:none'>
	<? echo wfMsg("comboajaxlogin-connectdirections") ?>
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
                <input type="hidden" name="wpLoginToken" value="<?php echo $loginToken; ?>" />
	<input tabindex="304" type="submit" id="wpLoginAndConnectCombo" value="<?php echo wfMsg("fbconnect-connect-next") ?>" onclick="loginAndConnectExistingUser();" />
	</form>
</div>

<div class="ajax-login-slider-panel" id='fbLoginLastStep' style='display:none'>
	<div id="fbNowConnectBox">
		<br/>
		<?php echo wfMsg('fbconnect-logged-in-now-connect'); ?>
		<br/><br/>
		<div><?php echo $fbButtton; ?></div>
	</div>
</div>