<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMsg('editaccount-status') ?></legend>
	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
</fieldset>
<?php } ?>
<form method="post" id="editaccountSelectForm" action="">
	<fieldset>
		<legend><?= wfMsg('editaccount-frame-close', $user) ?></legend>
		<p><?= wfMsg('editaccount-warning-close', $user) ?></p>
		<input type="submit" value="<?= wfMsg('editaccount-submit-close') ?>" />
		<input type="hidden" name="wpUserName" value="<?= $user ?>" />
		<input type="hidden" name="wpAction" value="closeaccountconfirm" />
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
