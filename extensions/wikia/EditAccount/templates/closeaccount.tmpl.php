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
		<div>
			<label for="wpReason"><?= wfMessage( 'editaccount-label-reason' )->escaped() ?></label>
			<input id="wpReason" name="wpReason" type="text" />
		</div>
		<div>
			<input type="submit" value="<?= wfMsg('editaccount-submit-close') ?>" />
		</div>
		<input type="hidden" name="wpUserName" value="<?= $user_hsc ?>" />
		<input type="hidden" name="wpAction" value="closeaccountconfirm" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
