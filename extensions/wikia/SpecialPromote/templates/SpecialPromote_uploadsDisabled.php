<? if ($checkAccess): ?>
	<p class="error"><?= wfMessage( 'promote-upload-uploads-disabled' )->text() ?></p>
	<div class="input-group submit-buttons">
		<input type="button" class="wikia-button secondary" id="cancel-button" value="<?= wfMessage( 'ok' )->text(); ?>"/>
	</div>
<? else: ?>
	<?= wfMsg('promote-wrong-rights'); ?>
<? endif; ?>
