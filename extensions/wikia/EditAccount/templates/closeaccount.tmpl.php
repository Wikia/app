<!-- s:<?= __FILE__ ?> -->
<?php if (!is_null($status)) { ?>
<fieldset>
	<legend><?= wfMessage( 'editaccount-status' )->escaped() ?></legend>
	<?php echo $status ? Wikia::successmsg($statusMsg) : Wikia::errormsg($statusMsg) ?>
</fieldset>
<?php } ?>
<form method="post" id="editaccountSelectForm" class="EditAccountForm" action="">
	<fieldset>
		<legend><?= wfMessage( 'editaccount-frame-close', $user )->escaped() ?></legend>
		<p><?= wfMessage( 'editaccount-warning-close', $user )->parse() ?></p>
		<div class="input-group">
			<label for="wpReason"><?= wfMessage( 'editaccount-label-reason' )->escaped() ?></label>
			<input id="wpReason" name="wpReason" type="text" />
		</div>
		<div class="input-group">
			<label for="wpClearEmail">
				<input id="wpClearEmail" type="checkbox" name="clearemail" />
				<strong><?= wfMessage( 'editaccount-label-clearemail' )->escaped() ?></strong>
			</label>
		</div>
		<div class="input-group">
			<input type="submit" value="<?= wfMessage( 'editaccount-submit-close' )->escaped() ?>" />
		</div>
		<input type="hidden" name="wpUserName" value="<?= $user_hsc ?>" />
		<input type="hidden" name="wpAction" value="closeaccountconfirm" />
		<input type="hidden" name="wpToken" value="<?= htmlspecialchars( $editToken ); ?>" />
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
