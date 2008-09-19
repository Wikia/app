<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMsg('editaccount-status') ?></legend>
	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
</fieldset>
<?php } ?>
<form method="post" id="editaccountSelectForm" action="">
	<fieldset>
		<legend><?= wfMsg('editaccount-frame-manage') ?></legend>
		<label for="wpUserName"><?= wfMsg('editaccount-label-select') ?></label>
		<input type="text" name="wpUserName" />
		<input type="submit" value="<?= wfMsg('editaccount-submit-account') ?>" />
		<input type="hidden" name="wpAction" value="displayuser" />
	</fieldset>
	<fieldset>
		<legend><?= wfMsg('editaccount-frame-usage') ?></legend>
		<?= wfMsg('editaccount-usage') ?>
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
