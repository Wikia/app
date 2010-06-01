<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMsg('editaccount-status') ?></legend>
       	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
</fieldset>
<?php } ?>
<fieldset>
	<legend><?= wfMsg('editaccount-frame-account', $user) ?></legend>
	<?
	print urlencode($user) . "<br/>\n";
	
	print "<span style=\"font-size: normal;\">\n";
	foreach( range(0, mb_strlen($user)-1 ) as $i )
	{
		$letter = mb_substr($user, $i ,1);
		if( ord($letter) > 127 ) {
			print "<code style=\"background-color: red; color: white;\">". $letter ."</code>";
		} else {
			print "<code>". $letter ."</code>";
		}
	}
	print "</span>\n";
	?>
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
