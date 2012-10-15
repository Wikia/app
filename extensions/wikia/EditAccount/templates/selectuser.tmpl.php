<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?php echo wfMsg('editaccount-status'); ?></legend>
	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
	<?php if( !empty($statusMsg2) ){ echo Wikia::errormsg($statusMsg2); } ?>
</fieldset>
<?php } ?>
<form method="post" id="editaccountSelectForm" action="">
	<fieldset>
		<legend><?= wfMsg('editaccount-frame-manage') ?></legend>
		<label for="wpUserName"><?php echo wfMsg('editaccount-label-select'); ?></label>
		<input type="text" name="wpUserName" value="<?php echo $user_hsc; ?>" />
		<input type="submit" value="<?php echo wfMsg('editaccount-submit-account'); ?>" />
		<input type="hidden" name="wpAction" value="displayuser" />
	</fieldset>
	<fieldset>
		<legend><?php echo wfMsg('editaccount-frame-usage'); ?></legend>
		<?php echo wfMsg('editaccount-usage'); ?>
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
