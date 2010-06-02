<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMsg('editaccount-status') ?></legend>
       	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
</fieldset>
<?php } ?>
<fieldset>
	<legend><?= wfMsg('editaccount-frame-account', $user) ?></legend>
	<?= $userEncoded ?><br />
	ID: <?= $userId; ?><br />
	Reg: <?= $userReg ; ?><br />
	<br />
	<table>
	<tr>
		<form method="post" action="">
		<td>
			<label for="wpNewEmail"><?= wfMsg('editaccount-label-email') ?></label>
		</td>
		<td>
			<input type="text" name="wpNewEmail" value="<?= $userEmail ?>" />
			<input type="submit" value="<?= wfMsg('editaccount-submit-email') ?>" />
			<input type="hidden" name="wpAction" value="setemail" />
			<input type="hidden" name="wpUserName" value="<?= $user ?>" />
		</td>
		</form>
	</tr>
	<tr>
		<form method="post" action="">
		<td>
			<label for="wpNewPass"><?= wfMsg('editaccount-label-pass') ?></label>
		</td>
		<td>
			<input type="text" name="wpNewPass" />
			<input type="submit" value="<?= wfMsg('editaccount-submit-pass') ?>" />
			<input type="hidden" name="wpAction" value="setpass" />
			<input type="hidden" name="wpUserName" value="<?= $user ?>" />
		</td>
		</form>
	</tr>
	<tr>
		<form method="post" action="">
		<td>
			<label for="wpNewRealName"><?= wfMsg('editaccount-label-realname') ?></label>
		</td>
		<td>
			<input type="text" name="wpNewRealName" value="<?= $userRealName ?>" />
			<input type="submit" value="<?= wfMsg('editaccount-submit-realname') ?>" />
			<input type="hidden" name="wpAction" value="setrealname" />
			<input type="hidden" name="wpUserName" value="<?= $user ?>" />
		</td>
		</form>
	</tr>
	</table>
</fieldset>
<fieldset>
	<legend><?= wfMsg('editaccount-frame-close', $user) ?></legend>
	<p><?= wfMsg('editaccount-usage-close') ?></p>
	<form method="post" action="">
		<input type="submit" value="<?= wfMsg('editaccount-submit-close') ?>" />
		<input type="hidden" name="wpAction" value="closeaccount" />
		<input type="hidden" name="wpUserName" value="<?= $user ?>" />
	</form>
</fieldset>
<!-- e:<?= __FILE__ ?> -->
