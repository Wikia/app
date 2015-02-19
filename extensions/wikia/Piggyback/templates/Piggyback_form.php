<?php if( !empty( $message ) ): ?>
<div class="<?= $messagetype ?>box">
	<?php if ( $messagetype == 'error' ):  ?>
		<h2><?= wfMessage( 'loginerror' )->escaped() ?></h2>
	<?php endif ?>
	<?= $message ?>
</div>
<div class="visualClear"></div>
<?php endif ?>

<div id="userloginForm">
	<form name="userlogin" method="post" action="<?= $actionlogin ?>">
		<h2><?= wfMessage( 'login' )->escaped() ?></h2>

		<table>
			<tr>
				<td class="mw-label"><label
						for='wpName1'><?= wfMessage( 'piggyback-otherusername' )->escaped() ?></label></td>
				<td class="mw-input">
					<input type='text' class='loginText' name="wpOtherName" id="wpOtherName1"
						   value="<?= htmlspecialchars($otherName) ?>" size='20'/>
				</td>
			</tr>
		</table>
		<div id="piggyback_userloginprompt"><p><?= wfMessage( 'piggyback-loginprompt' )->escaped() ?></p></div>

		<div id="userloginprompt"><?= wfMessage( 'loginprompt' )->escaped() ?></div>
		<table>
			<tr>
				<td class="mw-label"><label for='wpName1'><?= wfMessage( 'yourname' )->escaped() ?></label></td>
				<td class="mw-input">
					<input type='text' class='loginText' name="wpName" id="wpName1" value="<?= htmlspecialchars($name) ?>" size='20'/>
				</td>
			</tr>
			<tr>
				<td class="mw-label"><label for='wpPassword1'><?= wfMessage( 'yourpassword' )->escaped() ?></label></td>
				<td class="mw-input">
					<input type='password' class='loginPassword' name="wpPassword" id="wpPassword1" value="" size='20'/>
				</td>
			</tr>
			<tr>
				<td>
					<?php if ( !empty( $loginToken ) ): ?>
						<input type="hidden" name="wpLoginToken" value="<?= $loginToken; ?>"/>
					<?php elseif ( !empty( $token ) ): ?>
						<input type="hidden" name="wpLoginToken" value="<?= $token; ?>"/>
					<?php endif; ?>
				</td>
				<td class="mw-submit">
					<input type='submit' name="wpLoginattempt" id="wpLoginattempt" value="<?= wfMessage( 'login' )->escaped() ?>"/>
				</td>
			</tr>
		</table>
		<?php if ( !empty( $uselang ) ): ?>
			<input type="hidden" name="uselang" value="<?= htmlspecialchars($uselang); ?>" />
		<?php endif ?>
	</form>
</div>
<div id="loginend" style="clear: both;"><?= wfMessage( 'loginend' )->escaped(); ?></div>
